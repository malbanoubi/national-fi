<?php
    defined( 'ABSPATH' ) or die();
?>
    <div class="mobile-header-menu-container">
        <div class="mobile-header-row">

            <!-- Icons Block -->
            <div class="header-icons-container">
                <?php
                // Mini Cart Link
                if ( class_exists('WooCommerce') && industrium_get_prefered_option('header_minicart_status') == 'on' ) {
                    echo '<div class="header-icon mini-cart">';
                        echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="mini-cart-trigger">';
                            echo '<i class="mini-cart-count">';
                                if ( WC()->cart->cart_contents_count > 0 ) {
                                    echo '<span>' . WC()->cart->cart_contents_count . '</span>';
                                }
                            echo '</i>';
                        echo '</a>';
                    echo '</div>';
                }
                // Search Icon Trigger
                if ( industrium_get_prefered_option('header_search_status') == 'on' ) {
                    echo '<div class="header-icon search-trigger">';
                        echo '<span class="search-trigger-icon"></span>';
                    echo '</div>';
                }
                // Close Button
                echo '<div class="header-icon menu-close">';
                    echo '<span class="menu-close-icon"></span>';
                echo '</div>';

                ?>
            </div>

        </div>
        <!-- Menu Block -->
        <?php
            if ( industrium_get_prefered_option('header_menu_status') == 'on' ) {
                if ( !empty(industrium_get_prefered_option('header_menu_select')) && industrium_get_prefered_option('header_menu_select') != 'default' ) {
                    wp_nav_menu(
                        array(
                            'menu'          => industrium_get_prefered_option('header_menu_select'),
                            'menu_class'    => 'main-menu',
                            'depth'         => '0',
                            'container'     => '',
                            'fallback_cb'   => '',
                            'items_wrap'    => '<nav><ul id="%1$s" class="%2$s">%3$s</ul></nav>'
                        )
                    );
                } else {
                    $menu_locations = get_nav_menu_locations();
                    if ( isset($menu_locations['main']) && $menu_locations['main'] !== 0 ) {
                        wp_nav_menu(
                            array(
                                'theme_location'    => 'main',
                                'menu_class'        => 'main-menu',
                                'depth'             => '0',
                                'container'         => '',
                                'fallback_cb'       => '',
                                'items_wrap'        => '<nav><ul id="%1$s" class="%2$s">%3$s</ul></nav>'
                            )
                        );
                    }
                }
            }
        ?>

        <?php
        if (
            industrium_get_prefered_option('top_bar_status') == 'on' &&
            (
                industrium_get_prefered_option('top_bar_contacts_email_status') == 'on' ||
                industrium_get_prefered_option('top_bar_contacts_phone_status') == 'on' ||
                industrium_get_prefered_option('top_bar_contacts_address_status') == 'on'
            )
        ) {
            echo '<div class="header-mobile-contacts">';
                if ( !empty(industrium_get_prefered_option('top_bar_contacts_address')) && industrium_get_prefered_option('top_bar_contacts_address_status') == 'on' ) {
                    echo '<div class="contact-item contact-item-address">';
                        echo '<p class="contact-item-title">' . esc_html__('Location', 'industrium') . '</p>';
                        echo esc_html(industrium_get_prefered_option('top_bar_contacts_address'));
                    echo '</div>';
                }
                if ( !empty(industrium_get_prefered_option('top_bar_contacts_phone')) && industrium_get_prefered_option('top_bar_contacts_phone_status') == 'on' ) {
                    echo '<div class="contact-item contact-item-phone">';
                        echo '<p class="contact-item-title">' . esc_html__('Phone', 'industrium') . '</p>';
                        echo '<a href="tel:' . industrium_clear_phone(industrium_get_prefered_option('top_bar_contacts_phone')) . '">';
                            echo esc_html(industrium_get_prefered_option('top_bar_contacts_phone'));
                        echo '</a>';
                    echo '</div>';
                }
                if ( !empty(industrium_get_prefered_option('top_bar_contacts_email')) && industrium_get_prefered_option('top_bar_contacts_email_status') == 'on' ) {
                    echo '<div class="contact-item contact-item-email">';
                        echo '<p class="contact-item-title">' . esc_html__('Email', 'industrium') . '</p>';
                        echo '<a href="mailto:' . esc_attr(industrium_get_prefered_option('top_bar_contacts_email')) . '">';
                            echo esc_html(industrium_get_prefered_option('top_bar_contacts_email'));
                        echo '</a>';
                    echo '</div>';
                }
            echo '</div>';
        }
        ?>

        <?php
        if (
            industrium_get_prefered_option('top_bar_status') == 'on' &&
            industrium_get_prefered_option('top_bar_additional_text_status') == 'on' &&
            (
                !empty(industrium_get_prefered_option('top_bar_additional_text_status')) ||
                !empty(industrium_get_prefered_option('top_bar_additional_text'))
            )
        ) {
            echo '<div class="header-mobile-additional-text">';
                if ( !empty(industrium_get_prefered_option('top_bar_additional_text_title')) ) {
                    echo '<span class="additional-text-title">';
                        echo wp_kses(industrium_get_prefered_option('top_bar_additional_text_title'), array(
                            'mark' => array(),
                            'span' => array(
                                'class' => true
                            )
                        ));
                    echo '</span>';
                }
                if ( !empty(industrium_get_prefered_option('top_bar_additional_text')) ) {
                    echo wp_kses(industrium_get_prefered_option('top_bar_additional_text'), array(
                        'mark' => array(),
                        'span' => array(
                            'class' => true
                        )
                    ));
                }
            echo '</div>';
        }
        ?>

        <?php
        if (
            industrium_get_prefered_option('top_bar_status') == 'on' &&
            industrium_get_prefered_option('top_bar_socials_status') == 'on'
        ) {
            echo '<div class="header-mobile-socials">';
                echo industrium_socials_output('mobile-menu-socials wrapper-socials');
            echo '</div>';
        }
        ?>

        <?php
        if (
            industrium_get_prefered_option('header_callback_status') == 'on' &&
            (
                !empty(industrium_get_prefered_option('header_callback_text')) ||
                !empty(industrium_get_prefered_option('header_callback_title'))
            )
        ) {
            echo '<div class="callback">';
                if ( !empty(industrium_get_prefered_option('header_callback_title')) ) {
                    echo '<div class="callback-title">';
                        echo esc_html(industrium_get_prefered_option('header_callback_title'));
                    echo '</div>';
                }
                if ( !empty(industrium_get_prefered_option('header_callback_text')) ) {
                    echo '<div class="callback-text">';
                        echo esc_html(industrium_get_prefered_option('header_callback_text'));
                    echo '</div>';
                }
            echo '</div>';
        }
        ?>

        <?php
        if (
            industrium_get_prefered_option('header_button_status') == 'on' &&
            !empty(industrium_get_prefered_option('header_button_text'))
        ) {
            echo '<div class="header-mobile-button">';
                echo '<a class="industrium-button" href="' . ( !empty(industrium_get_prefered_option('header_button_url')) ? esc_url(industrium_get_prefered_option('header_button_url')) : esc_js('javascript:void(0);')) . '">';
                    echo esc_html(industrium_get_prefered_option('header_button_text'));
                    echo '<svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5"></polyline></svg>';
                echo '</a>';
            echo '</div>';
        }
        ?>

    </div>