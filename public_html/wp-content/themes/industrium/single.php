<?php
/**
 * The template for displaying single gallery post
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
$content_classes .= ( industrium_get_post_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );

$post_format = get_post_format();
$post_classes = 'single-post' . ( $post_format == 'quote' && industrium_post_options() && !empty(industrium_get_post_option('post_media_quote_text')) ? '  industrium-format-quote' : '' );
?>

    <div class="<?php echo esc_attr($content_classes); ?>">

        <!-- Content Container -->
        <div class="content">

            <div id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>

                <?php
                    if (
                        industrium_get_prefered_option('post_media_image_status') == 'on' &&
                        !empty(industrium_post_media_output())
                    ) {
                        echo '<div class="post-media-wrapper">';
                            echo industrium_post_media_output();
                        echo '</div>';
                    }                    

                    if (
                        industrium_get_prefered_option('post_date_status') == 'on' &&
                        !empty(industrium_post_date_output())
                    ) {
                        echo '<div class="post-meta-header">';
                            if ( industrium_get_prefered_option('post_date_status') == 'on' && !empty(industrium_post_date_output()) ) {
                                echo industrium_post_date_output(true);
                            }
                        echo '</div>';
                    }

                    if (
                        industrium_get_prefered_option('post_category_status') == 'on' &&
                        !empty(industrium_post_categories_output())
                    ) {
                        echo '<div class="post-labels">';
                            echo industrium_post_categories_output(true);
                        echo '</div>';
                    }
                ?>

                <?php
                    if ( industrium_get_prefered_option('post_title_status') == 'on' && !empty(get_the_title()) ) {
                        echo '<h2 class="post-title">' . get_the_title() . '</h2>';
                    }
                ?>

                <div class="post-content">
                    <?php the_content(); ?>
                </div>

                <?php
                    wp_link_pages(
                        array(
                            'before' => '<div class="content-pagination"><nav class="pagination"><div class="nav-links">',
                            'after' => '</div></nav></div>'
                        )
                    );
                ?>

                <?php
                    if (
                        ( industrium_get_prefered_option('post_tags_status') == 'on' && !empty(industrium_post_tags_output()) ) ||
                        ( industrium_get_prefered_option('post_socials_status') == 'on' && !empty(industrium_socials_output()) ) ||
                        ( industrium_get_prefered_option('post_author_status') == 'on' && !empty(industrium_post_author_output()) )
                    ) {
                        echo '<div class="post-meta-footer">';
                            if ( industrium_get_prefered_option('post_author_status') == 'on' && !empty(industrium_post_author_output()) ) {
                                echo industrium_post_author_output(true);
                            }
                            if ( industrium_get_prefered_option('post_tags_status') == 'on' && !empty(industrium_post_tags_output()) ) {
                                echo industrium_post_tags_output();
                            }
                            if ( industrium_get_prefered_option('post_socials_status') == 'on' && !empty(industrium_socials_output()) ) {
                                echo '<div class="post-meta-item post-meta-item-socials">';
                                    echo industrium_socials_output('wrapper-socials');
                                echo '</div>';
                            }
                        echo '</div>';
                    }
                ?>

                <?php
                    comments_template();
                ?>

                <?php
                    if (industrium_get_prefered_option('recent_posts_status') == 'on') {
                        industrium_recent_posts_output(
                            array(
                                'orderby'               => industrium_get_prefered_option('recent_posts_order_by'),
                                'numberposts'           => industrium_get_prefered_option('recent_posts_number'),
                                'post_type'             => get_post_type(),
                                'order'                 => industrium_get_prefered_option('recent_posts_order'),
                                'show_media'            => industrium_get_prefered_option('recent_posts_image'),
                                'show_category'         => industrium_get_prefered_option('recent_posts_category'),
                                'show_title'            => industrium_get_prefered_option('recent_posts_title'),
                                'show_date'             => industrium_get_prefered_option('recent_posts_date'),
                                'show_author'           => industrium_get_prefered_option('recent_posts_author'),
                                'show_excerpt'          => industrium_get_prefered_option('recent_posts_excerpt'),
                                'excerpt_length'        => industrium_get_prefered_option('recent_posts_excerpt_length'),
                                'show_tags'             => industrium_get_prefered_option('recent_posts_tags'),
                                'show_more'             => industrium_get_prefered_option('recent_posts_more')
                            )
                        );
                    }
                ?>

            </div>

        </div>

        <!-- Sidebar Container -->
        <?php get_sidebar(); ?>

    </div>

<?php
get_footer();