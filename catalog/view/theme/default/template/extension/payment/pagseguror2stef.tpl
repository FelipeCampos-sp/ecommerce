<?php
//se erro na sessao pagsegurp
if(!$sessao_ps['status']){
die('<div class="alert alert-danger">Ops, problema na session PagSeguro!<br>'.@$sessao_ps['msg'].'</div>');
}
?>
<div class="tela_pagseguro" id="tef">

<div class="row">
<div class="col-md-12">

<form class="form-horizontal form_pagamento_tef_pagseguro" method="post" action="<?php echo $gateway;?>" autocomplete="off">

<input id="pedido" name="pedido" value="<?php echo $pedido_full['order_id'];?>" type="hidden">
<input id="hash_tef" name="hash_tef" type="hidden">
<input id="meio" name="meio" type="hidden" value="tef">

<div class="form-group">
<label class="col-xs-3 control-label"></label>
<div class="col-xs-9 text-left">
<p class="form-control-static">
<img src="r2s/pagseguro/pagseguro-logo.jpg"><span id="logos_cartoes"></div>
</p>
</div>

<div class="form-group">
<label class="col-xs-3 control-label">Nome</label>
<div class="col-xs-9">
<p class="form-control-static"><?php echo $titular;?></p>
</div>
</div>

<div class="form-group">
<label class="col-xs-3 control-label">CPF/CNPJ</label>
<div class="col-xs-9">
<input type="text" onkeypress="mascara(this,'soNumeros')" maxlength="14" class="form-control" style="width:50%" id="cpf_tef" name="cpf_tef" placeholder="00000000000" value="<?php echo $cpf;?>" />
</div>
</div>

<div class="form-group">
<label class="col-xs-3 control-label">Banco</label>
<div class="col-xs-9">
<select name="banco_tef" style="width:60%" class="form-control" id="banco_tef">
</select>
</div>
</div>

<div class="form-group buttons">
<label class="col-xs-3 control-label">&nbsp;</label>
<div class="col-xs-9 text-left">
<button class="button btn btn-primary botao_pagar_tef" id="button-confirm" disabled><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Concluir Pagamento</button>
</div>
</div>

</form>
</div>
</div>

</div>

<link rel="stylesheet" type="text/css" href="r2s/pagseguro/css.css?<?php time();?>" />
<script type="text/javascript" src="r2s/pagseguro/jquery.validate.js?<?php echo time();?>"></script>
<script type="text/javascript" src="r2s/pagseguro/additional-methods.js?<?php echo time();?>"></script>
<script type="text/javascript" src="r2s/pagseguro/bootbox.min.js?<?php echo time();?>"></script>
<script type="text/javascript" src="r2s/pagseguro/block.js?<?php echo time();?>"></script>
<script type="text/javascript" src="r2s/pagseguro/init.js?<?php echo time();?>"></script>

<script type="text/javascript"> 
PagSeguroDirectPayment.setSessionId('<?php echo $sessao_ps['var']['id'];?>');

//carrega os meios ativos
PagSeguroDirectPayment.getPaymentMethods({
	amount: <?php echo number_format($total, 2, '.', '');?>,
	success: function(response) {
	console.log(response);
	var url_estatica = 'https://stc.pagseguro.uol.com.br';
	
	//imagens do cartao
	var images_cartao = '';
	var opcoes_cartao = '<option value="">Selecione</option>';
	if(response.error==false && typeof response.paymentMethods.ONLINE_DEBIT.options != 'undefined'){
	var cartoes = response.paymentMethods.ONLINE_DEBIT.options;
	$.each(cartoes , function( key, value ) {
		if(value.status=='AVAILABLE'){
		images_cartao += '<img src="'+url_estatica+''+value.images.SMALL.path+'"> ';
		opcoes_cartao += '<option value="'+value.name+'">'+value.displayName+'</option>';
		}
	});
	$('.botao_pagar_tef').removeAttr("disabled");
	$('#logos_cartoes').html(images_cartao);
	$('#banco_tef').html(opcoes_cartao);
	hash_cliente_id();
	}
	
	},
	error: function(response) {
	console.log(response);
	bootbox.dialog({
	message: 'Ops, problema ao carregar PagSeguro! Tente novamente.',
	title: "Erro",
	});
	}
});

//ao carregar script com sucesso
var hash_pagseguro_session = '<?php echo $sessao_ps['var']['id'];?>';

function hash_cliente_id(){
var sendhash = PagSeguroDirectPayment.getSenderHash();
$('#hash_tef').val(sendhash);
}

$(".form_pagamento_tef_pagseguro").validate({
	showErrors: function(errorMap, errorList) {
		if(jQuery.isEmptyObject(errorList)==false && errorList.length > 0){
		console.log(errorList);
		var alerta = '';
		$.each(errorList, function( index, value ){
			alerta += value.message+'<br>';
		});
		bootbox.dialog({
			message: alerta,
			title: "Dados obrigatorios!",
		});
		}
	},
	onclick: false,
	onfocusout: false,
	onkeyup: false,
	submitHandler: function(form) {
		
	$('#button-confirm').button('loading').attr('disabled', true);

    $.blockUI({
			message: '<img width="70" style="margin:10px" src="r2s/pagseguro/img/busy.gif">', 
			css: { border: '0px solid #000', 'background-color':'transparent', 'border-radius': '10px' } 
	});
	
	form.submit();
	
  },
  errorClass: "ops_campo_erro",
  rules: {
	cpf_tef: {
		required: true,
		validacpfcnpj:true
	},
	banco_tef: "required",
  },
  messages: {
	cpf_tef: "Informe CPF/CNPJ do titular!",
	banco_tef: "Selecione o banco",
  }
});
</script>
