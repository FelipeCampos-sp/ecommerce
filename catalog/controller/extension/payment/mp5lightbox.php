<?php
require_once "app/mp5lightbox/lib/mercadopago.php";
class ControllerExtensionPaymentMp5Lightbox extends Controller {
	
	private $valor_declarado_max = 10000;
	private $cubagem_max = 296207.4163;
	private $cubagem_pac_gf_max = 1000000;
	private $peso_max = 30;
	
	public function index() {
		$this->load->model('checkout/order');	
		$data['null'] = null;
		$modo = $this->config->get('mp5lightbox_modo');
		$dados_mp = $this->processar();
		
		if($dados_mp==false){
			if(isset($this->session->data['erro_mp'])){
			echo '<div class="alert alert-danger danger" role="alert"><i class="fa fa-exclamation-circle"></i> '.$this->session->data['erro_mp'].'</span>';	
			}else{
			echo '<div class="alert alert-danger danger" role="alert"><i class="fa fa-exclamation-circle"></i> Ops, problema ao conectar ao MercadoPago! Verifique suas credenciais.</span>';	
			}
			exit;
		}
		
		$data['url_mp'] = ($modo==0)?$dados_mp['sandbox_init_point']:$dados_mp['init_point'];
		
		if(version_compare(VERSION, '2.2.0.0', '>=')){
		return ($this->load->view('extension/payment/mp5lightbox.tpl', $data));
		}else{
		return ($this->load->view('default/template/extension/payment/mp5lightbox.tpl', $data));
		}
	}

	private function processar(){	
		$this->load->model('checkout/order');
		$order = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$mp = new MP(trim($this->config->get('mp5lightbox_afiliacao')),trim($this->config->get('mp5lightbox_chave')));
		$modo = $this->config->get('mp5lightbox_modo');
		if($modo==0){
		$mp->sandbox_mode(true);	
		}
		$telefone = preg_replace('/\D/', '',$order['telephone']);
		if(strlen($telefone)==13){
		$telefone = substr($telefone,-10);
		}elseif(strlen($telefone)==12){
		$telefone = substr($telefone,-10);
		}elseif(strlen($telefone)==11 || strlen($telefone)==10){
		$telefone = $telefone;
		}
		$ddd = substr($telefone,0,2);
		$tel = (strlen($telefone)==11)?substr($telefone,-9):substr($telefone,-8);
		
		//dados customer fiscal
		$fiscal = $this->config->get('mp5lightbox_cpf');
		$numero_fiscal = (isset($order['custom_field'][$fiscal]))?preg_replace('/\D/', '', $order['custom_field'][$fiscal]):'';
		
		//dados customer numero
		$numero = $this->config->get('mp5lightbox_numero');
		$numero_cobranca = (isset($order['payment_custom_field'][$numero]))?$order['payment_custom_field'][$numero]:'*';
		$numero_entrega = (isset($order['shipping_custom_field'][$numero]))?$order['shipping_custom_field'][$numero]:'*';
		
		//se o mercadoenvio esta ativado
		$total_pedido = $this->cart->getSubTotal();
		$total_frete = 0;
		$frete_gratis = $tem_mercado_envio = $tem_frete_gratis = false;
		$frete_modo = 'custom';
		$medidas = '';
		$mercado_envio_status = $this->config->get('mercadoenvios5_status');
		$mercado_servico = $this->config->get('mercadoenvios5_frete_gratis');
		$mercado_minimo = $this->config->get('mercadoenvios5_minimo');
		
		if ($this->cart->hasShipping() && isset($this->session->data['shipping_method'])) {
		$metodo = explode('.',$this->session->data['shipping_method']['code']);
		if($metodo[0]=='mercadoenvios5'){
		if($mercado_envio_status==1){
		$produtos = $this->cart->getProducts();
		$caixas = $this->organizarEmCaixas($produtos);
		if (count($caixas)==1) {
			$tem_mercado_envio = true;
			$total_frete = $this->getFrete();
			$frete_modo = 'me2';
			$caixa = $caixas[0];
			
			$lados = ceil($this->raizCubica($caixa['cubagem']));
			$ladosa = ($lados>2)?$lados:2;
			$ladosl = ($lados>11)?$lados:11;
			$ladosc = ($lados>16)?$lados:16;
			
			$peso = ceil(($caixa['peso']*1000));
			$medidas = $ladosa.'x'.$ladosl.'x'.$ladosc.','.$peso;
			
			if($mercado_servico>0 && $total_pedido>=$mercado_minimo){
			$tem_frete_gratis = true;
			$frete_gratis = array(array("id" =>(int)$mercado_servico));
			}
		}
		}		
		}
		}
		
		$preference_data = array(
			"items" => array(
				array(
					"id" => $order['order_id'],
					"title" => "Pedido #".$order['order_id']." em ".$this->config->get('config_name')."",
					"currency_id" => $order['currency_code'],
					"quantity" => 1,
					"unit_price" => (float)number_format($order['total']-$total_frete, 2, '.', '')
				)
			),
			"payer" => array(
				"name" => $order['payment_firstname'],
				"surname" => $order['payment_lastname'],
				"email" => $order['email'],
				"date_created" => $this->data_cadastro_cliente($order['customer_id']),
				"phone" => array(
					"area_code" => $ddd,
					"number" => $tel
				),
				"identification" => array(
					"type" => ((strlen($numero_fiscal)==14)?'CNPJ':'CPF'),
					"number" => $numero_fiscal
				),
				"address" => array(
					"street_name" => $order['payment_address_1'],
					"street_number" => $numero_cobranca,
					"zip_code" => preg_replace('/\D/', '', $order['payment_postcode'])
				)
			),
			"back_urls" => array(
				"success" => $this->url->link('extension/payment/mp5lightbox/cupom','','SSL'),
				"failure" => $this->url->link('checkout/checkout','','SSL'),
				"pending" => $this->url->link('extension/payment/mp5lightbox/cupom','','SSL')
			),
			"auto_return" => "approved",
			"notification_url" => $this->url->link('extension/payment/mp5lightbox/ipn','','SSL'),
			"external_reference" => $order['order_id'],
			"expires" => false,
			"expiration_date_from" => null,
			"expiration_date_to" => null
		);
		
		//ativa a opcao de mercadoenvio
		if ($this->cart->hasShipping() && isset($this->session->data['shipping_method'])) {
		$metodo = explode('.',$this->session->data['shipping_method']['code']);
		if($tem_frete_gratis && $tem_mercado_envio && $metodo[0]=='mercadoenvios5'){
		$men["shipments"] = array(
				"receiver_address" => array(
					"zip_code" => preg_replace('/\D/', '', $order['shipping_postcode'])
				),
				"default_shipping_method"=> (int)$metodo[1],
				"mode"=> $frete_modo,
				"dimensions"=> $medidas,
				"local_pickup" => false,
				"free_methods" => $frete_gratis
		);
		$preference_data = array_merge($preference_data,$men);
		}elseif($tem_mercado_envio && $metodo[0]=='mercadoenvios5'){
		$men["shipments"] = array(
				"receiver_address" => array(
					"zip_code" => preg_replace('/\D/', '', $order['shipping_postcode'])
				),
				"default_shipping_method"=> (int)$metodo[1],
				"mode"=> $frete_modo,
				"dimensions"=> $medidas,
				"local_pickup" => false
		);	
		$preference_data = array_merge($preference_data,$men);
		}
		}
		
		try {
		$preference = $mp->create_preference($preference_data);	
		return $preference['response'];
		} catch(Exception $e) {
		$this->session->data['erro_mp'] = $e->getMessage();
		$this->log->write("Erro MercadoPago #".$this->session->data['order_id'].": " . $e->getMessage());
		return false;
		}
	}
	
	public function getFrete(){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$this->session->data['order_id'] . "' AND code = 'shipping'");
		if(!isset($query->row['value'])){
		return 0;	
		}
		return $query->row['value'];
	}
	
	public function status_mp($status){
		$dados = array('id'=>$this->config->get('mp5lightbox_order_status_id'),'nome'=>'Aguardando pagamento');
		switch($status){
			case 'approved':
			$dados = array('id'=>$this->config->get('mp5lightbox_aprovado'),'nome'=>'Aprovado');
			break;
			case 'pending':
			case 'in_process':
			$dados = array('id'=>$this->config->get('mp5lightbox_pendente'),'nome'=>'Pendente');
			break;
			case 'rejected':
			case 'cancelled':
			$dados = array('id'=>$this->config->get('mp5lightbox_cancelado'),'nome'=>'Cancelado');
			break;
			case 'refunded':
			$dados = array('id'=>$this->config->get('mp5lightbox_devolvido'),'nome'=>'Devolvido');
			break;
			case 'in_mediation':
			$dados = array('id'=>$this->config->get('mp5lightbox_disputa'),'nome'=>'Disputa');
			break;
			case 'charged_back':
			$dados = array('id'=>$this->config->get('mp5lightbox_chargeback'),'nome'=>'Chargeback');
			break;
		}
		return $dados;
	}
		
	public function data_cadastro_cliente($id){
		$query = $this->db->query("SELECT date_added FROM `".DB_PREFIX."customer` WHERE `customer_id` = '".$id."' LIMIT 1;");
		if(isset($query->row['date_added'])){
			return date('Y-m-d',strtotime($query->row['date_added']));
		}else{
			return date('Y-m-d');
		}
	}
	
	public function cupom(){
		$this->load->model('checkout/order');		
		$mp = new MP(trim($this->config->get('mp5lightbox_afiliacao')),trim($this->config->get('mp5lightbox_chave')));
		$modo = $this->config->get('mp5lightbox_modo');
		if($modo==0){
		$mp->sandbox_mode(true);	
		}
		$data['pagamento'] = $row = $mp->colection_payment($_GET['collection_id']);
		$data['status'] = $this->status_mp($row['response']['status']);
		
		if(isset($this->session->data['order_id'])){
			$order = $this->model_checkout_order->getOrder($row['response']['external_reference']);
			$pedido_status_atual = $order['order_status_id'];
			if($data['status']['id']!=$pedido_status_atual){
			$this->model_checkout_order->addOrderHistory($order['order_id'],$data['status']['id'],$row['response']['id'].' - '.$row['response']['payment_method_id'],true);	
			}
		}
		
		$this->document->setTitle('Cupom MercadoPago');
		$this->document->setDescription('');
		$this->document->setKeywords('');
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		$data['iframe'] = $this->url->link('checkout/success','','SSL');
		
		if(version_compare(VERSION, '2.2.0.0', '>=')){
		$this->template = 'extension/payment/mp5lightbox_cupom.tpl';
		}else{
		$this->template = 'default/template/extension/payment/mp5lightbox_cupom.tpl';	
		}
		$this->response->setOutput($this->load->view($this->template, $data));
		
	}
	
	public function ipn(){
		$this->load->model('checkout/order');
		$mp = new MP(trim($this->config->get('mp5lightbox_afiliacao')),trim($this->config->get('mp5lightbox_chave')));
		$modo = $this->config->get('mp5lightbox_modo');
		if($modo==0){
		$mp->sandbox_mode(true);	
		}
		if (isset($_REQUEST['topic']) && $_REQUEST['topic'] == 'payment' && isset($_REQUEST['id'])){
			$payment_info = $mp->get('/v1/payments/'.$_REQUEST['id']);
			if ($payment_info["status"] == 200) {
				$pedido_id = $payment_info["response"]['external_reference'];
				$status = $this->status_mp($payment_info["response"]['status']);
				$order = $this->model_checkout_order->getOrder($pedido_id);
				$pedido_status_atual = $order['order_status_id'];
				if($status['id']!=$pedido_status_atual){
				$this->model_checkout_order->addOrderHistory($order['order_id'], $status['id'],'',true);	
				}
			}
		}
		echo 'OK';
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