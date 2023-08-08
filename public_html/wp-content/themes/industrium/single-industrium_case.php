<?php
/**
 * The template for displaying single case studies post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Industrium
 * @since Industrium 1.0
 */

the_post();
get_header();
$content_classes = 'content-wrapper';
$content_classes .= ' content-wrapper-sidebar-position-none';

$post_classes = 'single-post';
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
                                echo industrium_post_date_output(true, 'grid');
                            }
                        echo '</div>';
                    }

                    if (
                        industrium_get_prefered_option('post_category_status') == 'on' &&
                        !empty(industrium_case_studies_categories_output())
                    ) {
                        echo '<div class="post-labels">';
                            echo industrium_case_studies_categories_output(true);
                        echo '</div>';
                    }
                ?>

                <?php
                    if ( industrium_get_prefered_option('post_title_status') == 'on' && !empty(get_the_title()) ) {
                        echo '<h2 class="post-title">' . get_the_title() . '</h2>';
                    }
                ?>

                <div class="post-content">
                    <?php
                        the_content();
                        $result_box_direction = !empty(industrium_get_post_option('case_study_result')) && !empty(industrium_get_post_option('case_study_boxes')) ? 'vertical' : 'horizontal';
                        if ( !empty(industrium_get_post_option('case_study_result')) || !empty(industrium_get_post_option('case_study_boxes')) ) {
                            echo '<div class="case-studies-results">';
                                echo '<h4>' . esc_html__('Results', 'industrium') . '</h4>';
                                echo '<div class="results-wrapper">';
                                    if ( !empty(industrium_get_post_option('case_study_result')) ) {
                                        echo '<div class="results-content">';
                                            echo do_shortcode( wpautop( rwmb_meta('case_study_result') ) );
                                        echo '</div>';
                                    }
                                    if ( !empty(industrium_get_post_option('case_study_boxes')) ) {
                                        echo '<div class="results-boxes result-boxes-direction-' . esc_attr($result_box_direction) . '">';
                                            echo '<div class="result-boxes-decoration"></div>';
                                            $boxes = industrium_get_post_option('case_study_boxes');
                                            foreach ( $boxes as $box ) {
                                                echo '<div class="result-box">';
                                                    if ( !empty($box[0]) ) {
                                                        echo '<div class="result-box-value">' . esc_html($box[0]) . '</div>';
                                                    }
                                                    if ( !empty($box[1]) ) {
                                                        echo '<div class="result-box-title">' . esc_html($box[1]) . '</div>';
                                                    }
                                                echo '</div>';
                                            }
                                        echo '</div>';
                                    }
                                echo '</div>';
                            echo '</div>';
                        }
                    ?>
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
                        ( industrium_get_prefered_option('post_tags_status') == 'on' && !empty(industrium_case_studies_tags_output()) ) ||
                        ( industrium_get_prefered_option('post_socials_status') == 'on' && !empty(industrium_socials_output()) ) ||
                        ( industrium_get_prefered_option('post_author_status') == 'on' && !empty(industrium_post_author_output()) )
                    ) {
                        echo '<div class="post-meta-footer">';
                            if ( industrium_get_prefered_option('post_author_status') == 'on' && !empty(industrium_post_author_output()) ) {
                                echo industrium_post_author_output(true);
                            }
                            if ( industrium_get_prefered_option('post_tags_status') == 'on' && !empty(industrium_case_studies_tags_output()) ) {
                                echo industrium_case_studies_tags_output();
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

            </div>

        </div>

    </div>

<?php
get_footer();