<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

?>

<div class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-md-12 mb-0">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Strona główna' ); ?></a> 
					<span class="mx-2 mb-0">/</span>
					<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e( 'Sklep' ); ?></a> 
				</div>
			</div>
		</div>
	</div>

<div class="site-section">
	<div class="container">
		<div class="row mb-5">
			<div class="col-md-9 order-2">
				<div class="row mb-5">
					<?php
						// $attribute_taxonomies = wc_get_attribute_taxonomies();

						// if ( $attribute_taxonomies ) {
						// 	foreach ( $attribute_taxonomies as $tax ) {
						// 		echo '<p>' . $tax->attribute_label . ' (pa_' . $tax->attribute_name . ')</p>';
						// 	}
						// } else {
						// 	echo '<p>No attribute taxonomies found</p>';
						// }
					?>

					<?php
						// Pobierz aktualną stronę (dla paginacji)
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

						// Pobierz liczbę produktów na stronę z ustawień WooCommerce
						$posts_per_page = get_option('posts_per_page');

						// Argumenty zapytania
						$args = array(
							'post_type' => 'product', // Typ postu WooCommerce
							'posts_per_page' => $posts_per_page, // Liczba produktów na stronę
							'paged' => $paged, // Aktualna strona
						);

						// Sprawdź, czy są przekazane filtry kategorii lub rozmiaru
						if (isset($_GET['kategoria-produktu']) && !empty($_GET['kategoria-produktu'])) {
							$category_slugs = explode(';', $_GET['kategoria-produktu']);
							$category_slugs = array_map('sanitize_text_field', $category_slugs);

							$args['tax_query'][] = array(
								'taxonomy' => 'product_cat',
								'field' => 'slug',
								'terms' => $category_slugs,
							);
						}

						if (isset($_GET['rozmiar']) && !empty($_GET['rozmiar'])) {
							$size_slugs = explode(';', $_GET['rozmiar']);
							$size_slugs = array_map('sanitize_text_field', $size_slugs);

							$args['tax_query'][] = array(
								'taxonomy' => 'pa_rozmiar', // pa_nazwa-wariantu
								'field'    => 'slug',
								'terms'    => $size_slugs,
								'operator' => 'IN', // Użyj operatora IN dla wielu rozmiarów
							);
						}

						// Jeśli istnieją oba filtry, użyj operatora AND między nimi
						if (isset($args['tax_query']) && count($args['tax_query']) > 1) {
							$args['tax_query']['relation'] = 'AND';
						}

						// Nowe zapytanie WP_Query
						$the_query = new WP_Query($args);

						// Pętla
						if ($the_query->have_posts()) {
							while ($the_query->have_posts()) {
								$the_query->the_post();
								global $product;
					?>
								<div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
									<div class="block-4 text-center border">
										<figure class="block-4-image">
											<a href="<?php the_permalink(); ?>">
												<?php if (has_post_thumbnail()) { 
													the_post_thumbnail('medium', array('class' => 'img-fluid'));
												} else {
													echo '<img src="' . wc_placeholder_img_src() . '" alt="' . get_the_title() . '" class="img-fluid">';
												} ?>
											</a>
										</figure>
										<div class="block-4-text p-4">
											<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<p class="mb-0"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
											<p class="text-primary font-weight-bold"><?php echo $product->get_price_html(); ?></p>
										</div>
									</div>
								</div>
					<?php
							}
							wp_reset_postdata(); // Resetowanie globalnych zmiennych post
						} else {
							echo '<p>' . __('No products found', 'woocommerce') . '</p>';
						}
					?>
            	</div>
				<div class="row" data-aos="fade-up">
					<div class="col-md-12 text-center">
						<div class="site-block-27">
							<?php 
								if (function_exists('wp_pagenavi')) {
									wp_pagenavi(array('query' => $the_query));
								} 
							?>
						</div>
					</div>
				</div>
          	</div>
			<div class="col-md-3 order-1 mb-5 mb-md-0">
				<div class="border p-4 rounded mb-4">
					<div class="mb-4">
						<!-- Widget -->
						<?php if ( is_active_sidebar( 'wc-widget-one' ) ) : ?>
							<?php dynamic_sidebar( 'wc-widget-one' ); ?>      
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 * 
 */
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
