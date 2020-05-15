<div class="aide_body page">

	<div class="face-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="face-page-content">
						<h1 class="h1 title-page">
							<span><?=(isset($pageTitle)? $pageTitle:'');?></span>
						</h1>
						<img src="<?=base_url().'assets/images/default/img-3.png' ?>" class="face-page-img" alt="image takanon">
					</div>
				</div>
			</div>
		</div>
	</div>




	<div class="aide_block pBlock">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="aide_block-content">
						<h2 class="h2"><span>Les questions qui reviennent souvent</span></h2>
						
						<?php 
						if($listeAides):
							?>
							<dl class="i-accordion">
								<?php
								foreach($listeAides as $listeAide):
									$idAid = $listeAide->idAid;
									$libAid = $listeAide->libAid;
									$content = $listeAide->content;
									$statut = $listeAide->statut;
									?>
									<dt class="i-accordion-item">
										<?=$listeAide->libAid;?>
									</dt>
									<dd class="i-accordion-item-content">
										<?=$listeAide->content;?>
									</dd>
									<?php
								endforeach;
								?>
							</dl>
							<?php
							echo $pgt_nav;
						else:
							echo '<div class="i-alert_empty">Bientôt disponible!</div>';
						endif;
						?>	
					</div>
				</div>
			</div>
		</div>
	</div>




</div>