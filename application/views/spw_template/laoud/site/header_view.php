<header class="header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="header_content">
					<div class="header-logo">
						<a href="<?=base_url();?>">
							<img src="<?=base_url().'assets/images/default/logo.png' ?> " alt="logo Takanon-benin">
							<span>Takanon-benin</span>
						</a>
					</div>
					<nav class="header-nav">
						<ul class="header-nav-list">
							<li><a href="<?=base_url();?>" class="<?=($activePage=='')? 'active':'';?>">Accueil</a></li>
							<li><a href="<?=base_url().'services' ?>" class="<?=($activePage=='services'||$activePage=='documents'||$activePage=='repetiteurs')? 'active':'';?>">Services</a></li>
							<li><a href="<?=base_url().'actualites';?>" class="<?=($activePage=='actualites' || $activePage=='detail_actualite')? 'active':'';?>">Actualités</a></li>
							<li><a href="<?=base_url().'concours';?>" class="<?=($activePage=='concours')? 'active':'';?>">Concours</a></li>
							<li><a href="<?=base_url().'aide';?>" class="<?=($activePage=='aide')? 'active':'';?>">Aide</a></li>
							<li><a href="<?=base_url().'contacts';?>" class="<?=($activePage=='contacts')? 'active':'';?>">Contacts</a></li>
						</ul>
					</nav>
					<div class="header-right">
						<?php 
						//Totale qty
						$totalQty = 0;
						if($this->cart->contents()):
							foreach($this->cart->contents() as $item):
								$totalQty++;
							endforeach;
						endif;
						?>
						<a href="<?=base_url().'panier';?>" class="false-btn link-cart" title="Voir le panier">
							<span class="text"><?='Document'.(($totalQty>1)? 's':'');?></span>
							<span class="nber js-countArt">0</span>
						</a> 
						<a href="#login" class="false-btn link-login js-open-poPup" title="Se connecter">
							<span class="text">Connexion</span>
						</a>   
						<a href="#" class="btn-menu-phone js-btn-menu"><span></span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
