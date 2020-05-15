<div class="cli-page concours">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-hourglass-half"></i>
				<span class="text">Concours</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			
		</nav>
	</div>

	<div class="cli-page-body">
		<?php 
	
		if(!isset($this->session->concours)):
			?>
			<section class="cli-page-section concours-presentation">
				<div class="concours-presentation-lib">
					<?=$libConcour;?>
				</div>
				<table class="concours-presentation-tbl">
					<tbody>
						<tr>
							<th>Durée</th>
							<td></td>
						</tr>
						<tr>
							<th>Darticipants</th>
							<td>0</td>
						</tr>
					</tbody>
				</table>
				<div class="cli-page-section concours-bottom text-center">
					<a href="#startConcours" class="i-btn big js-open-poPup">Commencer</a>
				</div>
			</section>

			<?php
		else:

			?>
			<div id="zoneConcours" data-time="0">

				<div class="text-center">
					<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
				</div>
			</div>
			

			<?php




		endif;
		?>
	</div>

	
	
</div>