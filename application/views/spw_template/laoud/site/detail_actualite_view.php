<div class="detail_actualite_body page">

	<div class="face-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="face-page-content">
						<h1 class="h1 title-page">
							<span><?=(isset($pageTitle)? $pageTitle:'');?></span>
						</h1>
						<img src="<?=base_url().'assets/images/default/img-3.png' ?>" class="face-page-img" alt="image takanon">
					</div>
				</div>
			</div>
		</div>
	</div>




	<div class="detail_actualite_block pBlock">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="detail_actualite_block-content">
						<h2 class="h2"><span><?=(isset($titleArt)? $titleArt:'Detail actualité');?> </span></h2>

						<section class="detail_actualite_block-content-section">
							<div class="activeArt">
								<div class="img">
									<img src="<?=base_url().'assets/images/actualites/'.$artAffiche;?>" alt="<?=(isset($titleArt)? $titleArt:'image tackanon');?>">
								</div>
								<div class="text">
									<?=$descriptionArt;?>
								</div>
							</div>
						</section>

						<section class="last3Art">
							<h2 class="h2"><span>Lire aussi:</span></h2>
							<?php 
							if($lastActualites):
								?>
								<div class="last3Art-list">
									<?php 
									foreach($lastActualites as $lastActualite):
										$idAutreArt = $lastActualite->idAct;
										$afficheAutreArt = $lastActualite->affiche;
										$libAutreArt = $lastActualite->libAct;
										$dateAutreArt = $lastActualite->dateCreate;
										$descriptionAutreArt = $lastActualite->description
										?>
										<div class="last3Art-list-item">
											<a href="<?=base_url().'actualites/selection/'.cripterId($idAutreArt,0) ?>">
												<span class="img">
													<img src="<?=base_url().'assets/images/actualites/'.$afficheAutreArt;?>" alt="<?=(isset($libAutreArt)? $libAutreArt:'image tackanon');?>">
												</span>
												<span class="title">
													<?=$libAutreArt;?>
												</span>
												<span class="text">
													<?=recupererDebutTexte ($descriptionAutreArt, 150);?>
												</span>
											</a>
										</div>
										<?php 
									endforeach;
									?>
								</div>
								<?php 
							endif;
							?>
						</section>

					</div>
				</div>
			</div>
		</div>
	</div>



</div>