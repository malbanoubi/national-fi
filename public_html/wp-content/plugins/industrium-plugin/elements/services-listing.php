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
use Elementor\REPEATER;
use Elementor\Utils;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Industrium_Services_Listing_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_services_listing';
    }

    public function get_title() {
        return esc_html__('Services Listing', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function is_reload_preview_required() {
        return true;
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
                'label' => esc_html__('Services Listing', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'listing_type',
            [
                'label'         => esc_html__('Listing Type', 'industrium_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'grid',
                'options'       => [
                    'grid'          => esc_html__('Grid', 'industrium_plugin'),
                    'slider'        => esc_html__('Slider', 'industrium_plugin')
                ]
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
                    'type-2'          => esc_html__('Type 2', 'industrium_plugin'),
                    'type-3'          => esc_html__('Type 3', 'industrium_plugin'),
                    'type-4'          => esc_html__('Type 4', 'industrium_plugin'),
                    'type-5'          => esc_html__('Type 5', 'industrium_plugin'),
                ],
                'prefix_class'  => 'view_',
                'condition' => [
                    'listing_type' => 'slider'
                ]
            ]
        );

        $this->add_control(
            'style_type',
            [
                'label'         => esc_html__('Style Type', 'industrium_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'type-1',
                'options'       => [
                    'type-1'          => esc_html__('Type 1', 'industrium_plugin'),
                    'type-2'          => esc_html__('Type 2', 'industrium_plugin')
                ],
                'prefix_class'  => 'style_',
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => ['type-2', 'type-5']
                ]
            ]
        );

        $this->add_control(
            'post_order_by',
            [
                'label'         => esc_html__('Order By', 'industrium_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'date',
                'options'       => [
                    'date'          => esc_html__('Post Date', 'industrium_plugin'),
                    'rand'          => esc_html__('Random', 'industrium_plugin'),
                    'ID'            => esc_html__('Post ID', 'industrium_plugin'),
                    'title'         => esc_html__('Post Title', 'industrium_plugin')
                ]
            ]
        );

        $this->add_control(
            'post_order',
            [
                'label'         => esc_html__('Order', 'industrium_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'desc',
                'options'       => [
                    'desc'          => esc_html__('Descending', 'industrium_plugin'),
                    'asc'           => esc_html__('Ascending', 'industrium_plugin')
                ]
            ]
        );

        $this->add_control(
            'filter_by',
            [
                'label'         => esc_html__('Filter by:', 'industrium_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'none',
                'options'       => [
                    'none'          => esc_html__('None', 'industrium_plugin'),
                    'cat'           => esc_html__('Department', 'industrium_plugin'),
                    'id'            => esc_html__('ID', 'industrium_plugin')
                ],
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'         => esc_html__('Categories', 'industrium_plugin'),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'description'   => esc_html__('List of categories.', 'industrium_plugin'),
                'options'       => industrium_get_all_taxonomy_terms('industrium_service', 'industrium_services_category'),
                'condition'     => [
                    'filter_by'     => 'cat'
                ]
            ]
        );

        $this->add_control(
            'services',
            [
                'label'         => esc_html__('Choose Services', 'industrium_plugin'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => industrium_get_all_post_list('industrium_service'),
                'label_block'   => true,
                'multiple'      => true,
                'condition'     => [
                    'filter_by'     => 'id'
                ]
            ]
        );

        $this->add_responsive_control(
            'services_align',
            [
                'label'         => esc_html__('Alignment', 'industrium_plugin'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'          => [
                        'title'         => esc_html__('Left', 'industrium_plugin'),
                        'icon'          => 'eicon-text-align-left',
                    ],
                    'center'        => [
                        'title'         => esc_html__('Center', 'industrium_plugin'),
                        'icon'          => 'eicon-text-align-center',
                    ],
                    'right'         => [
                        'title'         => esc_html__('Right', 'industrium_plugin'),
                        'icon'          => 'eicon-text-align-right',
                    ]
                ],
                'default'       => 'left',
                'selectors'     => [
                    '{{WRAPPER}} .service-item' => 'text-align: {{VALUE}};'
                ],
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'     => esc_html__('Excerpt Length, in symbols', 'industrium_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 0,
                'default'   => '',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'view_type',
                            'operator' => '===',
                            'value' => 'type-2',
                        ],
                        [
                            'name' => 'view_type',
                            'operator' => '===',
                            'value' => 'type-5',
                        ],
                        [
                            'name' => 'listing_type',
                            'operator' => '===',
                            'value' => 'grid',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'         => esc_html__('Show Pagination', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'separator'     => 'before',
                'condition' => [
                    'listing_type' => 'grid'
                ]
            ]
        );

        $this->end_controls_section();


        // ----------------------------------- //
        // ---------- Grid Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_grid_settings',
            [
                'label'         => esc_html__('Grid Settings', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'grid_columns_number',
            [
                'label'         => esc_html__('Columns Number', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 4,
                'min'           => 1,
                'max'           => 6
            ]
        );

        $this->add_control(
            'grid_posts_per_page',
            [
                'label'         => esc_html__('Items Per Page', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 4,
                'min'           => -1
            ]
        );

        $this->end_controls_section();

        // ---------------------------- //
        // ---------- Slider ---------- //
        // ---------------------------- //
        $this->start_controls_section(
            'section_slider',
            [
                'label' => esc_html__('Slider Settings', 'industrium_plugin'),
                'condition' => [
                    'listing_type' => 'slider'
                ]
            ]
        );

        $this->add_control(
            'columns_number',
            [
                'label'     => esc_html__('Columns Number', 'industrium_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 3,
                'min'       => 1,
                'max'       => 4
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

        $this->add_responsive_control(
            'dots_padding',
            [
                'label'         => esc_html__( 'Pagination dots padding', 'industrium_plugin' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .owl-dots' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'dots'      => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'slider_width',
            [
                'label'         => esc_html__( 'Slider width', 'industrium_plugin' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => [ 'px', '%', 'vw' ],
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
                    'vw' => [
                        'min' => 0,
                        'max' => 150,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .industrium-service-listing-widget .archive-listing' => 'max-width: {{SIZE}}{{UNIT}};'
                ],
                'condition'     => [
                    'view_type' => 'type-5'
                ]
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
                ],
                'condition'     => [
                    'view_type' => 'type-2',
                    'style_type' => 'type-1'
                ]
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
            'item_height',
            [
                'label'     => esc_html__('Item Height', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 1000
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 590
                ],
                'selectors' => [
                    '{{WRAPPER}}.view_type-3 .service-item .service-slider-item-link'    => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.view_type-5 .service-item .service-slider-item-link'    => 'height: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => ['type-3', 'type-5']
                ]
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
                    '{{WRAPPER}} .service-listing-wrapper .service-item-wrapper'    => 'padding: calc({{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .service-listing-wrapper'                          => 'margin: calc(-{{SIZE}}{{UNIT}}/2); width: calc(100% + {{SIZE}}{{UNIT}});'
                ]
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'     => esc_html__('Item Padding', 'industrium_plugin'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}}.view_type-1 .service-item .service-slider-item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}}.view_type-1 .service-item .service-slider-link-inner' => 'padding-bottom: {{BOTTOM}}{{UNIT}};',
                    '{{WRAPPER}}.view_type-3 .service-item .service-slider-link-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}}.view_type-5 .service-item .service-slider-link-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type!' => 'type-2'
                ]
            ]
        );  

        $this->add_control(
            'bg_blend_mode',
            [
                'label' => esc_html__( 'Background Blend Mode', 'industrium_plugin' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal'  => esc_html__( 'Normal', 'industrium_plugin' ),
                    'multiply' => esc_html__( 'Multiply', 'industrium_plugin' ),
                    'screen' => esc_html__( 'Screen', 'industrium_plugin' ),
                    'overlay' => esc_html__( 'Overlay', 'industrium_plugin' ),
                    'darken' => esc_html__( 'Darken', 'industrium_plugin' ),
                    'lighten' => esc_html__( 'Lighten', 'industrium_plugin' ),
                    'color-dodge' => esc_html__( 'Color Dodge', 'industrium_plugin' ),
                    'saturation' => esc_html__( 'Saturation', 'industrium_plugin' ),
                    'color' => esc_html__( 'Color', 'industrium_plugin' ),
                    'luminosity' => esc_html__( 'Luminosity', 'industrium_plugin' )
                ],
                'selectors' => [
                    '{{WRAPPER}}.view_type-1 .service-item .service-slider-item-link' => 'background-blend-mode: {{VALUE}};',
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-1'
                ]
            ]
        );

        $this->start_controls_tabs('item_colors_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_item_colors_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'service_background_color',
                    [
                        'label'     => esc_html__('Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-grid-listing .service-item' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}} .service-slider-listing .service-slider-item-link' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'service_content_background_color',
                    [
                        'label'     => esc_html__('Content Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}.view_type-2 .service-item .service-item-content' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'view_type' => 'type-2'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'service_shadow',
                        'label'     => esc_html__('Item Shadow', 'industrium_plugin'),
                        'selector'  => '{{WRAPPER}} .service-item'
                    ]
                );

            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_item_colors_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'service_background_hover',
                    [
                        'label'     => esc_html__('Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-grid-listing .service-item:hover' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}} .service-slider-listing .service-item:hover .service-slider-item-link' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'service_content_background_hover',
                    [
                        'label'     => esc_html__('Content Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}.view_type-2 .service-item:hover .service-item-content' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'view_type' => 'type-2'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'service_hover_shadow',
                        'label'     => esc_html__('Item Shadow', 'industrium_plugin'),
                        'selector'  => '{{WRAPPER}} .service-item:hover'
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // ----------------------------------- //
        // ---------- Icon Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'icon_settings_section',
            [
                'label'     => esc_html__('Icon Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'listing_type',
                            'operator' => '===',
                            'value' => 'grid',
                        ],
                        [
                            'name' => 'view_type',
                            'operator' => 'in',
                            'value' => ['type-1', 'type-3', 'type-5'],
                        ]
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'service_icon_size',
            [
                'label'     => esc_html__('Icon Size', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 10,
                        'max'       => 280
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .service-item .service-icon' => 'font-size: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'service_icon_cont_size',
            [
                'label'     => esc_html__('Icon Container Size', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 10,
                        'max'       => 500
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .service-item .service-item-icon' => 'min-width: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'service_icon_space',
            [
                'label'     => esc_html__('Space After Icon', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .service-item .service-item-icon:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .service-item .service-item-icon:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before',
                'condition' => [
                    'listing_type' => 'grid'
                ]
            ]
        );

        $this->start_controls_tabs('icon_colors_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_icon_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

            $this->add_control(
                'service_icon_color',
                [
                    'label'     => esc_html__('Icon Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .service-item .service-item-icon i' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_icon_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );

            $this->add_control(
                'service_icon_hover',
                [
                    'label'     => esc_html__('Icon Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .service-item .service-item-link:hover .service-item-icon i' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .service-item .service-slider-item-link:hover .service-item-icon i' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Media Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'media_settings_section',
            [
                'label'     => esc_html__('Media Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'view_type' => 'type-2'
                ]
            ]
        );
        $this->start_controls_tabs( 'image_effects' );

        $this->start_controls_tab( 'normal',
            [
                'label' => esc_html__( 'Normal', 'industrium_plugin' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .service-item .service-item-media img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover',
            [
                'label' => esc_html__( 'Hover', 'industrium_plugin' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .service-item:hover .service-item-media img',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

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
                'name'      => 'title_typography',
                'label'     => esc_html__('Title Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .service-item .service-post-title'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'subtitle_typography',
                'label'     => esc_html__('Subtitle Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .service-item .service-item-subtitle',
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => ['type-1', 'type-3']
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'excerpt_typography',
                'label'     => esc_html__('Excerpt Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .service-item .service-item-excerpt',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'view_type',
                            'operator' => '===',
                            'value' => 'type-2',
                        ],
                        [
                            'name' => 'view_type',
                            'operator' => '===',
                            'value' => 'type-5',
                        ],
                        [
                            'name' => 'listing_type',
                            'operator' => '===',
                            'value' => 'grid',
                        ]
                    ]
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'counter_typography',
                'label'     => esc_html__('Counter Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .service-item .service-item-number',
                'condition' => [
                    'listing_type' => 'slider'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label'     => esc_html__('Title Padding', 'industrium_plugin'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}}.view_type-1 .service-item .service-post-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}}.view_type-2 .service-item .service-post-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}}.view_type-3 .service-item .service-post-title > span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}}.view_type-4 .service-item .service-post-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}}.view_type-5 .service-item .service-post-title > span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'space_icon',
            [
                'label' => esc_html__( 'Space before icon', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}}.view_type-1 .service-item .service-item-icon:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-1'
                ]
            ]
        );

        $this->add_responsive_control(
            'space_title',
            [
                'label' => esc_html__( 'Space before title', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}}.view_type-1 .service-item .service-post-title:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-1'
                ]
            ]
        );

        $this->add_responsive_control(
            'space_button',
            [
                'label' => esc_html__( 'Space before arrow button', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}}.view_type-1 .service-item .service-item-button:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-1'
                ]
            ]
        );

        $this->add_responsive_control(
            'space_excerpt',
            [
                'label' => esc_html__( 'Space before excerpt', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}}.view_type-2 .service-item:hover .service-item-excerpt:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.view_type-5 .service-item:hover .service-item-excerpt:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => ['type-2', 'type-5']
                ]
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'         => esc_html__('Content Padding', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em'],
                'selectors'     => [
                    '{{WRAPPER}}.view_type-2 .service-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-2'
                ]
            ]
        );

        $this->add_responsive_control(
            'counter_padding',
            [
                'label'         => esc_html__('Counter Padding', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em'],
                'selectors'     => [
                    '{{WRAPPER}}.view_type-2 .service-item-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-2'
                ]
            ]
        );

        $this->end_controls_section(); 

        // -------------------------------------- //
        // ---------- Color Settings ------------ //
        // -------------------------------------- //

        $this->start_controls_section(
            'color_settings_section',
            [
                'label'     => esc_html__('Color Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );
        $this->start_controls_tabs('content_colors_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_colors_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'service_title_color',
                    [
                        'label'     => esc_html__('Title Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-item .service-post-title' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .service-item .service-post-title a' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'service_subtitle_color',
                    [
                        'label'     => esc_html__('Subtitle Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-item .service-item-subtitle' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type' => 'slider',
                            'view_type' => ['type-1', 'type-3']
                        ]
                    ]
                );

                $this->add_control(
                    'service_excerpt_color',
                    [
                        'label'     => esc_html__('Excerpt Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-item .service-item-excerpt' => 'color: {{VALUE}};',
                        ],
                        'conditions' => [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'view_type',
                                    'operator' => '===',
                                    'value' => 'type-2',
                                ],
                                [
                                    'name' => 'view_type',
                                    'operator' => '===',
                                    'value' => 'type-5',
                                ],
                                [
                                    'name' => 'listing_type',
                                    'operator' => '===',
                                    'value' => 'grid',
                                ]
                            ]
                        ]
                    ]
                );

                $this->add_control(
                    'service_title_arrow_color',
                    [
                        'label'     => esc_html__('Title Arrow Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-item .service-post-title:before' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .service-item .service-item-button' => 'color: {{VALUE}};'
                        ],
                        'conditions' => [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'view_type',
                                    'operator' => '!==',
                                    'value' => 'type-4',
                                ],
                                [
                                    'name' => 'listing_type',
                                    'operator' => '===',
                                    'value' => 'grid',
                                ]
                            ]
                        ]
                    ]
                );

                $this->add_control(
                    'service_title_border_color',
                    [
                        'label'     => esc_html__('Title Border Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-item .service-item-link' => 'border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type' => 'grid'
                        ]
                    ]
                );

                $this->add_control(
                    'service_counter_color',
                    [
                        'label'     => esc_html__('Counter Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-item .service-item-number' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type' => 'slider'
                        ]
                    ]
                );

                $this->add_control(
                    'service_bg_color',
                    [
                        'label'     => esc_html__('Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}.view_type-3 .service-item .service-slider-item-link:before' => 'background-image: linear-gradient(0deg, {{VALUE}}, rgba(255, 255, 255, 0) 41%, rgba(255, 255, 255, 0));',
                            '{{WRAPPER}}.view_type-5 .service-item .service-slider-item-link:before' => 'background-image: linear-gradient(0deg, {{VALUE}}, rgba(255, 255, 255, 0));'
                        ],
                        'condition' => [
                            'listing_type' => 'slider',
                            'view_type' => ['type-3', 'type-5']
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_colors_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );                

                $this->add_control(
                    'service_link_hover',
                    [
                        'label'     => esc_html__('Title Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-item .service-item-header:hover .service-post-title' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .service-item .service-item-header:hover .service-post-title:before' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .service-item:hover .service-post-title' => 'color: {{VALUE}};',
                            '{{WRAPPER}}.view_type-4 .service-item .service-post-title a:hover' => 'color: {{VALUE}};',
                        ]
                    ]
                );

                $this->add_control(
                    'service_subtitle_hover',
                    [
                        'label'     => esc_html__('Subtitle Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-item:hover .service-item-subtitle' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type' => 'slider',
                            'view_type' => ['type-1', 'type-3']
                        ]
                    ]
                );

                $this->add_control(
                    'service_excerpt_hover',
                    [
                        'label'     => esc_html__('Excerpt Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-item:hover .service-item-excerpt' => 'color: {{VALUE}};'
                        ],
                        'conditions' => [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'view_type',
                                    'operator' => '===',
                                    'value' => 'type-2',
                                ],
                                [
                                    'name' => 'view_type',
                                    'operator' => '===',
                                    'value' => 'type-5',
                                ],
                                [
                                    'name' => 'listing_type',
                                    'operator' => '===',
                                    'value' => 'grid',
                                ]
                            ]
                        ]
                    ]
                );

                $this->add_control(
                    'service_title_arrow_hover',
                    [
                        'label'     => esc_html__('Title Arrow Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-item .service-item-header:hover .service-post-title:before' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .service-item:hover .service-item-button' => 'color: {{VALUE}};',
                            '{{WRAPPER}}.view_type-2 .service-item:hover .service-post-title:before' => 'color: {{VALUE}};',
                            '{{WRAPPER}}.view_type-3 .service-item:hover .service-post-title:before' => 'color: {{VALUE}};'
                        ],
                        'conditions' => [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'view_type',
                                    'operator' => '!==',
                                    'value' => 'type-4',
                                ],
                                [
                                    'name' => 'listing_type',
                                    'operator' => '===',
                                    'value' => 'grid',
                                ]
                            ]
                        ]
                    ]
                );

                $this->add_control(
                    'service_title_border_hover',
                    [
                        'label'     => esc_html__('Title Border Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-item .service-item-header:hover .service-item-link' => 'border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type' => 'grid'
                        ]
                    ]
                );

                $this->add_control(
                    'service_counter_hover',
                    [
                        'label'     => esc_html__('Counter Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .service-item:hover .service-item-number' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type' => 'slider'
                        ]
                    ]
                );

                $this->add_control(
                    'service_bg_color_hover',
                    [
                        'label'     => esc_html__('Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}.view_type-3 .service-item .service-slider-item-link:after' => 'background-image: linear-gradient(0deg, {{VALUE}}, rgba(255, 255, 255, 0) 41%, rgba(255, 255, 255, 0));',
                            '{{WRAPPER}}.view_type-5 .service-item .service-slider-item-link:after' => 'background-image: linear-gradient(0deg, {{VALUE}}, rgba(255, 255, 255, 0));'
                        ],
                        'condition' => [
                            'listing_type' => 'slider',
                            'view_type' => ['type-3', 'type-5']
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_control(
            'decoration_main_color',
            [
                'label'     => esc_html__('Decoration Main Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.view_type-4 .service-item .service-slider-item-link:before' => 'background-color: {{VALUE}};'
                ],
                'separator' => 'before',
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-4'
                ]
            ]
        );

        $this->add_control(
            'decoration_sec_color',
            [
                'label'     => esc_html__('Decoration Secondary Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.view_type-4 .service-item .service-slider-item-link:after' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-4'
                ]
            ]
        );

        $this->end_controls_section();


        // ----------------------------------------- //
        // ---------- Pagination Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'pagination_settings_section',
            [
                'label'     => esc_html__('Pagination Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_pagination'   => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'pagination_typography',
                'label'     => esc_html__('Pagination Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .content-pagination .page-numbers, {{WRAPPER}} .content-pagination .post-page-numbers'
            ]
        );

        $this->start_controls_tabs('pagination_settings_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_pagination_normal',
                [
                    'label'     => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'pagination_color',
                    [
                        'label'     => esc_html__('Pagination Text Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers, {{WRAPPER}} .content-pagination .post-page-numbers' => 'color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_control(
                    'pagination_border_color',
                    [
                        'label'     => esc_html__('Pagination Border Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers, {{WRAPPER}} .content-pagination .post-page-numbers' => 'border-color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_control(
                    'pagination_background_color',
                    [
                        'label'     => esc_html__('Pagination Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers:not(.current), {{WRAPPER}} .content-pagination .post-page-numbers:not(.current)' => 'background-color: {{VALUE}};'
                        ],
                    ]
                );

            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_pagination_active',
                [
                    'label'     => esc_html__('Active', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'pagination_color_active',
                    [
                        'label'     => esc_html__('Pagination Text Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers.current, {{WRAPPER}} .content-pagination .post-page-numbers.current, {{WRAPPER}} .content-pagination .page-numbers:hover, {{WRAPPER}} .content-pagination .post-page-numbers:hover' => 'color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_control(
                    'pagination_border_color_active',
                    [
                        'label'     => esc_html__('Pagination Border Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers.current, {{WRAPPER}} .content-pagination .post-page-numbers.current, {{WRAPPER}} .content-pagination .page-numbers:hover, {{WRAPPER}} .content-pagination .post-page-numbers:hover' => 'border-color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_control(
                    'pagination_background_color_active',
                    [
                        'label'     => esc_html__('Pagination Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers:after, {{WRAPPER}} .content-pagination .post-page-numbers:after' => 'background-color: {{VALUE}};'
                        ],
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
                'label'         => esc_html__('Slider Navigation Settings', 'consultum_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'listing_type' => 'slider'
                ]
            ]
        );

        $this->start_controls_tabs(
            'slider_pagination_settings_tabs',
            [                
                'conditions'    => [
                    'relation'  => 'and',
                    'terms'     => [
                        [
                            'name'      => 'dots',
                            'operator'  => '==',
                            'value'     => 'yes'
                        ],
                        [
                            'name'      => 'listing_type',
                            'operator'  => '==',
                            'value'     => 'slider'
                        ],
                    ],
                ]
            ]
        );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'slider_dots_normal',
                [
                    'label' => esc_html__('Normal', 'consultum_plugin')
                ]
            );

                $this->add_control(
                    'dot_color',
                    [
                        'label'     => esc_html__('Pagination Dot Color', 'consultum_plugin'),
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
                    'label' => esc_html__('Active', 'consultum_plugin')
                ]
            );

                $this->add_control(
                    'dot_active',
                    [
                        'label'     => esc_html__('Pagination Active Dot Color', 'consultum_plugin'),
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
                'conditions'    => [
                    'relation'  => 'and',
                    'terms'     => [
                        [
                            'name'      => 'nav',
                            'operator'  => '==',
                            'value'     => 'yes'
                        ],
                        [
                            'name'      => 'listing_type',
                            'operator'  => '==',
                            'value'     => 'slider'
                        ],
                    ],
                ]
            ]
        );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_arrows_normal',
                [
                    'label' => esc_html__('Normal', 'consultum_plugin')
                ]
            );

                $this->add_control(
                    'nav_color',
                    [
                        'label'     => esc_html__('Slider Arrows Color', 'consultum_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]:before' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'nav_bd',
                    [
                        'label'     => esc_html__('Slider Arrows Border', 'consultum_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'nav_bg',
                    [
                        'label'     => esc_html__('Slider Arrows Background', 'consultum_plugin'),
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
                    'label' => esc_html__('Hover', 'consultum_plugin')
                ]
            );

                $this->add_control(
                    'nav_hover',
                    [
                        'label'     => esc_html__('Slider Arrows Color', 'consultum_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]:not(.disabled):hover:before' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'nav_bd_hover',
                    [
                        'label'     => esc_html__('Slider Arrows Border', 'consultum_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]:not(.disabled):hover' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'nav_bg_hover',
                    [
                        'label'     => esc_html__('Slider Arrows Background', 'consultum_plugin'),
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
        $settings       = $this->get_settings();

        $listing_type           = $settings['listing_type'];
        $view_type              = $settings['view_type'];
        $post_order_by          = $settings['post_order_by'];
        $post_order             = $settings['post_order'];
        $filter_by              = $settings['filter_by'];
        $categories             = $settings['categories'];
        $services               = $settings['services'];
        $pagination             = $settings['show_pagination'];
        $paged                  = isset( $_GET[esc_attr($this->get_id()) . '-paged'] ) && $pagination == 'yes' ? (int)$_GET[esc_attr($this->get_id()) . '-paged'] : 1;

        $grid_columns_number    = $settings['grid_columns_number'];
        $grid_posts_per_page    = $settings['grid_posts_per_page'];
        $excerpt_length         = $settings['excerpt_length'];

        $columns_number         = $settings['columns_number'];
        $nav                    = $settings['nav'];
        $dots                   = $settings['dots'];
        $speed                  = $settings['speed'];
        $infinite               = $settings['infinite'];
        $autoplay               = $settings['autoplay'];
        $autoplay_speed         = $settings['autoplay_speed'];
        $autoplay_timeout       = $settings['autoplay_timeout'];
        $pause_on_hover         = $settings['pause_on_hover'];

        $widget_class           = 'industrium-service-listing-widget';
        $wrapper_class          = 'archive-listing-wrapper service-listing-wrapper';

        global $wp;
        $base = home_url($wp->request);

        $query_options          = [
            'post_type'             => 'industrium_service',
            'ignore_sticky_posts'   => true,
            'suppress_filters'      => true,
            'orderby'               => sanitize_key($post_order_by),
            'order'                 => sanitize_key($post_order),
            'link_base'             => esc_url($base)
        ];

        if ( $filter_by == 'cat' ) {
            $query_options = array_merge($query_options, [
                'industrium_services_category'  => $categories
            ]);
        } elseif ( $filter_by == 'id' ) {
            $query_options = array_merge($query_options, [
                'post__in'          => $services
            ]);
        };

        $widget_options = array(
            'excerpt_length' => $excerpt_length
        );
        $wrapper_attr = '';

        if($listing_type == 'grid') {
            $wrapper_class      .= ' service-grid-listing' . ( !empty($grid_columns_number) ? ' columns-' . esc_attr($grid_columns_number) : '' );
            $widget_options     = array(
                'item_class'            => 'service-item-wrapper',
                'columns_number'        => absint($grid_columns_number),
                'excerpt_length'        => $excerpt_length
            );
            $query_options      = array_merge($query_options, [
                'posts_per_page'        => ( !empty($grid_posts_per_page) ? $grid_posts_per_page : -1 ),
                'columns_number'        => $grid_columns_number,
                'paged'                 => $paged
            ]);
        } else {
            $widget_id          = $this->get_id();
            $slider_options     = [
                'items'                 => !empty($columns_number) ? (int)$columns_number : 1,
                'nav'                   => ('yes' === $nav),
                'dots'                  => ('yes' === $dots),
                'dotsContainer'         => !empty($widget_id) ? '.owl-dots-' . esc_attr($widget_id) : false,
                'autoplayHoverPause'    => ('yes' === $pause_on_hover),
                'autoplay'              => ('yes' === $autoplay),
                'autoplaySpeed'         => absint($autoplay_speed),
                'autoplayTimeout'       => absint($autoplay_timeout),
                'loop'                  => ('yes' === $infinite),
                'speed'                 => absint($speed),
                'view_type'             => $view_type
            ];
            $widget_options     = array_merge($widget_options, [
                'item_class'            => 'service-item-wrapper slider-item',
                'columns_number'        => absint($columns_number),
                'listing_type'          => 'slider',
                'view_type'             => $view_type
            ]);
            $query_options      = array_merge($query_options, [
                'posts_per_page'        => -1
            ]);
            $wrapper_attr       .= ' data-slider-options=' . esc_attr(wp_json_encode($slider_options));
            $wrapper_class      .= ' service-slider-listing owl-carousel owl-theme';
        }
        

        $query = new \WP_Query($query_options);
        $ajax_data = wp_json_encode($query_options);
        $widget_data = wp_json_encode($widget_options);

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="<?php echo esc_attr($widget_class); ?>">

            <div class="archive-listing" data-ajax='<?php echo esc_attr($ajax_data); ?>' data-widget='<?php echo esc_attr($widget_data); ?>'>
                <div class="<?php echo esc_attr($wrapper_class); ?>"<?php echo esc_html($wrapper_attr); ?>>
                    <?php
                        if($listing_type == 'slider') {
                            $counter = 0;
                        }
                        while( $query->have_posts() ){
                            if($listing_type == 'slider') {
                                $counter++;
                                $widget_options['service_counter'] = $counter;
                            }
                            $query->the_post();
                            get_template_part('content', 'industrium_service', $widget_options);
                        };
                        wp_reset_postdata();
                    ?>
                </div>

                <?php
                    if ( $pagination == 'yes' ) {
                        echo paginate_links( array(
                            'format'    => '?' . esc_attr($this->get_id()) . '-paged=%#%',
                            'current'   => max( 1, $paged ),
                            'total'     => $query->max_num_pages,
                            'end_size'  => 2,
                            'prev_text' => '<div class="button-icon"></div>',
                            'next_text' => '<div class="button-icon"></div>'
                        ) );
                    }
                ?>
            </div>
            <?php
                if ( $listing_type == 'slider' ) {
                    echo '<div class="owl-dots' . ( !empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '' ) . '"></div>';
                }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}