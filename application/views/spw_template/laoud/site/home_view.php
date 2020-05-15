<div class="home_body">

	<div class="face">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="face_content">
						<div class="face-baner">
							<?php 
							if($actualites):
								?>
								<div class="face-slider-baner-slider js-slick-1">
									<?php
									foreach($actualites as $actualite):
										?>
										<div class="face-slider-baner-slider-item">
											<div class="face-slider-baner-slider-item-img">
												<img src="<?=base_url().'assets/images/actualites/'.$actualite->affiche;?>" class="img-normal" alt="image Takanon-benin">
												<img src="<?=base_url().'assets/images/baner/img1.jpg' ?> " class="img-big" alt="image Takanon-benin">
											</div>
											<div class="face-slider-baner-slider-item_infos">
												<h1 class="h1 face-slider-baner-slider-item-title">
													<span class="text"><?=$actualite->libAct;?></span>
												</h1>
												<div class="face-slider-baner-slider-item-text">
													<?=recupererDebutTexte ($actualite->description, 250);?>
												</div>
												<div class="face-slider-baner-slider-item-class">
													<a href="<?=base_url().'actualites/selection/'.cripterId($actualite->idAct,0) ?>" class="face-slider-baner-slider-item-btn false-btn blue">En savoir plus</a>
												</div>
											</div>
										</div>
										<?php 
									endforeach;
									?>
								</div>
								<?php
							else:
								?>
								<div class="face-slider-baner-slider js-slick-1">
									<div class="face-slider-baner-slider-item">
										<div class="face-slider-baner-slider-item-img">
											<img src="<?=base_url().'assets/images/baner/img1.jpg' ?> " class="img-normal" alt="image Takanon-benin">
											<img src="<?=base_url().'assets/images/baner/img1b.jpg' ?> " class="img-big" alt="image Takanon-benin">
										</div>
										<div class="face-slider-baner-slider-item_infos">
											<h1 class="h1 face-slider-baner-slider-item-title">
												<span class="text">Bienvenue sur Takanon-benin</span>
											</h1>
											<div class="face-slider-baner-slider-item-text">
												Nouvelle plateforme de promotion de l'excellence en afrique dans le secteur éducatif. 
												Profitez dès-à présent de nos offres  en vous inscrivant dans la seconde sur le site Takanon-benin. Que vous soyez intéressez par des épreuves, des livres ou même des professeurs, c’est le moment de profiter de l’attachement que nous portons à votre réussite.
											</div>
											<div class="face-slider-baner-slider-item-class">
												<a href="#register" class="face-slider-baner-slider-item-btn false-btn blue js-open-poPup">Créer un compte</a>
											</div>
										</div>
									</div>
								</div>
								<?php 
							endif;
							?>

						</div>
						<div class="face-search">
							<div class="face-search-content">
								<div class="face-search-title">Recherche</div>
								<form method="POST" class="js-ctr-CatNiv" id="searchArticlesForm">
									<div class="i-form-row">
										<div class="i-placeholder">Categorie</div>
										<select name="ideCart" class="i-select2 js-ctr-Cat js-GetSelect" data-lib="cat">
											<option value="">---- Choisir une catégorie ----</option>
											<?=(isset($optionCategorieArt))? $optionCategorieArt:'';?>
										</select>
									</div>
									<div class="i-form-row">
										<div class="i-placeholder">Niveau</div>
										<select name="ideNiv" class="i-select2 js-ctr-Niv js-GetSelect" data-lib="niv">
											<option  value="">---- Choisir le niveau ----</option>
										</select>
									</div>
									<div class="i-form-row">
										<div class="i-placeholder">Matiere</div>
										<select name="ideMat" class="i-select2 js-ctr-Mat js-GetSelect" data-lib="mat">
											<option value="">---- Choisir une matiere ----</option>
											<?=(isset($optionMatieres))? $optionMatieres:'';?>
										</select>
									</div>
									<div class="i-form-row">
										<div class="i-placeholder">Année</div>
										<select name="ideAnn" class="i-select2 js-ctr-Ann js-GetSelect" data-lib="ann">
											<option>Choisir une année</option>
											<option value="">---- Choisir une année ----</option>
											<?=(isset($optionAnnees))? $optionAnnees:'';?>
										</select>
									</div>
									<div class="i-form-bootom">
										<button class="btn-form" name="searchArticlesBtn">Trouver</button>
									</div>
								</form>
							</div>
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

	<div class="availability">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="availability-content">
						<h2 class="h2">
							<span class="text">Nos disponibilités</span>
						</h2>
						<ul class="availability-list">
							<li class="availability-list-item">
								<span class="availability-list-item-icon">Ex</span>
								<div class="availability-list-item-row">
									<span class="availability-list-item-name">
										Examens
									</span>
									<span class="availability-list-item-nber"><?=number_format($total___examens, 0, ',', ' ');?></span>
								</div>
								<a href="<?=base_url().'documents' ?>" class="availability-list-item-link i-link">Voir tout</a>
							</li>
							<li class="availability-list-item">
								<span class="availability-list-item-icon">Co</span>
								<div class="availability-list-item-row">
									<span class="availability-list-item-name">
										Cours
									</span>
									<span class="availability-list-item-nber"><?=number_format($total___cours, 0, ',', ' ');?></span>
								</div>
								<a href="<?=base_url().'documents' ?>" class="availability-list-item-link i-link">Voir tout</a>
							</li>
							<li class="availability-list-item">
								<span class="availability-list-item-icon">N-C</span>
								<div class="availability-list-item-row">
									<span class="availability-list-item-name">
										Nos Concours 
									</span>
									<span class="availability-list-item-nber">0</span>
								</div>
								<a href="<?=base_url().'concours' ?>" class="availability-list-item-link i-link">Voir tout</a>
							</li>
							<li class="availability-list-item">
								<span class="availability-list-item-icon">Bo</span>
								<div class="availability-list-item-row">
									<span class="availability-list-item-name">
										Bourses
									</span>
									<span class="availability-list-item-nber">0</span>
								</div>
								<a href="<?=base_url().'documents' ?>" class="availability-list-item-link i-link">Voir tout</a>
							</li>
							<li class="availability-list-item">
								<span class="availability-list-item-icon">Fo</span>
								<div class="availability-list-item-row">
									<span class="availability-list-item-name">
										Epreuves
									</span>
									<span class="availability-list-item-nber"><?=number_format($total___epreuves, 0, ',', ' ');?></span>
								</div>
								<a href="<?=base_url().'documents' ?>" class="availability-list-item-link i-link">Voir tout</a>
							</li>
							<li class="availability-list-item">
								<span class="availability-list-item-icon">Re</span>
								<div class="availability-list-item-row">
									<span class="availability-list-item-name">
										Répétiteurs
									</span>
									<span class="availability-list-item-nber"><?=number_format($total___repetiteurs, 0, ',', ' ');?></span>
								</div>
								<a href="<?=base_url().'repetiteurs' ?>" class="availability-list-item-link i-link">Voir tout</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="collaborator">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="collaborator-content">
						<h2 class="h2">
							<span class="text">Nos différents collaborateurs</span>
						</h2>
						<div class="collaborator-prensentation">
							Dans le souci d'optimiser et d'accroître les rendements aux différents examens nous avons mis à disposition cette plateforme qui réunit les acteurs suivants:
						</div>
					</div>
					<ul class="collaborator-list">
						<li class="collaborator-list-item">
							<a href="#">
								<span class="collaborator-list-item-icon">
									<img src="<?=base_url().'assets/images/icons/icon-student.png' ?> " alt="élève Takanon-benin">
								</span>
								<span class="collaborator-list-item-name">Elèves</span>
							</a>
						</li>
						<li class="collaborator-list-item">
							<a href="#">
								<span class="collaborator-list-item-icon">
									<img src="<?=base_url().'assets/images/icons/icon-student2.png' ?> " alt="élève Takanon-benin">
								</span>
								<span class="collaborator-list-item-name">Etudiants</span>
							</a>
						</li>
						<li class="collaborator-list-item">
							<a href="#">
								<span class="collaborator-list-item-icon">
									<img src="<?=base_url().'assets/images/icons/icon-teacher.png' ?> " alt="élève Takanon-benin">
								</span>
								<span class="collaborator-list-item-name">Enseignants</span>
							</a>
						</li>
						<li class="collaborator-list-item">
							<a href="#">
								<span class="collaborator-list-item-icon">
									<img src="<?=base_url().'assets/images/icons/icon-librairie.png' ?> " alt="élève Takanon-benin">
								</span>
								<span class="collaborator-list-item-name">Librairies</span>
							</a>
						</li>
						<li class="collaborator-list-item">
							<a href="#">
								<span class="collaborator-list-item-icon">
									<img src="<?=base_url().'assets/images/icons/icon-mark.png' ?> " alt="élève Takanon-benin">
								</span>
								<span class="collaborator-list-item-name">Marques</span>
							</a>
						</li>
					</ul>
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
							<span class="text">Takanon-benin, toute la réussite académique en une adresse</span>
						</h2>
						<div class="seo-text">
							<p>
								Réussir son parcours académique n’est pas du tout l’apanage de l’apprenant qui n’est pas du tout préparé. Il faut pour passer ce cap important un cocktail préparatoire dont Takanon-benin vous livre ici les secrets. Géré par une équipe qui souhaite favoriser le partage de ressources pédagogiques, ce site a pour but de vous apporter de l'aide dans l'épreuve que constitue le cursus académique. Les différentes rubriques du site vous donneront toutes les ficelles pour bien réviser et réussir votre année.
							</p>
							<p>
								Entre épreuves et corrigés types, cours, livres, mémoires, opportunités de formation et de bourses d’études, vous trouvez ici les armes pour réussir votre parcours académique. Quel que soit votre université et ou votre école, vous trouverez ici un condensé d’épreuves pouvant vous permettre de réussir brillamment vos examens et concours.
							</p>
							<p>
								Et pour récompenser votre fidélité, nous récompensons les plus actifs à travers des concours organisés de façon périodique. Alors qu’attendez-vous pour réussir ? 
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>




<!--========================  poPup  ========================--> 

