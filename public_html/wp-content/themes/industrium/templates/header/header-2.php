<?php
    defined( 'ABSPATH' ) or die();
?>

<div class="header-row">

    <!-- Left Info Block -->
    <?php
        if (
            industrium_get_prefered_option('header_logo_status') == 'on'
        ) {
            echo '<div class="header-icons-container">';
                // Header Logo
                echo '<div class="logo-container">' . industrium_get_logo_output() . '</div>';
            echo '</div>';
        }
    ?>

    <!-- Menu Block -->
    <?php
        if ( industrium_get_prefered_option('header_menu_status') == 'on' ) {
            $menu_class = 'main-menu menu-' . (!empty(industrium_get_prefered_option('header_menu_dots')) ? industrium_get_prefered_option('header_menu_dots') : '');
            if ( !empty(industrium_get_prefered_option('header_menu_select')) && industrium_get_prefered_option('header_menu_select') != 'default' ) {
                wp_nav_menu(
                    array(
                        'menu'              => industrium_get_prefered_option('header_menu_select'),
                        'menu_class'        => $menu_class,
                        'depth'             => '0',
                        'container'         => 'div',
                        'container_class'   => 'header-menu-container',
                        'fallback_cb'       => '',
                        'items_wrap'        => '<nav><ul id="%1$s" class="%2$s">%3$s</ul></nav>'
                    )
                );
            } else {
                $menu_locations = get_nav_menu_locations();
                if ( isset($menu_locations['main']) && $menu_locations['main'] !== 0 ) {
                    wp_nav_menu(
                        array(
                            'theme_location'    => 'main',
                            'menu_class'        => $menu_class,
                            'depth'             => '0',
                            'container'         => 'div',
                            'container_class'   => 'header-menu-container',
                            'fallback_cb'       => '',
                            'items_wrap'        => '<nav><ul id="%1$s" class="%2$s">%3$s</ul></nav>'
                        )
                    );
                }
            }
        }
    ?>
    <!-- Header Callback Block -->
    <?php
        if(industrium_get_prefered_option('header_callback_status') == 'on' &&
        (
            !empty(industrium_get_prefered_option('header_callback_text')) ||
            !empty(industrium_get_prefered_option('header_callback_title'))
        )) {
            echo '<div class="header-icons-container header-callback-container">';
                echo '<div class="header-icon callback">';
                    if ( !empty(industrium_get_prefered_option('header_callback_title')) ) {
                        echo '<div class="callback-title">';
                            echo esc_html(industrium_get_prefered_option('header_callback_title'));
                        echo '</div>';
                    }
                    if ( !empty(industrium_get_prefered_option('header_callback_text')) ) {
                        echo '<div class="callback-text">';
                            if(!empty(industrium_get_prefered_option('header_callback_link'))) {
                                echo '<a href="' . esc_url(industrium_get_prefered_option('header_callback_link')) . '">';
                            }
                            echo esc_html(industrium_get_prefered_option('header_callback_text'));
                            if(!empty(industrium_get_prefered_option('header_callback_link'))) {
                                echo '</a>';
                            }
                        echo '</div>';
                    }
                echo '</div>';
            echo '</div>';
        }
    ?>
    <!-- Right Info Block -->
    <?php
        if (
            industrium_get_prefered_option('header_search_status') == 'on' ||
            (
                industrium_get_prefered_option('header_button_status') == 'on' &&
                !empty(industrium_get_prefered_option('header_button_text'))
            ) ||
            (
                class_exists('WooCommerce') && industrium_get_prefered_option('header_minicart_status') == 'on'
            ) ||
            industrium_get_prefered_option('header_login_status') == 'on' ||
            (
                industrium_get_prefered_option('side_panel_status') == 'on' &&
                is_active_sidebar('sidebar-side')
            )
        ) {
            echo '<div class="header-icons-container icons-container-big">';

                // Header Search
                if ( industrium_get_prefered_option('header_search_status') == 'on' ) {
                    echo '<div class="header-icon search-trigger">';
                        echo '<span class="search-trigger-icon"></span>';
                    echo '</div>';
                }

                // Header Product Cart
                if ( class_exists('WooCommerce') && industrium_get_prefered_option('header_minicart_status') == 'on' ) {
                    echo '<div class="header-icon mini-cart">';
                        echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="mini-cart-trigger">';
                            echo '<i class="mini-cart-count">';
                                if ( WC()->cart->cart_contents_count > 0 ) {
                                    echo '<span>' . WC()->cart->cart_contents_count . '</span>';
                                }
                            echo '</i>';
                        echo '</a>';
                        echo '<div class="mini-cart-panel woocommerce">';
                            woocommerce_mini_cart();
                        echo '</div>';
                    echo '</div>';
                }

                // Login/Logout
                if ( industrium_get_prefered_option('header_login_status') == 'on' ) {
                    if ( class_exists('WooCommerce') ) {
                        echo '<div class="header-icon login-logout">';
                        if (is_user_logged_in()) {
                            echo '<a href="' . wp_logout_url(home_url()) . '" title="' . esc_attr__('Logout', 'industrium') . '" class="link-logout"></a>';
                        } else {
                            echo '<a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '" title="' . esc_attr__('Login/Register', 'industrium') . '" class="link-login"></a>';
                        };
                        echo '</div>';
                    } else {
                        echo '<div class="header-icon login-logout">';
                        if (is_user_logged_in()) {
                            echo '<a href="' . wp_logout_url(home_url()) . '" title="' . esc_attr__('Logout', 'industrium') . '" class="link-logout"></a>';
                        } else {
                            echo '<a href="' . wp_login_url(get_permalink()) . '" title="' . esc_attr__('Login/Register', 'industrium') . '" class="link-login"></a>';
                        };
                        echo '</div>';
                    }
                }

                // Header Button
                if ( industrium_get_prefered_option('header_button_status') == 'on' && !empty(industrium_get_prefered_option('header_button_text')) ) {
                    echo '<div class="header-icon header-button-container">';
                        echo '<a class="industrium-button" href="' . ( !empty(industrium_get_prefered_option('header_button_url')) ? esc_url(industrium_get_prefered_option('header_button_url')) : esc_js('javascript:void(0);')) . '">';
                            echo esc_html(industrium_get_prefered_option('header_button_text'));
                        echo '</a>';
                    echo '</div>';
                }

                // Header Side Panel
                if ( industrium_get_prefered_option('side_panel_status') == 'on' && is_active_sidebar('sidebar-side') ) {
                    echo '<div class="header-icon dropdown-trigger">';
                        echo '<div class="dropdown-trigger-item"></div>';
                    echo '</div>';
                }

            echo '</div>';
        }
    ?>

</div>