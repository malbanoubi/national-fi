<?php
    defined( 'ABSPATH' ) or die();

    if ( is_home() ) {
    	global $post;
        $page_for_posts = get_option( 'page_for_posts' );
        $post = get_post($page_for_posts);
        $page_title = esc_html__('Home', 'industrium');
    } elseif ( class_exists('WooCommerce') && is_product() ) {
        $page_title = sprintf(stripslashes(industrium_get_theme_mod('woo_single_product_title')), get_the_title());
    } elseif ( class_exists('WooCommerce') && is_product_category()  ) {
        $page_title = sprintf(stripslashes(industrium_get_theme_mod('woo_product_categories_title')), single_term_title('', false));
    } elseif ( class_exists('WooCommerce') && is_product_tag() ) {
        $page_title = sprintf(stripslashes(industrium_get_theme_mod('woo_product_tags_title')), single_term_title('', false));
    } elseif ( class_exists('WooCommerce') && is_search() ) {
        $page_title = sprintf(esc_html__('Search Results By "%s"', 'industrium'), get_search_query());
    } elseif (is_archive()) {
        if ( class_exists('WooCommerce') && is_woocommerce() ) {
            $page_title = get_the_title();
        } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'industrium_portfolio') {
            $page_title = sprintf(esc_html(industrium_get_theme_mod('portfolio_archive_page_title')), post_type_archive_title('', false));
        } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'industrium_project') {
            $page_title = sprintf(esc_html(industrium_get_theme_mod('project_archive_page_title')), post_type_archive_title('', false));
        } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'industrium_case') {
            $page_title = sprintf(esc_html(industrium_get_theme_mod('case_studies_archive_page_title')), post_type_archive_title('', false));
        } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'industrium_team') {
            $page_title = sprintf(esc_html(industrium_get_theme_mod('team_archive_page_title')), post_type_archive_title('', false));
        } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'industrium_vacancy') {
            $page_title = sprintf(esc_html(industrium_get_theme_mod('vacancy_archive_page_title')), post_type_archive_title('', false));
        } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'industrium_service') {
            $page_title = sprintf(esc_html(industrium_get_theme_mod('service_archive_page_title')), post_type_archive_title('', false));
        } else {
            $page_title = get_the_archive_title();
        }
    } elseif (is_search()) {
        $page_title = sprintf(esc_html__('Search Results By "%s"', 'industrium'), get_search_query());
    } elseif (is_singular('industrium_portfolio')) {
        $page_title = sprintf(stripslashes(industrium_get_theme_mod('portfolio_single_page_title')), get_the_title());
    } elseif (is_singular('industrium_project')) {
        $page_title = sprintf(stripslashes(industrium_get_theme_mod('project_single_page_title')), get_the_title());
    } elseif (is_singular('industrium_case')) {
        $page_title = sprintf(stripslashes(industrium_get_theme_mod('case_studies_single_page_title')), get_the_title());
    } elseif (is_singular('industrium_team')) {
        $page_title = sprintf(stripslashes(industrium_get_theme_mod('team_single_page_title')), get_the_title());
    } elseif (is_singular('industrium_vacancy')) {
        $page_title = sprintf(stripslashes(industrium_get_theme_mod('vacancy_single_page_title')), get_the_title());
    } elseif (is_singular('industrium_service')) {
        $page_title = sprintf(stripslashes(industrium_get_theme_mod('service_single_page_title')), get_the_title());
    } elseif (is_single()) {
        $page_title = sprintf(stripslashes(industrium_get_theme_mod('post_page_title')), get_the_title());
    } else {
        $page_title = get_the_title();
    }
    $breadcrumbs_status = industrium_get_prefered_option('page_title_breadcrumbs_status');
    $page_title_classes = industrium_get_prefered_option('page_title_decoration_status') == 'on' ? 'page-title-decorated' : '';
?>

<!-- Page Title -->

<div class="page-title-container <?php echo esc_attr($page_title_classes);?>">
    <div class="page-title-bg"></div>
    <div class="page-title-row">
        <div class="page-title-wrapper">
            <div class="page-title-box">
                <?php
                    if ( industrium_get_prefered_option('page_title_heading_customize') == 'on' && industrium_get_prepared_option('page_title_heading_icon_status', '', 'page_title_heading_customize') == 'on') {
                        echo industrium_get_page_title_image_output();
                    }
                ?>
                <h1 class="page-title"><?php echo sprintf('%s', $page_title); ?></h1>
            </div>
            <?php
                if ( $breadcrumbs_status == 'on' ) {
                    industrium_breadcrumbs();
                }
            ?>
        </div>
    </div>
</div>