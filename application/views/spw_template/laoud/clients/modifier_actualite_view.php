<div class="cli-page modifier_actualite">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-bullhorn"></i>
				<span class="text">Actualités</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			
		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			<div class="cli-page-section-title">
				<span>Modification</span>
			</div>
			<div class="cli-page-section-content" id="modifierActualite">
				<?php 
				if($actualites):
					if($statut==2||$statut==1):
						?>
						<form method="POST" class="modifierActualiteForm" id="modifierActualiteForm">
							<div class="i-form-row">
								<div class="i-placeholder">Photo</div>
								<input type="file" name="file" class="js-dropify" data-default-file="<?=base_url().'assets/images/actualites/'.$artAffiche;?>">
							</div>
							<div class="i-form-row">
								<div class="i-placeholder">Titre</div>
								<input type="text" name="libAct" value="<?=(isset($artTile))? $artTile:'';?>">
							</div>
							<div class="i-form-row">
								<div class="i-placeholder">Description</div>
								<textarea name="description"><?=(isset($artDescription))? $artDescription:'';?></textarea>
							</div>

							<div class="i-form-bottom text-right">
								<button class="btn-form" name="modifierActualiteBtn" data-step="1">Modifier</button>
							</div>
						</form>
						<?php 
					else:
						echo '<div class="i-alert_empty">Désolé, vous n\'etes pas autorisé à modifier ce article !!!</div>';
					endif;
				else:
					echo '<div class="i-alert_empty">Désolé, ce article séléctioné n\'existe pas !!!</div>';
				endif;
				?>
			</div>
		</section>
	</div>
</div>