<!DOCTYPE html>
<html lang="pt-br">
<head>

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
    
  <!--Metas do site --> 
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1, maximum-scale=1,minimum-scale=1">
  <!--Metas de contato do site-->
  <meta name="geo.region" content="BR-SP" />
  <meta name="geo.position" content="-23.557742;-46.650194" />
  <meta name="ICBM" content="-23.557742, -46.650194" />

  <title>Contato</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/mobile.css">

  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="shortcut icon" href="img/bg-icon.png">

  <script src="https://code.jquery.com/jquery-3.2.1.js"></script>

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

<div class="content">
  <div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.2980246404722!2d-46.65238844908966!3d-23.557737567269186!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce59b5e88c2fa7%3A0x772148c09231ee27!2sR.+Itapeva%2C+56+-+Bela+Vista%2C+S%C3%A3o+Paulo+-+SP!5e0!3m2!1sen!2sbr!4v1513115680047" width="967" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
  </div>
</div>
<main>
  <section class="content">
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
                        <p style="color:#888;font-size:16px;">E-mail gerado do contato | Projeto Felipe Campos</p>
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
                              <p>UF: <b style="color:#2989ce;">'.$POST["UF"].'</b></p>
                              <p>Telefone: <b style="color:#2989ce;">'.$POST["telefone"].'</b></p>
                              <p>Como encontrou: <b style="color:#2989ce;">'.$POST["onde"].'</b></p>
                              <p>Mensagem: <b style="color:#2989ce;">'.$POST["subject"].'</b></p>
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
                  $mailContato->Subject = 'Projeto Felipe Campos';
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
    <form class="form" name="formcontato" method="post" >
      <fieldset class="form_left">
       <label>
         <span>Informe seu Nome:</span>
         <input type="text" placeholder="Nome" name="nome"/>
       </label>
       <label>
         <span>Informe seu Email:</span>
         <input type="text" placeholder="E-mail" name="email"/>
       </label>

        <label>Estado:
          <br>
            <select name="UF" id="UF">
              <option value="AC">Acre</option>
              <option value="AL">Alagoas</option>
              <option value="AP">Amapá</option>
              <option value="AM">Amazonas</option>
              <option value="BA">Bahia</option>
              <option value="CE">Ceará</option>
              <option value="DF">Distrito Federal</option>
              <option value="ES">Espírito Santo</option>
              <option value="GO">Goiás</option>
              <option value="MA">Maranhão</option>
              <option value="MT">Mato Grosso</option>
              <option value="MS">Mato Grosso do Sul</option>
              <option value="MG">Minas Gerais</option>
              <option value="PA">Pará</option>
              <option value="PB">Paraíba</option>
              <option value="PR">Paraná</option>
              <option value="PE">Pernambuco</option>
              <option value="PI">Piauí</option>
              <option value="RJ">Rio de Janeiro</option>
              <option value="RN">Rio Grande do Norte</option>
              <option value="RS">Rio Grande do Sul</option>
              <option value="RO">Rondônia</option>
              <option value="RR">Roraima</option>
              <option value="SC">Santa Catarina</option>
              <option value="SP">São Paulo</option>
              <option value="SE">Sergipe</option>
              <option value="TO">Tocantins</option>
            </select> 
       <label>

           <span>Sobre Qual Assunto Quer Falar:</span>
         <input type="text" placeholder="Assunto" name="assunto"/>
       </label>
       <label>
         <span>Deixe Seu Telefone:</span>
         <input type="text" placeholder="Telefone" name="telefone"/>
       </label>
    <label>
      <span>Como encontrou o Site</span>
      <select name="onde">
        <option value="Google">Google</option>
        <option value="Facebook">Facebook</option>
        <option value="Twitter">Twitter</option>
        <option value="Yahoo">Yahoo</option>
        <option value="Bing">Bing</option>
        <option value="Indicacao">Indicação</option>
      </select>
    </label>
  </fieldset>

     <label>
      <span>Fala Aqui:</span>
      <textarea name="subject" rows="8" placeholder="Escreva Sua Mensagem:"></textarea>
    </label>
    
    <div class="form_action">
      <input class="btn first" type="reset" value="Limpar Dados"/>
      <input class="btn" name="enviar" type="submit" value="Enviar Dados">
    </div>
  </form>

  <div class="clear"></div>
</section><!--fim da content-->
</main><!--fim da main-->

<footer>
    <?php require './pages/footer.php'; ?>
</footer>



<script src="js/menu.js"></script>
</body>
</html>
