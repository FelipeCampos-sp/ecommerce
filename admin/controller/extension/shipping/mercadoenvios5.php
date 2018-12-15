<?php
class ControllerExtensionShippingMercadoEnvios5 extends Controller {
	
	private $error = array(); 
	
	public function index() {   
		$this->load->language('shipping/mercadoenvios5');

		$this->document->setTitle("MercadoEnvios");
		
		$this->load->model('setting/setting');

		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('mercadoenvios5', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/shipping/mercadoenvios5', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
		
		$data['entry_rate'] = $this->language->get('entry_rate');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => 'MercadoEnvios [Loja5]',
			'href'      => $this->url->link('extension/shipping/mercadoenvios5', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('extension/shipping/mercadoenvios5', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');


		if (isset($this->request->post['mercadoenvios5_geo_zone_id'])) {
			$data['mercadoenvios5_geo_zone_id'] = $this->request->post['mercadoenvios5_geo_zone_id'];
		} else {
			$data['mercadoenvios5_geo_zone_id'] = $this->config->get('mercadoenvios5_geo_zone_id');
		}
		
		if (isset($this->request->post['mercadoenvios5_status'])) {
			$data['mercadoenvios5_status'] = $this->request->post['mercadoenvios5_status'];
		} else {
			$data['mercadoenvios5_status'] = $this->config->get('mercadoenvios5_status');
		}
		
		if (isset($this->request->post['mercadoenvios5_sort_order'])) {
			$data['mercadoenvios5_sort_order'] = $this->request->post['mercadoenvios5_sort_order'];
		} else {
			$data['mercadoenvios5_sort_order'] = $this->config->get('mercadoenvios5_sort_order');
		}

        if (isset($this->request->post['mercadoenvios5_nome'])) {
			$data['mercadoenvios5_nome'] = $this->request->post['mercadoenvios5_nome'];
		} else {
			$data['mercadoenvios5_nome'] = $this->config->get('mercadoenvios5_nome');
		}	

        if (isset($this->request->post['mercadoenvios5_tax_class_id'])) {
			$data['mercadoenvios5_tax_class_id'] = $this->request->post['mercadoenvios5_tax_class_id'];
		} else {
			$data['mercadoenvios5_tax_class_id'] = $this->config->get('mercadoenvios5_tax_class_id');
		}	

		if (isset($this->request->post['mercadoenvios5_minimo'])) {
			$data['mercadoenvios5_minimo'] = $this->request->post['mercadoenvios5_minimo'];
		} else {
			$data['mercadoenvios5_minimo'] = $this->config->get('mercadoenvios5_minimo');
		}

		if (isset($this->request->post['mercadoenvios5_frete_gratis'])) {
			$data['mercadoenvios5_frete_gratis'] = $this->request->post['mercadoenvios5_frete_gratis'];
		} else {
			$data['mercadoenvios5_frete_gratis'] = $this->config->get('mercadoenvios5_frete_gratis');
		}		
		
		$this->load->model('localisation/tax_class');
		
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
	
		$this->load->model('localisation/geo_zone');
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/mercadoenvios5.tpl', $data));
	}
	
	private function validate() {
		return true;
	}
}
?>