<?php 
echo $header; 
$order = @$pagamento['response'];
function meio_mp($meio){
	switch($meio){
		case 'credit_card':
		return 'Cart&atilde;o de Cr&eacute;dito';
		break;
		case 'tiket':
		return 'Boleto Banc&aacute;rio';
		break;
		case 'account_money':
		return 'Saldo MercadoPago';
		break;
		default:
		return 'MercadoPago';
	}
}
?>

<div class="container" id="container">
<div class="row">
<?php $class = 'col-sm-12'; ?>
<div id="content" class="<?php echo $class; ?>">

  <h3>Resultado da Transa&ccedil;&atilde;o</h3>
  <p>
  A transa&ccedil;&atilde;o <b><?php echo $order['id'];?></b> relacionada ao seu pedido <b>#<?php echo $order['external_reference'];?></b> encontra-se no status <b><?php echo $status['nome'];?></b>. 
  <br><br>
   <b>Forma de Pagamento:</b> <?php echo meio_mp($order['payment_type']);?><br>
  <b>Total a pagar:</b> R$<?php echo number_format($order['total_paid_amount'], 2, '.', '');?><?php echo ($order['payment_type']!='credit_card')?' &agrave; vista':' em '.$order['installments'].'x no '.$order['payment_method_id'];?> <b></b><br>

  <br>
  <?php if($order['payment_type']=='ticket'){?>
  Enviamos ao seu e-mail o link de pagamento do boleto, para que seu pedido seja enviado acesse o boleto e pague o mesmo at&eacute; o vencimento.
  <?php }elseif($order['payment_type']=='credit_card'){ ?>
  Este pedido ser&aacute; identificando em sua fatura por "MERCADOPAGO".
  <?php } ?>
  <br>
  <br>
  Clique <a href="index.php?route=account/order/info&order_id=<?php echo $order['external_reference'];?>">aqui</a> para visualizar detalhes de seu pedido ou para mais informa&ccedil;&otilde;es entre em <a href="index.php?route=information/contact">contato</a> com a loja.
  </p>


<script>
(function(){
    var i = document.createElement('iframe');
    i.style.display = 'none';
    i.onload = function() { i.parentNode.removeChild(i); };
    i.src = '<?php echo $iframe;?>';
    document.body.appendChild(i);
})();
</script>

<?php include("app/mp5lightbox/html.php");?>
<br>
</div>
</div>
</div>

<?php 
echo $footer; 
?>