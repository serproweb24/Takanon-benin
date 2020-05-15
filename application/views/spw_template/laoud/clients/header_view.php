<header class="cli_header">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="cli_header-content">
					<div class="cli_header-left">
						<a href="<?=base_url()."clients";?>" class="cli_header-logo">
							<span class="img">
								<img src="<?=base_url().'assets/images/default/logo_with.png';?> " alt="logo Takanon-benin">
							</span>
							<span class="name">Takanon-benin</span>
						</a>
					</div>
					<div class="cli_header-right">
						<ul class="i-user-list">
							<li>
								<a href="#" class="js-open-user-menu">
									<i class="fas fa-user-circle"></i>
									<span class="name">
										<?=$this->session->user_connected['nom'].' '.$this->session->user_connected['prenoms'];?>
									</span>
								</a>
								<ul class="i-user-menu-list">
									<li>
										<a href="<?=base_url().'clients/mon_compte';?>">
											<i class="fas fa-user"></i>
											<span class="text">Mon compte</span>
										</a>
									</li>
									<li>
										<a href="<?=base_url().'logout';?>">
											<i class="fas fa-sign-out-alt"></i>
											<span class="text">Se déconnecter</span>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
