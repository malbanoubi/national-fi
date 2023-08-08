<?php

// Sanitize non-negative integer value
// 'absint'

// Sanitize text with HTML tags
// 'wp_kses_post'

// Sanitize text without HTML tags
// 'esc_html', 'sanitize_text_field'

// Sanitize HTML tag attribute
// 'esc_attr'

// Sanitize HTML class name
// 'sanitize_html_class'

// Sanitize HEX color
// 'sanitize_hex_color'

// Sanitize url
// 'esc_url_raw'

// Sanitize shortcode
// 'wp_filter_post_kses'

// Sanitize CSS
// 'wp_strip_all_tags'

// Sanitize slug
// 'sanitize_key'

// Sanitize file name
// 'sanitize_file_name'

// Sanitize drop-down pages
// 'absint'

// Sanitize float value
if ( !function_exists('industrium_sanitize_float') ) {
    function industrium_sanitize_float($input) {
        return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}

// Sanitize integer value
if ( !function_exists('industrium_sanitize_int') ) {
    function industrium_sanitize_int($input) {
        return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }
}

// Sanitize repeater
if ( !function_exists('industrium_sanitize_repeater') ) {
    function industrium_sanitize_repeater($input) {
        $input_decoded = json_decode($input, true);
        if (!empty($input_decoded)) {
            foreach ($input_decoded as $boxk => $box) {
                foreach ($box as $key => $value) {
                    $input_decoded[$boxk][$key] = wp_kses_post($value);
                }
            }
            return json_encode($input_decoded);
        }
        return $input;
    }
}

// Sanitize Checkbox
if ( !function_exists('industrium_sanitize_checkbox') ) {
    function industrium_sanitize_checkbox($input) {
        return (1 === absint($input)) ? 1 : 0;
    }
}

// Sanitize Radio or Select
if ( !function_exists('industrium_sanitize_choice') ) {
    function industrium_sanitize_choice($input, $setting) {
        $input      = sanitize_text_field($input);
        $choices    = $setting->manager->get_control($setting->id)->choices;
        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }
}

// Sanitize CSS
if ( !function_exists('industrium_sanitize_css') ) {
    function industrium_sanitize_css($input) {
        return wp_filter_nohtml_kses($input);
    }
}

// Sanitize Range
if ( !function_exists('industrium_sanitize_range') ) {
    function industrium_sanitize_range($input, $setting) {
        $input  = absint($input);
        $atts   = $setting->manager->get_control($setting->id)->input_attrs;
        $min    = ( isset( $atts['min'] ) ? $atts['min'] : $input );
        $max    = ( isset( $atts['max'] ) ? $atts['max'] : $input );
        $step   = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
        return ( $min <= $input && $input <= $max && is_int($input / $step ) ? $input : $setting->default);
    }
}

// Sanitize E-mail
if ( !function_exists('industrium_sanitize_email') ) {
    function industrium_sanitize_email($input, $setting) {
        $email = sanitize_email($input);
        return ( !is_null($email) ? $email : $setting->default );
    }
}

// Sanitize HEX Color
if ( !function_exists('industrium_sanitize_color') ) {
    function industrium_sanitize_color($input, $setting) {
        $hex_color = sanitize_hex_color($input);
        return ( !is_null($hex_color) ? $hex_color : $setting->default );
    }
}

// Sanitize Alpha Color (HEX, RGB, RGBa)
if ( !function_exists( 'industrium_sanitize_alpha_color' ) ) {
    function industrium_sanitize_alpha_color($input, $setting) {
        if ( empty($input) || is_array($input) ) {
            return $setting->default;
        }

        if ( false === strpos( $input, 'rgb' ) ) {
            $input = sanitize_hex_color($input);
        } else {
            if ( false === strpos( $input, 'rgba' ) ) {
                $input = str_replace( ' ', '', $input );
                sscanf( $input, 'rgb(%d,%d,%d)', $red, $green, $blue );
                $input = 'rgb(' . industrium_in_range( $red, 0, 255 ) . ',' . industrium_in_range( $green, 0, 255 ) . ',' . industrium_in_range( $blue, 0, 255 ) . ')';
            } else {
                $input = str_replace( ' ', '', $input );
                sscanf( $input, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
                $input = 'rgba(' . industrium_in_range( $red, 0, 255 ) . ',' . industrium_in_range( $green, 0, 255 ) . ',' . industrium_in_range( $blue, 0, 255 ) . ',' . industrium_in_range( $alpha, 0, 1 ) . ')';
            }
        }
        return $input;
    }
}

// Sanitize Image
if ( !function_exists('industrium_sanitize_image') ) {
    function industrium_sanitize_image($input, $setting) {
        $mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif'          => 'image/gif',
            'png'          => 'image/png',
            'bmp'          => 'image/bmp',
            'tif|tiff'     => 'image/tiff',
            'ico'          => 'image/x-icon'
        );
        $file = wp_check_filetype($input, $mimes);
        return ( $file['ext'] ? $input : $setting->default );
    }
}

// Sanitize Select2
if ( !function_exists( 'industrium_sanitize_select2' ) ) {
    function industrium_sanitize_select2($input) {
        if ( strpos( $input, ',' ) !== false) {
            $input = explode( ',', $input );
        }
        if ( is_array( $input ) ) {
            foreach ( $input as $key => $value ) {
                $input[$key] = sanitize_text_field($value);
            }
            $input = implode(',', $input);
        }
        else {
            $input = sanitize_text_field($input);
        }
        return $input;
    }
}

// Sanitize Switcher
if ( ! function_exists( 'industrium_sanitize_switcher' ) ) {
    function industrium_sanitize_switcher($input) {
        if ( true === $input ) {
            return 1;
        } else {
            return 0;
        }
    }
}