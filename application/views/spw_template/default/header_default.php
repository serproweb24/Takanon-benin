<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="<?=isset($pageKeywords)? '- '.$pageKeywords:'';?>">
  <meta name="description" content="<?=isset($pageDescription)? '- '.$pageDescription:'';?>">
  <meta name="author" content="SerProWeb - Kombetto kevin">
  <title>Takanon-benin <?=isset($pageTitle)? '- '.$pageTitle:'';?></title>
  <?php 

  if(!isset($this->session->refrech)): 
    $refrech = 0;
  else:
   $refrech = $this->session->refrech;
   $refrech++;
 endif;
 $this->session->set_userdata('refrech', $refrech);


 ?>
 <!-- Favicon icon -->
 <link rel="shortcut icon" type="image/png" sizes="16x17" href="<?=base_url().'/assets/images/default/favicon.png'?>">

 <!-- My font-->
 <link href="<?=base_url().'assets/css/fonts.css?v='.$refrech?>" rel="stylesheet">

 <!-- Lirairie Jquery -->
 <script src="<?=base_url().'assets/librairies/jquery/jquery.3.4.1.min.js'?>"></script>

 <!-- Bootstrap CSS -->
 <link href="<?=base_url().'assets/librairies/bootstrap/bootstrap.4.3.min.css'?>" rel="stylesheet">

 <!-- font-awesome -->
 <link rel="stylesheet" href="<?=base_url().'assets/librairies/font-awesome-5/css/font-awesome.css';?>">
 <script  src="<?=base_url().'assets/librairies/font-awesome-5/svg-with-js/js/fontawesome-all.js';?>"></script>

 <!-- Slick CSS -->
 <link rel="stylesheet" type="text/css" href="<?=base_url().'assets/librairies/slick/slick.1.8.1.min.css'?>"/>
 <link rel="stylesheet" type="text/css" href="<?=base_url().'assets/librairies/slick/slick-theme.1.8.1.min.css'?>"/>

 <!-- select2 css -->
 <link href="<?=base_url().'/assets/librairies/select2/select2.min.css'?>" rel="stylesheet">

 <!-- Dropify Css-->
 <link rel="stylesheet" type="text/css" href="<?=base_url().'assets/librairies/dropify/css/dropify.min.css';?>"/>

 <!-- Spw-Alert Css-->
 <link rel="stylesheet" type="text/css" href="<?=base_url().'assets/librairies/spw_alert/spw_select.css';?>"/>

 <!-- My style-->
 <link href="<?=base_url().'assets/css/defaut.css?v='.$refrech;?>" rel="stylesheet">
 <link href="<?=base_url().'assets/css/style.css?v='.$refrech;?>" rel="stylesheet">
 <link href="<?=base_url().'assets/css/paul.css'?>" rel="stylesheet">

 <?php 
 $segment = $this->uri->segment(1);
 if(isset($segment)&&in_array($segment, array('clients', 'admin', 'users'))):
  echo '<link href="'.base_url().'assets/css/back-office.css?v='.$refrech.'" rel="stylesheet">';
endif;
/*<link href="<?=base_url().'assets/css/jules_admin.css'?>" rel="stylesheet">
<script src="https://cdn.kkiapay.me/k.js"></script>
*/
?>


</head>
<body>
  <div class="wrapper" id="wrapper">

