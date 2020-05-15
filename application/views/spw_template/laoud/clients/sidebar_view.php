<section class="sideb-menu">
	<?php $user = user_connected(); ?>
	<ul class="sideb-menu-list i-sidebar-list">
		<li>
			<a href="<?=base_url()."clients";?>" class="<?=($activePage=='' || $activePage=='mon_compte')? 'active':'';?>">
				<i class="fas fa-home"></i>
				<span class="text">Accueil</span>
			</a>
		</li>
		
		<li>
			<a href="<?=base_url()."clients/boutique";?>" class="<?=($activePage=='boutique')? 'active':'';?>">
				<i class="fas fa-newspaper"></i>
				<span class="text">Boutique</span>
			</a>
		</li>
		<li>
			<a href="<?=base_url()."clients/forums";?>" class="<?=($activePage=='forums')? 'active':'';?>">
				<i class="fas fa-life-ring"></i>
				<span class="text">Forums</span>
			</a>
		</li>
		<li>
			<a href="<?=base_url()."clients/actualites";?>" class="<?=($activePage=='actualites')? 'active':'';?>">
				<i class="fas fa-bullhorn"></i>
				<span class="text">Actualités</span>
			</a>
		</li>
		<?php
		if($user->idUseCat==1):
			?>
			<li>
				<a href="<?=base_url()."clients/repetiteur";?>" class="<?=($activePage=='repetiteur')? 'active':'';?>">
					<i class="fas fa-paperclip"></i>
					<span class="text">Répétiteur</span>
				</a>
			</li>
			<?php
		endif; 
		?>
		<?php 
		/*
		<li>
			<a href="<?=base_url()."clients/messages";?>" class="<?=($activePage=='messages')? 'active':'';?>">
				<i class="fas fa-user-alt"></i>
				<span class="text">Parrainage</span>
			</a>
		</li>
		*/
		?>
		
		<li>
			<a href="<?=base_url()."clients/messages";?>" class="<?=($activePage=='messages')? 'active':'';?>">
				<i class="fas fa-comments"></i>
				<span class="text">Message</span>
			</a>
		</li>
		<li>
			<a href="<?=base_url()."clients/concours";?>" class="<?=($activePage=='concours')? 'active':'';?>">
				<i class="fas fa-hourglass-half"></i>
				<span class="text">Concours</span>
			</a>
		</li>
		<li>
			<a href="<?=base_url()."clients/parametres";?>" class="<?=($activePage=='parametres')? 'active':'';?>">
				<i class="fas fa-cogs"></i>
				<span class="text">Parametre</span>
			</a>
		</li>
	</ul>
</section>