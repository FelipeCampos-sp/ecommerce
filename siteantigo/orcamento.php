<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<!-- metas da pagina da pagina -->
      <meta name="description" content="">
      <meta name="keywords" content="">
      <meta name="robots" content="index, follow">
      <meta name="revisit-after" content="1 day">
      <meta name="language" content="Portuguese">
      <meta name="generator" content="N/A">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <!-- fim das metas da pagina do site--> 

    <!--metas do facebook-->
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="Rcl Brasil reciclagem de lixo "/>
    <meta property="og:description" content="Esse Site Esta Sendo Desenvolvido para anunciar os serviços da empresa RCL Brasil"/>
    <meta property="og:image" content="https://www.publisheweb.com.br/themes/publishe/img/sitekit/index.jpg"/>
    <meta property="og:url" content="https://www.facebook.com/reciclarlixo/"/>
    <meta property="og:site_name" content="Reciclar lixo"/>
    <meta property="og:locale" content="pt_BR"/>
    <meta property="og:app_id" content="2071127009793740"/>
    <meta property="article:author" content="https://www.facebook.com/felipe.ferreiracampos.9"/>
    <meta property="og:article:publisher" content="https://www.facebook.com/reciclarlixo/"/>
    <!--fim das metas do facebook-->
    <!--metas do twitter-->
  
    <meta property="twitter:card" content="@RclBrasilColeta">
    <meta property="twitter:site" content="summary_large_image">
    <meta property="twitter:domain" content="www.projetofelipecampos.com.br">
    <meta property="twitter:title" content="summary_large_image">
    <meta property="twitter:description" content="summary_large_image">
    <meta property="twitter:image:src" content="summary_large_image">
    <meta property="twitter:url" content="summary_large_image">
  
    <!--metas do twitter-->

  <title>Orçamento</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/mobile.css">
  <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1, maximum-scale=1,minimum-scale=1">

  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="img/bg-icon.png"/>
</head>
<body>
   <header>   
  <?php require './pages/header.php'; ?>
 </header><!--end header--> 
 
 <input type="checkbox" id="btn-menu">
 <label for="btn-menu" class="mobile fa fa-bars fa-2x"></label>
  <nav>
  <?php require './pages/nav.php';?>
 </nav><!--end nav-->




<script src="js/menu.js"></script>

<main>
 <div class="content">

  <h1 class="title-form">Solicite um orçamento</h1>
  <?php
        use PHPMailer\PHPMailer\PHPMailer;
        require 'libs/PHPMailer/Exception.php';
        require 'libs/PHPMailer/PHPMailer.php';
        require 'libs/PHPMailer/SMTP.php';

        // CONSTANTES EMAIL SERVER
          // define('MAILERUSER', "felipe.ferreira.camposs@gmail.com");
          // define('MAILERPASS', "mercenario82");
          define('MAILERUSER', "felipe.ferreira.camposs@gmail.com");
          define('MAILERPASS', "mercenario82");
          define('MAILERHOST', "smtp.gmail.com");
          define('MAILERPORT', 587);
          define('MAILERSENDER', 'App Felipe');
        $erro = '';
        $POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $mail = $POST['email'];
        $mailContato = new PHPMailer(true);
        if(isset($POST['enviar'])):
          unset($POST['enviar']);
          // var_dump($POST);
          $BodyMail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
          <html xmlns="http://www.w3.org/1999/xhtml">
           <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Projeto Felipe Campos Marketing</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
             <style type="text/css">
              div, p, a, li, td { -webkit-text-size-adjust:none; }
             </style>
          </head>
          <body style="margin:0;padding:0;font-family: helvetica;">
            <table width="600" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td style="padding:20px 0 20px 0;" bgcolor="#2d2f3a" align="center">
                  <img style="display:block;" alt="Imagem" src="img/bg-logo.png" />
                </td>
              </tr>
              <tr>
                <td style="padding:20px 20px 20px 20px;">
                  <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td style="border-bottom:2px solid #ccc;padding:30px 0 30px 0;">
                        <span style="color:#888;font-size:22px;">Olá Felipe,</span>
                        <p style="color:#888;font-size:16px;">E-mail gerado do Orçamento | Projeto Felipe Campos</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="padding:20px 20px 20px 20px;">
                  <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="250">
                        <table width="100%" cellpadding="0" cellspacing="0">
                          
                          <tr>
                            <td style="padding:10px 0 10px 0;color:#666;font-size:15px;line-height:21px;">
                              <p>Nome: <b style="color:#2989ce;">'.$POST["nome"].'</b></p>
                              <p>E-mail:<b style="color:#2989ce;"> '.$POST["email"].'</b></p>
                              <p>Telefone: <b style="color:#2989ce;">'.$POST["telefone"].'</b></p>
                              <p>Assunto: <b style="color:#2989ce;">'.$POST["assunto"].'</b></p>
                              <p>Serviço: <b style="color:#2989ce;">'.$POST["servico"].'</b></p>
                            </td>
                          </tr>
                        </table>
                      </td>
                      
                    </tr>
                  </table>
                </td>
              </tr>
              
              <tr>
                <td style="padding:15px 10px 15px 10px;" bgcolor="#2989ce">
                  <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="480" style="color:#FFF;font-size:16px;" align="left">Todos os direitos reservados</td>
                      <td style="font-size:12px;" width="70" align="left"></td>
                      <td style="font-size:16px;" width="30" align="left"><a style="color:#FFF ;text-decoration: none;" target="_blank" href="http://www.projetofelipecampos.com.br">http://www.projetofelipecampos.com.br</a></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </body>
          </html>';    
  
              try{
                  $mailContato->isSMTP(); 
                  $mailContato->Host = MAILERHOST; 
                  $mailContato->SMTPAuth = true;       
                  $mailContato->Username = MAILERUSER; 
                  $mailContato->Password = MAILERPASS;
                  $mailContato->SMTPSecure = 'tls';
                  $mailContato->Port = MAILERPORT; 
                  $mailContato->setFrom(MAILERUSER);
                  $mailContato->addAddress(MAILERUSER);
                  $mailContato->isHTML(true); 
                  $mailContato->Subject = 'Projeto Felipe Campos | Orçamento';
                  $mailContato->Body    = $BodyMail;
                  $mailContato->send();
                  $erro= "<div class=\"accept\">E-mail enviado com sucesso!, $mailContato->ErrorInfo</div>";
              }catch (Exception $e){
              
                  $erro = "<div class=\"warning\">Não foi  possível enviar e-mail!, $mailContato->ErrorInfo</div>";
              }
          endif;
    ?>
    <div class="error-message">
          <?= $erro ?>
    </div>
  <form class="form-full" name="formorcamento" method="post" > 
   <p>
     <span>Seu nome é (obrigatorio)*</span>
     <input type="text" id="nome" placeholder="Informe seu nome" name="nome" required>
   </p>
   <p>
     <span>Seu email é (obrigatorio)*</span>
     <input type="text" name="email" id="email" placeholder="Informe seu email" required>
   </p>
   <p>
     <span>Seu telefone é (obrigatorio)*</span>
     <input type="text" id="tel" name="telefone" placeholder="Informe seu telefone" required>
   </p>

   <p>
     <span>Seu assunto é (obrigatorio)*</span>
     <input type="text" id="assunto" name="assunto" placeholder="Informe seu assunto" required>
   </p>

   <p>
     <span>Tipo de serviço é (obrigatorio)*</span>
     <select name="servico" required="" title="Favor Selecione Seu serviço">
      <option value="">Selecione seu tipo de serviço</option>
      <option value="Assessoria">Acessoria</option>
      <option value="Transportes">Transportes</option>
      <option value="Equipamentos">Equipamentos</option>
      <option value="Limpeza">Limpeza</option>        
    </select>
  </p>
  
  <input class="bottom" name="enviar" type="submit" value="ENVIAR">
</form>
<div class="clear"></div>
</div>

</main>

<footer>
    <?php require './pages/footer.php'; ?>
</footer>

</body>
</html>