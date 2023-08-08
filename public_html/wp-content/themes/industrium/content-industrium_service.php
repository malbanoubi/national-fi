<?php 
    $listing_type  = (!empty($args['listing_type']) ? $args['listing_type'] : 'grid');
    $view_type     = (!empty($args['view_type']) ? $args['view_type'] : '');
    $columns_number = (!empty($args['columns_number']) ? $args['columns_number'] : 3);
    $excerpt_length = (!empty($args['excerpt_length']) ? $args['excerpt_length'] : industrium_get_theme_mod('service_archive_excerpt_length'));
    $service_counter = (!empty($args['service_counter']) ? $args['service_counter'] : 1);
?>

<div <?php post_class('service-item-wrapper'); ?>>
    <div class="service-item">
         <?php
            if($listing_type === 'grid') {
                if (!empty(get_the_title()) || !empty(industrium_get_post_option('service_main_icon'))) {
                    echo '<div class="service-item-header">';
                        echo '<a href="' . esc_url(get_the_permalink()) . '" class="service-item-link">';                                               
                            if ( !empty(industrium_get_post_option('service_main_icon')) ) {
                                echo '<div class="service-item-icon">';
                                    echo '<div class="service-icon">';
                                        echo '<i class="' . esc_attr(industrium_get_post_option('service_main_icon')) . '"' . (!empty(industrium_get_post_option('service_main_icon_color')) ? ' style="color: ' . esc_attr(industrium_get_post_option('service_main_icon_color')) . '"' : '') . '></i>';
                                    echo '</div>';
                                echo '</div>';
                            }
                            if (!empty(get_the_title())) {
                                echo '<h5 class="service-post-title">' . get_the_title() . '</h5>';
                            } 
                        echo '</a>';
                    echo '</div>';
                }
                if ( !empty(industrium_get_post_option('service_description')) ) {
                    echo '<div class="service-item-excerpt">';
                        if ( has_excerpt() ) {
                            echo substr(get_the_excerpt(), 0, $excerpt_length);
                        } else {
                            echo substr(strip_tags(industrium_get_post_option('service_description')), 0, $excerpt_length);
                        }
                    echo '</div>';
                }
            } else {
                if($view_type === 'type-1' || $view_type === 'type-3' || $view_type === 'type-5') {
                    $attr = '';
                    if(!empty(industrium_get_post_option('service_slider_image_advanced'))) {
                        $bg_image_url = esc_url(industrium_get_prepared_img_url('service_slider_image_advanced'));
                    }
                    $style = '';
                    if(!empty($bg_image_url)) {
                        $style .= 'background-image: url(' . esc_url($bg_image_url) . ');';
                    }
                    if(!empty(industrium_get_post_option('service_slider_bg_color'))) {
                        $style .= 'background-color: ' . esc_attr(industrium_get_post_option('service_slider_bg_color')) . ';';
                    }
                    if(!empty(industrium_get_post_option('service_slider_item_color'))) {
                        $style .= 'color: ' . esc_attr(industrium_get_post_option('service_slider_item_color')) . ';';
                    }
                    echo '<a class="service-slider-item-link" href="' . esc_url(get_the_permalink()) . '" style="' . esc_attr($style) . '">';
                        echo '<div class="service-slider-link-inner">';
                        if($view_type !== 'type-5') {
                            if(!empty(industrium_get_post_option('service_subtitle'))) {
                                echo '<span class="service-item-subtitle">' . esc_html(industrium_get_post_option('service_subtitle')) . '</span>';
                            }
                        }
                        if ( !empty(industrium_get_post_option('service_main_icon')) ) {
                            echo '<div class="service-item-icon">';
                                echo '<div class="service-icon">';
                                    echo '<i class="' . esc_attr(industrium_get_post_option('service_main_icon')) . '"' . (!empty(industrium_get_post_option('service_main_icon_color')) ? ' style="color: ' . esc_attr(industrium_get_post_option('service_main_icon_color')) . '"' : '') . '></i>';
                                echo '</div>';
                            echo '</div>';
                        }
                        if($view_type === 'type-3' || $view_type === 'type-5') {
                            echo '<div class="service-slider-link-content">';
                            if($view_type === 'type-3') {
                                echo '<span class="service-item-number">' . ($service_counter < 10 ? '0' . $service_counter : $service_counter) . '</span>';
                            }                                
                            if (!empty(get_the_title())) {
                                echo '<h4 class="service-post-title"><span>' . get_the_title() . '</span></h4>';
                            }
                            if($view_type === 'type-5') {
                                if ( !empty(industrium_get_post_option('service_description')) ) {
                                    echo '<div class="service-item-excerpt">';
                                        if ( has_excerpt() ) {
                                            echo substr(get_the_excerpt(), 0, $excerpt_length);
                                        } else {
                                            echo substr(strip_tags(industrium_get_post_option('service_description')), 0, $excerpt_length);
                                        }
                                    echo '</div>';
                                }
                            }                            
                            echo '</div>';
                        } else {
                            if (!empty(get_the_title())) {
                                echo '<h3 class="service-post-title">' . get_the_title() . '</h3>';
                            }
                            echo '<i class="fontello icon-button_arrow service-item-button"></i>';
                            echo '<span class="service-item-number">' . ($service_counter < 10 ? '0' . $service_counter : $service_counter) . '</span>';
                        }                       
                        echo '</div>';
                    echo '</a>';
                } elseif ($view_type === 'type-2' || $view_type === 'type-4') {
                    echo '<a class="service-slider-item-link" href="' . esc_url(get_the_permalink()) . '">';
                        if(!empty(industrium_service_slider_media_output(null, $columns_number))) {
                            echo '<div class="service-item-media">';
                                echo industrium_service_slider_media_output(null, $columns_number);
                                if($view_type === 'type-4') {
                                    echo '<span class="service-item-number">' . ($service_counter < 10 ? '0' . $service_counter : $service_counter) . '</span>';
                                }
                            echo '</div>';
                        }
                        if($view_type === 'type-2') {
                            echo '<span class="service-item-number">' . ($service_counter < 10 ? '0' . $service_counter : $service_counter) . '</span>';
                        }
                        if($view_type === 'type-2') {
                            if (!empty(get_the_title()) || !empty(industrium_get_post_option('service_description'))) {
                                echo '<div class="service-item-content">';
                                if (!empty(get_the_title())) {
                                    echo '<h5 class="service-post-title">' . get_the_title() . '</h5>';
                                    if ( !empty(industrium_get_post_option('service_description')) ) {
                                        echo '<div class="service-item-excerpt">';
                                            if ( has_excerpt() ) {
                                                echo substr(get_the_excerpt(), 0, $excerpt_length);
                                            } else {
                                                echo substr(strip_tags(industrium_get_post_option('service_description')), 0, $excerpt_length);
                                            }
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';
                            }
                        }                       
                    echo '</a>';
                    if($view_type === 'type-4') {
                        if (!empty(get_the_title())) {
                            echo '<div class="service-item-content">';
                                echo '<h4 class="service-post-title"><a href="' . esc_url(get_the_permalink()) . '">' . get_the_title() . '</a></h4>';
                            echo '</div>';
                        }
                    }                    
                }          
            }
        ?>
    </div>
</div>