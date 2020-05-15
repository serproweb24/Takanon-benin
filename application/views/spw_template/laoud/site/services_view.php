<div class="services_body">

	<div class="face-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="face-page-content">
						<h1 class="h1 title-page">
							<span><?=(isset($pageTitle)? $pageTitle:'');?></span>
						</h1>
						<img src="<?=base_url().'assets/images/default/img-3.png' ?>" class="face-page-img" alt="image Takanon-benin">
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="services_block">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="services_block-content">
						<h2 class="h2"><span>Nos services</span></h2>

						<ul class="services_block-list briq_block-list">
							<li class="briq_block-list-item">
								<span class="icon">
									<img src="<?=base_url().'assets/images/icons/icon-student.png' ?> " alt="élève Takanon-benin">
								</span>
								<span class="name">Vente d'épreuves et / ou corrections</span>
							</li>
							<li class="briq_block-list-item">
								<span class="icon">
									<img src="<?=base_url().'assets/images/icons/icon-student.png' ?> " alt="élève Takanon-benin">
								</span>
								<span class="name">Vente de fournitures scolaires</span>
							</li>
							<li class="briq_block-list-item">
								<span class="icon">
									<img src="<?=base_url().'assets/images/icons/icon-student.png' ?> " alt="élève Takanon-benin">
								</span>
								<span class="name">Proposition de  répétiteurs</span>
							</li>
							<li class="briq_block-list-item">
								<span class="icon">
									<img src="<?=base_url().'assets/images/icons/icon-student.png' ?> " alt="élève Takanon-benin">
								</span>
								<span class="name">Promotion de l'excellence</span>
							</li>
							<li class="briq_block-list-item">
								<span class="icon">
									<img src="<?=base_url().'assets/images/icons/icon-student.png' ?> " alt="élève Takanon-benin">
								</span>
								<span class="name">Communication scolaire</span>
							</li>
							<li class="briq_block-list-item">
								<span class="icon">
									<img src="<?=base_url().'assets/images/icons/icon-student.png' ?> " alt="élève Takanon-benin">
								</span>
								<span class="name">Jeux / Concours</span>
							</li>
							

						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="last_offers">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="last_offers-content">
						<h2 class="h2 last_offers-title">
							<span class="text">Les derniers posts</span>
						</h2>
						<?php 
						if($listPosts):
							?>
							<ul class="last_offers-list">
								<?php 
								echo $listPosts;
								?>
							</ul>
							<div class="last_offers-content-bottom text-center">
								<a href="<?=base_url().'documents' ?>" class="false-btn blue">Voir tous les posts</a>
							</div>
							<?php 
						else:
							echo '<div class="i-alert_empty ">Bientôt disponible !!!</div>';
						endif;
						?>
						
					</div>
				</div>
			</div>
		</div>
	</div>

</div>