<div class="cli-page boutique">

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
			

			<div class="cli-page-section-content cli_with-sidebar">
				<div class="cli-page-body-sidebar">
					<div class="cli-page-body-sidebar-menu">
						<ul class="cli-page-body-sidebar-menu-list big">
							<li>
								<a href="<?=base_url().'users/forums';?>" class="active">Tous les forums</a>
							</li>
							<li>
								<a href="<?=base_url().'users/mes_forums';?>" >Mes forums</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="cli-page-body-main">
					<div class="cli-page-body-main-head">
						<div class="cli-page-body-main-head-left">

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
										$statutText ='Publié';
										$statutClass = 'actif';
									elseif($statut==3):
										$statutText ='Regeté';
										$statutClass = 'rejeter';
									endif;



									$participants = count($this->spw_model->get_rows_GrpBY('forums_content',array('idFor'=>$idFor),'idForCon','idUse'));
									$postes = count($this->spw_model->get_rows('forums_content',array('idFor'=>$idFor)));


						


									//Commentaires en attentes
									//$CountNewAlertArt = CountnewTicketReget($idTicReg,1);


									?>
									<div class="i-forum-list-item">
										<div class="i-forum-list-item-title">
											<?=$forum->libFor;?> 
											<span class="i-statut <?=(isset($statutClass))? $statutClass:'';?> small"><?=(isset($statutText))? $statutText:'';?></span>
										</div>
										<div class="i-forum-list-item-desc">
											<?=$forum->description;?> 
										</div>
										<div class="i-forum-list-item-bottom">
											<div class="i-bilanQty">
												<strong class="num"><?=number_format($participants, 0, ',', ' '); ?></strong> <?=($participants>1)? 'Participants':'Participant';?>
											</div>
											<a href="<?=base_url().'users/forums/selection/'.cripterId($forum->idFor,0);?> " class="i-bilanQty">
												<strong class="num"><?=number_format($postes, 0, ',', ' '); ?></strong> <?=($postes>1)? 'Postes':'Poste';?>
											</a>

											<?php if($statut==2): ?>
												<a href="<?=base_url().'users/forums/selection/'.cripterId($forum->idFor,0);?> " class="i-bilanQty">
													<strong><i class="fas fa-pencil-alt"></i></strong>
													Réagir
												</a>
											<?php endif; ?>

										
											
										</div>
									</div>

									<?php 
								endforeach;
							else:
								echo '<div class="i-alert_empty">Aucune information disponible !!!</div> ';
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