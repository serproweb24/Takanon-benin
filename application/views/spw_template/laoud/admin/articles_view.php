<div class="cli-page user">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-newspaper"></i>
				<span class="text">Articles</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			<div class="cli-page-section-title">
				<span>Bienvenue Sur <strong>Takanon</strong></span>
			</div>
			<div class="cli-page-section-content cli_with-sidebar">

				<div class="cli-page-body-sidebar">
					<div class="cli-page-body-sidebar-menu">
						<?php
						if($listCategorieArt):
							?>
							<ul class="cli-page-body-sidebar-menu-list big">
								<li><a href="<?=base_url().'admin/articles';?>" class="<?=(!isset($idArtCat))? 'active':'';?>">Tous les posts</a></li>
								<?php
								foreach($listCategorieArt as $value):
									$activeLinck = (isset($idArtCat)&&$idArtCat==$value->idArtCar)? 'active':'';

									//count total post
									$array = array(
										'idArtCar' => $value->idArtCar
									);
									$countAllArt = count($this->spw_model->get_rows('articles',$array));
									

									//count  post en attente
									$array['statut'] = 1;
									$countArtEnAttente = count($this->spw_model->get_rows('articles',$array));

									echo ' 
									<li>
									<a href="'.base_url().'admin/articles?cat='.$value->idArtCar.'" class="'.$activeLinck.'">'.$value->libArtCar.'
									<span class="i-num">'.number_format($countArtEnAttente, 0, ',', ' ').' / '.number_format($countAllArt, 0, ',', ' ').'</span>
									</a>
									</li> 
									';
								endforeach;
								?>
							</ul>
							<?php
						endif;
						?>
					</div>

					<div class="cli-page-body-sidebar-menu">
						<ul class="cli-page-body-sidebar-menu-list">
							<?php 
							$activeCat = (isset($idArtCat))? '?cat='.$idArtCat.'&':'?';
							?>
							<li><a href="<?=base_url().'admin/articles'.$activeCat;?>" class="<?=(!isset($statutArt))? 'active':'';?>">Tous</a></li>
							<li><a href="<?=base_url().'admin/articles'.$activeCat.'sta=1';?>"  class="<?=(isset($statutArt)&&$statutArt==1)? 'active':'';?>">En attentes</a></li>
							<li><a href="<?=base_url().'admin/articles'.$activeCat.'sta=2';?>"  class="<?=(isset($statutArt)&&$statutArt==2)? 'active':'';?>">Actifs</a></li>
							<li><a href="<?=base_url().'admin/articles'.$activeCat.'sta=3';?>"  class="<?=(isset($statutArt)&&$statutArt==3)? 'active':'';?>">Suspendus</a></li>
							<li><a href="<?=base_url().'admin/articles'.$activeCat.'sta=0';?>"  class="<?=(isset($statutArt)&&$statutArt==0)? 'active':'';?>">Bloqués</a></li>
						</ul>
					</div>
				</div>

				<div class="cli-page-body-main">
					
					<?php 

					if($listePostes):

						?>
						<ul class="documents_block-body-list i-post-list">
							<?php 
							foreach($listePostes as $listePoste):
								$idArt = $listePoste->idArt;
								$libArt =$listePoste->libArt;
								$statut = $listePoste->statutArt;
								$idClient = $listePoste->idUse;

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
								endif;

								//Verification de tiquet ouvert
								$idTicReg = false;
								$existTicke = existTicket($idArt,'articles',$type=true);
								if($existTicke):
									$idTicReg = $existTicke->idTicReg;
									$statutTicReg = $existTicke->statutTicReg;
								endif;


								//Commentaires en attentes
								$CountNewAlertArt = CountnewTicketReget($idTicReg,2);

								?>
								<li class="i-post-list-item">
									<span class="content">
										<span class="content-left">
											<span class="img">
												<img src="<?=base_url().'assets/images/default/img-document.png' ?>" alt="document takanon">
											</span>
										</span>
										<span class="content-rigth">
											<span class="item name">
												<strong>Nom:</strong> 
												<span><?=$libArt;?></span>
											</span>
											<span class="item name">
												<strong>Prix:</strong>
												<span><?=number_format($listePoste->prix, 0, ',', ' ').' f';?></span>
											</span>
											<span class="item name">
												<strong>Catégorie:</strong>
												<span><?=$listePoste->libArtCar;?></span>
											</span>
											<span class="item name">
												<strong>Niveau:</strong>
												<span><?=$listePoste->libNiv;?></span>
											</span>
											<span class="item name">
												<strong>Matiere:</strong>
												<span><?=$listePoste->libMat;?></span>
											</span>
											<span class="item name">
												<strong>Année:</strong>
												<span><?=$listePoste->libAnn;?></span>
											</span>
										</span>
									</span>
									<ul class="i-post-list-item-bottom">
										<li  class="left">
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
												<?php if($statut!=2): ?>
													<li>
														<a href="#ChangeStatut" class="valider js-transfer_data js-open-poPup" data-infos="<?=$idArt."@@".$libArt."@@".$statut;?>" data-title-modal="Validation d'article" data-modal-text="Êtes vous sur de vouloir <mark class='text-green'>Valider</mark> l'article :  <strong><?=$libArt;?></strong> ?" data-objet="<?='false';?>" data-type="valider-artilce">
															<i class="fas fa-check"></i>
														</a>
													</li>
												<?php endif;?>
												<?php if($statut!=3&&$statut!=0): ?>
													<li>
														<a href="#ChangeStatut" class="rejeter js-transfer_data js-open-poPup" data-infos="<?=$idArt."@@".$libArt."@@".$statut;?>" data-title-modal="<span class='text-orange'>Regeter l'article</span>" data-modal-text="Êtes vous sur de vouloir <mark class='text-orange'>Rejeter</mark> l'article :  <strong><?=$libArt;?></strong> ?" data-objet="true" data-type="rejeter-artilce">
															<i class="fas fa-undo"></i>
														</a>
													</li>
												<?php endif;?>
												<?php if($statut!=0): ?>
													<li>
														<a href="#ChangeStatut" class="delate js-transfer_data js-open-poPup" data-infos="<?=$idArt."@@".$libArt."@@".$statut;?>" data-title-modal="<span class='text-red'>Bloquer l'article</span>" data-modal-text="Êtes vous sur de vouloir <mark class='text-red'>Bloquer</mark> l'article :  <strong><?=$libArt;?></strong> ?" data-objet="true" data-type="bloquer-artilce">
															<i class="fas fa-ban"></i>
														</a>
													</li>
												<?php endif;?>
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
						echo '<div class="i-alert_empty ">Aucune information disponible !!!</div>';
					endif;
					?>
				</div>


				
			</div>
		</section>
	</div>
</div>