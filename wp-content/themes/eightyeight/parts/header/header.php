<header class="site-navbar" role="banner">
    <div class="site-navbar-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                <!-- Wyszukiwarka produktów -->
                <form role="search" method="get" class="site-block-top-search" action="<?php echo esc_url(home_url('/')); ?>">
                    <span class="icon icon-search2"></span>
                    <input type="search" class="form-control border-0" placeholder="Search" value="<?php echo get_search_query(); ?>" name="s" />
                    <!-- <input type="hidden" name="post_type" value="product" /> -->
                </form>
            </div>
            <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                <div class="site-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="js-logo-clone">Shoppers</a>
                </div>
            </div>
            <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                <div class="site-top-icons">
                <ul>
                    <li>
                        <a href="<?php echo esc_url( wc_get_page_permalink('myaccount') ); ?>"><span class="icon icon-person"></span></a></li>
                    <li>
                        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="site-cart">
                            <?php global $woocommerce; ?>
                            <span class="icon icon-shopping_cart"></span>
                            <span class="count"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
                        </a>
                    </li> 
                    <li class="d-inline-block d-md-none ml-md-0">
                        <a href="#" class="site-menu-toggle js-menu-toggle">
                            <span class="icon-menu"></span>
                        </a>
                    </li>
                </ul>
                </div> 
            </div>
        </div>
    </div>
    </div> 
    <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
            <!-- menu górne -->
            <?php 
                wp_nav_menu(array(
                    'theme_location' => 'header-menu',
                    'container' => false,
                    'menu_class' => 'site-menu js-clone-nav d-none d-md-block',
                    'my_menu_li_class' => '',
                    'my_menu_a_class' => '',
                    'depth' => 0, // ustawienie na 0 pozwala na nieograniczoną głębokość zagnieżdżenia
                    'walker' => new Walker_Nav_Menu_Custom()
                ));
            ?>
        </div>
    </nav>
</header>
