<div <?php post_class('vacancy-item-wrapper'); ?>>
    <div class="vacancy-item">

        <?php
            if ( !empty(industrium_get_post_option('vacancy_occupation')) || !empty(industrium_get_post_option('vacancy_location')) || !empty(get_the_title()) ) {
                echo '<div class="vacancy-item-header">';
                    if (!empty(industrium_get_post_option('vacancy_occupation')) || !empty(industrium_get_post_option('vacancy_location'))) {
                        echo '<div class="vacancy-post-meta">';
                        if (!empty(industrium_get_post_option('vacancy_occupation'))) {
                            echo '<div class="vacancy-post-meta-item vacancy-occupation">';
                                echo esc_html(industrium_get_post_option('vacancy_occupation'));
                            echo '</div>';
                        }
                        if (!empty(industrium_get_post_option('vacancy_location'))) {
                            echo '<div class="vacancy-post-meta-item vacancy-city">';
                                echo esc_html(industrium_get_post_option('vacancy_location'));
                            echo '</div>';
                        }
                        echo '</div>';
                    }

                    if (!empty(get_the_title())) {
                        echo '<h6 class="vacancy-post-title">' . get_the_title() . '</h6>';
                    }
                echo '</div>';
            }
        ?>

        <div class="vacancy-item-excerpt">
            <?php
                $excerpt_length = industrium_get_theme_mod('vacancy_archive_excerpt_length');
                echo substr(get_the_excerpt(), 0, $excerpt_length);
            ?>
        </div>

        <?php
            if ( !empty(industrium_get_post_option('vacancy_salary')) ) {
                echo '<div class="vacancy-item-salary">';
                    echo '<div class="vacancy-salary">';
                        echo '<div class="vacancy-salary-label">' . esc_html__('Salary', 'industrium') . '</div>';
                        echo '<div class="vacancy-salary-value">' . esc_html(industrium_get_post_option('vacancy_salary')) . '</div>';
                    echo '</div>';
                echo '</div>';
            }
        ?>

        <div class="vacancy-item-button">
            <?php
                echo '<a href="' . esc_url(get_the_permalink()) . '" class="industrium-button">';
                    esc_html_e('More Details', 'industrium');
                    echo '<svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5"></polyline></svg>';
                echo '</a>';
            ?>
        </div>
    </div>
</div>