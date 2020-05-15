<div class="cli-page forums">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-life-ring"></i>
				<span class="text">Forums</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">

		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			<div class="cli-page-section-title">
				<span>Liste de tous les Forums</span>
			</div>
			<div class="cli-page-section-content  cli_with-sidebar" >
				<div class="cli-page-body-sidebar">
					<div class="cli-page-body-sidebar-menu">
						<ul class="cli-page-body-sidebar-menu-list">
							<li>
								<a href="<?=base_url().'admin/forums';?>" class="<?=(!isset($statutForums))? 'active':'';?>">
									Tous les Forums
									<span class="i-num"><?=$totalForum;?></span>
								</a>
							</li>
							<li>
								<a href="<?=base_url().'admin/forums?sta=2';?>" class="<?=(isset($statutForums)&&$statutForums==2)? 'active':'';?>">
									Activés
									<span class="i-num"><?=$activerForum;?></span>
								</a>
							</li>
							<li>
								<a href="<?=base_url().'admin/forums?sta=1';?>" class="<?=(isset($statutForums)&&$statutForums==1)? 'active':'';?>">
									En attente
									<span class="i-num"><?=$attenteForum;?></span>
								</a>
							</li>
							<li>
								<a href="<?=base_url().'admin/forums?sta=3';?>"  class="<?=(isset($statutForums)&&$statutForums==3)? 'active':'';?>">
									Regetés
									<span class="i-num"><?=$regeterForum;?></span>
								</a>
							</li>
							<li>
								<a href="<?=base_url().'admin/forums?sta=0';?>" class="<?=(isset($statutForums)&&$statutForums==0)? 'active':'';?>">
									Fermés
									<span class="i-num"><?=$fermerForum;?></span>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="cli-page-body-main">

					<div class="cli-page-body-main-head">
						<div class="cli-page-body-main-head-left">
							<div class="cli-page-body-main-head-title">
								<?//=(isset($titleSection))? $titleSection:'Mes posts' ?>
								Tous les Forums 
							</div>
						</div>
						<div class="cli-page-body-main-head-right">
						</div>
					</div>
					<div class="cli-page-body-main-content">
						<div class="i-forum-list">
							<?php 
							if($forums):
								foreach($forums as $forum):
									$idFor = $forum->idFor;
									$libFor = $forum->libFor;
									$statut = $forum->statut;
									if($statut==0):
										$statutText ='Fermé';
										$statutClass = 'fermer';
									elseif($statut==1):
										$statutText ='En attente';
										$statutClass = '';
									elseif($statut==2):
										$statutText ='Activé';
										$statutClass = 'actif';
									elseif($statut==3):
										$statutText ='Regeté';
										$statutClass = 'rejeter';
									endif;


									$participants = count($this->spw_model->get_rows_GrpBY('forums_content',array('idFor'=>$idFor),'idForCon','idUse'));
									$postes = count($this->spw_model->get_rows('forums_content',array('idFor'=>$idFor)));


									//Verification de tiquet ouvert
									$idTicReg = false;
									$existTicke = existTicket($idFor,'forums',$type=true);
									if($existTicke):
										$idTicReg = $existTicke->idTicReg;
										$statutTicReg = $existTicke->statutTicReg;
									endif;


										//Commentaires en attentes
									$CountNewAlertArt = CountnewTicketReget($idTicReg,2);
									
									?>
									<div class="i-forum-list-item js-open-context-menu">
										<div class="i-forum-list-item-title">
											<?=$forum->libFor;?> 
											<span class="i-statut <?=(isset($statutClass))? $statutClass:'';?> small"><?=(isset($statutText))? $statutText:'';?></span>
											<div class="date">
												<span ><?='Le '.date('d-m-Y à H:i:s', strtotime($forum->dateCreate));?></span>
											</div>
										</div>
										<div class="i-forum-list-item-desc">
											<?=$forum->description;?> 
										</div>
										<div class="i-forum-list-item-bottom">
											<div class="i-bilanQty">
												<strong class="num"><?=number_format($participants, 0, ',', ' '); ?></strong> <?=($participants>1)? 'Participants':'Participant';?>
											</div>
											<a href="<?=base_url().'admin/forums/selection/'.cripterId($forum->idFor,0);?> " class="i-bilanQty">
												<strong class="num"><?=number_format($postes, 0, ',', ' '); ?></strong> <?=($postes>1)? 'Postes':'Poste';?>
											</a>

											<?php if($existTicke): ?>
												<a href="<?=base_url().'admin/ticket_regets?tck='.cripterId($idTicReg,0);?>" class="i-notif"   title="Motif">
													<i class="fas fa-bell"></i>
													<small class="i-notNum"><?=$CountNewAlertArt;?></small>
												</a>
											<?php endif; ?>

										</div>

										<ul class="js-contextMenuList">
											<?php if($statut!=2): ?>
												<li>
													<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-green'>Actier le forum</span>" data-infos="<?=$idFor."@@".$libFor."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-green'>Valider</mark> le forum :  <strong><?=$libFor;?></strong> ?" data-type="Activer-forum" data-objet="<?='false';?>">
														<i class="fas fa-check"></i>
														<span>Activer</span>
													</a>
												</li>
											<?php endif;?>

											<?php if($statut!=3&&$statut!=0): ?>
												<li>
													<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-orange'>Regeter le forum</span>" data-infos="<?=$idFor."@@".$libFor."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-orange'>Regeter</mark> le forum :  <strong><?=$libFor;?></strong> ?" data-type="Regeter-forum" data-objet="true"> 
														<i class="fas fa-undo"></i>
														<span>Regeter</span>
													</a>
												</li>
											<?php endif;?>

											<?php if($statut!=0): ?>
												<li>
													<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-red'>Fermer le forum</span>" data-infos="<?=$idFor."@@".$libFor."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-red'>Fermer</mark> le forum :  <strong><?=$libFor;?></strong> ?" data-type="Fermer-forum" data-objet="true">
														<i class="fas fa-ban"></i>
														<span>Fermer</span>
													</a>
												</li>
											<?php endif;?>


										</ul>

										

										

										

									</div>
									<?php 
								endforeach;
							else:
								echo '<div class="i-alert_empty">Auccun résultat disponible !!!</div> ';
							endif;
							?>
						</div>
						<?=$pgt_nav;?>
					</div>

				</div>
			</div>
		</section>
	</div>
</div>