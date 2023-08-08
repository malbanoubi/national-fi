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

    <div class="error-404-container">

        <div class="error-404-header">
            <!-- Logo Block -->
            <?php
                if ( industrium_get_prefered_option('error_logo_status') == 'on' ) {
                    echo '<div class="logo-container">' . industrium_get_error_logo_output() . '</div>';
                }
            ?>
        </div>

        <?php
            if ( !empty(industrium_get_theme_mod('error_main_image')) ) {
                echo '<img src="' . esc_url(industrium_get_theme_mod('error_main_image')) . '" alt="' . esc_attr__('404', 'industrium') . '" class="error-404-image tilt-effect">';
            }
        ?>

        <div class="error-404-inner">
            <div class="error-404-content">
                <?php
                    if ( !empty(industrium_get_theme_mod('error_title')) ) {
                        echo '<h1 class="error-404-title">' . wp_kses(industrium_get_theme_mod('error_title'), array('br' => array())) . '</h1>';
                    }
                    if ( !empty(industrium_get_theme_mod('error_text')) ) {
                        echo '<p class="error-404-info-text">' . esc_html(industrium_get_theme_mod('error_text')) . '</p>';
                    }
                    if (industrium_get_theme_mod('error_button_status') == 'on' && !empty(industrium_get_theme_mod('error_button_text')) ) {
                        echo '<div class="error-404-button">';
                            echo '<a class="error-404-home-button industrium-button" href="' . esc_url(home_url('/')) . '">' . esc_html(industrium_get_theme_mod('error_button_text')) . '<svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5"></polyline></svg></a>';
                        echo '</div>';
                    }
                    if (industrium_get_theme_mod('error_socials_status') == 'on' && !empty(industrium_socials_output())) {
                        echo industrium_socials_output('wrapper-socials');
                    }
                ?>
            </div>
        </div>

    </div>

<?php
    wp_footer();
?>
</body>
</html>