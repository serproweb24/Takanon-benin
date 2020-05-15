<div class="cli-page cli-actualites">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-bullhorn"></i>
				<span class="text">Actualités</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			<a href="#newActualite" class="js-open-poPup false-btn green small">
				<span class="text ">Créer une actualité</span>
			</a>
		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			
			<div class="cli-page-section-content   cli_with-sidebar">
				<div class="cli-page-body-sidebar">
					<div class="cli-page-body-sidebar-menu">
						<ul class="cli-page-body-sidebar-menu-list">
							<li><a href="<?=base_url().'clients/actualites';?>" class="<?=(!isset($idActCat))? 'active':'';?>">Tous Mes Forums</a></li>
							<?php 
							if(isset($listCategorieActs)):
								foreach($listCategorieActs as $listCategorieAct):
									//count post
									$array = array(
										'idUse' => $user->idUse,
										'idActCat' => $listCategorieAct->idActCat
									);
									$countCat = $this->spw_model->get_Count('actualites',$array);
									$activeLinck = (isset($idActCat)&&$idActCat==$listCategorieAct->idActCat)? 'active':'';

									echo '<li>
									<a href="'.base_url().'clients/actualites?actualite='.$listCategorieAct->idActCat.'" class="'.$activeLinck.'">
									'.$listCategorieAct->libActCat.'
									<span class="i-num">'.number_format($countCat, 0, ',', ' ').'</span>
									</a>
									</li>';
								endforeach;
							endif;
							?>
						</ul>
					</div>
				</div>

				<div class="cli-page-body-main"> 
					<div class="cli-page-body-main-content">
						<?php 
						if($actualites):
							?>
							<ul class="actualites_block-list adm">
								<?php 
								foreach($actualites as $actualite):
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
									$CountNewAlertArt = CountnewTicketReget($idTicReg,1);

									
									?>
									<li class="actualites_block-list-item">
										<a href="#">
											<div class="img">
												<img src="<?=base_url().'assets/images/actualites/'.$actualite->affiche;?> " alt="actualité takanon">
											</div>
											<div class="infos">
												<div class="date">
													Le <?=date('d-m-Y à H:i', strtotime($actualite->dateCreate));?>
												</div>
												<div class="title">
													<?=$actualite->libAct;?>
												</div>
												<div class="text">
													
													<?=recupererDebutTexte ($actualite->description, 300);?>
												</div>
											</div>
										</a>
										<ul class="i-post-list-item-bottom">
											<li  class="left">
												<span class="i-statut <?=(isset($statutClass))? $statutClass:'';?>">
													<?=(isset($statutText))? $statutText:'';?>
												</span>

												<?php if($existTicke): ?>
												<a href="<?=base_url().'clients/ticket_regets?tck='.cripterId($idTicReg,0);?>" class="i-notif"   title="Motif">
													<i class="fas fa-bell"></i>
													<small class="i-notNum"><?=$CountNewAlertArt;?></small>
												</a>
											<?php endif; ?>
											</li>
											<li class="right">
												<ul class="i-post-list-item-nav">
													<?php if($statut!=0&&$statut!=4): ?>
														<li>
															<a href="<?=base_url().'clients/actualites/modifier_actualite/'.cripterId($idAct,0);?>" class="update" title="Modifier">
																<i class="far fa-edit"></i>
															</a>
														</li>
													<?php endif; ?>
													<?php if($statut==2): ?>
														<li>
															<a href="#ChangeStatut" class="delate js-open-poPup js-transfer_data" title="Désactiver" data-infos="<?=$idAct."@@".$libAct."@@".$statut ?>" data-title-modal="Désactivation d'actualité"  data-modal-text="<?='Êtes vous sur de vouloir désactiver l\'actualité:  <mark >'.$libAct.'</mark>';?>" data-type="desactiver_actualite">
																<i class="fas fa-ban"></i>
															</a>
														</li>
													<?php endif; ?>
												</ul>
											</li>
										</ul>
									</li>
									<?php
								endforeach;
								?>
							</ul>
							<?php
							echo $pgt_nav; 
						else:
							echo '<div class="i-alert_empty">Désolé, aucune information disponible !!!</div>';
						endif;
						?>						
					</div>
				</div>

			</div>
		</div>

	</section>
</div>
</div>