<!--General==> Statut-->
<div class="poPup" id="ChangeStatut">
	<div class="poPup-head">
		<div class="poPup-head-title">
			<div class="text-center">
				<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo takanon">
			</div>
			<div class="poPup-title">Changement de statut</div>
		</div>
	</div>
	<div class="poPup-content" >
		<form method="post" class="form-login" id="ChangeStatutForm">
			<input type="hidden" data-id="0" name="id">
			<input type="hidden" data-statut="0" data-id="2" name="statut">
			<div class="i-form-textAlert">
				Êtes vous sur de vouloir <mark> éffectuer </mark> cette oppération ?
			</div>
			<div class="i-form-bottom text-center">
				<a href="#" class="btn-no js-poPup-close">Non</a>
				<button class="btn-yes" name="ChangeStatutBtn">Oui</button>
			</div>

		</form>
	</div>
</div>




<!--Actualites==> SModifier date de puplication-->
<div class="poPup" id="periodePub">
	<div class="poPup-head">
		<div class="poPup-head-title">
			<div class="text-center">
				<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo takanon">
			</div>
			<div class="poPup-title">Modifier la Période de publication</div>
		</div>
	</div>
	<div class="poPup-content" >
		<form method="post" class="form-login" id="periodePubForm">
			<input type="hidden" data-id="0" name="idAct">
			<div class="i-form-textAlert">
				Êtes vous sur de vouloir modifier la péride de publication de l'article:<mark data-id="1">  </mark> ?
			</div>
			<div class="x2">
				<div class="x2-elem i-form-row">
					<div class="i-placeholder">Début*</div>
					<input type="date" data-id="2" name="dateDebut" required>
				</div>
				<div class="x2-elem i-form-row">
					<div class="i-placeholder">Fin*</div>
					<input type="date" data-id="3" name="dateFin"  required>
				</div>
			</div>

			<div class="i-form-bottom text-center">
				<a href="#" class="btn-no js-poPup-close">Non</a>
				<button class="btn-yes" name="periodePubBtn">Modifier</button>
			</div>

		</form>
	</div>
</div>


<!--Aides==> Creer-->
<div class="poPup big" id="newAide">
	<div class="poPup-head">
		<div class="poPup-head-title">
			<div class="text-center">
				<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo takanon">
			</div>
			<div class="poPup-title">Céer une Aide</div>
		</div>
	</div>
	<div class="poPup-content" >
		<form method="post" class="form-login" id="newAideForm">
			<div class="i-form-row">
				<div class="i-placeholder">Titre*</div>
				<input type="text" name="libAid" required>
			</div>
			<div class="i-form-row">
				<div class="i-placeholder">Description*</div>
				<textarea name="description" required></textarea>
			</div>
			<div class="i-form-bottom text-center">
				<button class="btn-yes" name="newAideBtn">Ajouter</button>
			</div>

		</form>
	</div>
</div>

<!--Aides==>Modifier-->
<div class="poPup big" id="updateAide">
	<div class="poPup-head">
		<div class="poPup-head-title">
			<div class="text-center">
				<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo takanon">
			</div>
			<div class="poPup-title">Modifier une Aide</div>
		</div>
	</div>
	<div class="poPup-content" >
		<form method="post" class="form-login" id="updateAideForm">
			<input type="hidden" data-id="0" name="idAid">
			<div class="i-form-row">
				<div class="i-placeholder">Titre*</div>
				<input type="text" name="libAid" data-id="1" required>
			</div>
			<div class="i-form-row">
				<div class="i-placeholder">Description*</div>
				<textarea name="description" data-id="2" required></textarea>
			</div>
			<div class="i-form-bottom text-center">
				<button class="btn-yes" name="updateAideBtn">Modifier</button>
			</div>

		</form>
	</div>
</div>

<?php 
$segment = $this->uri->segment(2);
if(isset($segment)&&$segment=='questions'):
	?>
	<!--Question==> New question-->
	<div class="poPup big" id="newQuestion">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo takanon">
				</div>
				<div class="poPup-title">Nouvelle Question</div>
			</div>
		</div>
		<div class="poPup-content" >
			<form method="post" class="form-login" id="newQuestionForm">
				<div class="i-form-row">
					<div class="i-placeholder">Matiere*</div>
					<select name="idMat" class="i-select2" required>
						<option value="">--Choisir une matiere--</option>
						<?php 
						if($allMatieres):
							foreach($allMatieres as $allMatiere):
								?>
								<option value="<?=$allMatiere->idMat;?>"><?=$allMatiere->libMat;?></option>
								<?php
							endforeach;
						endif;
						?>
					</select>
				</div>
				<div class="x2">
					<div class="x2-elem i-form-row">
						<div class="i-placeholder">Auteur*</div>
						<select name="idAut" class="i-select2" required>
							<option value="">--Choisir une matiere--</option>
							<?php 
							if($allAuteurs):
								foreach($allAuteurs as $allAuteur):
									?>
									<option value="<?=$allAuteur->idUse;?>"><?=$allAuteur->nom.' '.$allAuteur->prenoms;?></option>
									<?php
								endforeach;
							endif;
							?>
						</select>
					</div>
					<div class="x2-elem i-form-row">
						<div class="i-placeholder">Duree en seconde*</div>
						<input type="number" name="time" required>
					</div>
				</div>
				<div class="i-form-row">
					<div class="i-placeholder">Question*</div>
					<textarea name="libQue" required></textarea>
				</div>
				<div class="i-form-bottom text-center">
					<button class="btn-yes" name="newQuestionBtn">Ajouter</button>
				</div>

			</form>
		</div>
	</div>



	<!--Question==> update question-->
	<div class="poPup big" id="updateQuestion">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo takanon">
				</div>
				<div class="poPup-title">Modifier Question</div>
			</div>
		</div>
		<div class="poPup-content" >
			<form method="post" class="form-login" id="updateQuestionForm">
				<input type="hidden" name="idAllQue" data-id="0">
				<div class="i-form-row">
					<div class="i-placeholder">Matiere*</div>
					<select name="idMat" class="i-select2" data-id="1" required>
						<option value="">--Choisir une matiere--</option>
						<?php 
						if($allMatieres):
							foreach($allMatieres as $allMatiere):
								?>
								<option value="<?=$allMatiere->idMat;?>"><?=$allMatiere->libMat;?></option>
								<?php
							endforeach;
						endif;
						?>
					</select>
				</div>
				<div class="x2">
					<div class="x2-elem i-form-row">
						<div class="i-placeholder">Auteur*</div>
						<select name="idAut" class="i-select2" data-id="2" required>
							<option value="">--Choisir une matiere--</option>
							<?php 
							if($allAuteurs):
								foreach($allAuteurs as $allAuteur):
									?>
									<option value="<?=$allAuteur->idUse;?>"><?=$allAuteur->nom.' '.$allAuteur->prenoms;?></option>
									<?php
								endforeach;
							endif;
							?>
						</select>
					</div>
					<div class="x2-elem i-form-row">
						<div class="i-placeholder" >Duree en seconde*</div>
						<input type="number" name="time" data-id="3" required>
					</div>
				</div>
				<div class="i-form-row">
					<div class="i-placeholder">Question*</div>
					<textarea name="libAllQue" data-id="4" required></textarea>
				</div>
				<div class="i-form-bottom text-center">
					<button class="btn-yes" name="updateQuestionBtn">Modifier</button>
				</div>

			</form>
		</div>
	</div>



	<!--Question==> New reponse-->
	<div class="poPup big" id="newReponses">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo takanon">
				</div>
				<div class="poPup-title">Ajouter Reponse</div>
			</div>
		</div>
		<div class="poPup-content" >
			<form method="post" class="form-login" id="newReponsesForm">
				<input type="hidden" name="idAllQue" data-id="0">
				<div class="i-form-row">
					<div class="i-placeholder">Reponses*</div>
					<textarea name="libAllRep" required></textarea>
				</div>
				<div class="i-form-row">
					<input type="hidden" name="idAllQue" data-id="0">
					<div class="i-placeholder">Type*</div>
					<select name="etat" class="i-select2" data-id="1" required>
						<option value="">--Choisir le type--</option>
						<option value="1">Vrai</option>
						<option value="0">Faux</option>
						?>
					</select>
				</div>
				<div class="i-form-bottom text-center">
					<button class="btn-yes" name="newReponsesBtn">Ajouter</button>
				</div>

			</form>
		</div>
	</div>
	<?php 
endif; //End question
?>


<!--Concours==> New Concours-->
<div class="poPup big" id="newConcours">
	<div class="poPup-head">
		<div class="poPup-head-title">
			<div class="text-center">
				<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo takanon">
			</div>
			<div class="poPup-title">Nouveau Concours</div>
		</div>
	</div>
	<div class="poPup-content" >
		<form method="post" class="form-login" id="newConcoursForm">
			<div class="i-form-row">
				<div class="i-placeholder">Concours*</div>
				<input type="text" name="libCon" required>
			</div>
			<div class="x2">
				<div class="x2-elem i-form-row">
					<div class="i-placeholder">Date Lancement*</div>
					<input type="date" name="dateDebut" required>
				</div>
				<div class="x2-elem i-form-row">
					<div class="i-placeholder">Heure de Lancement*</div>
					<input type="time" name="heureDebut" required>
				</div>
			</div>

			<div class="x2">
				<div class="x2-elem i-form-row">
					<div class="i-placeholder">Date Cloture*</div>
					<input type="date" name="dateFin" required>
				</div>
				<div class="x2-elem i-form-row">
					<div class="i-placeholder">Heure de Cloture*</div>
					<input type="time" name="heureFin" required>
				</div>
			</div>
			
			<div class="i-form-bottom text-center">
				<button class="btn-yes" name="newConcoursBtn">Créer</button>
			</div>

		</form>
	</div>
</div>


<!--Concours==> update Concours-->
<div class="poPup big" id="updateConcours">
	<div class="poPup-head">
		<div class="poPup-head-title">
			<div class="text-center">
				<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo takanon">
			</div>
			<div class="poPup-title">Modifier une Aide</div>
		</div>
	</div>
	<div class="poPup-content" >
		<form method="post"  id="updateConcoursForm">
			<input type="hidden" data-id="0" name="idCon">
			<div class="i-form-row">
				<div class="i-placeholder">Titre*</div>
				<input type="text" name="libCon" data-id="1" required>
			</div>
			<div class="i-form-bottom text-center">
				<button class="btn-yes" name="updateConcoursBtn">Modifier</button>
			</div>

		</form>
	</div>
</div>

<!--Concours==> Update periode Concours-->
<div class="poPup big" id="updatePeriodeConcours">
	<div class="poPup-head">
		<div class="poPup-head-title">
			<div class="text-center">
				<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo takanon">
			</div>
			<div class="poPup-title">NModifier la période du Concours</div>
		</div>
	</div>
	<div class="poPup-content" >
		<form method="post"  id="updatePeriodeConcoursForm">
			<input type="hidden" data-id="0" name="idCon">
		
			<div class="x2">
				<div class="x2-elem i-form-row">
					<div class="i-placeholder">Date Lancement*</div>
					<input type="date" name="dateDebut" data-id="2" required>
				</div>
				<div class="x2-elem i-form-row">
					<div class="i-placeholder">Heure de Lancement*</div>
					<input type="time" name="heureDebut" data-id="4" required>
				</div>
			</div>

			<div class="x2">
				<div class="x2-elem i-form-row">
					<div class="i-placeholder">Date Cloture*</div>
					<input type="date" name="dateFin" data-id="3" required>
				</div>
				<div class="x2-elem i-form-row">
					<div class="i-placeholder">Heure de Cloture*</div>
					<input type="time" name="heureFin" data-id="5" required>
				</div>
			</div>
			
			<div class="i-form-bottom text-center">
				<button class="btn-yes" name="updatePeriodeConcoursBtn">Modifier</button>
			</div>

		</form>
	</div>
</div>

<!--Concours==> New question-->
<div class="poPup big" id="newQuestionConcours">
	<div class="poPup-head">
		<div class="poPup-head-title">
			<div class="text-center">
				<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo takanon">
			</div>
			<div class="poPup-title">Ajouter une Question au concours</div>
		</div>
	</div>
	<div class="poPup-content" >
		<form method="post" class="form-login" id="newQuestionConcoursForm">
			<input type="hidden" name="idCon" data-id="0">
			<div class="i-form-row">
				<div class="i-placeholder">Question*</div>
				<select name="idAllQue" class="i-select2" required>
					<option value="">--Choisir une question--</option>
					<?php 
					if($allMatieres):
						foreach($allMatieres as $allMatiere):
							$idMat = $allMatiere->idMat;

							$concoursQuestions = $this->spw_model->get_rows_order('concours_all_questions',array('idMat'=>$idMat, 'statut'=>2), 'libAllQue', 'Asc');
							?>
							<optgroup label="<?=$allMatiere->libMat;?>">
							<?php 
							if($concoursQuestions):
								foreach($concoursQuestions as $concoursQuestion):
									?>
									<option value="<?=$concoursQuestion->idAllQue;?>"><?=$concoursQuestion->libAllQue;?></option>
									<?php 
								endforeach;
							else:
								?>
									<option value="">-</option>
									<?php 
							endif;
							?>
						</optgroup>
						<?php
					endforeach;
				endif;
				?>
			</select>
		</div>
		<div class="i-form-bottom text-center">
			<button class="btn-yes" name="newQuestionConcoursBtn">Ajouter</button>
		</div>

	</form>
</div>
</div>


