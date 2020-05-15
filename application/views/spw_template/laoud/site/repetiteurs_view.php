<div class="repetiteur_body">

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


	<div class="repetiteur_block pBlock">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="documents_block-content">
						<h2 class="h2"><span>Tous les répétiteurs disponibles sur <strong>TACKANON</strong></span></h2>
						<div class="documents_block-body">
							<div class="documents_block-body-sidebar">
								<div class="face-search">
									<div class="face-search-content">
										<div class="face-search-title">Recheche</div>
										<form method="POST">
											<div class="i-form-row">
												<div class="i-placeholder">Niveau</div>
												<select name="ideCart" class="i-select2">
													<option>Choisir le niveau</option>
												</select>
											</div>
											<div class="i-form-row">
												<div class="i-placeholder">Matiere</div>
												<select name="ideCart" class="i-select2">
													<option>Choisir une matiere</option>
												</select>
											</div>
											<div class="i-form-bootom">
												<button class="btn-form">Trouver</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="documents_block-body-content">
								<?php 
								if($repetiteursActualites):
									?>
									<div class="i-plaque-list">
										<?php

										foreach($repetiteursActualites as $repetiteur):
											$idRep = $repetiteur->idRep;
											$statut = $repetiteur->statutRep;
											$telephone = $repetiteur->telephone;
											$email = $repetiteur->email;
											$adresse = $repetiteur->adresse;
											$Repetiteur = $repetiteur->nom.' '.$repetiteur->prenoms;

											if(isset($repetiteur->avatar)&&!empty($repetiteur->avatar)):
												$avatar = $repetiteur->avatar;
											else:
												$avatar = 'default.jpg';
											endif;

											$as ="*";
											$lien = 'repetiteurs_offres.idMat = matieres.idMat';
											$matieres = $this->spw_model->get_Double_Table('repetiteurs_offres','matieres',$as,$lien,array('repetiteurs_offres.idRep'=>$idRep),'matieres.libMat','Asc');

											?>
											<div class="i-plaque-list-item">
												<a href="#">
													<span class="img">
														<img src="<?=base_url().'assets/images/users/'.$avatar;?>" alt="abonné Takanon-benin">
													</span>
													<span class="infos">
														<span class="lib"><?=$Repetiteur;?></span>
														<?php 
														if(isset($telephone)&&!empty($telephone)):
															?>
															<span class="i-cons-phone min">
																<?=$telephone;?>
															</span>
															<?php 
														endif;
														if(isset($email)&&!empty($email)):
															?>
															<span class="i-cons-email min">
																<?=$email;?>
															</span>
															<?php 
														endif;
														if(isset($adresse)&&!empty($adresse)):
															?>
															<span class="i-cons-adresse min">
																<?=$adresse;?>
															</span>
															<?php 
														endif;
														?>
														<span class="cat">
															Cours <?=$repetiteur->libCatNiv;?>
														</span>
														<span class="mat">
															<strong>Matieres:</strong> 
															<ul>
																<?php 
																if($matieres):
																	foreach($matieres as $matiere):
																		?>
																		<li>- <?=$matiere->libMat;?></li>
																		<?php 
																	endforeach;
																else:
																	?>
																	<li><small>Non définit</small></li>
																	<?php
																endif;
																?>
															</ul>
														</span>

													</span>
												</a>
											</div>
											<?php
										endforeach; 

										?>
									</div>
									<?php
									echo $pgt_nav; 
								else:
									echo '<div class="i-alert_empty">Désolé, auccune information disponible !!!</div>';
								endif;
								?>
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

</div>