<?php
    $columns_number = !empty($args['columns_number']) ? $args['columns_number'] : industrium_get_theme_mod('portfolio_archive_columns_number');
    $item_class     = !empty($args['item_class']) ? $args['item_class'] : 'portfolio-item-wrapper';
    $listing_type   = !empty($args['listing_type']) ? $args['listing_type'] : 'grid';
    $view_type      = !empty($args['view_type']) ? $args['view_type'] : 'type-1';
?>

<div <?php post_class($item_class); ?>>
    <div class="portfolio-item">
        <a href="<?php the_permalink(); ?>" class="portfolio-item-link">
            <?php
                echo '<span class="portfolio-item-media">';
                    echo industrium_portfolio_grid_media_output(null, $columns_number, $listing_type);
                echo '</span>';
                if ( !empty(get_the_title()) ) {
                    echo '<span class="portfolio-item-content">';
                        if($listing_type == 'slider' && $view_type == 'type-2') {
                            echo '<span class="portfolio-item-content-container">';
                        }
                        echo '<span class="portfolio-item-content-inner">';
                            if($listing_type != 'slider') {
                                echo industrium_portfolio_categories_output();
                            }                            
                            echo '<span class="post-title">' . get_the_title() . '</span>';
                        echo '</span>';
                        if($listing_type == 'slider' && $view_type == 'type-2') {
                            echo '</span>';
                        }
                    echo '</span>';
                }
            ?>
        </a>
    </div>
</div>