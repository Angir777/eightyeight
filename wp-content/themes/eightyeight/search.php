<?php

get_header();

include get_template_directory() . '/parts/options/options.php';

$front_page_id = get_option('page_on_front');
$front_page_title = get_the_title($front_page_id);

?>

<section class="hero-section">
	<div class="hero-content parallax-container padding-xlarge" data-parallax="scroll" data-image-src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="page-title">
                        <?php 
                            echo $search_title_pl; 
                        ?>
                        <br /><i>"<small><?php echo esc_html(get_search_query()); ?></small>"</i>
                    </h1>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="site-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
					<div class="row">
                        <?php
                            // Pobierz aktualną stronę (dla paginacji)
                            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            
                            // Pobierz liczbę wpisów na stronę z ustawień WordPressa
                            $posts_per_page = get_option('posts_per_page');

                            // Pobierz frazę wyszukiwania
                            $search_query = get_search_query();

                            // Argumenty zapytania
                            $args = array(
                                's'              => $search_query, // Fraza wyszukiwania
                                'posts_per_page' => $posts_per_page, // Liczba postów na stronę z ustawień WordPressa
                                'paged'          => $paged, // Aktualna strona
                            );

                            // Nowe zapytanie WP_Query
                            $the_query = new WP_Query( $args );

                            // Pętla
                            if ( $the_query->have_posts() ) {
                                while ( $the_query->have_posts() ) {
                                    $the_query->the_post(); 
                        ?>
                                    <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
									    <div class="block-4 text-center border">
                        <?php
                                                if ( has_post_thumbnail() ) {
                                                    $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
                                                } else {
                                                    $thumbnail_url = null;
                                                }
                                                   
                                                if ( $thumbnail_url) {
                                                    echo '
                                                        <figure class="block-4-image">
                                                            <a href="' . get_permalink() . '">
                                                                <img src="' . esc_url( $thumbnail_url ) . '" alt="" class="img-fluid">			
                                                            </a>
                                                        </figure>
                                                    ';
                                                }
                        ?>
                                            <div class="block-4-text p-4">		
                                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                <p class="mb-0"><?php the_excerpt(); ?></p>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                                wp_reset_postdata(); // Resetowanie globalnych zmiennych post
                            } else {
                                echo '<p>' . $no_posts_pl . '</p>'; 
                            }
                        ?>
					</div>
                    <div class="row">
                        <?php 
                            if (function_exists('wp_pagenavi')) {
                                // WP-PageNavi plugin
                                wp_pagenavi();
                            } 
                        ?>
                    </div>
			</div>
		</div>
	</div>
</section>

<?php

get_footer();