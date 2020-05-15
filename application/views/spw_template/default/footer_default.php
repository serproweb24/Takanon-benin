
</div>
</body>









<?php 
	//EXISTE
if(isset($_SESSION['message_existe'])){
	$message = $_SESSION['message_existe'];
	echo '<div class="item-alertSession" data-title="Alert: Existe déja!."  data-type="alert" data-session="message_existe">'.
	$message
	.'</div>';
}


//SUCCESS
if(isset($_SESSION['message_success'])){
	$message = $_SESSION['message_success'];
	echo '<div class="item-alertSession" data-title="Success!!!."  data-type="success" data-session="message_success">'.
	$message
	.'</div>';
}

//ERROR
if(isset($_SESSION['message_error'])){
	$message = $_SESSION['message_error'];
	echo '<div class="item-alertSession" data-title="Alert!."  data-type="error" data-session="message_error">'.
	$message
	.'</div>';
}

$refrech = $this->session->refrech;
?>

<!-- Slick Js -->
<script src="<?=base_url().'assets/librairies/slick/slick.1.8.1.min.min.js';?>"></script>

<!-- Validate Form Js-->
<script src="<?=base_url().'assets/librairies/ValidateForme/jquery.validate.min.js';?>"></script>
<script src="<?=base_url().'assets/librairies/ValidateForme/MyscriptsValidateForm.js';?>"></script>

<!-- Masque Input Js-->
<script src="<?=base_url().'assets/librairies/masqueInput/jquery.mask.js';?>"></script>

<!-- Select2 Js-->
<script src="<?=base_url().'assets/librairies/select2/select2.min.js';?>"></script>

<!-- Dropify Js-->
<script src="<?=base_url().'assets/librairies/dropify/js/dropify.min.js';?>"></script>

<!-- Simple-Alert -->
<script src="<?=base_url().'assets/librairies/spw_alert/spw_select.js';?>"></script>

<!-- Default Js -->
<script src="<?=base_url().'assets/js/default.js?v='.$refrech;?>"></script>

<!-- <script Js -->
	<script src="<?=base_url().'assets/js/script.js?v='.$refrech;?>"></script>
	<script src="<?=base_url().'assets/js/paul.js';?>"></script>


	<?php 
	$segment = $this->uri->segment(1);
	
	if(isset($segment)&&in_array($segment, array('clients', 'admin', 'users'))):
		$path__admin_js = base_url().'assets/js/'.$segment.'.js';
	echo '<script src="'.$path__admin_js.'?v='.$refrech.'"></script>';
endif;
?>

<script src="<?=base_url().'assets/js/jules.js';?>"></script>
