<div class="cli-page cli-repetiteurs">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-paperclip"></i>
				<span class="text">Répétiteur</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">

		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			<div class="cli-page-section-title">
				<span>Liste de tous les Répétiteurs</span>
			</div>
			<div class="cli-page-section-content   cli_with-sidebar">
				<div class="cli-page-body-sidebar">
					<div class="cli-page-body-sidebar-menu">
						<ul class="cli-page-body-sidebar-menu-list big">
							<li>
								<a href="<?=base_url().'admin/repetiteurs';?>" class="<?=(!isset($idCatNivActive))? 'active':'';?>">Toutes les Niveaux</a>
							</li>
							<?php 
							if($categorieNiveaux):
								foreach($categorieNiveaux as $categorieNiveau):
									$idCatNiv = $categorieNiveau->idCatNiv;
									$countTotalRepetiteur = infos_repetiteurs(array('idCatNiv'=>$idCatNiv),true);
									$countAttenteRepetiteur = infos_repetiteurs(array('idCatNiv'=>$idCatNiv,'statut'=>1),true);
									?>
									<li>
										<a href="<?=base_url().'admin/repetiteurs?cat='.$idCatNiv;?>" class="<?=(isset($idCatNivActive)&&$idCatNivActive==$idCatNiv)? 'active':'';?>">
											<?=$categorieNiveau->libCatNiv;?>
											<span class="i-num"><?=number_format($countAttenteRepetiteur, 0, ',', ' ').' / '.number_format($countTotalRepetiteur, 0, ',', ' ')?></span>
										</a>
									</li>
									<?php 
								endforeach;
							endif;
							?>
						</ul>
					</div>

					<div class="cli-page-body-sidebar-menu">
						<ul class="cli-page-body-sidebar-menu-list">
							<?php 
							$ActiveCat = (isset($idCatNivActive))? '?cat='.$idCatNivActive.'&':'?';
							?>
							<li><a href="<?=base_url().'admin/repetiteurs'.$ActiveCat;?>" class="<?=(!isset($statutRep))? 'active':'';?>">Tous</a></li>
							<li><a href="<?=base_url().'admin/repetiteurs'.$ActiveCat.'sta=2';?>" class="<?=(isset($statutRep)&&$statutRep==2)? 'active':'';?>">Actifs</a></li>
							<li><a href="<?=base_url().'admin/repetiteurs'.$ActiveCat.'sta=3';?>" class="<?=(isset($statutRep)&&$statutRep==3)? 'active':'';?>">Suspendus</a></li>
							<li><a href="<?=base_url().'admin/repetiteurs'.$ActiveCat.'sta=0';?>" class="<?=(isset($statutRep)&&$statutRep==0)? 'active':'';?>">Bloqués</a></li>
						</ul>
					</div>

				</div>

				<div class="cli-page-body-main">
					<div class="cli-page-body-main-content">
						
						<?php 
						if($repetiteurs):
							?>
							<div class="i-plaque-list">
								<?php 
								foreach($repetiteurs as $repetiteur):
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


									if($statut==0):
										$statutText ='Bloqué';
										$statutClass = 'bloquer';
									elseif($statut==1):
										$statutText ='En attente';
										$statutClass = '';
									elseif($statut==2):
										$statutText ='Publié';
										$statutClass = 'actif';
									elseif($statut==3):
										$statutText ='Regeté';
										$statutClass = 'rejeter';
									elseif($statut==4):
										$statutText ='Désactivé';
										$statutClass = 'desactiver';
									endif;

									?>
									<div class="i-plaque-list-item js-open-context-menu">
										<a href="#">
											<span class="img">
												<img src="<?=base_url().'assets/images/users/'.$avatar;?>" alt="abonné takanon">
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
												<span class="i-statut small text-center <?=(isset($statutClass))? $statutClass:'';?>">
													<?=(isset($statutText))? $statutText:'';?>
												</span>
											</span>
										</a>
										<ul class="js-contextMenuList">
											<?php if($statut!=2): ?>
												<li>
													<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-green'>Activation de répétiteur</span>" data-infos="<?=$idRep."@@".$Repetiteur."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-green'>Valider</mark> 
														le répétiteur :  <strong><?=$Repetiteur;?></strong> ?" data-objet="false"  data-type="Activer-repetiteurs">
														<i class="fas fa-check"></i>
														<span>Activer</span>
													</a>
												</li>
											<?php endif;?>

											<?php if($statut!=3&&$statut!=0): ?>
												<li>
													<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-orange'>Reget de répétiteur</span>" data-infos="<?=$idRep."@@".$Repetiteur."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-orange'>Regeter</mark> 
														le répétiteur :  <strong><?=$Repetiteur;?></strong> ?" data-objet="true" data-type="Regeter-repetiteurs">

														<i class="fas fa-undo"></i>
														<span>Regeter</span>

													</a>
												</li>
											<?php endif;?>

											<?php if($statut!=0): ?>
												<li>
													<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-red'>Bloquage de répétiteur</span>" data-infos="<?=$idRep."@@".$Repetiteur."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-red'>Bloquer</mark> 
														le répétiteur :  <strong><?=$Repetiteur;?></strong> ?" data-objet="true"  data-type="Bloquer-repetiteurs">
														<i class="fas fa-ban"></i>
														<span>Fermer</span>
													</a>
												</li>
											<?php endif;?>
										</ul>

										<?php 
										//Verification de tiquet ouvert
										$idTicReg = false;
										$existTicke = existTicket($idRep,'repetiteurs',$type=true);
										if($existTicke):
											$idTicReg = $existTicke->idTicReg;
											$statutTicReg = $existTicke->statutTicReg;
										endif;


										//Commentaires en attentes
										$CountNewAlertArt = CountnewTicketReget($idTicReg,2);
										?>

										<?php if($existTicke): ?>
											<a href="<?=base_url().'admin/ticket_regets?tck='.cripterId($idTicReg,0);?>" class="i-notif"   title="Motif">
												<i class="fas fa-bell"></i>
												<small class="i-notNum"><?=$CountNewAlertArt;?></small>
											</a>
										<?php endif; ?>
										
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
		</section>
	</div>




</div>