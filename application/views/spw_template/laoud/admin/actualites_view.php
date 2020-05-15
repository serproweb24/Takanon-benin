<div class="cli-page cli-actualites">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-bullhorn"></i>
				<span class="text">Actualités</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">

		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			
			<div class="cli-page-section-content   cli_with-sidebar">
				<div class="cli-page-body-sidebar">
					<div class="cli-page-body-sidebar-menu">
						<ul class="cli-page-body-sidebar-menu-list big">
							<li><a href="<?=base_url().'admin/actualites';?>" class="<?=(!isset($idActCatActive))? 'active':'';?>">Toutes les filiales</a></li>
							<?php 
							if($listCategorieActs):
								foreach($listCategorieActs as $listCategorieAct):
									$idActCat = $listCategorieAct->idActCat;

									$countActEnAttente = infos_actualites(array('idActCat'=>$idActCat,'statut'=>1),true);
									$countAllAct = infos_actualites(array('idActCat'=>$idActCat),true);  
									?>

									<li>
										<a href="<?=base_url().'admin/actualites?cat='.$idActCat;?>" class="<?=(isset($idActCatActive)&&$idActCatActive==$idActCat)? 'active':'';?>">
											<?=$listCategorieAct->libActCat;?>
											<span class="i-num"><?=number_format($countActEnAttente, 0, ',', ' ').' / '.number_format($countAllAct, 0, ',', ' ') ?></span>
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
							$ActiveCat = (isset($idActCatActive))? '?cat='.$idActCatActive.'&':'?';
							?>
							<li>
								<a href="<?=base_url().'admin/actualites'.$ActiveCat;?>" class="<?=(!isset($statutArt))? 'active':'';?>">Tous</a></li>
								<li>

									<a href="<?=base_url().'admin/actualites'.$ActiveCat.'sta=1';?>" class="<?=(isset($statutArt)&&$statutArt==1)? 'active':'';?>">
										En attentes

									</a>
								</li>
								<li>
									<a href="<?=base_url().'admin/actualites'.$ActiveCat.'sta=2';?>" class="<?=(isset($statutArt)&&$statutArt==2)? 'active':'';?>">
										Actifs
									</a>
								</li>
								<li>
									<a href="<?=base_url().'admin/actualites'.$ActiveCat.'sta=3';?>" class="<?=(isset($statutArt)&&$statutArt==3)? 'active':'';?>">Suspendus
									</a>
								</li>
								<li>
									<a href="<?=base_url().'admin/actualites'.$ActiveCat.'sta=0';?>" class="<?=(isset($statutArt)&&$statutArt==0)? 'active':'';?>">
										Bloqués
									</a>
								</li>
							</ul>
						</div>
					</div>

					<div class="cli-page-body-main"> 
						<div class="cli-page-body-main-content">
							<?php 
							if($listeActualites):
								?>
								<ul class="BO_actualites_list adm">
									<?php 
									foreach($listeActualites as $actualite):
										$statut = $actualite->statutAct;
										$idAct = $actualite->idAct;
										$libAct = $actualite->libAct;
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

										//Verification de tiquet ouvert
										$idTicReg = false;
										$existTicke = existTicket($idAct,'actualites',$type=true);
										if($existTicke):
											$idTicReg = $existTicke->idTicReg;
											$statutTicReg = $existTicke->statutTicReg;
										endif;


										//Commentaires en attentes
										$CountNewAlertArt = CountnewTicketReget($idTicReg,2);

										?>
										<li class="BO_actualites_list-item js-open-context-menu">
											<a href="#">
												<div class="img">
													<img src="<?=base_url().'assets/images/actualites/'.$actualite->affiche;?> " alt="actualité takanon">
												</div>
												<div class="infos">
													<div class="date">
														Le <?=date('d-m-Y à H:i', strtotime($actualite->dateCreateAct)).' ('.$actualite->libActCat.')';?>
													</div>
													<div class="title">
														<?=$actualite->libAct;?>
													</div>
													<div class="text">

														<?=recupererDebutTexte ($actualite->descriptionAct, 300);?>
													</div>
												</div>

											</a>
											<ul class="periode">
												<li>
													<span>Début:</span>
													<?=date('d-m-Y à H:i', strtotime($actualite->dateDebut));?>
												</li>
												<li>
													<span>Fin:</span>
													<?=date('d-m-Y à H:i', strtotime($actualite->dateFin));?>
												</li>
											</ul>
											<ul class="i-post-list-item-bottom">
												<li class="text-left left">
													<span class="i-statut <?=(isset($statutClass))? $statutClass:'';?>">
														<?=(isset($statutText))? $statutText:'';?>
													</span>

													<?php if($existTicke): ?>
														<a href="<?=base_url().'admin/ticket_regets?tck='.cripterId($idTicReg,0);?>" class="i-notif"   title="Motif">
															<i class="fas fa-bell"></i>
															<small class="i-notNum"><?=$CountNewAlertArt;?></small>
														</a>
													<?php endif; ?>
													
												</li>
												<li class="right">
													<ul class="i-post-list-item-nav">
														<li>
															<a href="#periodePub" class="update js-open-poPup js-transfer_data" title="Modifier la période de publication" data-type="actualites" data-infos="<?=$idAct.'@@'.$libAct.'@@'.date('Y-m-d', strtotime($actualite->dateDebut)).'@@'.date('Y-m-d', strtotime($actualite->dateFin)) ?>">
																<i class="fas fa-clock"></i>
															</a>
														</li>
													</ul>
												</li>
											</ul>

											<ul class="js-contextMenuList">
												<?php if($statut!=2): ?>
													<li>
														<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-green'>Activation d'actualité</span>" data-infos="<?=$idAct."@@".$libAct."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-green'>Valider</mark> 
															l'actualité :  <strong><?=$libAct;?></strong> ?" data-objet="false"  data-type="Activer-actualites">
															<i class="fas fa-check"></i>
															<span>Activer</span>
														</a>
													</li>
												<?php endif;?>

												<?php if($statut!=3&&$statut!=0): ?>
													<li>
														<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-orange'>Reget 
														d'actualité</span>" data-infos="<?=$idAct."@@".$libAct."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-orange'>Regeter</mark> 
														l'actualité :  <strong><?=$libAct;?></strong> ?" data-objet="true" data-type="Regeter-actualites"> 
														<i class="fas fa-undo"></i>
														<span>Regeter</span>
													</a>
												</li>
											<?php endif;?>

											<?php if($statut!=0): ?>
												<li>
													<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-red'>Bloquage d'actualité</span>" data-infos="<?=$idAct."@@".$libAct."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-red'>Bloquer</mark> 
														l'actualité :  <strong><?=$libAct;?></strong> ?" data-objet="true"  data-type="Bloquer-actualites">
														<i class="fas fa-ban"></i>
														<span>Fermer</span>
													</a>
												</li>
											<?php endif;?>


										</ul>

									</li>
									<?php
								endforeach;
								?>
							</ul>
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
	</section>
</div>
</div>