<div class="cli-page user">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-users"></i>
				<span class="text">Utilisateurs</span>
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
						<ul class="cli-page-body-sidebar-menu-list">
							<?php 
							$countAllUsers = GetCountNewEllem('users',array(),true); 
							$countAllAdmin = GetCountNewEllem('users',array('idGrpUti'=>1),true); 
							$countAllClients = GetCountNewEllem('users',array('idGrpUti'=>2),true);
							$countAllUser = GetCountNewEllem('users',array('idGrpUti'=>3),true);  
							?>
							<li>
								<a href="<?=base_url().'admin/users';?>" class="<?=(!isset($grpUsers))? 'active':'';?>">
									Tous
									<span class="i-num"><?=$countAllUsers;?></span>
								</a>
							</li>
							<li>
								<a href="<?=base_url().'admin/users?grp=1';?>" class="<?=(isset($grpUsers)&&$grpUsers==1)? 'active':'';?>">
									Administrateurs Généraux
									<span class="i-num"><?=$countAllAdmin;?></span>
								</a>
							</li>
							<li>
								<a href="<?=base_url().'admin/users?grp=2';?>" class="<?=(isset($grpUsers)&&$grpUsers==2)? 'active':'';?>">
									Administrateurs délégués
									<span class="i-num"><?=$countAllClients;?></span>
								</a>
							</li>
							<li>
								<a href="<?=base_url().'admin/users?grp=3';?>" class="<?=(isset($grpUsers)&&$grpUsers==3)? 'active':'';?>">
									Comptes privés
									<span class="i-num"><?=$countAllUser;?></span>
								</a></li>
							</ul>
						</div>

						<div class="cli-page-body-sidebar-menu">
							<ul class="cli-page-body-sidebar-menu-list">
								<?php 
								$ActiveGrp = (isset($grpUsers))? '?grp='.$grpUsers.'&':'?';
								?>
								<li><a href="<?=base_url().'admin/users'.$ActiveGrp;?>" class="<?=(!isset($statutUsers))? 'active':'';?>">Tous</a></li>
								<li><a href="<?=base_url().'admin/users'.$ActiveGrp.'sta=2';?>" class="<?=(isset($statutUsers)&&$statutUsers==2)? 'active':'';?>">Actifs</a></li>
								<li><a href="<?=base_url().'admin/users'.$ActiveGrp.'sta=3';?>" class="<?=(isset($statutUsers)&&$statutUsers==3)? 'active':'';?>">Suspendus</a></li>
								<li><a href="<?=base_url().'admin/users'.$ActiveGrp.'sta=0';?>" class="<?=(isset($statutUsers)&&$statutUsers==0)? 'active':'';?>">Bloqués</a></li>
							</ul>
						</div>
					</div>

					<div class="cli-page-body-main">
						<?php 
						if($all_users):
							?>
							<table class="i-table">
								<thead>
									<tr>
										<th class="wid-50">Id</th>
										<th>Utilisateur</th>
										<th class="wid-100">Statut</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($all_users as $all_user):?>
										<?php 
										$idUser = $all_user->idUser;
										$userName = $all_user->nom.' '.$all_user->prenoms;

										if(isset($all_user->avatar)&&!empty($all_user->avatar)):
											$avatar = $all_user->avatar;
										else:
											$avatar = 'default.jpg';
										endif;



										$statut = $all_user->statutUser;
										$idUse = $all_user->idUse;
										if($statut==0):
											$statutText ='Bloqué';
											$statutClass = 'bloquer';
										elseif($statut==1):
											$statutText ='En attente';
											$statutClass = '';
										elseif($statut==2):
											$statutText ='Actif';
											$statutClass = 'actif';
										elseif($statut==3):
											$statutText ='Regeté';
											$statutClass = 'rejeter';
										elseif($statut==4):
											$statutText ='Désactivé';
											$statutClass = 'desactiver';
										endif;

										?>
										<tr class="js-open-context-menu">
											<td><?="Tk-".$all_user->idUse;?></td>
											<td>
												<div class="v-user">
													<div class="img">
														<img src="<?=base_url().'assets/images/users/'.$avatar;?> " alt="avatar user takanon">
													</div>
													<div class="infos">
														<div class="name">
															<strong><?=$userName;?></strong> -
															<small><?=$all_user->libUsCat;?></small>
														</div>
														<div class="phone"><?=$all_user->telephone;?></div>
														<div class="email"><?=$all_user->email;?></div>
														<div class="date"><small>Enrégistreé le: <?=date('d-m-Y à H:i:s', strtotime($all_user->dateCreateUser));?></small></div>
													</div>
												</div>
											</td>
											<td>
												<span class="i-statut <?=isset($statutClass)? $statutClass:'';?>"><?=isset($statutText)? $statutText:'';?></span>
												<ul class="js-contextMenuList">
													<?php if($statut!=2): ?>
														<li>
															<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-green'>Activation d'utilisateur</span>" data-infos="<?=$idUser."@@".$userName."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-green'>Valider</mark> 
																l'utilisateur :  <strong><?=$userName;?></strong> ?" data-objet="false"  data-type="Activer-users">
																<i class="fas fa-check"></i>
																<span>Activer</span>
															</a>
														</li>
													<?php endif;?>

													<?php if($statut!=3&&$statut!=0): ?>
														<li>
															<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-orange'>Reget 
															d'utilisateur</span>" data-infos="<?=$idUser."@@".$userName."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-orange'>Regeter</mark> 
															l'utilisateur :  <strong><?=$userName;?></strong> ?" data-objet="true" data-type="Regeter-users"> 
															<i class="fas fa-undo"></i>
															<span>Regeter</span>
														</a>
													</li>
												<?php endif;?>

												<?php if($statut!=0): ?>
													<li>
														<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-red'>Bloquage d'utilisateur</span>" data-infos="<?=$idUser."@@".$userName."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-red'>Bloquer</mark> 
															l'utilisateur :  <strong><?=$userName;?></strong> ?" data-objet="true"  data-type="Bloquer-users">
															<i class="fas fa-ban"></i>
															<span>Fermer</span>
														</a>
													</li>
												<?php endif;?>


											</ul>
										</td>

									</tr>

								<?php endforeach;?>
							</tbody>
						</table>
						<?php
					else:
						echo '<div class="i-alert_empty ">Aucune information disponible !!!</div>';
					endif;
					?>

				</div>



			</div>
		</section>
	</div>
</div>