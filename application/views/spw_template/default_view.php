<?php 
/*----------------------------------------------------------------------*\
|===============================Spw-Template==============================|
\*----------------------------------------------------------------------*/
header('content-type:text/html; charset=UTF-8');


//===>Load Header_default
$this->load->view("spw_template/default/header_default");




//===>Load corridor Header
if($corridor){$this->load->view("spw_template/laoud/".$corridor."/header_view");} 



?>
<main class="<?=($pageName)? $pageName:'';?><?=($sidebar)? ' with_sidebar':'';?>">
	<?php 
	//===>Load sidebar if is true 
	if($sidebar){$this->load->view("spw_template/default/sidebar_view");} 
	//===>Load page
	?>
	<div class="content_page">
		<?php
		$this->load->view($contents);
		?>
	</div>
	<?php

	?>
</main>
<?php



//===>Load corridor footer
if($corridor){$this->load->view("spw_template/laoud/".$corridor."/footer_view");}






//===>Load Footer_default
$this->load->view("spw_template/default/footer_default");

?>