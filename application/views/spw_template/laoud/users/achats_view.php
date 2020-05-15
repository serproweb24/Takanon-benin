<div class="cli-page boutique">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-shopping-cart"></i>
				<span class="text">Mes achats</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			

			<div class="cli-page-section-content cli_with-sidebar">
				<div class="cli-page-body-sidebar">
					<div class="cli-page-body-sidebar-menu">
						<?php
						if($listCategorieArt):
							?>
							<ul class="cli-page-body-sidebar-menu-list big">
								<li><a href="<?=base_url().'users/achats';?>" class="<?=(!isset($idArtCat))? 'active':'';?>">Tous les articles</a></li>
								<?php
								foreach($listCategorieArt as $value):
									//count total post
									$countAllPost = GetCountNewEllem('paniers_content',array('idAcheteur'=>$user->idUse,'idArtCar'=>$value->idArtCar),true);


									$activeLinck = (isset($idArtCat)&&$idArtCat==$value->idArtCar)? 'active':'';

									echo ' 
									<li>
									<a href="'.base_url().'users/achats?cat='.$value->idArtCar.'" class="'.$activeLinck.'">'.$value->libArtCar.' 
									<span class="i-num">'.number_format($countAllPost, 0, ',', ' ').'</span>
									</a>
									</li> 
									';
								endforeach;
								?>
							</ul>
							<?php
						endif;
						?>
					</div>
					

				</div>

				<div class="cli-page-body-main">
					<div class="cli-page-body-main-head">
						<div class="cli-page-body-main-head-left">

						</div>
						<div class="cli-page-body-main-head-right">

						</div>
					</div>

					<div class="cli-page-body-main-content">
						<?php 
						if($achats):
							?>
							<table>
								<thead>
									<tr>
										<th>#</th>
										<th>Articles</th>
										<th>Vendeur</th>
										<th>Prix U.</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 0;
									foreach($achats as $achat):
										$i++;
										$idVendeur = $achat->idVendeur;
										$article = $achat->libArt;
										$prixArt = $achat->prix_u;
										$nomDoc = $achat->nomDoc;
										$dateAchat = date('d-m-Y à H:i', strtotime($achat->dateCreatePan));

										//Infos vendeur
										$vendeurs = $this->spw_model->get_rows('users', array('idUse'=>$idVendeur));
										foreach($vendeurs as $vendeur):
											$leVendeur = $vendeur->nom.' '.$vendeur->prenoms;
										endforeach;

										?>
										<tr>
											<td><?=$i;?></td>
											<td>
												<div class="imgArt">
													<img src="<?=base_url().'assets/images/default/img-document.png';?>" alt="document takkanon">
												</div>
												<?=$article;?>
												<small class="smallDate block"><?='le '.$dateAchat;?></small>
											</td>
											<td><?=$leVendeur;?></td>
											<td><?=number_format($prixArt, 0, ',', ' ').'f';?></td>
											<td>
												<a href="<?=base_url().'ouvrir_fichier?file='.$nomDoc.'&type=documents/posts' ?>" class="link-download" title="Télécharger"><i class="fas fa-download"></i></a>
											</td>
										</tr>
										<?php
									endforeach;
									?>
								</tbody>
							</table>
							<?php
							echo $pgt_nav;
						else:
							echo '<div class="i-alert_empty ">Aucune information disponible !!!</div>';
						endif;
						?>
					</div>
				</div>
			</div>


		</section>
	</div>
</div>

