<section class="sideb-menu">
	<ul class="sideb-menu-list i-sidebar-list">
		<li>
			<a href="<?=base_url()."users";?>" class="<?=($activePage=='' || $activePage=='mon_compte')? 'active':'';?>">
				<i class="fas fa-home"></i>
				<span class="text">Accueil</span>
			</a>
		</li>
		<li>
			<a href="<?=base_url()."users/achats";?>" class="<?=($activePage=='achats')? 'active':'';?>">
				<i class="fas fa-shopping-cart"></i>
				<span class="text">Mes achats</span>
			</a>
		</li>
		<li>
			<a href="<?=base_url()."users/forums";?>" class="<?=($activePage=='forums'||$activePage=='mes_forums')? 'active':'';?>">
				<i class="fas fa-life-ring"></i>
				<span class="text">Forums</span>
			</a>
		</li>
		<li>
			<a href="<?=base_url()."users/messages";?>" class="<?=($activePage=='messages')? 'active':'';?>">
				<i class="fas fa-comments"></i>
				<span class="text">Message</span>
			</a>
		</li>
		<li>
			<a href="<?=base_url()."users/concours";?>" class="<?=($activePage=='concours')? 'active':'';?>">
				<i class="fas fa-hourglass-half"></i>
				<span class="text">Concours</span>
			</a>
		</li>
	</ul>
</section>