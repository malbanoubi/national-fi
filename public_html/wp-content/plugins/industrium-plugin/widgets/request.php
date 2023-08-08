<?php
/*
 * Created by Artureanec
*/

if (!class_exists('Industrium_Request_Contacts_Widget')) {
    class Industrium_Request_Contacts_Widget extends WP_Widget {
        public function __construct() {
            parent::__construct(
                'Industrium_Request_Contacts_Widget',
                'Request Contacts (Industrium Theme)',
                array(
                    'description' => esc_html__('Request Contacts by Industrium Theme', 'industrium_plugin'),
                    'mime_type'   => ''
                )
            );
        }

        public function update($new_instance, $old_instance) {
            $instance = $old_instance;

            $instance['title'] = sanitize_text_field($new_instance['title']);

            $instance['quote_title']   = sanitize_text_field($new_instance['quote_title']);
            $instance['quote_text']    = sanitize_text_field($new_instance['quote_text']);
            $instance['button_text']    = sanitize_text_field($new_instance['button_text']);
            $instance['button_link']    = sanitize_text_field($new_instance['button_link']);
            $instance['new_tab'] = isset($new_instance['new_tab']) ? sanitize_text_field($new_instance['new_tab']) : '';

            return $instance;
        }

        public function form($instance) {
            $instance     = wp_parse_args( (array) $instance, array( 'title' => '' ) );

            $quote_title       = !empty( $instance['quote_title'] ) ? $instance['quote_title'] : '';
            $quote_text        = !empty( $instance['quote_text'] ) ? $instance['quote_text'] : '';
            $button_text        = !empty( $instance['button_text'] ) ? $instance['button_text'] : '';
            $button_link        = !empty( $instance['button_link'] ) ? $instance['button_link'] : '#';

            $new_tab     = isset( $instance['new_tab'] ) ? (bool) $instance['new_tab'] : false;
            ?>
            <div class="media-widget-control">
                <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'industrium_plugin' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'quote_title' ); ?>"><?php esc_html_e( 'Request Contacts Title:', 'industrium_plugin' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'quote_title' ); ?>" name="<?php echo $this->get_field_name( 'quote_title' ); ?>" type="text" value="<?php echo esc_attr( $quote_title ); ?>" />
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'quote_text' ); ?>"><?php esc_html_e( 'Request Contacts Text:', 'industrium_plugin' ); ?></label>
                    <textarea rows="3" class="widefat textarea widget_textarea_control" name="<?php echo $this->get_field_name( 'quote_text' ); ?>" id="<?php echo esc_attr( $this->get_field_id('quote_text') ) ?>"><?php echo esc_html($quote_text) ?></textarea>
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
                    <label for="<?php echo $this->get_field_id( 'new_tab' ); ?>">
                        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'new_tab' ); ?>" name="<?php echo $this->get_field_name( 'new_tab' ); ?>"<?php checked( $new_tab ); ?> />
                        <?php esc_html_e( 'Open Link in New Tab', 'industrium_plugin' ); ?>
                    </label>
                </p>
            </div>
        <?php
        }

        public function widget($args, $instance) {
            $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $quote_title = !empty( $instance['quote_title'] ) ? $instance['quote_title'] : '';
            $quote_text  = !empty( $instance['quote_text'] ) ? $instance['quote_text'] : '';
            $button_text  = !empty( $instance['button_text'] ) ? $instance['button_text'] : '';
            $button_link  = !empty( $instance['button_link'] ) ? $instance['button_link'] : '#';

            echo $args['before_widget'];

            if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            echo '<div class="request_contacts-widget-wrapper">';
                echo '<div class="request_contacts-widget-row">';
                    echo '<div class="request_contacts-widget-content">';
                        if ( !empty($quote_title) ) {
                            echo '<h2 class="request_contacts-title">'.esc_html($quote_title).'</h2>';
                        }
                        if ( !empty($quote_text) ) {
                            echo '<p class="request_contacts-description">'.wp_kses($quote_text, array(
                                    'strong' => true,
                                    'b' => true,
                                    'i' => true,
                                    'mark' => true,
                                    'em' => true,
                                    'br' => true
                                )). '</p>';
                        }                        
                    echo '</div>';
                    if ( !empty($button_text) && !empty($button_link) ) {
                        echo '<div class="request_contacts-button">';
                            $target = '';
                            if(isset($instance['new_tab'])) {
                                $target = $instance['new_tab'] == true ? ' target="_blank"' : '';
                            }
                            echo '<a href="' . esc_url($button_link) . '" class="industrium-button"' . industrium_output_code($target) . '>' . esc_html($button_text) . '<svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5"></polyline></svg></a>';
                        echo '</div>';
                    }  
                echo '</div>';             
            echo '</div>';

            echo $args['after_widget'];
        }
    }
}