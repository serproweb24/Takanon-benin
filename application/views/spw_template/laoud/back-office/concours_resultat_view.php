<div class="cli-page cli-aides">
	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-hourglass-half"></i>
				<span class="text">Concours - Résultat</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
		</nav>
	</div>

	<div class="cli-page-body">

		<?php 
		if(isset($_GET['c'])&&is_numeric($_GET['c'])):
			?>
		<div class="i-cc-resultat">
			<div class="i-cc-resultat-tite">
				Résultats du concour:
			</div>
			<div class="i-cc-resultat-lib">
				<?=$libConcour; ?>
			</div>
			<div class="i-cc-resultat-content">
				<?php 
				if($allParticipants):
					?>
					<table>
						<thead>
							<tr>
								<th>Participants</th>
								<th>Temps mis</th>
								<th>Réponses trouvées</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach($allParticipants as $allParticipant):
								$ideParicipant = $allParticipant->idUse;


								//Participant
								$participant = participant($ideParicipant);

								//==>Infos Participations
								$UserParticipations = $this->spw_model->get_rows('concours_participants',array('idUse'=>$ideParicipant, 'idCon'=>$ideConcour));
								foreach($UserParticipations as $UserParticipation):
									$data['ide_participation'] = $ide_participation = $UserParticipation->idConPar;
									$data['statut_participation'] = $statut_participation = $UserParticipation->statut;
									$data['timeStart_participation'] = $timeStart_participation = $UserParticipation->time_start;
									$data['timeEnd_participation'] = $timeEnd_participation = $UserParticipation->time_end;
								endforeach;
								$tempsMis = diffDate($timeEnd_participation, $timeStart_participation);

								//==>Infos content concours
								$contentConcoursInfos = $this->spw_model->get_rows('concours_content',array('idCon'=>$ideConcour));
								$nbrDeQuestions = count($contentConcoursInfos);


								//==>Infos vrai reponses trouves
								$as = "*,concours_all_reponses.idAllRep as idRepGen, concours_participants_reponses.idAllRep as idRepUse";
								$lien = 'concours_participants_reponses.idAllQue = concours_all_reponses.idAllQue';
								$array = array('concours_participants_reponses.idConPar'=>$ide_participation, 'concours_all_reponses.etat'=>1);
								$repnsesTrouvesInfos = $this->spw_model->get_Double_Table('concours_participants_reponses','concours_all_reponses',$as,$lien,$array,'','');
								$vraiReponseTrouver = 0;
								if($repnsesTrouvesInfos):
									foreach($repnsesTrouvesInfos as $repnsesTrouvesInfo):
										if($repnsesTrouvesInfo->idRepGen==$repnsesTrouvesInfo->idRepUse):
											$vraiReponseTrouver++;
										endif;
									endforeach;
								endif;





								?>
								<tr>
									<td>
										<?=$participant->nom.' '.$participant->prenoms;?>
									</td>
									<td>
										<?php 
										$seconde = $tempsMis->second;
										($seconde<10)? $seconde='0'.$seconde:$seconde=$seconde;

										$minutes = $tempsMis->minutes;
										($minutes<10)? $minutes='0'.$minutes:$minutes=$minutes;

										$heures = $tempsMis->heures;
										($heures<10)? $heures='0'.$heures:$heures=$heures;


										echo $heures.'h:'.$minutes.'m:'.$seconde.'s';
										?>

									</td>
									<td>
										<?=$vraiReponseTrouver.' / '.$nbrDeQuestions;?>
									</td>
								</tr>
								<?php 
							endforeach;
							?>
						</tbody>
					</table>
					<?php
				else:
					echo '<div class="i-alert green">Désolé! Aucun résultat trouvé!</div>';
				endif;
				?>

			</div>
		</div>
		<?php 
	else:
		echo '<div class="i-alert red">Désolé! Aucun résultat trouvé!</div>';
	endif;
	?>

</div>

</div>