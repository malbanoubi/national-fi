<?php
    $columns_number = !empty($args['columns_number']) ? $args['columns_number'] : industrium_get_theme_mod('project_archive_columns_number');
    $item_class     = !empty($args['item_class']) ? $args['item_class'] : 'project-item-wrapper';
    $text_position  = !empty($args['text_position']) ? $args['text_position'] : 'outside';
    $show_categories = isset($args['show_categories']) ? $args['show_categories'] : '';
    $show_excerpt   = isset($args['show_excerpt']) ? $args['show_excerpt'] : 'yes';
    $excerpt_length = !empty($args['excerpt_length']) ? $args['excerpt_length'] : 71;
    $show_read_more = isset($args['show_read_more']) ? $args['show_read_more'] : 'yes';
	$read_more_text = !empty($args['read_more_text']) ? $args['read_more_text'] : esc_html__('Read More', 'industrium');
    $listing_type = !empty($args['listing_type']) ? $args['listing_type'] : 'grid';
    $view_type = !empty($args['view_type']) ? $args['view_type'] : '';
    $slide_count = !empty($args['slide_count']) ? $args['slide_count'] : 0;
?>

<div <?php post_class($item_class); echo (($listing_type == 'slider' && $view_type == 'type-2') ? industrium_project_slider_media_output() : '') ?>>
    <div class="project-item">
        <a href="<?php the_permalink(); ?>" class="project-item-link">
            <?php
                if($listing_type != 'slider' || ($listing_type == 'slider' && $view_type == 'type-1')) {
                    echo '<span class="project-item-media">';
                        echo industrium_project_grid_media_output(null, $columns_number, $listing_type);
                    echo '</span>';
                }               
                if($listing_type == 'slider' && $view_type == 'type-2') {
                    echo '<span class="project-item-media">';
                        echo industrium_project_grid_media_output(null, $columns_number, $listing_type, $view_type);
                    echo '</span>';
                }
                if ( $text_position == 'inside' || $listing_type == 'slider') {
                    echo '<span class="project-item-content">';
                        if($listing_type == 'slider' && $view_type == 'type-2' && !empty($slide_count)) {
                            echo '<span class="slide-counter-big">' . ($slide_count < 10 ? '0' : '') . esc_html($slide_count) . '</span>';
                        }
                        if ( !empty(get_the_title()) ) {
                            echo '<span class="post-title"><span>' . get_the_title() . '</span></span>';
                        }
                        if ( $show_categories == 'yes' && !empty(industrium_taxonomy_output('industrium_project_category')) ) {
                            echo '<span class="project-item-categories">';
                                echo industrium_taxonomy_output('industrium_project_category', '', false);
                            echo '</span>';
                        }
                        if ( $show_excerpt == 'yes' ) {
                        	echo '<span class="project-item-excerpt">';
	                            echo substr(get_the_excerpt(), 0, $excerpt_length);
	                        echo '</span>';
                        }
                        if ($listing_type != 'slider') {
                        	if ( $show_read_more == 'yes' && !empty($read_more_text) ) {
			                    echo '<div class="post-more-button">';
			                        echo '<span class="industrium-button">';
			                            echo esc_html($read_more_text);
			                            echo '<svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5" /></svg>';
			                        echo '</span>';
			                    echo '</div>';
			                }
                        }                 
                        if($listing_type == 'slider' && $view_type == 'type-1') {
                            echo '<span class="project-item-button"></span>';
                        }
                    echo '</span>';
                    if($listing_type == 'slider' && $view_type == 'type-2') {
                        echo '<span class="project-item-content-alt">';
                            echo '<span class="project-item-button"></span>';
                            if(!empty($slide_count)) {
                                echo '<span class="slide-counter-big">' . ($slide_count < 10 ? '0' : '') . esc_html($slide_count) . '</span>';               
                            }                            
                        echo '</span>';
                        echo '<span class="button-container">';
                            echo '<span class="industrium-button">' . esc_html__('More about project', 'industrium') . '</span>';
                        echo "</span>";
                    }
                }
            ?>
        </a>
        <?php
            if ( $text_position == 'outside' && ($listing_type == 'grid' || $listing_type == 'masonry')) {
                echo '<div class="project-item-content">';
                    if (!empty(get_the_title())) {
                        echo '<div class="post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></div>';
                    }
                    if ( $show_categories == 'yes' && !empty(industrium_taxonomy_output('industrium_project_category')) ) {
                        echo '<div class="project-item-categories">';
                            echo industrium_taxonomy_output('industrium_project_category', '', true);
                        echo '</div>';
                    }
                    if ( $show_excerpt == 'yes' ) {
                    	echo '<div class="project-item-excerpt">';
	                        echo substr(get_the_excerpt(), 0, $excerpt_length);
	                    echo '</div>';
                    }
                    if ( $show_read_more == 'yes' && !empty($read_more_text) ) {
	                    echo '<div class="post-more-button">';
	                        echo '<a href="' . esc_url(get_the_permalink()) . '" class="industrium-button">';
	                            echo esc_html($read_more_text);
	                            echo '<svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5" /></svg>';
	                        echo '</a>';
	                    echo '</div>';
	                }         
                echo '</div>';
            }
        ?>
    </div>
</div>