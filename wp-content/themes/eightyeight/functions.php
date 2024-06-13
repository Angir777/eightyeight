<?php

	/* 
	*
	* WooCommerce
	*
	*/

	function mytheme_add_woocommerce_support() {
		add_theme_support('woocommerce');
	}
	add_action('after_setup_theme', 'mytheme_add_woocommerce_support');

	function modify_product_query($query) {
		if (!is_admin() && $query->is_main_query() && is_post_type_archive('product')) {
			$query->set('posts_per_page', get_option('posts_per_page'));
			$query->set('paged', (get_query_var('paged')) ? get_query_var('paged') : 1);
		}
	
		if (!is_admin() && $query->is_main_query() && is_tax('product_cat')) {
			$query->set('posts_per_page', get_option('posts_per_page'));
			$query->set('paged', (get_query_var('paged')) ? get_query_var('paged') : 1);
		}
	}
	add_action('pre_get_posts', 'modify_product_query');

	/* 
	*
	* Rejestracja widgetu
	*
	*/

	register_sidebar( array(
		'name'          => __( 'WC Widget One', 'skrzypniaktheme' ),
		'id'            => 'wc-widget-one',
		'description'   => __( 'Dodaj treść.', 'skrzypniaktheme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	/* 
	*
	* Rejestracja obrazków 
	*
	*/

	add_theme_support( 'post-thumbnails' );

	/* 
	*
	* Rejestracja logo 
	*
	*/

	add_theme_support( 'custom-logo' );

	/* 
	*
	* Rejestracja menu 
	*
	*/

	function reg_mymenu() {
		register_nav_menus(
			array(
				'header-menu' => __( 'Menu górne' ),
				'footer-menu-page' => __( 'Menu dolne dla strony' ),
				'footer-menu-shop' => __( 'Menu dolne dla sklepu' ),
			)
		);
	}
	add_action( 'init', 'reg_mymenu');

	// Dodawanie klasy do <li>
	function my_menu_li_class($classes, $item, $args) {
		if (property_exists($args, 'my_menu_li_class')) {
			$classes[] = $args->my_menu_li_class;
		}

		// Dodaj klasę 'active' jeśli element menu jest aktualną trasą
		if (in_array('current-menu-item', $classes) || in_array('current_page_item', $classes)) {
			$classes[] = 'active';
		}

		// Dodaj klasę 'has-children' jeśli element menu ma podmenu
		if (in_array('menu-item-has-children', $classes)) {
			$classes[] = 'has-children';
		}

		return $classes;
	}
	add_filter('nav_menu_css_class', 'my_menu_li_class', 1, 3);

	// Dodawanie klasy do <a>
	function my_menu_a_class( $attributes, $item, $args ) {
		if (property_exists($args, 'my_menu_a_class')) {
			$attributes['class'] = $args->my_menu_a_class;
		}
		
		return $attributes;
	}
	add_filter( 'nav_menu_link_attributes', 'my_menu_a_class', 1, 3 );

	class Walker_Nav_Menu_Custom extends Walker_Nav_menu {
		// Start Level
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$submenu = ($depth > 0) ? ' sub-menu' : '';
			$output .= "\n$indent<ul class=\"dropdown$submenu\">\n";
		}
	
		// Start Element
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ($depth) ? str_repeat("\t", $depth) : '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
	
			if (in_array('menu-item-has-children', $classes)) {
				$classes[] = 'has-children';
			}
	
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
	
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
	
			$output .= $indent . '<li' . $id . $class_names .'>';
	
			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
	
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
	
			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}
	
			$title = apply_filters( 'the_title', $item->title, $item->ID );
	
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . $title . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;
	
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	/* 
	*
	* Opcje motywu
	*
	*/

	class MyThemeOptions {
		private $mto;

		public function __construct() {
			add_action( 'admin_menu', array( $this, 'mto_add_plugin_page' ) );
			add_action( 'admin_init', array( $this, 'mto_add_page_init' ) );
		}

		public function mto_add_plugin_page() {
			add_menu_page(
				'Opcje szablonu', // page_title
				'Opcje szablonu', // menu_title
				'manage_options', // capability
				'theme-options', // menu_slug
				array( $this, 'mto_create_admin_page' ), // function
				'dashicons-admin-generic', // icon_url
				2 // position
			);
		}

		public function mto_create_admin_page() {
			$this->mto = get_option( 'mto_option_name' ); ?>

			<div class="wrap">
				<h2>Opcje szablonu</h2>
				
				<?php settings_errors(); ?>

				<form method="post" action="options.php">
					<?php
						settings_fields( 'mto_option_group' );
						do_settings_sections( 'mto_admin' );
						submit_button();
					?>
				</form>
			</div>
		<?php }

		public function mto_add_page_init() {
			register_setting(
				'mto_option_group', // option_group
				'mto_option_name', // option_name
				array( $this, 'mto_sanitize' ) // sanitize_callback
			);

			add_settings_section(
				'mto_section', // id
				'Stopka', // title
				array( $this, 'mto_section_info' ), // callback
				'mto_admin' // page
			);

			// Footer menu title PL
			add_settings_field(
				'mto_footer_menu_title_pl', // id
				'Tytuł menu PL', // title
				array( $this, 'mto_footer_menu_title_pl_callback' ), // callback
				'mto_admin', // page
				'mto_section' // section
			);

			// Contact data title PL
			add_settings_field(
				'mto_contact_data_title_pl', // id
				'Tytuł stopki PL', // title
				array( $this, 'mto_contact_data_title_pl_callback' ), // callback
				'mto_admin', // page
				'mto_section' // section
			);

			// Address
			add_settings_field(
				'mto_address', // id
				'Adres', // title
				array( $this, 'mto_address_callback' ), // callback
				'mto_admin', // page
				'mto_section' // section
			);

			// Phone
			add_settings_field(
				'mto_phone', // id
				'Telefon', // title
				array( $this, 'mto_phone_callback' ), // callback
				'mto_admin', // page
				'mto_section' // section
			);

			// Email
			add_settings_field(
				'mto_email', // id
				'E-mail', // title
				array( $this, 'mto_email_callback' ), // callback
				'mto_admin', // page
				'mto_section' // section
			);
		}

		public function mto_sanitize($input) {
			$sanitary_values = array();

			if ( isset( $input['mto_footer_menu_title_pl'] ) ) {
				$sanitary_values['mto_footer_menu_title_pl'] = sanitize_text_field( $input['mto_footer_menu_title_pl'] );
			}
			
			if ( isset( $input['mto_contact_data_title_pl'] ) ) {
				$sanitary_values['mto_contact_data_title_pl'] = sanitize_text_field( $input['mto_contact_data_title_pl'] );
			}

			if ( isset( $input['mto_address'] ) ) {
				$sanitary_values['mto_address'] = sanitize_text_field( $input['mto_address'] );
			}

			if ( isset( $input['mto_phone'] ) ) {
				$sanitary_values['mto_phone'] = sanitize_text_field( $input['mto_phone'] );
			}

			if ( isset( $input['mto_email'] ) ) {
				$sanitary_values['mto_email'] = sanitize_text_field( $input['mto_email'] );
			}

			return $sanitary_values;
		}

		public function mto_section_info() {}

		public function mto_footer_menu_title_pl_callback() {
			printf(
				'<input class="regular-text" type="text" name="mto_option_name[mto_footer_menu_title_pl]" id="mto_footer_menu_title_pl" value="%s">',
				isset( $this->mto['mto_footer_menu_title_pl'] ) ? esc_attr( $this->mto['mto_footer_menu_title_pl']) : ''
			);
		}

		public function mto_contact_data_title_pl_callback() {
			printf(
				'<input class="regular-text" type="text" name="mto_option_name[mto_contact_data_title_pl]" id="mto_contact_data_title_pl" value="%s">',
				isset( $this->mto['mto_contact_data_title_pl'] ) ? esc_attr( $this->mto['mto_contact_data_title_pl']) : ''
			);
		}

		public function mto_address_callback() {
			printf(
				'<input class="regular-text" type="text" name="mto_option_name[mto_address]" id="mto_address" value="%s">',
				isset( $this->mto['mto_address'] ) ? esc_attr( $this->mto['mto_address']) : ''
			);
		}

		public function mto_phone_callback() {
			printf(
				'<input class="regular-text" type="text" name="mto_option_name[mto_phone]" id="mto_phone" value="%s">',
				isset( $this->mto['mto_phone'] ) ? esc_attr( $this->mto['mto_phone']) : ''
			);
		}

		public function mto_email_callback() {
			printf(
				'<input class="regular-text" type="text" name="mto_option_name[mto_email]" id="mto_email" value="%s">',
				isset( $this->mto['mto_email'] ) ? esc_attr( $this->mto['mto_email']) : ''
			);
		}
	}
	if ( is_admin() ) { $opcje_szablonu = new MyThemeOptions(); }
	