<?php
//se erro na sessao pagsegurp
if(!$sessao_ps['status']){
die('<div class="alert alert-danger">Ops, problema na session PagSeguro!<br>'.@$sessao_ps['msg'].'</div>');
}
?>

<div class="tela_pagseguro" id="cartao">

<div class="row">

<div class="col-md-12">
<p class="alert alert-info attention">Informe abaixo os dados do cart&atilde;o de cr&eacute;dito correspondente ao titular do endere&ccedil;o de cobran&ccedil;a informado durante o checkout na loja.</p>
</div>

<div class="col-md-12">

<form class="oc2 form-horizontal form_pagamento_cartao_pagseguro" method="post" action="<?php echo $gateway;?>" autocomplete="off">

<input id="pedido" name="pedido" value="<?php echo $pedido_full['order_id'];?>" type="hidden">
<input id="bandeira_cartao" name="bandeira_cartao" type="hidden">
<input id="hash_cartao" name="hash_cartao" type="hidden">
<input id="token_cartao" name="token_cartao" type="hidden">
<input id="meio" name="meio" type="hidden" value="cartao">

<div class="form-group">
<label class="col-xs-12 col-md-2 control-label"></label>
<div class="col-xs-12 col-md-10 text-left">
<img src="r2s/pagseguro/pagseguro-logo.jpg"><span id="logos_cartoes"></div>
</div>

<div class="form-group">
<label class="col-xs-12 col-md-2 control-label">Titular</label>
<div class="col-xs-12 col-md-10">
<input type="text" style="width:100%;display: inline;" value="<?php echo $titular;?>" onkeyup="up(this)" onkeydown="up(this)" class="form-control" id="titular_cartao" name="titular_cartao" placeholder="NOME DO TITULAR DO CART&Atilde;O" />
</div>
</div>

<div class="form-group">
<label class="col-xs-12 col-md-2 control-label">Aniversario</label>
<div class="col-xs-12 col-md-2">
<input type="text" style="width:80%;display: inline;" onkeypress="javascript:mascara(this,'data');" maxlength="10" class="form-control" id="aniversario_cartao" name="aniversario_cartao" placeholder="DD/MM/AAAA" />
</div>
<label class="col-xs-12 col-md-1 control-label">CPF</label>
<div class="col-xs-12 col-md-3">
<input type="text" style="display: inline;" onkeypress="mascara(this,'soNumeros')" maxlength="11" class="form-control" id="cpf_cartao" name="cpf_cartao" placeholder="CPF do titular!" value="<?php echo $cpf;?>" />
</div>
<label class="col-xs-12 col-md-1 control-label">Telefone</label>
<div class="col-xs-12 col-md-3">
<input type="text" value="<?php echo $ddd;?><?php echo $tel;?>" onkeypress="mascara(this,'telefone')" style="display: inline;" maxlength="15" class="form-control" id="telefone_cartao" name="telefone_cartao" placeholder="(00)00000000" />
</div>
</div>

<div class="form-group">
<label class="col-xs-12 col-md-2 control-label">N&uacute;mero:</label>
<div class="col-xs-12 col-md-10">
<input type="text" onblur="checar_cartao_pagseguro(this.value)" onkeypress="mascara(this,'soNumeros')" style="width:100%;display: inline;" maxlength="19" class="form-control" id="numero_cartao" name="numero_cartao" placeholder="Digite o n&uacute;mero do cart&atilde;o!" />
</div>
</div>

<div class="form-group">
<label class="col-xs-12 col-md-2 control-label">Validade</label>
<div class="col-xs-12 col-md-6">
<select name="validade_cartao_mes" style="width:45%;display: inline;" class="form-control" id="validade_cartao_mes">
<option value="">M&ecirc;s</option>
<option value="01">01 - Janeiro</option>
<option value="02">02 - Feveriro</option>
<option value="03">03 - Mar&ccedil;o</option>
<option value="04">04 - Abril</option>
<option value="05">05 - Maio</option>
<option value="06">06 - Junho</option>
<option value="07">07 - Julho</option>
<option value="08">08 - Agosto</option>
<option value="09">09 - Setembro</option>
<option value="10">10 - Outubro</option>
<option value="11">11 - Novembro</option>
<option value="12">12 - Dezembro</option>
</select>
<select name="validade_cartao_ano" style="width:40%;display: inline;" class="form-control" id="validade_cartao_ano">
<option value="">Ano</option>
<?php for($i=date('Y');$i<=(date('Y')+30);$i++){?>
<option value="<?php echo $i;?>"><?php echo $i;?></option>
<?php } ?>
</select>
</div>

<label class="col-xs-12 col-md-1 control-label">C&oacute;d. CVV</label>
<div class="col-xs-12 col-md-3">
<input type="text"  onkeypress="mascara(this,'soNumeros')" placeholder="3 ou 4 digitos (amex)" maxlength="4" class="form-control" style="display: inline;" id="codigo_cartao" name="codigo_cartao" />
</div>
</div>

<div class="form-group">
<label class="col-xs-12 col-md-2 control-label">Parcela</label>
<div class="col-xs-12 col-md-10">
<select style="width:50%;display: inline;" name="parcela_cartao" onchange="calcular_total(this.value);" class="form-control" id="parcela_cartao">
<option value="">Digite o N&uacute;mero do Cart&atilde;o...</option>
</select>
<input type="text" style="width:40%;display: inline;" class="form-control" disabled value="Total: R$<?php echo number_format($total, 2, '.', '');?>" id="total-pagseguro">
</div>
</div>

<div class="form-group buttons">
<label class="hidden-xs col-xs-12 col-md-2 control-label">&nbsp;</label>
<div class="col-xs-12 col-md-4">
<button class="button btn btn-primary botao_pagar_cartao" disabled id="button-confirm"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Concluir Pagamento</button>
</div>
<div class="col-xs-12 col-md-6">
<b>Est&aacute; compra est&aacute; sendo feita no Brasil <img src="data:image/png;base64,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"></b>
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
//init
PagSeguroDirectPayment.setSessionId('<?php echo $sessao_ps['var']['id'];?>');

//carrega os meios ativos
PagSeguroDirectPayment.getPaymentMethods({
	amount: <?php echo number_format($total, 2, '.', '');?>,
	success: function(response) {
	console.log(response);
	var url_estatica = 'https://stc.pagseguro.uol.com.br';
	
	//imagens do cartao
	var images_cartao = '';
	if(response.error==false && typeof response.paymentMethods.CREDIT_CARD.options != 'undefined'){
	var cartoes = response.paymentMethods.CREDIT_CARD.options;
	$.each(cartoes , function( key, value ) {
		if(value.status=='AVAILABLE'){
		images_cartao += '<img src="'+url_estatica+''+value.images.SMALL.path+'"> ';
		}
	});
	$('.botao_pagar_cartao').removeAttr("disabled");
	$('#logos_cartoes').html(images_cartao);
	hash_cliente_id();
	}
	
	},
	error: function(response) {
	
	bootbox.dialog({
	message: 'Ops, problema ao carregar PagSeguro! Tente novamente.',
	title: "Erro",
	});
	
	}
});

//ao carregar script com sucesso
var total_pagseguro = <?php echo number_format($total, 2, '.', '');?>;
var hash_pagseguro_session = '<?php echo $sessao_ps['var']['id'];?>';

//funcao que checa o numero do cartao e carrega as parcelas
function checar_cartao_pagseguro(numero){
var cartao = numero;
if(cartao.length>=13){
var cartao = cartao.replace(/\D/g,'');
PagSeguroDirectPayment.getBrand({
cardBin: cartao,
success: function(response) {
	$('.imagens_pagaseguro').remove();
	$('#numero_cartao').after('<img class="imagens_pagaseguro" style="float: right; margin-top: -26px; position: relative; left: -10px;" src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/'+response.brand.name+'.png">');
	$('#bandeira_cartao').val(response.brand.name);
	carregar_parcelas_pagseguro();
},
error: function(response) {
	bootbox.dialog({
	message: "Ops, cart&atilde;o de cr&eacute;dito invalido ou n&atilde;o aceito!",
	title: "Erro",
	});
	$('#parcela_cartao').html('<option value="">Ops, cart&atilde;o de cr&eacute;dito invalido ou n&atilde;o aceito!</option>');
}
});
}
}

function carregar_parcelas_pagseguro(){
var items = '<option value="">Carregando...</option>';
PagSeguroDirectPayment.getInstallments({
amount: <?php echo number_format($total, 2, '.', '');?>,
brand: $("#bandeira_cartao").val(),
success: function(response) {
	var items = '';
	var parcelas = response.installments;
	console.log(parcelas);
	var bandeira = $("#bandeira_cartao").val();
	var parcela = eval("response.installments."+bandeira+"");
	$.each(parcela, function(key, val) {
	var com_sem_juros = '';
	if(val.interestFree){
	var com_sem_juros = ' sem juros';
	}
	items += '<option value="' + val.quantity + '|' + val.installmentAmount + '">' + val.quantity + 'x de R$' + val.installmentAmount.toFixed(2) + ''+com_sem_juros+'</option>';
	});
	$('#parcela_cartao').html(items);
},
error: function(response) {
	bootbox.dialog({
	message: "Ops, problema ao carregar parcelas!",
	title: "Erro",
	});
	$('#parcela_cartao').html('<option value="">Ops, problema ao carregar parcelas!</option>');
}
});
}

function hash_cliente_id(){
var sendhash = PagSeguroDirectPayment.getSenderHash();
$('#hash_cartao').val(sendhash);
}

function calcular_total(dados){
	var res = dados.split("|");
	var total = parseFloat(res[0]*res[1]);
	console.log(total);
	$('#total-pagseguro').val('Total: R$'+total.toFixed(2));
}

function gerarTokenPagSeguro(form){
	var cartao = $("#numero_cartao").val();
	var cartao = cartao.replace(/\D/g,'');
	var codigo = $("#codigo_cartao").val();
	var codigo = codigo.replace(/\D/g,'');
	var validade_mes = $("#validade_cartao_mes").val();
	var validade_ano = $("#validade_cartao_ano").val();
		
	var param = {
	cardNumber: cartao,
	cvv: codigo,
	expirationMonth: validade_mes.replace(/\D/g,''),
	expirationYear: validade_ano.replace(/\D/g,''),
	brand: $("#bandeira_cartao").val(),
	success: function(response) {
		
		$('#button-confirm').button('loading').attr('disabled', true);
		
		$.blockUI({
			message: '<img width="70" style="margin:10px" src="r2s/pagseguro/img/busy.gif">', 
			css: { border: '0px solid #000', 'background-color':'transparent', 'border-radius': '10px' } 
		});

		console.log('OK:');
		console.log(response);
		$('#token_cartao').val(response.card.token);
		form.submit();
	
	},
	complete: function(response) {
	},
	error: function(response) {
		
		console.log('ERRO:');
		console.log(response);
		
		if (typeof response.errors != 'undefined') {
			var erro = '';
			jQuery.each(response.errors, function(index, value) {
				erro += value+"<br>";
			});
			bootbox.dialog({
			message: erro,
			title: "Erro",
			});	
		}else{
			bootbox.dialog({
			message: "Ops, algum dado informado est&eacute; incorreto ou incompleto!",
			title: "Erro",
			});	
		}
		
		$('#tela-full-pagseguro').unblock(); 
		
		return false;
	
	}
	}
	
	console.log('LOG:');
	console.log(param);
	PagSeguroDirectPayment.createCardToken(param);
}

$(".form_pagamento_cartao_pagseguro").validate({
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
	
	gerarTokenPagSeguro(form);
	return false;
	
	},
	errorClass: "ops_campo_erro",
	rules: {
    titular_cartao: {
		required: true,
		minlength: 6
	},
	aniversario_cartao: {
		required: true,
		minlength: 10
	},
	telefone_cartao: {
		required: true,
		minlength: 12
	},
	cpf_cartao: {
		required: true,
		validacpfcnpj:true
	},
	numero_cartao: {
		required: true,
		validacartao:true
	},
	validade_cartao_mes: {
		required: true
	},
	validade_cartao_ano: {
		required: true
	},
	codigo_cartao: {
		required: true,
		minlength: 3,
		maxlength: 4
	},
  },
  messages: {
    titular_cartao: "Informe o nome do titular!",
	aniversario_cartao: "Informe data de nascimento do titular!",
	telefone_cartao: "Informe telefone do titular!",
	cpf_cartao: "Informe CPF do titular valido!",
	numero_cartao: "Informe o n\u00famero do cart\u00e3o valido!",
	validade_cartao_mes: "Selecione o mes de validade do cart\u00e3o!",
	validade_cartao_ano: "Selecione o ano de validade do cart\u00e3o!",
	codigo_cartao: "Informe o CVV do cart\u00e3o!",
  }
});
</script>
<script type="text/javascript">
<!--
$('#button-confirm').on('click', function() {
	//$(".form_pagamento_cartao_pagseguro").submit();
});
//-->
</script>