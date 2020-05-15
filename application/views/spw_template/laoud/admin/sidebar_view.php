<section class="sideb-menu">
	<ul class="sideb-menu-list i-sidebar-list">
		<li>
			<a href="<?=base_url()."admin";?>" class="<?=($activePage=='' || $activePage=='mon_compte')? 'active':'';?>">
				<i class="fas fa-home"></i>
				<span class="text">Accueil</span>
			</a>
		</li>
		<li>
			<?php $countAttentUsers = GetCountNewEllem('users',array('statut'=>1),true); ?>
			<a href="<?=base_url()."admin/users";?>" class="<?=($activePage=='users')? 'active':'';?>">
				<i class="fas fa-users"></i>
				<span class="text">Utilisateurs</span>
				<span class="i-num  <?=($countAttentUsers>0)? 'active':'';?>"><?=$countAttentUsers;?></span>
			</a>
		</li>
		
		<li>
			<?php $attenteArticle = infos_articles(array('statut'=>1),true); ?>
			<a href="<?=base_url()."admin/articles";?>" class="<?=($activePage=='articles')? 'active':'';?>">
				<i class="fas fa-newspaper"></i>
				<span class="text">Articles</span>
				<span class="i-num  <?=($attenteArticle>0)? 'active':'';?>"><?=$attenteArticle;?></span>
			</a>
		</li>
		<li>
			<?php $attenteForum = infos_forums(array('statut'=>1),true); ?>
			<a href="<?=base_url()."admin/forums";?>" class="<?=($activePage=='forums')? 'active':'';?>">
				<i class="fas fa-life-ring"></i>
				<span class="text">Forums</span>
				<span class="i-num  <?=($attenteForum>0)? 'active':'';?>"><?=$attenteForum;?></span>
			</a>
		</li>
		<li>
			<?php $attenteActualites = infos_actualites(array('statut'=>1),true); ?>
			<a href="<?=base_url()."admin/actualites";?>" class="<?=($activePage=='actualites')? 'active':'';?>">
				<i class="fas fa-bullhorn"></i>
				<span class="text">Actualités</span>
				<span class="i-num  <?=($attenteActualites>0)? 'active':'';?>"><?=$attenteActualites;?></span>
			</a>
		</li>
		<li>
			<?php $countAttenteRepetiteur = infos_repetiteurs(array('statut'=>1),true); ?>
			<a href="<?=base_url()."admin/repetiteurs";?>" class="<?=($activePage=='repetiteurs')? 'active':'';?>">
				<i class="fas fa-paperclip"></i>
				<span class="text">Répétiteur</span>
				<span class="i-num  <?=($attenteActualites>0)? 'active':'';?>"><?=$countAttenteRepetiteur;?></span>
			</a>
		</li>
		<li>
			<?php $countAttentMessages = GetCountNewEllem('messages',array('statut'=>1),true); ?>
			<a href="<?=base_url()."admin/messages";?>" class="<?=($activePage=='messages')? 'active':'';?>">
				<i class="fas fa-comments"></i>
				<span class="text">Message</span>
				<span class="i-num  <?=($countAttentMessages>0)? 'active':'';?>"><?=$countAttentMessages;?></span>
			</a>
		</li>
		<li>
			<a href="<?=base_url()."admin/concours";?>" class="<?=($activePage=='concours' || $activePage=='questions')? 'active':'';?>">
				<i class="fas fa-hourglass-half"></i>
				<span class="text">Concours</span>
			</a>
			<ul>
				<li>
					<a href="<?=base_url()."admin/concours";?>">Tous les concours</a>
				</li>
				<li>
					<a href="<?=base_url()."admin/questions";?>">Toutes les questions</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="<?=base_url()."admin/parametres";?>" class="<?=($activePage=='parametres' || $activePage=='aides')? 'active':'';?>">
				<i class="fas fa-cogs"></i>
				<span class="text">Parametre</span>
			</a>
			<ul>
				<li>
					<a href="<?=base_url()."admin/categories";?>">Categories</a>
				</li>
				<li>
					<a href="<?=base_url()."admin/aides";?>">Aides</a>
				</li>
			</ul>
		</li>
	</ul>
</section>