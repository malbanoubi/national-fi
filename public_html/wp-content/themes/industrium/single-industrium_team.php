<?php
/**
 * The template for displaying single team member item page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Industrium
 * @since Industrium 1.0
 */

the_post();
get_header();

$content_classes = 'content-wrapper content-wrapper-sidebar-position-none';
$content_classes .= ( industrium_get_post_option('content_top_margin') == 'on' ? ' content-wrapper-remove-top-margin' : '' );
$content_classes .= ( industrium_get_post_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );
?>
    <div id="team-<?php the_ID(); ?>" class="single-team">

        <section>
            <div class="<?php echo esc_attr($content_classes); ?>">

                <!-- Content Container -->
                <div class="content">
                    <div class="team-short-info-wrapper">
                        <div class="team-short-info-text">
                            <?php
                                if ( !empty(get_the_title()) ) {
                                    echo '<div class="team-short-info-title special-title">';
                                        if ( !empty(industrium_get_post_option('team_member_position')) ) {
                                            echo '<div class="special-title-backward">' . esc_html(industrium_get_post_option('team_member_position')) . '</div>';
                                        }
                                        echo '<h2 class="team-special-title">' . get_the_title() . '</h2>';
                                    echo '</div>';
                                }                                

                                if ( !empty(industrium_get_post_option('team_member_short_text')) ) {
                                    echo '<div class="team-short-info-description">' . do_shortcode( wpautop( industrium_get_post_option('team_member_short_text') ) ) . '</div>';
                                }
                            ?>
                            <div class="team-short-contact-button">
                                <?php 
                                    $team_member_contacts_link = !empty(industrium_get_post_option('team_member_contacts_link')) ? industrium_get_post_option('team_member_contacts_link') : '#';
                                ?>
                                <a href="<?php echo esc_url($team_member_contacts_link); ?>" target="_blank" class="industrium-button js-scroll-to"><?php echo esc_html__('Contact Me', 'industrium'); ?><svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5"></polyline></svg></a>
                            </div>
                        </div>
                        <div class="team-short-info-media">
                            <?php
                                echo industrium_team_member_media_output();
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="section-accent-bg">
            <div class="<?php echo esc_attr($content_classes); ?>">
                <div class="content">
                    <div class="team-biography-wrapper">
                        <?php
                            if ( !empty(industrium_get_post_option('team_member_biography_title')) ) {
                                echo '<div class="team-biography-title special-title">';
                                    echo '<div class="special-title-backward">' . esc_html__('Biography', 'industrium') . '</div>';
                                    echo '<h2 class="team-special-title">' . esc_html(industrium_get_post_option('team_member_biography_title')) . '</h2>';
                                echo '</div>';
                            }

                            if ( !empty(industrium_get_post_option('team_member_biography_text')) ) {
                                echo '<div class="team-biography-text">' . do_shortcode( wpautop( industrium_get_post_option('team_member_biography_text') ) ) . '</div>';
                            }
                        ?>
                    </div>
                    <div class="team-data-wrapper">
                        <?php
                            if ( !empty(industrium_get_post_option('team_member_personal_info_title')) || !empty(industrium_get_post_option('team_member_personal_info_item')) || !empty(industrium_get_post_option('team_member_email')) || !empty(industrium_get_post_option('team_member_socials')) ) {
                                echo '<div class="team-personal-info">';
                                    if ( !empty(industrium_get_post_option('team_member_personal_info_title')) ) {
                                        echo '<h4>' . esc_html(industrium_get_post_option('team_member_personal_info_title')) . '</h4>';
                                    }
                                    if ( !empty(industrium_get_post_option('team_member_personal_info_item')) ) {
                                        $personal_info_items = industrium_get_post_option('team_member_personal_info_item');
                                        foreach ( $personal_info_items as $item ) {
                                            echo '<div class="team-personal-info-item">' . esc_html($item) . '</div>';
                                        }
                                    }
                                    if ( !empty(industrium_get_post_option('team_member_email')) ) {
                                        echo '<div class="team-personal-info-item team-personal-info-item-email"><a href="mailto:' . esc_attr(industrium_get_post_option('team_member_email')) . '">' . esc_html(industrium_get_post_option('team_member_email')) . '</a></div>';
                                    }
                                    if ( !empty(industrium_get_post_option('team_member_socials')) ) {
                                        $social_items = industrium_get_post_option('team_member_socials');
                                        echo '<ul class="team-socials wrapper-socials">';
                                        foreach ( $social_items as $item ) {
                                            echo '<li>';
                                                echo '<a href="' . esc_url($item[1]) . '" target="_blank" class="fab ' . esc_attr($item[0]) . '"></a>';
                                            echo '</li>';
                                        }
                                        echo '</ul>';
                                    }
                                echo '</div>';
                            }

                            if ( !empty(industrium_get_post_option('team_member_skills_title')) || !empty(industrium_get_post_option('team_member_skills_list')) ) {
                                echo '<div class="team-skills">';
                                    if ( !empty(industrium_get_post_option('team_member_skills_title')) ) {
                                        echo '<h4>' . esc_html(industrium_get_post_option('team_member_skills_title')) . '</h4>';
                                    }
                                    if ( !empty(industrium_get_post_option('team_member_skills_list')) ) {
                                        $skills_items = industrium_get_post_option('team_member_skills_list');
                                        echo '<ul>';
                                        foreach ( $skills_items as $item ) {
                                            echo '<li>' . esc_html($item) . '</li>';
                                        }
                                        echo '</ul>';
                                    }
                                echo '</div>';
                            }

                            if ( !empty(industrium_get_post_option('team_member_values_title')) || !empty(industrium_get_post_option('team_member_values_list')) ) {
                                echo '<div class="team-values">';
                                    if ( !empty(industrium_get_post_option('team_member_values_title')) ) {
                                        echo '<h4>' . esc_html(industrium_get_post_option('team_member_values_title')) . '</h4>';
                                    }
                                    if ( !empty(industrium_get_post_option('team_member_values_list')) ) {
                                        $values_items = industrium_get_post_option('team_member_values_list');
                                        echo '<ul>';
                                        foreach ( $values_items as $item ) {
                                            echo '<li>' . esc_html($item) . '</li>';
                                        }
                                        echo '</ul>';
                                    }
                                echo '</div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="<?php echo esc_attr($content_classes); ?>">
                <div class="content">
                    <div class="team-expirience">
                        <?php
                            if ( !empty(industrium_get_post_option('team_member_experience_title')) ) {
                                echo '<div class="team-biography-title special-title">';
                                    echo '<div class="special-title-backward">' . esc_html__('Find Out More', 'industrium') . '</div>';
                                    echo '<h2 class="team-special-title">' . wp_kses(industrium_get_post_option('team_member_experience_title'), 'post') . '</h2>';
                                echo '</div>';
                            }

                            if ( !empty(industrium_get_post_option('team_member_education_list')) || !empty(industrium_get_post_option('team_member_experience_list')) ) {
                                echo '<div class="team-expirience-wrapper">';
                                    if ( !empty(industrium_get_post_option('team_member_education_list')) ) {
                                        $education_items = industrium_get_post_option('team_member_education_list');
                                        echo '<div class="team-expirience-education">';
                                            echo '<h4>' . esc_html__('Education', 'industrium') . '</h4>';
                                            echo '<div class="team-experience-list">';
                                            foreach ( $education_items as $item ) {
                                                echo '<div class="team-experience-item">';
                                                    echo '<div class="team-experience-item-period">' . esc_html($item[1]) . '</div>';
                                                    echo '<div class="team-experience-item-title">' . esc_html($item[0]) . '</div>';
                                                    echo '<div class="team-experience-item-description">' . esc_html($item[2]) . '</div>';
                                                echo '</div>';
                                            }
                                            echo '</div>';
                                        echo '</div>';
                                    }
                                    if ( !empty(industrium_get_post_option('team_member_experience_list')) ) {
                                        $experience_items = industrium_get_post_option('team_member_experience_list');
                                        echo '<div class="team-expirience-professional">';
                                            echo '<h4>' . esc_html__('Professional Experience', 'industrium') . '</h4>';
                                            echo '<div class="team-experience-list">';
                                            foreach ( $experience_items as $item ) {
                                                echo '<div class="team-experience-item">';
                                                    echo '<div class="team-experience-item-period">' . esc_html($item[1]) . '</div>';
                                                    echo '<div class="team-experience-item-title">' . esc_html($item[0]) . '</div>';
                                                    echo '<div class="team-experience-item-description">' . esc_html($item[2]) . '</div>';
                                                echo '</div>';
                                            }
                                            echo '</div>';
                                        echo '</div>';
                                    }
                                echo '</div>';
                            }
                        ?>
                    </div>
                    <div class="team-additional-content-wrapper">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </section>

    </div>

<?php
get_footer();