<div <?php post_class('team-item-wrapper'); ?>>
    <div class="team-item">
            <?php
                echo '<div class="team-item-media">';
                    echo industrium_team_member_media_output(true);
                    if ( industrium_post_options() && !empty(industrium_get_post_option('team_member_socials')) ) {
                        echo '<div class="team-item-socials">';
                            echo '<i class="socials-trigger fontello icon-share"></i>';
                            $social_items = industrium_get_post_option('team_member_socials');
                            echo '<ul class="team-socials wrapper-socials">';
                            foreach ( $social_items as $item ) {
                                echo '<li>';
                                    echo '<a href="' . esc_url($item[1]) . '" target="_blank" class="fab ' . esc_attr($item[0]) . '"></a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                        echo '</div>';
                    }
                echo '</div>';

                echo '<a href="' . get_the_permalink() . '" class="team-item-link">';
                echo '<span class="team-item-content">';
                    if ( industrium_post_options() && !empty(industrium_get_post_option('team_member_position')) ) {
                        echo '<span class="team-item-position">';
                            echo esc_html(industrium_get_post_option('team_member_position'));
                        echo '</span>';
                    }
                    if ( !empty(get_the_title()) ) {
                        echo '<span class="post-title">' . get_the_title() . '</span>';
                    }                    
                echo '</span>';
                echo '</a>';
            ?>
    </div>
</div>