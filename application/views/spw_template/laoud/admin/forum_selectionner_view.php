<div class="cli-page forum_selection">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-life-ring"></i>
				<span class="text">Forums</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
		</nav>
	</div>


	<div class="cli-page-body">
		<section class="cli-page-section">
			
			<div class="cli-page-section-content">
				
				<div class="cli-page-body-main">
					
					<div class="cli-page-body-main-content">
						
						<?php 
						if(isset($forumSelectonners)):
							?>
							<div class="v_forum-head">
								<div class="v_forum-head-title">
									<?=$sujetForum;?>
								</div>
								<div class="v_forum-head-description">
									<?=$descriptionForum;?>
								</div>
								<div class="v_forum-head-bottom">

								</div>
							</div>
							<div class="v_forum-body">
								<?php 
								if($statutForum==1):
									echo '<div class="i-alert_empty">Désolé, ce forum n\'est pas encore validé !!!</div>';
								else:
									?>
									<div class="v_forum-body-list">
										
										<?php 
										if($forumPostes):
											foreach($forumPostes as $forumPoste):
												if(!empty($forumPoste->avatar)&&($forumPoste->avatar!='error')):
													$avatar = $forumPoste->avatar;
												else:
													$avatar ='default.jpg';
												endif;
												?>
												<div class="v-discution-row">
													<div class="img">
														<img src="<?=base_url().'assets/images/users/'.$avatar ?>" alt="user avatar">
													</div>
													<div class="content">
														<div class="head">
															<span class="name"><?=$forumPoste->nom.' '.$forumPoste->prenoms;?></span>
															<span class="date"><?='Le '.date('d-m-Y à H:i:s', strtotime($forumPoste->dateCreate));?></span>
															<div class="text"><?=$forumPoste->message;?></div>
														</div>
													</div>
													<div class="bottom">

													</div>
												</div>
												<?php

											endforeach;
										else:
											echo '<div class="i-alert_empty">Désolé! auccun commentaire disponnible!</div>';
										endif;
										?>
									</div>
									<?php
									echo $pgt_nav;
								endif;
								?>
							</div>
							<?php 
						else:
							echo '<div class="i-alert_empty">Désolé, ce forum n\'existe pas !!!</div>';
						endif;
						?>
					</div>
				</div>

			</div>
		</section>
	</div>
</div>