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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Industrium_Icon_Box_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_icon_box';
    }

    public function get_title() {
        return esc_html__('Icon Box', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-icon-box';
    }

    public function get_categories() {
        return ['industrium_widgets'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Icon Box', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'icon_type',
            [
                'label'     => esc_html__('Type of Icon', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'default',
                'options'   => [
                    'default'   => esc_html__('Default Icon', 'industrium_plugin'),
                    'svg'       => esc_html__('SVG Icon', 'industrium_plugin')
                ]
            ]
        );

        $this->add_control(
            'default_icon',
            [
                'label'                     => esc_html__('Icon', 'industrium_plugin'),
                'type'                      => Controls_Manager::ICONS,
                'label_block'               => false,
                'default'                   => [
                    'value'     => 'fas fa-star',
                    'library'   => 'fa-solid'
                ],
                'skin'                      => 'inline',
                'exclude_inline_options'    => ['svg'],
                'condition'                 => [
                    'icon_type' => 'default'
                ]
            ]
        );

        $this->add_control(
            'svg_icon',
            [
                'label'         => esc_html__('SVG Icon', 'industrium_plugin'),
                'description'   => esc_html__('Enter svg code', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => '',
                'condition'     => [
                    'icon_type'     => 'svg'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_position',
            [
                'label'             => esc_html__( 'Icon Position', 'industrium_plugin' ),
                'type'              => Controls_Manager::CHOOSE,
                'options'           => [
                    'left'              => [
                        'title'             => esc_html__( 'Left', 'industrium_plugin' ),
                        'icon'              => 'eicon-h-align-left',
                    ],
                    'top'               => [
                        'title'             => esc_html__( 'Top', 'industrium_plugin' ),
                        'icon'              => 'eicon-v-align-top',
                    ],
                    'right'             => [
                        'title'             => esc_html__( 'Right', 'industrium_plugin' ),
                        'icon'              => 'eicon-h-align-right',
                    ]
                ],
                'prefix_class'      => 'icon-position%s-',
                'toggle'            => false,
                'default'           => 'top'
            ]
        );

        $this->add_control(
            'icon_vertical_position',
            [
                'label'             => esc_html__('Icon Vertical Alignment', 'industrium_plugin'),
                'type'              => Controls_Manager::CHOOSE,
                'options'           => [
                    'top'               => [
                        'title'             => esc_html__( 'Top', 'industrium_plugin' ),
                        'icon'              => 'eicon-v-align-top',
                    ],
                    'middle'            => [
                        'title'             => esc_html__( 'Middle', 'industrium_plugin' ),
                        'icon'              => 'eicon-v-align-middle',
                    ],
                    'bottom'            => [
                        'title'             => esc_html__( 'Bottom', 'industrium_plugin' ),
                        'icon'              => 'eicon-v-align-bottom',
                    ]
                ],
                'prefix_class'      => 'v-alignment-',
                'toggle'            => false,
                'default'           => 'top',
                'condition'         => [
                    'icon_position'   => ['left', 'right']
                ]
            ]
        );

        $this->add_control(
            'icon_box_align',
            [
                'label'             => esc_html__('Icon Box Alignment', 'industrium_plugin'),
                'type'              => Controls_Manager::CHOOSE,
                'options'           => [
                    'left'              => [
                        'title'             => esc_html__('Left', 'industrium_plugin'),
                        'icon'              => 'eicon-text-align-left',
                    ],
                    'center'            => [
                        'title'             => esc_html__('Center', 'industrium_plugin'),
                        'icon'              => 'eicon-text-align-center',
                    ],
                    'right'             => [
                        'title'             => esc_html__('Right', 'industrium_plugin'),
                        'icon'              => 'eicon-text-align-right',
                    ]
                ],
                'prefix_class'      => 'alignment-',
                'toggle'            => false,
                'default'           => 'center'
            ]
        );

        $this->add_control(
            'background_type',
            [
                'label'     => esc_html__('Type of Background', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'svg',
                'options'   => [
                    'none'              => esc_html__('None', 'industrium_plugin'),
                    'svg'               => esc_html__('SVG', 'industrium_plugin'),
                    'image'             => esc_html__('Image', 'industrium_plugin'),
                    'color'             => esc_html__('Color', 'industrium_plugin')
                ]
            ]
        );

        $this->add_control(
            'svg_background',
            [
                'label'         => esc_html__('SVG Background', 'industrium_plugin'),
                'description'   => esc_html__('Enter svg code', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => '',
                'condition'     => [
                    'background_type' => 'svg'
                ]
            ]
        );

        $this->start_controls_tabs('background_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'background_normal',
                [
                    'label'     => esc_html__('Normal', 'industrium_plugin'),
                    'condition' => [
                        'background_type' => 'image'
                    ]
                ]
            );

                $this->add_control(
                    'bg_image',
                    [
                        'label'     => esc_html__('Choose Background Image', 'industrium_plugin'),
                        'type'      => Controls_Manager::MEDIA,
                        'default'   => [],
                        'condition' => [
                            'background_type' => 'image'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'background_hover',
                [
                    'label'     => esc_html__('Hover', 'industrium_plugin'),
                    'condition' => [
                        'background_type' => 'image'
                    ]
                ]
            );

                $this->add_control(
                    'bg_image_hover',
                    [
                        'label'     => esc_html__('Choose Background Image', 'industrium_plugin'),
                        'type'      => Controls_Manager::MEDIA,
                        'default'   => [],
                        'condition' => [
                            'background_type' => 'image'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'title',
            [
                'label'         => esc_html__('Icon Box Title', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => esc_html__('Title', 'industrium_plugin'),
                'placeholder'   => esc_html__('Enter Icon Box Title', 'industrium_plugin'),
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'info',
            [
                'label' => esc_html__('Icon Box Information', 'industrium_plugin'),
                'type' => Controls_Manager::WYSIWYG,
                'rows' => '10',
                'default' => '',
                'placeholder' => esc_html__('Enter Your Custom Information', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'add_link',
            [
                'label'         => esc_html__('Add Link', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'link',
            [
                'label'         => esc_html__('Image Box Link', 'industrium_plugin'),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'default'       => [
                    'url'           => '',
                    'is_external'   => 'true',
                ],
                'placeholder'   => esc_html__( 'http://your-link.com', 'industrium_plugin' ),
                'condition' => [
                    'add_link' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'add_link_arrow',
            [
                'label'         => esc_html__('Show Link Arrow', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'condition' => [
                    'add_link' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'add_button_link',
            [
                'label'         => esc_html__('Add Button Link', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => '',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label'         => esc_html__('Image Box Button Link', 'industrium_plugin'),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'default'       => [
                    'url'           => '',
                    'is_external'   => 'true',
                ],
                'placeholder'   => esc_html__( 'http://your-link.com', 'industrium_plugin' ),
                'condition' => [
                    'add_button_link' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Icon Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'icon_settings',
            [
                'label' => esc_html__('Icon Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'icon_container_size',
            [
                'label'     => esc_html__('Icon Container Size', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 10,
                        'max'       => 280
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-container' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_background_size',
            [
                'label'     => esc_html__('Icon Background Size', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 10,
                        'max'       => 280
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-container .background' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'background_type!' => 'none'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => esc_html__('Icon Size', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 5,
                        'max'       => 280
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-container i' => 'font-size: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'icon_type' => 'default'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_svg_size',
            [
                'label'     => esc_html__('Icon Size', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 5,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-container .icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'icon_type' => 'svg'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'icon_shadow',
                'label'     => esc_html__('Icon Shadow', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .icon-container'
            ]
        );


        $this->start_controls_tabs('icon_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'icon_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'icon_color',
                    [
                        'label'     => esc_html__('Icon Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .icon-container i' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'default'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_svg_color',
                    [
                        'label'     => esc_html__('Icon Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .icon-container .icon svg' => 'fill: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'svg'
                        ]
                    ]
                );

                $this->add_control(
                    'background_svg_color',
                    [
                        'label'     => esc_html__('Background SVG Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .icon-container .background svg' => 'fill: {{VALUE}};'
                        ],
                        'condition' => [
                            'background_type' => 'svg',
                        ]
                    ]
                );

                $this->add_control(
                    'background_color',
                    [
                        'label'     => esc_html__('Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .icon-container' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'background_type' => 'color',
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'icon_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'icon_color_hover',
                    [
                        'label'     => esc_html__('Icon Color on Hover', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .icon-container i' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'default'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_svg_color_hover',
                    [
                        'label'     => esc_html__('Icon Color on Hover', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .icon-container .icon svg' => 'fill: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'svg'
                        ]
                    ]
                );

                $this->add_control(
                    'background_svg_color_hover',
                    [
                        'label'     => esc_html__('Background SVG on Hover', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .icon-container .background svg' => 'fill: {{VALUE}};'
                        ],
                        'condition' => [
                            'background_type' => 'svg'
                        ]
                    ]
                );

                $this->add_control(
                    'background_color_hover',
                    [
                        'label'     => esc_html__('Background Color on Hover', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .icon-container' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'background_type' => 'color'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_margin',
            [
                'label'         => esc_html__('Icon Margins', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .icon-box-item .icon-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_radius',
            [
                'label'         => esc_html__('Icon Border Radius', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .icon-box-item .icon-container.background-type-color' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'     => [
                    'background_type' => 'color'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------ //
        // ---------- Title Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'title_settings',
            [
                'label' => esc_html__('Title Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Title Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .icon-box-title'
            ]
        );

        $this->add_responsive_control(
            'title_arrow_size',
            [
                'label'     => esc_html__('Title Arrow Size', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-box-item.icon-box-header.with_arrow:before' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .icon-box-item.icon-box-header.with_arrow:after' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'add_link' => 'yes',
                    'add_link_arrow' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_arrow_line_height',
            [
                'label'     => esc_html__('Title Arrow Line Height', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ],
                    'em'  => [
                        'min'       => 0,
                        'max'       => 10,
                        'step' => 0.1
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-box-item.icon-box-header.with_arrow:before' => 'line-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .icon-box-item.icon-box-header.with_arrow:after' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'add_link' => 'yes',
                    'add_link_arrow' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('title_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'title_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label'     => esc_html__('Title Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .industrium-icon-box-widget > .icon-box-header .icon-box-title' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .icon-box-item-link' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .icon-box-item-link .icon-box-header svg' => 'fill: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'title_border_color',
                [
                    'label'     => esc_html__('Title Border Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .industrium-icon-box-widget > .icon-box-header' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .icon-box-item-link' => 'border-color: {{VALUE}};'                        
                    ]
                ]
            );

            $this->add_control(
                'title_arrow_color',
                [
                    'label'     => esc_html__('Title Arrow Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .icon-box-header:before' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .icon-box-item-link:hover .icon-box-header:before' => 'color: {{VALUE}};'
                    ],
                    'condition' => [
                        'add_link' => 'yes'
                    ]
                ]
            );

            $this->end_controls_tab();

            // ------------------------ //
            // ------ Hover Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'title_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );
            
            $this->add_control(
                'title_color_hover',
                [
                    'label'     => esc_html__('Title Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [                        
                        '{{WRAPPER}} .industrium-icon-box-widget > .icon-box-header:hover .icon-box-title' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .icon-box-item-link:hover' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .industrium-icon-box-widget > .icon-box-header:hover svg' => 'fill: {{VALUE}};',
                        '{{WRAPPER}} .icon-box-item-link:hover .icon-box-header svg' => 'fill: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'title_border_hover',
                [
                    'label'     => esc_html__('Title Border Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [                        
                        '{{WRAPPER}} .industrium-icon-box-widget:hover > .icon-box-header' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .icon-box-item-link:hover' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'title_arrow_hover',
                [
                    'label'     => esc_html__('Title Arrow Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .icon-box-item-link .icon-box-header:after' => 'color: {{VALUE}};'
                    ],
                    'condition' => [
                        'add_link' => 'yes'
                    ]
                ]
            );

        $this->end_controls_tabs();        

        $this->add_responsive_control(
            'title_margin',
            [
                'label'     => esc_html__('Space Between Title and Border', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .industrium-icon-box-widget > .icon-box-header' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .icon-box-item-link' => 'padding-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();


        // ---------------------------------------- //
        // ---------- Info Text Settings ---------- //
        // ---------------------------------------- //
        $this->start_controls_section(
            'text_settings',
            [
                'label' => esc_html__('Information Text Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'info_color',
            [
                'label'     => esc_html__('Information Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .icon-box-info' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->start_controls_tabs('button_link_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'button_link_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin'),
                    'condition' => [
                        'add_button_link' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'button_link_color',
                [
                    'label'     => esc_html__('Button Link Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .icon-box-button-link' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            // ------------------------ //
            // ------ Hover Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'button_link_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin'),
                    'condition' => [
                        'add_button_link' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'button_link_color_hover',
                [
                    'label'     => esc_html__('Button Link Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .icon-box-button-link:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();


        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'info_typography',
                'label'     => esc_html__('Information Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .icon-box-info, {{WRAPPER}} .icon-box-info p'
            ]
        );

        $this->add_responsive_control(
            'info_margin',
            [
                'label'     => esc_html__('Space Between Title and Text', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-box-content' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'button_link_padding',
            [
                'label'         => esc_html__('Button Link Padding', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .icon-box-button-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'add_button_link' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings        = $this->get_settings();

        $icon_type       = $settings['icon_type'];
        $default_icon    = $settings['default_icon'];
        $svg_icon        = $settings['svg_icon'];
        $add_link        = $settings['add_link'];
        $add_link_arrow  = $settings['add_link_arrow'];
        $link            = $settings['link'];
        $add_button_link = $settings['add_button_link'];
        $button_link     = $settings['button_link'];

        $background_type = $settings['background_type'];

        if ( $background_type == 'svg' ) {
            $svg_background = $settings['svg_background'];
        }
        if ( $background_type == 'image' ) {
            $bg_image = !empty($settings['bg_image']['url']) ? $settings['bg_image'] : array();
        }

        $title              = $settings['title'];
        $info               = $settings['info'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="industrium-icon-box-widget">
            <?php 
                $is_link = ($add_link == 'yes' && !empty($link) && $link['url'] !== '');
                if($is_link) {
                    echo '<a class="icon-box-item-link" href="' . esc_url($link['url']) . '"';
                        echo (($link['is_external'] == true) ? ' target="_blank"' : ''); echo (($link['nofollow'] == 'on') ? 'rel="nofollow"' : '');
                    echo '>';
                }
            ?>
            <?php
                $header_class = 'icon-box-item icon-box-header' . ($add_link_arrow == 'yes' ? ' with_arrow' : '');
            ?>
            <div class="<?php esc_attr_e($header_class);?>">
                <span class="icon-container<?php echo ( !empty($background_type) ? ' background-type-' . esc_attr($background_type) : '' ); ?>">
                    <?php
                    if ($icon_type == 'default') {
                        echo '<i class="' . esc_attr($default_icon['value']) . '"></i>';
                    }
                    if ($icon_type == 'svg') {
                        echo '<span class="icon">' . industrium_output_code($svg_icon) . '</span>';
                    }

                    if ($background_type == 'image') {
                        if (!empty($bg_image['url'])) {
                            echo '<img class="icon-container-bg-image" src="' . esc_url($bg_image['url']) . '" alt="' . esc_html__('Background Image', 'industrium_plugin') . '" />';
                        }
                    }
                    if ($background_type == 'svg' && !empty($svg_background)) {
                        echo '<span class="background">' . industrium_output_code($svg_background) . '</span>';
                    }
                    ?>
                </span>
                <?php
                    if ($title !== '') {
                        echo '<h5 class="icon-box-title">';
                            echo '<span class="industrium-heading-content">' . industrium_output_code($title) . '</span>';
                        echo '</h5>';
                    }
                ?>
            </div>
            <?php 
                if($is_link) {                   
                    echo '</a>';
                }
                if ($info !== '' || ($add_button_link == 'yes' && !empty($button_link) && $button_link['url'] !== '')) { ?>
                    <div class="icon-box-item icon-box-content">
                        <div class="content-container">                    
                            <?php
                                if($info !== '') {
                                    echo '<div class="icon-box-info">';
                                        echo industrium_output_code($info);
                                    echo '</div>';
                                }
                                if($add_button_link == 'yes' && !empty($button_link) && $button_link['url'] !== '') {
                                    echo '<a class="icon-box-button-link fontello icon-button-arrow" href="' . esc_url($button_link['url']) . '"';
                                        echo (($button_link['is_external'] == true) ? 'target="_blank"' : ''); echo (($button_link['nofollow'] == 'on') ? 'rel="nofollow"' : '');
                                    echo '></a>';
                                }
                            ?>
                        </div>
                    </div>
                <?php }
            ?>            
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}