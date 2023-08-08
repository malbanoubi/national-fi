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
use Elementor\REPEATER;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Industrium_Step_Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_step_carousel';
    }

    public function get_title() {
        return esc_html__('Step Carousel', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-slider-album';
    }

    public function get_categories() {
        return ['industrium_widgets'];
    }

    public function get_script_depends() {
        return ['elementor_widgets'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Step Carousel', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'view_type',
            [
                'label'         => esc_html__('View Type', 'industrium_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'type-1',
                'options'       => [
                    'type-1'          => esc_html__('Type 1', 'industrium_plugin'),
                    'type-2'          => esc_html__('Type 2', 'industrium_plugin')
                ],
                'prefix_class'  => 'view_'
            ]
        );

        $this->add_control(
            'view_style',
            [
                'label'         => esc_html__('View Style', 'industrium_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'style-1',
                'options'       => [
                    'style-1'          => esc_html__('Style 1', 'industrium_plugin'),
                    'style-2'          => esc_html__('Style 2', 'industrium_plugin'),
                    'style-3'          => esc_html__('Style 3', 'industrium_plugin')
                ],
                'prefix_class'  => 'view_'
            ]
        );

        $this->add_control(
            'title',
            [
                'label'         => esc_html__('Title', 'industrium_plugin'),
                'type'          => Controls_Manager::WYSIWYG
            ]
        );

        $this->add_control(
            'add_subtitle',
            [
                'label'         => esc_html__('Add Subheading', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'no',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label'         => esc_html__('Subheading', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__( 'This is subheading element', 'industrium_plugin' ),
                'placeholder'   => esc_html__( 'Enter Your Subheading', 'industrium_plugin'),
                'label_block'   => true,
                'condition'     => [
                    'add_subtitle'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'     => esc_html__('HTML Tag', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'h1'        => esc_html__( 'H1', 'industrium_plugin' ),
                    'h2'        => esc_html__( 'H2', 'industrium_plugin' ),
                    'h3'        => esc_html__( 'H3', 'industrium_plugin' ),
                    'h4'        => esc_html__( 'H4', 'industrium_plugin' ),
                    'h5'        => esc_html__( 'H5', 'industrium_plugin' ),
                    'h6'        => esc_html__( 'H6', 'industrium_plugin' ),
                    'div'       => esc_html__( 'div', 'industrium_plugin' ),
                    'span'      => esc_html__( 'span', 'industrium_plugin' ),
                    'p'         => esc_html__( 'p', 'industrium_plugin' )
                ],
                'default'   => 'h2'
            ]
        );

        $this->add_responsive_control(
            'title_align',
            [
                'label'         => esc_html__('Title Alignment', 'industrium_plugin'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'           => [
                        'title'         => esc_html__('Left', 'industrium_plugin'),
                        'icon'          => 'eicon-text-align-left',
                    ],
                    'center'        => [
                        'title'         => esc_html__('Center', 'industrium_plugin'),
                        'icon'          => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title'         => esc_html__('Right', 'industrium_plugin'),
                        'icon'          => 'eicon-text-align-right',
                    ]
                ],
                'default'       => is_rtl() ? 'right' : 'left',
                'prefix_class'  => 'title-alignment%s-',
                'selectors'     => [
                    '{{WRAPPER}} .industrium-heading' => 'text-align: {{VALUE}};',
                ]
            ]
        );
        
        $repeater = new Repeater();
        
        $repeater->add_control(
            'step_number',
            [
                'label'     => esc_html__('Step Number', 'industrium_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => '01',
                'separator' => 'before'
            ]
        );

        $repeater->add_control(
            'step_number_big',
            [
                'label'     => esc_html__('Step Number Big', 'industrium_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => '01',
                'separator' => 'before'
            ]
        );

        $repeater->add_control(
            'step_title',
            [
                'label'         => esc_html__('Title', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => ''
            ]
        );

        $repeater->add_control(
            'step_description',
            [
                'label'         => esc_html__('Description', 'industrium_plugin'),
                'description'   => esc_html__('Enter description', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => ''
            ]
        );

        $this->add_control(
            'step_items',
            [
                'label'         => esc_html__('Steps', 'industrium_plugin'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'title_field'   => '{{{name}}}',
                'prevent_empty' => false,
                'separator'     => 'before'
            ]
        );

        $this->add_responsive_control(
            'step_align',
            [
                'label'     => esc_html__('Alignment', 'industrium_plugin'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'      => [
                        'title'     => esc_html__('Left', 'industrium_plugin'),
                        'icon'      => 'eicon-text-align-left',
                    ],
                    'center'    => [
                        'title'     => esc_html__('Center', 'industrium_plugin'),
                        'icon'      => 'eicon-text-align-center',
                    ],
                    'right'     => [
                        'title'     => esc_html__('Right', 'industrium_plugin'),
                        'icon'      => 'eicon-text-align-right',
                    ]
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .step-item' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'item_spacing',
            [
                'label'     => esc_html__('Space between items', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 60
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 0
                ],
                'selectors' => [
                    '{{WRAPPER}} .steps-slider-container' => 'margin: 0 calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .step-item.slider-item' => 'margin: 0 calc({{SIZE}}{{UNIT}}/2);'
                ]
            ]
        );

        $this->end_controls_section();

        // ---------------------------- //
        // ---------- Slider ---------- //
        // ---------------------------- //
        $this->start_controls_section(
            'section_slider',
            [
                'label' => esc_html__('Slider Settings', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'columns_number',
            [
                'label'     => esc_html__('Columns Number', 'industrium_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 3,
                'min'       => 1,
                'max'       => 6
            ]
        );

        $this->add_responsive_control(
            'owl_stage_padding',
            [
                'label'         => esc_html__( 'Slider top padding', 'industrium_plugin' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .owl-stage-outer' => 'padding-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'slider_width',
            [
                'label'         => esc_html__( 'Slider width', 'industrium_plugin' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1920,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}}.view_type-2 .step-carousel-wrapper' => 'max-width: {{SIZE}}{{UNIT}};'
                ],
                'condition'     => [
                    'view_type' => 'type-2'
                ]
            ]
        );

        $this->add_control(
            'nav',
            [
                'label'         => esc_html__('Show navigation buttons', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );

        $this->add_control(
            'dots',
            [
                'label'         => esc_html__('Show pagination dots', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'speed',
            [
                'label'     => esc_html__('Animation Speed', 'industrium_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 500,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label'     => esc_html__('Infinite Loop', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'yes',
                'options'   => [
                    'yes'       => esc_html__('Yes', 'industrium_plugin'),
                    'no'        => esc_html__('No', 'industrium_plugin'),
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'     => esc_html__('Autoplay', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'yes',
                'options'   => [
                    'yes'       => esc_html__('Yes', 'industrium_plugin'),
                    'no'        => esc_html__('No', 'industrium_plugin'),
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => esc_html__('Autoplay Speed', 'industrium_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 300,
                'step'      => 100,
                'condition' => [
                    'autoplay'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'autoplay_timeout',
            [
                'label'     => esc_html__('Autoplay Timeout', 'industrium_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'step'      => 100,
                'condition' => [
                    'autoplay'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'     => esc_html__('Pause on Hover', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'yes',
                'options'   => [
                    'yes'       => esc_html__('Yes', 'industrium_plugin'),
                    'no'        => esc_html__('No', 'industrium_plugin'),
                ],
                'condition' => [
                    'autoplay'  => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        // -------------------------------------------- //
        // ---------- Widget Title Settings ---------- //
        // -------------------------------------------- //
        $this->start_controls_section(
            'title_settings_section',
            [
                'label'     => esc_html__('Heading Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'heading_typography',
                'label'     => esc_html__('Heading Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .industrium-heading .industrium-heading-content'
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => esc_html__('Heading Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-heading .industrium-heading-content' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'subtitle_typography',
                'label'     => esc_html__('Subheading Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .industrium-subheading',
                'condition' => [
                    'add_subtitle'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label'     => esc_html__('Subheading Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-subheading' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'add_subtitle'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'accent_text_color',
            [
                'label'     => esc_html__('Text Underline Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-heading .industrium-heading-content span[style *= "text-decoration: underline"]:before' => 'background-color: {{VALUE}} !important;'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'space_subheading',
            [
                'label' => esc_html__( 'Space between Heading and Subheading', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .industrium-heading .industrium-heading-content:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'add_subtitle' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Item Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_item_settings',
            [
                'label'         => esc_html__('Step Item Settings', 'industrium_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'item_background_color',
            [
                'label'         => esc_html__('Background Color', 'industrium_plugin'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '',
                'selectors'     => [
                    '{{WRAPPER}} .step-item' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'item_border_color',
            [
                'label'         => esc_html__('Border Color', 'industrium_plugin'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '',
                'selectors'     => [
                    '{{WRAPPER}} .step-item' => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'         => esc_html__('Item Padding', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .step-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .step-item .step-bg-number' => 'left: {{LEFT}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .step-item .step-bg-number' => 'right: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}}.view_style-3 .step-carousel-wrapper' => 'margin-left: -{{LEFT}}{{UNIT}};',
                    'body.rtl {{WRAPPER}}.view_style-3 .step-carousel-wrapper' => 'margin-left: 0; margin-right: -{{RIGHT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'bg_number_typography',
                'label'         => esc_html__('Background Number Typography', 'industrium_plugin'),
                'selector'      => '{{WRAPPER}} .step-item .step-bg-number',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'bg_number_color',
            [
                'label'         => esc_html__('Background Number Color', 'industrium_plugin'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '',
                'selectors'     => [
                    '{{WRAPPER}} .step-item .step-bg-number' => '-webkit-text-stroke: 1px {{VALUE}};',
                    '{{WRAPPER}}.view_style-2 .step-item:hover .step-bg-number' => '-webkit-text-fill-color: {{VALUE}};',
                    '{{WRAPPER}}.view_style-3 .step-item:hover .step-bg-number' => '-webkit-text-fill-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------- //
        // ---------- Number Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'section_number_settings',
            [
                'label'         => esc_html__('Number Settings', 'industrium_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'number_typography',
                'label'         => esc_html__('Number Typography', 'industrium_plugin'),
                'selector'      => '{{WRAPPER}} .step-item .step-number'
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label'         => esc_html__('Number Color', 'industrium_plugin'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '',
                'selectors'     => [
                    '{{WRAPPER}} .step-item .step-number' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'number_spacing',
            [
                'label'         => esc_html__('Space between number and title', 'industrium_plugin'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'            => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}}:not(.view_style-3) .step-item .step-number:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.view_style-3 .step-item .step-content:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Title Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_title_settings',
            [
                'label'         => esc_html__('Title Settings', 'industrium_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'title_typography',
                'label'         => esc_html__('Title Typography', 'industrium_plugin'),
                'selector'      => '{{WRAPPER}} .step-title'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'         => esc_html__('Title Color', 'industrium_plugin'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '',
                'selectors'     => [
                    '{{WRAPPER}} .step-title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'title_hover',
            [
                'label'         => esc_html__('Title Hover', 'industrium_plugin'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '',
                'selectors'     => [
                    '{{WRAPPER}} .step-item:hover .step-title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'         => esc_html__('Space between title and description', 'industrium_plugin'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'            => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .step-title:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'step_content_padding',
            [
                'label'         => esc_html__('Step Content Padding', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .step-item .step-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------------ //
        // ---------- Description Settings ---------- //
        // ------------------------------------------ //
        $this->start_controls_section(
            'section_description_settings',
            [
                'label' => esc_html__('Description Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'description_typography',
                'label'     => esc_html__('Description Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .step-description'
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__('Description Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .step-description' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();        

        // ----------------------------------------- //
        // ---------- Slider Nav Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'slider_nav_settings_section',
            [
                'label'         => esc_html__('Slider Navigation Settings', 'industrium_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'conditions'    => [
                    'relation'  => 'or',
                    'terms'     => [
                        [
                            'name'      => 'dots',
                            'operator'  => '==',
                            'value'     => 'yes'
                        ],
                        [
                            'name'      => 'nav',
                            'operator'  => '==',
                            'value'     => 'yes'
                        ],
                    ],
                ]
            ]
        );

        $this->start_controls_tabs(
            'slider_pagination_settings_tabs',
            [
                'condition' => [
                    'dots'      => 'yes'
                ]
            ]
        );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'slider_dots_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'dot_color',
                    [
                        'label'     => esc_html__('Pagination Dot Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-dots .owl-dot span' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'dot_border',
                    [
                        'label'     => esc_html__('Pagination Dot Border', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-dots .owl-dot span:before' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ------------------------ //
            // ------ Active Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'slider_dots_active',
                [
                    'label' => esc_html__('Active', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'dot_active',
                    [
                        'label'     => esc_html__('Pagination Active Dot Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'dot_border_active',
                    [
                        'label'     => esc_html__('Pagination Active Dot Border', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-dots .owl-dot.active span:before' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->start_controls_tabs(
            'slider_nav_settings_tabs',
            [
                'condition' => [
                    'nav'       => 'yes'
                ]
            ]
        );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_arrows_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'nav_color',
                    [
                        'label'     => esc_html__('Slider Arrows Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]:before' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'nav_bd',
                    [
                        'label'     => esc_html__('Slider Arrows Border', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'nav_bg',
                    [
                        'label'     => esc_html__('Slider Arrows Background', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_arrows_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'nav_hover',
                    [
                        'label'     => esc_html__('Slider Arrows Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]:not(.disabled):hover:before' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'nav_bd_hover',
                    [
                        'label'     => esc_html__('Slider Arrows Border', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]:not(.disabled):hover' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'nav_bg_hover',
                    [
                        'label'     => esc_html__('Slider Arrows Background', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]:not(.disabled):hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings();

        $title = $settings['title'];
        $title_tag = $settings['title_tag'];
        $add_subtitle = $settings['add_subtitle'];
        $subtitle = $settings['subtitle'];

        $columns_number     = $settings['columns_number'];

        $step_items     = $settings['step_items'];

        $dots                   = $settings['dots'];

        $widget_id              = $this->get_id();

        $dots_container_desktop = ( !empty($title) && !empty($widget_id) ? '.owl-dots-desktop.owl-dots-' . esc_attr($widget_id) : '.owl-dots-' . esc_attr($widget_id) );
        $dots_container_mobile  = ( !empty($title) && !empty($widget_id) ? '.owl-dots-mobile.owl-dots-' . esc_attr($widget_id) : $dots_container_desktop );

        $slider_options = [
            'items'                 => !empty($columns_number) ? (int)$columns_number : 1,
            'nav'                   => ('yes' === $settings['nav']),
            'dots'                  => ('yes' === $dots),
            'dotsContainer'         => $dots_container_desktop,
            'dotsContainerMobile'   => $dots_container_mobile,
            'autoplayHoverPause'    => ('yes' === $settings['pause_on_hover']),
            'autoplay'              => ('yes' === $settings['autoplay']),
            'autoplaySpeed'         => absint($settings['autoplay_speed']),
            'autoplayTimeout'       => absint($settings['autoplay_timeout']),
            'loop'                  => ('yes' === $settings['infinite']),
            'speed'                 => absint($settings['speed'])
        ];

        $item_classes = 'step-item slider-item';

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="industrium-step-carousel-widget">
            <?php
                if ( !empty($title) ) {
                    echo '<' . esc_html($title_tag) . ' class="industrium-heading' . ( $dots == 'yes' ? ' heading-with-pagination' : '' ) . '">';
                        echo '<span class="industrium-heading-inner">';
                            if ( $add_subtitle == 'yes' && !empty($subtitle) ) {
                                echo '<span class="industrium-subheading">' . esc_html($subtitle) . '</span>';
                            }
                            echo '<span class="industrium-heading-content">';
                                echo wp_kses($title, array(
                                    'br'        => array(),
                                    'span'      => array(
                                        'style'     => true
                                    ),
                                    'a'         => array(
                                        'href'      => true,
                                        'target'    => true
                                    ),
                                    'img'       => array(
                                        'src'       => true,
                                        'srcset'    => true,
                                        'sizes'     => true,
                                        'class'     => true,
                                        'alt'       => true,
                                        'title'     => true
                                    ),
                                    'em'        => array(),
                                    'strong'    => array(),
                                    'del'       => array()
                                ));
                            echo '</span>';
                        echo '</span>';
                        if ( $dots == 'yes' ) {
                            echo '<span class="owl-dots owl-dots-desktop' . (!empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '') . '"></span>';
                        }
                    echo '</' . esc_html($title_tag) . '>';
                }
            ?>

            <div class="step-carousel-wrapper">

                <div class="steps-slider-container">
                    <div class="steps-slider owl-carousel owl-theme" data-slider-options="<?php echo esc_attr(wp_json_encode($slider_options)); ?>">
                        <?php

                            foreach ($step_items as $item) {
                                $step_number        = $item['step_number'];
                                $step_number_big    = $item['step_number_big'];
                                $step_title         = $item['step_title'];
                                $step_description   = $item['step_description'];

                                echo '<div class="' . esc_attr($item_classes) . '">';
                                    if ( !empty($step_number)) {
                                        echo '<div class="step-bg-number">' . esc_html($step_number_big) . '</div>';
                                        echo '<div class="step-number">' . esc_html($step_number) . '</div>';
                                    }
                                    if ( !empty($step_title) || !empty($step_description) ) {
                                        echo '<div class="step-content">';
                                            if ( !empty($step_title) ) {
                                                echo '<h3 class="step-title">' . wp_kses($step_title, array('br' => array())) . '</h3>';
                                            }
                                            if ( !empty($step_description) ) {
                                                echo '<div class="step-description">' . esc_html($step_description) . '</div>';
                                            }
                                        echo '</div>';
                                    }                                 
                                echo '</div>';
                            }
                        ?>
                    </div>                    
                </div>
                <?php 
                    if(!empty($title)) {
                        echo '<div class="owl-dots owl-dots-mobile' . ( !empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '' ) . '"></div>';      
                    } else {
                        echo '<div class="owl-dots' . ( !empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '' ) . '"></div>';
                    }
                ?>
            </div>
        </div>

        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}