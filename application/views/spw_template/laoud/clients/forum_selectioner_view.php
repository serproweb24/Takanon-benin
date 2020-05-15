<div class="cli-page forum_selection">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-life-ring"></i>
				<span class="text">Forums</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			<a href="#NewForum" class="js-open-poPup false-btn green small">
				<span class="text ">Créer un forum</span>
			</a>
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
									<div class="v_forum-body-list" id="listCommentsForum" data-offset="1">

									</div>
									<div class="v_forum-body-bottom">
									<div class="i-edite js-edite" contenteditable="true" data-forum='<?=(isset($idForumCripter))? $idForumCripter:"";?>'>
										
									</div>
								</div>
									<?php
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