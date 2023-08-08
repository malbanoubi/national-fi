<?php
$post_format    = get_post_format();

$show_cat       = ( isset($args['show_cat']) ? $args['show_cat'] : 'yes' );
$show_media     = ( isset($args['show_media']) ? $args['show_media'] : 'yes' );
$show_author    = ( isset($args['show_author']) ? $args['show_author'] : 'no' );
$show_date      = ( isset($args['show_date']) ? $args['show_date'] : 'yes' );
$show_title     = ( isset($args['show_title']) ? $args['show_title'] : 'yes' );
$show_tags      = ( isset($args['show_tags']) ? $args['show_tags'] : 'yes' );
$show_excerpt   = ( isset($args['show_excerpt']) ? $args['show_excerpt'] : 'yes' );
$show_read_more = ( isset($args['show_read_more']) ? $args['show_read_more'] : 'yes' );
$read_more_text = ( isset($args['read_more_text']) ? $args['read_more_text'] : esc_html__('Read More', 'industrium') );
$item_class     = ( isset($args['item_class']) ? $args['item_class'] : '' );
$excerpt_length = ( isset($args['excerpt_length']) ? $args['excerpt_length'] : '' );
$columns_number = ( isset($args['columns_number']) ? $args['columns_number'] : 1 );
$listing_type  = ( isset($args['listing_type']) ? $args['listing_type'] : 'classic' );

$post_classes   = 'standard-blog-item-wrapper' . ( $post_format == 'quote' && industrium_post_options() && !empty(industrium_get_post_option('post_media_quote_text')) ? ' industrium-format-quote' : '' ) . ( !empty($item_class) ? ' ' . esc_attr($item_class) : '' );
?>

<div <?php post_class($post_classes); ?>>
    <div class="blog-item">
        <?php
            if ( $show_media == 'yes' && !empty(industrium_post_media_output()) ) {
                echo '<div class="post-media-wrapper">';
                    echo industrium_post_media_output(true, $columns_number);
                echo '</div>';
            }            

            if ( !($post_format == 'quote' && industrium_post_options() && !empty(industrium_get_post_option('post_media_quote_text'))) ) {
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

                if ( $show_cat == 'yes' && !empty(industrium_post_categories_output()) ) {
                    echo '<div class="post-labels">';
                        echo industrium_post_categories_output(true);
                    echo '</div>';
                }

                if ( $show_title == 'yes' && !empty(get_the_title()) ) {
                    $header_tag = 'h2';
                    switch ($columns_number) {
                        case 2:
                            $header_tag = 'h3';
                            break;
                        case 3:
                            $header_tag = 'h4';
                            break;
                        case 4:
                        case 5:
                        case 6:
                            $header_tag = 'h5';
                            break;
                        default:
                            $header_tag = 'h2';
                            break;
                    }
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

                if ( $show_tags == 'yes' && !empty(industrium_post_tags_output()) ) {
                    echo industrium_post_tags_output(', ');
                }

                if ( $show_read_more == 'yes' && !empty($read_more_text) ) {
                    echo '<div class="post-more-button">';
                        echo '<a href="' . esc_url(get_the_permalink()) . '" class="industrium-button">';
                            echo esc_html($read_more_text);
                            echo '<svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5" /></svg>';
                        echo '</a>';
                    echo '</div>';
                }
            }
        ?>
    </div>
</div>