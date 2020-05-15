<div class="cli-page cli-aides">
	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-hourglass-half"></i>
				<span class="text">Les questions</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			<a href="#newQuestion" class="js-open-poPup false-btn green small">
				<span class="text ">Ajouter une question</span>
			</a>
		</nav>
	</div>
	<div class="cli-page-body">
		<section class="cli-page-section">
			<div class="cli-page-section-title">
				<span><strong>Toutes les questions</strong></span>
			</div>
			<div class="cli-page-section-content   cli_with-sidebar">
				<div class="cli-page-body-sidebar">
					<div class="cli-page-body-sidebar-menu">
						<ul class="cli-page-body-sidebar-menu-list big">
							<li>
								<a href="#" class="<?=(!isset($statutAid))? 'active':'';?>">Toutes</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="cli-page-body-main">
					<div class="cli-page-body-main-content">
						<?php
						if($listeMatieres):
							?>
							<dl class="i-accordion">
								<?php
								foreach($listeMatieres as $listeMatiere):
									$idMat = $listeMatiere->idMat;

									//Liste des questions
									$questions = $this->spw_model->get_rows('concours_all_questions', array('idMat'=>$idMat));
									?>
									<dt class="i-accordion-item">
										<?=$listeMatiere->libMat;?>
									</dt>
									<dd>
										<?php
										if($questions): 
											?>
											<table>
												<thead>
													<tr>
														<td>Question</td>
														<td>Réponses</td>
													</tr>
												</thead>
												<tbody>
													<?php 
													foreach($questions as $question):
														//Questions
														$idAllQue = $question->idAllQue;
														$libAllQue = $question->libAllQue;
														$idAut = $question->idAut;
														$idMat = $question->idMat;
														$time = $question->time;

														//Reponses
														$reponses = $this->spw_model->get_rows('concours_all_reponses', array('idAllQue'=>$idAllQue));
														?>
														<tr>
															<td class="js-open-context-menu">
																<?=$question->libAllQue;?>
																<ul class="js-contextMenuList">
																	<li>
																		<a href="#updateQuestion" class="js-open-poPup js-transfer_data" data-infos="<?=$idAllQue.'@@'.$idMat.'@@'.$idAut.'@@'.$time.'@@'.$libAllQue;?>">
																			<i class="far fa-edit"></i>
																			<span>Modifier la question</span>
																		</a>
																	</li>
																	<li>
																		<a href="#newReponses" class="js-open-poPup js-transfer_data" data-infos="<?=$idAllQue.'@@'.$libAllQue;?>">
																			<i class="fas fa-plus"></i>
																			<span>Ajouter une réponse</span>
																		</a>
																	</li>
																</ul>
															</td>
															<td>
																<?php 
																if($reponses):
																	?>
																	<ul class="concours-list-reponses">
																		<?php
																		foreach($reponses as $reponse):
																			$etat = $reponse->etat;
																			$classReponse = ($etat==1)? 'active':'';
																			?>
																			<li class="<?=$classReponse;?>"><?=$reponse->libAllRep;?></li>
																			<?php
																		endforeach;
																		?>
																	</ul>
																	<?php
																else:
																	echo '<div class="i-alert_empty">Désolé! Aucune réponse disponible!</div>';
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
										else:
											echo '<div class="i-alert_empty">Désolé! Aucune information disponible!</div>';
										endif;
										?>
									</dd>
									<?php
								endforeach;
								?>
							</dl>
							<?php
							echo $pgt_nav;
						else:
							echo '<div class="i-alert_empty">Désolé! Aucune information disponible!</div>';
						endif;
						?>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>