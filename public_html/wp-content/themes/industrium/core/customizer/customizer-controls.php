<?php

if (class_exists('WP_Customize_Control')) {

// Register Custom Control
    class Industrium_Customize_Control extends WP_Customize_Control {
        public $dependency = array();
        public $separator  = 'none';

        public function is_visible(){
            $dependency_array   = $this->dependency;
            $is_visible         = true;

            if ( !empty($dependency_array) ) {
                foreach ($dependency_array as $value) {
                    $depend_control = $value['control'];
                    $depend_operator = $value['operator'];
                    $depend_values = explode(',', $value['value']);
                    $depend_values = array_map('trim', $depend_values);

                    $observable_value = get_theme_mod($depend_control);
                }
                switch ($depend_operator) {
                    case '==':
                        if (!in_array($observable_value, $depend_values)) {
                            $is_visible = false;
                        }
                        break;
                    case '!=':
                        if (in_array($observable_value, $depend_values)) {
                            $is_visible = false;
                        }
                        break;
                    default:
                        if (!in_array($observable_value, $depend_values)) {
                            $is_visible = false;
                        }
                        break;
                }
            }
            return $is_visible;
        }

        public function enqueue() {
            wp_enqueue_script( 'industrium-customizer-js', get_template_directory_uri() . '/js/customizer.js', array('jquery'), '1.0', true );
        }

        public function render() {
            $id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
            $depend_class   = ( !empty($this->dependency) ? ' is-depend' : '' ) . ($this->is_visible() == false ? ' invisible' : '');
            $depend_attr    = ( !empty($this->dependency) ? json_encode($this->dependency) : '' );
            switch ($this->separator){
                case 'before':
                    $separator = ' separator-before';
                    break;
                case 'after':
                    $separator = ' separator-after';
                    break;
                case 'both':
                    $separator = ' separator-both';
                    break;
                default:
                    $separator = '';
                    break;
            }
            $class = 'customize-control customize-control-' . esc_attr($this->type) . esc_attr($depend_class) . esc_attr($separator);

            echo '<li id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '"' . ( !empty($depend_attr) ? ' data-dependency="' . esc_attr( $depend_attr ) . '"' : '' ) . '>';
                $this->render_content();
            echo '</li>';
        }

        public function render_content() {
            $description_id     = '_customize-description-' . esc_attr($this->id);
            $input_id           = '_customize-input-' . esc_attr($this->id);
            $describedby_attr   = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
            $allowed_html       = array(
                'a'         => array(
                    'href'      => true,
                    'title'     => true,
                    'class'     => true,
                    'target'    => true
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'i'         => array(
                    'class'     => true
                ),
                'span'      => array(
                    'class'     => true
                ),
                'code'      => array()
            );

            switch ( $this->type ) {
                case 'checkbox':
                    ?>
                    <span class="customize-inside-control-row">
                        <input
                                id="<?php echo esc_attr( $input_id ); ?>"
                            <?php echo sprintf('%s', $describedby_attr); ?>
                                type="checkbox"
                                value="<?php echo esc_attr( $this->value() ); ?>"
                            <?php $this->link(); ?>
                            <?php checked( $this->value() ); ?>
                        />
					    <label for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $this->label ); ?></label>
                        <?php if ( ! empty( $this->description ) ) : ?>
                            <span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo wp_kses($this->description, $allowed_html); ?></span>
                        <?php endif; ?>
				    </span>
                    <?php
                    break;
                case 'radio':
                    if ( empty( $this->choices ) ) {
                        return;
                    }

                    $name = '_customize-radio-' . $this->id;
                    ?>
                    <?php if ( ! empty( $this->label ) ) : ?>
                        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $this->description ) ) : ?>
                        <span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo wp_kses($this->description, $allowed_html); ?></span>
                    <?php endif; ?>

                    <?php foreach ( $this->choices as $value => $label ) : ?>
                    <span class="customize-inside-control-row">
						<input
                                id="<?php echo esc_attr( $input_id . '-radio-' . $value ); ?>"
                                type="radio"
                            <?php echo sprintf('%s', $describedby_attr); ?>
                                value="<?php echo esc_attr( $value ); ?>"
                                name="<?php echo esc_attr( $name ); ?>"
                            <?php $this->link(); ?>
                            <?php checked( $this->value(), $value ); ?>
                        />
						<label for="<?php echo esc_attr( $input_id . '-radio-' . $value ); ?>"><?php echo esc_html( $label ); ?></label>
					</span>
                <?php endforeach; ?>
                    <?php
                    break;
                case 'select':
                    if ( empty( $this->choices ) ) {
                        return;
                    }

                    ?>
                    <?php if ( ! empty( $this->label ) ) : ?>
                    <label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
                <?php endif; ?>
                    <?php if ( ! empty( $this->description ) ) : ?>
                    <span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo wp_kses($this->description, $allowed_html); ?></span>
                <?php endif; ?>

                    <select id="<?php echo esc_attr( $input_id ); ?>" <?php echo sprintf('%s', $describedby_attr); ?> <?php $this->link(); ?>>
                        <?php
                        foreach ( $this->choices as $value => $label ) {
                            echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . esc_html($label) . '</option>';
                        }
                        ?>
                    </select>
                    <?php
                    break;
                case 'textarea':
                    ?>
                    <?php if ( ! empty( $this->label ) ) : ?>
                        <label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
                    <?php endif; ?>
                    <?php if ( ! empty( $this->description ) ) : ?>
                        <span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo wp_kses($this->description, $allowed_html); ?></span>
                    <?php endif; ?>
                    <textarea
                            id="<?php echo esc_attr( $input_id ); ?>"
                            rows="5 "
                        <?php echo sprintf('%s', $describedby_attr); ?>
                        <?php $this->input_attrs(); ?>
                        <?php $this->link(); ?>
                    ><?php echo esc_textarea( $this->value() ); ?></textarea>
                    <?php
                    break;
                case 'dropdown-pages':
                    ?>
                    <?php if ( ! empty( $this->label ) ) : ?>
                    <label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
                <?php endif; ?>
                    <?php if ( ! empty( $this->description ) ) : ?>
                    <span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo wp_kses($this->description, $allowed_html); ?></span>
                <?php endif; ?>

                    <?php
                    $dropdown_name     = '_customize-dropdown-pages-' . $this->id;
                    $show_option_none  = esc_html__( '&mdash; Select &mdash;', 'industrium' );
                    $option_none_value = '0';
                    $dropdown          = wp_dropdown_pages(
                        array(
                            'name'              => $dropdown_name,
                            'echo'              => 0,
                            'show_option_none'  => $show_option_none,
                            'option_none_value' => $option_none_value,
                            'selected'          => $this->value(),
                        )
                    );
                    if ( empty( $dropdown ) ) {
                        $dropdown  = sprintf( '<select id="%1$s" name="%1$s">', esc_attr( $dropdown_name ) );
                        $dropdown .= sprintf( '<option value="%1$s">%2$s</option>', esc_attr( $option_none_value ), esc_html( $show_option_none ) );
                        $dropdown .= '</select>';
                    }

                    $dropdown = str_replace( '<select', '<select ' . $this->get_link() . ' id="' . esc_attr( $input_id ) . '" ' . $describedby_attr, $dropdown );
                    $nav_menus_created_posts_setting = $this->manager->get_setting( 'nav_menus_created_posts' );
                    if ( $nav_menus_created_posts_setting && current_user_can( 'publish_pages' ) ) {
                        $auto_draft_page_options = '';
                        foreach ( $nav_menus_created_posts_setting->value() as $auto_draft_page_id ) {
                            $post = get_post( $auto_draft_page_id );
                            if ( $post && 'page' === $post->post_type ) {
                                $auto_draft_page_options .= sprintf( '<option value="%1$s">%2$s</option>', esc_attr( $post->ID ), esc_html( $post->post_title ) );
                            }
                        }
                        if ( $auto_draft_page_options ) {
                            $dropdown = str_replace( '</select>', $auto_draft_page_options . '</select>', $dropdown );
                        }
                    }

                    echo sprinf('%s', $dropdown);
                    ?>
                    <?php if ( $this->allow_addition && current_user_can( 'publish_pages' ) && current_user_can( 'edit_theme_options' ) ) : // Currently tied to menus functionality. ?>
                    <button type="button" class="button-link add-new-toggle">
                        <?php
                        /* translators: %s: Add New Page label. */
                        printf( esc_html__( '+ %s', 'industrium' ), get_post_type_object( 'page' )->labels->add_new_item );
                        ?>
                    </button>
                    <div class="new-content-item">
                        <label for="create-input-<?php echo esc_attr($this->id); ?>"><span class="screen-reader-text"><?php esc_html_e( 'New page title', 'industrium' ); ?></span></label>
                        <input type="text" id="create-input-<?php echo esc_attr($this->id); ?>" class="create-item-input" placeholder="<?php esc_attr_e( 'New page title&hellip;', 'industrium'
                        ); ?>">
                        <button type="button" class="button add-content"><?php _e( 'Add', 'industrium' ); ?></button>
                    </div>
                <?php endif; ?>
                    <?php
                    break;
                default:
                    ?>
                    <?php if ( ! empty( $this->label ) ) : ?>
                        <label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
                    <?php endif; ?>
                    <?php if ( ! empty( $this->description ) ) : ?>
                        <span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo wp_kses($this->description, $allowed_html); ?></span>
                    <?php endif; ?>
                    <input
                            id="<?php echo esc_attr( $input_id ); ?>"
                            type="<?php echo esc_attr( $this->type ); ?>"
                        <?php echo sprintf('%s', $describedby_attr); ?>
                        <?php $this->input_attrs(); ?>
                        <?php if ( ! isset( $this->input_attrs['value'] ) ) : ?>
                            value="<?php echo esc_attr( $this->value() ); ?>"
                        <?php endif; ?>
                        <?php $this->link(); ?>
                    />
                    <?php
                    break;
            }

        }
    }

// Register Separator Control
    class Industrium_Customize_Separator_Control extends Industrium_Customize_Control{
        public $type        = 'separator';

        public function render_content(){
            echo '<div class="customize-control-content">';
                echo '<div class="customize-separator"></div>';
            echo '</div>';
        }
    }

// Register Resolution Control
    class Industrium_Customize_Resolution_Control extends Industrium_Customize_Control{
        public $type        = 'resolution';

        public function render_content(){
            $description_id = '_customize-description-' . esc_attr($this->id);
            $input_id       = '_customize-input-' . esc_attr($this->id);
            $allowed_html   = array(
                'a'         => array(
                    'href'      => true,
                    'title'     => true,
                    'class'     => true,
                    'target'    => true
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'i'         => array(
                    'class'     => true
                ),
                'span'      => array(
                    'class'     => true
                ),
                'code'      => array()
            );
            $values         = json_decode( $this->value(), true );

            if ( !empty( $this->label ) ) {
                echo '<label for="' . esc_attr( $input_id ) . '_width" class="customize-control-title">' . esc_html($this->label) . '</label>';
            }

            if ( !empty( $this->description ) ) {
                echo '<span id="' . esc_attr( $description_id ) . '" class="description customize-control-description">' . wp_kses($this->description, $allowed_html) . '</span>';
            }

            echo '<div class="customize-control-content">'; ?>
                <input type="hidden" id="<?php echo esc_attr($input_id); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-resolution-values" <?php $this->link(); ?> />
                <span class="industrium-resolution-control">
                    <input type="number" step="1" pattern="\d*" size="4" value="<?php echo esc_attr($values['width']); ?>" placeholder="<?php esc_attr_e('Width', 'industrium'); ?>" id="<?php
                        echo esc_attr($input_id) . '_width'; ?>" aria-describedby="<?php echo esc_attr($description_id); ?>" class="resolution-value-width" />
                    <input type="number" step="1" pattern="\d*" size="4" value="<?php echo esc_attr($values['height']); ?>" placeholder="<?php esc_attr_e('Height', 'industrium'); ?>"
                           id="<?php echo esc_attr($input_id) . '_height'; ?>" aria-describedby="<?php echo esc_attr($description_id); ?>" class="resolution-value-height" />
                </span>
            <?php echo '</div>';
        }
    }

// Register Dimensions Control
    class Industrium_Customize_Dimensions_Control extends Industrium_Customize_Control{
        public $type                = 'dimensions';
        public $show_field          = [
            'top'       => false,
            'right'     => false,
            'bottom'    => false,
            'left'      => false
        ];

        public function render_content(){
            $description_id = '_customize-description-' . esc_attr($this->id);
            $input_id       = '_customize-input-' . esc_attr($this->id);
            $allowed_html   = array(
                'a'         => array(
                    'href'      => true,
                    'title'     => true,
                    'class'     => true,
                    'target'    => true
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'i'         => array(
                    'class'     => true
                ),
                'span'      => array(
                    'class'     => true
                ),
                'code'      => array()
            );

            $unit_list      = industrium_get_unit_options();
            $values         = json_decode( $this->value(), true );

            if ( !empty( $this->label ) ) {
                echo '<label for="' . esc_attr( $input_id ) . '_top" class="customize-control-title">' . esc_html($this->label) . '</label>';
            }
            if ( !empty( $this->description ) ) {
                echo '<span id="' . esc_attr( $description_id ) . '" class="description customize-control-description">' . wp_kses($this->description, $allowed_html) . '</span>';
            }
            echo '<div class="customize-control-content">'; ?>
                <input type="hidden" id="<?php echo esc_attr($input_id); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-dimensions-values" <?php $this->link(); ?> />
                <span class="industrium-dimensions-control">
                    <span class="industrium-dimensions-values">
                        <?php if ( $this->show_field['top'] ) { ?>
                            <input type="number" step="1" pattern="\d*" size="4" value="<?php echo esc_attr( $values['top'] ); ?>" placeholder="<?php esc_attr_e('Top', 'industrium'); ?>"
                                   id="<?php echo esc_attr($input_id) . '_top'; ?>" aria-describedby="<?php echo esc_attr($description_id); ?>" class="dimensions-value-top" />
                        <?php } ?>
                        <?php if ( $this->show_field['right'] ) { ?>
                            <input type="number" step="1" pattern="\d*" size="4" value="<?php echo esc_attr( $values['right'] ); ?>" placeholder="<?php esc_attr_e('Right', 'industrium'); ?>" id="<?php echo esc_attr($input_id) . '_right'; ?>" aria-describedby="<?php echo esc_attr($description_id); ?>" class="dimensions-value-right" />
                        <?php } ?>
                        <?php if ( $this->show_field['bottom'] ) { ?>
                            <input type="number" step="1" pattern="\d*" size="4" value="<?php echo esc_attr( $values['bottom'] ); ?>" placeholder="<?php esc_attr_e('Bottom', 'industrium'); ?>" id="<?php echo esc_attr($input_id) . '_bottom'; ?>" aria-describedby="<?php echo esc_attr($description_id); ?>" class="dimensions-value-bottom" />
                        <?php } ?>
                        <?php if ( $this->show_field['left'] ) { ?>
                            <input type="number" step="1" pattern="\d*" size="4" value="<?php echo esc_attr( $values['left'] ); ?>" placeholder="<?php esc_attr_e('Left', 'industrium'); ?>" id="<?php echo esc_attr($input_id) . '_left'; ?>" aria-describedby="<?php echo esc_attr($description_id); ?>" class="dimensions-value-left" />
                        <?php } ?>
                    </span>
                    <select class="industrium-dimensions-unit dimensions-value-unit" id="<?php echo esc_attr($input_id) . '_unit'; ?>">
                        <?php
                        foreach ( $unit_list as $value => $label ) {
                            echo '<option value="' . esc_attr($value) . '"' . selected($values['unit'], $value, false ) . '>' . esc_html($label) . '</option>';
                        }
                        ?>
                    </select>
                </span>
            <?php echo '</div>';
        }
    }

// Register Notice Control
    class Industrium_Customize_Notice_Control extends Industrium_Customize_Control {
        public $type        = 'notice';

        public function render_content() {
            $description_id = '_customize-description-' . esc_attr($this->id);
            $allowed_html   = array(
                'a'         => array(
                    'href'      => true,
                    'title'     => true,
                    'class'     => true,
                    'target'    => true
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'i'         => array(
                    'class'     => true
                ),
                'span'      => array(
                    'class'     => true
                ),
                'code'      => array()
            );

            if ( !empty( $this->label ) ) {
                echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
            }

            if ( !empty( $this->description ) ) {
                echo '<span id="' . esc_attr( $description_id ) . '" class="description customize-control-description customize-control-notice">' . wp_kses( $this->description, $allowed_html ) . '</span>';
            }
        }
    }

// Register Google Font Control
    class Industrium_Customize_Google_Font_Control extends Industrium_Customize_Control {
        public $type                = 'google-font';
        public $show_field          = [
            'font_family'       => false,
            'font_backup'       => false,
            'font_styles'       => false,
            'font_subset'       => false,
            'font_size'         => false,
            'line_height'       => false,
            'text_transform'    => false,
            'letter_spacing'    => false,
            'word_spacing'      => false,
            'font_style'        => false,
            'font_weight'       => false
        ];

        private $fontList           = false;

        public function __construct( $manager, $id, $args = array() ) {
            parent::__construct( $manager, $id, $args );
            global $industrium_fonts_array;
            $this->fontList = $industrium_fonts_array;
        }

        public function to_json() {
            parent::to_json();
            $this->json['googlefontlist'] = $this->fontList;
        }

        public function enqueue() {
            wp_enqueue_script('select2-js', get_template_directory_uri() . '/js/select2.min.js', array('jquery'), '1.0', true );
            wp_enqueue_style( 'select2-style', get_template_directory_uri() . '/css/select2.css' );
            wp_enqueue_script( 'industrium-customizer-js', get_template_directory_uri() . '/js/customizer.js', array('jquery', 'select2-js'), '1.0', true );
        }

        public function render_content(){
            $description_id = '_customize-description-' . esc_attr($this->id);
            $input_id       = '_customize-input-' . esc_attr($this->id);
            $allowed_html   = array(
                'a'         => array(
                    'href'      => true,
                    'title'     => true,
                    'class'     => true,
                    'target'    => true
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'i'         => array(
                    'class'     => true
                ),
                'span'      => array(
                    'class'     => true
                ),
                'code'      => array()
            );
            $unit_list                  = industrium_get_unit_options();
            $font_list                  = industrium_get_all_font_names();
            $values                     = json_decode( $this->value(), true );
            $font_backup_list           = industrium_get_backup_fonts();
            $font_text_transform_list   = industrium_get_text_transform_options();
            $font_style_list            = industrium_get_font_style_options();
            if ( isset($this->show_field['font_family']) && $this->show_field['font_family'] ) {
                $font_styles_options_list   = industrium_get_current_font_weight_options($values['font_family']);
                $font_subset_list           = industrium_get_current_font_subset_options($values['font_family']);
            }

            if ( !empty( $this->label ) ) {
                echo '<label for="' . esc_attr($input_id) . '_font_family" class="customize-control-title">' . esc_html($this->label) . '</label>';
            }
            if ( !empty( $this->description ) ) {
                echo '<span id="' . esc_attr( $description_id ) . '" class="description customize-control-description">' . wp_kses($this->description, $allowed_html) . '</span>';
            }
            echo '<div class="customize-control-content">'; ?>
                <span class="industrium-google-font-control">
                    <input type="hidden" id="<?php echo esc_attr($input_id);  ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-font-values" <?php $this->link(); ?> />

                    <?php if ( isset($this->show_field['font_family']) && $this->show_field['font_family'] ) { ?>
                        <span class="industrium-google-font-field">
                            <span class="industrium-google-font-field-label"><?php esc_html_e('Font Family', 'industrium') ?></span>
                            <select class="industrium-google-fonts-list font-value-font-family" id="<?php echo esc_attr($input_id) . '_font_family'; ?>" data-name="<?php echo esc_attr( $this->id ); ?>">
                                <?php
                                    foreach ($font_list as $key => $font_name) {
                                        echo '<option value="' . esc_attr($font_name) . '" ' . selected($values['font_family'], $font_name, false) . '>' . esc_html($font_name) . '</option>';
                                    }
                                ?>
                            </select>
                        </span>
                    <?php } ?>

                    <?php if (
                        ( isset($this->show_field['font_backup']) && $this->show_field['font_backup'] ) &&
                        ( isset($this->show_field['font_family']) && $this->show_field['font_family'] )
                    ) { ?>
                        <span class="industrium-google-font-field">
                            <span class="industrium-google-font-field-label"><?php esc_html_e('Backup Font Family', 'industrium') ?></span>
                            <select id="<?php echo esc_attr($input_id) . '_font_backup'; ?>" class="font-value-font-backup">
                                <?php
                                    foreach ($font_backup_list as $key => $font_name) {
                                        echo '<option value="' . esc_attr($font_name) . '" ' . selected($values['font_backup'], $font_name, false) . '>' . esc_html($font_name) . '</option>';
                                    }
                                ?>
                            </select>
                        </span>
                    <?php } ?>

                    <?php if (
                        ( isset($this->show_field['font_styles']) && $this->show_field['font_styles'] ) &&
                        ( isset($this->show_field['font_family']) && $this->show_field['font_family'] )
                    ) {
                        $defaultValue = !empty($values['font_styles']) ? explode( ',', $values['font_styles'] ) : $font_styles_options_list;
                        ?>
                        <span class="industrium-google-font-field">
                            <span class="industrium-google-font-field-label"><?php esc_html_e('Font Styles', 'industrium') ?></span>
                            <span class="dropdown_select2_control">
                                <input type="hidden" id="<?php echo esc_attr($input_id) . '_font_styles'; ?>" class="customize-control-dropdown-select2 font-value-font-styles" value="<?php echo esc_attr($values['font_styles']); ?>" name="<?php echo esc_attr($input_id) . '_font_styles'; ?>" />
                                <select name="select2-list-multi[]" class="customize-control-select2 industrium-google-font-styles" data-placeholder="" multiple="multiple" id="select2-<?php echo esc_attr($input_id) . '_font_styles'; ?>">
                                    <?php
                                        foreach ( $font_styles_options_list as $key => $font_style ) {
                                            $font_style_name = str_replace('100', 'Thin 100 ', $font_style);
                                            $font_style_name = str_replace('200', 'Extra-Light 200 ', $font_style_name);
                                            $font_style_name = str_replace('300', 'Light 300 ', $font_style_name);
                                            $font_style_name = str_replace('400', 'Regular 400 ', $font_style_name);
                                            $font_style_name = str_replace('500', 'Medium 500 ', $font_style_name);
                                            $font_style_name = str_replace('600', 'Semi-Bold 600 ', $font_style_name);
                                            $font_style_name = str_replace('700', 'Bold 700 ', $font_style_name);
                                            $font_style_name = str_replace('800', 'Extra-Bold 800 ', $font_style_name);
                                            $font_style_name = str_replace('900', 'Black 900 ', $font_style_name);

                                            $font_style_name = str_replace('regular', 'Regular 400 ', $font_style_name);
                                            $font_style_name = str_replace('italic', 'Italic ', $font_style_name);
                                            $font_style_name = trim($font_style_name);

                                            $font_style = str_replace('regular', '400', $font_style);
                                            if ( is_array( $font_style ) ) {
                                                echo '<optgroup label="' . esc_attr( $key ) . '">';
                                                foreach ( $font_style as $optgroupkey => $optgroupvalue ) {
                                                    echo '<option value="' . esc_attr( $optgroupkey ) . '" ' . ( in_array( esc_attr($optgroupkey), $defaultValue ) ? 'selected="selected"' : '' ) . '>' . esc_attr( $optgroupvalue ) . '</option>';
                                                }
                                                echo '</optgroup>';
                                            } else {
                                                echo '<option value="' . esc_attr($font_style) . '" ' . ( in_array( esc_attr($font_style), $defaultValue ) ? 'selected="selected"' : '' ) . '>' . esc_attr($font_style_name) . '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </span>
                        </span>
                    <?php } ?>

                    <?php if (
                        ( isset($this->show_field['font_subset']) && $this->show_field['font_subset'] ) &&
                        ( isset($this->show_field['font_family']) && $this->show_field['font_family'] )
                    ) {
                        $defaultValue = !empty($values['font_subset']) ? explode( ',', $values['font_subset'] ) : $font_subset_list;
                        ?>
                        <span class="industrium-google-font-field">
                            <span class="industrium-google-font-field-label"><?php esc_html_e('Font Subsets', 'industrium') ?></span>
                            <span class="dropdown_select2_control">
                                <input type="hidden" id="<?php echo esc_attr($input_id) . '_font_subset'; ?>" class="customize-control-dropdown-select2 font-value-font-subset" value="<?php echo esc_attr($values['font_subset']); ?>" name="<?php echo esc_attr($input_id) . '_font_subset'; ?>" />
                                <select name="select2-list-multi[]" class="customize-control-select2 industrium-google-font-subset" data-placeholder="" multiple="multiple" id="select2-<?php echo esc_attr($input_id) . '_font_subset'; ?>">
                                    <?php
                                    foreach ( $font_subset_list as $key => $current_font_subset ) {
                                        $font_subset_name = str_replace('-ext',  ' Extended', $current_font_subset);
                                        $font_subset_name = str_replace('-',  ' ', $font_subset_name);
                                        $font_subset_name = ucwords($font_subset_name);

                                        if ( is_array( $current_font_subset ) ) {
                                            echo '<optgroup label="' . esc_attr( $key ) . '">';
                                            foreach ( $current_font_subset as $optgroupkey => $optgroupvalue ) {
                                                echo '<option value="' . esc_attr( $optgroupkey ) . '" ' . ( in_array( esc_attr($optgroupkey), $defaultValue ) ? 'selected="selected"' : '' ) . '>' . esc_attr( $optgroupvalue ) . '</option>';
                                            }
                                            echo '</optgroup>';
                                        } else {
                                            echo '<option value="' . esc_attr($current_font_subset) . '" ' . ( in_array( esc_attr($current_font_subset), $defaultValue ) ? 'selected="selected"' : '' ) . '>' . esc_attr($font_subset_name) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </span>
                        </span>
                    <?php } ?>

                    <?php if ( isset($this->show_field['text_transform']) && $this->show_field['text_transform'] ) { ?>
                        <span class="industrium-google-font-field">
                            <span class="industrium-google-font-field-label"><?php esc_html_e('Text Transform', 'industrium') ?></span>
                            <select id="<?php echo esc_attr($input_id) . '_text_transform'; ?>" class="font-value-text-transform">
                                <?php
                                    foreach ($font_text_transform_list as $key => $current_text_transform) {
                                        echo '<option value="' . esc_attr($key) . '" ' . selected($values['text_transform'], $key, false) . '>' . esc_html($current_text_transform) . '</option>';
                                    }
                                ?>
                            </select>
                        </span>
                    <?php } ?>

                    <?php if ( isset($this->show_field['font_size']) && $this->show_field['font_size'] ) { ?>
                        <span class="industrium-google-font-field">
                            <span class="industrium-google-font-field-label"><?php esc_html_e('Font Size', 'industrium'); ?></span>
                            <span class="industrium-google-font-field-control">
                                <input type="number" min="0" pattern="\d*" size="5" value="<?php echo esc_attr( $values['font_size'] ); ?>" id="<?php echo esc_attr($input_id) . '_font_size'; ?>" aria-describedby="<?php echo esc_attr($description_id); ?>" class="font-value-font-size" />
                                <select class="industrium-font-unit font-value-font-size-unit" id="<?php echo esc_attr($input_id) . '_font_size_unit'; ?>">
                                    <?php
                                        foreach ( $unit_list as $value => $label ) {
                                            echo '<option value="' . esc_attr($value) . '"' . selected($values['font_size_unit'], $value, false ) . '>' . esc_html($label) . '</option>';
                                        }
                                    ?>
                                </select>
                            </span>
                        </span>
                    <?php } ?>

                    <?php if ( isset($this->show_field['line_height']) && $this->show_field['line_height'] ) { ?>
                        <span class="industrium-google-font-field">
                            <span class="industrium-google-font-field-label"><?php esc_html_e('Line Height', 'industrium'); ?></span>
                            <span class="industrium-google-font-field-control">
                                <input type="number" min="0" pattern="\d*" size="5" value="<?php echo esc_attr( $values['line_height'] ); ?>" id="<?php echo esc_attr($input_id) . '_line_height'; ?>" aria-describedby="<?php echo esc_attr($description_id); ?>" class="font-value-line-height" />
                                <select class="industrium-font-unit font-value-line-height-unit" id="<?php echo esc_attr($input_id) . '_line_height_unit'; ?>">
                                    <?php
                                    foreach ( $unit_list as $value => $label ) {
                                        echo '<option value="' . esc_attr($value) . '"' . selected($values['line_height_unit'], $value, false ) . '>' . esc_html($label) . '</option>';
                                    }
                                    ?>
                                </select>
                            </span>
                        </span>
                    <?php } ?>

                    <?php if (isset($this->show_field['letter_spacing']) &&  $this->show_field['letter_spacing'] ) { ?>
                        <span class="industrium-google-font-field">
                            <span class="industrium-google-font-field-label"><?php esc_html_e('Letter Spacing', 'industrium'); ?></span>
                            <span class="industrium-google-font-field-control">
                                <input type="number" pattern="\d*" size="5" step="0.01" value="<?php echo esc_attr( $values['letter_spacing'] ); ?>" id="<?php echo esc_attr($input_id) . '_letter_spacing'; ?>" aria-describedby="<?php echo esc_attr($description_id); ?>" class="font-value-letter-spacing" />
                                <select class="industrium-font-unit font-value-letter-spacing-unit" id="<?php echo esc_attr($input_id) . '_letter_spacing_unit'; ?>">
                                    <?php
                                    foreach ( $unit_list as $value => $label ) {
                                        echo '<option value="' . esc_attr($value) . '"' . selected($values['letter_spacing_unit'], $value, false ) . '>' . esc_html($label) . '</option>';
                                    }
                                    ?>
                                </select>
                            </span>
                        </span>
                    <?php } ?>

                    <?php if ( isset($this->show_field['word_spacing']) && $this->show_field['word_spacing'] ) { ?>
                        <span class="industrium-google-font-field">
                            <span class="industrium-google-font-field-label"><?php esc_html_e('Word Spacing', 'industrium'); ?></span>
                            <span class="industrium-google-font-field-control">
                                <input type="number" pattern="\d*" size="3" step="0.1" value="<?php echo esc_attr( $values['word_spacing'] ); ?>" id="<?php echo esc_attr($input_id) . '_word_spacing'; ?>" aria-describedby="<?php echo esc_attr($description_id); ?>" class="font-value-word-spacing" />
                                <select class="industrium-font-unit font-value-word-spacing-unit" id="<?php echo esc_attr($input_id) . '_word_spacing_unit'; ?>">
                                    <?php
                                    foreach ( $unit_list as $value => $label ) {
                                        echo '<option value="' . esc_attr($value) . '"' . selected($values['word_spacing_unit'], $value, false ) . '>' . esc_html($label) . '</option>';
                                    }
                                    ?>
                                </select>
                            </span>
                        </span>
                    <?php } ?>

                    <?php if ( isset($this->show_field['font_style']) && $this->show_field['font_style'] ) { ?>
                        <span class="industrium-google-font-field">
                            <span class="industrium-google-font-field-label"><?php esc_html_e('Font Style', 'industrium') ?></span>
                            <select id="<?php echo esc_attr($input_id) . '_font_style'; ?>" class="font-value-font-style">
                                <?php
                                foreach ($font_style_list as $key => $current_style) {
                                    echo '<option value="' . esc_attr($key) . '" ' . selected($values['font_style'], $key, false) . '>' . esc_html($current_style) . '</option>';
                                }
                                ?>
                            </select>
                        </span>
                    <?php } ?>

                    <?php if ( isset($this->show_field['font_weight']) && $this->show_field['font_weight'] ) {
                        $defaultValue = !empty($values['font_weight']) ? explode( ',', $values['font_weight'] ) : '';
                        ?>
                        <span class="industrium-google-font-field">
                            <span class="industrium-google-font-field-label"><?php esc_html_e('Font Weight', 'industrium') ?></span>
                            <select id="<?php echo esc_attr($input_id) . '_font_weight'; ?>" class="font-value-font-weight">
                                    <?php
                                    if ( isset($this->show_field['font_family']) && $this->show_field['font_family'] ) {
                                        foreach ( $font_styles_options_list as $key => $font_weight ) {
                                            $font_weight = str_replace('regular', '400', $font_weight);
                                            $font_weight = trim($font_weight);

                                            if ( ctype_digit($font_weight) ) {
                                                echo '<option value="' . esc_attr($font_weight) . '" ' . ( in_array( esc_attr($font_weight), $defaultValue ) ? 'selected="selected"' : '' ) . '>' . esc_attr($font_weight) . '</option>';
                                            }
                                        }
                                    } else {
                                        $font_weight_options_list = industrium_get_font_weight_options();
                                        foreach ( $font_weight_options_list as $key => $font_weight ) {
                                            if ( ctype_digit($font_weight) ) {
                                                echo '<option value="' . esc_attr($font_weight) . '" ' . ( in_array( esc_attr($font_weight), $defaultValue ) ? 'selected="selected"' : '' ) . '>' . esc_attr($font_weight) . '</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </span>
                        </span>
                    <?php } ?>

                </span>
            <?php echo '</div>';

            if ( isset($this->show_field['font_family']) && $this->show_field['font_family'] == true ) {
                $current_fonts_array = get_theme_mod('current_fonts');
                if(!is_array($current_fonts_array)) {
                    $current_fonts_array = array();
                }
                if ( !in_array($this->id, $current_fonts_array) ) {
                    $current_fonts_array[] = $this->id;
                    set_theme_mod('current_fonts', $current_fonts_array);
                }
            }
        }
    }

// Register Social Icons Repeater Control
    class Industrium_Customize_Socials_Control extends Industrium_Customize_Control {

        public $id;
        private $boxtitle                               = array();
        private $add_field_label                        = array();
        private $customizer_icon_container              = '';
        private $allowed_html                           = array();

        /*Class constructor*/
        public function __construct( $manager, $id, $args = array() ) {
            parent::__construct( $manager, $id, $args );
            $this->add_field_label = esc_html__('Add new field', 'industrium');
            if ( ! empty( $args['add_field_label'] ) ) {
                $this->add_field_label = $args['add_field_label'];
            }

            $this->boxtitle = esc_html__( 'Customizer Socials', 'industrium');
            if ( ! empty ( $args['item_name'] ) ) {
                $this->boxtitle = $args['item_name'];
            } elseif ( ! empty( $this->label ) ) {
                $this->boxtitle = $this->label;
            }

            if ( ! empty( $args['customizer_repeater_icon_control'] ) ) {
                $this->customizer_repeater_icon_control = $args['customizer_repeater_icon_control'];
            }

            if ( ! empty( $args['customizer_repeater_title_control'] ) ) {
                $this->customizer_repeater_title_control = $args['customizer_repeater_title_control'];
            }

            if ( ! empty( $args['customizer_repeater_link_control'] ) ) {
                $this->customizer_repeater_link_control = $args['customizer_repeater_link_control'];
            }

            if ( ! empty( $id ) ) {
                $this->id = $id;
            }

            $icons = industrium_get_fa_brands_icons();
            sort( $icons );
            $icon_container = industrium_icon_picker_popover(true);
            $this->customizer_icon_container = $icon_container;

            $allowed_array1 = wp_kses_allowed_html( 'post' );
            $allowed_array2 = array(
                'input' => array(
                    'type'        => array(),
                    'class'       => array(),
                    'placeholder' => array()
                )
            );

            $this->allowed_html = array_merge( $allowed_array1, $allowed_array2 );
        }

        /*Enqueue resources for the control*/
        public function enqueue() {
            wp_enqueue_script( 'customizer-repeater-fontawesome-iconpicker', get_template_directory_uri() . '/js/fontawesome-iconpicker.min.js', array( 'jquery' ), '1.0', true );
            wp_enqueue_script( 'industrium-customizer-js', get_template_directory_uri() . '/js/customizer.js', array('jquery-ui-draggable'), '1.0', true );
        }

        public function render_content() {
            $description_id = '_customize-description-' . $this->id;
            $allowed_html   = array(
                'a'         => array(
                    'href'      => true,
                    'title'     => true,
                    'class'     => true,
                    'target'    => true
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'i'         => array(
                    'class'     => true
                ),
                'span'      => array(
                    'class'     => true
                ),
                'code'      => array()
            );

            /*Get default options*/
            $this_default = json_decode( $this->setting->default );

            /*Get values (json format)*/
            $values = $this->value();

            /*Decode values*/
            $json = json_decode( $values );

            if ( ! is_array( $json ) ) {
                $json = array( $values );
            }

            if ( !empty( $this->label ) ) {
                echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
            }
            if ( !empty( $this->description ) ) {
                echo '<span id="' . esc_attr( $description_id ) . '" class="description customize-control-description">' . wp_kses($this->description, $allowed_html) . '</span>';
            }
            ?>

            <div class="customizer-repeater-general-control-repeater customizer-repeater-general-control-droppable">
            <?php
                if ( ( count( $json ) == 1 && '' === $json[0] ) || empty( $json ) ) {
                    if ( ! empty( $this_default ) ) {
                        $this->iterate_array( $this_default ); ?>
                        <input type="hidden"
                            id="customizer-repeater-<?php echo esc_attr( $this->id ); ?>-colector" <?php esc_attr( $this->link() ); ?>
                            class="customizer-repeater-colector"
                            value="<?php echo esc_textarea( json_encode( $this_default ) ); ?>"/>
                        <?php
                    } else {
                        $this->iterate_array(); ?>
                        <input type="hidden"
                            id="customizer-repeater-<?php echo esc_attr( $this->id ); ?>-colector" <?php esc_attr( $this->link() ); ?>
                            class="customizer-repeater-colector"/>
                        <?php
                    }
                } else {
                    $this->iterate_array( $json ); ?>
                    <input type="hidden"
                        id="customizer-repeater-<?php echo esc_attr( $this->id ); ?>-colector" <?php esc_attr( $this->link() ); ?>
                        class="customizer-repeater-colector" value="<?php echo esc_textarea( $this->value() ); ?>"/>
                    <?php
                } ?>
            </div>
            <button type="button" class="button add_field customizer-repeater-new-field">
                <?php echo esc_html( $this->add_field_label ); ?>
            </button>
            <?php
        }

        private function iterate_array($array = array()){
            /*Counter that helps checking if the box is first and should have the delete button disabled*/
            $it = 0;
            if( !empty($array) ){
                foreach( $array as $icon ){
                    $icon_value = $title = $link = '';
                    if(!empty($icon->id)){
                        $id = $icon->id;
                    }
                    if(!empty($icon->icon_value)){
                        $icon_value = $icon->icon_value;
                    }
                    if(!empty($icon->title)){
                        $title = $icon->title;
                    }
                    if(!empty($icon->link)){
                        $link = $icon->link;
                    }
                    ?>
                    <div class="customizer-repeater-general-control-repeater-container customizer-repeater-draggable">
                        <div class="customizer-repeater-customize-control-title">
                            <?php echo ( !empty($icon->title) ? esc_html($icon->title) : esc_html__( 'New Item', 'industrium' ) ); ?>
                        </div>
                        <div class="customizer-repeater-box-content-hidden">
                            <?php
                                $this->icon_picker_control($icon_value);
                                $this->input_control(array(
                                    'label' => apply_filters('repeater_input_labels_filter', esc_html__( 'Title','industrium'), $this->id, 'customizer_repeater_title_control' ),
                                    'class' => 'customizer-repeater-title-control',
                                    'type'  => apply_filters('customizer_repeater_input_types_filter', '', $this->id, 'customizer_repeater_title_control' ),
                                ), $title);
                                $this->input_control(array(
                                    'label' => apply_filters('repeater_input_labels_filter', esc_html__( 'Link','industrium'), $this->id, 'customizer_repeater_link_control' ),
                                    'class' => 'customizer-repeater-link-control',
                                    'sanitize_callback' => 'esc_url_raw',
                                    'type'  => apply_filters('customizer_repeater_input_types_filter', '', $this->id, 'customizer_repeater_link_control' ),
                                ), $link);
                            ?>

                            <input type="hidden" class="social-repeater-box-id" value="<?php if ( ! empty( $id ) ) {
                                echo esc_attr( $id );
                            } ?>">
                            <button type="button" class="social-repeater-general-control-remove-field" <?php if ( $it == 0 ) {
                                echo 'style="display:none;"';
                            } ?>>
                                <?php esc_html_e( 'Delete field', 'industrium'); ?>
                            </button>

                        </div>
                    </div>

                    <?php
                    $it++;
                }
            } else { ?>
                <div class="customizer-repeater-general-control-repeater-container">
                    <div class="customizer-repeater-customize-control-title">
                        <?php esc_html_e( 'New Item', 'industrium' ); ?>
                    </div>
                    <div class="customizer-repeater-box-content-hidden">
                        <?php
                            $this->icon_picker_control();

                            $this->input_control( array(
                                'label' => apply_filters('repeater_input_labels_filter', esc_html__( 'Title','industrium'), $this->id, 'customizer_repeater_title_control' ),
                                'class' => 'customizer-repeater-title-control',
                                'type'  => apply_filters('customizer_repeater_input_types_filter', '', $this->id, 'customizer_repeater_title_control' ),
                            ) );

                            $this->input_control( array(
                                'label' => apply_filters('repeater_input_labels_filter', esc_html__( 'Link','industrium'), $this->id, 'customizer_repeater_link_control' ),
                                'class' => 'customizer-repeater-link-control',
                                'type'  => apply_filters('customizer_repeater_input_types_filter', '', $this->id, 'customizer_repeater_link_control' ),
                            ) );
                        ?>
                        <input type="hidden" class="social-repeater-box-id">
                        <button type="button" class="social-repeater-general-control-remove-field button" style="display:none;">
                            <?php esc_html_e( 'Delete field', 'industrium'); ?>
                        </button>
                    </div>
                </div>
                <?php
            }
        }

        private function input_control( $options, $value='' ){
            ?>
                <span class="customize-control-title"><?php echo esc_html( $options['label'] ); ?></span>
                <input type="text" value="<?php echo ( !empty($options['sanitize_callback']) ?  call_user_func_array( $options['sanitize_callback'], array( $value ) ) : esc_attr($value) ); ?>" class="<?php echo esc_attr($options['class']); ?>" placeholder="<?php echo esc_attr( $options['label'] ); ?>"/>
            <?php
        }

        private function icon_picker_control($value = '', $show = ''){ ?>
            <div class="social-repeater-general-control-icon" <?php if( $show === 'customizer_repeater_image' || $show === 'customizer_repeater_none' ) { echo 'style="display:none;"'; } ?>>
                <span class="customize-control-title">
                    <?php esc_html_e('Icon','industrium'); ?>
                </span>

                <div class="input-group icp-container">
                    <input data-placement="bottomRight" class="icp icp-auto" value="<?php if(!empty($value)) { echo esc_attr( $value );} ?>" type="text" readonly>
                    <span class="input-group-addon">
                        <i class="fab <?php echo esc_attr($value); ?>"></i>
                    </span>
                </div>
                <?php echo sprintf('%s', $this->customizer_icon_container); ?>
            </div>
            <?php
        }
    }

// Register Radio Buttons with Image Control
    class Industrium_Customize_Imaged_Radio_Control extends Industrium_Customize_Control {
        public $type = 'image_radio_button';

        public function render_content() {
            $description_id = '_customize-description-' . esc_attr($this->id);
            $input_id       = '_customize-input-' . esc_attr($this->id);
            $allowed_html   = array(
                'a'         => array(
                    'href'      => true,
                    'title'     => true,
                    'class'     => true,
                    'target'    => true
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'i'         => array(
                    'class'     => true
                ),
                'span'      => array(
                    'class'     => true
                ),
                'code'      => array()
            );

            if ( !empty( $this->label ) ) {
                echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
            }

            if ( !empty( $this->description ) ) {
                echo '<span id="' . esc_attr( $description_id ) . '" class="description customize-control-description">' . wp_kses($this->description, $allowed_html) . '</span>';
            }
            ?>
            <div class="image_radio_button_control">
                <?php foreach ( $this->choices as $key => $value ) { ?>
                    <label class="radio-button-label">
                        <input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?> id="<?php echo esc_attr($input_id) . '-' . esc_attr($key) ; ?>" />
                        <img src="<?php echo esc_attr( $value['image'] ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>" title="<?php echo esc_attr( $value['name'] ); ?>" />
                    </label>
                <?php } ?>
            </div>
            <?php
        }
    }

// Register Select2 Control
    class Industrium_Customize_Select2_Control extends Industrium_Customize_Control {
        public $type            = 'dropdown-select2';
        private $multiselect    = false;
        private $placeholder    = '';

        public function __construct( $manager, $id, $args = array(), $options = array() ) {
            parent::__construct( $manager, $id, $args );
            if ( isset( $this->input_attrs['multiselect'] ) && $this->input_attrs['multiselect'] ) {
                $this->multiselect = true;
            }
            if ( isset( $this->input_attrs['placeholder'] ) && $this->input_attrs['placeholder'] ) {
                $this->placeholder = $this->input_attrs['placeholder'];
            } else {
                $this->placeholder = esc_attr__('Please select...', 'industrium');
            }
        }

        public function enqueue() {
            wp_enqueue_script('select2-js', get_template_directory_uri() . '/js/select2.min.js', array('jquery'), '1.0', true );
            wp_enqueue_style( 'select2-style', get_template_directory_uri() . '/css/select2.css' );
            wp_enqueue_script( 'industrium-customizer-js', get_template_directory_uri() . '/js/customizer.js', array( 'select2-js', 'jquery' ), '1.0', true );
        }

        public function render_content() {
            $defaultValue = $this->value();
            if ( $this->multiselect ) {
                $defaultValue = explode( ',', $this->value() );
            }
            $description_id = '_customize-description-' . esc_attr($this->id);
            $allowed_html   = array(
                'a'         => array(
                    'href'      => true,
                    'title'     => true,
                    'class'     => true,
                    'target'    => true
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'i'         => array(
                    'class'     => true
                ),
                'span'      => array(
                    'class'     => true
                ),
                'code'      => array()
            );

            if ( !empty( $this->label ) ) {
                echo '<label for="select2-' . esc_attr( $this->id ) . '" class="customize-control-title">' . esc_html($this->label) . '</label>';
            }

            if ( !empty( $this->description ) ) {
                echo '<span id="' . esc_attr( $description_id ) . '" class="description customize-control-description">' . wp_kses($this->description, $allowed_html) . '</span>';
            }
            ?>

            <div class="dropdown_select2_control">
                <input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" class="customize-control-dropdown-select2" value="<?php echo esc_attr( $this->value() ); ?>" name="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); ?> />
                <select name="select2-list-<?php echo ( ($this->multiselect) ? 'multi[]' : 'single' ); ?>" class="customize-control-select2" data-placeholder="<?php echo
                esc_attr($this->placeholder); ?>" <?php echo ( ($this->multiselect) ? 'multiple="multiple" ' : '' ); ?> id="select2-<?php echo esc_attr( $this->id ); ?>">
                    <?php
                    if ( !$this->multiselect ) {
                        echo '<option></option>';
                    }
                    foreach ( $this->choices as $key => $value ) {
                        if ( is_array( $value ) ) {
                            echo '<optgroup label="' . esc_attr( $key ) . '">';
                            foreach ( $value as $optgroupkey => $optgroupvalue ) {
                                if( $this->multiselect ){
                                    echo '<option value="' . esc_attr( $optgroupkey ) . '" ' . ( in_array( esc_attr( $optgroupkey ), $defaultValue ) ? 'selected="selected"' : '' ) . '>' . esc_attr( $optgroupvalue ) . '</option>';
                                } else {
                                    echo '<option value="' . esc_attr( $optgroupkey ) . '" ' . selected( esc_attr( $optgroupkey ), $defaultValue, false )  . '>' . esc_attr( $optgroupvalue ) . '</option>';
                                }
                            }
                            echo '</optgroup>';
                        } else {
                            if( $this->multiselect ){
                                echo '<option value="' . esc_attr( $key ) . '" ' . ( in_array( esc_attr( $key ), $defaultValue ) ? 'selected="selected"' : '' ) . '>' . esc_attr( $value ) . '</option>';
                            } else{
                                echo '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $key ), $defaultValue, false )  . '>' . esc_attr( $value ) . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
            </div>
            <?php
        }
    }

// Register Media Control
    class Industrium_Media_Custom_Control extends Industrium_Customize_Control {
        public $type            = 'media';
        public $mime_type       = '';
        public $button_labels   = array();
        public $visibility      = true;

        public function __construct( $manager, $id, $args = array() ) {
            parent::__construct( $manager, $id, $args );

            $this->button_labels    = wp_parse_args( $this->button_labels, $this->get_default_button_labels() );
            $this->visibility       = wp_parse_args( $this->visibility, $this->is_visible() );
        }

        public function enqueue() {
            wp_enqueue_media();
        }

        public function to_json() {
            parent::to_json();
            $this->json['label']         = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
            $this->json['mime_type']     = $this->mime_type;
            $this->json['button_labels'] = $this->button_labels;
            $this->json['visibility']    = $this->visibility;
            $this->json['canUpload']     = current_user_can( 'upload_files' );

            $value = $this->value();

            if ( is_object( $this->setting ) ) {
                if ( $this->setting->default ) {
                    // Fake an attachment model - needs all fields used by template.
                    // Note that the default value must be a URL, NOT an attachment ID.
                    $ext  = substr( $this->setting->default, -3 );
                    $type = in_array( $ext, array( 'jpg', 'png', 'gif', 'bmp' ), true ) ? 'image' : 'document';

                    $default_attachment = array(
                        'id'    => 1,
                        'url'   => $this->setting->default,
                        'type'  => $type,
                        'icon'  => wp_mime_type_icon( $type ),
                        'title' => wp_basename( $this->setting->default ),
                    );

                    if ( 'image' === $type ) {
                        $default_attachment['sizes'] = array(
                            'full' => array( 'url' => $this->setting->default ),
                        );
                    }

                    $this->json['defaultAttachment'] = $default_attachment;
                }

                if ( $value && $this->setting->default && $value === $this->setting->default ) {
                    // Set the default as the attachment.
                    $this->json['attachment'] = $this->json['defaultAttachment'];
                } elseif ( $value ) {
                    $this->json['attachment'] = wp_prepare_attachment_for_js( $value );
                }
            }
        }

        public function render_content() {}

        public function content_template() {
            ?>
            <#
            var descriptionId = _.uniqueId( 'customize-media-control-description-' );
            var describedByAttr = data.description ? ' aria-describedby="' + descriptionId + '" ' : '';
            #>

            <# if ( data.label ) { #>
            <span class="customize-control-title">{{ data.label }}</span>
            <# } #>
            <div class="customize-control-notifications-container"></div>
            <# if ( data.description ) { #>
            <span id="{{ descriptionId }}" class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>

            <# if ( data.attachment && data.attachment.id ) { #>
            <div class="attachment-media-view attachment-media-view-{{ data.attachment.type }} {{ data.attachment.orientation }}">
                <div class="thumbnail thumbnail-{{ data.attachment.type }}">
                    <# if ( 'image' === data.attachment.type && data.attachment.sizes && data.attachment.sizes.medium ) { #>
                    <img class="attachment-thumb" src="{{ data.attachment.sizes.medium.url }}" draggable="false" />
                    <# } else if ( 'image' === data.attachment.type && data.attachment.sizes && data.attachment.sizes.full ) { #>
                    <img class="attachment-thumb" src="{{ data.attachment.sizes.full.url }}" draggable="false" />
                    <# } else if ( 'audio' === data.attachment.type ) { #>
                    <# if ( data.attachment.image && data.attachment.image.src && data.attachment.image.src !== data.attachment.icon ) { #>
                    <img src="{{ data.attachment.image.src }}" class="thumbnail" draggable="false" />
                    <# } else { #>
                    <img src="{{ data.attachment.icon }}" class="attachment-thumb type-icon" draggable="false" />
                    <# } #>
                    <p class="attachment-meta attachment-meta-title">&#8220;{{ data.attachment.title }}&#8221;</p>
                    <# if ( data.attachment.album || data.attachment.meta.album ) { #>
                    <p class="attachment-meta"><em>{{ data.attachment.album || data.attachment.meta.album }}</em></p>
                    <# } #>
                    <# if ( data.attachment.artist || data.attachment.meta.artist ) { #>
                    <p class="attachment-meta">{{ data.attachment.artist || data.attachment.meta.artist }}</p>
                    <# } #>
                    <audio style="visibility: hidden" controls class="wp-audio-shortcode" width="100%" preload="none">
                        <source type="{{ data.attachment.mime }}" src="{{ data.attachment.url }}"/>
                    </audio>
                    <# } else if ( 'video' === data.attachment.type ) { #>
                    <div class="wp-media-wrapper wp-video">
                        <video controls="controls" class="wp-video-shortcode" preload="metadata"
                        <# if ( data.attachment.image && data.attachment.image.src !== data.attachment.icon ) { #>poster="{{ data.attachment.image.src }}"<# } #>>
                        <source type="{{ data.attachment.mime }}" src="{{ data.attachment.url }}"/>
                        </video>
                    </div>
                    <# } else { #>
                    <img class="attachment-thumb type-icon icon" src="{{ data.attachment.icon }}" draggable="false" />
                    <p class="attachment-title">{{ data.attachment.title }}</p>
                    <# } #>
                </div>
                <div class="actions">
                    <# if ( data.canUpload ) { #>
                    <button type="button" class="button remove-button">{{ data.button_labels.remove }}</button>
                    <button type="button" class="button upload-button control-focus" {{{ describedByAttr }}}>{{ data.button_labels.change }}</button>
                    <# } #>
                </div>
            </div>
            <# } else { #>
            <div class="attachment-media-view">
                <# if ( data.canUpload ) { #>
                <button type="button" class="upload-button button-add-media" {{{ describedByAttr }}}>{{ data.button_labels.select }}</button>
                <# } #>
                <div class="actions">
                    <# if ( data.defaultAttachment ) { #>
                    <button type="button" class="button default-button">{{ data.button_labels['default'] }}</button>
                    <# } #>
                </div>
            </div>
            <# } #>
            <?php
        }

        public function get_default_button_labels() {
            // Get just the mime type and strip the mime subtype if present.
            $mime_type = ! empty( $this->mime_type ) ? strtok( ltrim( $this->mime_type, '/' ), '/' ) : 'default';

            switch ( $mime_type ) {
                case 'video':
                    return array(
                        'select'       => esc_html__( 'Select video', 'industrium' ),
                        'change'       => esc_html__( 'Change video', 'industrium' ),
                        'default'      => esc_html__( 'Default', 'industrium' ),
                        'remove'       => esc_html__( 'Remove', 'industrium' ),
                        'placeholder'  => esc_html__( 'No video selected', 'industrium' ),
                        'frame_title'  => esc_html__( 'Select video', 'industrium' ),
                        'frame_button' => esc_html__( 'Choose video', 'industrium' ),
                    );
                case 'audio':
                    return array(
                        'select'       => esc_html__( 'Select audio', 'industrium' ),
                        'change'       => esc_html__( 'Change audio', 'industrium' ),
                        'default'      => esc_html__( 'Default', 'industrium' ),
                        'remove'       => esc_html__( 'Remove', 'industrium' ),
                        'placeholder'  => esc_html__( 'No audio selected', 'industrium' ),
                        'frame_title'  => esc_html__( 'Select audio', 'industrium' ),
                        'frame_button' => esc_html__( 'Choose audio', 'industrium' ),
                    );
                case 'image':
                    return array(
                        'select'       => esc_html__( 'Select image', 'industrium' ),
                        'site_icon'    => esc_html__( 'Select site icon', 'industrium' ),
                        'change'       => esc_html__( 'Change image', 'industrium' ),
                        'default'      => esc_html__( 'Default', 'industrium' ),
                        'remove'       => esc_html__( 'Remove', 'industrium' ),
                        'placeholder'  => esc_html__( 'No image selected', 'industrium' ),
                        'frame_title'  => esc_html__( 'Select image', 'industrium' ),
                        'frame_button' => esc_html__( 'Choose image', 'industrium' ),
                    );
                default:
                    return array(
                        'select'       => esc_html__( 'Select file', 'industrium' ),
                        'change'       => esc_html__( 'Change file', 'industrium' ),
                        'default'      => esc_html__( 'Default', 'industrium' ),
                        'remove'       => esc_html__( 'Remove', 'industrium' ),
                        'placeholder'  => esc_html__( 'No file selected', 'industrium' ),
                        'frame_title'  => esc_html__( 'Select file', 'industrium' ),
                        'frame_button' => esc_html__( 'Choose file', 'industrium' ),
                    );
            }
        }

    }

// Register Upload Control
    class Industrium_Upload_Custom_Control extends Industrium_Media_Custom_Control {
        public $type            = 'upload';
        public $mime_type       = '';
        public $button_labels   = array();
        public $removed         = '';
        public $context;
        public $extensions      = array();

        public function to_json() {
            parent::to_json();

            $value = $this->value();
            if ( $value ) {
                // Get the attachment model for the existing file.
                $attachment_id = attachment_url_to_postid( $value );
                if ( $attachment_id ) {
                    $this->json['attachment'] = wp_prepare_attachment_for_js( $attachment_id );
                }
            }
        }
    }

// Register Image Control
    class Industrium_Image_Custom_Control extends Industrium_Upload_Custom_Control {
        public $type        = 'image';
        public $mime_type   = 'image';

        public function prepare_control() {}

        public function add_tab( $id, $label, $callback ) {
            _deprecated_function( __METHOD__, '4.1.0' );
        }

        public function remove_tab( $id ) {
            _deprecated_function( __METHOD__, '4.1.0' );
        }

        public function print_tab_image( $url, $thumbnail_url = null ) {
            _deprecated_function( __METHOD__, '4.1.0' );
        }
    }

// Register Color Control
    class Industrium_Color_Custom_Control extends Industrium_Customize_Control {
        public $type = 'color';
        public $statuses;
        public $mode = 'full';

        public function __construct( $manager, $id, $args = array() ) {
            $this->statuses = array( '' => esc_html__( 'Default', 'industrium' ) );
            parent::__construct( $manager, $id, $args );
        }

        public function enqueue() {
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_style( 'wp-color-picker' );
        }

        public function to_json() {
            parent::to_json();
            $this->json['statuses']     = $this->statuses;
            $this->json['defaultValue'] = $this->setting->default;
            $this->json['mode']         = $this->mode;
        }

        public function render_content() {}

        public function content_template() {
            ?>
            <# var defaultValue = '#RRGGBB', defaultValueAttr = '',
            isHueSlider = data.mode === 'hue';
            if ( data.defaultValue && _.isString( data.defaultValue ) && ! isHueSlider ) {
            if ( '#' !== data.defaultValue.substring( 0, 1 ) ) {
            defaultValue = '#' + data.defaultValue;
            } else {
            defaultValue = data.defaultValue;
            }
            defaultValueAttr = ' data-default-color=' + defaultValue; // Quotes added automatically.
            } #>
            <# if ( data.label ) { #>
            <span class="customize-control-title">{{{ data.label }}}</span>
            <# } #>
            <# if ( data.description ) { #>
            <span class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>
            <div class="customize-control-content">
                <label><span class="screen-reader-text">{{{ data.label }}}</span>
                    <# if ( isHueSlider ) { #>
                    <input class="color-picker-hue" type="text" data-type="hue" />
                    <# } else { #>
                    <input class="color-picker-hex" type="text" maxlength="7" placeholder="{{ defaultValue }}" {{ defaultValueAttr }} />
                    <# } #>
                </label>
            </div>
            <?php
        }
    }

// Register Switcher Control
    class Industrium_Switcher_Custom_Control extends Industrium_Customize_Control {
        public $type = 'switcher';

        public function render_content() {
            $description_id = '_customize-description-' . esc_attr($this->id);
            $input_id       = '_customize-input-' . esc_attr($this->id);
            $allowed_html   = array(
                'a'         => array(
                    'href'      => true,
                    'title'     => true,
                    'class'     => true,
                    'target'    => true
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'i'         => array(
                    'class'     => true
                ),
                'span'      => array(
                    'class'     => true
                ),
                'code'      => array()
            );
            ?>
            <div class="toggle-switch-control">
                <div class="toggle-switch">
                    <input type="checkbox" id="<?php echo esc_attr($input_id); ?>" name="<?php echo esc_attr($this->id); ?>" class="toggle-switch-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?>>
                    <label class="toggle-switch-label" for="<?php echo esc_attr($input_id); ?>">
                        <span class="toggle-switch-inner"></span>
                        <span class="toggle-switch-switch"></span>
                    </label>
                </div>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php if( !empty( $this->description ) ) {
                    echo '<span class="customize-control-description" id="' . esc_attr( $description_id ) . '">' . wp_kses($this->description, $allowed_html) . '</span>';
                } ?>
            </div>
            <?php
        }
    }

// Register Alpha Color Control
    class Industrium_Alpha_Color_Custom_Control extends Industrium_Customize_Control {
        public $type = 'alpha-color';
        public $palette;
        public $show_opacity;

        public function enqueue() {
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_script( 'industrium-customizer-js', get_template_directory_uri() . '/js/customizer.js', array( 'jquery', 'wp-color-picker' ), '1.0', true );
            wp_enqueue_style( 'wp-color-picker' );
        }

        public function render_content() {
            $description_id = '_customize-description-' . esc_attr($this->id);
            $input_id       = '_customize-input-' . esc_attr($this->id);
            $allowed_html   = array(
                'a'         => array(
                    'href'      => true,
                    'title'     => true,
                    'class'     => true,
                    'target'    => true
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'i'         => array(
                    'class'                 => true,
                    'data-dependency-id'    => true,
                    'data-dependency-val'   => true
                ),
                'span'      => array(
                    'class'     => true
                ),
                'code'      => array()
            );

            if ( is_array( $this->palette ) ) {
                $palette = implode( '|', $this->palette );
            } else {
                $palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
            }
            $show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';

            if ( !empty( $this->label ) ) {
                echo '<label class="customize-control-title">' . esc_html($this->label) . '</label>';
            }
            if ( !empty( $this->description ) ) {
                echo '<span id="' . esc_attr( $description_id ) . '" class="description customize-control-description">' . wp_kses($this->description, $allowed_html) . '</span>';
            }
            ?>

            <div class="customize-control-content">
                <input class="alpha-color-control" type="text" data-show-opacity="<?php echo esc_attr($show_opacity); ?>" data-palette="<?php echo esc_attr( $palette ); ?>"
                       data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?> id="<?php echo esc_attr($input_id); ?>" />
            </div>
            <?php
        }
    }

}