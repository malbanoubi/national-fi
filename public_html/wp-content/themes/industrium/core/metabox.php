<?php
/*
 * Created by Artureanec
*/

# Custom Fields
if ( class_exists( 'RWMB_Field' ) ) {
    class RWMB_Help_Field extends RWMB_Key_Value_Field {
        public static function html( $meta, $field ) {
            // Question.
            $key                            = isset( $meta[0] ) ? $meta[0] : '';
            $attributes                     = self::get_attributes( $field, $key );
            $attributes['placeholder']      = esc_attr__('Title', 'industrium');
            $html                           = sprintf( '<input %s>', self::render_attributes( $attributes ) );

            // Answer.
            $val                            = isset( $meta[1] ) ? $meta[1] : '';
            $attributes                     = self::get_attributes( $field, $val );
            $attributes['placeholder']      = esc_attr__('Text', 'industrium');
            $attributes['id']               = $attributes['id'] . esc_attr('_text');
            $attributes['value']            = false;
            $html                           .= sprintf( '<textarea %s>%s</textarea>', self::render_attributes( $attributes ), $val );

            return $html;
        }
    }

    class RWMB_Benefits_Field extends RWMB_Input_Field {
        public static function admin_enqueue_scripts() {
            wp_enqueue_style( 'rwmb-color', RWMB_CSS_URL . 'color.css', array( 'wp-color-picker' ), RWMB_VER );

            $dependencies = array( 'wp-color-picker' );
            $args         = func_get_args();
            $field        = reset( $args );
            if ( ! empty( $field['alpha_channel'] ) ) {
                wp_enqueue_script( 'wp-color-picker-alpha', RWMB_JS_URL . 'wp-color-picker-alpha/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), RWMB_VER, true );
                $dependencies = array( 'wp-color-picker-alpha' );
            }
            wp_enqueue_script( 'rwmb-color', RWMB_JS_URL . 'color.js', $dependencies, RWMB_VER, true );
        }

        public static function html( $meta, $field ) {

            $icon_container = industrium_icon_picker_popover(true, true, true, true);

            // Icon.
            $key                                    = isset( $meta[0] ) ? $meta[0] : '';
            $attributes                             = self::get_attributes( $field, $key );
            $attributes['placeholder']              = esc_attr__('Icon', 'industrium');
            $attributes['class']                    = esc_attr('rwmb-icon icp icp-auto');
            $attributes['type']                     = esc_attr('text');
            $attributes['readonly']                 = true;
            $attributes['id']                       = $attributes['id'] . esc_attr('_icon');
            $attributes['data-options']             = false;
            $attributes['data-alpha-enabled']       = false;
            $attributes['data-alpha-color-type']    = false;
            $html                                   = '<div class="rwmb-benefits-icon-picker">';
            $html                                   .= '<div class="input-group icp-container">';
            $html                                   .= sprintf('<input data-placement="bottomRight" %s">', self::render_attributes($attributes) );

            if ( !empty($key) ) {
                $html .= '<span class="input-group-addon"><i class="' . esc_attr($key) . '"></i></span></div>' . sprintf('%s', $icon_container);
            } else {
                $html .= '<span class="input-group-addon"></span></div>' . sprintf('%s', $icon_container);
            };
            $html                                   .= '</div>';

            // Title.
            if ( $field['field_title'] ) {
                $val                                    = isset( $meta[1] ) ? $meta[1] : '';
                $attributes                             = self::get_attributes( $field, $val );
                $attributes['placeholder']              = esc_attr__('Title', 'industrium');
                $attributes['id']                       = $attributes['id'] . esc_attr('_title');
                $attributes['data-options']             = false;
                $attributes['data-alpha-enabled']       = false;
                $attributes['data-alpha-color-type']    = false;
                $html                                   .= '<div class="rwmb-benefits-title">';
                $html                                   .= sprintf( '<input %s>', self::render_attributes($attributes) );
                $html                                   .= '</div>';
            }

            // Color.
            if ( $field['field_color'] ) {
                $key                                    = isset( $meta[2] ) ? $meta[2] : '';
                $attributes                             = self::get_attributes( $field, $key );
                $attributes['placeholder']              = false;
                $attributes['class']                    = 'rwmb-color wp-color-picker';
                $attributes['id']                       = $attributes['id'] . esc_attr('_color');
                $html                                   .= '<div class="rwmb-benefits-color">';
                $html                                   .= sprintf( '<input %s>', self::render_attributes($attributes) );
                $html                                   .= '</div>';
            }

            return $html;
        }

        protected static function begin_html( array $field ) : string {
            $desc = $field['desc'] ? "<p id='{$field['id']}_description' class='description'>{$field['desc']}</p>" : '';
            if ( empty( $field['name'] ) ) {
                return '<div class="rwmb-input">' . $desc;
            }
            return sprintf(
                '<div class="rwmb-label">
				<label for="%s">%s</label>
			</div>
			<div class="rwmb-input">
			%s',
                $field['id'],
                $field['name'],
                $desc
            );
        }

        protected static function input_description( array $field ) : string {
            return '';
        }

        protected static function label_description( array $field ) : string {
            return '';
        }

        public static function esc_meta( $meta ) {
            foreach ( (array) $meta as $k => $pairs ) {
                $meta[ $k ] = array_map( 'esc_attr', (array) $pairs );
            }
            return $meta;
        }

        public static function value( $new, $old, $post_id, $field ) {
            foreach ( $new as &$arr ) {
                if ( empty( $arr[0] ) && empty( $arr[1] ) ) {
                    $arr = false;
                }
            }
            $new = array_filter( $new );
            return $new;
        }

        public static function normalize( $field ) {
            $field['clone']         = true;
            $field['multiple']      = true;
            $field                  = wp_parse_args(
                $field,
                array(
                    'alpha_channel' => false,
                    'js_options'    => array(),
                )
            );
            $field                  = wp_parse_args(
                $field,
                array(
                    'field_title'   => false,
                    'field_color'   => false,
                    'size'          => 30,
                    'maxlength'     => false,
                    'pattern'       => false,
                )
            );
            $field['js_options']    = wp_parse_args(
                $field['js_options'],
                array(
                    'defaultColor' => false,
                    'hide'         => true,
                    'palettes'     => true,
                )
            );
            $field             = parent::normalize( $field );

            $field['attributes']['type'] = 'text';
            $field['placeholder']        = wp_parse_args(
                (array) $field['placeholder'],
                array(
                    'key'   => esc_html__( 'Icon', 'industrium' ),
                    'value' => esc_html__( 'Title', 'industrium' ),
                )
            );
            return $field;
        }

        public static function format_clone_value( $field, $value, $args, $post_id ) {
            return sprintf( '<label>%s:</label> %s', $value[0], $value[1] );
        }

        public static function get_attributes( $field, $value = null ) {
            $attributes         = parent::get_attributes( $field, $value );
            $attributes         = wp_parse_args(
                $attributes,
                array(
                    'size'          => $field['size'],
                    'maxlength'     => $field['maxlength'],
                    'pattern'       => $field['pattern'],
                    'placeholder'   => $field['placeholder'],
                    'data-options'  => wp_json_encode( $field['js_options'] ),
                )
            );
            $attributes['type'] = 'text';

            if ( $field['alpha_channel'] ) {
                $attributes['data-alpha-enabled']    = 'true';
                $attributes['data-alpha-color-type'] = 'hex';
            }

            return $attributes;
        }

        public static function format_single_value( $field, $value, $args, $post_id ) {
            return sprintf( "<span style='display:inline-block;width:20px;height:20px;border-radius:50%%;background:%s;'></span>", $value );
        }
    }

    class RWMB_Iconpicker_Field extends RWMB_Input_Field {

        public static function html( $meta, $field ) {
            $icon_container = industrium_icon_picker_popover(true, true, true, true);

            // Icon.
            $attributes                              = self::call( 'get_attributes', $field, $meta );
            $attributes['placeholder']              = '';
            $attributes['class']                    = esc_attr('icp icp-auto');
            $attributes['type']                     = esc_attr('text');
            $attributes['readonly']                 = true;
            $html                                   = '<div class="rwmb-iconpicker-icon-picker">';
            $html                                   .= '<div class="input-group icp-container">';
            $html                                   .= sprintf('<input data-placement="bottomRight" %s">', self::render_attributes($attributes) );

            if ( !empty($meta) ) {
                $html .= '<span class="input-group-addon"><i class="' . esc_attr($meta) . '"></i></span></div>' . sprintf('%s', $icon_container);
            } else {
                $html .= '<span class="input-group-addon"></span></div>' . sprintf('%s', $icon_container);
            };
            $html                                   .= '</div>';

            return $html;
        }

        public static function normalize( $field ) {
            $field = parent::normalize( $field );

            $field = wp_parse_args(
                $field,
                array(
                    'size'      => 30,
                    'maxlength' => false,
                    'pattern'   => false,
                )
            );

            return $field;
        }

        public static function get_attributes( $field, $value = null ) {
            $attributes = parent::get_attributes( $field, $value );
            $attributes = wp_parse_args(
                $attributes,
                array(
                    'size'        => $field['size'],
                    'maxlength'   => $field['maxlength'],
                    'pattern'     => $field['pattern'],
                    'placeholder' => $field['placeholder'],
                )
            );

            return $attributes;
        }
    }
}

# RWMB check
if (!function_exists('industrium_post_options')) {
    function industrium_post_options()
    {
        if (class_exists('RWMB_Loader')) {
            return true;
        } else {
            return false;
        }
    }
}

# RWMB get option
if (!function_exists('industrium_get_post_option')) {
    function industrium_get_post_option($name, $default = false) {
        if (class_exists('RWMB_Loader')) {
            if (rwmb_meta($name)) {
                return rwmb_meta($name);
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }
}

# RWMB get value
if (!function_exists('industrium_get_post_value')) {
    function industrium_get_post_value($name, $default = false) {
        if (class_exists('RWMB_Loader')) {
            if (rwmb_the_value($name, null, null, false)) {
                return rwmb_the_value($name, null, null, false);
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }
}

# RWMB get image
if (!function_exists('industrium_get_post_image')) {
    function industrium_get_post_image($name, $size = 'large', $default = false) {
        if (class_exists('RWMB_Loader')) {
            if (rwmb_meta($name)) {
                $out = '';
                $images = rwmb_meta( $name, array( 'size' => $size ) );
                foreach ( $images as $image ) {
                    $out .= '<div class="image_wrapper"><img src="'. $image['url']. '" alt="'. $image['alt']. '"></div>';
                }
                return $out;
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }
}

# RWMB get time
if (!function_exists('industrium_get_post_time')) {
    function industrium_get_post_time($time, $default = false) {
        if (class_exists('RWMB_Loader')) {
            if (rwmb_meta($time)) {
                $time = ' ' . rwmb_meta($time);
                $time = str_replace(esc_html__(' 0 Hours', 'industrium'), '', $time);
                $time = str_replace(esc_html__(' 0 Minutes', 'industrium'), '', $time);
                $time = str_replace(esc_html__(' 1 Hours', 'industrium'), esc_html__(' 1 Hour', 'industrium'), $time);
                $time = str_replace(esc_html__(' 1 Minutes', 'industrium'), esc_html__('1 Minute', 'industrium'), $time);
                return trim($time);
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }
}

if (class_exists('RWMB_Loader')) {
    if (!function_exists('industrium_custom_meta_boxes')) {
        add_filter('rwmb_meta_boxes', 'industrium_custom_meta_boxes');

        function industrium_custom_meta_boxes($meta_boxes) {
            $sidebar_list_default = array(
                'default' => esc_html__('Default', 'industrium')
            );
            $sidebar_list = industrium_get_all_sidebar_list();
            $sidebar_list = $sidebar_list_default + $sidebar_list;

            # Quote Post Format
            $meta_boxes[] = array(
                'title'         => esc_html__('Quote Post Format Settings', 'industrium'),
                'post_types'    => array('post'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'            => 'post_media_quote_text',
                        'name'          => esc_html__('Select Images', 'industrium'),
                        'placeholder'   => esc_html__('Enter Quote Text', 'industrium'),
                        'type'          => 'textarea',
                    ),
                    array(
                        'id'            => 'post_media_quote_author',
                        'name'          => esc_html__('Select Images', 'industrium'),
                        'placeholder'   => esc_html__('Quote Author Name', 'industrium'),
                        'type'          => 'text',
                    ),
                ),
            );

            # Gallery Post Format
            $meta_boxes[] = array(
                'title'         => esc_html__('Gallery Post Format Settings', 'industrium'),
                'post_types'    => array('post'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'        => 'post_media_gallery_select',
                        'name'      => esc_html__('Select Images', 'industrium'),
                        'type'      => 'image_advanced',
                    ),
                ),
            );

            # Video Post Format
            $meta_boxes[] = array(
                'title'         => esc_html__('Video Post Format Settings', 'industrium'),
                'post_types'    => array('post'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'        => 'post_media_video_type',
                        'name'      => esc_html__('Video Source', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'link',
                        'options'   => array(
                            'link'      => esc_html__('Outer Link', 'industrium'),
                            'self'      => esc_html__('Self Hosted', 'industrium')
                        )
                    ),
                    array(
                        'id'            => 'post_media_video_url',
                        'name'          => esc_html__('Enter Video Link', 'industrium'),
                        'type'          => 'oembed',
                        'desc'          => esc_html__('Copy link to the video from YouTube or other video-sharing website.', 'industrium'),
                        'attributes'    => array(
                            'data-dependency-id'    => 'post_media_video_type',
                            'data-dependency-val'   => 'link'
                        )
                    ),
                    array(
                        'id'                => 'post_media_video_select',
                        'name'              => esc_html__('Select Video From Media Library', 'industrium'),
                        'type'              => 'video',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'attributes'        => array(
                            'data-dependency-id'    => 'post_media_video_type',
                            'data-dependency-val'   => 'self'
                        )
                    ),
                ),
            );

            # Content Output Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Single Post Settings', 'industrium'),
                'post_types'    => array('post'),
                'context'       => 'advanced',
                'fields'        => array(

                    //-- Single Post Settings
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Post Output Settings', 'industrium'),
                    ),

                    array(
                        'id'        => 'post_media_image_status',
                        'name'      => esc_html__('Show Media Block', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'post_category_status',
                        'name'      => esc_html__('Show Post Categories', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'post_date_status',
                        'name'      => esc_html__('Show Post Date', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'post_author_status',
                        'name'      => esc_html__('Show Post Author', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'post_comment_counter_status',
                        'name'      => esc_html__('Show Number of Post Comments', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'post_title_status',
                        'name'      => esc_html__('Show Post Title', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'post_tags_status',
                        'name'      => esc_html__('Show Post Tags', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'post_socials_status',
                        'name'      => esc_html__('Show Post Social Buttons', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Sticky Header
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Recent Posts', 'industrium'),
                    ),

                    array(
                        'id'        => 'recent_posts_status',
                        'name'      => esc_html__('Show Recent Posts', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'recent_posts_customize',
                        'name'      => esc_html__('Customize', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_section_heading',
                        'name'          => esc_html__('Recent Posts Section Title', 'industrium'),
                        'type'          => 'text',
                        'std'           => '',
                        'placeholder'   => industrium_get_theme_mod('recent_posts_section_heading')
                    ),

                    array(
                        'id'            => 'recent_posts_number',
                        'name'          => esc_html__('Number of Posts', 'industrium'),
                        'type'          => 'select',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            '2'             => esc_html__('2 Items', 'industrium'),
                            '3'             => esc_html__('3 Items', 'industrium'),
                            '4'             => esc_html__('4 Items', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_order_by',
                        'name'          => esc_html__('Order By', 'industrium'),
                        'type'          => 'select',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'random'        => esc_html__('Random', 'industrium'),
                            'date'          => esc_html__('Date', 'industrium'),
                            'name'          => esc_html__('Name', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_order',
                        'name'          => esc_html__('Sort Order', 'industrium'),
                        'type'          => 'select',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'desc'          => esc_html__('Descending', 'industrium'),
                            'asc'           => esc_html__('Ascending', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_image',
                        'name'          => esc_html__('Show Recent Post Image', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'on'            => esc_html__('Yes', 'industrium'),
                            'off'           => esc_html__('No', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_category',
                        'name'          => esc_html__('Show Recent Post Categories', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'on'            => esc_html__('Yes', 'industrium'),
                            'off'           => esc_html__('No', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_date',
                        'name'          => esc_html__('Show Recent Post Date', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'on'            => esc_html__('Yes', 'industrium'),
                            'off'           => esc_html__('No', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_author',
                        'name'          => esc_html__('Show Recent Post Author', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'on'            => esc_html__('Yes', 'industrium'),
                            'off'           => esc_html__('No', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_comment_counter',
                        'name'          => esc_html__('Show Recent Post Number of Comments', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'on'            => esc_html__('Yes', 'industrium'),
                            'off'           => esc_html__('No', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_title',
                        'name'          => esc_html__('Show Recent Post Title', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'on'            => esc_html__('Yes', 'industrium'),
                            'off'           => esc_html__('No', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_excerpt',
                        'name'          => esc_html__('Show Recent Post Excerpt', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'on'            => esc_html__('Yes', 'industrium'),
                            'off'           => esc_html__('No', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_excerpt_length',
                        'name'          => esc_html__('Recent Post Excerpt Length', 'industrium'),
                        'type'          => 'number',
                        'placeholder'   => industrium_get_theme_mod('recent_posts_excerpt_length'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'custom'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_tags',
                        'name'          => esc_html__('Show Recent Post Tags', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'on'            => esc_html__('Yes', 'industrium'),
                            'off'           => esc_html__('No', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_posts_more',
                        'name'          => esc_html__('Show Recent Post \'Read More\' Button', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'on'            => esc_html__('Yes', 'industrium'),
                            'off'           => esc_html__('No', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    )
                )
            );

            # Portfolio Custom Fields
            $meta_boxes[] = array(
                'title'         => esc_html__('Portfolio Fields', 'industrium'),
                'post_types'    => array('industrium_portfolio'),
                'context'       => 'side',
                'fields'        => array(
                    array(
                        'id'    => 'portfolio_author',
                        'name'  => esc_html__('Portfolio Author', 'industrium'),
                        'type'  => 'text'
                    ),
                    array(
                        'id'    => 'portfolio_client',
                        'name'  => esc_html__('Client', 'industrium'),
                        'type'  => 'text'
                    ),
                    array(
                        'id'    => 'portfolio_gallery',
                        'name'  => esc_html__('Portfolio Gallery', 'industrium'),
                        'type'  => 'image_advanced'
                    )
                )
            );

            # Projects Custom Fields
            $meta_boxes[] = array(
                'title'         => esc_html__('Project Fields', 'industrium'),
                'post_types'    => array('industrium_project'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'            => 'project_strategy',
                        'name'          => esc_html__('Strategy', 'industrium'),
                        'type'          => 'text',
                        'add_button'    => esc_html__('+ Add More', 'industrium'),
                        'clone'         => true
                    ),
                    array(
                        'id'            => 'project_design',
                        'name'          => esc_html__('Design', 'industrium'),
                        'type'          => 'text',
                        'add_button'    => esc_html__('+ Add More', 'industrium'),
                        'clone'         => true
                    ),
                    array(
                        'id'            => 'project_client',
                        'name'          => esc_html__('Client', 'industrium'),
                        'type'          => 'text'
                    ),
                    array(
                        'id'            => 'project_button',
                        'name'          => esc_html__('Link Button', 'industrium'),
                        'type'          => 'text_list',
                        'options'       => array(
                            esc_attr__('Link', 'industrium')   => esc_html__('Link', 'industrium'),
                            esc_attr__('Label', 'industrium')  => esc_html__('Label', 'industrium')
                        ),
                        'clone'         => false
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'project_gallery',
                        'name'          => esc_html__('Project Gallery', 'industrium'),
                        'type'          => 'image_advanced'
                    )
                )
            );

            # Team Member Custom Fields
            $meta_boxes[] = array(
                'title'         => esc_html__('Team Member Fields', 'industrium'),
                'post_types'    => array('industrium_team'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'            => 'team_member_position',
                        'name'          => esc_html__('Position', 'industrium'),
                        'type'          => 'text'
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_short_text',
                        'name'          => esc_html__('Member Short Info', 'industrium'),
                        'type'          => 'wysiwyg',
                        'options'       => array(
                            'textarea_rows' => 6
                        ),
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_contacts_link',
                        'name'          => esc_html__('Contacts Link', 'industrium'),
                        'type'          => 'text',
                        'std'           => '#'
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_socials',
                        'name'          => esc_html__('Social Links', 'industrium'),
                        'type'          => 'key_value',
                        'placeholder'   => array(
                            'key'           => esc_attr__('Icon', 'industrium'),
                            'value'         => esc_attr__('Link', 'industrium')
                        ),
                        'add_button'    => esc_html__('+ Add More', 'industrium'),
                        'class'         => 'icon-picker',
                        'clone'         => true,
                        'sort_clone'    => true,
                        'max_clone'     => 7
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_biography_title',
                        'name'          => esc_html__('Biography Title', 'industrium'),
                        'type'          => 'text'
                    ),
                    array(
                        'id'            => 'team_member_biography_text',
                        'name'          => esc_html__('Biography Text', 'industrium'),
                        'type'          => 'wysiwyg',
                        'options'       => array(
                            'textarea_rows' => 6
                        ),
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_personal_info_title',
                        'name'          => esc_html__('Personal Info Title', 'industrium'),
                        'type'          => 'text',
                        'std'           => esc_html__('Personal Info', 'industrium')
                    ),
                    array(
                        'id'            => 'team_member_personal_info_item',
                        'name'          => esc_html__('Personal Info Item', 'industrium'),
                        'type'          => 'text',
                        'clone'         => true,
                        'add_button'    => esc_html__('+ Add More', 'industrium')
                    ),
                    array(
                        'id'            => 'team_member_email',
                        'name'          => esc_html__('Personal Info E-mail', 'industrium'),
                        'type'          => 'text'
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_skills_title',
                        'name'          => esc_html__('Skills List Title', 'industrium'),
                        'type'          => 'text',
                        'std'           => esc_html__('Main Skills', 'industrium')
                    ),
                    array(
                        'id'            => 'team_member_skills_list',
                        'name'          => esc_html__('Personal Skills', 'industrium'),
                        'type'          => 'text',
                        'clone'         => true,
                        'add_button'    => esc_html__('+ Add More', 'industrium')
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_values_title',
                        'name'          => esc_html__('Values List Title', 'industrium'),
                        'type'          => 'text',
                        'std'           => esc_html__('Values', 'industrium')
                    ),
                    array(
                        'id'            => 'team_member_values_list',
                        'name'          => esc_html__('Values', 'industrium'),
                        'type'          => 'text',
                        'clone'         => true,
                        'add_button'    => esc_html__('+ Add More', 'industrium')
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'team_member_experience_title',
                        'name'          => esc_html__('Experience & Education Section Title', 'industrium'),
                        'type'          => 'textarea',
                        'std'           => wp_kses_post(__('My experience<br> & years of education', 'industrium'))
                    ),
                    array(
                        'id'            => 'team_member_education_list',
                        'name'          => esc_html__('Education List', 'industrium'),
                        'type'          => 'text_list',
                        'clone'         => true,
                        'options'       => array(
                            esc_attr__('Title', 'industrium')          => esc_html__('Title', 'industrium'),
                            esc_attr__('Period', 'industrium')         => esc_html__('Period', 'industrium'),
                            esc_attr__('Description', 'industrium')    => esc_html__('Description', 'industrium'),
                        ),
                        'add_button'    => esc_html__('+ Add More', 'industrium')
                    ),
                    array(
                        'id'            => 'team_member_experience_list',
                        'name'          => esc_html__('Experience List', 'industrium'),
                        'type'          => 'text_list',
                        'clone'         => true,
                        'options'       => array(
                            esc_attr__('Title', 'industrium')          => esc_html__('Title', 'industrium'),
                            esc_attr__('Period', 'industrium')         => esc_html__('Period', 'industrium'),
                            esc_attr__('Description', 'industrium')    => esc_html__('Description', 'industrium'),
                        ),
                        'add_button'    => esc_html__('+ Add More', 'industrium')
                    ),
                )
            );

            # Vacancy Custom Fields
            $meta_boxes[] = array(
                'title'         => esc_html__('Career Fields', 'industrium'),
                'post_types'    => array('industrium_vacancy'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'        => 'vacancy_occupation',
                        'name'      => esc_html__('Occupation', 'industrium'),
                        'type'      => 'text',
                        'desc'      => esc_html__('Full-time, part-time, contract, etc.', 'industrium')
                    ),
                    array(
                        'id'        => 'vacancy_location',
                        'name'      => esc_html__('Location', 'industrium'),
                        'type'      => 'text',
                    ),
                    array(
                        'id'        => 'vacancy_salary',
                        'name'      => esc_html__('Salary', 'industrium'),
                        'type'      => 'text',
                    ),
                    array(
                        'id'        => 'vacancy_responsibilities',
                        'name'      => esc_html__('Responsibilities', 'industrium'),
                        'type'      => 'wysiwyg',
                        'raw'       => false,
                        'options'   => array(
                            'textarea_rows' => 8,
                            'teeny'         => true,
                        ),
                    ),
                    array(
                        'id'        => 'vacancy_qualifications',
                        'name'      => esc_html__('Preferred Qualifications', 'industrium'),
                        'type'      => 'wysiwyg',
                        'raw'       => false,
                        'options'   => array(
                            'textarea_rows' => 8,
                            'teeny'         => true,
                        ),
                    ),
                    array(
                        'id'            => 'vacancy_button',
                        'name'          => esc_html__('Contact Button', 'industrium'),
                        'type'          => 'text_list',
                        'options'       => array(
                            esc_attr__('Link', 'industrium')   => esc_html__('Link', 'industrium'),
                            esc_attr__('Label', 'industrium')  => esc_html__('Label', 'industrium')
                        ),
                        'clone'         => false
                    ),

                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Recent Careers', 'industrium'),
                    ),

                    array(
                        'id'        => 'recent_vacancies_status',
                        'name'      => esc_html__('Show Recent Careers', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'recent_vacancies_customize',
                        'name'      => esc_html__('Customize', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'recent_vacancies_section_heading',
                        'name'          => esc_html__('Recent Careers Section Title', 'industrium'),
                        'type'          => 'textarea',
                        'std'           => '',
                        'placeholder'   => industrium_get_theme_mod('recent_vacancies_section_heading')
                    ),

                    array(
                        'id'            => 'recent_vacancies_number',
                        'name'          => esc_html__('Number of Posts', 'industrium'),
                        'type'          => 'number',
                        'min'           => 1,
                        'max'           => 20,
                        'step'          => 1,
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_posts_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_vacancies_order_by',
                        'name'          => esc_html__('Order By', 'industrium'),
                        'type'          => 'select',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'random'        => esc_html__('Random', 'industrium'),
                            'date'          => esc_html__('Date', 'industrium'),
                            'name'          => esc_html__('Name', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_vacancies_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'recent_vacancies_order',
                        'name'          => esc_html__('Sort Order', 'industrium'),
                        'type'          => 'select',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'desc'          => esc_html__('Descending', 'industrium'),
                            'asc'           => esc_html__('Ascending', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'recent_vacancies_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                )
            );

            # Service Post Icon Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Service Icon', 'industrium'),
                'post_types'    => array('industrium_service'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'            => 'service_main_icon',
                        'type'          => 'iconpicker',
                        'name'          => esc_html__('Service Icon', 'industrium'),
                    ),
                    array(
                        'id'            => 'service_main_icon_color',
                        'name'          => esc_html__('Icon Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),
                )
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Service Slider Alternative Image', 'industrium'),
                'post_types'    => array('industrium_service'),
                'context'       => 'advanced',
                'fields'  => [
                    [
                        'type'             => 'image_advanced',
                        'name'             => esc_html__( 'Image', 'industrium' ),
                        'id'               => 'service_slider_image_advanced',
                        'max_file_uploads' => 1,
                    ],
                ],
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Service Slider Background Color', 'industrium'),
                'post_types'    => array('industrium_service'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'            => 'service_slider_bg_color',
                        'name'          => esc_html__('Slider Item Background Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),
                )
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Service Slider Item Color', 'industrium'),
                'post_types'    => array('industrium_service'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'            => 'service_slider_item_color',
                        'name'          => esc_html__('Slider Item Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),
                )
            );
            # Service Custom Fields
            $meta_boxes[] = array(
                'title'         => esc_html__('Service Fields', 'industrium'),
                'post_types'    => array('industrium_service'),
                'context'       => 'after_title',
                'fields'        => array(
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Short Description', 'industrium'),
                    ),
                    array(
                        'id'        => 'service_description',
                        'type'      => 'wysiwyg',
                        'raw'       => true,
                        'options'   => array(
                            'textarea_rows' => 12,
                            'teeny'         => false,
                        ),
                    ),

                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'service_subtitle',
                        'name'          => esc_html__('Service Slider Subtitle', 'industrium'),
                        'type'          => 'text',
                        'std'           => esc_html__('Industrium Services', 'industrium'),
                    ),
                    array(
                        'type' => 'divider',
                    ),
                    array(
                        'id'            => 'service_help_title',
                        'name'          => esc_html__('Help Section Title', 'industrium'),
                        'type'          => 'text',
                        'std'           => esc_html__('We’re Here to Help You', 'industrium'),
                    ),
                    array(
                        'id'            => 'service_help_items',
                        'name'          => esc_html__('Help Items', 'industrium'),
                        'type'          => 'help',
                        'clone'         => true,
                        'add_button'    => esc_html__('+ Add More', 'industrium')
                    ),

                )
            );

            # Case Study Custom Fields
            $meta_boxes[] = array(
                'title'         => esc_html__('Case Study Fields', 'industrium'),
                'post_types'    => array('industrium_case'),
                'context'       => 'advanced',
                'fields'        => array(
                    array(
                        'id'        => 'case_study_result',
                        'name'      => esc_html__('Results', 'industrium'),
                        'type'      => 'wysiwyg',
                        'raw'       => false,
                        'options'   => array(
                            'textarea_rows' => 8,
                            'teeny'         => true,
                        ),
                    ),

                    array(
                        'id'        => 'case_study_boxes',
                        'name'      => 'Result Boxes',
                        'type'      => 'text_list',
                        'clone'     => true,
                        'options'   => array(
                            'Value'     => 'Value',
                            'Title'     => 'Title'
                        ),
                    ),
                )
            );

            # Post and Page Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Color Settings', 'industrium'),
                'post_types'    => array('post', 'page', 'industrium_portfolio', 'industrium_team', 'industrium_vacancy', 'industrium_service', 'industrium_case', 'product', 'industrium_project'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(

                    # Color Options

                    //-- Standard colors
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Standard Colors', 'industrium'),
                    ),

                    array(
                        'id'            => 'standard_default_text_color',
                        'name'          => esc_html__('Default Text Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_dark_text_color',
                        'name'          => esc_html__('Dark Text Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_light_text_color',
                        'name'          => esc_html__('Light Text Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_accent_text_color',
                        'name'          => esc_html__('Accent Text Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'            => 'standard_border_color',
                        'name'          => esc_html__('Border Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_border_hover_color',
                        'name'          => esc_html__('Hovered Border Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'            => 'standard_background_color',
                        'name'          => esc_html__('Background Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_background_alter_color',
                        'name'          => esc_html__('Alternative Background Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'            => 'standard_button_text_color',
                        'name'          => esc_html__('Button Text Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_border_color',
                        'name'          => esc_html__('Button Border Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_background_color',
                        'name'          => esc_html__('Button Background Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_text_hover',
                        'name'          => esc_html__('Button Text Hover', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_border_hover',
                        'name'          => esc_html__('Button Border Hover', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'standard_button_background_hover',
                        'name'          => esc_html__('Button Background Hover', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Contrast Colors
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Contrast Colors', 'industrium'),
                    ),

                    array(
                        'id'            => 'contrast_default_text_color',
                        'name'          => esc_html__('Default Text Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_dark_text_color',
                        'name'          => esc_html__('Dark Text Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_light_text_color',
                        'name'          => esc_html__('Light Text Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_accent_text_color',
                        'name'          => esc_html__('Accent Text Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'            => 'contrast_border_color',
                        'name'          => esc_html__('Border Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_border_hover_color',
                        'name'          => esc_html__('Hovered Border Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'            => 'contrast_background_color',
                        'name'          => esc_html__('Background Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_background_alter_color',
                        'name'          => esc_html__('Alternative Background Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'            => 'contrast_button_text_color',
                        'name'          => esc_html__('Button Text Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_border_color',
                        'name'          => esc_html__('Button Border Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_background_color',
                        'name'          => esc_html__('Button Background Color', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_text_hover',
                        'name'          => esc_html__('Button Text Hover', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_border_hover',
                        'name'          => esc_html__('Button Border Hover', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),

                    array(
                        'id'            => 'contrast_button_background_hover',
                        'name'          => esc_html__('Button Background Hover', 'industrium'),
                        'type'          => 'color',
                        'std'           => '',
                        'alpha_channel' => true
                    ),
                )
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Top Bar Settings', 'industrium'),
                'post_types'    => array('post', 'page', 'industrium_portfolio', 'industrium_team', 'industrium_vacancy', 'industrium_service', 'industrium_case', 'product', 'industrium_project'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(

                # Top Bar Options

                    //-- Top Bar General
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('General', 'industrium'),
                    ),

                    array(
                        'id'        => 'top_bar_status',
                        'name'      => esc_html__('Show Top Bar', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'top_bar_customize',
                        'name'      => esc_html__('Customize', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'top_bar_default_text_color',
                        'name'          => esc_html__('Default Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_dark_text_color',
                        'name'          => esc_html__('Dark Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_light_text_color',
                        'name'          => esc_html__('Light Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_accent_text_color',
                        'name'          => esc_html__('Accent Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_border_color',
                        'name'          => esc_html__('Border Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_border_hover_color',
                        'name'          => esc_html__('Hovered Border Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_background_color',
                        'name'          => esc_html__('Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_background_alter_color',
                        'name'          => esc_html__('Alternative Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_button_text_color',
                        'name'          => esc_html__('Button Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_button_border_color',
                        'name'          => esc_html__('Button Border Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_button_background_color',
                        'name'          => esc_html__('Button Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_button_text_hover',
                        'name'          => esc_html__('Button Text Hover', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_button_border_hover',
                        'name'          => esc_html__('Button Border Hover', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_button_background_hover',
                        'name'          => esc_html__('Button Background Hover', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),
                    
                     //-- Top Bar Menu
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Menu', 'industrium'),
                    ),

                    array(
                        'id'        => 'top_bar_menu_status',
                        'name'      => esc_html__('Show Menu', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),
                    array(
                        'id'        => 'top_bar_menu_select',
                        'name'      => esc_html__('Select Menu', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => industrium_get_all_menu_list()
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Top Bar Social Buttons
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Social Buttons', 'industrium'),
                    ),

                    array(
                        'id'        => 'top_bar_socials_status',
                        'name'      => esc_html__('Show Social Buttons', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Top Bar Additional Text
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Additional Text', 'industrium'),
                    ),

                    array(
                        'id'        => 'top_bar_additional_text_status',
                        'name'      => esc_html__('Show Additional Text', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'top_bar_additional_text_title',
                        'name'          => esc_html__('Additional Text Title', 'industrium'),
                        'type'          => 'textarea',
                        'placeholder'   => industrium_get_theme_mod('top_bar_additional_text_title'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_additional_text_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_additional_text',
                        'name'          => esc_html__('Additional Text', 'industrium'),
                        'type'          => 'textarea',
                        'placeholder'   => industrium_get_theme_mod('top_bar_additional_text'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_additional_text_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Top Bar Contacts
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Contacts', 'industrium'),
                    ),

                    array(
                        'id'        => 'top_bar_contacts_phone_status',
                        'name'      => esc_html__('Show Phone Number', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'top_bar_contacts_phone_title',
                        'name'          => esc_html__('Phone Title', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('top_bar_contacts_phone_title'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_contacts_phone_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_contacts_phone',
                        'name'          => esc_html__('Phone Number', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('top_bar_contacts_phone'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_contacts_phone_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'        => 'top_bar_contacts_email_status',
                        'name'      => esc_html__('Show Email Address', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'top_bar_contacts_email_title',
                        'name'          => esc_html__('Email Title', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('top_bar_contacts_email_title'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_contacts_email_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'top_bar_contacts_email',
                        'name'          => esc_html__('Email Address', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('top_bar_contacts_email'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_contacts_email_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),                    

                    array(
                        'id'        => 'top_bar_contacts_address_status',
                        'name'      => esc_html__('Show Address', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'top_bar_contacts_address_title',
                        'name'          => esc_html__('Address Title', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('top_bar_contacts_address_title'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_contacts_address_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),
                    
                    array(
                        'id'            => 'top_bar_contacts_address',
                        'name'          => esc_html__('Address', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('top_bar_contacts_address'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'top_bar_contacts_address_status',
                            'data-dependency-val'   => 'on'
                        )
                    )

                )
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Header Settings', 'industrium'),
                'post_types'    => array('post', 'page', 'industrium_portfolio', 'industrium_team', 'industrium_vacancy', 'industrium_service', 'industrium_case', 'product', 'industrium_project'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(

                # Header Options

                    //-- Header General
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Contacts', 'industrium'),
                    ),

                    array(
                        'id'        => 'header_status',
                        'name'      => esc_html__('Show Header', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'header_style',
                        'name'      => esc_html__('Header Style', 'industrium'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'type-1'    => esc_html__('Style 1', 'industrium'),
                            'type-2'    => esc_html__('Style 2', 'industrium'),
                            'type-3'    => esc_html__('Style 3', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'header_position',
                        'name'      => esc_html__('Header Position', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'above'     => esc_html__('Above', 'industrium'),
                            'over'      => esc_html__('Over', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'header_customize',
                        'name'      => esc_html__('Customize', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'header_default_text_color',
                        'name'          => esc_html__('Default Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_dark_text_color',
                        'name'          => esc_html__('Dark Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_light_text_color',
                        'name'          => esc_html__('Light Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_accent_text_color',
                        'name'          => esc_html__('Accent Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_border_color',
                        'name'          => esc_html__('Border Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_border_hover_color',
                        'name'          => esc_html__('Hovered Border Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_background_color',
                        'name'          => esc_html__('Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_background_alter_color',
                        'name'          => esc_html__('Alternative Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_text_color',
                        'name'          => esc_html__('Button Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_border_color',
                        'name'          => esc_html__('Button Border Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_background_color',
                        'name'          => esc_html__('Button Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_text_hover',
                        'name'          => esc_html__('Button Text Hover', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_border_hover',
                        'name'          => esc_html__('Button Border Hover', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_button_background_hover',
                        'name'          => esc_html__('Button Background Hover', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Sticky Header
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Sticky Header', 'industrium'),
                    ),

                    array(
                        'id'        => 'sticky_header_status',
                        'name'      => esc_html__('Show Sticky Header', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Mobile Header
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Mobile Header', 'industrium'),
                    ),

                    array(
                        'id'            => 'mobile_header_breakpoint',
                        'name'          => esc_html__('Mobile Header Breakpoint, in px', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('mobile_header_breakpoint'),
                        'std'           => ''
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Header Logo
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Logo', 'industrium'),
                    ),

                    array(
                        'id'        => 'header_logo_status',
                        'name'      => esc_html__('Show Header Logo', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'header_logo_customize',
                        'name'      => esc_html__('Customize', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        )
                    ),

                    array(
                        'id'                => 'header_logo_image',
                        'name'              => esc_html__('Logo Image', 'industrium'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'        => array(
                            'data-dependency-id'    => 'header_logo_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_logo_retina',
                        'name'          => esc_html__('Logo Retina', 'industrium'),
                        'type'          => 'checkbox',
                        'std'           => 1,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_logo_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'                => 'header_logo_mobile_image',
                        'name'              => esc_html__('Mobile Logo Image', 'industrium'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'        => array(
                            'data-dependency-id'    => 'header_logo_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_logo_mobile_retina',
                        'name'          => esc_html__('Mobile Logo Retina', 'industrium'),
                        'type'          => 'checkbox',
                        'std'           => 1,
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_logo_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Header Callback
                    array(
                        'type'          => 'heading',
                        'name'          => esc_html__('Header Callback', 'industrium'),
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_style',
                            'data-dependency-val'   => 'type-3'
                        )
                    ),

                    array(
                        'id'            => 'header_callback_status',
                        'name'          => esc_html__('Show Header Callback Block', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'               => esc_html__('Default', 'industrium'),
                            'on'                    => esc_html__('Yes', 'industrium'),
                            'off'                   => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'header_callback_title',
                        'name'          => esc_html__('Header Callback Title', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('header_callback_title'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_callback_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_callback_text',
                        'name'          => esc_html__('Header Callback Text', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('header_callback_text'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_callback_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'header_callback_link',
                        'name'          => esc_html__('Header Callback Link', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('header_callback_link'),
                        'std'           => '',
                        'attributes'    => array(
                            'data-dependency-id'    => 'header_callback_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Header Button
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Header Button', 'industrium'),
                    ),

                    array(
                        'id'        => 'header_button_status',
                        'name'      => esc_html__('Show Header Button', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'header_button_text',
                        'name'          => esc_html__('Header Button Text', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('header_button_text'),
                        'std'           => ''
                    ),

                    array(
                        'id'            => 'header_button_url',
                        'name'          => esc_html__('Header Button Link', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('header_button_url'),
                        'std'           => ''
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Header Menu
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Header Menu', 'industrium'),
                    ),

                    array(
                        'id'        => 'header_menu_status',
                        'name'      => esc_html__('Show Main Menu', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'header_menu_select',
                        'name'      => esc_html__('Select Menu', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => industrium_get_all_menu_list()
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    array(
                        'id'        => 'header_menu_dots',
                        'name'      => esc_html__('Header Menu Icons', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'dots'      => esc_html__('Dots', 'industrium'),
                            'checks'    => esc_html__('Checkmarks', 'industrium')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Header Side Panel
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Header Icons', 'industrium'),
                    ),

                    array(
                        'id'        => 'side_panel_status',
                        'name'      => esc_html__('Show side panel trigger', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'header_search_status',
                        'name'      => esc_html__('Show search icon', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'header_minicart_status',
                        'name'          => esc_html__('Show product cart', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'on'            => esc_html__('Yes', 'industrium'),
                            'off'           => esc_html__('No', 'industrium')
                        ),
                    ),
                ),
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Page Title Settings', 'industrium'),
                'post_types'    => array('post', 'page', 'industrium_portfolio', 'industrium_team', 'industrium_vacancy', 'industrium_service', 'industrium_case', 'product', 'industrium_project'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(

                    # Page Title Options

                    //-- Page Title General
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('General', 'industrium'),
                    ),

                    array(
                        'id'        => 'page_title_status',
                        'name'      => esc_html__('Show Page Title', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'page_title_overlay_status',
                        'name'      => esc_html__('Show overlay', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'page_title_overlay_color',
                        'name'          => esc_html__('Overlay Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_overlay_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'        => 'page_title_customize',
                        'name'      => esc_html__('Customize', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'class'     => 'divider-before',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'page_title_height',
                        'name'          => esc_html__('Page Title Height', 'industrium'),
                        'type'          => 'number',
                        'placeholder'   => industrium_get_theme_mod('page_title_height'),
                        'std'           => industrium_get_theme_mod('page_title_height'),
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_default_text_color',
                        'name'          => esc_html__('Default Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_dark_text_color',
                        'name'          => esc_html__('Dark Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_light_text_color',
                        'name'          => esc_html__('Light Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_accent_text_color',
                        'name'          => esc_html__('Accent Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_border_color',
                        'name'          => esc_html__('Border Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_border_hover_color',
                        'name'          => esc_html__('Hovered Border Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_background_color',
                        'name'          => esc_html__('Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_background_alter_color',
                        'name'          => esc_html__('Alternative Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_text_color',
                        'name'          => esc_html__('Button Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_border_color',
                        'name'          => esc_html__('Button Border Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_background_color',
                        'name'          => esc_html__('Button Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_text_hover',
                        'name'          => esc_html__('Button Text Hover', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_border_hover',
                        'name'          => esc_html__('Button Border Hover', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_button_background_hover',
                        'name'          => esc_html__('Button Background Hover', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'                => 'page_title_background_image',
                        'name'              => esc_html__('Background Image', 'industrium'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'class'             => 'divider-before',
                        'attributes'        => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_background_position',
                        'name'          => esc_html__('Background Position', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'center center' => esc_html__('Center Center', 'industrium'),
                            'center left'   => esc_html__('Center Left', 'industrium'),
                            'center right'  => esc_html__('Center Right', 'industrium'),
                            'top center'    => esc_html__('Top Center', 'industrium'),
                            'top left'      => esc_html__('Top Left', 'industrium'),
                            'top right'     => esc_html__('Top Right', 'industrium'),
                            'bottom center' => esc_html__('Bottom Center', 'industrium'),
                            'bottom left'   => esc_html__('Bottom Left', 'industrium'),
                            'bottom right'  => esc_html__('Bottom Right', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_background_repeat',
                        'name'          => esc_html__('Background Repeat', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'no-repeat'     => esc_html__('No-repeat', 'industrium'),
                            'repeat'        => esc_html__('Repeat', 'industrium'),
                            'repeat-x'      => esc_html__('Repeat-x', 'industrium'),
                            'repeat-y'      => esc_html__('Repeat-y', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'page_title_background_size',
                        'name'          => esc_html__('Background Size', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'initial'       => esc_html__('Initial', 'industrium'),
                            'auto'          => esc_html__('Auto', 'industrium'),
                            'cover'         => esc_html__('Cover', 'industrium'),
                            'contain'       => esc_html__('Contain', 'industrium'),
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type'          => 'divider',
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'hide_page_title_background_mobile',
                        'name'          => esc_html__('Hide Background Image on Mobile Devices', 'industrium'),
                        'type'          => 'checkbox',
                        'std'           => 0,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'hide_page_title_background_tablet',
                        'name'          => esc_html__('Hide Background Image on Tablet Devices', 'industrium'),
                        'type'          => 'checkbox',
                        'std'           => 0,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    //-- Page Title Heading
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Heading', 'industrium'),
                    ),

                    array(
                        'id'        => 'page_title_heading_customize',
                        'name'      => esc_html__('Customize', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'page_title_heading_icon_status',
                        'name'      => esc_html__('Add Image Icon before Title', 'industrium'),
                        'type'      => 'select',
                        'std'       => industrium_get_theme_mod('page_title_heading_icon_status'),
                        'options'   => array(
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_heading_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'                => 'page_title_heading_icon_image',
                        'name'              => esc_html__('Icon Image', 'industrium'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'        => array(
                            'data-dependency-id'    => 'page_title_heading_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                     array(
                        'id'            => 'page_title_heading_icon_retina',
                        'name'          => esc_html__('Icon Image Retina', 'industrium'),
                        'type'          => 'checkbox',
                        'std'           => 1,
                        'attributes'    => array(
                            'data-dependency-id'    => 'page_title_heading_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),
                    
                    //-- Page Title Breadcrumbs
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Page Title Breadcrumbs', 'industrium'),
                    ),

                    array(
                        'id'        => 'page_title_breadcrumbs_status',
                        'name'      => esc_html__('Show Page Title Breadcrumbs', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Show', 'industrium'),
                            'off'       => esc_html__('Hide', 'industrium')
                        )
                    ),

                    //-- Page Title Decoration
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Page Title Decoration', 'industrium'),
                    ),

                    array(
                        'id'        => 'page_title_decoration_status',
                        'name'      => esc_html__('Show Page Title Decoration', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    )
                )
            );

            // Layout Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Layout Settings', 'industrium'),
                'post_types'    => array('page'),
                'context'       => 'advanced',
                'closed'        => true,
                'fields'        => array(

                    //-- Content Margin
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Content Margin', 'industrium'),
                    ),
                    array(
                        'id'        => 'content_top_margin',
                        'name'      => esc_html__('Remove Top Margin', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'off',
                        'options'   => array(
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'content_bottom_margin',
                        'name'      => esc_html__('Remove Bottom Margin', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'off',
                        'options'   => array(
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Sidebar Options
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Sidebar', 'industrium'),
                    ),

                    array(
                        'id'        => 'sidebar_position',
                        'name'      => esc_html__('Sidebar Position', 'industrium'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'left'      => esc_html__('Left', 'industrium'),
                            'right'     => esc_html__('Right', 'industrium'),
                            'none'      => esc_html__('None', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'page_sidebar_select',
                        'name'          => esc_html__('Select Sidebar', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => $sidebar_list
                    ),
                )
            );

            // Layout Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Layout Settings', 'industrium'),
                'post_types'    => array('industrium_service'),
                'context'       => 'advanced',
                'closed'        => true,
                'fields'        => array(

                    //-- Content Margin
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Content Margin', 'industrium'),
                    ),
                    array(
                        'id'        => 'content_top_margin',
                        'name'      => esc_html__('Remove Top Margin', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'off',
                        'options'   => array(
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'content_bottom_margin',
                        'name'      => esc_html__('Remove Bottom Margin', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'off',
                        'options'   => array(
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Sidebar Options
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Sidebar', 'industrium'),
                    ),

                    array(
                        'id'        => 'service_sidebar_position',
                        'name'      => esc_html__('Sidebar Position', 'industrium'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'left'      => esc_html__('Left', 'industrium'),
                            'right'     => esc_html__('Right', 'industrium'),
                            'none'      => esc_html__('None', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'service_sidebar_select',
                        'name'          => esc_html__('Select Sidebar', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => $sidebar_list
                    ),
                )
            );

            // Layout Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Layout Settings', 'industrium'),
                'post_types'    => array('industrium_team'),
                'context'       => 'advanced',
                'closed'        => true,
                'fields'        => array(

                    //-- Content Margin
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Content Margin', 'industrium'),
                    ),
                    array(
                        'id'        => 'content_top_margin',
                        'name'      => esc_html__('Remove Top Margin', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'off',
                        'options'   => array(
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'content_bottom_margin',
                        'name'      => esc_html__('Remove Bottom Margin', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'off',
                        'options'   => array(
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        )
                    )
                )
            );

            // Layout Settings
            $meta_boxes[] = array(
                'title'         => esc_html__('Layout Settings', 'industrium'),
                'post_types'    => array('post'),
                'context'       => 'advanced',
                'closed'        => true,
                'fields'        => array(

                    //-- Sidebar Options
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Sidebar', 'industrium'),
                    ),

                    array(
                        'id'        => 'post_sidebar_position',
                        'name'      => esc_html__('Sidebar Position', 'industrium'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'left'      => esc_html__('Left', 'industrium'),
                            'right'     => esc_html__('Right', 'industrium'),
                            'none'      => esc_html__('None', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'post_sidebar_select',
                        'name'          => esc_html__('Select Sidebar', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => $sidebar_list
                    ),
                )
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Side Panel Settings', 'industrium'),
                'post_types'    => array('post', 'page', 'industrium_portfolio', 'industrium_team', 'industrium_vacancy', 'industrium_service', 'industrium_case', 'product'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(
                    //-- Side Panel Logo
                    array(
                        'id'        => 'sidebar_logo_status',
                        'name'      => esc_html__('Show Logo', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'                => 'sidebar_logo_image',
                        'name'              => esc_html__('Logo Image', 'industrium'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'        => array(
                            'data-dependency-id'    => 'sidebar_logo_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'sidebar_logo_retina',
                        'name'          => esc_html__('Logo Retina', 'industrium'),
                        'type'          => 'checkbox',
                        'std'           => 1,
                        'attributes'        => array(
                            'data-dependency-id'    => 'sidebar_logo_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),                    
                )
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Footer Settings', 'industrium'),
                'post_types'    => array('post', 'page', 'industrium_portfolio', 'industrium_team', 'industrium_vacancy', 'industrium_service', 'industrium_case', 'product', 'industrium_project'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(

                    # Footer Options

                    //-- Footer General
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('General', 'industrium'),
                    ),

                    array(
                        'id'        => 'footer_status',
                        'name'      => esc_html__('Show Footer', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'footer_style',
                        'name'      => esc_html__('Footer Style', 'industrium'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'type-1'    => esc_html__('Style 1', 'industrium'),
                            'type-2'    => esc_html__('Style 2', 'industrium'),
                            'type-3'    => esc_html__('Style 3', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'footer_customize',
                        'name'      => esc_html__('Customize', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'off'       => esc_html__('No', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'footer_default_text_color',
                        'name'          => esc_html__('Default Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_dark_text_color',
                        'name'          => esc_html__('Dark Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_light_text_color',
                        'name'          => esc_html__('Light Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_accent_text_color',
                        'name'          => esc_html__('Accent Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_border_color',
                        'name'          => esc_html__('Border Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_border_hover_color',
                        'name'          => esc_html__('Hovered Border Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_background_color',
                        'name'          => esc_html__('Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_background_alter_color',
                        'name'          => esc_html__('Alternative Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_text_color',
                        'name'          => esc_html__('Button Text Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'class'         => 'divider-before',
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_border_color',
                        'name'          => esc_html__('Button Border Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_background_color',
                        'name'          => esc_html__('Button Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_text_hover',
                        'name'          => esc_html__('Button Text Hover', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_border_hover',
                        'name'          => esc_html__('Button Border Hover', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_button_background_hover',
                        'name'          => esc_html__('Button Background Hover', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'                => 'footer_background_image',
                        'name'              => esc_html__('Background Image', 'industrium'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'attributes'        => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_background_position',
                        'name'          => esc_html__('Background Position', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'center center' => esc_html__('Center Center', 'industrium'),
                            'center left'   => esc_html__('Center Left', 'industrium'),
                            'center right'  => esc_html__('Center Right', 'industrium'),
                            'top center'    => esc_html__('Top Center', 'industrium'),
                            'top left'      => esc_html__('Top Left', 'industrium'),
                            'top right'     => esc_html__('Top Right', 'industrium'),
                            'bottom center' => esc_html__('Bottom Center', 'industrium'),
                            'bottom left'   => esc_html__('Bottom Left', 'industrium'),
                            'bottom right'  => esc_html__('Bottom Right', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_background_repeat',
                        'name'          => esc_html__('Background Repeat', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'no-repeat'     => esc_html__('No-repeat', 'industrium'),
                            'repeat'        => esc_html__('Repeat', 'industrium'),
                            'repeat-x'      => esc_html__('Repeat-x', 'industrium'),
                            'repeat-y'      => esc_html__('Repeat-y', 'industrium')
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'id'            => 'footer_background_size',
                        'name'          => esc_html__('Background Size', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => array(
                            'default'       => esc_html__('Default', 'industrium'),
                            'initial'       => esc_html__('Initial', 'industrium'),
                            'auto'          => esc_html__('Auto', 'industrium'),
                            'cover'         => esc_html__('Cover', 'industrium'),
                            'contain'       => esc_html__('Contain', 'industrium'),
                        ),
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_customize',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Footer Logo
                    array(
                        'id'        => 'footer_logo_status',
                        'name'      => esc_html__('Show Logo', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        ),
                        'attributes'        => array(
                            'data-dependency-id'    => 'footer_style',
                            'data-dependency-val'   => 'type-3'
                        )
                    ),

                    array(
                        'id'                => 'footer_logo_image',
                        'name'              => esc_html__('Logo Image', 'industrium'),
                        'type'              => 'image_advanced',
                        'max_file_uploads'  => 1,
                        'max_status'        => false,
                        'size'              => 'full',
                        'attributes'        => array(
                            'data-dependency-id'    => 'footer_style',
                            'data-dependency-val'   => 'type-3'
                        )
                    ),

                    array(
                        'id'            => 'footer_logo_retina',
                        'name'          => esc_html__('Logo Retina', 'industrium'),
                        'type'          => 'checkbox',
                        'std'           => 1,
                        'attributes'        => array(
                            'data-dependency-id'    => 'footer_style',
                            'data-dependency-val'   => 'type-3'
                        )
                    ),   

                    array(
                        'type' => 'divider',
                    ),

                    //-- Special Text

                    array(
                        'id'        => 'footer_special_text_status',
                        'name'      => esc_html__('Show Special Text', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        ),
                        'attributes'        => array(
                            'data-dependency-id'    => 'footer_style',
                            'data-dependency-val'   => 'type-3'
                        )
                    ),

                    array(
                        'id'            => 'footer_special_text',
                        'name'          => esc_html__('Special Text', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('footer_special_text'),
                        'std'           => '',
                        'attributes'        => array(
                            'data-dependency-id'    => 'footer_style',
                            'data-dependency-val'   => 'type-3'
                        )
                    ),

                    //-- Footer Widgets
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Footer Widgets', 'industrium'),
                    ),

                    array(
                        'id'        => 'footer_sidebar_top_status',
                        'name'      => esc_html__('Show Top Footer Widgets', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'footer_sidebar_top_select',
                        'name'          => esc_html__('Select Top Sidebar', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => $sidebar_list,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_sidebar_top_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),
                    
                    array(
                        'id'        => 'footer_sidebar_status',
                        'name'      => esc_html__('Show Footer Widgets', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'footer_sidebar_select',
                        'name'          => esc_html__('Select Sidebar', 'industrium'),
                        'type'          => 'select',
                        'std'           => 'default',
                        'options'       => $sidebar_list,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_sidebar_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Copyright
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Copyright', 'industrium'),
                    ),

                    array(
                        'id'        => 'footer_copyright_status',
                        'name'      => esc_html__('Show Copyright', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'            => 'footer_copyright_text',
                        'name'          => esc_html__('Copyright Text', 'industrium'),
                        'type'          => 'text',
                        'placeholder'   => industrium_get_theme_mod('footer_copyright_text'),
                        'std'           => '',
                        'sanitize_callback' => 'wp_kses_post'
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Footer Menu
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Footer Menu', 'industrium'),
                    ),

                    array(
                        'id'        => 'footer_menu_status',
                        'name'      => esc_html__('Show Footer Menu', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'footer_menu_select',
                        'name'      => esc_html__('Select Menu', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => industrium_get_all_menu_list()
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Footer Additional Menu
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Footer Additional Menu', 'industrium'),
                    ),

                    array(
                        'id'        => 'footer_additional_menu_status',
                        'name'      => esc_html__('Show Footer Additional Menu', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),

                    array(
                        'id'        => 'footer_additional_menu_select',
                        'name'      => esc_html__('Select Menu', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => industrium_get_all_menu_list()
                    ),

                    array(
                        'type' => 'divider',
                    ),

                    //-- Footer Decoration
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Footer Decoration', 'industrium'),
                    ),

                    array(
                        'id'        => 'footer_decoration_status',
                        'name'      => esc_html__('Show Footer Decoration', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),
                )
            );

            $meta_boxes[] = array(
                'title'         => esc_html__('Additional Settings', 'industrium'),
                'post_types'    => array('post', 'page', 'industrium_portfolio', 'industrium_team', 'industrium_vacancy', 'industrium_service', 'industrium_case', 'product', 'industrium_project'),
                'closed'        => true,
                'context'       => 'advanced',
                'fields'        => array(                    

                    //-- Footer Scroll To Top
                    array(
                        'type'  => 'heading',
                        'name'  => esc_html__('Scroll To Top Button', 'industrium'),
                    ),

                    array(
                        'id'        => 'footer_scrolltop_status',
                        'name'      => esc_html__('Show Scroll To Top Button', 'industrium'),
                        'type'      => 'select',
                        'std'       => 'default',
                        'options'   => array(
                            'default'   => esc_html__('Default', 'industrium'),
                            'on'        => esc_html__('Yes', 'industrium'),
                            'off'       => esc_html__('No', 'industrium')
                        )
                    ),
                    array(
                        'id'            => 'footer_scrolltop_bg_color',
                        'name'          => esc_html__('Scroll To Top Button Background Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_scrolltop_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),
                    array(
                        'id'            => 'footer_scrolltop_color',
                        'name'          => esc_html__('Scroll To Top Button Color', 'industrium'),
                        'type'          => 'color',
                        'alpha_channel' => true,
                        'attributes'    => array(
                            'data-dependency-id'    => 'footer_scrolltop_status',
                            'data-dependency-val'   => 'on'
                        )
                    ),
                )
            );

            return $meta_boxes;
        }
    }
}