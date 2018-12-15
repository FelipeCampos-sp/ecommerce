<?php 
class ControllerExtensionPaymentPagSeguroR2SBoleto extends Controller{
	public function index(){
		$this->response->redirect($this->url->link('extension/payment/pagseguror2s', 'token=' . $this->session->data['token'], 'SSL'));
	}
}
?>
