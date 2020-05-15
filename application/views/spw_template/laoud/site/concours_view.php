<div class="concours_body">

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




	<div class="concours_block">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="services_block-content">
						<h2 class="h2"><span>Tous les concours <strong>Takanon-benin</strong></span></h2>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="contest">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="contest-content">
						<div class="contest_block">
							<div class="contest_block-head">
								<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
								<h2 class="contest_block-title">Jeux - Concours</h2>
							</div>
							<?php 
							$totalCC_encours = countConcourByPeriode(array('concours.dateStart <='=>$maintenant, 'concours.dateEnd >='=>$maintenant));
							?>
							<div class="contest_block-body <?=($totalCC_encours>0)? 'active':'';?>">
								<div class="contest_block-timer">
									<span><?=($totalCC_encours>0)? '<a href="#" class="js-go_to_concours">'.$totalCC_encours.'</a>':'?';?></span>
								</div>
							</div>
							<div class="contest_block-row">
								<span class="contest_block-row-text">
									<?=($totalCC_encours>0)? '<a href="#" class="text-green js-go_to_concours">Encours</a>':'Bientôt disponible';?>
								</span>
							</div>
						</div>

						<img src="<?=base_url().'assets/images/default/img-1.png' ?>" class="img-concour" alt="concours Takanon-benin">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="seo">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="seo-content">
						<h2 class="h2">
							<span class="text">Takanon-benin, courcours pour tous.</span>
						</h2>
						<div class="seo-text">
							<p>
								Votre fidélité sur Takanon-benin est récompensée grâce au concours Super apprenant organisé sur la plateforme. Le principe est simple, chaque mois, un nouveau défi est mis en ligne. Chaque défi remporté vous donne droit à un crédit Takanon-benin. A la fin de l’année, les 5 personnes ayant reçu le plus de crédit Takanon-benin se verront attribués des gros lots et codes de téléchargements gratuits.
							</p>
						</div>
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