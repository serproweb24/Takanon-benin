<div class="cli-page boutique">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-newspaper"></i>
				<span class="text">Boutique</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			<?php
			/*  
			<ul class="cli-page-menu">
				<li>
					<a href="#" class="js-open-poPup">
						<span class="text">Articles</span>
					</a>
				</li>
				<li>
					<a href="#" class="js-open-poPup">
						<span class="text">Ventes</span>
					</a>
				</li>
			</ul>
			*/
			
			?>
		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			<div class="cli-page-section-hed boutique-head">
				<div class="boutique-head-body">
					<div class="boutique-head-body-baner">
						
					</div>
					<div class="boutique-head-body-content">
						<div class="boutique-head-body-content-left">
							<div class="boutique-head-user">
								<div class="img">
									<img src="<?=base_url().'assets/images/users/'.$user->avatar;?>" alt="user avatar">
								</div>
								<div class="name">
									<span class="name">
										<?=$user->nom.' '.$user->prenoms;?>
									</span>
								</div>
								<a href="#" class="phone">
									<i class="fas fa-phone"></i>
									<span class="text"><?=$user->telephone;?></span>
								</a>
								<a href="#" class="email">
									<i class="far fa-envelope"></i>
									<span class="text"><?=$user->email;?></span>
								</a>
								<a href="#" class="profession">
									<i class="fab fa-jenkins"></i>
									<span class="text"><?=$user->profession;?></span>
								</a>
							</div>
						</div>
						<div class="boutique-head-body-content-right">
							<div class="boutique-head-body-content-right-cont">
								<a href="#" class="i-abonnes">
									<span class="num">0</span>
									<span class="text">Abonné(s)</span>
								</a>
								<a href="#newPost" class="i-add-post false-btn green js-open-poPup">Ajouter un document</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="cli-page-section-content cli_with-sidebar">
				<div class="cli-page-body-sidebar">
					<div class="cli-page-body-sidebar-menu">
						<?php
						if($listCategorieArt):
							?>
							<ul class="cli-page-body-sidebar-menu-list big">
								<li><a href="<?=base_url().'clients/boutique';?>" class="<?=(!isset($idArtCat))? 'active':'';?>">Tous les posts</a></li>
								<?php
								foreach($listCategorieArt as $value):
									//count total post
									$countAllPost = GetCountNewEllem('articles',array('idUse'=>$user->idUse,'idArtCar'=>$value->idArtCar),true);

									//count attente post
									$countNewPost = GetCountNewEllem('articles',array('idUse'=>$user->idUse,'idArtCar'=>$value->idArtCar, 'statut'=>1),true);

									$activeLinck = (isset($idArtCat)&&$idArtCat==$value->idArtCar)? 'active':'';

									echo ' 
									<li>
									<a href="'.base_url().'clients/boutique?cat='.$value->idArtCar.'" class="'.$activeLinck.'">'.$value->libArtCar.' 
									<span class="i-num">'.number_format($countNewPost, 0, ',', ' ').' / '.number_format($countAllPost, 0, ',', ' ').'</span>
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
							$ActiveCat = (isset($idArtCat))? '?cat='.$idArtCat.'&':'?';
							?>
							<li>
								<a href="<?=base_url().'clients/boutique'.$ActiveCat;?>" class="<?=(!isset($statutArt))? 'active':'';?>">Tous</a></li>
								<li>

									<a href="<?=base_url().'clients/boutique'.$ActiveCat.'sta=1';?>" class="<?=(isset($statutArt)&&$statutArt==1)? 'active':'';?>">
										En attentes

									</a>
								</li>
								<li>
									<a href="<?=base_url().'clients/boutique'.$ActiveCat.'sta=2';?>" class="<?=(isset($statutArt)&&$statutArt==2)? 'active':'';?>">
										Actifs
									</a>
								</li>
								<li>
									<a href="<?=base_url().'clients/boutique'.$ActiveCat.'sta=3';?>" class="<?=(isset($statutArt)&&$statutArt==3)? 'active':'';?>">Suspendus
									</a>
								</li>
								<li>
									<a href="<?=base_url().'clients/boutique'.$ActiveCat.'sta=0';?>" class="<?=(isset($statutArt)&&$statutArt==0)? 'active':'';?>">
										Bloqués
									</a>
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
							<?php 
							if($listePostes):

								?>
								<ul class="documents_block-body-list i-post-list">
									<?php 
									foreach($listePostes as $listePoste):
										$statut = $listePoste->statutArt;
										$idArt = $listePoste->idArt;
										$idClient = $listePoste->idUse;
										$idArtCat = $listePoste->idArtCat;
										$idNiv = $listePoste->idNiv;
										$idMat = $listePoste->idMat;
										$idAnn = $listePoste->idAnn;
										$descriptionArt = $listePoste->descriptionArt;
										$libArt = $listePoste->libArt;
										$prix = $listePoste->prix;
										
										//Verification de tiquet ouvert
										$idTicReg = false;
										$existTicke = existTicket($idArt,'articles',$type=true);
										if($existTicke):
											$idTicReg = $existTicke->idTicReg;
											$statutTicReg = $existTicke->statutTicReg;
										endif;

										//Commentaires en attentes
										$CountNewAlertArt = CountnewTicketReget($idTicReg,1);







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
														<span><?=$listePoste->libArt;?></span>
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
													<span class="i-statut <?=(isset($statutClass))? $statutClass:'';?>"><?=(isset($statutText))? $statutText:'';?></span>

													<!--La cloche de notification-->
													<?php if(($existTicke)): ?>
														<a href="<?=base_url().'clients/ticket_regets?tck='.cripterId($idTicReg,0);?>" class="i-notif"   title="Motif">
															<i class="fas fa-bell"></i>
															<small class="i-notNum"><?=$CountNewAlertArt;?></small>
														</a>
													<?php endif; ?>

												</li>
												<li class="right">												
													<ul class="i-post-list-item-nav">
														<li>
															<a href="#updatePost" class="update js-open-poPup js-transfer_data js-upPost" data-infos="<?=$idArt.'@@'.$idArtCat.'@@'.$idNiv.'@@'.$idMat.'@@'.$idAnn.'@@'.$libArt.'@@'.$prix.'@@'.$descriptionArt;?>">
																<i class="far fa-edit"></i>
															</a>
														</li>
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
				</div>


			</section>
		</div>
	</div>