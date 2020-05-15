<div class="actualites_body">

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


	<div class="actualites_block">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="services_block-content">
						<h2 class="h2"><span>Toutes les actualités sur <strong>Takanon-benin</strong></span></h2>

						
						<?php 
						if($listeActualites):
							?>
							<ul class="actualites_block-list ">
								<?php 
								foreach($listeActualites as $actualite):
									$afficheArt = $actualite->affiche;
									$idAct = $actualite->idAct;
									if(isset($afficheArt)&&!empty($afficheArt)&&$afficheArt!='error'):
										$affiche = $afficheArt;
									else:
										$affiche = 'default.jpg';
									endif;
									
									?>
									<li class="actualites_block-list-item">
										<a href="<?=base_url().'actualites/selection/'.cripterId($idAct,0) ?>">
											<div class="img">
												<img src="<?=base_url().'assets/images/actualites/'.$affiche;?>" alt="<?="image ".$actualite->libAct;?>">
											</div>
											<div class="infos">
												<div class="date">
													<?='Le '.date('d-m-Y à H:i', strtotime($actualite->dateCreate));?>
												</div>
												<div class="title">
													<?=$actualite->libAct;?>
												</div>
												<div class="text">
													<?=recupererDebutTexte ($actualite->description, 250);?>
												</div>
											</div>
										</a>
									</li>
									<?php 
								endforeach;
								?>
							</ul>
							<?php
							echo $pgt_nav;  
						else:
							echo '<div class="i-alert_empty ">Aucune information disponible !!!</div>';
						endif;
						?>
						
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