<div class="contacts_body page">

	<div class="face-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="face-page-content">
						<h1 class="h1 title-page">
							<span><?=(isset($pageTitle)? $pageTitle:'');?></span>
						</h1>
						<img src="<?=base_url().'assets/images/default/img-3.png' ?>" class="face-page-img" alt="image tackanon">
					</div>
				</div>
			</div>
		</div>
	</div>




	<div class="contacts_block pBlock">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="contacts_block-content">
						<div class="contacts_block-content-left">
							<div class="contacts_block-content-left-row">
								<a href="telto:+22997750144" class="phone">
									(+229) 97-75-01-44
								</a>
							</div>
							<div class="contacts_block-content-left-row">
								<a href="mailto:contacts@takanon-benin.com" class="email">
									contacts@takanon-benin.com
								</a>
							</div>
							<ul class="rl-list">
								<li>
									<a href="https://www.facebook.com/takanonbenin/" class="fac"></a>
								</li>
								<li>
									<a href="https://www.instagram.com/takanon_benin/" class="inst"></a>
								</li>
								<li>
									<a href="https://twitter.com/takanon_benin" class="twe"></a>
								</li>
							</ul>
						</div>
						<div class="contacts_block-content-tube">
							<div class="contacts_block-content-tube-head">
								<div class="title h2"><span>Laissez nous un message</span></div>
							</div>
							<div class="contacts_block-content-body">
								<form method="post" id="newMessageForm">
									<div class="i-form-row">
										<div class="i-placeholder">Votre nom <span class="red-stars">*</span></div>
										<input type="text" name="nom_prenoms"  required>
									</div>
									<div class="x2">
										<div class="i-form-row x2-elem">
											<div class="i-placeholder">Téléphone <span class="red-stars">*</span></div>
											<input type="text" name="phone" class="js-phone" required>
										</div>
										<div class="i-form-row x2-elem">
											<div class="i-placeholder"> Email </div>
											<input type="email" name="email" >
										</div>
									</div>
									<div class="i-form-row">
										<div class="i-placeholder">Objet <span class="red-stars">*</span></div>
										<input type="text" name="objet"  required>
									</div>
									<div class="i-form-row">
										<div class="i-placeholder">Message<span class="red-stars">*</span></div>
										<textarea name="messages"   required></textarea>
									</div>

									<div class="i-form-bottom text-center">
										<button class="btn-form" name="newMessageBtn">Envoyer</button>
									</div>

								</form>
							</div>
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>




</div>