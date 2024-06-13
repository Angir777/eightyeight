<?php

get_header();

$front_page_id = get_option('page_on_front');
$front_page_title = get_the_title($front_page_id);

?>

<div class="bg-light py-3">
	<div class="container">
		<div class="row">
			<div class="col-md-12 mb-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e($front_page_title); ?></a> <span class="mx-2 mb-0">/</span> <strong class="text-black"><?php echo the_title(); ?></strong></div>
		</div>
	</div>
</div> 

<div class="site-section border-bottom" data-aos="fade">
	<div class="container">
		<div class="row mb-5">
			<div class="col-md-12">
			
				<div class="site-section-heading pt-3 mb-4">
					<h2 class="text-black"><?php echo the_title(); ?></h2>
				</div>
				
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
				
			</div>
		</div>
	</div>
</div>

<?php

get_footer();