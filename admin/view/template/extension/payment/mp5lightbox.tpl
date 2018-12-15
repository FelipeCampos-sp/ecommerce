<?php echo $header; ?>

<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script>
$(function(){
$(".dinheiro").maskMoney({thousands:'', decimal:'.', allowZero:true, suffix: ''});
});
</script>

<style>
.form-control-ex input[type="text"],input[type="number"],select,textarea {
	margin: 3px !important;
	border: solid 1px #dcdcdc;
	border-radius:4px;
	height: 30px;
}
.help {
	font-style: italic;
	font-size: 13px;
}
</style>

<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cod" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> MercadoPago Lightbox</h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cod" class="form-horizontal form-control-ex">
		
<div role="tabpanel">
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
<li role="presentation" class="active"><a href="#configuracoes" aria-controls="configuracoes" role="tab" data-toggle="tab">Configura&ccedil;&otilde;es</a></li>

</ul>
<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="configuracoes">

<table class="table table-striped">


<tr>
<td>Nome do M&oacute;dulo:</td>
<td><input type="text" name="mp5lightbox_nome" value="<?php echo $mp5lightbox_nome; ?>" size="70" /></td>
</tr>

<tr>
<td>Total minimo:</td>
<td><input class="dinheiro" type="text" name="mp5lightbox_total" value="<?php echo $mp5lightbox_total; ?>" /></td>
</tr>

<tr>
<td><?php echo $entry_geo_zone; ?></td>
<td><select name="mp5lightbox_geo_zone_id">
<option value="0"><?php echo $text_all_zones; ?></option>
<?php foreach ($geo_zones as $geo_zone) { ?>
<?php if ($geo_zone['geo_zone_id'] == $mp5lightbox_geo_zone_id) { ?>
<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>

<tr>
<td><?php echo $entry_status; ?></td>
<td><select name="mp5lightbox_status">
<?php if ($mp5lightbox_status) { ?>
<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
<option value="0"><?php echo $text_disabled; ?></option>
<?php } else { ?>
<option value="1"><?php echo $text_enabled; ?></option>
<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
<?php } ?>
</select></td>
</tr>

<tr>
<td><?php echo $entry_sort_order; ?></td>
<td><input type="text" name="mp5lightbox_sort_order" value="<?php echo $mp5lightbox_sort_order; ?>" size="5" /></td>
</tr>

<tr>
<td>Modo:</td>
<td><select name="mp5lightbox_modo">
<?php if ($mp5lightbox_modo==1) { ?>
<option value="1" selected="selected">Produ&ccedil;&atilde;o</option>
<option value="0">Teste</option>
<?php } else { ?>
<option value="1">Produ&ccedil;&atilde;o</option>
<option value="0" selected="selected">Teste</option>
<?php } ?>
</select>
</td>
</tr>

<tr>
<td>Client_ID:</td>
<td><input type="text" name="mp5lightbox_afiliacao" value="<?php echo $mp5lightbox_afiliacao; ?>" size="50" /></td>
</tr>

<tr>
<td>Client_Secret:</td>
<td><input type="text" name="mp5lightbox_chave" value="<?php echo $mp5lightbox_chave; ?>" size="90" /></td>
</tr>

<tr>
<td>Origem CPF</td>
<td>
<select name="mp5lightbox_cpf" id="input-canceled-status" class="form-control">
<option value="0" selected="selected">Cliente digita ao finalizar</option>
<?php foreach ($campos as $campo) { ?>
<?php if ($campo['custom_field_id'] == $mp5lightbox_cpf) { ?>
<option value="<?php echo $campo['custom_field_id']; ?>" selected="selected"><?php echo $campo['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $campo['custom_field_id']; ?>"><?php echo $campo['name']; ?></option>
<?php } ?>
<?php } ?>
</select>
</td>
</tr>

<tr>
<td>Origem N&uacute;mero</td>
<td>
<select name="mp5lightbox_numero" id="input-canceled-status" class="form-control">
<option value="0" selected="selected">Vai junto ao logradouro</option>
<?php foreach ($campos as $campo) { ?>
<?php if ($campo['custom_field_id'] == $mp5lightbox_numero) { ?>
<option value="<?php echo $campo['custom_field_id']; ?>" selected="selected"><?php echo $campo['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $campo['custom_field_id']; ?>"><?php echo $campo['name']; ?></option>
<?php } ?>
<?php } ?>
</select>
</td>
</tr>

<tr>
<td>Status Inicial</td>
<td><select name="mp5lightbox_order_status_id">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $mp5lightbox_order_status_id) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>


<tr>
<td>Status Pago:</td>
<td><select name="mp5lightbox_aprovado">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $mp5lightbox_aprovado) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>

<tr>
<td>Status Cancelado:</td>
<td><select name="mp5lightbox_cancelado">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $mp5lightbox_cancelado) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>

<tr>
<td>Status Pendente:</td>
<td><select name="mp5lightbox_pendente">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $mp5lightbox_pendente) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>

<tr>
<td>Status Disputa:</td>
<td><select name="mp5lightbox_disputa">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $mp5lightbox_disputa) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>


<tr>
<td>Status Devolvido:</td>
<td><select name="mp5lightbox_devolvido">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $mp5lightbox_devolvido) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>

<tr>
<td>Status Chargeback:</td>
<td><select name="mp5lightbox_chargeback">
<?php foreach ($order_statuses as $order_status) { ?>
<?php if ($order_status['order_status_id'] == $mp5lightbox_chargeback) { ?>
<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
<?php } else { ?>
<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
<?php } ?>
<?php } ?>
</select></td>
</tr>

</table>

</div>		
	


</div>
</div>

        </form>
      </div>
    </div>
  </div>
</div>

<script>
$('input[name="mp5lightbox_soft"]').on( "keyup keydown", function() {
var string = $(this).val();
$(this).val(string.replace(/[^0-9a-zA-Z]/g,'').toUpperCase());
});
</script>

<?php echo $footer; ?> 