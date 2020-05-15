<div class="panier_body page">

	<div class="face-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="face-page-content">
						<h1 class="h1 title-page">
							<span><?=(isset($pageTitle)? $pageTitle:'');?></span>
						</h1>
						<img src="<?=base_url().'assets/images/default/img-3.png' ?>" class="face-page-img" alt="image tackanon">
					</div>
				</div>
			</div>
		</div>
	</div>



	<div class="panier_block pBlock">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="panier_block-content">
						<div class="panier_block-content-head">
							<h2 class="h2 pBlock-panier">
								<?php 
								if(isset($this->session->user_connected)&&$this->session->user_connected['idGrpUti']==3):
									echo '<span>Panier de <strong>'.$this->session->user_connected['nom'].' '.$this->session->user_connected['prenoms'].'</strong></span>';
								else:
									echo '<span>Votre <strong>Panier</strong></span>';
								endif;
								?>
								
							</h2>
						</div>
						
						<div class="panier_block-content-body js-cart-view">
							<?php 
							//Totale qty
							/*$totalQty = 0;
							if($this->cart->contents()):
								?>
								<ul class="i-panier-content-list ">
									<?php 
									foreach($this->cart->contents() as $item):
										$totalQty++;
										$prixUnitaireArt = $item['price'];
										$prixToatalArt = $item['subtotal'];
										$nameToatalArt = $item['name'];
										$qtyToatalArt = $item['qty'];
										?>
										<li class="i-panier-content-list-item">
											<div class="i-panier-content-list-item-left">
												<div class="top">
													<div class="img">
														<img src="<?=base_url().'assets/images/default/img-document.png' ?>" alt="document tackanon">
													</div>
													<div class="name">
														<?=$nameToatalArt;?>
													</div>
												</div>

											</div>
											<div class="i-panier-content-list-item-right">
												<div class="price">
													<?=number_format($prixUnitaireArt, 0, ',', ' ').'F'; ?>
												</div>
												<div class="quantite">
													<span class="moin js-calc-moin">-</span>
													<input type="number" value="<?=number_format($qtyToatalArt, 0, ',', ' '); ?>">
													<span class="plus js-calc-plus">+</span>
												</div>
												<div class="prixTU"><?=number_format($prixToatalArt, 0, ',', ' ').'F'; ?></div>
												<a href="#" class="supprimer">x</a>
											</div>
										</li>
										<?php
									endforeach;
								else:
									?>
								</ul>
								<div class="i-alert">
									Votre panier est vide!
								</div>
								<?php
							endif;*/
							?>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>