<?php

get_header();

include get_template_directory() . '/parts/options/options.php';

$front_page_id = get_option('page_on_front');
$front_page_title = get_the_title($front_page_id);

?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<section class="hero-section">
	<div class="hero-content parallax-container padding-xlarge" data-parallax="scroll" data-image-src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="page-title">
                        <?php the_title(); ?>
                    </h1>
                    <small>
                    <?php
                        // Pobranie danych o autorze
                        $post_author_id = get_the_author_meta('ID');
                        $post_author_name = get_the_author_meta('display_name');

                        // Pobranie daty publikacji
                        $post_date = get_the_date();

                        // Wyświetlenie danych o autorze i dacie publikacji
                        echo '<div class="post-meta">';
                        // echo 'Autor: <a href="' . get_author_posts_url($post_author_id) . '">' . $post_author_name . '</a> | Data publikacji: ' . $post_date;
                        echo 'Autor: ' . $post_author_name . '</a> | Data publikacji: ' . $post_date;
                        echo '</div>';
                        ?>
                    </small>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="latest-blog" class="scrollspy-section padding-large">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-8">
				<div class="post-grid">
					<div class="row p-3">
                        <?php the_content(); ?>
					</div>
                    <div class="row">
                        <!-- Nawigacja po wpisach -->
                        <nav class="single-nav">
                            <?php if (get_previous_post()) : ?>
                                <span class="nav-prev"><?php previous_post_link('%link', 'Poprzedni wpis'); ?></span>
                            <?php else : ?>
                                <span class="nav-prev empty-link"></span>
                            <?php endif; ?>
                            
                            <?php if (get_next_post()) : ?>
                                <span class="nav-next"><?php next_post_link('%link', 'Kolejny wpis'); ?></span>
                            <?php else : ?>
                                <span class="nav-next empty-link"></span>
                            <?php endif; ?>
                        </nav>
                    </div>
                    <div class="row comments">
                        <?php comments_template(); ?>
                    </div>
				</div>
			</div>
            <div class="col-12 col-md-4 pl-3 w-100">
                <!-- Widget -->
                <?php if ( is_active_sidebar( 'blog-widget' ) ) : ?>
                    <?php dynamic_sidebar( 'blog-widget' ); ?>      
                <?php endif; ?>
            </div>
		</div>
	</div>
</section>

<?php endwhile; endif; ?>

<?php

get_footer();