<?php
/**
 * The template for displaying single project item page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Industrium
 * @since Industrium 1.0
 */

the_post();
get_header();

$sidebar_args = industrium_get_sidebar_args();
$sidebar_position = $sidebar_args['sidebar_position'];

$content_classes = 'content-wrapper';
$content_classes .= ' content-wrapper-sidebar-position-' . esc_attr($sidebar_position);
$content_classes .= ( industrium_get_post_option('content_top_margin') == 'on' ? ' content-wrapper-remove-top-margin' : '' );

$additional_classes = 'content-wrapper content-wrapper-sidebar-position-none';
$content = apply_filters('the_content', get_the_content());
if ( empty($content) ) {
    $content_classes .= ( industrium_get_post_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );
} else {
    $additional_classes .= ( industrium_get_post_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );
};
?>

    <div class="<?php echo esc_attr($content_classes); ?>">

        <!-- Content Container -->
        <div class="content">

            <div id="service-<?php the_ID(); ?>" class="single-service">

                <div class="service-post-content">

                    <?php
                        if ( !empty(industrium_post_media_output()) ) {
                            echo '<div class="post-media-wrapper">';
                                echo industrium_post_media_output();
                            echo '</div>';
                        }

                        if ( !empty(get_the_title()) ) {
                            echo '<h2 class="post-title">' . get_the_title() . '</h2>';
                        }

                        if ( !empty(industrium_get_post_option('service_description')) ) {
                            echo do_shortcode( wpautop( rwmb_meta('service_description') ) );;
                        }

                        // FAQ
                        if (!empty(industrium_get_post_option('service_help_items'))) {
                            if ( !empty(industrium_get_post_option('service_help_title')) ) {
                                echo '<h4>' . esc_html(industrium_get_post_option('service_help_title')) . '</h4>';
                            }
                            echo '<div class="help-wrapper">';
                                $helps = industrium_get_post_option('service_help_items');
                                foreach ($helps as $help) {
                                    echo '<div class="help-item">';
                                        if ( !empty($help[0]) ) {
                                            echo '<div class="help-item-title">';
                                                echo esc_html($help[0]);
                                            echo '</div>';
                                        }
                                    if ( !empty($help[1]) ) {
                                        echo '<div class="help-item-content">';
                                            echo esc_html($help[1]);
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                }
                            echo '</div>';
                        }

                    ?>

                </div>
            </div>

        </div>

        <!-- Sidebar Container -->
        <?php get_sidebar(); ?>

    </div>

    <?php
        if ( !empty($content) ) {
            echo '<div class="' . esc_attr($additional_classes) . '">';
                echo '<div class="content">';
        }
        the_content();
        if ( !empty($content) ) {
                echo '</div>';
            echo '</div>';
        }
    ?>

<?php
get_footer();