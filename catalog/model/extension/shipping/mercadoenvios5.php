<?php
require_once "app/mp5lightbox/lib/mercadopago.php";
class ModelExtensionShippingMercadoEnvios5 extends Model {
	
	private $valor_declarado_max = 10000;
	private $cubagem_max = 296207.4163;
	private $cubagem_pac_gf_max = 1000000;
	private $peso_max = 30;
	
	public function formatar($valor){
		if(version_compare(VERSION, '2.2.0.0', '>=')){
			return $this->currency->format($valor,$this->session->data['currency']);
		}else{
			return $this->currency->format($valor);
		}
	}

	public function getQuote($address) {
		
		$this->load->language('extension/shipping/cod');
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('mercadoenvios5_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		
		if (!$this->config->get('mercadoenvios5_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}	

		if (!$this->config->get('mercadoenvios5_status')) {
			$status = false;
		}
		
		$mp = new MP(trim($this->config->get('mp5lightbox_afiliacao')),trim($this->config->get('mp5lightbox_chave')));
		$modo = $this->config->get('mp5lightbox_modo');
		if($modo==0){
		$mp->sandbox_mode(true);	
		}
		
		$method_data = array();
		$produtos = $this->cart->getProducts();
		$total_pedido = $this->cart->getSubTotal();
		$caixas = $this->organizarEmCaixas($produtos);

		if ($status && count($caixas)==1) {
			
			$caixa = $caixas[0];
			
			$minimo = $this->config->get('mercadoenvios5_minimo');
			
			$frete_gratis = 0;
			if($total_pedido>=$minimo){
			$frete_gratis = $this->config->get('mercadoenvios5_frete_gratis');
			}
			
			$lados = ceil($this->raizCubica($caixa['cubagem']));
			$ladosa = ($lados>2)?$lados:2;
			$ladosl = ($lados>11)?$lados:11;
			$ladosc = ($lados>16)?$lados:16;
			
			$para = preg_replace ("/[^0-9]/", '', $address['postcode']);
			$medidas_e_peso = ''.$ladosa.'x'.$ladosl.'x'.$ladosc.','.ceil(($caixa['peso']*1000));
			
			$params = array(
				"dimensions" => $medidas_e_peso,
				"zip_code" => $para,
				"item_price" => (float)number_format($total_pedido, 2, '.', ''),
				"free_method" => (($frete_gratis)?$frete_gratis:null) // optional
			);
			
			$this->log->write("MercadoEnvios Medidas: " . $medidas_e_peso);
			
			try {

			$response = $mp->get("/shipping_options", $params);
			
			if($response['status']==200){
				if(isset($response['response']['options'])){
				foreach($response['response']['options'] AS $k=>$v){

					//prazo
					if(isset($v['speed']['shipping'])){
					$prazo_em_dias = round($v['speed']['shipping']/24);
					}elseif($v['estimated_delivery_time']['shipping']){
					$prazo_em_dias = round($v['estimated_delivery_time']['shipping']/24);	
					}
					
					$frete_texto = $this->formatar($this->tax->calculate($v['cost'], $this->config->get('mercadoenvios5_tax_class_id'), $this->config->get('config_tax')));
					
					$quote_data[$v['shipping_method_id']] = array(
        			'code'         => 'mercadoenvios5.'.$v['shipping_method_id'],
        			'title'        => $v['name'].' em at&eacute; '.$prazo_em_dias.' dias',
        			'cost'         => $v['cost'],
					'tax_class_id' => $this->config->get('mercadoenvios5_tax_class_id'),
					'text'         => (($v['cost']==0)?"<span style='color:#468847'>Gr&aacute;tis.</span>":$frete_texto)
					);
				}
				if(count($quote_data)>=1){
					$method_data = array(
        			'code'       => 'mercadoenvios5',
        			'title'      => $this->config->get('mercadoenvios5_nome'),
        			'quote'      => $quote_data,
					'sort_order' => $this->config->get('mercadoenvios5_sort_order'),
        			'error'      => false
					);
				}
				}
				
			}
			
			} catch(Exception $e) {
				$this->log->write("Erro MercadoEnvios: " . $e->getMessage());
				return false;
			}
				
		}
		
		return $method_data;
	}
	
	private function getDimensaoEmCm($unidade_id, $dimensao){	
		if(is_numeric($dimensao)){
			$length_class_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "length_class mc LEFT JOIN " . DB_PREFIX . "length_class_description mcd ON (mc.length_class_id = mcd.length_class_id) WHERE mcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND mc.length_class_id =  '" . (int)$unidade_id . "'");
			if(isset($length_class_product_query->row['unit'])){
				if($length_class_product_query->row['unit'] == 'mm'){
					return $dimensao / 10;
				}		
			}
		}
		return $dimensao;
	}
	
	private function getPesoEmKg($unidade_id, $peso){
		if(is_numeric($peso)) {
			$weight_class_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class wc LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (wc.weight_class_id = wcd.weight_class_id) WHERE wcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND wc.weight_class_id =  '" . (int)$unidade_id . "'");
			
			if(isset($weight_class_product_query->row['unit'])){
				if($weight_class_product_query->row['unit'] == 'g'){
					return ($peso / 1000);
				}		
			}
		}
		return $peso;
	}	
	
  	private function validar($produto){
		$cubagem = (float)$produto['height'] * (float)$produto['width'] * (float)$produto['length'];
		$peso = (float)$produto['weight'];
		if(!$peso || $peso > $this->peso_max || !$cubagem || $cubagem > $this->cubagem_max){
			$this->log->write(sprintf($this->language->get('error_limites'), $produto['name']));
			
			return false;
		}
  		return true;
  	}

  	private function organizarEmCaixas($produtos) {
  		$caixas = array();
  		foreach ($produtos as $prod) {
			
			//fix erro nova opencart
			$prod['key'] = isset($prod['cart_id'])?$prod['cart_id']:$prod['key'];
			
  			$prod_copy = $prod;
  			$prod_copy['quantity'] = 1;

  			$prod_copy['width']	= $this->getDimensaoEmCm($prod_copy['length_class_id'], $prod_copy['width']);
  			$prod_copy['height']= $this->getDimensaoEmCm($prod_copy['length_class_id'], $prod_copy['height']);
  			$prod_copy['length']= $this->getDimensaoEmCm($prod_copy['length_class_id'], $prod_copy['length']);

  			$prod_copy['weight']= $this->getPesoEmKg($prod_copy['weight_class_id'], $prod_copy['weight'])/$prod['quantity'];
  			
  			$prod_copy['length_class_id'] = $this->config->get('config_length_class_id');
  			$prod_copy['weight_class_id'] = $this->config->get('config_weight_class_id');
  	
  			$cx_num = 0;
  	
  			for ($i = 1; $i <= $prod['quantity']; $i++) {
  				if ($this->validar($prod_copy)){
					isset($caixas[$cx_num]['peso']) ? true : $caixas[$cx_num]['peso'] = 0;
					isset($caixas[$cx_num]['cubagem']) ? true : $caixas[$cx_num]['cubagem'] = 0;					
  	
  					$peso = $caixas[$cx_num]['peso'] + $prod_copy['weight'];
					$cubagem = $caixas[$cx_num]['cubagem'] + ($prod_copy['width'] * $prod_copy['height'] * $prod_copy['length']);
					
 					$peso_dentro_limite = ($peso <= $this->peso_max);
					$cubagem_dentro_limite = ($cubagem <= $this->cubagem_max);

  					if ($peso_dentro_limite && $cubagem_dentro_limite) {
  						if (isset($caixas[$cx_num]['produtos'][$prod_copy['key']])) {
  							$caixas[$cx_num]['produtos'][$prod_copy['key']]['quantity']++;
  						} else {
  							$caixas[$cx_num]['produtos'][$prod_copy['key']] = $prod_copy;
  						}						
						
						$caixas[$cx_num]['peso'] = $peso;
						$caixas[$cx_num]['cubagem'] = $cubagem;
  					} else{
  						$cx_num++;
  						$i--;
  					}
  				} else {
  					$caixas = array();
  					break 2;  // sai dos dois foreach
  				}
  			}
  		}
  		return $caixas;
  	}

  	private function getTotalCaixa($products) {
  		$total = 0;
  		foreach ($products as $product) {
  			$total += $this->currency->format($this->tax->calculate($product['total'], $product['tax_class_id'], $this->config->get('config_tax')), '', '', false);
  		}
  		return $total;
  	}

	private function raizCubica($n) {
		return pow($n, 1/3);
	}	
}
?>