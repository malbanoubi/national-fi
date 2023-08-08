<?php
    defined( 'ABSPATH' ) or die();
?>

    <div class="mobile-header-row">

        <!-- Logo Block -->
        <?php
            if ( industrium_get_prefered_option('header_logo_status') == 'on' ) {
                echo '<div class="logo-container">' . industrium_get_logo_output(true) . '</div>';
            }
        ?>

        <!-- Icons Block -->
        <?php
            if (
                industrium_get_prefered_option('header_search_status') == 'on' ||
                industrium_get_prefered_option('header_menu_status') == 'on' ||
                (
                    industrium_get_prefered_option('side_panel_status') == 'on' &&
                    is_active_sidebar('sidebar-side')
                ) ||
                (
                    class_exists('WooCommerce') && industrium_get_prefered_option('header_minicart_status') == 'on'
                ) ||
                industrium_get_prefered_option('header_login_status') == 'on'
            ) {
                echo '<div class="header-icons-container">';

                    // Mini Cart Link
                    if ( class_exists('WooCommerce') && industrium_get_prefered_option('header_minicart_status') == 'on' ) {
                        echo '<div class="header-icon mini-cart">';
                            echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="mini-cart-trigger">';
                                echo '<i class="mini-cart-count">';
                                    echo '<span></span>';
                                echo '</i>';
                            echo '</a>';
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

                    // Search Icon Trigger
                    if ( industrium_get_prefered_option('header_search_status') == 'on' ) {
                        echo '<div class="header-icon search-trigger">';
                            echo '<span class="search-trigger-icon"></span>';
                        echo '</div>';
                    }

                    // Side Panel Trigger
                    if ( industrium_get_prefered_option('side_panel_status') == 'on' && is_active_sidebar('sidebar-side') ) {
                        echo '<div class="header-icon dropdown-trigger">';
                            echo '<div class="dropdown-trigger-item"></div>';
                        echo '</div>';
                    }

                    // Burger Menu Trigger
                    if ( industrium_get_prefered_option('header_menu_status') == 'on' ) { ?>
                        <div class="header-icon menu-trigger">
                            <span class="menu-trigger-icon">
                                <span class="hamburger">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                            </span>
                        </div>
                    <?php }

                echo '</div>';
            }
        ?>

    </div>