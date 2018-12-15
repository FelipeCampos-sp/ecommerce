function mascaraCampos(t, mask){
	var i = t.value.length;
	var saida = mask.substring(1,0);
	var texto = mask.substring(i)
	if (texto.substring(0,1) != saida){
	t.value += texto.substring(0,1);
	}
}
function validar_cep(cep){
	if(cep.length==8 || cep.length==9){
		return true;
	}else{
		return false;
	}		
}
function calcular_frete_ok(){
	var cep = $('#cep').val();
	var id = $('#id_produto_frete').val();
	var qtd = $('input[name="quantity"]').val();
	if(validar_cep(cep)){
	$.ajax({
		url: 'index.php?route=checkout/simulador',
		type: 'post',
		data: 'cep='+cep+'&id='+id+'&qtd='+qtd,
		dataType: 'html',
		beforeSend: function() {
			$('#resultado-frete').html('<br><img class="center-block" src="image/aguarde_cep.gif">');
			$('#botao-cep').button('loading');
		},
		complete: function() {
			$('#botao-cep').button('reset');
		},			
		success: function(html) {
			$('#resultado-frete').html(html);
		}
	});
	}else{
		alert('Digite um CEP v\u00e1lido!');
		$('#cep').focus();
		return false;
	}
}