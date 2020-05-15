<div class="documents_body page">

	<div class="face-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="face-page-content">
						<h1 class="h1 title-page">
							<span><?=(isset($pageTitle)? $pageTitle:'');?></span>
						</h1>
						<img src="<?=base_url().'assets/images/default/img-3.png' ?>" class="face-page-img" alt="image tackanon">
					</div>
				</div>
			</div>
		</div>
	</div>




	<div class="documents_block pBlock">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="documents_block-content">
						<h2 class="h2"><span>Tous les documents sur <strong>TACKANON</strong></span></h2>
						<?php 
						//var_dump($_SESSION);
						?>
						<div class="documents_block-body">
							<div class="documents_block-body-sidebar">
								<div class="face-search">
									<div class="face-search-content">
										<div class="face-search-title">Recheche</div>
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
							<div class="documents_block-body-content">
								<div class="documents_block-body-head hidden">
									<div class="documents_block-body-head-left">
										<div class="i-form-row">
											<div class="i-placeholder">Filtrer</div>
											<select name="filtre">
												<option value="">Par prix</option>
												<option value="">Par niveau</option>
												<option value="">Par matiere</option>
												<option value="">Par année</option>
											</select>
										</div>
									</div>
								</div>
								<?php 
								
								if($articles):
									?>
									<ul class="documents_block-body-list i-document-list">
										<?php 
										foreach($articles as $article):
											$idArt = $article->idArt;
											$libArt = $article->libArt;
											$prixArt = $article->prix;
											$idUseArt = $article->idUseArt;
											$descArt = (!empty($article->description))? $article->description:'<small>Sans description.</small>';

											//Auteur
											$autors = $this->spw_model->get_rows('users', array('idUse'=>$idUseArt));
											foreach($autors as $autor):
												$identiteAutor = $autor->nom.' '.$autor->prenoms;
											endforeach;

											?>
											<li class="i-document-list-item">
												<a href="#PreviewDoc" class="js-open-poPup js-transfer_data" data-infos="<?= $idArt."@@".$libArt."@@".$prixArt."F@@".$descArt."@@".$identiteAutor;?>">
													<div class="i-document-list-item-img">
														<img src="<?=base_url().'assets/images/default/img-document.png' ?>" alt="document tackanon">
													</div>
													<span class="i-document-list-item-name">
														<?=$libArt;?>
													</span>
													<span class="i-document-list-item-price">
														<?=number_format($prixArt, 0, ',', ' ').'F'; ?>
													</span>
												</a>
											</li>
											<?php 
										endforeach;
										?>
									</ul>
									<?php 
									echo $pgt_nav;
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
	</div>


</div>