<?php
/*
 * Created by Artureanec
*/

if (!class_exists('Industrium_Banner_Widget')) {
    class Industrium_Banner_Widget extends WP_Widget {
        public function __construct() {
            parent::__construct(
                'Industrium_Banner_Widget',
                'Banner (Industrium Theme)',
                array(
                    'description' => esc_html__('Banner Widget by Industrium Theme', 'industrium_plugin'),
                    'mime_type'   => 'image'
                )
            );
        }

        public function update($new_instance, $old_instance) {
            $instance = $old_instance;

            $instance['title'] = sanitize_text_field($new_instance['title']);

            $instance['banner_title']   = sanitize_text_field($new_instance['banner_title']);
            $instance['banner_text']    = sanitize_text_field($new_instance['banner_text']);
            $instance['button_text']    = sanitize_text_field($new_instance['button_text']);
            $instance['button_link']    = sanitize_text_field($new_instance['button_link']);
            $instance['bg']             = strip_tags( $new_instance['bg'] );
            $instance['colors']         = sanitize_text_field( $new_instance['colors'] );

            return $instance;
        }

        public function form($instance) {
            $instance     = wp_parse_args( (array) $instance, array( 'title' => '' ) );

            $banner_title   = !empty( $instance['banner_title'] ) ? $instance['banner_title'] : '';
            $banner_text    = !empty( $instance['banner_text'] ) ? $instance['banner_text'] : '';
            $button_text    = !empty( $instance['button_text'] ) ? $instance['button_text'] : '';
            $button_link    = !empty( $instance['button_link'] ) ? $instance['button_link'] : '#';
            $bg             = isset($instance['bg']) && !empty( $instance['bg'] ) ? $instance['bg'] : '';
            $colors         = !empty( $instance['colors'] ) ? $instance['colors'] : 'default';
            ?>
            <div class="media-widget-control">
                <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'industrium_plugin' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'banner_title' ); ?>"><?php esc_html_e( 'Banner Title:', 'industrium_plugin' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'banner_title' ); ?>" name="<?php echo $this->get_field_name( 'banner_title' ); ?>" type="text" value="<?php echo esc_attr( $banner_title ); ?>" />
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'banner_text' ); ?>"><?php esc_html_e( 'Banner Text:', 'industrium_plugin' ); ?></label>
                    <textarea rows="3" class="widefat textarea widget_textarea_control" name="<?php echo $this->get_field_name( 'banner_text' ); ?>" id="<?php echo esc_attr( $this->get_field_id('banner_text') ) ?>"><?php echo esc_html($banner_text) ?></textarea>
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php esc_html_e( 'Button Text:', 'industrium_plugin' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" />
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'button_link' ); ?>"><?php esc_html_e( 'Button Link:', 'industrium_plugin' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'button_link' ); ?>" name="<?php echo $this->get_field_name( 'button_link' ); ?>" type="text" value="<?php echo esc_url( $button_link ); ?>" />
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'bg' ); ?>"><?php esc_html_e( 'Background image:', 'industrium_plugin' ); ?></label>
                </p>

                <div class="media-widget-preview media_image">
                    <?php
                        $bg_id = !empty($bg) ? attachment_url_to_postid($bg) : '';
                        if ( !empty($bg_id) ) {
                            if ( wp_get_attachment_image_url($bg_id, 'medium') ) {
                                $preview_url = wp_get_attachment_image_url($bg_id, 'medium');
                            } else {
                                $preview_url = wp_get_attachment_image_url($bg_id, 'full');
                            }
                        } else {
                            $preview_url = get_template_directory_uri() . '/img/null.png';
                        }
                        echo '<img class="attachment-thumb ' . $this->get_field_id( 'bg' ) . '_img' . (empty($bg) ? ' hidden' : '') . '" src="' . esc_url($preview_url) . '" />';
                    ?>
                    <div class="attachment-media-view">
                        <button type="button" id="<?php echo $this->get_field_id( 'bg' ) ?>" class="button select-media button-add-media not-selected js_custom_upload_media<?php echo
                        empty($bg) ? ' empty' : ' hidden'; ?>"><?php esc_html_e('Add Image', 'industrium_plugin') ?></button>
                    </div>
                    <input hidden type="text" class="widefat <?php echo $this->get_field_id( 'bg' ) ?>_url" name="<?php echo esc_attr( $this->get_field_name( 'bg' ) ); ?>" value="<?php echo !empty($bg) ? $bg : ''; ?>" />
                </div>

                <p class="media-widget-buttons">
                    <button id="<?php echo $this->get_field_id( 'bg' ).'_remove' ?>" type="button" class="button js_custom_remove_media<?php echo (empty($bg) ? ' hidden' : ''); ?>"><?php esc_html_e('Replace Image', 'industrium_plugin') ?></button>
                </p>

                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('colors')); ?>">
                        <?php esc_html_e('Banner Colors', 'industrium_plugin'); ?>:
                    </label>
                    <select name="<?php echo esc_attr($this->get_field_name('colors')); ?>"
                            id="<?php echo esc_attr($this->get_field_id('colors')); ?>">
                        <option value="default" <?php selected($colors, 'default'); ?>><?php esc_html_e('Default', 'industrium_plugin'); ?></option>
                        <option value="contrast" <?php selected($colors, 'contrast'); ?>><?php esc_html_e('Contrast', 'industrium_plugin'); ?></option>
                    </select>
                </p>

            </div>
        <?php
        }

        public function widget($args, $instance) {
            $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $banner_title = !empty( $instance['banner_title'] ) ? $instance['banner_title'] : '';
            $banner_text  = !empty( $instance['banner_text'] ) ? $instance['banner_text'] : '';
            $button_text  = !empty( $instance['button_text'] ) ? $instance['button_text'] : '';
            $button_link  = !empty( $instance['button_link'] ) ? $instance['button_link'] : '#';
            $bg           = isset($instance['bg']) && !empty( $instance['bg'] ) ? $instance['bg'] : '';
            $colors       = !empty( $instance['colors'] ) ? $instance['colors'] : 'default';

            echo $args['before_widget'];

            if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            echo '<div class="banner-widget-wrapper' . ( $colors == 'contrast' ? ' banner-contrast-colors' : ' banner-default-colors' ) . '">';
                if ( !empty($bg) ) {
                    echo '<img src="' . esc_url($bg) . '" alt=""' . esc_attr__('Banner', 'industrium_plugin') . '" />';
                }
                echo '<div class="banner-content">';
                    if ( !empty($banner_title) ) {
                        echo '<h6 class="banner-title">'.esc_html($banner_title).'</h6>';
                    }
                    if ( !empty($banner_text) ) {
                        echo '<p class="banner-description">'.wp_kses($banner_text, array(
                                'strong' => true,
                                'b' => true,
                                'i' => true,
                                'mark' => true,
                                'em' => true,
                                'br' => true
                            )). '</p>';
                    }
                    if ( !empty($button_text) && !empty($button_link) ) {
                        echo '<div class="banner-button">';
                            echo '<a href="' . esc_url($button_link) . '" class="industrium-button">' . esc_html($button_text) . '</a>';
                        echo '</div>';
                    }
                echo '</div>';
            echo '</div>';

            echo $args['after_widget'];
        }
    }
}