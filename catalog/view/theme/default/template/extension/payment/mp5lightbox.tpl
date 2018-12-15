<div class="buttons">
  <div class="pull-left left">
  Seu pagamento ser&aacute; concluido em ambiente seguro MercadoPago!
  </div>
  <div class="pull-right right">
    <a id="button-confirm" class="btn btn-primary button">Concluir Pagamento</a>
  </div>
</div>

<script type="text/javascript">
<!--
//carrega o script caso nao exista
if (typeof $MPC == 'undefined') {
$.getScript( "https://www.mercadopago.com/org-img/jsapi/mptools/buttons/render.js", function( data, textStatus, jqxhr ) {
  console.log('js mp carregado!');
});
}

$('#button-confirm').bind('click', function() {
	//abre o mercadopago ou redireciona
	if (typeof $MPC != 'undefined') {
	console.log('abrir mp');
	$MPC.openCheckout ({
    url: "<?php echo $url_mp;?>",
    mode: "modal",
    onreturn: function(data) {
    }
	});
	}else{
	console.log('redirecionar mp');
	location.href="<?php echo $url_mp;?>";
	}
});
//-->
</script>