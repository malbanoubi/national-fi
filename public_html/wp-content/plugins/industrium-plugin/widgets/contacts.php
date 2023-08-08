<?php
/*
 * Created by Artureanec
*/

if (!class_exists('Industrium_Contacts_Widget')) {
    class Industrium_Contacts_Widget extends WP_Widget {
        public function __construct() {
            parent::__construct(
                'Industrium_Contacts_Widget',
                'Contacts Widget (Industrium Theme)',
                array(
                    'description' => esc_html__('Contacts Widget by Industrium Theme', 'industrium_plugin'),
                    'mime_type'   => 'image'
                )
            );
        }

        private function allowedTags() {
            $kses_defaults = wp_kses_allowed_html( 'post' );
            $svg_args = array(
                'svg'   => array(
                    'class'           => true,
                    'style'           => true,
                    'focusable'       => true,
                    'aria-hidden'     => true,
                    'aria-labelledby' => true,
                    'role'            => true,
                    'xmlns'           => true,
                    'width'           => true,
                    'height'          => true,
                    'viewbox'         => true
                ),
                'g'     => array( 'fill' => true ),
                'path'  => array( 
                    'd'               => true, 
                    'fill'            => true  
                )
            );

            $allowed_tags = array_merge( $kses_defaults, $svg_args );

            return $allowed_tags;
        }

        public function update($new_instance, $old_instance) {
            $instance = $old_instance;

            $instance['title']      = sanitize_text_field($new_instance['title']);
            $instance['logo']       = strip_tags($new_instance['logo']);
            $instance['logo_id']    = esc_attr($new_instance['logo_id']);
            $instance['retina']     = sanitize_text_field($new_instance['retina']);
            $instance['show_labels'] = !empty($new_instance['show_labels']) ? sanitize_text_field($new_instance['show_labels']) : '';
            $instance['address']    = wp_kses_post($new_instance['address']);
            $instance['phone']      = wp_kses($new_instance['phone'], $this->allowedTags());
            $instance['email']      = wp_kses_post($new_instance['email']);
            $instance['social']     = sanitize_text_field($new_instance['social']);
            $instance['text']       = wp_kses_post($new_instance['text']);
            $instance['copyright']  = wp_kses_post($new_instance['copyright']);
            $instance['link_text']   = esc_attr($new_instance['link_text']);
            $instance['contacts_link']  = esc_url($new_instance['contacts_link']);

            return $instance;
        }

        public function form($instance) {
            $default_values = array(
                'title'     => '',
                'logo'      => '',
                'logo_id'   => '',
                'retina'    => false,
                'show_labels' => false,
                'address'   => '',
                'phone'     => '',
                'email'     => '',
                'social'    => 'disabled',
                'text'      => '',
                'copyright' => '',
                'link_text' => '',
                'contacts_link' => ''
            );

            $instance = wp_parse_args((array)$instance, $default_values);
            $retina     = isset( $instance['retina'] ) ? (bool) $instance['retina'] : false;
            $show_labels     = isset( $instance['show_labels'] ) ? (bool) $instance['show_labels'] : false;
            ?>

            <div class="industrium_widget">
                <div class="media-widget-control">
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                            <?php esc_html_e('Title', 'industrium_plugin'); ?>:
                        </label>
                        <input class="widefat"
                               type="text"
                               id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                               name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                               value="<?php echo esc_html($instance['title']); ?>"
                        />
                    </p>

                    <p>
                        <label for="<?php echo $this->get_field_id( 'logo' ); ?>"><?php esc_html_e( 'Logo:', 'industrium_plugin' ); ?></label>
                    </p>

                    <div class="media-widget-preview media_image">
                        <?php
                        $logo_id = !empty($instance['logo']) ? attachment_url_to_postid( $instance['logo'] ) : '';

                        if ( !empty($logo_id) ) {
                            if ( wp_get_attachment_image_url($logo_id, 'medium') ) {
                                $logo_url = wp_get_attachment_image_url($logo_id, 'medium');
                            } else {
                                $logo_url = wp_get_attachment_image_url($logo_id, 'full');
                            }
                        } else {
                            $logo_url = get_template_directory_uri() . '/img/null.png';
                        }
                        echo '<img class="attachment-thumb ' . $this->get_field_id( 'logo' ) . '_img' . (empty($instance['logo']) ? ' hidden' : '') . '" src="' . esc_url($logo_url) . '" />';
                        ?>
                        <div class="attachment-media-view">
                            <button type="button" id="<?php echo $this->get_field_id( 'logo' ) ?>" class="button select-media button-add-media not-selected js_custom_upload_media<?php echo empty($instance['logo']) ? ' empty' : ' hidden'; ?>"><?php esc_html_e('Add Image', 'industrium_plugin') ?></button>
                        </div>
                        <input hidden type="text" class="widefat <?php echo $this->get_field_id( 'logo' ) ?>_url" name="<?php echo esc_attr( $this->get_field_name( 'logo' ) ); ?>" value="<?php echo !empty($instance['logo']) ? $instance['logo'] : ''; ?>" />
                        <input hidden type="text" class="widefat2 <?php echo $this->get_field_id( 'logo' ) ?>_id" name="<?php echo esc_attr( $this->get_field_name( 'logo_id' ) ); ?>" value="<?php echo !empty($instance['logo_id']) ? $instance['logo_id'] : ''; ?>" />
                    </div>

                    <p class="media-widget-buttons">
                        <button id="<?php echo $this->get_field_id( 'logo' ).'_remove' ?>" type="button" class="button js_custom_remove_media<?php echo (empty($instance['logo']) ? ' hidden' : ''); ?>"><?php esc_html_e('Replace Image', 'industrium_plugin') ?></button>
                    </p>

                    <p>
                        <label for="<?php echo $this->get_field_id( 'retina' ); ?>">
                            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'retina' ); ?>" name="<?php echo $this->get_field_name( 'retina' ); ?>"<?php checked( $retina ); ?> />
                            <?php esc_html_e( 'Logo Retina', 'industrium_plugin' ); ?>
                        </label>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id( 'show_labels' ); ?>">
                            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_labels' ); ?>" name="<?php echo $this->get_field_name( 'show_labels' ); ?>"<?php checked( $show_labels ); ?> />
                            <?php esc_html_e( 'Show Labels', 'industrium_plugin' ); ?>
                        </label>
                    </p>
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('address')); ?>">
                            <?php esc_html_e('Address', 'industrium_plugin'); ?>:
                        </label>
                        <textarea class="widefat"
                               id="<?php echo esc_attr($this->get_field_id('address')); ?>"
                               name="<?php echo esc_attr($this->get_field_name('address')); ?>"
                        ><?php echo wp_kses_post($instance['address']); ?></textarea>
                    </p>

                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('phone')); ?>">
                            <?php esc_html_e('Phone Number', 'industrium_plugin'); ?>:
                        </label>
                        <textarea class="widefat"
                                  id="<?php echo esc_attr($this->get_field_id('phone')); ?>"
                                  name="<?php echo esc_attr($this->get_field_name('phone')); ?>"
                        ><?php echo wp_kses($instance['phone'], $this->allowedTags()); ?></textarea>
                    </p>

                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('email')); ?>">
                            <?php esc_html_e('Email', 'industrium_plugin'); ?>:
                        </label>
                        <textarea class="widefat"
                                  id="<?php echo esc_attr($this->get_field_id('email')); ?>"
                                  name="<?php echo esc_attr($this->get_field_name('email')); ?>"
                        ><?php echo wp_kses_post($instance['email']); ?></textarea>
                    </p>

                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('social')); ?>">
                            <?php esc_html_e('Social Buttons', 'industrium_plugin'); ?>:
                        </label>
                        <select name="<?php echo esc_attr($this->get_field_name('social')); ?>"
                                id="<?php echo esc_attr($this->get_field_id('social')); ?>">
                            <option value="disabled" <?php selected($instance['social'], 'disabled'); ?>><?php esc_html_e('Disabled', 'industrium_plugin'); ?></option>
                            <option value="enabled" <?php selected($instance['social'], 'enabled'); ?>><?php esc_html_e('Enabled', 'industrium_plugin'); ?></option>
                        </select>
                    </p>

                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('text')); ?>">
                            <?php esc_html_e('Description', 'industrium_plugin'); ?>:
                        </label>
                        <textarea class="widefat"
                                  id="<?php echo esc_attr($this->get_field_id('text')); ?>"
                                  name="<?php echo esc_attr($this->get_field_name('text')); ?>"
                        ><?php echo wp_kses_post($instance['text']); ?></textarea>
                    </p>

                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('copyright')); ?>">
                            <?php esc_html_e('Additional text', 'industrium_plugin'); ?>:
                        </label>
                        <textarea class="widefat"
                                  id="<?php echo esc_attr($this->get_field_id('copyright')); ?>"
                                  name="<?php echo esc_attr($this->get_field_name('copyright')); ?>"
                        ><?php echo wp_kses_post($instance['copyright']); ?></textarea>
                    </p>
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('link_text')); ?>">
                            <?php echo esc_html__('Link Text', 'industrium_plugin'); ?>:
                        </label>
                        <input class="widefat"
                               type="text"
                               id="<?php echo esc_attr($this->get_field_id('link_text')); ?>"
                               name="<?php echo esc_attr($this->get_field_name('link_text')); ?>"
                               value="<?php echo esc_html($instance['link_text']); ?>"
                        />
                    </p>
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('contacts_link')); ?>">
                            <?php echo esc_html__('Contacts Link', 'industrium_plugin'); ?>:
                        </label>
                        <input class="widefat"
                               type="text"
                               id="<?php echo esc_attr($this->get_field_id('contacts_link')); ?>"
                               name="<?php echo esc_attr($this->get_field_name('contacts_link')); ?>"
                               value="<?php echo esc_url($instance['contacts_link']); ?>"
                        />
                    </p>
                </div>
            </div>
            <?php
        }

        public function widget($args, $instance) {
            extract($args);

            echo $before_widget;
            if ($instance['title']) {
                echo $before_title;
                echo apply_filters('widget_title', $instance['title']);
                echo $after_title;
            }

            if ( !empty($instance['logo']) && !empty($instance['logo_id']) ) {
                $demo_url = 'https://demo.artureanec.com/themes/industrium';
                $current_url = get_home_url();
                if ( strpos($instance['logo'], $demo_url) === false ) {
                    $url = $instance['logo'];
                } else {
                    $url = str_replace($demo_url, $current_url, $instance['logo']);
                }
                $logo_id = $instance['logo_id'];
                $logo_meta = wp_get_attachment_metadata( $logo_id );
                if ( $instance['retina'] == true ) {
                    $logo_width = (isset($logo_meta['width']) ? floor($logo_meta['width'] / 2 ) : 0);
                    $logo_height = (isset($logo_meta['height']) ? floor( $logo_meta['height'] / 2 ) : 0);
                } else {
                    $logo_width = (isset($logo_meta['width']) ? $logo_meta['width'] : 0);
                    $logo_height = (isset($logo_meta['height']) ? $logo_meta['height'] : 0);
                }
                echo '<div class="industrium-contacts-widget-logo logo' . ($instance['retina'] == true ? ' retina-logo' : '') . '">';
                    echo '<a href="' . esc_url(home_url('/')) . '" class="logo-link">';
                        echo '<img width="' . esc_attr($logo_width) . '" height="' . esc_attr($logo_height) . '" src="'.esc_url($url).'" alt="' . esc_attr(get_post_meta(attachment_url_to_postid($url), '_wp_attachment_image_alt', TRUE)) . '" />';
                    echo '</a>';
                echo '</div>';
            }

            if ($instance['text'] !== '') {
                echo '
                    <div class="industrium-contacts-widget-description">
                        <p>
                            ' . wp_kses_post($instance['text']) . '
                        </p>
                    </div>
                ';
            }
            $label_class = '';
            if ($instance['show_labels'] == true) {
                $label_class = ' labeled';
            }
            if ($instance['address'] !== '') {
                echo '<div class="industrium-contacts-widget-field industrium-contacts-widget-address' . $label_class .'">';
                    if ($instance['show_labels'] == true) {
                        echo '<h6 class="field-label">' . esc_html__('Location', 'industrium_plugin') . '</h6>';
                    }
                    echo wp_kses_post($instance['address']);
                echo '</div>';
            }
            if ($instance['phone'] !== '') {
                echo '<div class="industrium-contacts-widget-field industrium-contacts-widget-phone' . $label_class .'">';
                    if ($instance['show_labels'] == true) {
                        echo '<h6 class="field-label">' . esc_html__('Phone', 'industrium_plugin') . '</h6>';
                    } 
                    echo wp_kses($instance['phone'], $this->allowedTags());
                echo '</div>';
            }
            if ($instance['email'] !== '') {
                echo '<div class="industrium-contacts-widget-field industrium-contacts-widget-email' . $label_class .'">';
                    if ($instance['show_labels'] == true) {
                        echo '<h6 class="field-label">' . esc_html__('Email', 'industrium_plugin') . '</h6>';
                    } 
                    echo wp_kses_post($instance['email']);
                echo '</div>';
            }

            if (isset($instance['social']) && $instance['social'] == 'enabled') {
                echo industrium_socials_output('widget-socials wrapper-socials');
            }
            if ($instance['link_text'] !== '' && $instance['contacts_link'] !== '') {
                echo '
                    <div class="industrium-contacts-widget-link">
                        <a href="' . esc_url($instance['contacts_link']) . '">' . 
                            wp_kses($instance['link_text'], array('br' => array(), 'strong' => array(), 'b' => array(), 'em' => array(), 'i' => array())) .
                        ' </a>
                    </div>
                ';
            }
            if ($instance['copyright'] !== '') {
                echo '
                    <div class="industrium-contacts-widget-copyright">
                        <p>
                            ' . wp_kses_post($instance['copyright']) . '
                        </p>
                    </div>
                ';
            }

            echo $after_widget;
        }
    }
}
