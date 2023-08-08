<?php
    defined( 'ABSPATH' ) or die();

    $slide_sidebar_classes = 'slide-sidebar-wrapper slide-sidebar-position-left';

    $header_classes = 'header';
    if ( !empty(industrium_get_prefered_option('header_style')) ) {
        $header_classes .= ' header-' . esc_attr(industrium_get_prefered_option('header_style'));
    }
    if ( !empty(industrium_get_prefered_option('header_position')) ) {
        $header_classes .= ' header-position-' . esc_attr(industrium_get_prefered_option('header_position'));
    }
    if ( !empty(industrium_get_prefered_option('sticky_header_status')) ) {
        $header_classes .= ' sticky-header-' . esc_attr(industrium_get_prefered_option('sticky_header_status'));
    }

    $mobile_classes = 'mobile-header';
    if ( !empty(industrium_get_prefered_option('header_position')) ) {
        $mobile_classes .= ' mobile-header-position-' . esc_attr(industrium_get_prefered_option('header_position'));
    }
    if ( !empty(industrium_get_prefered_option('sticky_header_status')) ) {
        $mobile_classes .= ' sticky-header-' . esc_attr(industrium_get_prefered_option('sticky_header_status'));
    }
    if ( !empty(industrium_get_prefered_option('header_style')) ) {
        $mobile_classes .= ' mobile-header-' . esc_attr(industrium_get_prefered_option('header_style'));
    }

    $sticky_header_classes = 'header sticky-header';
    if ( !empty(industrium_get_prefered_option('header_style')) ) {
        $sticky_header_classes .= ' header-' . esc_attr(industrium_get_prefered_option('header_style'));
    }
    $mobile_sticky_header_classes = 'mobile-header sticky-header';
    if ( !empty(industrium_get_prefered_option('header_style')) ) {
        $mobile_sticky_header_classes .= ' mobile-header-' . esc_attr(industrium_get_prefered_option('header_style'));
    }
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php wp_head(); ?>
    </head>

    <!-- Body -->
    <body <?php body_class(); ?>>
        <?php if ( function_exists( 'wp_body_open' ) ) {
                wp_body_open();
        } ?>
        <div class="body-overlay"></div>

        <?php if ( industrium_get_prefered_option('page_loader_status') == 'on' ) { ?>
            <!-- Page Pre Loader -->
            <div class="page-loader-container">
                <div class="page-loader">
                    <div class="page-loader-inner">
                        <?php
                            if ( !empty(industrium_get_prefered_option('page_loader_image')) ) {
                                $loader_image_metadata = wp_get_attachment_metadata(attachment_url_to_postid(industrium_get_prefered_option('page_loader_image')));
                                $loader_image_width = (isset($loader_image_metadata['width']) ? $loader_image_metadata['width'] : 0);
                                $loader_image_height = (isset($loader_image_metadata['height']) ? $loader_image_metadata['height'] : 0);
                                $loader_image_url = industrium_get_theme_mod('page_loader_image');

                                echo '<img width="' . esc_attr($loader_image_width) . '" height="' . esc_attr($loader_image_height) . '" src="' . esc_url($loader_image_url) . '" alt="' . esc_attr__('Page Loader Image', 'industrium') . '"  class="page-loader-logo" />';
                            } else {
                                $preloader_src = get_template_directory_uri() . '/img/preloader.png';
                                echo '<img width="58" height="90" src="' . esc_url($preloader_src) . '" alt="' . esc_attr__('Page Loader Image', 'industrium') . '"  class="page-loader-logo" />';
                            }
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ( industrium_get_prefered_option('header_search_status') == 'on' ) { ?>
            <!-- Search Panel -->
            <div class="site-search">
                <div class="site-search-close"></div>
                <?php
                    $search_args = array(
                        'echo'          => true,
                        'aria_label'    => 'global'
                    );
                    get_search_form($search_args);
                ?>
            </div>
        <?php } ?>

        <!-- Mobile Menu Panel -->
        <?php
            get_template_part( 'templates/header/header-mobile-aside' );
        ?>

        <!-- Top Bar -->
        <?php
            if ( industrium_get_prefered_option('top_bar_status') == 'on' ) {
                get_template_part( 'templates/top-bar/top-bar' );
            }
        ?>

        <div class="body-container">

            <?php
            if ( industrium_get_prefered_option('side_panel_status') == 'on' && 
                (is_active_sidebar('sidebar-side') ) || industrium_get_prefered_option('sidebar_logo_status') == 'on') { ?>
                <!-- Side Panel -->
                <div class="<?php echo esc_attr($slide_sidebar_classes); ?>">
                    <div class="slide-sidebar">
                        <div class="slide-sidebar-close"></div>
                        <div class="slide-sidebar-content">
                            <?php 
                                if ( industrium_get_prefered_option('sidebar_logo_status') == 'on' ) {
                                    // Side Panel Logo
                                    echo '<div class="sidebar-logo-container">' . industrium_get_sidebar_logo_output() . '</div>';
                                }
                            ?>
                            <?php dynamic_sidebar('sidebar-side'); ?>
                        </div>
                    </div>
                </div>
            <?php
            } ?>

            <!-- Mobile Sticky Header -->
            <?php
            if(industrium_get_prefered_option('sticky_header_status') == 'on') {
                echo '<div class="' . esc_attr($mobile_sticky_header_classes) . '">';
                    get_template_part( 'templates/header/header-mobile' );
                echo '</div>';
            } ?>

            <!-- Mobile Header -->
            <?php
            echo '<div class="' . esc_attr($mobile_classes) . '">';
                get_template_part( 'templates/header/header-mobile' );
            echo '</div>';
            ?>

            <?php
            if ( industrium_get_prefered_option('header_status') == 'on' ) {
                if(industrium_get_prefered_option('sticky_header_status') == 'on') { ?>
                    <!-- Sticky Header -->
                    <?php echo '<header class="' . esc_attr($sticky_header_classes) . '">';
                        switch (industrium_get_prefered_option('header_style')) {                            
                            case 'type-2' :
                                get_template_part('templates/header/header-2');
                                break;
                            case 'type-1' :
                            case 'type-3' :
                                get_template_part('templates/header/header-1');
                                break;
                            default :
                                get_template_part('templates/header/header-1');
                                break;
                        }
                    ?>
                    <?php echo '</header>'; 
                } ?> 
                <!-- Header -->
                <?php
                echo '<header class="' . esc_attr($header_classes) . '">';
                    switch (industrium_get_prefered_option('header_style')) {
                        case 'type-2' :
                            get_template_part('templates/header/header-2');
                            break;
                        case 'type-3' :
                            get_template_part('templates/header/header-3');
                            break;
                        default :
                            get_template_part('templates/header/header-1');
                            break;
                    }
                echo '</header>';
            }
            ?>

            <?php
            // Page Title
            if (industrium_get_prefered_option('page_title_status') == 'on') {
                get_template_part( 'templates/page-title/page-title' );
            }
            ?>