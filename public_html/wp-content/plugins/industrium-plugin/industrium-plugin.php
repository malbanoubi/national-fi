<?php
/*
Plugin Name: Industrium Plugin
Plugin URI: https://demo.artureanec.com/
Description: Register Custom Widgets and Custom Post Types for Industrium Theme.
Version: 1.2.1
Author: Artureanec
Author URI: https://demo.artureanec.com/
Text Domain: industrium_plugin
*/

// --- Register Custom Widgets --- //
if (!function_exists('industrium_widgets_load')) {
    function industrium_widgets_load() {
        require_once(__DIR__ . "/widgets/banner.php");
        require_once(__DIR__ . "/widgets/contacts.php");
        require_once(__DIR__ . "/widgets/featured-posts.php");
        require_once(__DIR__ . "/widgets/nav-menu.php");
        require_once(__DIR__ . "/widgets/request.php");
    }
}
add_action('plugins_loaded', 'industrium_widgets_load');

if (!function_exists('industrium_add_custom_widget')) {
    function industrium_add_custom_widget($name) {
        register_widget($name);
    }
}

// --- Add Mime Types --- //
function industrium_upload_mimes( $mimes = array() ) {
    // allow SVG file upload
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';

    return $mimes;
}
add_filter( 'upload_mimes', 'industrium_upload_mimes', 99 );

// --- Register Custom Post Types --- //
add_action('init', 'industrium_register_custom_post_types');
if (!function_exists('industrium_register_custom_post_types')) {
    function industrium_register_custom_post_types() {
        # Portfolio
        register_taxonomy(
            'industrium_portfolio_category',
            array('industrium_portfolio'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Portfolio Categories', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Portfolio Category', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Category', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Portfolio Categories', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Category', 'industrium_plugin'),
                    'parent_item'       => esc_html__('Parent Category', 'industrium_plugin'),
                    'parent_item_colon' => esc_html__('Parent Category:', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Category', 'industrium_plugin'),
                    'update_item'       => esc_html__('Update Category', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('Add New Category', 'industrium_plugin'),
                    'new_item_name'     => esc_html__('New Portfolio Category', 'industrium_plugin'),
                    'menu_name'         => esc_html__('Portfolio Categories', 'industrium_plugin'),
                ),
                'hierarchical'      => true,
                'show_admin_column' => false
            )
        );
        register_post_type(
            'industrium_portfolio',
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Portfolios', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Portfolio', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Portfolio', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Portfolios', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Portfolio', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Portfolio', 'industrium_plugin'),
                    'add_new'           => esc_html__('Add New Portfolio', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('New Portfolio', 'industrium_plugin'),
                    'archives'          => esc_html__('Portfolios', 'industrium_plugin')
                ),
                'public'            => true,
                'rewrite'           => array(
                    'slug'              => 'portfolio',
                    'with_front'        => false
                ),
                'hierarchical'      => true,
                'menu_position'     => 4,
                'menu_icon'         => 'dashicons-format-gallery',
                'supports'          => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
                'taxonomies'        => array( 'industrium_portfolio_category' ),
                'has_archive'       => true
            )
        );

        # Projects
        register_taxonomy(
            'industrium_project_category',
            array('industrium_project'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Project Categories', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Project Category', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Category', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Project Categories', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Category', 'industrium_plugin'),
                    'parent_item'       => esc_html__('Parent Category', 'industrium_plugin'),
                    'parent_item_colon' => esc_html__('Parent Category:', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Category', 'industrium_plugin'),
                    'update_item'       => esc_html__('Update Category', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('Add New Category', 'industrium_plugin'),
                    'new_item_name'     => esc_html__('New Project Category', 'industrium_plugin'),
                    'menu_name'         => esc_html__('Project Categories', 'industrium_plugin'),
                ),
                'hierarchical'      => true,
                'show_admin_column' => false
            )
        );
        register_post_type(
            'industrium_project',
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Projects', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Project', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Project', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Projects', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Project', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Project', 'industrium_plugin'),
                    'add_new'           => esc_html__('Add New Project', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('New Project', 'industrium_plugin'),
                    'archives'          => esc_html__('Projects', 'industrium_plugin')
                ),
                'public'            => true,
                'rewrite'           => array(
                    'slug'              => 'projects',
                    'with_front'        => false
                ),
                'hierarchical'      => true,
                'menu_position'     => 5,
                'menu_icon'         => 'dashicons-laptop',
                'supports'          => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
                'taxonomies'        => array( 'industrium_project_category' ),
                'has_archive'       => true
            )
        );

        # Team
        register_taxonomy(
            'industrium_team_department',
            array('industrium_team'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Departments', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Department', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Departments', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Departments', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Department', 'industrium_plugin'),
                    'parent_item'       => esc_html__('Parent Department', 'industrium_plugin'),
                    'parent_item_colon' => esc_html__('Parent Department:', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Department', 'industrium_plugin'),
                    'update_item'       => esc_html__('Update Department', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('Add New Department', 'industrium_plugin'),
                    'new_item_name'     => esc_html__('New Department Name', 'industrium_plugin'),
                    'menu_name'         => esc_html__('Departments', 'industrium_plugin'),
                ),
                'hierarchical'      => true,
                'show_admin_column' => false
            )
        );
        register_post_type('industrium_team',
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Team Members', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Team Member', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Team Member', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Team Members', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Team Member', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Team Member', 'industrium_plugin'),
                    'add_new'           => esc_html__('Add New Member', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('New Team Member', 'industrium_plugin'),
                    'archives'          => esc_html__('Team', 'industrium_plugin')
                ),
                'public'            => true,
                'rewrite'           => array(
                    'slug'              => 'team',
                    'with_front'        => false
                ),
                'hierarchical'      => false,
                'menu_position'     => 6,
                'menu_icon'         => 'dashicons-groups',
                'supports'          => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
                'taxonomies'        => array( 'industrium_team_department' ),
                'has_archive'       => true
            )
        );

        # Careers
        register_taxonomy(
            'industrium_careers_department',
            array('industrium_vacancy'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Departments', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Department', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Departments', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Departments', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Department', 'industrium_plugin'),
                    'parent_item'       => esc_html__('Parent Department', 'industrium_plugin'),
                    'parent_item_colon' => esc_html__('Parent Department:', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Department', 'industrium_plugin'),
                    'update_item'       => esc_html__('Update Department', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('Add New Department', 'industrium_plugin'),
                    'new_item_name'     => esc_html__('New Department Name', 'industrium_plugin'),
                    'menu_name'         => esc_html__('Departments', 'industrium_plugin'),
                ),
                'hierarchical'      => true,
                'show_admin_column' => false
            )
        );
        register_post_type('industrium_vacancy',
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Careers', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Career', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Career', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Careers', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Career', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Career', 'industrium_plugin'),
                    'add_new'           => esc_html__('Add New Career', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('New Career', 'industrium_plugin'),
                    'archives'          => esc_html__('Careers', 'industrium_plugin')
                ),
                'public'            => true,
                'rewrite'           => array(
                    'slug'              => 'careers',
                    'with_front'        => false
                ),
                'hierarchical'      => false,
                'menu_position'     => 7,
                'menu_icon'         => 'dashicons-megaphone',
                'supports'          => array( 'title', 'editor', 'author', 'excerpt' ),
                'taxonomies'        => array( 'industrium_careers_department' ),
                'has_archive'       => true
            )
        );

        # Services
        register_taxonomy(
            'industrium_services_category',
            array('industrium_service'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Service Categories', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Service Category', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Category', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Categories', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Category', 'industrium_plugin'),
                    'parent_item'       => esc_html__('Parent Category', 'industrium_plugin'),
                    'parent_item_colon' => esc_html__('Parent Category:', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Category', 'industrium_plugin'),
                    'update_item'       => esc_html__('Update Category', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('Add New Category', 'industrium_plugin'),
                    'new_item_name'     => esc_html__('New Category Name', 'industrium_plugin'),
                    'menu_name'         => esc_html__('Categories', 'industrium_plugin'),
                ),
                'hierarchical'      => true,
                'show_admin_column' => false
            )
        );
        register_post_type('industrium_service',
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Services', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Service', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Service', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Services', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Service', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Service', 'industrium_plugin'),
                    'add_new'           => esc_html__('Add New Service', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('New Service', 'industrium_plugin'),
                    'archives'          => esc_html__('Services', 'industrium_plugin')
                ),
                'public'            => true,
                'rewrite'           => array(
                    'slug'              => 'services',
                    'with_front'        => false
                ),
                'hierarchical'      => false,
                'menu_position'     => 8,
                'menu_icon'         => 'dashicons-admin-generic',
                'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
                'taxonomies'        => array( 'industrium_services_category' ),
                'has_archive'       => true
            )
        );

        # Case Studies
        register_taxonomy(
            'industrium_case_study_category',
            array('industrium_case'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Case Study Categories', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Case Study Category', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Category', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Categories', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Category', 'industrium_plugin'),
                    'parent_item'       => esc_html__('Parent Category', 'industrium_plugin'),
                    'parent_item_colon' => esc_html__('Parent Category:', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Category', 'industrium_plugin'),
                    'update_item'       => esc_html__('Update Category', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('Add New Category', 'industrium_plugin'),
                    'new_item_name'     => esc_html__('New Category Name', 'industrium_plugin'),
                    'menu_name'         => esc_html__('Categories', 'industrium_plugin'),
                ),
                'hierarchical'      => true,
                'show_admin_column' => false,
                'show_in_rest'      => true
            )
        );
        register_taxonomy(
            'industrium_case_study_tag',
            array('industrium_case'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Case Study Tags', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Case Study Tag', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Tag', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Tags', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Tag', 'industrium_plugin'),
                    'parent_item'       => esc_html__('Parent Tag', 'industrium_plugin'),
                    'parent_item_colon' => esc_html__('Parent Tag:', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Tag', 'industrium_plugin'),
                    'update_item'       => esc_html__('Update Tag', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('Add New Tag', 'industrium_plugin'),
                    'new_item_name'     => esc_html__('New Tag Name', 'industrium_plugin'),
                    'menu_name'         => esc_html__('Tags', 'industrium_plugin'),
                ),
                'hierarchical'      => false,
                'show_admin_column' => false,
                'show_in_rest'      => true
            )
        );
        register_post_type('industrium_case',
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Case Studies', 'industrium_plugin'),
                    'singular_name'     => esc_html__('Case Study', 'industrium_plugin'),
                    'search_items'      => esc_html__('Search Case Studies', 'industrium_plugin'),
                    'all_items'         => esc_html__('All Case Studies', 'industrium_plugin'),
                    'view_item'         => esc_html__('View Case Study', 'industrium_plugin'),
                    'edit_item'         => esc_html__('Edit Case Study', 'industrium_plugin'),
                    'add_new'           => esc_html__('Add New Case Study', 'industrium_plugin'),
                    'add_new_item'      => esc_html__('New Case Study', 'industrium_plugin'),
                    'archives'          => esc_html__('Case Studies', 'industrium_plugin')
                ),
                'public'            => true,
                'rewrite'           => array(
                    'slug'              => 'case-studies',
                    'with_front'        => false
                ),
                'hierarchical'      => false,
                'menu_position'     => 9,
                'menu_icon'         => 'dashicons-open-folder',
                'supports'          => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
                'taxonomies'        => array( 'industrium_case_study_category' ),
                'has_archive'       => true,
                'show_in_rest'      => true
            )
        );

    }
}

// Init Custom Widgets for Elementor
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

final class Industrium_Custom_Widgets {
    const  VERSION = '1.0.0';
    const  MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const  MINIMUM_PHP_VERSION = '5.4';
    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
    }    

    public function init() {

        load_plugin_textdomain('industrium_plugin', false, plugin_basename(dirname(__FILE__)) . '/languages');
        
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'industrium_admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'industrium_admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'industrium_admin_notice_minimum_php_version']);
            return;
        }

        // Add Custom Fonts Group
        if ( !function_exists('industrium_add_custom_fonts_group_to_elementor') ) {
            function industrium_add_custom_fonts_group_to_elementor($font_groups) {
                $additional_groups = array(
                    'theme_fonts'     => esc_html__( 'Theme Fonts', 'industrium_plugin' )
                );
                $font_groups = array_merge($font_groups, $additional_groups);
                return $font_groups;
            }
        }
        add_filter( 'elementor/fonts/groups', 'industrium_add_custom_fonts_group_to_elementor' );

        // Add Custom Fonts
        if ( !function_exists('industrium_add_custom_fonts_to_elementor') ) {
            function industrium_add_custom_fonts_to_elementor($fonts) {
                $additional_fonts = array(
                    'Manrope Alt'        => 'theme_fonts'
                );
                $fonts = array_merge($fonts, $additional_fonts);
                return $fonts;
            }
        }
        add_filter( 'elementor/fonts/additional_fonts', 'industrium_add_custom_fonts_to_elementor' );

        // Include Additional Files
        add_action('elementor/init', [$this, 'industrium_include_additional_files']);

        // Add new Elementor Categories
        add_action('elementor/init', [$this, 'industrium_add_elementor_category']);

        // Register Widget Scripts
        add_action('elementor/frontend/after_register_scripts', [$this, 'industrium_register_widget_scripts']);

        add_action('wp_enqueue_scripts', function () {
            wp_localize_script('ajax_query_products', 'industrium_ajaxurl',
                array(
                    'url' => admin_url('admin-ajax.php')
                )
            );
        });

        // Register New Widgets
        add_action('elementor/widgets/register', [$this, 'industrium_widgets_register']);

        // Register Editor Styles
        add_action('elementor/editor/before_enqueue_scripts', function () {
            wp_register_style('industrium_elementor_admin', plugins_url('industrium-plugin/css/industrium-plugin-admin.css'));
            wp_enqueue_style('industrium_elementor_admin');
        });
    }


    public function industrium_admin_notice_missing_main_plugin() {
        $message = sprintf(
        /* translators: 1: Restbeef Core 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'industrium_plugin'),
            '<strong>' . esc_html__('Restbeef Core', 'industrium_plugin') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'industrium_plugin') . '</strong>'
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function industrium_admin_notice_minimum_elementor_version() {
        $message = sprintf(
        /* translators: 1: Restbeef Core 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'industrium_plugin'),
            '<strong>' . esc_html__('Restbeef Core', 'industrium_plugin') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'industrium_plugin') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function industrium_admin_notice_minimum_php_version() {
        $message = sprintf(
        /* translators: 1: Press Elements 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'industrium_plugin'),
            '<strong>' . esc_html__('Press Elements', 'industrium_plugin') . '</strong>',
            '<strong>' . esc_html__('PHP', 'industrium_plugin') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function industrium_include_additional_files() {}

    public function industrium_add_elementor_category() {
        $categories = [];
        $categories['industrium_widgets'] = [
            'title' => esc_html__('Industrium Widgets', 'industrium_plugin'),
            'icon'  => 'eicon-plug'
        ];
        $old_categories = \Elementor\Plugin::$instance->elements_manager->get_categories();
        $categories     = array_merge($categories, $old_categories);

        $set_categories = function ( $categories ) {
            $this->categories = $categories;
        };
        $set_categories->call( \Elementor\Plugin::$instance->elements_manager, $categories );
    }

    public function industrium_register_widget_scripts() {
        // Lib
        wp_register_script('fancybox', plugins_url('industrium-plugin/js/lib/jquery.fancybox.min.js'), array('jquery'));
        wp_register_script('slick-slider', plugins_url('industrium-plugin/js/lib/slick.min.js'), array('jquery'));
        wp_register_script('isotope', plugins_url('industrium-plugin/js/lib/isotope.pkgd.min.js'), array('jquery'));
        wp_register_script('plugin', plugins_url('industrium-plugin/js/lib/jquery.plugin.js'), array('jquery'));
        wp_register_script('countdown', plugins_url('industrium-plugin/js/lib/jquery.countdown.min.js'), array('jquery', 'plugin'));

        // Scripts
        wp_register_script('tabs_widget', plugins_url('industrium-plugin/js/tabs-widget.js'), array('jquery', 'industrium-theme'));
        wp_register_script('elementor_widgets', plugins_url('industrium-plugin/js/elementor-widgets.js'), array('jquery', 'owl-carousel', 'isotope', 'industrium-theme'));
        wp_register_script('countdown_widget', plugins_url('industrium-plugin/js/countdown-widget.js'), array('jquery', 'countdown'));
    }

    public function industrium_widgets_register() {

        // --- Include Widget Files --- //
        require_once __DIR__ . '/elements/blog.php';
        require_once __DIR__ . '/elements/button.php';
        require_once __DIR__ . '/elements/case-study-listing.php';
        require_once __DIR__ . '/elements/content-slider.php';
        require_once __DIR__ . '/elements/countdown.php';
        require_once __DIR__ . '/elements/decoration.php';
        require_once __DIR__ . '/elements/heading.php';
        require_once __DIR__ . '/elements/history-carousel.php';
        require_once __DIR__ . '/elements/icon-box.php';
        require_once __DIR__ . '/elements/image-carousel.php';
        require_once __DIR__ . '/elements/portfolio-listing.php';
        require_once __DIR__ . '/elements/price-item.php';
        require_once __DIR__ . '/elements/projects-listing.php';
        require_once __DIR__ . '/elements/special-text.php';
        require_once __DIR__ . '/elements/services-listing.php';
        require_once __DIR__ . '/elements/step.php';
        require_once __DIR__ . '/elements/step-carousel.php';
        require_once __DIR__ . '/elements/tabs.php';
        require_once __DIR__ . '/elements/team-members.php';
        require_once __DIR__ . '/elements/testimonial-carousel.php';
        require_once __DIR__ . '/elements/vacancies-listing.php';
        require_once __DIR__ . '/elements/video-button.php';

        // --- Register Widgets --- //
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Blog_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Button_Widget());        
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Vacancies_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Case_Study_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Content_Slider_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Countdown_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Decoration_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Heading_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_History_Carousel_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Icon_Box_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Image_Carousel_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Portfolio_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Price_Item_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Projects_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Services_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Special_Text_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Step_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Step_Carousel_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Tabs_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Team_Members_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Testimonial_Carousel_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Video_Button_Widget());        

        if (class_exists('WooCommerce')) {
            require_once __DIR__ . '/elements/products.php';
            \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Products_Widget());
        }

        if ( function_exists( 'wpforms' ) ) {
            require_once __DIR__ . '/elements/wpforms.php';
            \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Wpforms_Widget());
        }

        if ( function_exists( 'sb_instagram_feed_init' ) ) {
            require_once __DIR__ . '/elements/instagram-feed.php';
            \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Instagram_Feed_Widget());
        }

        if ( function_exists( 'mc4wp' ) ) {
            require_once __DIR__ . '/elements/mailchimp.php';
            \Elementor\Plugin::instance()->widgets_manager->register(new Industrium\Widgets\Industrium_Mailchimp_Widget());
        }
    }
}

Industrium_Custom_Widgets::instance();

if ( did_action( 'elementor/loaded' ) ) {

    add_action('elementor/element/before_section_end', function ($element, $section_id, $args) {
        if ('section' === $element->get_name() && 'section_background' === $section_id) {
            $element->add_control(
                'use_parallax',
                [
                    'label'         => esc_html__( 'Parallax Effect', 'plugin-domain' ),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'On', 'your-plugin' ),
                    'label_off'     => esc_html__( 'Off', 'your-plugin' ),
                    'return_value'  => 'yes',
                    'default'       => 'no'
                ]
            );
        }
        if ('section' === $element->get_name() && 'section_layout' === $section_id) {
            $element->add_control(
                'section_container_padding',
                [
                    'label'         => esc_html__( 'Remove Container Padding', 'industrium_plugin' ),
                    'description'    => esc_html__('Container paddings are added to no gap stretched section`s container'),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'On', 'industrium_plugin' ),
                    'label_off'     => esc_html__( 'Off', 'industrium_plugin' ),
                    'return_value'  => 'container-padding-remove',
                    'default'       => '',
                    'prefix_class'  => 'elementor-section-',
                    'hide_in_inner' => true,
                    'condition'     => [
                        'stretch_section' => 'section-stretched',
                        'gap!'       => 'no'
                    ] 
                ]
            );
        }
        if ('section' === $element->get_name() && 'section_layout' === $section_id) {
            $element->add_control(
                'section_row_wrap',
                [
                    'label'         => esc_html__( 'Allow Columns Wrap', 'industrium_plugin' ),
                    'description'    => esc_html__('Allow Columns Wrap on Tablet and up'),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'On', 'industrium_plugin' ),
                    'label_off'     => esc_html__( 'Off', 'industrium_plugin' ),
                    'return_value'  => 'row-wrap',
                    'default'       => '',
                    'prefix_class'  => 'elementor-section-'
                ]
            );
        }
        if ('section' === $element->get_name() && 'section_layout' === $section_id) {
            $element->add_control(
                'section_inner_container_padding',
                [
                    'label'         => esc_html__( 'Remove Container Padding', 'industrium_plugin' ),
                    'description'    => esc_html__('Container paddings are added to inner section container in stretched parent section with no gap'),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'On', 'industrium_plugin' ),
                    'label_off'     => esc_html__( 'Off', 'industrium_plugin' ),
                    'return_value'  => 'container-padding-remove',
                    'default'       => '',
                    'prefix_class'  => 'elementor-section-',
                    'hide_in_top' => true,
                    'condition'     => [
                        'gap!'       => 'no'
                    ] 
                ]
            );
        }

        if ('image' === $element->get_name() && 'section_image' === $section_id) {
            $element->add_control(
                'hovered_caption',
                [
                    'label' => esc_html__( 'Add Hovered Caption', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', 'industrium_plugin' ),
                    'label_off'     => esc_html__( 'No', 'industrium_plugin' ),
                    'return_value'  => 'yes',
                    'default'       => 'no',
                    'condition' => [
                        'link_to!' => 'none'
                    ]
                ]
            );
            $element->add_control(
                'hovered_caption_text',
                [
                    'label' => esc_html__( 'Hovered Caption Text', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'condition' => [
                        'hovered_caption' => 'yes',
                        'link_to!' => 'none'
                    ]
                ]
            );  
            $element->add_control(
                'link_style',
                [
                    'label' => esc_html__( 'Link Style', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        'inline-block' => esc_html__( 'Default', 'industrium_plugin' ),
                        'block' => esc_html__( 'Block', 'industrium_plugin' )
                    ],
                    'default' => 'inline-block',
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image a' => 'display: {{VALUE}};',
                    ],
                ]
            );
            $element->add_control(
                'image_badge',
                [
                    'label' => esc_html__( 'Add Image Badge', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', 'industrium_plugin' ),
                    'label_off'     => esc_html__( 'No', 'industrium_plugin' ),
                    'return_value'  => 'yes',
                    'default'       => 'no'
                ]
            );
            $element->add_control(
                'image_badge_text',
                [
                    'label' => esc_html__( 'Image Badge Text', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'condition' => [
                        'image_badge' => 'yes'
                    ]
                ]
            );
            $element->add_control(
                'image_badge_hor_position',
                [
                    'label' => esc_html__( 'Image Badge Horizontal Position', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-badge' => 'left: {{SIZE}}{{UNIT}};',
                        'body.rtl {{WRAPPER}} .elementor-image-badge' => 'right: {{SIZE}}{{UNIT}};'
                    ],
                    'condition' => [
                        'image_badge' => 'yes'
                    ]
                ]
            );
            $element->add_control(
                'image_badge_vert_position',
                [
                    'label' => esc_html__( 'Image Badge Vertical Position', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-badge' => 'top: {{SIZE}}{{UNIT}};'
                    ],
                    'condition' => [
                        'image_badge' => 'yes'
                    ]
                ]
            );
        }

        if ('image' === $element->get_name() && 'section_style_image' === $section_id) {
            $element->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name'          => 'hovered_caption_typography',
                    'label'         => esc_html__('Hovered Caption Typography', 'industrium_plugin'),
                    'selector'      => '{{WRAPPER}} .hovered-caption',
                    'condition' => [
                        'hovered_caption' => 'yes',
                        'link_to!' => 'none'
                    ],
                ]
            );
            $element->add_control(
                'hovered_caption_color',
                [
                    'label' => esc_html__( 'Hovered Caption Color', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'condition' => [
                        'hovered_caption' => 'yes',
                        'link_to!' => 'none'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .hovered-caption' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $element->add_control(
                'hovered_caption_bg_color',
                [
                    'label' => esc_html__( 'Hovered Caption Background Color', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'condition' => [
                        'hovered_caption' => 'yes',
                        'link_to!' => 'none'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .hovered-caption' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $element->add_responsive_control(
                'hovered_caption_padding',
                [
                    'label' => esc_html__( 'Hovered Caption Padding', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .hovered-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'hovered_caption' => 'yes',
                        'link_to!' => 'none'
                    ],
                ]
            );
            $element->add_responsive_control(
                'image_link_padding',
                [
                    'label' => esc_html__( 'Image Link Padding', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'link_to!' => 'none'
                    ],
                ]
            );
            $element->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name'          => 'image_badge_typography',
                    'label'         => esc_html__('Image Badge Typography', 'industrium_plugin'),
                    'selector'      => '{{WRAPPER}} .elementor-image-badge',
                    'condition' => [
                        'image_badge' => 'yes'
                    ],
                ]
            );
            $element->add_control(
                'image_badge_color',
                [
                    'label' => esc_html__( 'Image Badge Color', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'condition' => [
                        'image_badge' => 'yes'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-badge' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $element->add_control(
                'image_badge_bg_color',
                [
                    'label' => esc_html__( 'Image Badge Background Color', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'condition' => [
                        'image_badge' => 'yes'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-badge' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
        }
        if ('text-editor' === $element->get_name() && 'section_style' === $section_id) {
            $element->add_control(
				'height',
				[
					'label' => esc_html__( 'Height', 'industrium_plugin' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}}' => 'min-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-widget-container' => 'height: 100%;',
					],
				]
			);
        }

        if ('social-icons' === $element->get_name() && 'section_social_hover' === $section_id) {            
            $element->remove_control('hover_primary_color');
            $element->add_control(
                'hover_primary_color',
                [
                    'label' => esc_html__( 'Primary Color', 'elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'condition' => [
                        'icon_color' => 'custom',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-social-icon:before' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
        }

        if ('accordion' === $element->get_name() && 'section_title_style' === $section_id) {
            $element->add_control(
                'accordion_border_color',
                [
                    'label' => esc_html__( 'Item Border Color', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-accordion-item' => 'color: {{VALUE}};'
                    ],
                ]
            );
        }

        if ('accordion' === $element->get_name() && 'section_title_style' === $section_id) {
            $element->add_control(
                'accordion_icon_width',
                [
                    'label' => esc_html__( 'Icon Auto Width', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-tab-title .elementor-accordion-icon svg' => 'width: auto;'
                    ],
                ]
            );
            $element->add_control(
                'accordion_icon_height',
                [
                    'label' => esc_html__( 'Icon Auto Height', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-tab-title .elementor-accordion-icon svg' => 'height: auto;'
                    ],
                ]
            );
        }

        if ('progress' === $element->get_name() && 'section_progress' === $section_id) {
            $element->remove_control('inner_text');
            $element->add_control(
                'inner_text',
                [
                    'label'     => esc_html__( 'Hidden Inner Text', 'elementor' ),
                    'type'      => \Elementor\Controls_Manager::HIDDEN,
                    'default'   => ''
                ]
            );
        }
        if ('progress' === $element->get_name() && 'section_progress_style' === $section_id) {
            $element->remove_control('bar_color');
            $element->remove_control('bar_bg_color');
            $element->remove_control('bar_height');
            $element->remove_control('bar_border_radius');
            $element->remove_control('inner_text_heading');
            $element->remove_control('bar_inline_color');

            $element->remove_control('bar_inner_typography_typography');
            $element->remove_control('bar_inner_typography_font_family');
            $element->remove_responsive_control('bar_inner_typography_font_size');
            $element->remove_control('bar_inner_typography_font_weight');
            $element->remove_control('bar_inner_typography_text_transform');
            $element->remove_control('bar_inner_typography_font_style');
            $element->remove_control('bar_inner_typography_text_decoration');
            $element->remove_responsive_control('bar_inner_typography_line_height');
            $element->remove_responsive_control('bar_inner_typography_letter_spacing');

            $element->remove_control('bar_inner_shadow_text_shadow');
            $element->remove_control('bar_inner_shadow_text_shadow_type');

            $element->add_control(
                'progress_bar_bg_color',
                [
                    'label'     => esc_html__( 'Track Color', 'industrium_plugin' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-progress-wrapper' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $element->add_control(
                'progress_bar_color',
                [
                    'label'     => esc_html__( 'Progress Color', 'industrium_plugin' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-progress-wrapper .elementor-progress-bar' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
        }
        if ('progress' === $element->get_name() && 'section_title' === $section_id) {
            $element->remove_control('title_color');

            $element->remove_control('typography_typography');
            $element->remove_control('typography_font_family');
            $element->remove_responsive_control('typography_font_size');
            $element->remove_control('typography_font_weight');
            $element->remove_control('typography_text_transform');
            $element->remove_control('typography_font_style');
            $element->remove_control('typography_text_decoration');
            $element->remove_responsive_control('typography_line_height');
            $element->remove_responsive_control('typography_letter_spacing');

            $element->remove_control('title_shadow_text_shadow');
            $element->remove_control('title_shadow_text_shadow_type');

            $element->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name'          => 'progress_title_typography',
                    'label'         => esc_html__('Title Typography', 'industrium_plugin'),
                    'selector'      => '{{WRAPPER}} .elementor-widget-container .elementor-widget-progress .elementor-title'
                ]
            );
            $element->add_control(
                'progress_title_color',
                [
                    'label'     => esc_html__( 'Title Color', 'elementor' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-widget-container .elementor-widget-progress .elementor-title' => 'color: {{VALUE}};',
                    ]
                ]
            );

            $element->add_control(
                'progress_percentage_separator',
                [
                    'type'      => \Elementor\Controls_Manager::DIVIDER,
                    'condition' => [
                        'display_percentage'    => 'show'
                    ]
                ]
            );

            $element->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name'      => 'progress_percentage_typography',
                    'label'     => esc_html__('Percentage Typography', 'industrium_plugin'),
                    'selector'  => '{{WRAPPER}} .elementor-widget-container .elementor-progress-percentage',
                    'condition' => [
                        'display_percentage'    => 'show'
                    ]
                ]
            );
            $element->add_control(
                'progress_percentage_color',
                [
                    'label'     => esc_html__( 'Percentage Color', 'elementor' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-widget-container .elementor-progress-percentage' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'display_percentage'    => 'show'
                    ]
                ]
            );
        }
        if ('counter' === $element->get_name() && 'section_counter' === $section_id) {
            $element->add_responsive_control(
                'info_align',
                [
                    'label'     => esc_html__('Text Alignment', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::CHOOSE,
                    'options'   => [
                        'left'      => [
                            'title'     => esc_html__('Left', 'industrium_plugin'),
                            'icon'      => 'eicon-text-align-left',
                        ],
                        'center'    => [
                            'title'     => esc_html__('Center', 'industrium_plugin'),
                            'icon'      => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title'     => esc_html__('Right', 'industrium_plugin'),
                            'icon'      => 'eicon-text-align-right',
                        ]
                    ],
                    'default'   => 'center',
                    'selectors' => [
                        '{{WRAPPER}} .elementor-counter .elementor-counter-title, {{WRAPPER}} .elementor-counter .elementor-counter-number-wrapper' => 'text-align: {{VALUE}};',
                    ],
                    'prefix_class' => 'elementor-counter-alignment%s-'
                ]
            );
        }
        if ('counter' === $element->get_name() && 'section_number' === $section_id) {
            $element->remove_control('number_color');
            $element->add_control(
                'number_color',
                [
                    'label'     => esc_html__('Text Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-counter-number-wrapper' => '-webkit-text-stroke: 1px {{VALUE}};'
                    ]
                ]
            );
        }

        if ('counter' === $element->get_name() && 'section_counter' === $section_id) { 
                $element->add_control(
                    'title_position',
                    [
                        'label' => esc_html__( 'Title Position', 'industrium_plugin' ),
                        'type' => \Elementor\Controls_Manager::CHOOSE,
                        'default' => 'top',
                        'options' => [
                            'left' => [
                                'title' => esc_html__( 'Left', 'industrium_plugin' ),
                                'icon' => 'eicon-h-align-left',
                            ],
                            'top' => [
                                'title' => esc_html__( 'Top', 'industrium_plugin' ),
                                'icon' => 'eicon-v-align-top',
                            ],
                            'bottom' => [
                                'title' => esc_html__( 'Bottom', 'industrium_plugin' ),
                                'icon' => 'eicon-v-align-bottom',
                            ],
                            'right' => [
                                'title' => esc_html__( 'Right', 'industrium_plugin' ),
                                'icon' => 'eicon-h-align-right',
                            ],
                        ],
                        'prefix_class' => 'elementor-position-',
                        'toggle' => false
                    ]
                );
                $element->add_responsive_control(
                    'vert_alignment',
                    [
                        'label' => esc_html__( 'Vertical Alignment', 'industrium_plugin' ),
                        'type' => \Elementor\Controls_Manager::CHOOSE,
                        'default' => 'center',
                        'options' => [
                            'flex-start' => [
                                'title' => esc_html__( 'Top', 'industrium_plugin' ),
                                'icon' => 'eicon-v-align-top',
                            ],
                            'center' => [
                                'title' => esc_html__( 'Middle', 'industrium_plugin' ),
                                'icon' => 'eicon-v-align-middle',
                            ],
                            'flex-end' => [
                                'title' => esc_html__( 'Bottom', 'industrium_plugin' ),
                                'icon' => 'eicon-v-align-bottom',
                            ]
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .elementor-counter' => '-webkit-align-items: {{VALUE}}; -moz-align-items: {{VALUE}}; -ms-align-items: {{VALUE}}; align-items: {{VALUE}};',
                        ],
                        'conditions' => [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'title_position',
                                    'operator' => '==',
                                    'value' => 'left'
                                ],
                                [
                                    'name' => 'title_position',
                                    'operator' => '==',
                                    'value' => 'right'
                                ]
                            ]
                        ]
                    ]
                );
            }
        if ('counter' === $element->get_name() && 'section_title' === $section_id) {
            $element->add_responsive_control(
                'title_margin',
                [
                    'label' => esc_html__( 'Title Margin', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-counter .elementor-counter-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $element->add_control(
                'title_type',
                [
                    'label' => esc_html__( 'Title Type', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        'normal' => esc_html__( 'Normal', 'industrium_plugin' ),
                        'vertical' => esc_html__( 'Vertical', 'industrium_plugin' )
                    ],
                    'default' => 'normal',
                    'prefix_class' => 'elementor-counter-title-'
                ]
            );
        }
        if ('icon' === $element->get_name() && 'section_icon' === $section_id) {
            $element->add_control(
                'add_pulse_animation',
                [
                    'label'         => esc_html__( 'Permanent Pulse Animation', 'industrium_plugin' ),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Show', 'industrium_plugin' ),
                    'label_off'     => esc_html__( 'Hide', 'industrium_plugin' ),
                    'return_value'  => 'yes',
                    'default'       => 'no',
                    'prefix_class'  => 'pulse-animation-',
                    'toggle'        => true
                ]
            );
        }
        if ('icon' === $element->get_name() && 'section_style_icon' === $section_id) {
            $element->add_control(
                'pulse_border_color',
                [
                    'label'     => esc_html__('Pulse Animation Border Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon:before' => 'border-color: {{VALUE}};'
                    ],
                    'condition' => [
                        'add_pulse_animation'  => 'yes'
                    ],
                    'default'   => '#ffffff',
                    'separator' => 'before'
                ]
            );
        }
        if ('icon-list' === $element->get_name() && 'section_icon_style' === $section_id) {
            $element->add_responsive_control(
                'icon_spacing',
                [
                    'label' => esc_html__( 'Space Before Icon', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon-list-icon' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );   
        }
        if ('image-box' === $element->get_name() && 'section_style_content' === $section_id) {
            $element->add_control(
                'title_padding',
                [
                    'label' => esc_html__( 'Title Padding', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $element->add_control(
                'title_border_color',
                [
                    'label'     => esc_html__('Title Border Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title' => 'border-color: {{VALUE}};'
                    ],
                ]
            );
            $element->add_control(
                'arrow_color',
                [
                    'label'     => esc_html__('Arrow Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title a:before' => 'color: {{VALUE}};'
                    ],
                ]
            );
            $element->add_control(
                'arrow_color_hover',
                [
                    'label'     => esc_html__('Arrow Hover Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title a:hover:before' => 'color: {{VALUE}};'
                    ],
                ]
            );
        }

        if ('icon-box' === $element->get_name() && 'section_style_content' === $section_id) {
            $element->add_control(
                'title_padding',
                [
                    'label' => esc_html__( 'Title Padding', 'industrium_plugin' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $element->add_control(
                'title_border_color',
                [
                    'label'     => esc_html__('Title Border Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title' => 'border-color: {{VALUE}};'
                    ],
                ]
            );
            $element->add_control(
                'arrow_color',
                [
                    'label'     => esc_html__('Arrow Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title a:before' => 'color: {{VALUE}};'
                    ],
                ]
            );
            $element->add_control(
                'arrow_color_hover',
                [
                    'label'     => esc_html__('Arrow Hover Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title a:hover:before' => 'color: {{VALUE}};'
                    ],
                ]
            );
        }

        if ( 'video' === $element->get_name() && 'section_image_overlay' === $section_id ) {
            $element->add_control(
                'show_color_overlay',
                [
                    'label'                 => esc_html__( 'Color Overlay', 'industrium_plugin' ),
                    'type'                  => \Elementor\Controls_Manager::SWITCHER,
                    'label_off'             => esc_html__( 'Hide', 'industrium_plugin' ),
                    'label_on'              => esc_html__( 'Show', 'industrium_plugin' ),
                    'frontend_available'    => true,
                    'condition'             => [
                        'show_image_overlay'    => 'yes'
                    ],
                    'separator'             => 'before'
                ]
            );

            $element->start_controls_tabs(
                'tabs_background_overlay',
                [
                    'condition' => [
                        'show_image_overlay'    => 'yes',
                        'show_color_overlay'    => 'yes'
                    ],
                ]
            );

                $element->start_controls_tab(
                    'tab_background_overlay_normal',
                    [
                        'label' => esc_html__( 'Normal', 'industrium_plugin' ),
                    ]
                );

                    $element->add_group_control(
                        \Elementor\Group_Control_Background::get_type(),
                        [
                            'name'      => 'background_overlay',
                            'selector'  => '{{WRAPPER}} .elementor-custom-embed-image-overlay:before',
                        ]
                    );

                    $element->add_control(
                        'background_overlay_opacity',
                        [
                            'label'     => esc_html__( 'Opacity', 'industrium_plugin' ),
                            'type'      => \Elementor\Controls_Manager::SLIDER,
                            'default'   => [
                                'size'      => .5,
                            ],
                            'range'     => [
                                'px'        => [
                                    'max'       => 1,
                                    'step'      => 0.01,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .elementor-custom-embed-image-overlay:before' => 'opacity: {{SIZE}};',
                            ],
                            'condition' => [
                                'background_overlay_background' => [ 'classic', 'gradient' ],
                            ],
                        ]
                    );

                    $element->add_group_control(
                        \Elementor\Group_Control_Css_Filter::get_type(),
                        [
                            'name'          => 'bg_css_filters',
                            'selector'      => '{{WRAPPER}} .elementor-custom-embed-image-overlay:before',
                            'conditions'    => [
                                'relation'      => 'or',
                                'terms'         => [
                                    [
                                        'name'      => 'background_overlay_image[url]',
                                        'operator'  => '!==',
                                        'value'     => '',
                                    ],
                                    [
                                        'name'      => 'background_overlay_color',
                                        'operator'  => '!==',
                                        'value'     => '',
                                    ],
                                ],
                            ],
                        ]
                    );

                    $element->add_control(
                        'overlay_blend_mode',
                        [
                            'label'         => esc_html__( 'Blend Mode', 'industrium_plugin' ),
                            'type'          => \Elementor\Controls_Manager::SELECT,
                            'options'       => [
                                ''              => esc_html__( 'Normal', 'industrium_plugin' ),
                                'multiply'      => 'Multiply',
                                'screen'        => 'Screen',
                                'overlay'       => 'Overlay',
                                'darken'        => 'Darken',
                                'lighten'       => 'Lighten',
                                'color-dodge'   => 'Color Dodge',
                                'saturation'    => 'Saturation',
                                'color'         => 'Color',
                                'luminosity'    => 'Luminosity',
                            ],
                            'selectors'     => [
                                '{{WRAPPER}} .elementor-custom-embed-image-overlay:before' => 'mix-blend-mode: {{VALUE}}',
                            ],
                            'conditions'    => [
                                'relation'      => 'or',
                                'terms'         => [
                                    [
                                        'name'      => 'background_overlay_image[url]',
                                        'operator'  => '!==',
                                        'value'     => '',
                                    ],
                                    [
                                        'name'      => 'background_overlay_color',
                                        'operator'  => '!==',
                                        'value'     => '',
                                    ],
                                ],
                            ],
                        ]
                    );

                $element->end_controls_tab();

                $element->start_controls_tab(
                    'tab_background_overlay_hover',
                    [
                        'label' => esc_html__( 'Hover', 'industrium_plugin' ),
                    ]
                );

                    $element->add_group_control(
                        \Elementor\Group_Control_Background::get_type(),
                        [
                            'name'      => 'background_overlay_hover',
                            'selector'  => '{{WRAPPER}}:hover .elementor-custom-embed-image-overlay:before',
                        ]
                    );

                    $element->add_control(
                        'background_overlay_hover_opacity',
                        [
                            'label'     => esc_html__( 'Opacity', 'industrium_plugin' ),
                            'type'      => \Elementor\Controls_Manager::SLIDER,
                            'default'   => [
                                'size'      => .5,
                            ],
                            'range'     => [
                                'px'        => [
                                    'max'       => 1,
                                    'step'      => 0.01,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}}:hover .elementor-custom-image-color-overlay:before' => 'opacity: {{SIZE}};',
                            ],
                            'condition' => [
                                'background_overlay_hover_background' => [ 'classic', 'gradient' ],
                            ],
                        ]
                    );

                    $element->add_group_control(
                        \Elementor\Group_Control_Css_Filter::get_type(),
                        [
                            'name'      => 'bg_css_filters_hover',
                            'selector'  => '{{WRAPPER}}:hover .elementor-custom-embed-image-overlay:before',
                        ]
                    );

                    $element->add_control(
                        'background_overlay_hover_transition',
                        [
                            'label'         => esc_html__( 'Transition Duration', 'industrium_plugin' ),
                            'type'          => \Elementor\Controls_Manager::SLIDER,
                            'default'       => [
                                'size'  => 0.3,
                            ],
                            'range'         => [
                                'px'    => [
                                    'max'       => 3,
                                    'step'      => 0.1,
                                ],
                            ],
                            'render_type'   => 'ui',
                            'separator'     => 'before',
                        ]
                    );

                $element->end_controls_tab();

            $element->end_controls_tabs();
        }
        if ( 'video' === $element->get_name() && 'section_video_style' === $section_id ) {
            $element->remove_control('play_icon_title');
            $element->remove_control('play_icon_color');
            $element->remove_responsive_control('play_icon_size');
            $element->remove_control('play_icon_text_shadow');
            $element->remove_control('play_icon_text_shadow_type');

            $element->add_responsive_control(
                'video_width',
                [
                    'label'         => esc_html__('Video Max Width', 'industrium_plugin'),
                    'type'          => \Elementor\Controls_Manager::SLIDER,
                    'size_units'    => [ 'px', '%' ],
                    'range'         => [
                        'px'            => [
                            'min'           => 100,
                            'max'           => 1170,
                        ],
                        '%'             => [
                            'min'           => 1,
                            'max'           => 100,
                        ]
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .elementor-widget-container' => 'max-width: {{SIZE}}{{UNIT}};'
                    ]
                ]
            );
            $element->add_responsive_control(
                'video_float',
                [
                    'label'     => esc_html__('Video Position', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::CHOOSE,
                    'options'   => [
                        'left'      => [
                            'title'     => esc_html__('Left', 'industrium_plugin'),
                            'icon'      => 'eicon-text-align-left',
                        ],
                        'none'      => [
                            'title'     => esc_html__('Center', 'industrium_plugin'),
                            'icon'      => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title'     => esc_html__('Right', 'industrium_plugin'),
                            'icon'      => 'eicon-text-align-right',
                        ]
                    ],
                    'default'   => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .elementor-widget-container' => 'float: {{VALUE}};',
                    ],
                ]
            );
            $element->add_control(
                'play_icon_title',
                [
                    'label'     => esc_html__( 'Play Icon', 'elementor' ),
                    'type'      => \Elementor\Controls_Manager::HEADING,
                    'condition' => [
                        'show_image_overlay'    => 'yes',
                        'show_play_icon'        => 'yes',
                    ],
                    'separator' => 'before',
                ]
            );

            $element->add_responsive_control(
                'play_button_size',
                [
                    'label'     => esc_html__( 'Button Size', 'elementor' ),
                    'type'      => \Elementor\Controls_Manager::SLIDER,
                    'range'     => [
                        'px'        => [
                            'min'       => 10,
                            'max'       => 300,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-custom-embed-play'              => 'width: calc({{SIZE}}{{UNIT}} + 50px); height: calc({{SIZE}}{{UNIT}} + 50px);',
                        '{{WRAPPER}} .elementor-custom-embed-play:before'       => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; margin: calc(-{{SIZE}}{{UNIT}} / 2) 0 0 calc(-{{SIZE}}{{UNIT}} / 2)',
                        '{{WRAPPER}} .elementor-custom-embed-play .progress'    => 'width: calc({{SIZE}}{{UNIT}} + 32px); height: calc({{SIZE}}{{UNIT}} + 32px); top: calc( 50% - ( ({{SIZE}}{{UNIT}} + 32px) / 2 )); left: calc( 50% - ( ({{SIZE}}{{UNIT}} + 32px) / 2 ));',
                    ],
                    'condition' => [
                        'show_image_overlay'    => 'yes',
                        'show_play_icon'        => 'yes',
                    ],
                ]
            );

            $element->add_responsive_control(
                'play_icon_size',
                [
                    'label'     => esc_html__( 'Icon Size', 'elementor' ),
                    'type'      => \Elementor\Controls_Manager::SLIDER,
                    'range'     => [
                        'px'        => [
                            'min'       => 10,
                            'max'       => 300,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-custom-embed-play:before' => 'font-size: {{SIZE}}{{UNIT}}',
                    ],
                    'condition' => [
                        'show_image_overlay'    => 'yes',
                        'show_play_icon'        => 'yes',
                    ],
                ]
            );

            $element->start_controls_tabs('button_settings_tabs');

                // ------------------------ //
                // ------ Normal Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'tab_button_normal',
                    [
                        'label' => esc_html__('Normal', 'industrium_plugin')
                    ]
                );

                    $element->add_control(
                        'play_icon_color',
                        [
                            'label'     => esc_html__('Icon Color', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .elementor-custom-embed-play:before' => 'color: {{VALUE}};'
                            ]
                        ]
                    );

                    $element->add_control(
                        'play_icon_bg',
                        [
                            'label'     => esc_html__('Icon Background', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .elementor-custom-embed-play:before' => 'background: {{VALUE}};',
                                '{{WRAPPER}} .elementor-custom-embed-play .progress__circle, {{WRAPPER}} .elementor-custom-embed-play .progress__path' => 'stroke: {{VALUE}};'
                            ]
                        ]
                    );

                $element->end_controls_tab();

                // ----------------------- //
                // ------ Hover Tab ------ //
                // ----------------------- //
                $element->start_controls_tab(
                    'tab_button_hover',
                    [
                        'label' => esc_html__('Hover', 'industrium_plugin')
                    ]
                );

                    $element->add_control(
                        'play_icon_hover',
                        [
                            'label'     => esc_html__('Icon Hover', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .elementor-custom-embed-play:hover:before' => 'color: {{VALUE}};'
                            ]
                        ]
                    );

                    $element->add_control(
                        'play_icon_bg_hover',
                        [
                            'label'     => esc_html__('Icon Background Hover', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .elementor-custom-embed-play:hover:before' => 'background: {{VALUE}};',
                                '{{WRAPPER}} .elementor-custom-embed-play:hover .progress__circle, {{WRAPPER}} .elementor-custom-embed-play:hover .progress__path' => 'stroke: {{VALUE}};'
                            ]
                        ]
                    );

                $element->end_controls_tab();

            $element->end_controls_tabs();
        }


        if ('image-carousel' === $element->get_name() && 'section_style_navigation' === $section_id) {

            $element->remove_control('arrows_size');
            $element->remove_control('arrows_color');
            $element->remove_control('heading_style_dots');
            $element->remove_control('dots_position');
            $element->remove_control('dots_size');
            $element->remove_control('dots_color');



            $element->start_controls_tabs(
                'slider_nav_settings_tabs',
                [
                    'condition' => [
                        'navigation' => [ 'arrows', 'both' ],
                    ]
                ]
            );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $element->start_controls_tab(
                'tab_arrows_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

            $element->add_control(
                'nav_color',
                [
                    'label'     => esc_html__('Slider Arrows Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container .elementor-swiper-button i' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'nav_bd',
                [
                    'label'     => esc_html__('Slider Arrows Border', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container .elementor-swiper-button i' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'nav_bg',
                [
                    'label'     => esc_html__('Slider Arrows Background', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container .elementor-swiper-button i' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'nav_box_shadow',
                    'label'     => esc_html__( 'Box Shadow', 'industrium_plugin' ),
                    'selector'  => '{{WRAPPER}} .swiper-container .elementor-swiper-button i',
                ]
            );

            $element->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $element->start_controls_tab(
                'tab_arrows_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );

            $element->add_control(
                'nav_hover',
                [
                    'label'     => esc_html__('Slider Arrows Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container .elementor-swiper-button:hover i' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'nav_bd_hover',
                [
                    'label'     => esc_html__('Slider Arrows Border', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container .elementor-swiper-button:hover i' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'nav_bg_hover',
                [
                    'label'     => esc_html__('Slider Arrows Background', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container .elementor-swiper-button:hover i' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'nav_box_shadow_hover',
                    'label'     => esc_html__( 'Box Shadow', 'industrium_plugin' ),
                    'selector'  => '{{WRAPPER}} .swiper-container .elementor-swiper-button:hover i',
                ]
            );

            $element->end_controls_tab();

            $element->end_controls_tabs();


            $element->add_control(
                'heading_style_dots',
                [
                    'label'     => esc_html__( 'Dots', 'elementor' ),
                    'type'      => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'navigation' => [ 'dots', 'both' ],
                    ],
                ]
            );


            $element->start_controls_tabs(
                'slider_dot_settings_tabs',
                [
                    'condition' => [
                        'navigation' => [ 'dots', 'both' ],
                    ]
                ]
            );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $element->start_controls_tab(
                'pagination_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

            $element->add_control(
                'dot_color',
                [
                    'label'     => esc_html__('Pagination Dot Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet:after' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'dot_border',
                [
                    'label'     => esc_html__('Pagination Dot Border', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->end_controls_tab();

            // ------------------------ //
            // ------ Active Tab ------ //
            // ------------------------ //
            $element->start_controls_tab(
                'pagination_active',
                [
                    'label' => esc_html__('Active', 'industrium_plugin')
                ]
            );

            $element->add_control(
                'dot_active',
                [
                    'label'     => esc_html__('Pagination Active Dot Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active:after' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'dot_border_active',
                [
                    'label'     => esc_html__('Pagination Active Dot Border', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->end_controls_tab();

            $element->end_controls_tabs();
        }

        if ('image-carousel' === $element->get_name() && 'section_style_image' === $section_id) {
            $element->remove_control('image_spacing');
            $element->remove_control('image_spacing_custom');
            $element->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'image_shadow',
                    'selector'  => '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .swiper-slide-image',
                ]
            );

            $element->add_control(
                'image_spacing',
                [
                    'label'     => esc_html__( 'Spacing', 'industrium_plugin' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'options'   => [
                        ''          => esc_html__( 'Default', 'industrium_plugin' ),
                        'custom'    => esc_html__( 'Custom', 'industrium_plugin' ),
                    ],
                    'default'   => '',
                    'condition' => [
                        'slides_to_show!' => '1',
                    ],
                ]
            );
            $element->add_control(
                'image_spacing_custom',
                [
                    'label'                 => esc_html__( 'Image Spacing', 'industrium_plugin' ),
                    'type'                  => \Elementor\Controls_Manager::SLIDER,
                    'range'                 => [
                        'px'                    => [
                            'max'                   => 100,
                        ],
                    ],
                    'default'               => [
                        'size'                  => 20,
                    ],
                    'show_label'            => false,
                    'condition'             => [
                        'image_spacing'         => 'custom',
                        'slides_to_show!'       => '1',
                    ],
                    'frontend_available'    => true,
                    'render_type'           => 'none',
                    'separator'             => 'after',
                    'selectors'             => [
                        '{{WRAPPER}} .elementor-image-carousel-wrapper' => 'margin: -{{SIZE}}px; padding: {{SIZE}}px !important;'
                    ],
                ]
            );

            $element->add_control(
                'icon_color',
                [
                    'label'     => esc_html__('Icon Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-slide a:after' => 'color: {{VALUE}};'
                    ],
                    'separator' => 'before',
                    'condition' => [
                        'link_to'   => ['file', 'custom']
                    ]
                ]
            );

            $element->add_control(
                'icon_bg_color',
                [
                    'label'     => esc_html__('Icon Background Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-slide a:after' => 'background-color: {{VALUE}};'
                    ],
                    'condition' => [
                        'link_to'   => ['file', 'custom']
                    ]
                ]
            );

            $element->add_control(
                'overlay_color',
                [
                    'label'     => esc_html__('Image Overlay Color', 'industrium_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-slide a:before' => 'background-color: {{VALUE}};'
                    ],
                    'condition' => [
                        'link_to'       => ['file', 'custom'],
                        'view_style'    => 'style_2'
                    ]
                ]
            );


            $element->start_controls_tabs('frame_settings_tabs');

                // ------------------------ //
                // ------ Normal Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'frame_normal',
                    [
                        'label'     => esc_html__('Normal', 'industrium_plugin'),
                        'condition' => [
                            'link_to'    => ['file', 'custom'],
                            'view_style' => 'style_2'
                        ]
                    ]
                );

                    $element->add_control(
                        'frame_color',
                        [
                            'label'     => esc_html__('Frame Color', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .swiper-slide a:before' => 'border-color: {{VALUE}};'
                            ],
                            'condition' => [
                                'link_to'    => ['file', 'custom'],
                                'view_style' => 'style_2'
                            ]
                        ]
                    );

                $element->end_controls_tab();

                // ------------------------ //
                // ------ Active Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'frame_hover',
                    [
                        'label'     => esc_html__('Hover', 'industrium_plugin'),
                        'condition' => [
                            'link_to'    => ['file', 'custom'],
                            'view_style' => 'style_2'
                        ]
                    ]
                );

                    $element->add_control(
                        'frame_color_hover',
                        [
                            'label'     => esc_html__('Frame Color on Hover', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .swiper-slide a:hover:before' => 'border-color: {{VALUE}};'
                            ],
                            'condition' => [
                                'link_to'    => ['file', 'custom'],
                                'view_style' => 'style_2'
                            ]
                        ]
                    );

                $element->end_controls_tab();

            $element->end_controls_tabs();
        }

        if ('accordion' === $element->get_name() && 'section_title_style' === $section_id) {
            $element->remove_control('border_width');
            $element->remove_control('border_color');

            $element->add_responsive_control(
                'space_between',
                [
                    'label'     => esc_html__( 'Space Between', 'industrium_plugin' ),
                    'type'      => \Elementor\Controls_Manager::SLIDER,
                    'range'     => [
                        'px'        => [
                            'min'       => 0,
                            'max'       => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-accordion-item:not(:last-of-type)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );
            $element->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'box_shadow',
                    'selector'  => '{{WRAPPER}} .elementor-accordion-item',
                ]
            );
        }

        if ('accordion' === $element->get_name() && 'section_toggle_style_title' === $section_id) {
            $element->remove_control('title_background');
            $element->remove_control('title_color');
            $element->remove_control('tab_active_color');

            $element->start_controls_tabs('title_colors_tabs');

                // ------------------------ //
                // ------ Normal Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'title_colors_normal',
                    [
                        'label' => esc_html__('Normal', 'industrium_plugin')
                    ]
                );

                    $element->add_control(
                        'title_color',
                        [
                            'label'     => esc_html__('Title Color', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title:not(.elementor-active) .elementor-accordion-title' => 'color: {{VALUE}};'
                            ]
                        ]
                    );

                    $element->add_control(
                        'title_bg_color',
                        [
                            'label'     => esc_html__('Title Background Color', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title:not(.elementor-active)' => 'background-color: {{VALUE}};'
                            ]
                        ]
                    );

                $element->end_controls_tab();

                // ------------------------ //
                // ------ Active Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'title_colors_active',
                    [
                        'label' => esc_html__('Active', 'industrium_plugin')
                    ]
                );

                    $element->add_control(
                        'active_title_color',
                        [
                            'label'     => esc_html__('Title Color', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title.elementor-active .elementor-accordion-title' => 'color: {{VALUE}};'
                            ]
                        ]
                    );

                    $element->add_control(
                        'active_title_bg_color',
                        [
                            'label'     => esc_html__('Title Background Color', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title.elementor-active' => 'background-color: {{VALUE}};'
                            ]
                        ]
                    );

                $element->end_controls_tab();

            $element->end_controls_tabs();
        }

        if ('toggle' === $element->get_name() && 'section_toggle_style' === $section_id) {
            $element->remove_control('border_width');
            $element->remove_control('border_color');
        }

        if ('toggle' === $element->get_name() && 'section_toggle_style_title' === $section_id) {
            $element->remove_control('title_background');
            $element->remove_control('title_color');
            $element->remove_control('tab_active_color');

            $element->start_controls_tabs('title_colors_tabs');

                // ------------------------ //
                // ------ Normal Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'title_colors_normal',
                    [
                        'label' => esc_html__('Normal', 'industrium_plugin')
                    ]
                );

                    $element->add_control(
                        'title_color',
                        [
                            'label'     => esc_html__('Title Color', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title:not(.elementor-active) .elementor-toggle-title' => 'color: {{VALUE}};'
                            ]
                        ]
                    );

                    $element->add_control(
                        'title_bg_color',
                        [
                            'label'     => esc_html__('Title Background Color', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title:not(.elementor-active)' => 'background-color: {{VALUE}};'
                            ]
                        ]
                    );

                $element->end_controls_tab();

                // ------------------------ //
                // ------ Active Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'title_colors_active',
                    [
                        'label' => esc_html__('Active', 'industrium_plugin')
                    ]
                );

                    $element->add_control(
                        'active_title_color',
                        [
                            'label'     => esc_html__('Title Color', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title.elementor-active .elementor-toggle-title' => 'color: {{VALUE}};'
                            ]
                        ]
                    );

                    $element->add_control(
                        'active_title_bg_color',
                        [
                            'label'     => esc_html__('Title Background Color', 'industrium_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title.elementor-active' => 'background-color: {{VALUE}};'
                            ]
                        ]
                    );

                $element->end_controls_tab();

            $element->end_controls_tabs();
        }

    }, 10, 3);

    add_action('elementor/widget/render_content', function( $content, $widget ) {
        if ( 'image' === $widget->get_name() ) {
            $settings = $widget->get_settings();
            if ($settings['link_to'] !== 'none' && $settings['hovered_caption'] == 'yes' && $settings['hovered_caption_text'] !== '') {
                $content = str_replace('</a>', '<span class="hovered-caption">' . $settings['hovered_caption_text'] . '</span></a>', $content);
            }
            if($settings['image_badge'] === 'yes' && $settings['image_badge_text'] !== '') {
                $content = str_replace('<div class="elementor-image">', '<div class="elementor-image"><span class="elementor-image-badge">' . $settings['image_badge_text'] . '</span>', $content);
            }
        }

        return $content;
    }, 10, 2 );

    add_action('elementor/widget/render_content', function( $content, $widget ) {
        if ( 'video' === $widget->get_name() ) {
            $content = str_replace('<i class="eicon-play" aria-hidden="true"></i>', '<svg aria-hidden="true" class="progress" width="70" height="70" viewBox="0 0 70 70"><path class="progress__circle" d="m35,2.5c17.955803,0 32.5,14.544199 32.5,32.5c0,17.955803 -14.544197,32.5 -32.5,32.5c-17.955803,0 -32.5,-14.544197 -32.5,-32.5c0,-17.955801 14.544197,-32.5 32.5,-32.5z"></path><path class="progress__path" d="m35,2.5c17.955803,0 32.5,14.544199 32.5,32.5c0,17.955803 -14.544197,32.5 -32.5,32.5c-17.955803,0 -32.5,-14.544197 -32.5,-32.5c0,-17.955801 14.544197,-32.5 32.5,-32.5z" pathLength="1"></path></svg>', $content);
        }

        return $content;
    }, 10, 2 );

    add_action('elementor/frontend/section/before_render', function( \Elementor\Element_Base $element ) {
        $settings = $element->get_settings();
        if ( $settings['use_parallax'] == 'yes' ) {
            $element->add_render_attribute('_wrapper', [
                'data-parallax'     => 'scroll'
            ] );
        }
    } );
    
    add_action('elementor/widget/render_content', function( $content, $widget ) {
        if ( 'google_maps' === $widget->get_name() ) {
            $content = str_replace(' frameborder="0"', '', $content);
            $content = str_replace(' scrolling="no"', '', $content);
            $content = str_replace(' marginheight="0"', '', $content);
            $content = str_replace(' marginwidth="0"', '', $content);
        }

        return $content;
    }, 10, 2 );
}