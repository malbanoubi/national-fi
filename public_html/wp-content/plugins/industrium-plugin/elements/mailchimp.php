<?php

/*
 * Created by Artureanec
*/

namespace Industrium\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Industrium_Mailchimp_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_mailchimp';
    }

    public function get_title() {
        return esc_html__('MailChimp', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-mailchimp';
    }

    public function is_reload_preview_required() {
        return true;
    }

    public function get_categories() {
        return ['industrium_widgets'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_display_form',
            [
                'label' => esc_html__('Display Form', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'industrium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => ''
            ]
        );

        $this->end_controls_section();


        // ------------------------------------ //
        // ---------- Title Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'title_settings_section',
            [
                'label'     => esc_html__('Title Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'title!'  => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Title Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .mailchimp-widget-heading'
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('HTML Tag', 'industrium_plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => esc_html__( 'H1', 'industrium_plugin' ),
                    'h2' => esc_html__( 'H2', 'industrium_plugin' ),
                    'h3' => esc_html__( 'H3', 'industrium_plugin' ),
                    'h4' => esc_html__( 'H4', 'industrium_plugin' ),
                    'h5' => esc_html__( 'H5', 'industrium_plugin' ),
                    'h6' => esc_html__( 'H6', 'industrium_plugin' ),
                    'div' => esc_html__( 'div', 'industrium_plugin' ),
                    'span' => esc_html__( 'span', 'industrium_plugin' ),
                    'p' => esc_html__( 'p', 'industrium_plugin' )
                ],
                'default' => 'h5'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Title Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mailchimp-widget-heading, {{WRAPPER}}' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------ //
        // ---------- Field Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'fields_settings_section',
            [
                'label'     => esc_html__('Fields Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        // Field
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'field_typography',
                'label'     => esc_html__('Field Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="date"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime-local"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="email"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="month"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="number"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="password"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="search"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="tel"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="text"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="time"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="url"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="week"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields select, 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea'
            ]
        );

        $this->start_controls_tabs('fields_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_fields_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'field_color',
                    [
                        'label'     => esc_html__('Field Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="date"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime-local"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="email"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="month"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="number"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="password"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="search"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="tel"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="text"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="time"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="url"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="week"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields select, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'field_border_color',
                    [
                        'label'     => esc_html__('Field Border Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="radio"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="checkbox"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="date"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime-local"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="email"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="month"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="number"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="password"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="search"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="tel"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="text"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="time"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="url"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="week"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields select, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea' => 'border-color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields .select-wrap:after' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'field_background_color',
                    [
                        'label'     => esc_html__('Field Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="radio"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="checkbox"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="date"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime-local"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="email"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="month"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="number"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="password"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="search"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="tel"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="text"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="time"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="url"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="week"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields select, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ------------------------ //
            // ------ Active Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_fields_active',
                [
                    'label' => esc_html__('Active', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'field_color_focus',
                    [
                        'label'     => esc_html__('Field Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="date"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime-local"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="email"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="month"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="number"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="password"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="search"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="tel"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="text"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="time"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="url"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="week"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields select:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:focus' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'field_border_focus',
                    [
                        'label'     => esc_html__('Field Border Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="date"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime-local"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="email"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="month"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="number"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="password"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="search"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="tel"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="text"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="time"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="url"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="week"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields select:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:focus' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'field_background_focus',
                    [
                        'label'     => esc_html__('Field Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="date"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime-local"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="email"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="month"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="number"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="password"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="search"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="tel"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="text"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="time"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="url"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="week"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields select:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:focus' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'field_placeholder_color',
            [
                'label'     => esc_html__('Field Placeholder Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input:-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields .wpforms-form input::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input:-ms-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:-ms-input-placeholder' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'dark_color',
            [
                'label'     => esc_html__('Field Dark Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"], {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="radio"]:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-webkit-slider-runnable-track' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]:focus::-webkit-slider-runnable-track' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-moz-range-track' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-ms-track' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="checkbox"]:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-webkit-slider-thumb' => '-webkit-box-shadow: 0px 0px 0px 1px {{VALUE}}; -moz-box-shadow: 0px 0px 0px 1px {{VALUE}}; box-shadow: 0px 0px 0px 1px {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-moz-range-thumb' => '-webkit-box-shadow: 0px 0px 0px 1px {{VALUE}}; -moz-box-shadow: 0px 0px 0px 1px {{VALUE}}; box-shadow: 0px 0px 0px 1px {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-ms-thumb' => '-webkit-box-shadow: 0px 0px 0px 1px {{VALUE}}; -moz-box-shadow: 0px 0px 0px 1px {{VALUE}}; box-shadow: 0px 0px 0px 1px {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]:focus::-ms-thumb' => '-webkit-box-shadow: 0px 0px 0px 1px {{VALUE}}; -moz-box-shadow: 0px 0px 0px 1px {{VALUE}}; box-shadow: 0px 0px 0px 1px {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label'     => esc_html__('Field Accent Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="radio"]:checked, {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="checkbox"]:checked' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-webkit-slider-thumb' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-moz-range-thumb' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-ms-thumb' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]:focus::-ms-thumb' => 'background-color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        // Label
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'label_typography',
                'label'     => esc_html__('Label Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields label'
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => esc_html__('Label Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields label' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------- //
        // ---------- Button Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'button_settings_section',
            [
                'label'     => esc_html__('Button Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'label'     => esc_html__('Button Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'button_bg',
                'label'     => esc_html__( 'Button Background', 'industrium_plugin' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button:after'
            ]
        );

        $this->start_controls_tabs('button_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_button_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'button_color',
                    [
                        'label'     => esc_html__('Button Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_button_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'button_color_hover',
                    [
                        'label'     => esc_html__('Button Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings();
        $title              = $settings['title'];
        $title_tag          = $settings['title_tag'];
        $shortcode_attr     = '';

        $form_id = (int) get_option( 'mc4wp_default_form_id', 0 );

        if (!empty($form_id)) {
            $shortcode_attr .= ' id="' . esc_attr($form_id) . '"';
        }

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>
        <div class="industrium-mailchimp-widget">
            <?php
                if ( !empty($title) ) {
                    echo '<' . esc_html($title_tag) . ' class="mailchimp-widget-heading industrium-heading"><span class="industrium-heading-content">' . esc_html($title) . '</span></' . esc_html
                        ($title_tag) . '>';
                }
                if ( !empty($form_id) ) {
                    $shortcode = '[mc4wp_form' . $shortcode_attr . ']';
                    echo do_shortcode($shortcode);
                }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
