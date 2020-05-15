<div class="cli-page concours">

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


		//S'il existe un concour encours
		if(isset($_SESSION['concours'])):

			?>
			<div class="i-alert red">Désolé! Vous nous pouvez consulter aucun résultat maintenant, Cas vous avez un concours encours!</div>
			<?php

		else:

			if($VerifierParticipations):
				?>
				<div class="i-cc-resultat">
					<div class="i-cc-resultat-tite">
						Résultat du concour:
					</div>
					<div class="i-cc-resultat-lib">
						<?=$libConcour; ?>
					</div>
					<div class="i-cc-resultat-content">
						<?php 
						//A Repondut a toutes les question
						if($statut_participation==2):
							?>
							<table class="i-cc-resultat-tble">
								<tbody>
									<tr>
										<th>Participant:</th>
										<td><?=$participant->nom.' '.$participant->prenoms;?></td>
									</tr>
									<tr>
										<th>Taux de question</th>
										<td><?=$nbrDeReponses.' / '.$nbrDeQuestions;?></td>
									</tr>
									<tr>
										<th>Réponsess trouvées</th>
										<td><?=$vraiReponseTrouver.' / '.$nbrDeQuestions;?></td>
									</tr>
									<tr>
										<th>Temps mis</th>
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
									</tr>
								</tbody>
							</table>
							<?php 
					//N'a pas fini la participation statut = 1
						elseif($statut_participation==1):
							?>
							<div class="i-alert red">Vous avez été disqualifié, pour n'avoir pas finir le concours!</div>
							<?php 
					//A abandoner  statut = 3
						elseif($statut_participation==3):
							?>
							<div class="i-alert red">Vous avez été disqualifié, pour avoir renoncer au concours!</div>
							<?php 
						endif;
						?>
					</div>
				</div>
				<?php 
			else:
echo '<div class="i-alert red">Désolé! Aucun résultat trouvé!</div>';
			endif;
		endif;
		?>
		

		


	</div>

</div>