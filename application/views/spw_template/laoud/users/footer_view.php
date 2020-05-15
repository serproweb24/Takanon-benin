<footer class="cli_footer">
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="footer-bottom-content">
						Copyright © Takanon-benin, 2019 - Realisé par <a href="http://serproweb.ru/"><span>SerProWeb <?=$pageName; ?></span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>



<!--======================== Genérale poPup  ========================--> 

<!--Avatar-->
<?php if($pageName=='mon_compte'):?>
	<div class="poPup" id="updateAvatar">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
				</div>
				Modifier Ma Photo de Profil
			</div>
		</div>
		<div class="poPup-content" >
			<form method="post" class="form-login" id="updateAvatarForm">
				<div class="i-form-row">
					<div class="i-placeholder">Photo</div>
					<input type="file" name="file" class="js-dropify" data-default-file="<?=base_url().'assets/images/users/'.$user->avatar;?>">
				</div>

				<div class="i-form-bottom text-center">
					<button class="btn-form" name="updateAvatarBtn">Modifier</button>
				</div>

			</form>
		</div>
	</div>
<?php endif;?>


<!--Mot de passe-->
<?php if($pageName=='mon_compte'):?>
	<div class="poPup" id="updatePassword">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
				</div>
				<span class="title">Confirmer Mot de passe</span>

			</div>
		</div>
		<div class="poPup-content" >
			<form method="post" class="form-login" id="updatePasswordForm" >

				<div class="js-step-1">
					<div class="i-form-row">
						<div class="i-placeholder">Votre mot de passe actuelle<span class="red-stars">*</span></div>
						<div class="block-password">
							<input type="password" name="password"  minlength="8"  required>
							<a href="#" class="block-password-show js-show-password"><i class="fas fa-eye"></i></a>
						</div>
					</div>
				</div>
				<div class="js-step-2">

				</div>


				<div class="i-form-bottom text-center">
					<button class="btn-form" data-step="1" name="updatePasswordBtn">Confirmer</button>
				</div>

			</form>
		</div>
	</div>
<?php endif;?>


<!--NewPost-->
<?php if($pageName=='boutique'):?>
	<div class="poPup" id="newPost">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
				</div>
				<span class="title">Ajout d'un post</span>

			</div>
		</div>
		<div class="poPup-content" >
			<form method="post"  id="newPostForm" class="js-ctr-CatNiv">
				<div class="x2">
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Categorie<span class="red-stars">*</span></div>
						<select name="idArtCar" class="i-select2 js-ctr-Cat" required>
							<option value="">---- Choisir une catégorie ----</option>
							<?=(isset($optionCategorieArt))? $optionCategorieArt:'';?>
						</select>
					</div>
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Niveau<span class="red-stars">*</span></div>
						<select name="idNiv" class="i-select2 js-ctr-Niv" required>
							<option  value="">---- Choisir le niveau ----</option>
						</select>
					</div>
				</div>
				<div class="x2">
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Matiere<span class="red-stars">*</span></div>
						<select name="idMat" class="i-select2 js-ctr-Mat" required>
							<option value="">---- Choisir une matiere ----</option>
							<?=(isset($optionMatieres))? $optionMatieres:'';?>
						</select>
					</div>
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Année<span class="red-stars">*</span></div>
						<select name="idAnn" class="i-select2 js-ctr-Ann" required>
							<option value="">---- Choisir une année ----</option>
							<?=(isset($optionAnnees))? $optionAnnees:'';?>
						</select>
					</div>
				</div>
				<div class="x2">
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Nom du document<span class="red-stars">*</span></div>
						<input type="text" name="libArt" required>
					</div>
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Prix du document<span class="red-stars">*</span></div>
						<input type="number" name="prix" required>
					</div>
				</div>
				<div class="i-form-row">
					<div class="i-placeholder">Charger le fichier<span class="red-stars">*</span></div>
					<input type="file" name="file" required>
				</div>
				<div class="i-form-row">
					<div class="i-placeholder">Description</div>
					<textarea name="description"></textarea>
				</div>

				<div class="i-form-bottom text-center">
					<button class="btn-form" data-step="1" name="newPostBtn">Poster</button>
				</div>

			</form>
		</div>
	</div>
<?php endif;?>



<!--NewForum-->
<?php if($pageName=='forums'):?>
	<div class="poPup" id="NewForum">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
				</div>
				<span class="title">Créer un forum</span>

			</div>
		</div>
		<div class="poPup-content" >
			<form method="post"  id="NewForumForm" class="js-ctr-CatNiv">

				<div class="i-form-row">
					<div class="i-placeholder">Sujet<span class="red-stars">*</span></div>
					<input type="text" name="libFor" required>
				</div>
				<div class="i-form-row">
					<div class="i-placeholder">Description<span class="red-stars">*</span></div>
					<textarea name="description"  required></textarea>
				</div>

				<div class="i-form-bottom text-center">
					<button class="btn-form" data-step="1" name="NewForumBtn">Poster</button>
				</div>

			</form>
		</div>
	</div>
<?php endif;?>



<!--Actualites-->
<?php if($pageName=='actualites'):?>
	<div class="poPup" id="newActualite">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
				</div>
				Nouvelle actualité
			</div>
		</div>
		<div class="poPup-content" >
			<form method="post" class="form-login" id="newActualiteForm">
				<div class="i-form-row">
					<div class="i-placeholder">Affiche<span class="red-stars">*</span></div>
					<input type="file" name="file" class="js-dropify" required>
				</div>
				<div class="i-form-row">
					<div class="i-placeholder">Catégorie<span class="red-stars">*</span></div>
					<select name="idActCat" >
						<?php  ?>
						<option value="">---- Choisir une catégorie ----</option>
						<?=(isset($optionCategorieAct))? $optionCategorieAct:'';?>
					</select>
				</div>
				<div class="i-form-row">
					<div class="i-placeholder">Titre<span class="red-stars">*</span></div>
					<input type="text" name="libAct" required>
				</div>
				<div class="i-form-row">
					<div class="i-placeholder">Catégorie<span class="red-stars">*</span></div>
					<textarea name="description"  required></textarea>
				</div>

				<div class="i-form-bottom text-center">
					<button class="btn-form" name="newActualiteBtn">Soumettre</button>
				</div>

			</form>
		</div>
	</div>
<?php endif;?>


<!--Répétiteur-->
<?php if($pageName=='repetiteur'):?>
	<div class="poPup" id="newMatierRepetiteur">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
				</div>
				Ajouter une Matière
			</div>
		</div>

		<div class="poPup-content" >
			<form method="post" class="form-login" id="newMatierRepetiteurForm">
				<div class="x2">
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Matière<span class="red-stars">*</span></div>
						<select name="idMat" >
							<option value="">---- Choisir une catégorie ----</option>
							<?=(isset($optionMatieres))? $optionMatieres:'';?>
						</select>
					</div>
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Prix / Mois<span class="red-stars">*</span></div>
						<input type="number" name="price"  required>
					</div>	
				</div>
				<div class="i-form-bottom text-center">
					<button class="btn-form" name="newMatierRepetiteurBtn">Ajouter</button>
				</div>

			</form>
		</div>
	</div>

	
	<div class="poPup" id="updatPriceMatierRepetiteur">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
				</div>
				Modifier le prix
			</div>
		</div>
		<div class="poPup-content" >
			<form method="post" class="form-login" id="updatPriceMatierRepetiteurForm">
				<div class="i-form-row">
					<div class="i-placeholder">Prix / Mois<span class="red-stars">*</span></div>
					<input type="number" name="price"  required>
				</div>
				<div class="i-form-bottom text-center">
					<button class="btn-form" name="updatPriceMatierRepetiteurBtn">Ajouter</button>
				</div>

			</form>
		</div>
	</div>


	<div class="poPup" id="startRepetiteur">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
				</div>
				Activation compte repétiteur
			</div>
		</div>
		<div class="poPup-content" >
			<form method="post" class="form-login" id="startRepetiteurForm">
				<div class="i-form-row">
					<div class="i-placeholder">Niveau d'enseignement<span class="red-stars">*</span></div>
					<select name="idCatNiv" >
						<option value="">---- Choisir une catégorie ----</option>
						<?=(isset($optionCategorieNivEnseignement))? $optionCategorieNivEnseignement:'';?>
					</select>
				</div>
				<div class="i-form-row">
					<div class="i-placeholder">Descrition de soit<span class="red-stars">*</span></div>
					<textarea name="description"></textarea>
				</div>
				<div class="i-form-bottom text-center">
					<button class="btn-form" name="startRepetiteurBtn">Valider</button>
				</div>

			</form>
		</div>
	</div>


	<div class="poPup" id="chagerSatatutRepetiteur">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
				</div>
				Statut Répétiteur
			</div>
		</div>
		<div class="poPup-content" >
			<form method="post" class="form-login" id="chagerSatatutRepetiteurForm">
				<div class="i-form-textAlert">
					Êtes vous sur de vouloir <mark>éffectuer</mark> cette oppération ?
				</div>
				<div class="i-form-bottom text-center">
					<a href="#" class="btn-no js-poPup-close">Non</a>
					<button class="btn-yes" name="ChangeStatutBtn">Oui</button>
				</div>

			</form>
		</div>
	</div>

<?php endif;?>



<!--Concours-->
<?php if($pageName=='concours_encours'):?>
	<div class="poPup" id="startConcours">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
				</div>
				Êtes vous sûr de vouloir commencer à jouer?
			</div>
		</div>
		<div class="poPup-content" >
			<form method="post"  id="startConcoursForm">
				<div class="i-form-bottom text-center">
					<a href="#" class="btn-no js-poPup-close">Non</a>
					<button class="btn-yes" name="startConcoursBtn">Oui</button>
				</div>

			</form>
		</div>
	</div>

	<div class="poPup" id="destoryConcours">
		<div class="poPup-head">
			<div class="poPup-head-title">
				<div class="text-center">
					<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
				</div>
				Êtes vous sûr de vouloir renoncer au jeux?
			</div>
		</div>
		<div class="poPup-content" >
			<form method="post"  id="destoryConcoursForm">
				<div class="i-form-bottom text-center">
					<a href="#" class="btn-no js-poPup-close">Non</a>
					<button class="btn-yes" name="destoryConcoursBtn">Oui</button>
				</div>

			</form>
		</div>
	</div>
<?php endif;?>


<!--General==> Statut-->
<div class="poPup" id="ChangeStatut">
	<div class="poPup-head">
		<div class="poPup-head-title">
			<div class="text-center">
				<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
			</div>
			<div class="poPup-title">Changement de statut</div>
		</div>
	</div>
	<div class="poPup-content" >
		<form method="post" class="form-login" id="ChangeStatutForm">
			<input type="hidden" data-id="0" name="id">
			<input type="hidden" data-statut="0" data-id="3" name="statut">
			<div class="i-form-textAlert">
				Êtes vous sur de vouloir <mark>éffectuer</mark> cette oppération ?
			</div>
			<div class="i-form-bottom text-center">
				<a href="#" class="btn-no js-poPup-close">Non</a>
				<button class="btn-yes" name="ChangeStatutBtn">Oui</button>
			</div>

		</form>
	</div>
</div>