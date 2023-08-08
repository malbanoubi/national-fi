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
?>

    <div class="<?php echo esc_attr($content_classes); ?>">

        <!-- Content Container -->
        <div class="content">

            <div id="project-<?php the_ID(); ?>" class="single-project">

                <?php if ( !empty(industrium_media_gallery_output('project_gallery')) ) {
                    echo '<div class="project-post-gallery">';
                        echo industrium_media_gallery_output('project_gallery');
                    echo '</div>';
                ?>

                <div class="project-post-content">
                    <?php
                        if ( !empty(get_the_title()) ) {
                            echo '<h2 class="project-post-title">' . get_the_title() . '</h2>';
                        }
                    }
                    ?>

                    <?php the_content(); ?>

                    <div class="project-post-meta-wrapper">
                        <div class="project-post-meta">
                            <?php
                                if ( !empty(industrium_get_post_option('project_strategy')) ) {
                                    echo '<div class="project-post-meta-item">';
                                        echo '<div class="project-post-meta-label">' . esc_html__('Strategy', 'industrium') . '</div>';
                                        $strategy_list = industrium_get_post_option('project_strategy');
                                        echo wp_kses( implode(', <br>', $strategy_list ), array('br' => array()) );
                                    echo '</div>';
                                }
                                if ( !empty(industrium_get_post_option('project_design')) ) {
                                    echo '<div class="project-post-meta-item">';
                                        echo '<div class="project-post-meta-label">' . esc_html__('Design', 'industrium') . '</div>';
                                        $design_list = industrium_get_post_option('project_design');
                                        echo wp_kses( implode(', <br>', $design_list ), array('br' => array()) );
                                    echo '</div>';
                                }
                                if ( !empty(industrium_get_post_option('project_client')) ) {
                                    echo '<div class="project-post-meta-item">';
                                        echo '<div class="project-post-meta-label">' . esc_html__('Client', 'industrium') . '</div>';
                                        echo esc_html(industrium_get_post_option('project_client'));
                                    echo '</div>';
                                }
                            ?>
                        </div>
                    </div>
                    <?php
                        if ( !empty(industrium_get_post_option('project_button')) ) {
                            $button = industrium_get_post_option('project_button');
                            echo '<div class="project-post-button">';
                                echo '<a href="' . esc_url( $button[0] ) . '" class="industrium-button">' . esc_html( $button[1] ) . '<svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5"></polyline></svg></a>';
                            echo '</div>';
                        }
                    ?>

                </div>
            </div>

            <?php
                $args = array(
                    'prev_label'            => !empty(industrium_get_theme_mod('project_single_page_prev_button')) ? industrium_get_theme_mod('project_single_page_prev_button') : esc_html__('Prev projects', 'industrium'),
                    'next_label'            => !empty(industrium_get_theme_mod('project_single_page_next_button')) ? industrium_get_theme_mod('project_single_page_next_button') : esc_html__('Next projects', 'industrium'),
                    'taxonomy_name'         => 'industrium_project_category',
                    'taxonomy_separator'    => ' / '
                );
                echo industrium_post_navigation($args);
            ?>

        </div>

        <!-- Sidebar Container -->
        <?php get_sidebar(); ?>

    </div>

<?php
get_footer();