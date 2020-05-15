<div class="cli-page">
<?php //var_dump($_SESSION); ?>
	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-home"></i>
				<span class="text">Accueil</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
		</nav>
	</div>

	<div class="cli-page-body">
		<?php 

//var_dump($_SESSION);
	//echo $this->session->user_connected['idGrpUti'];

		?>
		<section class="cli-page-section">
			<div class="cli-page-section-title">
				<span>
					Bienvenue Sur <strong>Takkanon</strong> 
				</span>
				<span class="alert-exist-panier">
					<?php 
					if($this->cart->contents()):
						echo 'Vous avez un panier encours! <a href="'.base_url().'panier">Aller au panier</a>';
					endif;
					?>
				</span>
			</div>
			<div class="cli-page-section-content">
				<div class="">
					<img src="<?=base_url().'assets/images/background/bg-contest2.png';?> " alt="logo takanon">
				</div>
			</div>
		</section>
	</div>
</div>