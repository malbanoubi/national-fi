<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Industrium
 * @since Industrium 1.0
 */

get_header();

$content_classes = 'content-wrapper content-wrapper-sidebar-position-none';
?>

    <div class="<?php echo esc_attr($content_classes); ?>">
        <div class="content">
            <!-- Content Container -->
            <div class="content-inner">

                <div class="archive-listing">
                    <div class="archive-listing-wrapper">
                        <?php
                        if (have_posts()) {
                            while (have_posts()) : the_post();
                                get_template_part('content', 'search');
                            endwhile;
                        } else {
                            ?>
                            <h2 class="industrium-no-results-title"><?php esc_html_e('Oops! Nothing Found!', 'industrium'); ?></h2>

                            <div class="industrium-no-result-search-form">
                                <?php
                                    $search_args = array(
                                        'echo'          => true,
                                        'aria_label'    => 'page'
                                    );
                                    get_search_form($search_args);
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="content-pagination">
                        <?php
                            echo get_the_posts_pagination(array(
                                'end_size'  => 2,
                                'prev_text' => '<div class="button-icon"></div>',
                                'next_text' => '<div class="button-icon"></div>'
                            ));
                        ?>
                    </div>
                </div>

            </div>
        </div>



    </div>

<?php
get_footer();