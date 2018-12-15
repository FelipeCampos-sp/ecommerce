<?php
include(dirname(__FILE__)."/../../../../r2s/pagseguro/serviceREST.php");
class ControllerExtensionPaymentPagSeguroR2S extends Controller {
	
	public function index() {
		$this->load->model('checkout/order');
		$this->language->load('extension/payment/cod');
		$data['button_confirm'] = $this->language->get('button_confirm');
		//opcoes
		$data['modo'] = ($this->config->get('pagseguror2s_modo'))?'':'sandbox.';
		$data['gateway'] = $this->url->link('extension/payment/pagseguror2s/gateway','','SSL');
		//cliente
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$data['titular'] = strtoupper($order_info['firstname']).' '.strtoupper($order_info['lastname']);
		$data['sessao_ps'] = $this->sessaops();
		$data['total'] = number_format($order_info['total'], 2, '.', '');
		$ddd = $tel = '';
		$tell_full = substr(preg_replace('/\D/', '', $order_info['telephone']),-11);
		if(strlen($tell_full)==10){
		$ddd = substr($tell_full,0,2);
		$tel = substr($tell_full,-8);
		}else if(strlen($tell_full)==11){
		$ddd = substr($tell_full,0,2);
		$tel = substr($tell_full,-9);
		}
		$data['ddd'] = '('.$ddd.')';
		$data['tel'] = ''.$tel.'';
		$fiscal = '';
		$custom_fiscal = $this->config->get('pagseguror2s_fiscal');
		if(isset($order_info['custom_field'][$custom_fiscal])){
		$fiscal = preg_replace('/\D/', '', $order_info['custom_field'][$custom_fiscal]);	
		}
		$data['cpf'] = $fiscal;
		$data['sem_juros'] = $this->config->get('pagseguror2s_sem_juros');
		$data['pedido_full'] = $order_info;
		if(version_compare(VERSION, '2.1.9.9', '<=')){
			return $this->load->view('default/template/extension/payment/pagseguror2s.tpl', $data);
		}else{
			return $this->load->view('extension/payment/pagseguror2s', $data);
		}
	}
	
	public function tratar_mensagem_erro($erro=''){
		$erros = dirname(__FILE__)."/../../../../r2s/pagseguro/erros.csv";
		$array_erros = $this->csv_to_array($erros);
		if(is_array($array_erros)){
			foreach($array_erros AS $k=>$v){
				if($v['erro']==$erro){
					return ' - '.utf8_encode($v['traducao']);
					break;	
				}
			}
		}
		return $erro;
	}
	
	public function csv_to_array($filename='', $delimiter=',') {
		if(!file_exists($filename) || !is_readable($filename))
			return FALSE;
		$header = NULL;
		$data = array();
		if (($handle = fopen($filename, 'r')) !== FALSE){
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
			{
				if(!$header)
					$header = $row;
				else
					$data[] = array_combine($header, $row);
			}
			fclose($handle);
		}
		return $data;
	}
	
	public function tratar_erro($erro){
		$this->load->model('checkout/order');
		$this->document->setTitle('Erro PagSeguro');
		$this->document->setDescription('');
		$this->document->setKeywords('');
		$data['erro']=$erro;
		$data['continue'] = $this->url->link('checkout/checkout','','SSL');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		if(version_compare(VERSION, '2.1.9.9', '<=')){
			$this->response->setOutput($this->load->view('default/template/extension/payment/pagseguror2s_erro.tpl', $data));
		}else{
			$this->response->setOutput($this->load->view('extension/payment/pagseguror2s_erro', $data));
		}
	}
	
	public function gateway(){
		$this->load->model('checkout/order');
		$email_pagseguro = trim($this->config->get('pagseguror2s_email'));
		$token_pagseguro = trim($this->config->get('pagseguror2s_token'));
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		//tratamento do telefone
		$ddd = $tel = '';
		$tell_full = substr(preg_replace('/\D/', '', $_POST['telefone_cartao']),-11);
		if(strlen($tell_full)==10){
		$ddd = substr($tell_full,0,2);
		$tel = substr($tell_full,-8);
		}else if(strlen($tell_full)==11){
		$ddd = substr($tell_full,0,2);
		$tel = substr($tell_full,-9);
		}
		
		//complemento
		$com_id = $this->config->get('pagseguror2s_complemento');
		$complemento_cob = (isset($order_info['payment_custom_field'][$com_id]))?$order_info['payment_custom_field'][$com_id]:'';
		$complemento_ent = (isset($order_info['shipping_custom_field'][$com_id]))?$order_info['shipping_custom_field'][$com_id]:'';
		
		//pega o fiscal
		$fiscal = preg_replace('/\D/', '', $_POST['cpf_cartao']);	
		//parcela do pedido
		if(isset($_POST['parcela_cartao'])){
		$parcelas = explode('|',$_POST['parcela_cartao']);
		}
		//xml pagseguro
		$xmlps['email'] = trim($email_pagseguro);
		$xmlps['token'] = trim($token_pagseguro);
		$xmlps['currency'] = 'BRL';
		$xmlps['paymentMode'] = 'default';
		$xmlps['paymentMethod'] = 'creditCard';
		$xmlps['receiverEmail'] = trim($email_pagseguro);
		$xmlps['reference'] = $order_info['order_id'];
		$xmlps['senderName'] = trim(preg_replace('!\s+!',' ',$order_info['firstname'].' '.$order_info['lastname']));
		$xmlps['senderEmail'] = $order_info['email'];
		$xmlps['senderAreaCode'] = $ddd;
		$xmlps['senderPhone'] = $tel;
		if(strlen($fiscal)==11){
		$xmlps['senderCPF'] = $fiscal;	
		}elseif(strlen($fiscal)==14){
		$xmlps['senderCNPJ'] = $fiscal;	
		}
		$xmlps['notificationURL'] = $this->url->link('extension/payment/pagseguror2s/ipn','','SSL');
		$xmlps['redirectURL'] = $this->url->link('account/order','','SSL');
		
		//produtos
		$i=1;
		$total_produtos = 0;
		foreach($this->cart->getProducts() AS $produto){
		$total_produtos+=$produto['price']*$produto['quantity'];
		$xmlps['itemId'.$i] = $produto['product_id'];
		$xmlps['itemDescription'.$i] = substr(utf8_decode($produto['name']), 0, 99);
		$xmlps['itemAmount'.$i] = number_format($produto['price'], 2, '.', '');
		$xmlps['itemQuantity'.$i] = $produto['quantity'];
		$i++;
		}
		
		//impostos e taxas
		$impostos = $this->getTaxas();
		if($impostos>0){
			$xmlps['itemId'.$i] = $order_info['order_id'];
			$xmlps['itemDescription'.$i] = 'Impostos e Taxas';
			$xmlps['itemAmount'.$i] = number_format($impostos, 2, '.', '');
			$xmlps['itemQuantity'.$i] = 1;
			$i++;
		}
		
		//extras e frete
		$xmlps['shippingType'] = '3';
		$xmlps['shippingCost'] = number_format($this->getFrete(), 2, '.', '');
		$xmlps['extraAmount'] = number_format($this->getDescontos(), 2, '.', '');
		
		//endereco de entrega se nao houver entrega
		if($order_info['shipping_zone_id']==0){
		$numero = $this->config->get('pagseguror2s_numero');
		$numero_logradouro = (isset($order_info['payment_custom_field'][$numero]))?$order_info['payment_custom_field'][$numero]:preg_replace('/\D/', '', $order_info['payment_address_1']);
		$xmlps['shippingAddressStreet'] = utf8_decode(trim(str_replace(',','',preg_replace('/\d+/','',$order_info['payment_address_1']))));
		$xmlps['shippingAddressNumber'] = !empty($numero_logradouro)?$numero_logradouro:'';
		$xmlps['shippingAddressComplement'] = $complemento_cob;
		$xmlps['shippingAddressDistrict'] = utf8_decode((empty($order_info['payment_address_2'])?'Bairro':$order_info['payment_address_2']));
		$xmlps['shippingAddressPostalCode'] = preg_replace('/\D/', '', $order_info['payment_postcode']);
		$xmlps['shippingAddressCity'] = utf8_decode($order_info['payment_city']);
		$xmlps['shippingAddressState'] = $order_info['payment_zone_code'];	
		}else{
		//se houver
		$numero = $this->config->get('pagseguror2s_numero');
		$numero_logradouro = (isset($order_info['shipping_custom_field'][$numero]))?$order_info['shipping_custom_field'][$numero]:preg_replace('/\D/', '', $order_info['shipping_address_1']);
		$xmlps['shippingAddressStreet'] = utf8_decode(trim(str_replace(',','',preg_replace('/\d+/','',$order_info['shipping_address_1']))));
		$xmlps['shippingAddressNumber'] =  !empty($numero_logradouro)?$numero_logradouro:'';
		$xmlps['shippingAddressComplement'] = $complemento_ent;
		$xmlps['shippingAddressDistrict'] = utf8_decode((empty($order_info['shipping_address_2'])?'Bairro':$order_info['shipping_address_2']));
		$xmlps['shippingAddressPostalCode'] = preg_replace('/\D/', '', $order_info['shipping_postcode']);
		$xmlps['shippingAddressCity'] = utf8_decode($order_info['shipping_city']);
		$xmlps['shippingAddressState'] = $order_info['shipping_zone_code'];		
		}
		$xmlps['shippingAddressCountry'] = 'BRA';
		//email teste
		if($this->config->get('pagseguror2s_modo')==0){
		$xmlps['senderEmail'] = 'sandbox'.time().'@sandbox.pagseguro.com.br';	
		}
		//dados cartao
		$dddt = $telt = '';
		$tell_fullt = substr(preg_replace('/\D/', '',$_POST['telefone_cartao']),-11);
		if(strlen($tell_fullt)==10){
		$dddt = substr($tell_fullt,0,2);
		$telt = substr($tell_fullt,-8);
		}else if(strlen($tell_fullt)==11){
		$dddt = substr($tell_fullt,0,2);
		$telt = substr($tell_fullt,-9);
		}
		$xmlps['creditCardToken'] = trim($_POST['token_cartao']);
		$xmlps['creditCardHolderCPF'] = $fiscal;
		$xmlps['creditCardHolderBirthDate'] = $_POST['aniversario_cartao'];
		$holder = $_POST['titular_cartao'];
		$xmlps['creditCardHolderName'] = utf8_decode(trim(preg_replace('!\s+!',' ',$holder)));
		$xmlps['senderHash'] = trim($_POST['hash_cartao']);
		$xmlps['creditCardHolderAreaCode'] = $dddt;
		$xmlps['creditCardHolderPhone'] = $telt;
		//parcela
		$xmlps['installmentValue'] = number_format($parcelas[1], 2, '.', '');
		$xmlps['installmentQuantity'] = (int)$parcelas[0];
		$sem_juros = (int)$this->config->get('pagseguror2s_sem_juros');
		//endereco de cobranca
		$numero = $this->config->get('pagseguror2s_numero');
		$numero_logradouro = (isset($order_info['payment_custom_field'][$numero]))?$order_info['payment_custom_field'][$numero]:preg_replace('/\D/', '', $order_info['payment_address_1']);
		$xmlps['billingAddressStreet'] = utf8_decode(trim(str_replace(',','',preg_replace('/\d+/','',$order_info['payment_address_1']))));
		$xmlps['billingAddressNumber'] =  !empty($numero_logradouro)?$numero_logradouro:'';
		$xmlps['billingAddressComplement'] = $complemento_cob;
		$xmlps['billingAddressDistrict'] = utf8_decode((empty($order_info['payment_address_2'])?'Bairro':$order_info['payment_address_2']));
		$xmlps['billingAddressPostalCode'] = preg_replace('/\D/', '', $order_info['payment_postcode']);
		$xmlps['billingAddressCity'] = utf8_decode($order_info['payment_city']);
		$xmlps['billingAddressState'] = $order_info['payment_zone_code'];
		$xmlps['billingAddressCountry'] = 'BRA';
		
		if(isset($_POST['debug'])){
		print_r($xmlps);
		exit;
		}
		
		//faz a call na api
		$c = new clientREST();
		$sandbox = ($this->config->get('pagseguror2s_modo') == 0 ? 'sandbox.' : '');
		$response = $c->execRequest('https://ws.'.$sandbox.'pagseguro.uol.com.br/v2/transactions','post',$xmlps);
		
		libxml_use_internal_errors(true);
        $xml = simplexml_load_string($response);
		
		if(isset($_POST['debug'])){
		print_r($xml);
		exit;
		}

		if($xml){	
		if(isset($xml->error) || isset($xml->errors)){
			
		$data['erro'] = true;
		$data['msg'] = (isset($xml->error->message)?$xml->error->message:print_r($xml->errors,true));
		
		}else{
			
		$data['erro'] = false;
		$dados_pagseguro = $this->object2array($xml);
		$status_id = $this->getStatusPagamento($dados_pagseguro['status']);
		$meio = $this->meio($dados_pagseguro['paymentMethod']['code']);
		$tipo = $this->tipoPagamento($dados_pagseguro['paymentMethod']['type']);
		$log = (($meio)?$meio:$tipo).'<br>';
		$log .= 'Transação: '.$dados_pagseguro['code'].'<br>';
		$log .= 'Dividido em '.$parcelas[0].'x de R$'.number_format($parcelas[1], 2, '.', '').' (R$'.number_format(($parcelas[0]*$parcelas[1]), 2, '.', '').')';
		$this->model_checkout_order->addOrderHistory($dados_pagseguro['reference'], $status_id['id'],$log,true);
		$data['cupom'] = $this->url->link('extension/payment/pagseguror2s/cupom&id='.$dados_pagseguro['code'].'&venda='.$this->session->data['order_id'].'','','SSL');

		}
		}else{
			
		$data['erro'] = true;
		switch($response){
		case 'Unauthorized':
		$data['msg'] = 'Token/email não autorizado pelo PagSeguro. Verifique suas configurações no painel.';
		break;
		case 'Forbidden':
		$data['msg'] = 'Acesso não autorizado à Api Pagseguro. Verifique se você tem permissão para usar este serviço. Retorno: ' . var_export($response,true);
		break;
		default:
		$data['msg'] = 'Retorno inesperado do PagSeguro. Retorno: ' . var_export($response,true);
		}
		
		}
		
		if($data['erro']){
			//se erro
			$this->log->write("Erro Pagseguro Cartao - ".$this->tratar_mensagem_erro($data['msg']));
			echo $this->tratar_erro($this->tratar_mensagem_erro($data['msg']));
		}else{
			//se ok
			$this->response->redirect($data['cupom']);
		}

	}
	
	public function meio($id){
		foreach($this->toOptionArray() AS $meio){
		if($meio['value']==$id){
		return $meio['label'];
		}
		}
		return false;
	}
	
	public function toOptionArray() {
        $options = array();
        $options[] = array('value'=>'101','label'=>'Cartão de crédito Visa');
        $options[] = array('value'=>'102','label'=>'Cartão de crédito MasterCard');
        $options[] = array('value'=>'103','label'=>'Cartão de crédito American Express');
        $options[] = array('value'=>'104','label'=>'Cartão de crédito Diners');
        $options[] = array('value'=>'105','label'=>'Cartão de crédito Hipercard');
        $options[] = array('value'=>'106','label'=>'Cartão de crédito Aura');
        $options[] = array('value'=>'107','label'=>'Cartão de crédito Elo');
        $options[] = array('value'=>'108','label'=>'Cartão de crédito PLENOCard');
        $options[] = array('value'=>'109','label'=>'Cartão de crédito PersonalCard');
        $options[] = array('value'=>'110','label'=>'Cartão de crédito JCB');
        $options[] = array('value'=>'111','label'=>'Cartão de crédito Discover');
        $options[] = array('value'=>'112','label'=>'Cartão de crédito BrasilCard');
        $options[] = array('value'=>'113','label'=>'Cartão de crédito FORTBRASIL');
        $options[] = array('value'=>'114','label'=>'Cartão de crédito CARDBAN');
        $options[] = array('value'=>'115','label'=>'Cartão de crédito VALECARD');
        $options[] = array('value'=>'116','label'=>'Cartão de crédito Cabal');
        $options[] = array('value'=>'117','label'=>'Cartão de crédito Mais!');
        $options[] = array('value'=>'118','label'=>'Cartão de crédito Avista');
        $options[] = array('value'=>'119','label'=>'Cartão de crédito GRANDCARD');
        $options[] = array('value'=>'201','label'=>'Boleto Bradesco');
        $options[] = array('value'=>'202','label'=>'Boleto Santander');
        $options[] = array('value'=>'301','label'=>'Débito online Bradesco');
        $options[] = array('value'=>'302','label'=>'Débito online Itaú');
        $options[] = array('value'=>'303','label'=>'Débito online Unibanco');
        $options[] = array('value'=>'304','label'=>'Débito online Banco do Brasil');
        $options[] = array('value'=>'305','label'=>'Débito online Banco Real');
        $options[] = array('value'=>'306','label'=>'Débito online Banrisul');
        $options[] = array('value'=>'307','label'=>'Débito online HSBC');
        $options[] = array('value'=>'401','label'=>'Saldo PagSeguro');
        $options[] = array('value'=>'501','label'=>'Oi Paggo');
        $options[] = array('value'=>'701','label'=>'Depósito em conta - Banco do Brasil');

        return $options;
    }
	
	public function getDescontos(){
		$query = $this->db->query("SELECT SUM(value) AS desconto FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$this->session->data['order_id'] . "' AND value < 0");
		if(!isset($query->row['desconto'])){
		return 0;	
		}
		$num = $query->row['desconto'];
		$num = $num <= 0 ? $num : -$num;
		return $num;
	}
	
	public function getFrete(){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$this->session->data['order_id'] . "' AND code = 'shipping'");
		if(!isset($query->row['value'])){
		return 0;	
		}
		return $query->row['value'];
	}
	
	public function getTaxas(){
		$query = $this->db->query("SELECT SUM(value) AS taxa FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$this->session->data['order_id'] . "' AND code = 'tax'");
		if(isset($query->row['taxa'])){
		return abs($query->row['taxa']);
		}else{
		return 0;
		}
	}
	
	public function cupom(){
		$this->load->model('checkout/order');
		$this->document->setTitle('Resultado da Transa&ccedil;&atilde;o');
		$this->document->setDescription('');
		$this->document->setKeywords('');
		
		$email_pagseguro = trim($this->config->get('pagseguror2s_email'));
		$token_pagseguro = trim($this->config->get('pagseguror2s_token'));
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		$c = new clientREST();
		$sandbox = ($this->config->get('pagseguror2s_modo') == 0 ? 'sandbox.' : '');
		$response = $c->execRequest('https://ws.'.$sandbox.'pagseguro.uol.com.br/v2/transactions/'.$_GET['id'].'','get','email='.$email_pagseguro.'&token='.$token_pagseguro.'');
		libxml_use_internal_errors(true);
        $xml = simplexml_load_string($response);
		$dados_pagseguro = $this->object2array($xml);
		
		$order_info = $this->model_checkout_order->getOrder($dados_pagseguro['reference']);
		if(isset($_GET['debug'])){
		print_r($dados_pagseguro);
		}
		
		$data['meio'] = $this->meio($dados_pagseguro['paymentMethod']['code']);
		$data['iframe'] = $this->url->link('checkout/success','','SSL');
		$data['msg'] = '';
		$data['dados'] = $dados_pagseguro;
		$data['order'] = $order_info;
		$data['pedido'] = $order_info['order_id'];
		$data['status'] = $this->getStatusPagamento($dados_pagseguro['status']);
		
		if(version_compare(VERSION, '2.1.9.9', '<=')){
			$this->response->setOutput($this->load->view('default/template/extension/payment/pagseguror2s_recibo.tpl', $data));
		}else{
			$this->response->setOutput($this->load->view('extension/payment/pagseguror2s_recibo', $data));
		}
	}
	
	public function sessaops(){
		//init
		$xml = false;
		//gera a auth
		$sandbox = ($this->config->get('pagseguror2s_modo') == "0" ? 'sandbox.' : '');
		$aut = "https://ws.".$sandbox."pagseguro.uol.com.br/v2/sessions";
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL,$aut);
		curl_setopt($curl, CURLOPT_FAILONERROR, false); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS,"email=".trim($this->config->get('pagseguror2s_email'))."&token=".trim($this->config->get('pagseguror2s_token'))."");		
		$response = curl_exec($curl); 
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($response);
        if(false === $xml){
            switch($response){
                case 'Unauthorized':
                    $msg = 'Token/email não autorizado pelo PagSeguro. Verifique suas configurações no painel.';
                    break;
                case 'Forbidden':
                    $msg = 'Acesso não autorizado à Api Pagseguro. Verifique se você tem permissão para usar este serviço. Retorno: ' . var_export($response,true);
                    break;
                default:
                    $msg = 'Retorno inesperado do PagSeguro. Retorno: ' . var_export($response,true);
            }
			return array('status'=>false,'msg'=>$msg);
        }
		return array('status'=>true,'var'=>$this->object2array($xml));
	}
	
	public function object2array($object) {
	return @json_decode(@json_encode($object),true); 
	}
	
	public function so_numeros($num){
		return preg_replace('/\D/', '', $num);
	}
	
	public function tipoPagamento($tipo){
		if($tipo==1){
			return 'Cartão de Crédito';
		}elseif($tipo==2){
			return 'Boleto Bancário';
		}elseif($tipo==3){
			return 'Débito Online';
		}elseif($tipo==4){
			return 'Saldo Pagseguro';
		}elseif($tipo==5){
			return 'Oi Paggo';
		}elseif($tipo==7){
			return 'Deposito Bancário';
		}
	}
	
	public function ipn(){
		$this->load->model('checkout/order');
		if(isset($_POST['notificationType']) && $_POST['notificationType']=='transaction'){
			
			$c = new clientREST();
			$sandbox = ($this->config->get('pagseguror2s_modo') == "0" ? 'sandbox.' : '');
			
			$dados['email'] = trim($this->config->get('pagseguror2s_email'));
			$dados['token'] = trim($this->config->get('pagseguror2s_token'));
			
			$response = $c->execRequest('https://ws.'.$sandbox.'pagseguro.uol.com.br/v2/transactions/notifications/'.$_POST['notificationCode'].'','get',$dados);
			
			libxml_use_internal_errors(true);
			$xml = simplexml_load_string($response);
			$ret = $this->object2array($xml);
			
			if(isset($ret['code'])){
				
				$pedidoId = $this->so_numeros($ret['reference']);
				$status = $ret['status'];
				$transacao = $ret['code'];
				
				//verifica se e um pedido valido
				if($pedidoId>0){
				
				//dados do pedido e status
				$pedidos = $this->model_checkout_order->getOrder($pedidoId);
				$status_id = $this->getStatusPagamento($status);
				
				
				//se o pedido for zerado cria ou atualizar
				if($status_id['id']){
					//log
					$meio = $this->meio($ret['paymentMethod']['code']);
					$tipo = $this->tipoPagamento($ret['paymentMethod']['type']);
					$log = (($meio)?$meio:$tipo).' - '.$ret['code'];
					if(isset($ret['paymentLink']) && $status==1){
					$log .= ' - <a href="'.$ret['paymentLink'].'" target="_blank">[link de pagamento]</a>';
					}
					//atualiza se o status diferente do atual
					if($pedidos['order_status_id']!=$status_id['id']){
					$this->model_checkout_order->addOrderHistory($pedidoId,$status_id['id'],$log,true);
					}
				}
				echo 'OK';
				
				}
			}
		}
    }
	
	private function getStatusPagamento($status) {
			switch($status) {
				case "1": 
				$status = "Aguardando Pagamento";
				$status_id = $this->config->get('pagseguror2s_in');
				break;
				case "2":				
				$status = "Em Analise";
				$status_id = $this->config->get('pagseguror2s_pe');
				break;
				case "3": 
				$status = "Pago";
				$status_id = $this->config->get('pagseguror2s_pg');
				break;
				case "7":
				$status = "Cancelado";
				$status_id = $this->config->get('pagseguror2s_ca');
				break;	
				case "6":
				$status = "Devolvido";
				$status_id = $this->config->get('pagseguror2s_de');
				break;	
				case "9":
				$status = "Em contestacao";
				$status_id = $this->config->get('pagseguror2s_di');
				break;	
				default:
				$status = false;
				$status_id = false;
			}
			return array('nome'=>$status,'id'=>$status_id);
	}
}
?>