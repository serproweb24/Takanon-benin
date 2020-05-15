<div class="cli-page concours">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-hourglass-half"></i>
				<span class="text">Concours</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			
		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			<div class="cli-page-section-title">
				<span><strong>Takanon-bénin</strong></span>
			</div>

			<div class="cli-page-section-content   cli_with-sidebar">
				<div class="cli-page-body-sidebar">
					<div class="cli-page-body-sidebar-menu">
						<ul class="cli-page-body-sidebar-menu-list big">
							<li>
								<a href="<?=base_url().'users/concours';?>" class="<?=(!isset($periodeCC))? 'active':'';?>">Tous</a>
							</li>
							<li>
								<a href="<?=base_url().'users/concours?pd=4&';?>" class="<?=(isset($periodeCC)&&$periodeCC==4)? 'active':'';?>">
									Mes concours
									<span class="i-num"><?=$totalCC_mes;?></span>
								</a>
							</li>
							<li>
								<a href="<?=base_url().'users/concours?pd=3&';?>" class="<?=(isset($periodeCC)&&$periodeCC==3)? 'active':'';?>">
									Bientôt
									<span class="i-num"><?=$totalCC_bientot;?></span>
								</a>
							</li>
							<li>
								<a href="<?=base_url().'users/concours?pd=2&';?>" class="<?=(isset($periodeCC)&&$periodeCC==2)? 'active':'';?>">
									Encours
									<span class="i-num"><?=$totalCC_encours;?></span>
								</a>
							</li>
							<li>
								<a href="<?=base_url().'users/concours?pd=1&';?>" class="<?=(isset($periodeCC)&&$periodeCC==1)? 'active':'';?>">
									Passés
									<span class="i-num"><?=$totalCC_passer?></span>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="cli-page-body-main">
					<div class="cli-page-body-main-content">
						<?php 
						if($listeConcours):
							?>
							<table class="tbl_concours">
								<thead>
									<tr>
										<td>Période</td>
										<td>Concour</td>
										<td>Participants</td>
										<td>Action</td>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach($listeConcours as $listeConcour):
										$ideConcour = $listeConcour->idCon;
										$statutConcour = $listeConcour->statut;
										$debutConcour = $listeConcour->dateStart;
										$finConcour = $listeConcour->dateEnd;

										//Verifier si n'a pas deja jouer
										$dejaJouer = $this->spw_model->get_rows('concours_participants',array('idUse'=>$user->idUse, 'idCon'=>$ideConcour));

										//Nbre de participant
										$nbrParticipant = count($this->spw_model->get_rows('concours_participants',array('idCon'=>$ideConcour)));

										?>
										<tr>
											<td><?='Du '.date('d-m-Y à H:i:s', strtotime($debutConcour)).'<br> Au '.date('d-m-Y à H:i:s', strtotime($finConcour));?></td>
											<td><?=$listeConcour->libCon;?></td>
											<td><?=$nbrParticipant;?></td>
											<td>
												<?php 
												if($statutConcour==2): 
													if($maintenant<=$finConcour && $maintenant>=$debutConcour): 
														if($dejaJouer):
															if(isset($_SESSION['concours'])):
																?>
																<a href="<?=base_url().'users/concours/encours?c='.cripterId($listeConcour->idCon,0);?>" class="i-btn">Continuer le concours</a>
																<?php 
															else:

																?>
																<a href="<?=base_url().'users/concours/resultat?c='.cripterId($listeConcour->idCon,0);?>" class="i-btn">Voir le résultat</a>
																<?php 
															endif;

														else:
															?>
															<a href="<?=base_url().'users/concours/encours?c='.cripterId($listeConcour->idCon,0);?>" class="i-btn">Jouer</a>
															<?php 
														endif;
													else:
											//Concour deja cloturer
														if($maintenant>=$finConcour&$dejaJouer):
															?>
															<a href="<?=base_url().'users/concours/resultat?c='.cripterId($listeConcour->idCon,0);?>" class="i-btn">Voir le résultat</a>
															<?php
														elseif($maintenant<=$debutConcour): 
															?>
															<small class="alert">Bientôt disponible</small>
															<?php
														endif;
													endif;
												endif; 
												?>
											</td>
										</tr>
										<?php 
									endforeach;
									?>
								</tbody>
							</table>
							<?php 
							echo $pgt_nav;
						else:
							echo '<div class="i-alert_empty ">Aucune information disponible!</div>';
						endif;
						?>
					</div>
				</div>
			</div>

			
		</section>
	</div>

	
	
</div>