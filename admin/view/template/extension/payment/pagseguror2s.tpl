
<?php echo $header; ?>

<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script>
$(function(){
$(".dinheiro").maskMoney({thousands:'', decimal:'.', allowZero:true, suffix: ''});
});
</script>

<style>
.form-control-pagseguro {
	margin: 2px !important;
	border: solid 1px #dcdcdc;
	border-radius:4px;
	height: 30px;
}
</style>

<?php echo $column_left; ?>
<div id="content">
<div class="page-header">
<div class="container-fluid">
<div class="pull-right">
<button type="submit" form="form-pagseguro" data-toggle="tooltip" class="btn btn-primary"><i class="fa fa-save"></i></button>
<a href="<?php echo $cancel; ?>" data-toggle="tooltip" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
<h1><?php echo $heading_title; ?></h1>
<ul class="breadcrumb">
<?php foreach ($breadcrumbs as $breadcrumb) { ?>
<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
<?php } ?>
</ul>
</div>
</div>
<div class="container-fluid">

<?php if ($error_warning) { ?>
<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php } ?>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-list"></i> PagSeguro Transparente</h3>
</div>
<div class="panel-body">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-pagseguro">


<div role="tabpanel">


<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
<li role="presentation" class="active"><a href="#configuracoes" aria-controls="configuracoes" role="tab" data-toggle="tab">Configura&ccedil;&otilde;es</a></li>
<li role="presentation"><a href="#cartao" aria-controls="cartao" role="tab" data-toggle="tab">Cart&atilde;o</a></li>
<li role="presentation"><a href="#boleto" aria-controls="boleto" role="tab" data-toggle="tab">Boleto</a></li>
<li role="presentation"><a href="#tef" aria-controls="tef" role="tab" data-toggle="tab">TEF</a></li>
<li role="presentation"><a href="#status" aria-controls="status" role="tab" data-toggle="tab">Status</a></li>
</ul>


<div class="tab-content">	

<div role="tabpanel" class="tab-pane active" id="configuracoes">
<table class="table table-condensed">

<tr>
<td>Status</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_status">
<?php if ($pagseguror2s_status) { ?>
<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
<option value="0"><?php echo $text_disabled; ?></option>
<?php } else { ?>
<option value="1"><?php echo $text_enabled; ?></option>
<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
<?php } ?>
</select></td>
</tr>

<tr>
<td>Ambiente</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_modo">
<?php if ($pagseguror2s_modo) { ?>
<option value="1" selected="selected">Producao</option>
<option value="0">Teste (sandbox)</option>
<?php } else { ?>
<option value="1">Producao</option>
<option value="0" selected="selected">Teste (sandbox)</option>
<?php } ?>
</select></td>
</tr>

<tr>
<td>E-mail pagseguro</td>
<td><input class="form-control-pagseguro" type="text" size="40" name="pagseguror2s_email" value="<?php echo $pagseguror2s_email; ?>" /></td>
</tr>
<tr>
<td>Token pagseguro</td>
<td><input class="form-control-pagseguro" type="text" size="40" name="pagseguror2s_token" value="<?php echo $pagseguror2s_token; ?>" /></td>
</tr>

<tr>
<td>Origem CPF/CNPJ</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_fiscal">
<option value="0" selected="selected">Cliente digita manual</option>
<?php foreach ($campos as $campo) { ?>
<?php if ($campo['custom_field_id'] == $pagseguror2s_fiscal) { ?>
<option value="<?php echo $campo['custom_field_id']; ?>" selected="selected"><?php echo $campo['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $campo['custom_field_id']; ?>"><?php echo $campo['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>

<tr>
<td>Origem N&uacute;mero</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_numero">
<option value="0" selected="selected">Vai junto ao logradouro</option>
<?php foreach ($campos as $campo) { ?>
<?php if ($campo['custom_field_id'] == $pagseguror2s_numero) { ?>
<option value="<?php echo $campo['custom_field_id']; ?>" selected="selected"><?php echo $campo['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $campo['custom_field_id']; ?>"><?php echo $campo['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>

<tr>
<td>Origem Complemento</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_complemento">
<option value="0" selected="selected">Nao requer o uso</option>
<?php foreach ($campos as $campo) { ?>
<?php if ($campo['custom_field_id'] == $pagseguror2s_complemento) { ?>
<option value="<?php echo $campo['custom_field_id']; ?>" selected="selected"><?php echo $campo['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $campo['custom_field_id']; ?>"><?php echo $campo['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>

<tr>
<td>Zona</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_geo_zone_id">
<option value="0">Todas</option>
<?php foreach ($geo_zones as $geo_zone) { ?>
<?php if ($geo_zone['geo_zone_id'] == $pagseguror2s_geo_zone_id) { ?>
<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>

</table>
</div>

<div role="tabpanel" class="tab-pane" id="cartao">
<table class="table table-condensed">
<tr>
<td>Status Cart&atilde;o</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_status_cartao">
<?php if ($pagseguror2s_status_cartao) { ?>
<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
<option value="0"><?php echo $text_disabled; ?></option>
<?php } else { ?>
<option value="1"><?php echo $text_enabled; ?></option>
<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
<?php } ?>
</select></td>
</tr>
<tr>
<td width="250">Titulo Cart&atilde;o</td>
<td><input type="text" class="form-control-pagseguro" size="40" name="pagseguror2s_titulo_cartao" value="<?php echo $pagseguror2s_titulo_cartao; ?>" /></td>
</tr>
<tr>
<td>Ordem</td>
<td><input class="form-control-pagseguro" type="text" name="pagseguror2s_ordem_cartao" value="<?php echo $pagseguror2s_ordem_cartao; ?>" size="8" /></td>
</tr>
<tr>
<td>Total minimo</td>
<td><input class="form-control-pagseguro dinheiro" type="text" name="pagseguror2s_total_cartao" size="8" value="<?php echo $pagseguror2s_total_cartao; ?>" /></td>
</tr>
</table>
</div>

<div role="tabpanel" class="tab-pane" id="boleto">
<table class="table table-condensed">
<tr>
<td>Status Boleto</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_status_boleto">
<?php if ($pagseguror2s_status_boleto) { ?>
<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
<option value="0"><?php echo $text_disabled; ?></option>
<?php } else { ?>
<option value="1"><?php echo $text_enabled; ?></option>
<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
<?php } ?>
</select></td>
</tr>
<tr>
<td width="250">Titulo Boleto</td>
<td><input type="text" class="form-control-pagseguro" size="40" name="pagseguror2s_titulo_boleto" value="<?php echo $pagseguror2s_titulo_boleto; ?>" /></td>
</tr>
<tr>
<td>Ordem</td>
<td><input class="form-control-pagseguro" type="text" name="pagseguror2s_ordem_boleto" value="<?php echo $pagseguror2s_ordem_boleto; ?>" size="8" /></td>
</tr>
<tr>
<td>Total minimo</td>
<td><input class="form-control-pagseguro dinheiro" type="text" name="pagseguror2s_total_boleto" size="8" value="<?php echo $pagseguror2s_total_boleto; ?>" /></td>
</tr>
</table>
</div>

<div role="tabpanel" class="tab-pane" id="tef">
<table class="table table-condensed">
<tr>
<td>Status TEF</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_status_tef">
<?php if ($pagseguror2s_status_tef) { ?>
<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
<option value="0"><?php echo $text_disabled; ?></option>
<?php } else { ?>
<option value="1"><?php echo $text_enabled; ?></option>
<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
<?php } ?>
</select></td>
</tr>
<tr>
<td width="250">Titulo TEF</td>
<td><input type="text" class="form-control-pagseguro" size="40" name="pagseguror2s_titulo_tef" value="<?php echo $pagseguror2s_titulo_tef; ?>" /></td>
</tr>
<tr>
<td>Ordem</td>
<td><input class="form-control-pagseguro" type="text" name="pagseguror2s_ordem_tef" value="<?php echo $pagseguror2s_ordem_tef; ?>" size="8" /></td>
</tr>
<tr>
<td>Total minimo</td>
<td><input class="form-control-pagseguro dinheiro" type="text" name="pagseguror2s_total_tef" size="8" value="<?php echo $pagseguror2s_total_tef; ?>" /></td>
</tr>
</table>
</div>

<div role="tabpanel" class="tab-pane" id="status">
<table class="table table-condensed">
<tr>
<td width="250">Status Aguardando Pagamento</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_in">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $pagseguror2s_in) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>
<tr>
<td>Status Pendente/Em analize</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_pe">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $pagseguror2s_pe) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>
<tr>
<td>Status Pago</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_pg">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $pagseguror2s_pg) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>
<tr>
<td>Status Cancelado</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_ca">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $pagseguror2s_ca) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>
<tr>
<td>Status Devolvido</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_de">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $pagseguror2s_de) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>
<tr>
<td>Status Em Disputa</td>
<td><select class="form-control-pagseguro" name="pagseguror2s_di">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $pagseguror2s_di) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>
</table>
</div>


</form>
</div>
</div>
</div>
</div>
<?php echo $footer; ?>