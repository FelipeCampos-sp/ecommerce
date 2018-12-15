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
        <button type="submit" form="form-correios" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> MercadoEnvios MercadoPago</h3>
      </div>
      <div class="panel-body">
         <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-correios" class="form-control-ex">
        <table class="form">
		
		  <tr>
            <td width="150"></td>
            <td><b>Esta forma de entrega funciona somente para pedidos finalizados e pagos por MercadoPago!</b></td>
          </tr>

          <tr>
            <td width="150">Nome de Exibicao</td>
            <td><input type="text" name="mercadoenvios5_nome" value="<?php echo $mercadoenvios5_nome; ?>" size="40" /></td>
          </tr>
		  
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="mercadoenvios5_geo_zone_id">
                <option value="0">Todas Zonas</option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $mercadoenvios5_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="mercadoenvios5_status">
                <?php if ($mercadoenvios5_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
		            <tr>
            <td>Taxa</td>
            <td><select name="mercadoenvios5_tax_class_id">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($tax_classes as $tax_class) { ?>
                  <?php if ($tax_class['tax_class_id'] == $citylink_tax_class_id) { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="mercadoenvios5_sort_order" value="<?php echo $mercadoenvios5_sort_order; ?>" size="3" /></td>
          </tr>
		  
		  <tr>
            <td>Frete Gratuito</td>
            <td><select name="mercadoenvios5_frete_gratis">
                <?php if ($mercadoenvios5_frete_gratis=='182') { ?>
                <option value="182" selected="selected">Empresso</option>
                <option value="100009">Normal</option>
				<option value="0">Nenhum metodo gratuito</option>
                <?php } elseif($mercadoenvios5_frete_gratis=='100009') { ?>
                <option value="182">Empresso</option>
                <option value="100009" selected="selected">Normal</option>
				<option value="0">Nenhum metodo gratuito</option>
                <?php }else{ ?>
				<option value="182">Empresso</option>
                <option value="100009">Normal</option>
				<option value="0" selected="selected">Nenhum metodo gratuito</option>
				<?php } ?>
              </select></td>
          </tr>
		  
		  <tr>
            <td width="150">Para total minimo de</td>
            <td><input type="text" class="dinheiro" name="mercadoenvios5_minimo" value="<?php echo $mercadoenvios5_minimo; ?>" size="40" /> (pedido minimo para frete gratuito)</td>
          </tr>
		  

		  
        </table>
      </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>