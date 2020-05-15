<div class="cli-page cli-aides">
	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-hourglass-half"></i>
				<span class="text">Concours</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			<a href="#newConcours" class="js-open-poPup false-btn green small">
				<span class="text ">Créer un concours</span>
			</a>
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
								<a href="<?=base_url().'admin/concours';?>" class="<?=(!isset($periodeCC))? 'active':'';?>">Tous</a>
							</li>
							<li>
								<a href="<?=base_url().'admin/concours?pd=3&';?>" class="<?=(isset($periodeCC)&&$periodeCC==3)? 'active':'';?>">
								Bientôt
								<span class="i-num"><?=$totalCC_bientot;?></span>
							</a>
							</li>
							<li>
								<a href="<?=base_url().'admin/concours?pd=2&';?>" class="<?=(isset($periodeCC)&&$periodeCC==2)? 'active':'';?>">
									Encours
									<span class="i-num"><?=$totalCC_encours;?></span>
								</a>
							</li>
							<li>
								<a href="<?=base_url().'admin/concours?pd=1&';?>" class="<?=(isset($periodeCC)&&$periodeCC==1)? 'active':'';?>">
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
							<dl class="i-accordion">
								<?php
								foreach($listeConcours as $listeConcour):
									$idCon = $listeConcour->idCon;
									$idConCripter = cripterId($idCon,0);
									$libCon = $listeConcour->libCon;
									$debutConcour = $listeConcour->dateStart;
									$finConcour = $listeConcour->dateEnd;
									$statut = $listeConcour->statut;

									$dateDebutCC = date('Y-m-d', strtotime($debutConcour));
									$dateFinCC = date('Y-m-d', strtotime($finConcour));

									$HeureDebutCC = date('H:i', strtotime($debutConcour));
									$HeureFinCC = date('H:i', strtotime($finConcour));

									//Nbre de participant
									$nbrParticipant = count($this->spw_model->get_rows('concours_participants',array('idCon'=>$idCon)));

									//Listes des questions
									$as = '*, concours_content.statut as statutCC, concours_content.idAllQue as idAllQueCC';
									$lien = 'concours_content.idAllQue = concours_all_questions.idAllQue';
									$array = array('concours_content.idCon'=>$idCon);
									$questions = $this->spw_model->get_Double_Table('concours_content','concours_all_questions',$as,$lien,$array,'concours_all_questions.libAllQue','Asc');

									//Nbre de questin
									$nbrQuestion = count($questions);

									//Durré total
									$tatalSecond = 0;
									foreach($questions as $question):
										$tatalSecond += $question->time;
									endforeach;

									
									$durreConcours = convertSecond($tatalSecond);

									
									if($statut==2):
										if($maintenant<=$finConcour && $maintenant>=$debutConcour): 
											$statutText ='Encours';
											$statutClass = 'actif';
										else:
											if($maintenant>=$finConcour):
												$statutText ='Déjà passé';
												$statutClass = 'desactiver';
											elseif($maintenant<=$debutConcour): 
												$statutText ='Bientôt';
												$statutClass = '';
											endif;
										endif;
									endif;

									?>
									<dt class="i-accordion-item <?=($maintenant<=$debutConcour)?'js-open-context-menu':''?>">
										<table>
											<tbody>
												<tr>
													<td style="width: 60%;">
														<?=$listeConcour->libCon;?>
														<div>
															<small>
																<?='Du '.date('d-m-Y à H:i:s', strtotime($debutConcour)).' AU '.date('d-m-Y à H:i:s', strtotime($finConcour));?> 
															</small>
														</div>
														<i class="i-statut <?=(isset($statutClass))? $statutClass:'';?>">
															<?=(isset($statutText))? $statutText:'';?>
														</i>
													</td>
													<td style="width: 20%;"><strong><?=$nbrQuestion;?></strong> <small>Question(s) pour </small> <?=$durreConcours->heures.'h : '.$durreConcours->minutes.'m';?></td>
													<td style="width: 20%;"><strong><?=$nbrParticipant;?></strong> <small>Participant(s)</small></td>
												</tr>
											</tbody>
										</table>

										<?php 
										if($maintenant<=$debutConcour):
											?>
											<ul class="js-contextMenuList">
												<li>
													<a href="#updateConcours" class="js-open-poPup js-transfer_data" data-infos="<?=$idConCripter."@@".$libCon."@@".$debutConcour."@@".$statut;?>" data-title-modal="Modification le concours">
														<i class="far fa-edit"></i>
														<span>Modifier</span>
													</a>
												</li>
												
												<li>
													<a href="#updatePeriodeConcours" class="js-open-poPup js-transfer_data" data-infos="<?=$idConCripter."@@".$libCon."@@".$dateDebutCC."@@".$dateFinCC."@@".$HeureDebutCC."@@".$HeureFinCC."@@".$statut;?>" data-title-modal="Modification de la période du concours: <strong><?=$libCon;?></strong>">
														<i class="far fa-edit"></i>
														<span>Modifier la période</span>
													</a>
												</li>

												<li>
													<a href="#newQuestionConcours" class="js-open-poPup js-transfer_data" data-infos="<?=$idConCripter."@@".$libCon."@@"."@@".$statut;?>">
														<i class="fa fa-plus"></i>
														<span>Ajouter une question</span>
													</a>
												</li>

											</ul>
											<?php 
										endif;
										?>
										
									</dt>
									<dd class="i-accordion-item-content">
										<a href="<?=base_url().'admin/concours_resultats?c='.$idConCripter;?>">Voir les résultats</a>
										<div class="accordion-content-block">

											<?php 
											if($questions):
												?>
												<table>
													<thead>
														<tr>
															<td style="width: 60%;">Question</td>
															<td style="width: 10%;">Temps</td>
															<td style="width: 30%;">Réponse</td>
														</tr>
													</thead>
													<tbody>
														<?php 
														foreach($questions as $question):
															$idAllQue = $question->idAllQueCC;
															$idAllQueCripter = cripterId($idAllQue,0);
															$libAllQue = $question->libAllQue;
															$statut = $question->statutCC;

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

															//Reponses
															$reponses = $this->spw_model->get_rows('concours_all_reponses', array('idAllQue'=>$idAllQue));

															?>
															<tr class="js-open-context-menu <?=($statut==3)?'i-bloquer':'';?>">
																<td><?=$libAllQue;?></td>
																<td><?=$question->time;?>s</td>
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
																		echo '<div class="i-alert_empty">Désolé! Aucune information disponible!</div>';
																	endif;
																	?>


																	<ul class="js-contextMenuList">
																		<li>
																			<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-infos="<?=$idAllQue.'@@'.$libAllQue.'@@'.$statut;?>" data-modal-text="Êtes vous sur de vouloir <mark class='text-green'>Bloquer</mark> 
																				la question :  <strong><?=$libAllQue;?></strong> ?" data-objet="false"  data-type="Regeter-concours_content">
																				<i class="far fa-edit"></i>
																				<span>Bloquer cette question</span>
																			</a>
																		</li>
																	</ul>
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
										</div>
									</dd>
									<?php
								endforeach;
								?>
							</dl>
							<?php
							echo $pgt_nav;
						else:
							echo '<div class="i-alert_empty">Désolé! Auccune information disponible!</div>';
						endif;
						?>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>