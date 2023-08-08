<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Industrium
 * @since Industrium 1.0
 */

get_header();

$sidebar_args = industrium_get_sidebar_args();
$sidebar_position = $sidebar_args['sidebar_position'];

$content_classes = 'content-wrapper';
$content_classes .= ( industrium_get_post_option('content_top_margin') == 'on' ? ' content-wrapper-remove-top-margin' : '' );
$content_classes .= ( industrium_get_post_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );
$content_classes .= ' content-wrapper-sidebar-position-' . esc_attr($sidebar_position);

$columns_number = industrium_get_theme_mod('portfolio_archive_columns_number');
$posts_per_page = industrium_get_theme_mod('portfolio_archive_posts_per_page');
$paged          = get_query_var('paged') ? get_query_var('paged') : 1;

$query = new WP_Query( [
    'post_type'             => 'industrium_portfolio',
    'columns_number'        => $columns_number,
    'posts_per_page'        => $posts_per_page,
    'paged'                 => $paged
] );
?>

    <div class="<?php echo esc_attr($content_classes); ?>">
        <div class="content">
            <!-- Content Container -->
            <div class="content-inner">

                <div class="archive-listing">
                    <div class="archive-listing-wrapper portfolio-listing-wrapper portfolio-grid-listing<?php echo ( isset($columns_number) && !empty($columns_number) ? ' columns-' . esc_attr($columns_number) : '' ); ?>">
                        <?php
                            while( $query->have_posts() ){
                                $query->the_post();
                                get_template_part('content', 'industrium_portfolio');
                            };
                            wp_reset_postdata();
                        ?>
                    </div>

                    <div class="content-pagination">
                    <?php
                        echo get_the_posts_pagination(array(
                            'current'   => $paged,
                            'total'     => $query->max_num_pages,
                            'end_size'  => 2,
                            'prev_text' => '<div class="button-icon"></div>',
                            'next_text' => '<div class="button-icon"></div>'
                        ));
                    ?>
                    </div>
                </div>

            </div>
        </div>

        <!-- Sidebar Container -->
        <?php get_sidebar(); ?>

    </div>

<?php
get_footer();