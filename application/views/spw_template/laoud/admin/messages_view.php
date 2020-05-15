<div class="cli-page cli-actualites">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-comments"></i>
				<span class="text">Messages</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			
		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			<div class="cli-page-section-title">
				<span>Tous les messages</span>
			</div>
			<div class="cli-page-section-content ">
				
				<div class="cli-page-body-main"> 
					<div class="cli-page-body-main-content">
						<?php 
						if($messages):
							?>
							<table class="i-table tb_message">
								<thead>
									<tr>
										<td>#</td>
										<th>Expéditeur</th>
										<th>Contacts</th>
										<th>Objet</th>
										<th>Message</th>
										<th>Statut</th>

									</tr>
								</thead>
								<tbody>
									<?php 
									foreach($messages as $message):
										$statut = $message->statut;
										$idMes = $message->idMes;
										$expediteur = $message->nom_prenoms;

										if($statut==1):
											$statutText ='Nouveau';
											$statutClass = 'actif';
										elseif($statut==2):
											$statutText ='Vu';
											$statutClass = '';
										endif;
										?>

										<tr class="<?=($statut==1)? 'js-open-context-menu':'';?>">
											<td><?=$idMes;?></td>
											<td>
												<?=$expediteur;?>
												<small class="date"><?=date('d-m-Y à H:i:s', strtotime($message->dateCreate)) ?>	</small>
											</td>
											<td>
												<p><strong>Email:</strong> <a href="<?='mailto:'.$message->email;?>"><?=$message->email;?></a></p>
												<p><strong>Tél:</strong> <a href="<?='tel:'.$message->phone;?>"><?=$message->phone;?></a></p>
											</td>
											<td>
												<?=$message->objet;?>
											</td>
											<td class="text">
												<?=$message->messages;?>
											</td>
											<td class="statut">
												
												<span class="i-statut small js-transfer_data <?=(isset($statutClass))? $statutClass:'';?>" <?=($statut==1)? 'data-poPup="ChangeStatut"':''; ?> data-infos="<?=$idMes."@@".$expediteur."@@".$statut ?>" data-title-modal="Marquer comme lu" data-modal-text="<?='Êtes vous sur de vouloir marquer le message de :  <mark >'.$expediteur.'</mark> comme lu?';?>" data-type="desactiver_message">
													<?=(isset($statutText))? $statutText:'';?>
												</span>



												<ul class="js-contextMenuList">
													<?php if($statut==1): ?>
														<li>
															<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-green'>Marquer comme vu</span>" data-infos="<?=$idMes."@@".$expediteur."@@".$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-green'>marquer comme vu</mark> 
																le message de :  <strong><?=$expediteur;?></strong> ?" data-objet="<?=($statut==1)? 'false':'true';?>"  data-type="Activer-messages">
																<i class="fas fa-check"></i>
																<span>Marquer comme vu</span>
															</a>
														</li>
													<?php endif;?>
												</ul>
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
