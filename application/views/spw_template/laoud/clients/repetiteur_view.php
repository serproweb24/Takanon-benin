<div class="cli-page repetiteur">

	<div class="cli-page-header">
		<div class="cli-page-header-title">
			<h1 class="title">
				<i class="fas fa-paperclip"></i>
				<span class="text">Répétiteur</span>
			</h1>
		</div>
		<nav class="cli-page-header-nav">
			<?php 
			if(isset($statutRep)):
				if($statutRep==0):
					$statutText ='Bloqué';
					$statutClass = 'bloquer';
				elseif($statutRep==1):
					$statutText ='En attente de validation';
					$statutClass = '';
				elseif($statutRep==2):
					$statutText ='Activé';
					$statutClass = 'actif';
				elseif($statutRep==3):
					$statutText ='Regeté';
					$statutClass = 'rejeter';
				elseif($statutRep==4):
					$statutText ='Désactivé';
					$statutClass = 'desactiver';
				endif;
			endif;
			if(isset($statutRep)&&$statutRep==2):
				$titleLink = 'Désactivér mode répétiteur';
			elseif(isset($statutRep)&&$statutRep==4):
				$titleLink = 'Activer mode répétiteur';
			else:
				$titleLink = '';
			endif;
			?>
			<a href="#<?=(isset($idRep))? 'chagerSatatutRepetiteur':'startRepetiteur' ?>" class="i-OnOff-statut <?=(isset($statutClass))? $statutClass:''?> <?=((isset($statutRep)&&$statutRep==0)||(isset($statutRep)&&$statutRep==1)||isset($statutRep)&&$statutRep==3)? '':'js-open-poPup';?> " title="<?=$titleLink;?>" >
				<span class="text"><?=(isset($statutText))? $statutText:'Compte non Activé'?></span>
			</a>
		</nav>
	</div>

	<div class="cli-page-body">
		<section class="cli-page-section">
			<div class="cli-page-section-title">
				<span>Profil répétiteur</span>
			</div>
			<div class="cli-page-section-content" >
				<?php 
				if(isset($idRep)&&!empty($idRep)):
					?>
					<div class="repetiteur-profil">
						<div class="repetiteur-profil-row">
							<div class="repetiteur-profil-row-head">
								<div class="img">
									<img src="<?=base_url().'assets/images/users/'.$user->avatar;?>" alt="user avatar">
								</div>
								<div class="infos">
									<div class="infos-row name">
										<?=$user->nom.' '.$user->prenoms;?>
									</div>
									<div class="infos-row email">
										<i class="far fa-envelope"></i>
										<?=$user->email;?>
									</div>
									<div class="infos-row phone">
										<i class="fas fa-phone"></i>
										<?=$user->telephone;?>
									</div>

									<section class="infos-matieres">
										<div class="title">
											Matières - <span><?='Cours '.$libCatNiv;?></span>
											<a href="#newMatierRepetiteur" class="i-add min js-open-poPup" title="Ajouter"></a>
										</div>
										<?php 
										if(isset($listMat)&&!empty($listMat)): 
											echo $listMat;
										else:
											echo '<div class="i-alert_empty text-with">Vous n\'avez pas définir vos Matières !!!</div>';
										endif;
										?>
									</section>

									<?php 
									//Verification de tiquet ouvert
									$idTicReg = false;
									$existTicke = existTicket($idRep,'repetiteurs',$type=true);
									if($existTicke):
										$idTicReg = $existTicke->idTicReg;
										$statutTicReg = $existTicke->statutTicReg;
									endif;

										//Commentaires en attentes
									$CountNewAlertArt = CountnewTicketReget($idTicReg,1);
									?>

									<!--La cloche de notification-->
									<?php if(($existTicke)): ?>
										<a href="<?=base_url().'clients/ticket_regets?tck='.cripterId($idTicReg,0);?>" class="i-notif"   title="Motif">
											<i class="fas fa-bell"></i>
											<small class="i-notNum"><?=$CountNewAlertArt;?></small>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<?php 
				else:
					echo '<div class="i-alert_empty ">Votre compte répétiteur n\'est pas activé !!!</div>';
				endif;
				?>
			</div>
		</section>
	</div>
</div>