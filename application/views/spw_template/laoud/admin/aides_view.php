<div class="cli-page cli-aides">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-cogs"></i>
				<span class="text">Aides</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			<a href="#newAide" class="js-open-poPup false-btn green small">
				<span class="text ">Créer une aide</span>
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
								<a href="<?=base_url().'admin/aides';?>" class="<?=(!isset($statutAid))? 'active':'';?>">Tous</a>
							</li>
							<li>
								<a href="<?=base_url().'admin/aides?sta=2';?>" class="<?=(isset($statutAid)&&$statutAid==2)? 'active':'';?>">Actifs</a>
							</li>
							<li>
								<a href="<?=base_url().'admin/aides?sta=4';?>" class="<?=(isset($statutAid)&&$statutAid==4)? 'active':'';?>">Désactivés</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="cli-page-body-main"> 
					<div class="cli-page-body-main-content">
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

									?>
									<dt class="i-accordion-item js-open-context-menu">
										<?=$listeAide->libAid;?>
										<ul class="js-contextMenuList">
											<?php if($statut!=2): ?>
												<li>
													<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-green'>Activation d'aide</span>" data-modal-text="Êtes vous sur de vouloir <mark class='text-green'>Activer</mark> 
														l'aide :  <strong><?=$libAid;?></strong> ?" data-infos="<?=$idAid."@@".$libAid."@@".$statut;?>" data-objet="false" data-type="Activer-aides">
														<i class="fas fa-check"></i>
														<span>Activer</span>
													</a>
												</li>
												<?php 
											endif;
											if($statut==2):
												?>
												<li>
													<a href="#ChangeStatut" class="js-open-poPup js-transfer_data" data-title-modal="<span class='text-red'>Désactivation d'actualité</span>" data-modal-text="Êtes vous sur de vouloir <mark class='text-green'>Désactiver</mark> 
														l'aide :  <strong><?=$libAid;?></strong> ?" data-infos="<?=$idAid."@@".$libAid."@@".$statut;?>" data-objet="false" data-type="Desactiver-aides">
														<i class="fas fa-undo"></i>
														<span>Désactiver</span>
													</a>
												</li>
											<?php endif; ?>
											<li>
												<a href="#updateAide" class="js-open-poPup js-transfer_data" data-infos="<?=$idAid."@@".$libAid."@@".$content."@@".$statut;?>" data-title-modal="<span class='text-orange'>Modifier une aide</span>">
													<i class="far fa-edit"></i>
													<span>Modifier</span>
												</a>
											</li>
										</ul>
										<i class="i-statut <?=(isset($statutClass))? $statutClass:'';?>">
											<?=(isset($statutText))? $statutText:'';?>
										</i>
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
							echo '<div class="i-alert_empty">Désolé! Auccune information disponible!</div>';
						endif;
						?>						
					</div>
				</div>

			</div>
		</section>
	</div>
</div>