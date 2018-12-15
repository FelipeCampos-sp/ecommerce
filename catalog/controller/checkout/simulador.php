<?php
class ControllerCheckoutSimulador extends Controller {
	public function index() {
		//define cep de entrega
		$this->request->post['qtd'] = isset($this->request->post['qtd'])?$this->request->post['qtd']:1;
		$this->session->data['shipping_address'] = array(
				'firstname'      => '',
				'lastname'       => '',
				'company'        => '',
				'address_1'      => '',
				'address_2'      => '',
				'postcode'       => $this->request->post['cep'],
				'city'           => '',
				'zone_id'        => 0,
				'zone'           => '',
				'zone_code'      => '',
				'country_id'     => $this->config->get('config_country_id'),
				'country'        => '',
				'iso_code_2'     => '',
				'iso_code_3'     => '',
				'address_format' => ''
		);
		
		//fix opencart novas
		if(version_compare(VERSION, '2.1.0.0', '>=')){
		$produtos = $this->cart->getProducts();
		if($this->cart->hasProducts()){
			$this->session->data['cart_salva'] = $produtos;
			$this->cart->clear();
		}
		}else{
		if(isset($this->session->data['cart'])){
			$this->session->data['cart_salva'] = $this->session->data['cart'];	
			unset($this->session->data['cart']);
		}
		}
		
		//new session simulator product
		$this->cart->add($this->request->post['id'], $this->request->post['qtd'], array(), 0);
		//calcula o frete
		$quote_data = array();
		$this->load->model('extension/extension');
		$results = $this->model_extension_extension->getExtensions('shipping');
		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('extension/shipping/' . $result['code']);
				$quote = $this->{'model_extension_shipping_' . $result['code']}->getQuote($this->session->data['shipping_address']);
				if ($quote) {
					if(count($quote['quote'])>0){
					$quote_data[$result['code']] = array(
						'title'      => $quote['title'],
						'quote'      => $quote['quote'],
						'sort_order' => $quote['sort_order'],
						'error'      => $quote['error']
					);
					}
				}
			}
		}
		$sort_order = array();
		foreach ($quote_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}
		array_multisort($sort_order, SORT_ASC, $quote_data);
		if(count($quote_data)>0){
			$resultados['erro'] =false;
			$resultados['cotas'] = $quote_data;
		}else{
			$resultados['erro'] =true;
			$resultados['cotas'] = 'Nenhum meio de entrega disponível!';
		}
			
		//limpa a nova session
		if(version_compare(VERSION, '2.1.0.0', '>=')){
			$this->cart->clear();
		}else{
		if(isset($this->session->data['cart'])){
			unset($this->session->data['cart']);
		}
		}
		
		//recria a session antiga
		if(version_compare(VERSION, '2.1.0.0', '>=')){
		if(isset($this->session->data['cart_salva'])){
			foreach ($this->session->data['cart_salva'] as $produto) {
				$opcoes = array();
				foreach($produto['option'] AS $k=>$v){
					$opcoes[$v['product_option_id']] = $v['product_option_value_id'];
				}
				$this->cart->add($produto['product_id'], $produto['quantity'], $opcoes, 0);
			}
			unset($this->session->data['cart_salva']);
		}
		}else{
		if(isset($this->session->data['cart_salva'])){
			$this->session->data['cart'] = $this->session->data['cart_salva'];
			unset($this->session->data['cart_salva']);
		}
		}
		
		//retorna o json
		if($resultados['erro']==false){
			$html = '<br><table class="table-simulador table-bordered-simulador">';
			foreach($resultados['cotas'] AS $k=>$v){
				$html .= '<tr><td colspan="2" style="text-align:left;"><b>'.$v['title'].'</b></td></tr>';
				foreach($v['quote'] AS $x=>$z){
					$html .= '<tr><td>'.$z['title'].'</td><td width="80">'.$z['text'].'</td></tr>';
				}
			}
			$html .= '</table>';
			echo $html;
		}else{
			echo '<br>'.$resultados['cotas'];
		}
	}
}