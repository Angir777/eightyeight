<?php

get_header();

include get_template_directory() . '/parts/options/options.php';

$banner = get_field('banner', get_option('page_on_front'));
$icons = get_field('icons', get_option('page_on_front'));
$featured_products_title = get_field('featured_products_title', get_option('page_on_front'));
$promo = get_field('promo', get_option('page_on_front'));

?>

<div class="site-blocks-cover" style="background-image: url(<?php echo $banner['image']; ?>);" data-aos="fade">
    <div class="container">
        <div class="row align-items-start align-items-md-center justify-content-end">
            <div class="col-md-5 text-center text-md-left pt-5 pt-md-0">
            <h1 class="mb-2"><?php echo $banner['title']; ?></h1>
            <div class="intro-text text-center text-md-left">
                <p class="mb-4"><?php echo $banner['text']; ?></p>
                <p>
                    <a href="<?php echo $banner['button']['url']; ?>" class="btn btn-sm btn-primary">
                        <?php echo $banner['button']['title']; ?>
                    </a>
                </p>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section site-section-sm site-blocks-1">
    <div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
            <div class="icon mr-4 align-self-start">
                <span class="<?php echo $icons['icon_one']['icon']; ?>"></span>
            </div>
            <div class="text">
                <h2 class="text-uppercase"><?php echo $icons['icon_one']['title']; ?></h2>
                <p><?php echo $icons['icon_one']['text']; ?></p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
            <div class="icon mr-4 align-self-start">
                <span class="<?php echo $icons['icon_two']['icon']; ?>"></span>
            </div>
            <div class="text">
                <h2 class="text-uppercase"><?php echo $icons['icon_two']['title']; ?></h2>
                <p><?php echo $icons['icon_two']['text']; ?></p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
            <div class="icon mr-4 align-self-start">
                <span class="<?php echo $icons['icon_three']['icon']; ?>"></span>
            </div>
            <div class="text">
                <h2 class="text-uppercase"><?php echo $icons['icon_three']['title']; ?></h2>
                <p><?php echo $icons['icon_three']['text']; ?></p>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="site-section site-blocks-2">
    <div class="container">
        <div class="row">
            <?php
            // Pobieranie kategorii produktów z WooCommerce
            $args = array(
                'taxonomy'   => 'product_cat',
                'orderby'    => 'name',
                'show_count' => 0,
                'pad_counts' => 0,
                'hierarchical' => 1,
                'title_li'   => '',
                'hide_empty' => 0,
                'parent'     => 0 // Pobierz tylko główne kategorie
            );
            $all_categories = get_terms($args);
            
            // Inicjalizacja licznika
            $counter = 0;

            foreach ($all_categories as $category) {

                // Zatrzymaj pętlę po 2 kategoriach
                if ($counter >= 2) {
                    break;
                }

                // Pobierz miniaturkę kategorii
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image_url = wp_get_attachment_url($thumbnail_id);
                
                // Domyślny obrazek, jeśli nie ma przypisanego obrazka
                if (!$image_url) {
                    $image_url = get_stylesheet_directory_uri() . '/assets/images/default.jpg';
                }

                // Tworzenie niestandardowego linku
                $custom_link = add_query_arg('kategoria-produktu', $category->slug, home_url('/sklep/'));
                
                echo '<div class="col-sm-6 col-md-6 col-lg-6 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">';
                echo '<a class="block-2-item" href="' . esc_url($custom_link) . '">'; 
                // get_term_link($category)
                echo '<figure class="image">';
                echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($category->name) . '" class="img-fluid">';
                echo '</figure>';
                echo '<div class="text">';
                echo '<span class="text-uppercase">Collections</span>';
                echo '<h3>' . esc_html($category->name) . '</h3>';
                echo '</div>';
                echo '</a>';
                echo '</div>';

                // Zwiększenie licznika
                $counter++;
            }
            ?>
        </div>
    </div>
</div>

<div class="site-section block-3 site-blocks-2 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 site-section-heading text-center pt-4">
                <h2><?php echo $featured_products_title; ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="nonloop-block-3 owl-carousel">
                    <?php
                    // Argumenty zapytania dla polecanych produktów
                    $args = array(
                        'post_type'      => 'product', // Ensures the post type is a product
                        'post_status'    => 'publish', // Ensures the product is published
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'product_visibility', // Does a meta query on product visibility
                                'field'    => 'name',
                                'terms'    => 'featured', // Makes sure we grab all products flagged as featured
                                'operator' => 'IN',
                                ),
                            ) 
                    );

                    $loop = new WP_Query($args);

                    while ($loop->have_posts()) : $loop->the_post();
                        global $product;
                        ?>
                        <div class="item">
                            <div class="block-4 text-center">
                                <figure class="block-4-image">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('shop_catalog', array('class' => 'img-fluid')); ?>
                                    <?php else : ?>
                                        <img src="<?php echo wc_placeholder_img_src(); ?>" alt="<?php the_title(); ?>" class="img-fluid">
                                    <?php endif; ?>
                                </figure>
                                <div class="block-4-text p-4">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p class="mb-0"><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                                    <p class="text-primary font-weight-bold"><?php echo $product->get_price_html(); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;

                    wp_reset_query();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section block-8">
    <div class="container">
    <div class="row justify-content-center  mb-5">
        <div class="col-md-7 site-section-heading text-center pt-4">
            <h2><?php echo $promo['promo_title']; ?></h2>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-md-12 col-lg-7 mb-5">
            <a href="#"><img src="<?php echo $promo['image']; ?>" alt="Promo" class="img-fluid rounded"></a>
        </div>
        <div class="col-md-12 col-lg-5 text-center pl-md-5">
            <h2><a href="#"><?php echo $promo['text']; ?></a></h2>
            <p>
                <a href="<?php echo $promo['button']['url']; ?>" class="btn btn-sm btn-primary">
                    <?php echo $promo['button']['title']; ?>
                </a>
            </p>
        </div>
    </div>
    </div>
</div>

<?php

get_footer();