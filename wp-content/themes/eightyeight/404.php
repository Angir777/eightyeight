<?php

get_header();

include get_template_directory() . '/parts/options/options.php';

$front_page_id = get_option('page_on_front');
$front_page_title = get_the_title($front_page_id);
$error_code = "404";

$error_title = $error_title_pl;
$error_text = $error_text_pl;

?>

<div class="site-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2 class="display-3 text-black"><?php esc_html_e($error_code); ?></h2>
				<p class="lead mb-5"><?php esc_html_e($error_title); ?></p>
				<p><?php esc_html_e($error_text); ?> <br> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-sm btn-primary"><?php esc_html_e($front_page_title); ?></a></p>
			</div>
		</div>
	</div>
</div>

<?php

get_footer();