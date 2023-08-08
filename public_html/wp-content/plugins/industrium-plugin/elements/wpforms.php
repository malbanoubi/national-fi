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

class Industrium_Wpforms_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_wpforms';
    }

    public function get_title() {
        return esc_html__('WPForms', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
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

        $forms = wpforms()->form->get();
        $form_list_default = [
            'default' => esc_html__('Select your form', 'industrium_plugin')
        ];
        $form_list = [];
        if ( !empty( $forms ) ) {
            foreach ($forms as $key => $form) {
                $form_list[$form->post_title] = $form->post_title;
            }
            $form_list = array_merge($form_list_default, $form_list);
        } else {
            $form_list['default'] = esc_html__('No forms', 'industrium_plugin');
        }
        $this->add_control(
            'form',
            [
                'label'   => esc_html__('Form', 'industrium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => $form_list
            ]
        );

        $this->add_control(
            'add_name',
            [
                'label' => esc_html__('Display form name', 'industrium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_off' => esc_html__('No', 'industrium_plugin'),
                'label_on' => esc_html__('Yes', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'add_description',
            [
                'label' => esc_html__('Display form description', 'industrium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_off' => esc_html__('No', 'industrium_plugin'),
                'label_on' => esc_html__('Yes', 'industrium_plugin')
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label'     => esc_html__('Text Alignment', 'industrium_plugin'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'left',
                'options'   => [
                    'left'      => [
                        'title'     => esc_html__( 'Left', 'industrium_plugin' ),
                        'icon'      => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title'     => esc_html__( 'Center', 'industrium_plugin' ),
                        'icon'      => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title'     => esc_html__( 'Right', 'industrium_plugin' ),
                        'icon'      => 'eicon-text-align-right'
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}'   => 'text-align: {{VALUE}};'
                ]
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
                'selector'  => '{{WRAPPER}} .wpforms-widget-heading'
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
                    '{{WRAPPER}} .wpforms-widget-heading' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'title_decoration_color',
            [
                'label'     => esc_html__('Title Decoration Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-heading:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------- //
        // ---------- Content Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'content_settings_section',
            [
                'label'         => esc_html__('Form Header Settings', 'industrium_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'conditions'    => [
                    'relation'  => 'or',
                    'terms'     => [
                        [
                            'name'      => 'add_name',
                            'operator'  => '==',
                            'value'     => 'yes'
                        ],
                        [
                            'name'      => 'add_description',
                            'operator'  => '==',
                            'value'     => 'yes'
                        ],
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'form_name_typography',
                'label'     => esc_html__('Form Name Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .wpforms-head-container .wpforms-title',
                'condition' => [
                    'add_name'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'form_name_color',
            [
                'label'     => esc_html__('Form Name Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-head-container .wpforms-title' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'add_name'  => 'yes'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'form_description_typography',
                'label'     => esc_html__('Form Description Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .wpforms-head-container .wpforms-description',
                'condition' => [
                    'add_description'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'form_description_color',
            [
                'label'     => esc_html__('Form Description Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-head-container .wpforms-description' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'add_description'  => 'yes'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------- //
        // ---------- Fields Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'fields_settings_section',
            [
                'label'     => esc_html__('Fields Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        // Field
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'field_typography',
                'label'     => esc_html__('Field Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-label-inline, 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="date"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime-local"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="email"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="month"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="number"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="password"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="range"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="search"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="tel"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="text"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="time"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="url"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="week"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form select, 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea'
            ]
        );

        $this->add_control(
            'field_color',
            [
                'label'     => esc_html__('Field Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-label-inline, 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="date"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime-local"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="email"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="month"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="number"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="password"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="search"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="tel"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="text"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="time"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="url"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="week"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form select, 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'field_placeholder_color',
            [
                'label'     => esc_html__('Field Placeholder Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .input-floating-wrap .floating-placeholder' => 'color: {{VALUE}};',                    
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input:-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input:-ms-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea:-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea:-ms-input-placeholder' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'field_border_color',
            [
                'label'     => esc_html__('Field Border Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="radio"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="checkbox"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="date"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime-local"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="email"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="month"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="number"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="password"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="search"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="tel"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="text"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="time"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="url"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="week"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form select, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .select-wrap:after' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'field_background_color',
            [
                'label'     => esc_html__('Field Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="radio"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="checkbox"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="date"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime-local"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="email"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="month"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="number"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="password"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="search"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="tel"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="text"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="time"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="url"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="week"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form select, 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'dark_color',
            [
                'label'     => esc_html__('Field Dark Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"], {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="radio"]:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-webkit-slider-runnable-track' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]:focus::-webkit-slider-runnable-track' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-moz-range-track' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-ms-track' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="checkbox"]:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-webkit-slider-thumb' => '-webkit-box-shadow: 0px 0px 0px 1px {{VALUE}}; -moz-box-shadow: 0px 0px 0px 1px {{VALUE}}; box-shadow: 0px 0px 0px 1px {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-moz-range-thumb' => '-webkit-box-shadow: 0px 0px 0px 1px {{VALUE}}; -moz-box-shadow: 0px 0px 0px 1px {{VALUE}}; box-shadow: 0px 0px 0px 1px {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-ms-thumb' => '-webkit-box-shadow: 0px 0px 0px 1px {{VALUE}}; -moz-box-shadow: 0px 0px 0px 1px {{VALUE}}; box-shadow: 0px 0px 0px 1px {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]:focus::-ms-thumb' => '-webkit-box-shadow: 0px 0px 0px 1px {{VALUE}}; -moz-box-shadow: 0px 0px 0px 1px {{VALUE}}; box-shadow: 0px 0px 0px 1px {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label'     => esc_html__('Field Accent Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="radio"]:checked, {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="checkbox"]:checked' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-webkit-slider-thumb' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-moz-range-thumb' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-ms-thumb' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]:focus::-ms-thumb' => 'background-color: {{VALUE}};'
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
                'selector'  => '{{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-label'
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => esc_html__('Label Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-label' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'required_color',
            [
                'label'     => esc_html__('Required Field Sign Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-label .wpforms-required-label' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        // Description
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'description_typography',
                'label'     => esc_html__('Field Description Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-number-slider-hint, {{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-description'
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__('Field Description Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-number-slider-hint, {{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-description' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
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
                'selector'  => '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"], {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"], {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button'
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__('Button Text Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"], {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"], {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'button_border_color',
            [
                'label'     => esc_html__('Button Border Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button' => 'border-color: {{VALUE}};background-image: linear-gradient(0deg, {{VALUE}} 0%, {{VALUE}} 100%);',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"]:after, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"]:after, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button:after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"] svg, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button svg' => 'stroke: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label'     => esc_html__('Button Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"], {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"], {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings();
        $title              = $settings['title'];
        $title_tag          = $settings['title_tag'];
        $add_name           = $settings['add_name'];
        $add_description    = $settings['add_description'];
        $shortcode_attr     = '';

        $form_id            = '';
        $form_name          = $settings['form'];

        $forms = wpforms()->form->get();
        if ( !empty( $forms ) ) {
            foreach ($forms as $key => $form) {
                if ($form->post_title == $form_name) {
                    $form_id = $form->ID;
                }
            }

            if (!empty($form_id)) {
                $shortcode_attr .= ' id="' . esc_attr($form_id) . '"';
            }
            if ($add_name == 'yes') {
                $shortcode_attr .= ' title="true"';
            }
            if ($add_description == 'yes') {
                $shortcode_attr .= ' description="true"';
            }
        }

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>
        <div class="industrium-wpforms-widget">
            <?php
                if ( !empty($title) ) {
                    echo '<' . esc_html($title_tag) . ' class="wpforms-widget-heading industrium-heading"><span class="industrium-heading-content">' . esc_html($title) . '</span></' . esc_html($title_tag) . '>';
                }
                if ( !empty($form_id) ) {
                    $shortcode = '[wpforms' . $shortcode_attr . ']';
                    echo do_shortcode($shortcode);
                }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
