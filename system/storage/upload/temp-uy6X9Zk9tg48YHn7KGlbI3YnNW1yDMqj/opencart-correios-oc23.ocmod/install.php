<?php
// mais informações sobre limites em https://www.correios.com.br/para-voce/correios-de-a-a-z/limites-de-dimensoes-e-peso

$this->load->model('setting/setting');

$result = $this->model_setting_setting->getSetting('correios');

if(!$result || ($result && empty($result['correios_servicos']))) {
	
	$data = array();

	$data['correios_servicos'][] = array(
		"codigo" => "04014",
		"nome" => "SEDEX",
		"a_cobrar" => "0",
		"postcode" => "",
		"contrato_codigo" => "",
		"contrato_senha" => "",
		"max_declarado" => "10000",
		"min_declarado" => "19",
		"max_soma_lados" => "200",
		"min_soma_lados" => "29",
		"max_lado" => "105",
		"max_peso" => "30",
		"mao_propria" => "0",
		"aviso_recebimento" => "0",
		"declarar_valor" => "0",
		"total" => "",
		"prazo_adicional" => "",
		"adicional" => ""
	);

	$data['correios_servicos'][] = array(
		"codigo" => "04065",
		"nome" => "SEDEX a Cobrar",
		"a_cobrar" => "1",		
		"postcode" => "",
		"contrato_codigo" => "",
		"contrato_senha" => "",
		"max_declarado" => "10000",
		"min_declarado" => "19",
		"max_soma_lados" => "200",
		"min_soma_lados" => "29",
		"max_lado" => "105",
		"max_peso" => "30",
		"mao_propria" => "0",
		"aviso_recebimento" => "0",
		"declarar_valor" => "1",
		"total" => "",
		"prazo_adicional" => "",
		"adicional" => ""
	);

	$data['correios_servicos'][] = array(
		"codigo" => "40215",
		"nome" => "SEDEX 10",
		"a_cobrar" => "0",		
		"postcode" => "",
		"contrato_codigo" => "",
		"contrato_senha" => "",
		"max_declarado" => "10000",
		"min_declarado" => "19",
		"max_soma_lados" => "200",
		"min_soma_lados" => "29",
		"max_lado" => "105",
		"max_peso" => "10",
		"mao_propria" => "0",
		"aviso_recebimento" => "0",
		"declarar_valor" => "0",
		"total" => "",
		"prazo_adicional" => "",
		"adicional" => ""
	);

	$data['correios_servicos'][] = array(
		"codigo" => "40169",
		"nome" => "SEDEX 12",
		"a_cobrar" => "0",		
		"postcode" => "",
		"contrato_codigo" => "",
		"contrato_senha" => "",
		"max_declarado" => "10000",
		"min_declarado" => "19",
		"max_soma_lados" => "200",
		"min_soma_lados" => "29",
		"max_lado" => "105",
		"max_peso" => "10",
		"mao_propria" => "0",
		"aviso_recebimento" => "0",
		"declarar_valor" => "0",
		"total" => "",
		"prazo_adicional" => "",
		"adicional" => ""
	);

	$data['correios_servicos'][] = array(
		"codigo" => "40290",
		"nome" => "SEDEX Hoje",
		"a_cobrar" => "0",		
		"postcode" => "",
		"contrato_codigo" => "",
		"contrato_senha" => "",
		"max_declarado" => "10000",
		"min_declarado" => "19",
		"max_soma_lados" => "200",
		"min_soma_lados" => "29",
		"max_lado" => "105",
		"max_peso" => "10",
		"mao_propria" => "0",
		"aviso_recebimento" => "0",
		"declarar_valor" => "0",
		"total" => "",
		"prazo_adicional" => "",
		"adicional" => ""
	);

	$data['correios_servicos'][] = array(
		"codigo" => "04510",
		"nome" => "PAC",
		"a_cobrar" => "0",		
		"postcode" => "",
		"contrato_codigo" => "",
		"contrato_senha" => "",
		"max_declarado" => "3000",
		"min_declarado" => "19",
		"max_soma_lados" => "200",
		"min_soma_lados" => "29",
		"max_lado" => "105",
		"max_peso" => "30",
		"mao_propria" => "0",
		"aviso_recebimento" => "0",
		"declarar_valor" => "0",
		"total" => "",
		"prazo_adicional" => "",
		"adicional" => ""
	);

	$data['correios_servicos'][] = array(
		"codigo" => "04707",
		"nome" => "PAC a Cobrar",
		"a_cobrar" => "1",		
		"postcode" => "",
		"contrato_codigo" => "",
		"contrato_senha" => "",
		"max_declarado" => "3000",
		"min_declarado" => "19",
		"max_soma_lados" => "200",
		"min_soma_lados" => "29",
		"max_lado" => "105",
		"max_peso" => "30",
		"mao_propria" => "0",
		"aviso_recebimento" => "0",
		"declarar_valor" => "1",
		"total" => "",
		"prazo_adicional" => "",
		"adicional" => ""
	);

	$this->model_setting_setting->editSetting('correios', $data);
}
?>