<?php
/*
 * Created by Artureanec
*/

# General
add_theme_support('title-tag');
add_theme_support('automatic-feed-links');
add_theme_support('post-formats', array('image', 'video', 'gallery', 'quote'));
add_theme_support('html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

if( !isset( $content_width ) ) $content_width = 1340;

# ADD Localization Folder
add_action('after_setup_theme', 'industrium_pomo');
if (!function_exists('industrium_pomo')) {
    function industrium_pomo() {
        load_theme_textdomain('industrium', get_template_directory() . '/languages');
    }
}

require_once(get_template_directory() . '/core/helper-functions.php');
require_once(get_template_directory() . '/core/layout-functions.php');
require_once(get_template_directory() . '/core/init.php');

# Register CSS/JS
add_action('wp_enqueue_scripts', 'industrium_css_js');
if (!function_exists('industrium_css_js')) {
    function industrium_css_js() {
        # CSS
        wp_enqueue_style('industrium-theme', get_template_directory_uri() . '/css/theme.css', array(), wp_get_theme()->get('Version'));
        wp_style_add_data( 'industrium-theme', 'rtl', 'replace' ); 

        if (class_exists('WooCommerce')) {
            wp_enqueue_style('industrium-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array(), wp_get_theme()->get('Version'));
            wp_style_add_data( 'industrium-woocommerce', 'rtl', 'replace' ); 
            wp_enqueue_style('industrium-style', get_template_directory_uri() . '/style.css', array('industrium-theme', 'industrium-woocommerce'), wp_get_theme()->get('Version') );
        } else {
            wp_enqueue_style('industrium-style', get_template_directory_uri() . '/style.css', array('industrium-theme'), wp_get_theme()->get('Version') );
        }

        # JS
        wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.min.js', array('jquery'), false, true);
        wp_enqueue_script('tilt', get_template_directory_uri() . '/js/tilt.jquery.min.js', array('jquery'), false, true);
        wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', true, false, true);
        wp_enqueue_script('isotope', get_template_directory_uri() . '/js/isotope.min.js', array(), false, true );

        wp_register_script('industrium-theme', get_template_directory_uri() . '/js/theme.js', array('jquery', 'isotope', 'tilt'), wp_get_theme()->get('Version'), true);
        wp_localize_script( 'industrium-theme', 'ajax_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        wp_enqueue_script('industrium-theme');


        if (is_singular() && comments_open()) {
            wp_enqueue_script('comment-reply');
        }

        $localize_theme = array();
        $localize_theme['rtl'] = (bool)is_rtl();
        if (class_exists('\Elementor\Plugin')) {
            if(\Elementor\Plugin::$instance->preview->is_preview_mode()) {
                $localize_theme['is_editor_preview'] = true;
            }
            wp_localize_script('industrium-theme', 'theme',
                $localize_theme
            );
        }        

        # Colors
        require_once(get_template_directory() . "/css/custom/custom.php");

        global $industrium_custom_css;
        wp_add_inline_style('industrium-theme', $industrium_custom_css);
    }
}

# Register CSS/JS for Admin Settings
add_action('admin_enqueue_scripts', 'industrium_admin_css_js');
if (!function_exists('industrium_admin_css_js')) {
    function industrium_admin_css_js() {
        # CSS
        wp_enqueue_style('industrium-admin', get_template_directory_uri() . '/css/admin.css');
        # JS
        wp_enqueue_script('industrium-admin', get_template_directory_uri() . '/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), false, true);
    }
}

# Register CSS for Gutenberg Editor

add_action('enqueue_block_editor_assets', 'industrium_gutenberg_css', 1, 1);
add_action('enqueue_block_editor_assets', 'industrium_register_theme_fonts', 1, 1);
if (!function_exists('industrium_gutenberg_css')) {
    function industrium_gutenberg_css() {

        add_theme_support( 'editor-styles' );
        add_editor_style( 'css/gutenberg-editor.css' );

        require_once(get_template_directory() . "/css/custom/custom.php");
        global $industrium_custom_css;
        wp_enqueue_style('industrium-admin', get_template_directory_uri() . '/css/admin.css');
        wp_add_inline_style('industrium-admin', $industrium_custom_css);
    }
}

# Register Google Fonts
add_action('wp_enqueue_scripts', 'industrium_register_theme_fonts');
if (!function_exists('industrium_register_theme_fonts')) {
    function industrium_register_theme_fonts() {
        $fonts_list = array('header_menu_font', 'header_sub_menu_font', 'page_title_heading_font', 'page_title_breadcrumbs_font', 'main_font', 'additional_font', 'headings_font', 'buttons_font');
        $font_control_list      = get_theme_mod('current_fonts', $fonts_list);
        $current_fonts_array    = array();
        $families               = array();
        $result                 = array();
        foreach ( $font_control_list as $control ) {
            $values = industrium_get_theme_mod($control);
            $values = json_decode($values, true);
            if ( isset($values['font_family']) && !empty($values['font_family']) ) {
                $current_font = array();
                $current_font['font_family'] = $values['font_family'];
                $current_font['font_styles'] = $values['font_styles'];
                $current_font['font_subset'] = $values['font_subset'];
                $current_fonts_array[$control] = $current_font;
            }
        }

        if ( !empty($current_fonts_array) && is_array($current_fonts_array) ) {
            foreach ( $current_fonts_array as $item ) {
                if ( !in_array($item['font_family'], $families) ) {
                    $families[] = $item['font_family'];
                }
            }
            foreach ( $families as $variant ) {
                foreach ( $current_fonts_array as $key => $item ) {
                    if ( $variant == $item['font_family'] ) {
                        $result[$variant]['font_styles'] = empty($result[$variant]['font_styles']) ? $item['font_styles'] : $result[$variant]['font_styles'] . ',' . $item['font_styles'];
                        $result[$variant]['font_subset'] = empty($result[$variant]['font_subset']) ? $item['font_subset'] : $result[$variant]['font_subset'] . ',' . $item['font_subset'];
                    }
                }
            }
            foreach ( $result as $key => $value ) {
                $styles = array_unique(explode(',', $result[$key]['font_styles']));
                asort($styles, SORT_NUMERIC );
                $subset = array_unique(explode(',', $result[$key]['font_subset']));
                asort($subset, SORT_NUMERIC );
                $result[$key]['font_styles'] = implode( ',', $styles );
                $result[$key]['font_subset'] = implode( ',', $subset );
            }
            if ( !empty($result) && is_array($result) ) {
                $fonts = array();
                foreach ( $result as $font_name => $font_params ) {
                    if ( $font_name != 'Manrope Alt' ) {
                        $fonts[] = $font_name . ':' . $font_params['font_styles'] . '&subset=' . $font_params['font_subset'];
                    }
                }
                $fonts_url = '//fonts.googleapis.com/css?family=' . urlencode( implode('|', $fonts) );
                wp_enqueue_style('industrium-fonts', $fonts_url);
            }
        }
    }
}



# WP Footer
add_action('wp_footer', 'industrium_wp_footer');
if (!function_exists('industrium_wp_footer')) {
    function industrium_wp_footer() {
        Industrium_Helper::getInstance()->echoFooter();
    }
}

# Register Menu
add_action('init', 'industrium_register_menu');
if (!function_exists('industrium_register_menu')) {
    function industrium_register_menu() {
        register_nav_menus(
            [
                'main'              => esc_html__('Main menu', 'industrium'),
                'top_bar_user_menu' => esc_html__('Top bar menu', 'industrium'),
                'footer_menu'       => esc_html__('Footer Menu', 'industrium'),
                'footer_add_menu'   => esc_html__('Footer Additional Menu', 'industrium')
            ]
        );
    }
}


# Register Sidebars
add_action('widgets_init', 'industrium_widgets_init');
if (!function_exists('industrium_widgets_init')) {
    function industrium_widgets_init() {
        register_sidebar(
            array(
                'name'          => esc_html__('Page Sidebar', 'industrium'),
                'id'            => 'sidebar',
                'description'   => esc_html__('Widgets in this area will be shown on all pages.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title"><span>',
                'after_title'   => '</span></h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Post Sidebar', 'industrium'),
                'id'            => 'sidebar-post',
                'description'   => esc_html__('Widgets in this area will be shown on all posts.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title"><span>',
                'after_title'   => '</span></h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Career Sidebar', 'industrium'),
                'id'            => 'sidebar-career',
                'description'   => esc_html__('Widgets in this area will be shown on all career pages.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title"><span>',
                'after_title'   => '</span></h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Service Sidebar', 'industrium'),
                'id'            => 'sidebar-service',
                'description'   => esc_html__('Widgets in this area will be shown on all service pages.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title"><span>',
                'after_title'   => '</span></h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Archive Sidebar', 'industrium'),
                'id'            => 'sidebar-archive',
                'description'   => esc_html__('Widgets in this area will be shown on all posts and archive pages.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title"><span>',
                'after_title'   => '</span></h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Side Panel Sidebar', 'industrium'),
                'id'            => 'sidebar-side',
                'description'   => esc_html__('Widgets in this area will be shown on side panel.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget side-widget %2$s"><div class="widget-wrapper side-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title side-widget-title">',
                'after_title'   => '</h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('F.A.Q. Sidebar', 'industrium'),
                'id'            => 'sidebar-faq',
                'description'   => esc_html__('Widgets in this area will be shown on F.A.Q. page', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title"><span>',
                'after_title'   => '</span></h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Top Sidebar', 'industrium'),
                'id'            => 'sidebar-footer-top',
                'description'   => esc_html__('Widgets in this area will be shown on footer top area.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title footer-widget-title">',
                'after_title'   => '</h5>',
            )
        );
        
        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 1)', 'industrium'),
                'id'            => 'sidebar-footer-style1',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title footer-widget-title">',
                'after_title'   => '</h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 2)', 'industrium'),
                'id'            => 'sidebar-footer-style2',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title footer-widget-title">',
                'after_title'   => '</h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 3)', 'industrium'),
                'id'            => 'sidebar-footer-style3',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title footer-widget-title">',
                'after_title'   => '</h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 4)', 'industrium'),
                'id'            => 'sidebar-footer-style4',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title footer-widget-title">',
                'after_title'   => '</h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 5)', 'industrium'),
                'id'            => 'sidebar-footer-style5',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title footer-widget-title">',
                'after_title'   => '</h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 6)', 'industrium'),
                'id'            => 'sidebar-footer-style6',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title footer-widget-title">',
                'after_title'   => '</h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 7)', 'industrium'),
                'id'            => 'sidebar-footer-style7',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title footer-widget-title">',
                'after_title'   => '</h5>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 8)', 'industrium'),
                'id'            => 'sidebar-footer-style8',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'industrium'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h5 class="widget-title footer-widget-title">',
                'after_title'   => '</h5>',
            )
        );

        if (class_exists('WooCommerce')) {
            register_sidebar(
                array(
                    'name'          => esc_html__('Sidebar WooCommerce', 'industrium'),
                    'id'            => 'sidebar-woocommerce',
                    'description'   => esc_html__('Widgets in this area will be shown on Woocommerce Pages.', 'industrium'),
                    'before_widget' => '<div id="%1$s" class="widget wooсommerce-widget %2$s"><div class="widget-wrapper">',
                    'after_widget'  => '</div></div>',
                    'before_title'  => '<h6 class="widget-title"><span>',
                    'after_title'   => '</span></h6>',
                )
            );
        }
    }
}

// Init Custom Widgets
if ( function_exists('industrium_add_custom_widget') ) {
    industrium_add_custom_widget('Industrium_Contacts_Widget');
    industrium_add_custom_widget('Industrium_Featured_Posts_Widget');
    industrium_add_custom_widget('Industrium_Banner_Widget');
    industrium_add_custom_widget('Industrium_Nav_Menu_Widget');
    industrium_add_custom_widget('Industrium_Request_Contacts_Widget');
}

// Init Elementor for Custom Post Types
if (!function_exists('industrium_init_elementor_for_team_post_type')) {
    function industrium_init_elementor_for_team_post_type() {
        add_post_type_support('industrium-team', 'elementor');
    }
}
add_action('init', 'industrium_init_elementor_for_team_post_type');

if (!function_exists('industrium_init_elementor_for_portfolio_post_type')) {
    function industrium_init_elementor_for_portfolio_post_type() {
        add_post_type_support('industrium-portfolio', 'elementor');
    }
}
add_action('init', 'industrium_init_elementor_for_portfolio_post_type');

if (!function_exists('industrium_init_elementor_for_service_post_type')) {
    function industrium_init_elementor_for_service_post_type() {
        add_post_type_support('industrium-service', 'elementor');
    }
}
add_action('init', 'industrium_init_elementor_for_service_post_type');

//Custom Animation for Elementor
if (!function_exists('custom_animation')) {
    function custom_animation() {
        return array(
            'Industrium Animation' => [
                'industrium_decoration' => 'Decoration Animation',
                'industrium_slide_in_up_left' => 'Slide In Up Left',
                'industrium_clip_in_down' => 'Clip In Down',
                'industrium_clip_in_up' => 'Clip In Up',
                'image_clip_right' => 'Image Clip Right',
                'image_clip_left' => 'Image Clip Left',
            ]
        );
    }
}
add_filter( 'elementor/controls/animations/additional_animations', 'custom_animation' );

# WooCommerce
if (class_exists('WooCommerce')) {
    require_once( get_template_directory() . '/woocommerce/wooinit.php');
}

// Remove standard WP gallery styles
add_filter( 'use_default_gallery_style', '__return_false' );

// Register custom image sizes
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1340, 701, true );
}
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'industrium_post_thumbnail_mobile', 535, 280, array('center', 'center') );
    add_image_size( 'industrium_post_thumbnail_tablet', 951, 497, array('center', 'center') );
    add_image_size( 'industrium_post_thumbnail_default', 995, 521, array('center', 'center') );
    add_image_size( 'industrium_post_thumbnail_full', 1340, 701, array('center', 'center') );

    add_image_size( 'industrium_post_grid_2_columns', 960, 1200, array('center', 'center') );
    add_image_size( 'industrium_post_grid_3_columns', 640, 800, array('center', 'center') );
    add_image_size( 'industrium_post_grid_4_columns', 480, 600, array('center', 'center') );
    add_image_size( 'industrium_post_grid_5_columns', 384, 480, array('center', 'center') );
    add_image_size( 'industrium_post_grid_6_columns', 320, 400, array('center', 'center') );

    add_image_size( 'industrium_portfolio_thumbnail', 835, 578, array('center', 'center') );
    add_image_size( 'industrium_portfolio_grid_1_columns', 1340, 1160, array('center', 'center') );
    add_image_size( 'industrium_portfolio_grid_2_columns', 960, 831, array('center', 'center') );
    add_image_size( 'industrium_portfolio_grid_3_columns', 640, 554, array('center', 'center') );
    add_image_size( 'industrium_portfolio_grid_4_columns', 480, 416, array('center', 'center') );
    add_image_size( 'industrium_portfolio_grid_5_columns', 384, 333, array('center', 'center') );
    add_image_size( 'industrium_portfolio_grid_6_columns', 320, 277, array('center', 'center') );

    add_image_size( 'industrium_portfolio_slider_1_columns', 1620, 817, array('center', 'center') );

    add_image_size( 'industrium_portfolio_masonry_1_columns', 1920, 1440, array('center', 'center') );
    add_image_size( 'industrium_portfolio_masonry_2_columns', 1920, 1440, array('center', 'center') );
    add_image_size( 'industrium_portfolio_masonry_3_columns', 1280, 960, array('center', 'center') );
    add_image_size( 'industrium_portfolio_masonry_4_columns', 960, 720, array('center', 'center') );
    add_image_size( 'industrium_portfolio_masonry_5_columns', 768, 576, array('center', 'center') );
    add_image_size( 'industrium_portfolio_masonry_6_columns', 640, 480, array('center', 'center') );

    add_image_size( 'industrium_project_slider_1_columns', 1920, 817, array('center', 'center') );

    add_image_size( 'industrium_project_grid_1_columns', 1920, 1435, array('center', 'center') );
    add_image_size( 'industrium_project_grid_2_columns', 960, 718, array('center', 'center') );
    add_image_size( 'industrium_project_grid_3_columns', 640, 479, array('center', 'center') );
    add_image_size( 'industrium_project_grid_4_columns', 480, 359, array('center', 'center') );
    add_image_size( 'industrium_project_grid_5_columns', 384, 287, array('center', 'center') );
    add_image_size( 'industrium_project_grid_6_columns', 320, 239, array('center', 'center') );

    add_image_size( 'industrium_service_slider_1_columns', 960, 1154, array('center', 'center') );
    add_image_size( 'industrium_service_slider_2_columns', 960, 1154, array('center', 'center') );
    add_image_size( 'industrium_service_slider_3_columns', 640, 770, array('center', 'center') );
    add_image_size( 'industrium_service_slider_4_columns', 480, 577, array('center', 'center') );

    add_image_size( 'industrium_team_thumbnail', 542, 489, array('center', 'center') );
}
add_filter( 'image_size_names_choose', 'industrium_image_size_names' );
if ( !function_exists( 'industrium_image_size_names' ) ) {
    function industrium_image_size_names($sizes) {
        return array_merge($sizes, array(
            'industrium_post_thumbnail_default'    => esc_html__('Post Thumbnail (Default)', 'industrium'),
            'industrium_post_thumbnail_full'       => esc_html__('Post Thumbnail (Full)', 'industrium'),
        ));
    }
}

// Media Upload
if (!function_exists('industrium_enqueue_media')) {
    function industrium_enqueue_media() {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'industrium_enqueue_media' );

// Responsive video
add_filter('embed_oembed_html', 'industrium_wrap_oembed_video', 99, 4);
if (!function_exists('industrium_wrap_oembed_video')) {
    function industrium_wrap_oembed_video($html, $url, $attr, $post_id) {
        return '<div class="video-embed">' . $html . '</div>';
    }
}

// Custom Search form
add_filter('get_search_form', 'industrium_get_search_form', 10, 2);
if ( !function_exists('industrium_get_search_form') ) {
    function industrium_get_search_form($form, $args) {
        $search_rand = mt_rand(0, 999);
        $search_js = 'javascript:document.getElementById("search-' . esc_js($search_rand) . '").submit();';
        $placeholder = ( $args['aria_label'] == 'global' ? esc_attr__('Search', 'industrium') : esc_attr__('Search...', 'industrium') );

        $form = '<form name="search_form" method="get" action="' . esc_url(home_url('/')) . '" class="search-form" id="search-' . esc_attr($search_rand) . '">';
            $form .= '<span class="search-form-icon" onclick="' . esc_js($search_js) . '"></span>';
            $form .= '<input type="text" name="s" value="" placeholder="' . esc_attr($placeholder) . '" title="' . esc_attr__('Search', 'industrium') . '" class="search-form-field">';
        $form .= '</form>';

        return $form;
    }
}

// Customize WP Categories Widget
add_filter('wp_list_categories', 'industrium_customize_categories_widget', 10, 2);
if ( !function_exists('industrium_customize_categories_widget') ) {
    function industrium_customize_categories_widget($output, $args) {
        $args['use_desc_for_title'] = false;
        if ( $args['hierarchical'] ) {
            $output = str_replace('"cat-item', '"cat-item cat-item-hierarchical', $output);
        }
        return $output;
    }
}

// Add 'Background color' button to Tiny MCE text editor
add_action( 'init', 'industrium_tiny_mce_background_color' );
if ( !function_exists('industrium_tiny_mce_background_color') ) {
    function industrium_tiny_mce_background_color() {
        add_filter('mce_buttons_2', 'industrium_tiny_mce_background_color_button', 999, 1);
    }
}
if ( !function_exists('industrium_tiny_mce_background_color_button') ) {
    function industrium_tiny_mce_background_color_button($buttons) {
        array_splice($buttons, 4, 0, 'backcolor');
        return $buttons;
    }
}

// Move Comment Message field in Comment form
add_filter( 'comment_form_fields', 'cosmacos_move_comment_fields' );
if ( !function_exists('cosmacos_move_comment_fields') ) {
    function cosmacos_move_comment_fields($fields) {
        if ( !function_exists('is_product') || !is_product() ) {
            $comment_field = $fields['comment'];
            $cookies_field = $fields['cookies'];
            unset($fields['comment']);
            unset($fields['cookies']);
            $fields['comment'] = $comment_field;
            $fields['cookies'] = $cookies_field;
        }
        return $fields;
    }
}

// WPForms Plugin Dropdown Menu Fix
if ( function_exists( 'wpforms') ) {
    add_action( 'wpforms_display_field_select', 'industrium_wpform_start_select_wrapper', 5, 1 );
    if ( !function_exists('industrium_wpform_start_select_wrapper') ) {
        function industrium_wpform_start_select_wrapper($field) {
            echo '<div class="select-wrap' . (isset($field['multiple']) && !empty($field['multiple']) ? ' multiple' : '') . (!empty($field['size']) && isset($field['size']) ? ' wpforms-field-' . esc_attr($field['size']) : '') . '">';
        }
    }
    add_action( 'wpforms_display_field_select', 'industrium_wpform_finish_select_wrapper', 15 );
    if ( !function_exists('industrium_wpform_finish_select_wrapper') ) {
        function industrium_wpform_finish_select_wrapper() {
            echo '</div>';
        }
    }
}

// Custom Password Form
add_filter( 'the_password_form', 'industrium_password_form' );
if ( !function_exists('industrium_password_form') ) {
    function industrium_password_form() {
        global $post;
        $out = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" class="post-password-form" method="post"><p>' . esc_html__('This content is password protected. To view it please enter your password below:', 'industrium') . '</p><p><label for="password"><input name="post_password" id="password" type="password" placeholder="' . esc_attr__('Password', 'industrium') . '" size="20" required /></label><button name="Submit">' . esc_html__('Enter', 'industrium') . '</button></p></form>';
        return $out;
    }
}

// Set Elementor Features Default Values
add_action( 'elementor/experiments/feature-registered', 'industrium_elementor_features_set_default', 10, 2 );
if ( !function_exists('industrium_elementor_features_set_default') ) {
    function industrium_elementor_features_set_default( Elementor\Core\Experiments\Manager $experiments_manager ) {
        $experiments_manager->set_feature_default_state('e_dom_optimization', 'inactive');
    }
}

// Set custom palette in customizer colorpicker
add_action( 'customize_controls_enqueue_scripts', 'industrium_custom_color_palette' );
if ( !function_exists('industrium_custom_color_palette') ) {
    function industrium_custom_color_palette() {
        $color_palettes = json_encode(industrium_get_custom_color_palette());
        wp_add_inline_script('wp-color-picker', 'jQuery.wp.wpColorPicker.prototype.options.palettes = ' . sprintf('%s', $color_palettes) . ';');
    }
}

// Filter for widgets
add_filter( 'dynamic_sidebar_params', 'industrium_dynamic_sidebar_params' );
if (!function_exists('industrium_dynamic_sidebar_params')) {
    function industrium_dynamic_sidebar_params($sidebar_params) {
        if (is_admin()) {
            return $sidebar_params;
        }
        global $wp_registered_widgets;
        $widget_id = $sidebar_params[0]['widget_id'];
        $wp_registered_widgets[$widget_id]['original_callback'] = $wp_registered_widgets[$widget_id]['callback'];
        $wp_registered_widgets[$widget_id]['callback'] = 'industrium_widget_callback_function';

        return $sidebar_params;
    }
}
add_filter( 'widget_output', 'industrium_output_filter', 10, 3 );
if (!function_exists('industrium_output_filter')) {
    function industrium_output_filter($widget_output, $widget_id_base, $widget_id) {
        if ($widget_id_base != 'woocommerce_product_categories' && $widget_id_base != 'wpforms-widget' && $widget_id_base != 'block') {
            $widget_output = str_replace('<select', '<div class="select-wrap"><select', $widget_output);
            $widget_output = str_replace('</select>', '</select></div>', $widget_output);
        }

        return $widget_output;
    }
}

// Admin Footer
add_filter('admin_footer', 'industrium_admin_footer');
if (!function_exists('industrium_admin_footer')) {
    function industrium_admin_footer() {
        if (strlen(get_page_template_slug())>0) {
            echo "<input type='hidden' name='' value='" . (get_page_template_slug() ? get_page_template_slug() : '') . "' class='industrium_this_template_file'>";
        }
    }
}

// Remove post format parameter
add_filter('preview_post_link', 'industrium_remove_post_format_parameter', 9999);
if (!function_exists('industrium_remove_post_format_parameter')) {
    function industrium_remove_post_format_parameter($url) {
        $url = remove_query_arg('post_format', $url);
        return $url;
    }
}

// Post excerpt customize
add_filter( 'excerpt_length', function() {
    return 41;
} );
add_filter( 'excerpt_more', function(){
    return '...';
} );

// Wrap pagination links
add_filter( 'paginate_links_output', 'industrium_wrap_pagination_links', 10, 2 );
if ( !function_exists('industrium_wrap_pagination_links') ) {
    function industrium_wrap_pagination_links($template, $args) {
        return '<div class="content-pagination">' .
                    '<nav class="navigation pagination">' .
                        '<h2 class="screen-reader-text">' . esc_html__('Pagination', 'industrium') . '</h2>' .
                        '<div class="nav-links">' .
                            wp_kses($template, array(
                                'span'  => array(
                                    'class'         => true,
                                    'aria-current'  => true
                                ),
                                'div'  => array(
                                    'class'         => true
                                ),
                                'a'     => array(
                                    'class'         => true,
                                    'href'          => true
                                )
                            )) .
                        '</div>' .
                    '</nav>' .
                '</div>';
    }
}

//Add Ajax Actions
add_action('wp_ajax_pagination', 'ajax_pagination');
add_action('wp_ajax_nopriv_pagination', 'ajax_pagination');

//Construct Loop & Results
function ajax_pagination() {
    $query_data         = $_POST;

    $paged              = ( isset($query_data['paged']) ) ? intval($query_data['paged']) : 1;
    $filter_term        = ( isset($query_data['filter_term']) ) ? $query_data['filter_term'] : null;
    $filter_taxonomy    = ( isset($query_data['filter_taxonomy']) ) ? $query_data['filter_taxonomy'] : null;
    $args               = ( isset($query_data['args']) ) ? json_decode(stripslashes($query_data['args']), true) : array();
    $args               = array_merge($args, array( 'paged' => sanitize_key($paged) ));
    if ( !empty($filter_term) && !empty($filter_taxonomy) ) {
        $args   = array_merge($args, array( sanitize_key($filter_taxonomy) => sanitize_key($filter_term) ));
    }
    $post_type          = isset($args['post_type']) ? $args['post_type'] : 'post';
    $widget             = ( isset($query_data['widget']) ) ? json_decode(stripslashes($query_data['widget']), true) : array();
    $query              = new WP_Query($args);

    $wrapper_class      = isset($query_data['classes']) ? $query_data['classes'] : '';
    $id                 = isset($query_data['id']) ? $query_data['id'] : '';
    $link_base          = isset($args['link_base']) ? $args['link_base'] : '';

    echo '<div class="' . esc_attr($wrapper_class) . '">';
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('content', $post_type, $widget);
        };
        wp_reset_postdata();
    echo '</div>';

    echo paginate_links( array(
        'base'      => $link_base . '/?' . esc_attr($id) . '-paged=%#%',
        'current'   => max( 1, $paged ),
        'total'     => $query->max_num_pages,
        'end_size'  => 2,
        'prev_text' => '<div class="button-icon"></div>',
        'next_text' => '<div class="button-icon"></div>',
        'add_args'  => false
    ) );

    die();
}

// Customize WP-Blocks Output
if ( !function_exists('industrium_wpblock_dropdown_wrapper') ) {
    function industrium_wpblock_dropdown_wrapper($block_content, $block) {

        // if($block['blockName'] == 'core/latest-posts' && $block['attrs']['displayPostDate'] == true && $block['attrs']['displayFeaturedImage'] == true) {
        //     $block_content = str_replace('<a class="wp-block-latest-posts__post-title"', '<div class="wp-block-latest-posts_content"><a class="wp-block-latest-posts__post-title"', $block_content);
        //     $block_content = str_replace('</time>', '<div></time>', $block_content);
        // }

        if (
            isset($block['attrs']['displayAsDropdown']) && $block['attrs']['displayAsDropdown'] === true
        ) {
            $block_content = str_replace('<select', '<div class="select-wrap"><select', $block_content);
            $block_content = str_replace('</select>', '</select></div>', $block_content);
        }

        if (
            ( $block['blockName'] == 'core/search' && isset($block['attrs']['buttonUseIcon']) && $block['attrs']['buttonUseIcon'] === true ) ||
            ( $block['blockName'] == 'woocommerce/product-search' )
        ) {
            $block_content = preg_replace('/<svg\s+.*(<\/svg>)/s', '', $block_content);
        }

        if ( $block['blockName'] == 'core/loginout' && isset($block['attrs']['displayLoginAsForm']) && $block['attrs']['displayLoginAsForm'] === true ) {
            $block_content = str_replace('id="user_login"', 'id="user_login" placeholder="' . esc_attr__('Username or Email Address', 'industrium') . '"', $block_content);
            $block_content = str_replace('id="user_pass"', 'id="user_pass" placeholder="' . esc_attr__('Password', 'industrium') . '"', $block_content);
            $block_content = preg_replace('/<label for.*<\/label>/', '', $block_content);
        }
        if ( $block['blockName'] == 'core/button' && (!isset($block['attrs']['className']) ||
            (isset($block['attrs']['className']) && $block['attrs']['className'] !== 'is-style-fill')
             )) {
            $block_content = str_replace('</a>', '<svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5"></polyline></svg></a>', $block_content);
        }

        return $block_content;
    }
}

add_filter( 'render_block', 'industrium_wpblock_dropdown_wrapper', 10, 2 );