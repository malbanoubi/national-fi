<?php
/*
 * Created by Artureanec
*/

namespace Industrium\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\REPEATER;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Industrium_Image_Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_image_carousel';
    }

    public function get_title() {
        return esc_html__('Image Carousel', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return ['industrium_widgets'];
    }

    public function get_script_depends() {
        return ['elementor_widgets', 'wp-mediaelement'];
    }

    public function get_style_depends() {
        return ['wp-mediaelement'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Image Carousel', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'view_type',
            [
                'label'     => esc_html__('View Type', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'type-1',
                'options'   => [
                    'type-1'    => esc_html__('Type 1', 'industrium_plugin'),
                    'type-2'    => esc_html__('Type 2', 'industrium_plugin'),
                    'type-3'    => esc_html__('Type 3', 'industrium_plugin'),
                ],
                'prefix_class'  => 'view-'
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
            'add_button',
            [
                'label'         => esc_html__('Add Button', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'no',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'condition'     => [
                    'view_type'  => 'type-3'
                ]
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'     => esc_html__('Button Text', 'industrium_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('Button', 'industrium_plugin'),
                'condition'     => [
                    'view_type'  => 'type-3',
                    'add_button'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label'         => esc_html__('Button Link', 'industrium_plugin'),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'default'       => [
                    'url'           => '',
                    'is_external'   => 'true',
                ],
                'placeholder'   => esc_html__( 'http://your-link.com', 'industrium_plugin' ),
                'condition'     => [
                    'view_type'  => 'type-3',
                    'add_button'  => 'yes'
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
            'image',
            [
                'label'     => esc_html__('Image', 'industrium_plugin'),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url'           => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image_thumbnail',
                'default'   => 'full'
            ]
        );

        $repeater->add_control(
            'item_subtitle',
            [
                'label'         => esc_html__('Subtitle', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXT,
                'default'       => '',
                'label_block'   => true,
                'placeholder'   => esc_html__('Enter Subtitle', 'industrium_plugin')
            ]
        );

        $repeater->add_control(
            'item_title',
            [
                'label'         => esc_html__('Title', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXT,
                'default'       => '',
                'label_block'   => true,
                'placeholder'   => esc_html__('Enter Title', 'industrium_plugin')
            ]
        );

        $repeater->add_control(
            'item_description',
            [
                'label'         => esc_html__('Description', 'industrium_plugin'),
                'type'          => Controls_Manager::WYSIWYG,
                'rows'          => '10',
                'default'       => '',
                'placeholder'   => esc_html__('Enter Description', 'industrium_plugin')
            ]
        );

        $repeater->add_control(
            'show_arrow_button',
            [
                'label'         => esc_html__('Show Arrow Button', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => '',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'carousel_items',
            [
                'label'         => esc_html__('Items', 'industrium_plugin'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'title_field'   => '{{{name}}}',
                'prevent_empty' => false,
                'separator'     => 'before'
            ]
        );

        $this->end_controls_section();


        // ---------------------------- //
        // ---------- Slider ---------- //
        // ---------------------------- //
        $this->start_controls_section(
            'section_slider',
            [
                'label'         => esc_html__('Slider Settings', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'items',
            [
                'label'         => esc_html__('Visible Items', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3,
                'min'           => 1,
                'max'           => 6
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

        $this->add_responsive_control(
            'dots_space',
            [
                'label' => esc_html__( 'Space before dots', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 37,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-wrapper ~ .owl-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'dots' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'speed',
            [
                'label'         => esc_html__('Animation Speed', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 500
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label'         => esc_html__('Infinite Loop', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'         => esc_html__('Autoplay', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'         => esc_html__('Autoplay Speed', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 300,
                'step'          => 100,
                'condition'     => [
                    'autoplay'      => 'yes'
                ]
            ]
        );

        $this->add_control(
            'autoplay_timeout',
            [
                'label'         => esc_html__('Autoplay Timeout', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 5000,
                'step'          => 100,
                'condition'     => [
                    'autoplay'      => 'yes'
                ]
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'         => esc_html__('Pause on Hover', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'condition'     => [
                    'autoplay'      => 'yes'
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
                    '{{WRAPPER}}.view-type-2 .slider-wrapper' => 'max-width: {{SIZE}}{{UNIT}};'
                ],
                'condition'     => [
                    'view_type' => 'type-2'
                ]
            ]
        );

        $this->add_control(
            'show_custom_cursor',
            [
                'label'         => esc_html__('Show Custom Cursor', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => '',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin')
            ]
        );

        $this->end_controls_section();


        // ------------------------------------ //
        // ---------- Title Settings ---------- //
        // ------------------------------------ //
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
                'name'      => 'title_typography',
                'label'     => esc_html__('Heading Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .industrium-heading .industrium-heading-content'
            ]
        );

        $this->add_control(
            'title_color',
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
                    '{{WRAPPER}} .industrium-subheading' => '-webkit-text-stroke: 1px {{VALUE}};'
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

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'      => 'title_shadow',
                'label'     => esc_html__('Heading Text Shadow', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .industrium-heading .industrium-heading-content'
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

        // ------------------------------------- //
        // ---------- Button Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Button Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'view_type' => 'type-3'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'label'     => esc_html__('Button Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .industrium-button'
            ]
        );        

        $this->add_control(
            'border_color',
            [
                'label'     => esc_html__('Border Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-button:after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .industrium-button' => 'background-image: linear-gradient(0deg, {{VALUE}} 0%, {{VALUE}} 100%);',
                    '{{WRAPPER}} .industrium-button svg' => 'stroke: {{VALUE}};',
                ]
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
                            '{{WRAPPER}} .industrium-button' => 'color: {{VALUE}};'
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
                            '{{WRAPPER}} .industrium-button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_padding',
            [
                'label'         => esc_html__('Button Padding', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .industrium-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();


        // ----------------------------------- //
        // ---------- Item Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'item_settings_section',
            [
                'label'     => esc_html__('Item Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
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
                    'size'      => 30
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-container' => 'margin: 0 calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .slider-container .slider-item' => 'padding: 0 calc({{SIZE}}{{UNIT}}/2);'
                ]
            ]
        );

        $this->add_control(
            'item_vertical_align',
            [
                'label'     => esc_html__('Vertical Alignment', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'center',
                'options'   => [
                    'flex-start'    => esc_html__('Top', 'industrium_plugin'),
                    'center'        => esc_html__('Center', 'industrium_plugin'),
                    'flex-end'      => esc_html__('Bottom', 'industrium_plugin'),
                    'stretch'       => esc_html__('Stretch', 'industrium_plugin')
                ],
                'selectors' => [
                    '{{WRAPPER}} .owl-carousel .owl-stage' => '-webkit-align-items: {{VALUE}}; -moz-align-items: {{VALUE}}; -ms-align-items: {{VALUE}}; align-items: {{VALUE}};'
                ],
                'prefix_class' => 'elementor-align-items-'
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'         => esc_html__( 'Item padding', 'industrium_plugin' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .slider-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label'         => esc_html__( 'Item Border Radius', 'industrium_plugin' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .slider-item-inner'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_align',
            [
                'label'     => esc_html__('Item Alignment', 'industrium_plugin'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'=> [
                        'title'     => esc_html__('Left', 'industrium_plugin'),
                        'icon'      => 'eicon-text-align-left',
                    ],
                    'center'    => [
                        'title'     => esc_html__('Center', 'industrium_plugin'),
                        'icon'      => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title'     => esc_html__('Right', 'industrium_plugin'),
                        'icon'      => 'eicon-text-align-right',
                    ]
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .slider-item-inner' => 'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->start_controls_tabs( 'slider_item_settings_tabs' );

            $this->start_controls_tab( 'slider_item_normal',
                [
                    'label' => esc_html__( 'Normal', 'industrium_plugin' ),
                ]
            );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'      => 'item_border',
                        'label'     => esc_html__( 'Item Border', 'industrium_plugin' ),
                        'selector'  => '{{WRAPPER}} .slider-item-inner'
                    ]
                );

                $this->add_control(
                    'item_bg_color',
                    [
                        'label'     => esc_html__('Item Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'item_box_shadow',
                        'label'     => esc_html__( 'Box Shadow', 'industrium_plugin' ),
                        'selector'  => '{{WRAPPER}} .slider-item-inner',
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab( 'slider_item_hover',
                [
                    'label' => esc_html__( 'Hover', 'industrium_plugin' ),
                ]
            );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'      => 'item_border_hover',
                        'label'     => esc_html__( 'Item Border', 'industrium_plugin' ),
                        'selector'  => '{{WRAPPER}} .slider-item-inner:hover'
                    ]
                );

                $this->add_control(
                    'item_bg_color_hover',
                    [
                        'label'     => esc_html__('Item Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'item_box_shadow_hover',
                        'label'     => esc_html__( 'Box Shadow', 'industrium_plugin' ),
                        'selector'  => '{{WRAPPER}} .slider-item-inner:hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // ------------------------------------ //
        // ---------- Image Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'image_settings_section',
            [
                'label'     => esc_html__('Image Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label'             => esc_html__( 'Width', 'industrium_plugin' ),
                'type'              => Controls_Manager::SLIDER,
                'default'           => [
                    'unit'  => '%',
                ],
                'tablet_default'    => [
                    'unit'  => '%',
                ],
                'mobile_default'    => [
                    'unit'  => '%',
                ],
                'size_units'        => [ '%', 'px', 'vw' ],
                'range'             => [
                    '%'     => [
                        'min'   => 1,
                        'max'   => 100,
                    ],
                    'px'    => [
                        'min'   => 1,
                        'max'   => 1000,
                    ],
                    'vw'    => [
                        'min'   => 1,
                        'max'   => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label'             => esc_html__( 'Max Width', 'industrium_plugin' ),
                'type'              => Controls_Manager::SLIDER,
                'default'           => [
                    'unit'  => '%',
                ],
                'tablet_default'    => [
                    'unit'  => '%',
                ],
                'mobile_default'    => [
                    'unit'  => '%',
                ],
                'size_units'        => [ '%', 'px', 'vw' ],
                'range'             => [
                    '%'     => [
                        'min'   => 1,
                        'max'   => 100,
                    ],
                    'px'    => [
                        'min'   => 1,
                        'max'   => 1000,
                    ],
                    'vw'    => [
                        'min'   => 1,
                        'max'   => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label'             => esc_html__( 'Height', 'industrium_plugin' ),
                'type'              => Controls_Manager::SLIDER,
                'default'           => [
                    'unit'  => 'px',
                ],
                'tablet_default'    => [
                    'unit'  => 'px',
                ],
                'mobile_default'    => [
                    'unit'  => 'px',
                ],
                'size_units'        => [ 'px', 'vh' ],
                'range'             => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500,
                    ],
                    'vh'    => [
                        'min'   => 1,
                        'max'   => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'separator_panel_style',
            [
                'type'  => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( 'image_effects' );

            $this->start_controls_tab( 'normal',
                [
                    'label' => esc_html__( 'Normal', 'industrium_plugin' ),
                ]
            );

                $this->add_control(
                    'opacity',
                    [
                        'label'     => esc_html__( 'Opacity', 'industrium_plugin' ),
                        'type'      => Controls_Manager::SLIDER,
                        'range'     => [
                            'px'        => [
                                'max'       => 1,
                                'min'       => 0.10,
                                'step'      => 0.01,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} img' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Css_Filter::get_type(),
                    [
                        'name'      => 'css_filters',
                        'selector'  => '{{WRAPPER}} img',
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab( 'hover',
                [
                    'label' => esc_html__( 'Hover', 'industrium_plugin' ),
                ]
            );

                $this->add_control(
                    'opacity_hover',
                    [
                        'label'     => esc_html__( 'Opacity', 'industrium_plugin' ),
                        'type'      => Controls_Manager::SLIDER,
                        'range'     => [
                            'px'        => [
                                'max'       => 1,
                                'min'       => 0.10,
                                'step'      => 0.01,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} img:hover' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Css_Filter::get_type(),
                    [
                        'name'      => 'css_filters_hover',
                        'selector'  => '{{WRAPPER}} img:hover',
                    ]
                );

                $this->add_control(
                    'background_hover_transition',
                    [
                        'label'     => esc_html__( 'Transition Duration', 'industrium_plugin' ),
                        'type'      => Controls_Manager::SLIDER,
                        'range'     => [
                            'px'        => [
                                'max'       => 3,
                                'step'      => 0.1,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} img'   => 'transition-duration: {{SIZE}}s',
                        ],
                    ]
                );

                $this->add_control(
                    'hover_animation',
                    [
                        'label' => esc_html__( 'Hover Animation', 'industrium_plugin' ),
                        'type'  => Controls_Manager::HOVER_ANIMATION,
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'selector'  => '{{WRAPPER}} img',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'industrium_plugin' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} img'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'image_box_shadow',
                'exclude'   => [
                    'box_shadow_position',
                ],
                'selector'  => '{{WRAPPER}} img',
            ]
        );

        $this->end_controls_section();


        // -------------------------------------- //
        // ---------- Content Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'content_settings_section',
            [
                'label'     => esc_html__('Content Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'item_subtitle_typography',
                'label'     => esc_html__('Subtitle Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .slider-item-inner .slider-item-subtitle'
            ]
        );        

        $this->add_responsive_control(
            'item_subtitle_margin',
            [
                'label'     => esc_html__('Space between subtitle and image', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => -100,
                        'max'       => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-item-inner .slider-item-media:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'item_title_typography',
                'label'     => esc_html__('Title Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .slider-item-inner .slider-item-title'
            ]
        );

        $this->add_control(
            'show_title_border',
            [
                'label'         => esc_html__('Show Title Border', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => '',
                'return_value'  => 'on',
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'prefix_class' => 'elementor-title-border-'
            ]
        );

        $this->add_control(
            'title_border_color',
            [
                'label'     => esc_html__('Title Border Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slider-item .slider-item-title:before' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'show_title_border' => 'on'
                ]
            ]
        );

        $this->add_responsive_control(
            'space_between_title_border',
            [
                'label'     => esc_html__('Space between title and border', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-item .slider-item-title:before' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'show_title_border' => 'on'
                ]
            ]
        );

        $this->add_responsive_control(
            'item_title_margin',
            [
                'label'     => esc_html__('Space between title and image', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => -100,
                        'max'       => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-item-inner .slider-item-title:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'item_description_typography',
                'label'     => esc_html__('Description Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .slider-item-inner .slider-item-description',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'item_description_margin',
            [
                'label'     => esc_html__('Space between description and title', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => -100,
                        'max'       => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-item-inner .slider-item-description:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs('content_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_content_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'item_subtitle_color',
                    [
                        'label'     => esc_html__('Subtitle Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner .slider-item-subtitle' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'item_title_color',
                    [
                        'label'     => esc_html__('Title Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner .slider-item-title' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'item_description_color',
                    [
                        'label'     => esc_html__('Description Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner .slider-item-description' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'arrow_button_color',
                    [
                        'label'     => esc_html__('Arrow Button Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner .slider-item-arrow' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'show_arrow_button' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_content_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );  

                $this->add_control(
                    'item_subtitle_hover',
                    [
                        'label'     => esc_html__('Subtitle Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner:hover .slider-item-subtitle' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'item_title_hover',
                    [
                        'label'     => esc_html__('Title Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner:hover .slider-item-title' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'item_description_hover',
                    [
                        'label'     => esc_html__('Description Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner:hover .slider-item-description' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'arrow_button_hover',
                    [
                        'label'     => esc_html__('Arrow Button Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner:hover .slider-item-arrow' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'show_arrow_button' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // ----------------------------------------- //
        // ---------- Slider Nav Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'slider_nav_settings_section',
            [
                'label'     => esc_html__('Slider Navigation Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('slider_pagination_settings_tabs');

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

        $this->end_controls_section();
    }

    protected function render() {
        $settings               = $this->get_settings();

        $view_type              = $settings['view_type'];
        $title                  = $settings['title'];
        $title_tag              = $settings['title_tag'];
        $add_subtitle           = $settings['add_subtitle'];
        $subtitle               = $settings['subtitle'];
        $add_button             = $settings['add_button'];
        $carousel_items         = $settings['carousel_items'];

        $items                  = $settings['items'];
        $dots                   = $settings['dots'];
        $speed                  = $settings['speed'];
        $infinite               = $settings['infinite'];
        $autoplay               = $settings['autoplay'];
        $autoplay_speed         = $settings['autoplay_speed'];
        $autoplay_timeout       = $settings['autoplay_timeout'];
        $pause_on_hover         = $settings['pause_on_hover'];

        $button_text    = $settings['button_text'];
        $button_link    = $settings['button_link'];

        if ($button_link['url'] !== '') {
            $button_url = $button_link['url'];
        } else {
            $button_url = '#';
        }

        $widget_class           = 'industrium-image-slider-widget';

        $widget_id              = $this->get_id();

        $dots_container_desktop = ( !empty($title) && !empty($widget_id) ? '.owl-dots-desktop.owl-dots-' . esc_attr($widget_id) : '.owl-dots-' . esc_attr($widget_id) );
        $dots_container_mobile  = ( !empty($title) && !empty($widget_id) ? '.owl-dots-mobile.owl-dots-' . esc_attr($widget_id) : $dots_container_desktop );

        $slider_options     = [
            'items'                 => !empty($items) ? (int)$items : 1,
            'nav'                   => false,
            'dots'                  => ('yes' === $dots),
            'dotsContainer'         => $dots_container_desktop,
            'dotsContainerMobile'   => $dots_container_mobile,
            'autoplayHoverPause'    => ('yes' === $pause_on_hover),
            'autoplay'              => ('yes' === $autoplay),
            'autoplaySpeed'         => absint($autoplay_speed),
            'autoplayTimeout'       => absint($autoplay_timeout),
            'loop'                  => ('yes' === $infinite),
            'speed'                 => absint($speed),
        ];
        $wrapper_attr       = ' data-slider-options=' . esc_attr(wp_json_encode($slider_options));
        $wrapper_class      = 'image-carousel owl-carousel owl-theme';

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="<?php echo esc_attr($widget_class); ?>">

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
                        if($view_type == 'type-3' && ($add_button == 'yes' || $dots == 'yes')) {
                            echo '<span class="pagination_wrapper">';
                                if($add_button == 'yes') { ?>
                                    <a class="industrium-button" href="<?php echo esc_url($button_url); ?>" <?php echo (($button_link['is_external'] == true) ? 'target="_blank"' : ''); echo (($button_link['nofollow'] == 'on') ? 'rel="nofollow"' : ''); ?>><?php echo esc_html($button_text); ?><svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5"></polyline></svg></a>
                                <?php }
                                if ( $dots == 'yes' ) {
                                    echo '<span class="owl-dots owl-dots-desktop' . (!empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '') . '"></span>';
                                }
                            echo '</span>';
                        }
                        if ( $view_type != 'type-3' && $dots == 'yes' ) {
                            echo '<span class="owl-dots owl-dots-desktop' . (!empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '') . '"></span>';
                        }
                    echo '</' . esc_html($title_tag) . '>';
                }
            ?>
            <div class="slider-wrapper">
                <?php
                    if($settings['show_custom_cursor'] == 'yes') { ?>
                        <div class="cursor_drag">
                            <div class="cursor-bg"></div>
                            <span></span>
                        </div>
                    <?php }
                ?>
                <div class="slider-container">
                    <div class="<?php echo esc_attr($wrapper_class); ?>"<?php echo esc_html($wrapper_attr); ?>>
                        <?php
                            foreach ($carousel_items as $item) {
                                echo '<div class="slider-item">';
                                    echo '<div class="slider-item-inner">';
                                        if( !empty($item['item_subtitle'])) {
                                            echo '<div class="slider-item-subtitle">' . esc_html($item['item_subtitle']) . '</div>';
                                        }
                                        if( !empty($item['image']) && !empty($item['image']['url'])) {
                                            echo '<div class="slider-item-media">';
                                                echo Group_Control_Image_Size::get_attachment_image_html( $item, 'image_thumbnail', 'image' );
                                            echo '</div>';
                                        }                                    
                                        if ( !empty($item['item_title']) ) {
                                            echo '<div class="slider-item-title">' . esc_html($item['item_title']) . '</div>';
                                        }
                                        if ( !empty($item['item_description']) ) {
                                            echo '<div class="slider-item-description">' . wp_kses($item['item_description'], array(
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
                                                )) . '</div>';
                                        }
                                        if( !empty($item['show_arrow_button']) ) {
                                            echo '<span class="slider-item-arrow"></span>';
                                        }
                                    echo '</div>';
                                echo '</div>';
                            }
                        ?>
                    </div>
                </div>
            </div>

            <?php
                if ( $dots == 'yes' ) {
                    if(!empty($title)) {
                        echo '<div class="owl-dots owl-dots-mobile' . ( !empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '' ) . '"></div>';      
                    } else {
                        echo '<div class="owl-dots' . ( !empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '' ) . '"></div>';
                    }
                }
            ?>

        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}

    private function get_link_url( $attachment, $instance ) {
        if ( 'none' === $instance['link_to'] ) {
            return false;
        }

        if ( 'custom' === $instance['link_to'] ) {
            if ( empty( $instance['link']['url'] ) ) {
                return false;
            }

            return $instance['link'];
        }

        return [
            'url' => wp_get_attachment_url( $attachment['id'] ),
        ];
    }

    private function get_image_caption( $attachment ) {
        $caption_type = $this->get_settings_for_display( 'caption_type' );

        if ( empty( $caption_type ) ) {
            return '';
        }

        $attachment_post = get_post( $attachment['id'] );

        if ( 'caption' === $caption_type ) {
            return $attachment_post->post_excerpt;
        }

        if ( 'title' === $caption_type ) {
            return $attachment_post->post_title;
        }

        return $attachment_post->post_content;
    }
}