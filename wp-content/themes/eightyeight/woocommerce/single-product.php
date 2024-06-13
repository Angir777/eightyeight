<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<div class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-md-12 mb-0">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Strona Główna' ); ?></a> 
					<span class="mx-2 mb-0">/</span>
					<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e( 'Sklep' ); ?></a> 
					<span class="mx-2 mb-0">/</span>
					<strong class="text-black"><?php the_title(); ?></strong>
				</div>
			</div>
		</div>
	</div>

	<div class="site-section">
		<div class="container">
			
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>

					<?php do_action('woocommerce_before_single_product'); ?>

					<div id="product-<?php the_ID(); ?>" class="row" <?php wc_product_class(); ?>>
						<div class="col-md-6">
							<?php
								/**
								 * woocommerce_before_single_product_summary hook.
								 *
								 * @hooked woocommerce_show_product_sale_flash - 10
								 * @hooked woocommerce_show_product_images - 20
								 */
								// do_action('woocommerce_before_single_product_summary');
							?>
							<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) );
								}

								$attachment_ids = $product->get_gallery_image_ids();
								if ( $attachment_ids ) {
									foreach ( $attachment_ids as $attachment_id ) {
										$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
										echo '<img src="' . esc_url( $image_url ) . '" class="img-fluid" alt="' . esc_attr( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) . '" />';
									}
								}
							?>
						</div>
						<div class="col-md-6">
							<h2 class="text-black"><?php the_title(); ?></h2>
							
							<p><?php the_excerpt(); ?></p>
							
							<p class="mb-4"><?php the_content(); ?></p>
							
							<p><strong class="text-primary h4"><?php wc_get_template('single-product/price.php'); ?></strong></p>
							
							<div class="mb-1 d-flex">
								<?php woocommerce_template_single_add_to_cart(); ?>
							</div>
						</div>
					</div>

					<?php do_action('woocommerce_after_single_product'); ?>
				<?php endwhile; ?>
			
		</div>
	</div>

<?php

get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
