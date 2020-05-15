<footer class="footer">
	<div class="footer-top">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="footer-top-content">
						<div class="footer-top-logo">
							<a href="<?=base_url();?>">
								<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo tackanon">
								<span>Takanon-benin</span>
							</a>
						</div>
						<nav class="footer-top-nav">
							<ul class="footer-top-nav-list">
								<li><a href="<?=base_url();?>" class="<?=($activePage=='')? 'active':'';?>">Accueil</a></li>
								<li><a href="<?=base_url().'services' ?>" class="<?=($activePage=='services'||$activePage=='documents'||$activePage=='repetiteurs')? 'active':'';?>">Services</a></li>
								<li><a href="actualites" class="<?=($activePage=='actualites' || $activePage=='detail_actualite')? 'active':'';?>">Actualités</a></li>
								<li><a href="concours" class="<?=($activePage=='concours')? 'active':'';?>">Concours</a></li>
								<li><a href="aide" class="<?=($activePage=='aide')? 'active':'';?>">Aide</a></li>
								<li><a href="contacts" class="<?=($activePage=='contacts')? 'active':'';?>">Contacts</a></li>
							</ul>
						</nav>
						<div class="footer-top-right">
							<div class="footer-top-right-visite">
								<?php $visiteurs = count_visitor(); ?>
								<span class="nuber"><?=200+$visiteurs;?></span>
								<span class="text">Visiteurs</span>
							</div>    
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="footer-bottom-content">
						Copyright © Takanon-benin, 2019 - Realisé par <a href="http://serproweb.ru/"><span>SerProWeb</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>



<!--======================== Genérale poPup  ========================--> 

<!--Login-->
<div class="poPup" id="login">
	<div class="poPup-head">
		<div class="poPup-head-title">
			<div class="text-center">
				<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo tackanon">
			</div>
			Connexion
		</div>
	</div>
	<div class="poPup-content" >
		<form method="post" class="form-login" id="loginForm">
			<div class="i-form-row">
				<div class="i-placeholder">Téléphone <span class="red-stars">*</span></div>
				<input type="text" name="telephone" class="js-phone" required>
			</div>
			<div class="i-form-row">
				<div class="i-placeholder">Mot de passe <span class="red-stars">*</span></div>
				<div class="block-password">
					<input type="password" name="password" required>
					<a href="#" class="block-password-show js-show-password"><i class="fas fa-eye"></i></a>
				</div>
			</div>
			
			<div class="i-form-bottom text-center">
				<button class="btn-form" name="loginBtn">Se connecter</button>
			</div>

			<div class="login-form-bottom text-center">
				<p class="login-form-bottom-forgetPass">
					<a href="#forget_pass" class="i-link js-open-poPup"><span>Mot de passe oublié</span></a>
				</p>
				<span>Vous n'avez pas encore de compte?</span> <a href="#register" class="i-link js-open-poPup"><span>S'inscrire</span></a>
			</div>

		</form>
	</div>
</div>

<!--Inscription-->
<div class="poPup" id="register">
	<div class="poPup-head">
		<div class="poPup-head-title">
			<div class="text-center">
				<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo tackanon">
			</div>
			<span class="title">Inscription</span>
		</div>
	</div>
	<div class="poPup-content" >
		<form method="post" class="form-login" id="registerForm">
			<div class="js-step-1">
				<div class="x2">
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Nom <span class="red-stars">*</span></div>
						<input type="text" name="nom" minlength="3" required>
					</div>
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Prénoms <span class="red-stars">*</span></div>
						<input type="text" name="prenoms" minlength="3" required>
					</div>
				</div>
				<div class="i-form-row">
					<div class="i-placeholder">Je suis <span class="red-stars">*</span></div>
					<select name="idUseCat">
						<option value="">----- Choisir -----</option>
						<?php 
						$categorieUsers = categorieUsers();
						if($categorieUsers):
							foreach($categorieUsers as $categorieUser):
								echo '<option value="'.$categorieUser->idUseCat.'">'.$categorieUser->libUsCat.'</option>';
							endforeach;			
						endif;
						?>
					</select>
				</div>
				<div class="x2">
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Téléphone <span class="red-stars">*</span></div>
						<input type="text" name="telephone" class="js-phone" required>
					</div>
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Email <span class="red-stars">*</span></div>
						<input type="text" name="email" required>
					</div>
				</div>
				<div class="x2">
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Mot de passe <span class="red-stars">*</span></div>
						<div class="block-password">
							<input type="password" name="password" class="password" minlength="8" required>
							<a href="#" class="block-password-show js-show-password"><i class="fas fa-eye"></i></a>
						</div>
					</div>
					<div class="i-form-row x2-elem">
						<div class="i-placeholder">Confirmer le mot de passe <span class="red-stars">*</span></div>
						<div class="block-password">
							<input type="password" name="password-repeat"  class="password-repeate" required>
							<a href="#" class="block-password-show js-show-password"><i class="fas fa-eye"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="js-step-2" >
			</div>
			
			<div class="i-form-bottom text-center">
				<button class="btn-form" name="registerBtn" data-step="1">S'inscrire</button>
			</div>

			<div class="login-form-bottom text-center">
				<span>Vous avez déja un compte?</span> <a href="#login" class="i-link js-open-poPup"><span>Se Connecter</span></a>
			</div>
		</form>
	</div>
</div>

<!--Mot de passe oublié-->
<div class="poPup" id="forget_pass">
	<div class="poPup-head">
		<div class="poPup-head-title">
			<div class="text-center">
				<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo tackanon">
			</div>
			<div class="title">Mot de passe oublié</div>
		</div>
	</div>
	<div class="poPup-content" >
		<form method="post" class="form-forget_pass" id="forget_passForm" data-step="1">
			<div class="js-step-1">
				<div class="i-form-row">
					<div class="i-placeholder">Email <span class="red-stars">*</span></div>
					<input type="email" name="email"  required>
				</div>
			</div>
			<div class="i-form-bottom text-center">
				<button class="btn-form" name="forget_passBtn">Suivant</button>
			</div>
		</form>
	</div>
</div>


<!--PreviewDoc-->
<div class="poPup PreviewDoc" id="PreviewDoc">
	<div class="poPup-content">
		<form method="POST" id="PreviewDocForm">
			<input type="hidden" name="idArt" data-id="0">
			<input type="hidden" name="nameArt" data-id="1">
			<input type="hidden" name="priceArt" data-id="2">
			<div class="PreviewDoc-body-head">
				<div class="PreviewDoc-body-head-img">
					<img src="<?=base_url().'assets/images/default/img-document.png' ?>" alt="document tackanon">
				</div>
				<div class="PreviewDoc-body-head-infos">
					<strong class="PreviewDoc-body-head-infos-row name" data-id="1">
						
					</strong>
					<strong class="PreviewDoc-body-head-infos-row price" data-id="2">
					</strong>
					
					<div class="PreviewDoc-body-head-infos-row desc">
						<h5 class="title">Description</h5>
						<div class="text" data-id="3">
							Aucune description disponible.
						</div> 
					</div>
					<div class="PreviewDoc-body-head-infos-row autor">
						<strong>Proposé par: </strong> <span class="name" data-id="4"></span>
					</div>
				</div>
			</div>
			<div class="PreviewDoc-body-main text-center">
				<button class="add-in-cart false-btn blue js-add-in-cart" name="add-in-cartBtn">Ajouter au panier</button>
			</div>
		</form>
	</div>
</div>
</div>

