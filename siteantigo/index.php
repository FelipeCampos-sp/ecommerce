<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>HOME</title>
  
    <!-- metas da pagina da pagina --> 
    <meta name="language" content="Portuguese">
    <meta name="generator" content="N/A">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta itemprop="url" content="https://projetofelipecampos.com.br/"/>
      
    <!-- fim das metas da pagina do site--> 
   
    <!-- metas das pagínas do google -->
    <meta name="description" content="A melhor coleta de lixo e reciclagem para o Brail">
    <meta name="keywords" content="">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="1 day"> 
      
      
    <!-- fim das metas das pagínas do google-->
      
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
    
    <link rel="canonical" href="https://projetofelipecampos.com.br/">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mobile.css">
    <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1, maximum-scale=1,minimum-scale=1">
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


	<div class="slideshow">
            <?php require './pages/slide.php'; ?>
	</div>



	<main>  
          <section class="content box-index-master">
            <article class="box-index">
               <article class="box-meio">
               	
               	<aricle class="box-meio-item">
               	 <img class="imagem-home" src="img/bg-32.jpg">       
                  <h1>A Rcl Brasil</h1>
                  <p>
                    A Rcl Brasil é uma empresa fundada em 2018 com a finalidade de oferecer serviços de qualidade para reciclagem de lixo, e transformar os resíduos em plásticos, metais,papeis e vidros e principalmente reduzir a emissão de gás tóxico e poluição.
                  </p> 
               	</aricle>

               	<aricle class="box-meio-item">
               	  <img class="imagem-home" src="img/bg-33.png">
               	  <h1>Você já regularizou os resíduos perigosos de uma coleta de lixo</h1>	
               	  <p>
               	  	É muito importante você separar os resíduos perigosos de uma coleta de lixo para 
               	  	não prejudicar o meio ambiente e preservar a sustentabilidade 
               	  </p>
               	</aricle>
              
               </article>
		
            </article>
		</section><!--end section-->



		<section class="content">
			<h1 class="title-home">Nossos serviços</h1>
			<article class="nossos-servicos">
				<article class="nossos-servicos__box">
					<h1>Consultoria ambiental</h1>
					<img class="img-servico" alt="imagem serviços" title="serviços" src="img/bg-1-home.png">             
				</article>

				<article class="nossos-servicos__box">
					<h1>Gerenciamento de resíduos</h1>
					<img class="img-servico" src="img/bg-2-home.png" title="Gerenciamento de serviços" alt="imagem serviços">
				</article>

				<article class="nossos-servicos__box">
					<h1>Processo de limpeza</h1>
					<img class="img-servico" src="img/bg-3-home.png" title="processo de limpeza" alt="limpeza">
				</article>

				<article class="nossos-servicos__box">
					<h1>Equipamentos da empresa</h1>
					<img class="img-servico" src="img/bg-4--home.png" title="Equipamentos da empresa" alt="empresa">
				</article>
			</article>
			<div class="clear"></div>  
		</section><!--fim da section-->
	</main><!--end main-->

	<footer>       
            <?php require './pages/footer.php'; ?>  
       </footer>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/menu.js"></script>

</body>
</html>