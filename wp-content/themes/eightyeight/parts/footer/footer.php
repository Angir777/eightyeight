<?php 
    include get_template_directory() . '/parts/options/options.php';
?>

<footer class="site-footer border-top">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mb-5 mb-lg-0">
				<div class="row">
					<div class="col-md-12">
						<h3 class="footer-heading mb-4"><?php echo $footer_menu_title_pl ?></h3>
					</div>
					<div class="col-md-6 col-lg-6">
					<?php
						wp_nav_menu(array(
							'theme_location' => 'footer-menu-page',
							'menu_class' => 'list-unstyled',
							'container' => false,
							'depth' => 1, // Ogranicza menu do 1 poziomu, bez sub-linków
						));
					?>
					</div>
					<div class="col-md-6 col-lg-6">
					<?php
						wp_nav_menu(array(
							'theme_location' => 'footer-menu-shop',
							'menu_class' => 'list-unstyled',
							'container' => false,
							'depth' => 1, // Ogranicza menu do 1 poziomu, bez sub-linków
						));
					?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="block-5 mb-5">
					<h3 class="footer-heading mb-4"><?php echo $contact_data_title_pl ?></h3>
					<ul class="list-unstyled">
						<?php 
							if ($address) {
								echo '<li class="address">'.$address.'</li>';
							}
							if ($phone) {
								echo '<li class="phone">'.$phone.'</li>';
							}
							if ($email) {
								echo '<li class="email">'.$email.'</li>';
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="row pt-5 mt-5 text-center">
			<div class="col-md-12">
				<p>
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				Copyright &copy;<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" class="text-primary">Colorlib</a>
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				</p>
			</div>
		</div>
	</div>
</footer>