<div class="cli-page mon_compte">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-user"></i>
				<span class="text">Mon compte</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			<ul class="cli-page-menu">
				<li>
					<a href="#updatePassword" class="js-open-poPup">
						<i class="fas fa-key"></i>
						<span class="text">Changer mot de passe</span>
					</a>
				</li>
			</ul>
		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			<div class="cli-page-section-title">
				<span>Modification</span>
			</div>
			<div class="cli-page-section-content" id="modifierCompteForm">
				<form method="POST" id="modifierCompteFrom">
					<div class="x2">
						<div class="i-form-row x2-elem">
							<div class="mon_compte_view-avartar">
								<a href="#updateAvatar" class="js-open-poPup">
									<img src="<?=base_url().'assets/images/users/'.$user->avatar;?>" alt="user avatar">
								</a>
								<span class="alert">
									<i class="far fa-image"></i>
									Changer la photo de profile
								</span>
							</div>
						</div>
						<div class="x2-elem">
							<div class="i-form-row">
								<div class="i-placeholder">Nom <span class="red-stars">*</span></div>
								<input type="text" name="nom" minlength="3" value="<?=$user->nom;?>" required>
							</div>
							<div class="i-form-row">
								<div class="i-placeholder">Prénoms <span class="red-stars">*</span></div>
								<input type="text" name="prenoms" minlength="3" value="<?=$user->prenoms;?>" required>
							</div>
							<div class="i-form-row">
								<div class="i-placeholder">Téléphone <span class="red-stars">*</span></div>
								<input type="text" name="telephone" class="js-phone" value="<?=$user->telephone;?>" required>
							</div>
							<div class="i-form-row">
								<div class="i-placeholder">Email <span class="red-stars">*</span></div>
								<input type="text" name="email" value="<?=$user->email;?>" required>
							</div>

						</div>
					</div>
					<div class="x2">
						<div class="i-form-row x2-elem">
							<div class="i-placeholder">Pays<span class="red-stars">*</span></div>
							<select name="idPay">
								<option value="">----- Choisir -----</option>
								<?php 
								$pays = tousLesPays();
								if($pays):
									foreach($pays as $pay):
										$selected = ($idPay==$pay->idPay)? 'selected="selected"':'';
										echo '<option value="'.$pay->idPay.'"  '.$selected.'>'.$pay->libPay.'</option>';
									endforeach;

								endif;
								?>
							</select>
						</div>
						<div class="i-form-row x2-elem">
							<div class="i-placeholder">Ville<span class="red-stars">*</span></div>
							<select name="idVil">
								<option value="">----- Choisir -----</option>
								<?php 
								$villes = toutesLesVilles();
								if($villes):
									foreach($villes as $ville):
										$selected = ($idVil==$ville->idVil)? 'selected="selected"':'';
										echo '<option value="'.$ville->idVil.'" data-paye="'.$ville->idPay.'"  '.$selected.'>'.$ville->libVil.'</option>';
									endforeach;

								endif;
								?>
							</select>
						</div>
					</div>
					<div class="i-form-row">
						<div class="i-placeholder">Adresse<span class="red-stars">*</span></div>
						<input type="text" name="adresse" value="<?=$user->adresse;?>"  required>
					</div>
					<div class="i-form-row">
						<div class="i-placeholder">Description</div>
						<textarea name="description" > <?=$user->description;?> </textarea>
					</div>
					<div class="i-form-bottom text-right">
						<button class="btn-form" name="modifierCompteBtn" data-step="1">Modifier</button>
					</div>
				</form>
			</div>
		</section>
	</div>
</div>