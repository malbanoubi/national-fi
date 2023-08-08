<?php
$show_cat       = ( isset($args['show_cat']) ? $args['show_cat'] : 'yes' );
$show_media     = ( isset($args['show_media']) ? $args['show_media'] : 'yes' );
$show_author    = ( isset($args['show_author']) ? $args['show_author'] : 'yes' );
$show_date      = ( isset($args['show_date']) ? $args['show_date'] : 'yes' );
$show_name      = ( isset($args['show_name']) ? $args['show_name'] : 'yes' );
$show_tags      = ( isset($args['show_tags']) ? $args['show_tags'] : 'yes' );
$show_excerpt   = ( isset($args['show_excerpt']) ? $args['show_excerpt'] : 'yes' );
$show_read_more = ( isset($args['show_read_more']) ? $args['show_read_more'] : 'yes' );
$read_more_text = ( isset($args['read_more_text']) ? $args['read_more_text'] : esc_html__('See Case Study', 'industrium') );
$item_class     = 'grid-item grid-blog-item-wrapper' . ( isset($args['item_class']) ? ' ' . $args['item_class'] : '' );
$excerpt_length = ( isset($args['excerpt_length']) && !empty($args['excerpt_length']) ? $args['excerpt_length'] : industrium_get_theme_mod('case_studies_archive_excerpt_length') );
$columns_number = ( isset($args['columns_number']) && !empty($args['columns_number']) ? $args['columns_number'] : industrium_get_theme_mod('case_studies_archive_columns_number') );
$listing_type = (!empty($args['listing_type']) ? $args['listing_type'] : 'grid');
?>

<div <?php post_class($item_class); ?>>
    <div class="blog-item">
        <?php
            if ( $show_media == 'yes' && !empty(industrium_post_media_output()) ) {
                echo '<div class="post-media-wrapper">';
                    echo industrium_post_media_output(true, $columns_number, true);
                echo '</div>';
            }

            if (
                ( $show_date == 'yes' && !empty(industrium_post_date_output()) ) ||
                ( $show_author == 'yes' && !empty(industrium_post_author_output()) )
            ) {
                echo '<div class="post-meta-header">';
                    if ( $show_date == 'yes' && !empty(industrium_post_date_output()) ) {
                        echo industrium_post_date_output(true, $listing_type);
                    }
                    if ( $show_author == 'yes' && !empty(industrium_post_author_output()) ) {
                        echo industrium_post_author_output(true);
                    }
                echo '</div>';
            }

            if ( $show_cat == 'yes' && !empty(industrium_case_studies_categories_output()) ) {
                echo '<div class="post-labels">';
                    echo industrium_case_studies_categories_output(true);
                echo '</div>';
            }

            if ( $show_name == 'yes' && !empty(get_the_title()) ) {
                $header_tag = ( $columns_number > 2 ? 'h5' : 'h4' );
                echo '<' . esc_html($header_tag) . ' class="post-title"><a href="' . esc_url(get_the_permalink()) . '">' . get_the_title() . '</a></' . esc_html($header_tag) . '>';
            }

            if ( $show_excerpt == 'yes' ) {
                echo '<div class="post-content">';
                    if (!empty($excerpt_length)) {
                        echo substr(get_the_excerpt(), 0, $excerpt_length);
                    } else {
                        the_excerpt();
                    }
                echo '</div>';
            }

            if ( $show_tags == 'yes' && !empty(industrium_case_studies_tags_output()) ) {
                echo industrium_case_studies_tags_output(', ');
            }

            if ( $show_read_more == 'yes' && !empty($read_more_text) ) {
                echo '<div class="post-more-button">';
                    echo '<a class="industrium-button" href="' . esc_url(get_the_permalink()) . '">';
                        echo '<span>' . esc_html($read_more_text) . '</span>';
                        echo '<svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5" /></svg>';
                    echo '</a>';
                echo '</div>';
            }
        ?>
    </div>
</div>