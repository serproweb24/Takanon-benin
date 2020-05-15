<div class="cli-page ticket_regets">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-newspaper"></i>
				<span class="text">Boutique</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			
		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			<div class="cli-page-section-title">
				<span>Ticket reget - <strong>Takanon</strong></span>
			</div>
			<?php 
			if($historyElemUpdates):
				?>
				<div class="i-ticket">
					<div class="i-ticket-head">
						<div class="date"><?=$dateReget;?></div>
						<div class="text">
							<?=(isset($motif)&&!empty($motif))? $motif:'Auccun motif n\'a été défini.';?>
						</div>
					</div>
					<div class="i-ticket-dialogue">
						<div class="i-ticket-dialogue-content js-list-content-post">
							<?php 
							if($listMessages):
								foreach($listMessages as $listMessage):
									$typeUser = $listMessage->idGrpUti;
									?>
									<div class="v-discution-row">
										<div class="img">
											<?php 
											if($typeUser==1):
												$avatar = 'default/logo.png';
											else:
												$avatar = (isset($listMessage->avatar)&&!empty($listMessage->avatar))? 'users/'.$listMessage->avatar:'users/default.jpg';
											endif;
											?>
											<img src="<?=base_url().'assets/images/'.$avatar;?>" alt="user avatar">
										</div>
										<div class="content">
											<div class="head">
												<span class="name"><?=$listMessage->nom.' '.$listMessage->prenoms;?></span>
												<span class="date">Le <?=date('d-m-Y à H:i:s', strtotime($listMessage->dateCreateMessage));?></span>
												<div class="text"><?=$listMessage->message;?></div>
											</div>
										</div>
									</div>
									<?php
								endforeach;
							else:

							endif;
							?>
						</div>
					</div>
					<div class="i-ticket-bottom">
						<div class="i-edite js-edite-message" contenteditable="true" placeholder="Laissez un message">

						</div>
					</div>
				</div>
				<?php
			else:
				?>
				
				<?php
			endif;
			?>



		</section>
	</div>
</div>