<?php
/*
 * Created by Artureanec
*/

namespace Industrium\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\REPEATER;
use Elementor\Utils;
use Elementor\Embed;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Industrium_Content_Slider_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_content_slider';
    }

    public function get_title() {
        return esc_html__('Content Slider', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-post-slider';
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
                'label' => esc_html__('Content Slider', 'industrium_plugin')
            ]
        );

        $this->add_responsive_control(
            'slider_height',
            [
                'label'     => esc_html__('Slider Height', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 10,
                        'max'       => 2000,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .content-item' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'add_scroll_down',
            [
                'label'         => esc_html__('Show "Scroll Down" button', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'no',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'scroll_down_position',
            [
                'label'     => esc_html__( 'Button position', 'industrium_plugin' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left'      => esc_html__( 'Left', 'industrium_plugin' ),
                    'right'     => esc_html__( 'Right', 'industrium_plugin' )
                ],
                'condition' => [
                    'add_scroll_down'   => 'yes'
                ]
            ]
        );

        $this->add_control(
            'add_contacts',
            [
                'label'         => esc_html__('Show contact info', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'no',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'contact_phone_title',
            [
                'label'         => esc_html__('Phone title', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => '',
                'condition'     => [
                    'add_contacts'  => 'yes'
                ],
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'contact_phone_text',
            [
                'label'         => esc_html__('Phone text', 'industrium_plugin'),
                'type'          => Controls_Manager::WYSIWYG,
                'label_block'   => true,
                'placeholder'   => esc_html__('Enter text', 'industrium_plugin'),
                'default'       => '',
                'condition'     => [
                    'add_contacts'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'add_video',
            [
                'label'         => esc_html__('Show video preview', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'no',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'video_type',
            [
                'label'     => esc_html__( 'Source', 'industrium_plugin' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'youtube',
                'options'   => [
                    'youtube'       => esc_html__( 'YouTube', 'industrium_plugin' ),
                    'vimeo'         => esc_html__( 'Vimeo', 'industrium_plugin' ),
                    'dailymotion'   => esc_html__( 'Dailymotion', 'industrium_plugin' ),
                    'hosted'        => esc_html__( 'Self Hosted', 'industrium_plugin' )
                ],
                'frontend_available' => true,
                'condition' => [
                    'add_video'     => 'yes'
                ]
            ]
        );

        $this->add_control(
            'youtube_url',
            [
                'label'         => esc_html__( 'Link', 'industrium_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
                'placeholder'   => esc_html__( 'Enter your URL', 'industrium_plugin' ) . ' (YouTube)',
                'default'       => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                'label_block'   => true,
                'condition'     => [
                    'add_video'     => 'yes',
                    'video_type'    => 'youtube'
                ],
                'frontend_available' => true
            ]
        );

        $this->add_control(
            'vimeo_url',
            [
                'label'         => esc_html__( 'Link', 'industrium_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ],
                ],
                'placeholder'   => esc_html__( 'Enter your URL', 'industrium_plugin' ) . ' (Vimeo)',
                'default'       => 'https://vimeo.com/235215203',
                'label_block'   => true,
                'condition'     => [
                    'add_video'     => 'yes',
                    'video_type'    => 'vimeo'
                ]
            ]
        );

        $this->add_control(
            'dailymotion_url',
            [
                'label'         => esc_html__( 'Link', 'industrium_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ],
                ],
                'placeholder'   => esc_html__( 'Enter your URL', 'industrium_plugin' ) . ' (Dailymotion)',
                'default'       => 'https://www.dailymotion.com/video/x6tqhqb',
                'label_block'   => true,
                'condition'     => [
                    'add_video'     => 'yes',
                    'video_type'    => 'dailymotion'
                ]
            ]
        );

        $this->add_control(
            'insert_url',
            [
                'label'     => esc_html__( 'External URL', 'industrium_plugin' ),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'add_video'     => 'yes',
                    'video_type'    => 'hosted'
                ]
            ]
        );

        $this->add_control(
            'hosted_url',
            [
                'label'         => esc_html__( 'Choose File', 'industrium_plugin' ),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::MEDIA_CATEGORY
                    ],
                ],
                'media_type'    => 'video',
                'condition'     => [
                    'add_video'     => 'yes',
                    'video_type'    => 'hosted',
                    'insert_url'    => ''
                ]
            ]
        );

        $this->add_control(
            'external_url',
            [
                'label'         => esc_html__( 'URL', 'industrium_plugin' ),
                'type'          => Controls_Manager::URL,
                'autocomplete'  => false,
                'options'       => false,
                'label_block'   => true,
                'show_label'    => false,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
                'media_type'    => 'video',
                'placeholder'   => esc_html__( 'Enter your URL', 'industrium_plugin' ),
                'condition'     => [
                    'add_video'     => 'yes',
                    'video_type'    => 'hosted',
                    'insert_url'    => 'yes'
                ],
            ]
        );

        $this->add_control(
            'video_button_text',
            [
                'label' => esc_html__( 'Video Button Text', 'industrium_plugin' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Watch Video', 'industrium_plugin' ),
                'condition'     => [
                    'add_video'     => 'yes'
                ]
            ]
        );

        $this->add_control(
            'add_decoration',
            [
                'label'         => esc_html__('Show Decoration', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'no',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'decoration_position',
            [
                'label'     => esc_html__( 'Decoration position', 'industrium_plugin' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'pagination',
                'options'   => [
                    'pagination'      => esc_html__( 'Pagination/Video', 'industrium_plugin' ),
                    'contacts'     => esc_html__( 'Contacts', 'industrium_plugin' )
                ],
                'condition'    => [
                    'add_decoration' => 'yes'
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

        $repeater = new Repeater();

        $repeater->add_control(
            'slide_name',
            [
                'label'     => esc_html__('Slide Name', 'industrium_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => '',
                'separator' => 'after'
            ]
        );

        $repeater->add_control(
            'hide_slide',
            [
                'label'         => esc_html__('Hide This Slide', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'no',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'separator'     => 'before'
            ]
        );

        $repeater->add_responsive_control(
            'content_max_width',
            [
                'label'         => esc_html__('Text Column Width, %', 'industrium_plugin'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['%'],
                'range'         => [
                    '%'             => [
                        'min' => 1,
                        'max' => 100
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-content-column'    => 'width: {{SIZE}}%;'
                ]
            ]
        );

        $repeater->add_control(
            'content_position',
            [
                'label'         => esc_html__('Text Column Position', 'industrium_plugin'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'start'         => [
                        'title'         => esc_html__( 'Left', 'industrium_plugin' ),
                        'icon'          => 'eicon-h-align-left'
                    ],
                    'center'        => [
                        'title'         => esc_html__( 'Center', 'industrium_plugin' ),
                        'icon'          => 'eicon-h-align-center'
                    ],
                    'end'           => [
                        'title'         => esc_html__( 'Right', 'industrium_plugin' ),
                        'icon'          => 'eicon-h-align-right'
                    ]
                ]
            ]
        );

        $repeater->add_responsive_control(
            'content_vertical_position',
            [
                'label'         => esc_html__('Content Vertical Position', 'industrium_plugin'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'flex-start'         => [
                        'title'         => esc_html__( 'Top', 'industrium_plugin' ),
                        'icon'          => 'eicon-v-align-top'
                    ],
                    'center'        => [
                        'title'         => esc_html__( 'Center', 'industrium_plugin' ),
                        'icon'          => 'eicon-v-align-middle'
                    ],
                    'flex-end'           => [
                        'title'         => esc_html__( 'Bottom', 'industrium_plugin' ),
                        'icon'          => 'eicon-v-align-bottom'
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .elementor-container > .elementor-row' => 'align-items: {{VALUE}}'
                ]
            ]
        );

        $repeater->add_responsive_control(
            'content_text_align',
            [
                'label'     => esc_html__('Text Alignment', 'industrium_plugin'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'center',
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
                'selectors_dictionary' => [
                    'left' => is_rtl() ? 'text-align:left; justify-content: flex-end;' : 'text-align:left; justify-content: flex-start;',
                    'center' => 'text-align:center; justify-content: center;',
                    'right' => is_rtl() ? 'text-align:right; justify-content: flex-start;' : 'text-align:right; justify-content: flex-end;',
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-content-column' => '{{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .content-slider-item-buttons' => '{{VALUE}}',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'industrium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['%', 'px', 'em', 'vw'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .elementor-container > .elementor-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $repeater->add_control(
            'divider_1',
            [
                'type' => Controls_Manager::DIVIDER
            ]
        );

        $repeater->start_controls_tabs('button_settings_tabs');

        // -------------------- //
        // ------ BG Tab ------ //
        // -------------------- //
        $repeater->start_controls_tab(
            'tab_bg',
            [
                'label' => esc_html__('BG', 'industrium_plugin')
            ]
        );

            $repeater->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'      => 'background',
                    'label'     => esc_html__( 'Background', 'industrium_plugin' ),
                    'types'     => [ 'classic', 'gradient', 'video' ],
                    'fields_options' => [
                        'video_fallback' => [
                            'active' => false
                        ],
                    ],
                    'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}}'
                ]
            );

            $repeater->add_control(
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
                        '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-blend-mode: {{VALUE}};',
                    ]
                ]
            );

            $repeater->add_control(
                'add_bg_overlay',
                [
                    'label'         => esc_html__('Add Overlay', 'industrium_plugin'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                    'label_off'     => esc_html__('No', 'industrium_plugin'),
                    'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                    'separator'     => 'before'
                ]
            );

            $repeater->add_control(
                'bg_overlay_color',
                [
                    'label'     => esc_html__('Overlay Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};'
                    ],
                    'condition' => [
                        'add_bg_overlay'    => 'yes'
                    ]
                ]
            );

        $repeater->end_controls_tab();

        // ----------------------- //
        // ------ Image Tab ------ //
        // ----------------------- //
        $repeater->start_controls_tab(
            'tab_image',
            [
                'label' => esc_html__('Image', 'industrium_plugin')
            ]
        );

            $repeater->add_control(
                'additional_image',
                [
                    'label' => esc_html__('Additional Image', 'industrium_plugin'),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ]
                ]
            );

            $repeater->add_responsive_control(
                'image_max_width',
                [
                    'label'         => esc_html__('Image Column Width, %', 'industrium_plugin'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['%'],
                    'range'         => [
                        '%'             => [
                            'min' => 1,
                            'max' => 100
                        ]
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .slide-image-column'    => 'width: {{SIZE}}%;'
                    ]
                ]
            );

            $repeater->add_responsive_control(
                'additional_image_align',
                [
                    'label'     => esc_html__('Image Alignment', 'industrium_plugin'),
                    'type'      => Controls_Manager::CHOOSE,
                    'default'   => 'right',
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
                        '{{WRAPPER}} {{CURRENT_ITEM}} .additional-image' => 'text-align: {{VALUE}};'
                    ]
                ]
            );

            $repeater->add_control(
                'additional_image_vertical_position',
                [
                    'label'     => esc_html__('Vertical Position', 'industrium_plugin'),
                    'type'      => Controls_Manager::CHOOSE,
                    'default'   => 'middle',
                    'options'   => [
                        'top'       => [
                            'title'     => esc_html__( 'Top', 'industrium_plugin' ),
                            'icon'      => 'eicon-v-align-top'
                        ],
                        'middle'    => [
                            'title'     => esc_html__( 'Middle', 'industrium_plugin' ),
                            'icon'      => 'eicon-v-align-middle'
                        ],
                        'bottom'    => [
                            'title'     => esc_html__( 'Bottom', 'industrium_plugin' ),
                            'icon'      => 'eicon-v-align-bottom'
                        ]
                    ]
                ]
            );

            $repeater->add_responsive_control(
                'image_margin',
                [
                    'label' => esc_html__('Position', 'industrium_plugin'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['%', 'px'],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .additional-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );

            $repeater->add_control(
                'image_behind_text',
                [
                    'label'         => esc_html__('Move Image Behind Text', 'industrium_plugin'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                    'label_off'     => esc_html__('No', 'industrium_plugin'),
                    'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                    'separator'     => 'before'
                ]
            );

        $repeater->end_controls_tab();

        // ----------------------- //
        // ------ Title Tab ------ //
        // ----------------------- //
        $repeater->start_controls_tab(
            'tab_title',
            [
                'label' => esc_html__('Title', 'industrium_plugin')
            ]
        );

            $repeater->add_control(
                'heading',
                [
                    'label'         => esc_html__('Title', 'industrium_plugin'),
                    'type'          => Controls_Manager::WYSIWYG,
                    'label_block'   => true,
                    'placeholder'   => esc_html__('Enter Title', 'industrium_plugin'),
                    'default'       => esc_html__('Title', 'industrium_plugin')
                ]
            );

            $repeater->add_control(
                'subheading_status',
                [
                    'label' => esc_html__('Show Subheading', 'industrium_plugin'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Show', 'industrium_plugin' ),
                    'label_off' => esc_html__( 'Hide', 'industrium_plugin' ),
                    'return_value' => 'yes',
                    'default' => 'no'
                ]
            );
            $repeater->add_control(
                'subheading',
                [
                    'label' => esc_html__('Subheading', 'industrium_plugin'),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => esc_html__('Enter Subheading', 'industrium_plugin'),
                    'default' => esc_html__('Subheading', 'industrium_plugin'),
                    'condition' => [
                        'subheading_status' => 'yes'
                    ]
                ]
            );

            $repeater->add_control(
                'remove_subheading_dot',
                [
                    'label'         => esc_html__('Remove Subheading Dot', 'industrium_plugin'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => '',
                    'return_value'  => 'yes',
                    'label_off'     => esc_html__('No', 'industrium_plugin'),
                    'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                    'condition'     => [
                        'subheading_status'  => 'yes'
                    ]
                ]
            );

            $repeater->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'      => 'heading_typography',
                    'label'     => esc_html__('Heading Typography', 'industrium_plugin'),
                    'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-heading .industrium-heading-content'
                ]
            );

            $repeater->add_control(
                'heading_color',
                [
                    'label'     => esc_html__('Heading Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-heading .industrium-heading-content' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $repeater->add_control(
                'accent_text_color',
                [
                    'label'     => esc_html__('Text Underline Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-heading .industrium-heading-content span[style *= "text-decoration: underline"]:before' => 'background-color: {{VALUE}} !important;',
                        '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-heading .industrium-heading-content u:before' => 'background-color: {{VALUE}} !important;'
                    ]
                ]
            );

            $repeater->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'subheading_typography',
                    'label' => esc_html__('Subheading Typography', 'industrium_plugin'),
                    'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-subheading',
                    'condition' => [
                        'subheading_status' => 'yes'
                    ]
                ]
            );

            $repeater->add_control(
                'subheading_color',
                [
                    'label' => esc_html__('Subheading Color', 'industrium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-subheading' => 'color: {{VALUE}};'
                    ],
                    'condition' => [
                        'subheading_status' => 'yes'
                    ]                        
                ]
            );

            $repeater->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name'      => 'title_shadow',
                    'label'     => esc_html__('Heading Text Shadow', 'industrium_plugin'),
                    'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-heading .industrium-heading-content'
                ]
            );

            $repeater->add_responsive_control(
                'title_margin',
                [
                    'label' => esc_html__( 'Title Margin', 'industrium_plugin' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $repeater->end_controls_tab();

        // ---------------------- //
        // ------ Text Tab ------ //
        // ---------------------- //
        $repeater->start_controls_tab(
            'tab_text',
            [
                'label' => esc_html__('Text', 'industrium_plugin')
            ]
        );

            $repeater->add_control(
                'text',
                [
                    'label'         => esc_html__('Promo Text', 'industrium_plugin'),
                    'type'          => Controls_Manager::WYSIWYG,
                    'default'       => '',
                    'placeholder'   => esc_html__('Enter Promo Text', 'industrium_plugin'),
                    'separator'     => 'before'
                ]
            );

            $repeater->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'      => 'text_typography',
                    'label'     => esc_html__('Text Typography', 'industrium_plugin'),
                    'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .content-slider-item-text, {{WRAPPER}} {{CURRENT_ITEM}} .content-slider-item-text p'
                ]
            );

            $repeater->add_control(
                'text_color',
                [
                    'label'     => esc_html__('Text Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .content-slider-item-text' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $repeater->add_responsive_control(
                'text_padding',
                [
                    'label' => esc_html__( 'Text Padding', 'industrium_plugin' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .content-slider-item-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $repeater->end_controls_tab();

            // ------------------------- //
            // ------ Buttons Tab ------ //
            // ------------------------- //
            $repeater->start_controls_tab(
                'tab_button',
                [
                    'label' => esc_html__('Buttons', 'industrium_plugin')
                ]
            );

                $repeater->add_control(
                    'button_text',
                    [
                        'label'     => esc_html__('Button Text', 'industrium_plugin'),
                        'type'      => Controls_Manager::TEXT,
                        'default'   => esc_html__('Button', 'industrium_plugin'),
                        'separator' => 'before'
                    ]
                );

                $repeater->add_control(
                    'button_link',
                    [
                        'label'         => esc_html__('Button Link', 'industrium_plugin'),
                        'type'          => Controls_Manager::URL,
                        'label_block'   => true,
                        'default'       => [
                            'url'           => '',
                            'is_external'   => 'true',
                        ],
                        'placeholder'   => esc_html__( 'http://your-link.com', 'industrium_plugin' )
                    ]
                );

                $repeater->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                        'name'      => 'button_typography',
                        'label'     => esc_html__('Button Typography', 'industrium_plugin'),
                        'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-button'
                    ]
                );

                $repeater->add_control(
                    'button_color',
                    [
                        'label'     => esc_html__('Button Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-button' => 'color: {{VALUE}};',
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-button:after' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before'
                    ]
                );

                $repeater->add_control(
                    'button_bg_color',
                    [
                        'label'     => esc_html__('Button Background', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-button .industrium-button-text' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $repeater->add_control(
                    'button_arrow_color',
                    [
                        'label'     => esc_html__('Button Arrow Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-button:after' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before'
                    ]
                );

                $repeater->add_control(
                    'button_color_hover',
                    [
                        'label'     => esc_html__('Button Hover Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-button:hover' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before'
                    ]
                );

                $repeater->add_control(
                    'button_bg_hover',
                    [
                        'label'     => esc_html__('Button Background Hover', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-button .industrium-button-text:before' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $repeater->add_control(
                    'button_border_color',
                    [
                        'label'     => esc_html__('Button Border Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-button' => 'border-color: {{VALUE}};',
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-button:before' => 'background-color: {{VALUE}};'
                        ],
                        'separator' => 'before'
                    ]
                );

                $repeater->add_control(
                    'button_radius',
                    [
                        'label'         => esc_html__('Border Radius', 'industrium_plugin'),
                        'type'          => Controls_Manager::DIMENSIONS,
                        'size_units'    => ['px', '%'],
                        'selectors'     => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ],
                        'separator'     => 'before'
                    ]
                );

                $repeater->add_control(
                    'button_padding',
                    [
                        'label'         => esc_html__('Button Padding', 'industrium_plugin'),
                        'type'          => Controls_Manager::DIMENSIONS,
                        'size_units'    => ['px', '%'],
                        'selectors'     => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-button .industrium-button-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ]
                    ]
                );

                $repeater->add_control(
                    'add_video_button',
                    [
                        'label'         => esc_html__('Add Video Button', 'industrium_plugin'),
                        'type'          => Controls_Manager::SWITCHER,
                        'default'       => 'no',
                        'return_value'  => 'yes',
                        'label_off'     => esc_html__('No', 'industrium_plugin'),
                        'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                        'separator'     => 'before'
                    ]
                );

                $repeater->add_responsive_control(
                    'slide_video_button_position',
                    [
                        'label'     => esc_html__( 'Button position', 'industrium_plugin' ),
                        'type'      => Controls_Manager::SELECT,
                        'default'   => 'text',
                        'options'   => [
                            'text'    => esc_html__( 'Text Column', 'industrium_plugin' ),
                            'column'    => esc_html__( 'Video Column', 'industrium_plugin' )
                        ],
                        'prefix_class' => 'slide_video_button_position-%s',
                        'condition' => [
                            'add_video_button'  => 'yes'
                        ]
                    ]
                );

                $repeater->add_control(
                    'slide_video_type',
                    [
                        'label'     => esc_html__( 'Source', 'industrium_plugin' ),
                        'type'      => Controls_Manager::SELECT,
                        'default'   => 'youtube',
                        'options'   => [
                            'youtube'       => esc_html__( 'YouTube', 'industrium_plugin' ),
                            'vimeo'         => esc_html__( 'Vimeo', 'industrium_plugin' ),
                            'dailymotion'   => esc_html__( 'Dailymotion', 'industrium_plugin' ),
                            'hosted'        => esc_html__( 'Self Hosted', 'industrium_plugin' )
                        ],
                        'frontend_available' => true,
                        'condition' => [
                            'add_video_button'  => 'yes'
                        ]
                    ]
                );

                $repeater->add_control(
                    'slide_youtube_url',
                    [
                        'label'         => esc_html__( 'Link', 'industrium_plugin' ),
                        'type'          => Controls_Manager::TEXT,
                        'dynamic'       => [
                            'active'        => true,
                            'categories'    => [
                                TagsModule::POST_META_CATEGORY,
                                TagsModule::URL_CATEGORY
                            ]
                        ],
                        'placeholder'   => esc_html__( 'Enter your URL', 'industrium_plugin' ) . ' (YouTube)',
                        'default'       => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                        'label_block'   => true,
                        'condition'     => [
                            'add_video_button'  => 'yes',
                            'slide_video_type'  => 'youtube'
                        ],
                        'frontend_available' => true
                    ]
                );

                $repeater->add_control(
                    'slide_vimeo_url',
                    [
                        'label'         => esc_html__( 'Link', 'industrium_plugin' ),
                        'type'          => Controls_Manager::TEXT,
                        'dynamic'       => [
                            'active'        => true,
                            'categories'    => [
                                TagsModule::POST_META_CATEGORY,
                                TagsModule::URL_CATEGORY
                            ],
                        ],
                        'placeholder'   => esc_html__( 'Enter your URL', 'industrium_plugin' ) . ' (Vimeo)',
                        'default'       => 'https://vimeo.com/235215203',
                        'label_block'   => true,
                        'condition'     => [
                            'add_video_button'  => 'yes',
                            'slide_video_type'  => 'vimeo'
                        ]
                    ]
                );

                $repeater->add_control(
                    'slide_dailymotion_url',
                    [
                        'label'         => esc_html__( 'Link', 'industrium_plugin' ),
                        'type'          => Controls_Manager::TEXT,
                        'dynamic'       => [
                            'active'        => true,
                            'categories'    => [
                                TagsModule::POST_META_CATEGORY,
                                TagsModule::URL_CATEGORY
                            ],
                        ],
                        'placeholder'   => esc_html__( 'Enter your URL', 'industrium_plugin' ) . ' (Dailymotion)',
                        'default'       => 'https://www.dailymotion.com/video/x6tqhqb',
                        'label_block'   => true,
                        'condition'     => [
                            'add_video_button'  => 'yes',
                            'slide_video_type'  => 'dailymotion'
                        ]
                    ]
                );

                $repeater->add_control(
                    'slide_insert_url',
                    [
                        'label'     => esc_html__( 'External URL', 'industrium_plugin' ),
                        'type'      => Controls_Manager::SWITCHER,
                        'condition' => [
                            'add_video_button'  => 'yes',
                            'slide_video_type'  => 'hosted'
                        ]
                    ]
                );

                $repeater->add_control(
                    'slide_hosted_url',
                    [
                        'label'         => esc_html__( 'Choose File', 'industrium_plugin' ),
                        'type'          => Controls_Manager::MEDIA,
                        'dynamic'       => [
                            'active'        => true,
                            'categories'    => [
                                TagsModule::MEDIA_CATEGORY
                            ],
                        ],
                        'media_type'    => 'video',
                        'condition'     => [
                            'add_video_button'  => 'yes',
                            'slide_video_type'  => 'hosted',
                            'slide_insert_url'  => ''
                        ]
                    ]
                );

                $repeater->add_control(
                    'slide_external_url',
                    [
                        'label'         => esc_html__( 'URL', 'industrium_plugin' ),
                        'type'          => Controls_Manager::URL,
                        'autocomplete'  => false,
                        'options'       => false,
                        'label_block'   => true,
                        'show_label'    => false,
                        'dynamic'       => [
                            'active'        => true,
                            'categories'    => [
                                TagsModule::POST_META_CATEGORY,
                                TagsModule::URL_CATEGORY
                            ]
                        ],
                        'media_type'    => 'video',
                        'placeholder'   => esc_html__( 'Enter your URL', 'industrium_plugin' ),
                        'condition'     => [
                            'add_video_button'  => 'yes',
                            'slide_video_type'  => 'hosted',
                            'slide_insert_url'  => 'yes'
                        ]
                    ]
                );

                $repeater->add_control(
                    'slide_lightbox',
                    [
                        'type'                  => Controls_Manager::HIDDEN,
                        'default'               => 'yes',
                        'frontend_available'    => true
                    ]
                );

                $repeater->add_control(
                    'slide_controls',
                    [
                        'type'                  => Controls_Manager::HIDDEN,
                        'default'               => 'yes',
                        'frontend_available'    => true
                    ]
                );

                $repeater->add_control(
                    'slide_aspect_ratio',
                    [
                        'type'                  => Controls_Manager::HIDDEN,
                        'default'               => '169',
                        'frontend_available'    => true
                    ]
                );

                $repeater->add_responsive_control(
                    'slide_video_button_align',
                    [
                        'label'     => esc_html__('Video Column Alignment', 'industrium_plugin'),
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
                        'default'   => 'right',
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .slide-video-column' => 'text-align: {{VALUE}}'
                        ],
                        'condition' => [
                            'add_video_button' => 'yes',
                            'slide_video_button_position' => 'column'
                        ]
                    ]
                );

                $repeater->add_responsive_control(
                    'video_button_size',
                    [
                        'label' => esc_html__( 'Video Button Size', 'industrium_plugin' ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'px', 'em' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 200,
                                'step' => 1,
                            ],
                            'em' => [
                                'min' => 0.1,
                                'max' => 10,
                                'step' => 0.1,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-video-button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-video-button .elementor-custom-embed-play .eicon-play' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};'
                        ],
                        'condition' => [
                            'add_video_button'  => 'yes'
                        ]
                    ]
                );

                $repeater->add_responsive_control(
                    'slide_video_button_margin',
                    [
                        'label' => esc_html__( 'Video Button Margin', 'industrium_plugin' ),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => [ 'px', '%', 'em' ],
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-video-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                        'condition' => [
                            'add_video_button'  => 'yes'
                        ]
                    ]
                );

                $repeater->add_control(
                    'video_button_color',
                    [
                        'label'     => esc_html__('Video Button Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-video-button .elementor-custom-embed-play .eicon-play svg' => 'stroke: {{VALUE}};',
                            '{{WRAPPER}} {{CURRENT_ITEM}} .industrium-video-button .elementor-custom-embed-play .eicon-play:before' => 'background-color: {{VALUE}};'
                        ],
                        'separator' => 'before',
                        'condition' => [
                            'add_video_button'  => 'yes'
                        ]
                    ]
                );

            $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'content_items',
            [
                'label'         => esc_html__('Slides', 'industrium_plugin'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'title_field'   => '{{{slide_name}}}',
                'prevent_empty' => true,
                'separator'     => 'before'
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
                'separator'     => 'before'
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
                'separator'     => 'before'
            ]
        );

        $this->add_responsive_control(
            'dots_align',
            [
                'label'     => esc_html__('Pagination Alignment', 'industrium_plugin'),
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
                'condition' => [
                    'dots' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'progress',
            [
                'label'         => esc_html__('Show progress', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'progress_position',
            [
                'label'     => esc_html__( 'Progress position', 'industrium_plugin' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'pagination',
                'options'   => [
                    'pagination'    => esc_html__( 'Pagination', 'industrium_plugin' ),
                    'left'      => esc_html__( 'Left', 'industrium_plugin' ),
                    'right'     => esc_html__( 'Right', 'industrium_plugin' )
                ],
                'condition' => [
                    'progress'      => 'yes'
                ]
            ]
        );

        $this->add_control(
            'speed',
            [
                'label'     => esc_html__('Animation Speed', 'industrium_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 1200,
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
                'default'   => 5000,
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
                'label' => esc_html__('Pause on Hover', 'industrium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'industrium_plugin'),
                    'no' => esc_html__('No', 'industrium_plugin'),
                ],
                'condition' => [
                    'autoplay' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();


        // --------------------------------------- //
        // ---------- Contacts Settings ---------- //
        // --------------------------------------- //
        $this->start_controls_section(
            'section_contacts_settings',
            [
                'label'         => esc_html__('Contacts Settings', 'industrium_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'add_contacts'  => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'contacts_title_typography',
                'label'     => esc_html__('Title Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .bottom-area .contacts .contact-item-title'
            ]
        );

        $this->add_control(
            'contacts_title_color',
            [
                'label'     => esc_html__('Title Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .bottom-area .contacts .contact-item-title' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'contacts_text_typography',
                'label'     => esc_html__('Text Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .bottom-area .contacts .contact-item-text'
            ]
        );

        $this->add_control(
            'contacts_text_color',
            [
                'label'     => esc_html__('Text Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .bottom-area .contacts .contact-item-text, {{WRAPPER}} .bottom-area .contacts .contact-item-text a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'contacts_text_accent',
            [
                'label'     => esc_html__('Accent Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .bottom-area .contacts .contact-item-text a:hover, {{WRAPPER}} .bottom-area .contacts .contact-item:before' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'contacts_bg_color',
            [
                'label'     => esc_html__('Contacts Background', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .bottom-area .contacts' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();


        // -------------------------------------------- //
        // ---------- Video Preview Settings ---------- //
        // -------------------------------------------- //
        $this->start_controls_section(
            'section_video_settings',
            [
                'label'         => esc_html__('Video Preview Settings', 'industrium_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'add_video'     => 'yes'
                ]
            ]
        );

        $this->add_control(
            'video_play_bg',
            [
                'label'     => esc_html__('Play Button Background', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .bottom-area .content-slider-video .elementor-custom-embed-play .eicon-play' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'video_play_icon',
            [
                'label'     => esc_html__('Play Icon Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .bottom-area .content-slider-video .elementor-custom-embed-play .eicon-play svg' => 'stroke: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'video_play_color',
            [
                'label'     => esc_html__('Play Button Text Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .bottom-area .content-slider-video .elementor-custom-embed-play .video-button-text' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'video_play_bg_color',
            [
                'label'     => esc_html__('Play Button Text Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .bottom-area .content-slider-video .elementor-custom-embed-play .video-button-text' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'video_button_typography',
                'selector' => '{{WRAPPER}} .bottom-area .content-slider-video .elementor-custom-embed-play .video-button-text',
            ]
        );

        $this->end_controls_section();


        // ----------------------------------------- //
        // ---------- Slider Nav Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'section_slider_settings',
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
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'pagination_title',
            [
                'label' => esc_html__( 'Slider Pagination', 'industrium_plugin' ),
                'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'dot_bg_color',
            [
                'label'     => esc_html__('Pagination Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .bottom-area .owl-dots-wrapper' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'dots'      => 'yes'
                ]
            ]
        );

        $this->add_control(
            'progress_bg_color',
            [
                'label'     => esc_html__('Progress Track Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .slider-progress-wrapper .slider-progress-track' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'dots'      => 'yes',
                    'progress' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'progress_track_bg_color',
            [
                'label'     => esc_html__('Progress Track Indicator Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .slider-progress-wrapper .slider-progress-track .progress' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'dots'      => 'yes',
                    'progress' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'progress_color',
            [
                'label'     => esc_html__('Progress Counters Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .slider-progress-wrapper .slider-progress-current' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .slider-progress-wrapper .slider-progress-all' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'dots'      => 'yes',
                    'progress' => 'yes'
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
                        'default'   => '',
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
                        'default'   => '',
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
                        'default'   => '',
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
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .owl-dots .owl-dot.active span:before' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'separator_arrows',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'arrows_title',
            [
                'label' => esc_html__( 'Slider Navigation', 'industrium_plugin' ),
                'type'  => Controls_Manager::HEADING,
                'condition' => [
                    'nav'       => 'yes'
                ]
            ]
        );

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
                        'default'   => '',
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
                        'default'   => '',
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
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'nav_box_shadow',
                        'label'     => esc_html__( 'Box Shadow', 'industrium_plugin' ),
                        'selector'  => '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]',
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
                        'default'   => '',
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
                        'default'   => '',
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
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]:not(.disabled):hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'nav_box_shadow_hover',
                        'label'     => esc_html__( 'Box Shadow', 'industrium_plugin' ),
                        'selector'  => '{{WRAPPER}} .owl-theme .owl-nav [class*="owl-"]:not(.disabled):hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // ------------------------------------------------- //
        // ---------- Slider Decoration Settings ---------- //
        // ------------------------------------------------- //
        $this->start_controls_section(
            'slider_decoration_settings',
            [
                'label'     => esc_html__('Slider Decoration Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'add_decoration'   => 'yes'
                ]
            ]
        );

        $this->add_control(
            'main_decoration_color',
            [
                'label'     => esc_html__('Decoration Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .slider-decoration:before' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'add_decoration'    => 'yes'
                ]
            ]
        );

        $this->add_control(
            'sec_decoration_color',
            [
                'label'     => esc_html__('Secondary Decoration Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .slider-decoration:after' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'add_decoration'    => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------------------- //
        // ---------- Scroll Down Button Settings ---------- //
        // ------------------------------------------------- //
        $this->start_controls_section(
            'section_scroll_down_settings',
            [
                'label'     => esc_html__('"Scroll Down" Button Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'add_scroll_down'   => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs( 'scroll_down_settings_tabs' );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'scroll_down_normal_tab',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'scroll_down_color',
                    [
                        'label'     => esc_html__('Icon Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .content-slider-scroll-down' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'scroll_down_bg',
                    [
                        'label'     => esc_html__('Button Background', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .content-slider-scroll-down' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'scroll_down_hover_tab',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'scroll_down_hover',
                    [
                        'label'     => esc_html__('Icon Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .content-slider-scroll-down:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'scroll_down_bg_hover',
                    [
                        'label'     => esc_html__('Button Background', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .content-slider-scroll-down:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings               = $this->get_settings();

        $add_contacts           = $settings['add_contacts'];
        $contact_phone_title    = $settings['contact_phone_title'];
        $contact_phone_text     = $settings['contact_phone_text'];

        $add_video              = $settings['add_video'];
        $video_type             = $settings['video_type'];
        $youtube_url            = $settings['youtube_url'];
        $vimeo_url              = $settings['vimeo_url'];
        $dailymotion_url        = $settings['dailymotion_url'];
        $insert_url             = $settings['insert_url'];
        $hosted_url             = $settings['hosted_url'];
        $external_url           = $settings['external_url'];

        $add_scroll_down        = $settings['add_scroll_down'];
        $scroll_down_position   = $settings['scroll_down_position'];

        $add_decoration         = $settings['add_decoration'];
        $decoration_position    = $settings['decoration_position'];

        $progress               = ('yes' === $settings['progress']);

        $content_items          = $settings['content_items'];
        $widget_id              = $this->get_id();

        $slider_options         = [
            'items'                 => 1,
            'nav'                   => ('yes' === $settings['nav']),
            'dots'                  => ('yes' === $settings['dots']),
            'autoplayHoverPause'    => ('yes' === $settings['pause_on_hover']),
            'autoplay'              => ('yes' === $settings['autoplay']),
            'autoplaySpeed'         => absint($settings['autoplay_speed']),
            'autoplayTimeout'       => absint($settings['autoplay_timeout']),
            'loop'                  => ('yes' === $settings['infinite']),
            'speed'                 => absint($settings['speed']),
            'dotsContainer'         => !empty($widget_id) ? '.owl-dots-' . esc_attr($widget_id) : false,
            'animateOut'            => 'fadeOut',
            'progress'              => $progress,
            'progress_position'     => $settings['progress_position']
        ];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="industrium-content-slider-widget">
            <div class="content-slider-wrapper">

                <div class="content-slider-container">
                    <div class="content-slider owl-carousel owl-theme" data-slider-options="<?php echo esc_attr(wp_json_encode($slider_options)); ?>">
                        <?php

                        foreach ($content_items as $slide) {
                            if($slide['hide_slide'] === 'yes') {
                                continue;
                            }
                            $item_classes = 'content-item slider-item';
                            $item_classes .= ' elementor-repeater-item-' . esc_attr($slide['_id']);
                            $item_classes .= ' content-position-' . esc_attr($slide['content_position']);
                            $item_classes .= ' image-vertical-position-' . esc_attr($slide['additional_image_vertical_position']);
                            $item_classes .= ' aside-area-position-' . ( !empty($settings['progress_position']) ? esc_attr($settings['progress_position']) : 'left' );
                            $item_classes .= ($slide['image_behind_text'] == 'yes' ? ' image_behind_text' : ''); 

                            $add_video_button           = $slide['add_video_button'];
                            $slide_video_button_position    = $slide['slide_video_button_position'];
                            $slide_video_type           = $slide['slide_video_type'];
                            $slide_youtube_url          = $slide['slide_youtube_url'];
                            $slide_vimeo_url            = $slide['slide_vimeo_url'];
                            $slide_dailymotion_url      = $slide['slide_dailymotion_url'];
                            $slide_insert_url           = $slide['slide_insert_url'];
                            $slide_hosted_url           = $slide['slide_hosted_url'];
                            $slide_external_url         = $slide['slide_external_url'];

                            $slide_settings = [
                                'video_type' => $slide_video_type,
                                'youtube_url' => $slide_youtube_url,
                                'vimeo_url' => $slide_vimeo_url,
                                'dailymotion_url' => $slide_dailymotion_url,
                                'insert_url' => $slide_insert_url,
                                'hosted_url' => $slide_hosted_url,
                                'external_url' => $slide_external_url
                            ];
                            echo '<div class="' . esc_attr($item_classes) . '"' . $this->print_render_attribute_string( '_wrapper' ) . '>';

                                    if ( 'video' === $slide['background_background'] ) :
                                        if ( $slide['background_video_link'] ) :
                                            $video_properties = Embed::get_video_properties( $slide['background_video_link'] );

                                            $this->add_render_attribute( 'background-video-container', 'class', 'elementor-background-video-container' );

                                            if ( ! $slide['background_play_on_mobile'] ) {
                                                $this->add_render_attribute( 'background-video-container', 'class', 'elementor-hidden-phone' );
                                            }
                                            ?>
                                            <div <?php $this->print_render_attribute_string( 'background-video-container' ); ?>>
                                                <?php if ( $video_properties ) : ?>
                                                        <?php
                                                            $slide_video_settings = [
                                                                'autoplay' => true,
                                                                'play_on_mobile' => $slide['background_play_on_mobile'],
                                                                'play_once' => 'yes' === $slide['background_play_once'],
                                                                'video_url' => $slide['background_video_link'],
                                                                'start' => $slide['background_video_start'],
                                                                'end' => $slide['background_video_end']
                                                            ];
                                                            $embed_params = $this->get_bg_video_embed_params($slide_video_settings);
                                                            $embed_options = $this->get_bg_video_embed_options([
                                                                'yt_privacy' => $slide['background_privacy_mode']
                                                            ]);
                                                            $video_html = Embed::get_embed_html( $slide['background_video_link'], $embed_params, $embed_options);
                                                            Utils::print_unescaped_internal_string( $video_html );
                                                        ?>
                                                    <?php

                                                else :
                                                    $video_tag_attributes = 'autoplay muted playsinline src="' . $slide['background_video_link'] . '"';
                                                    if ( 'yes' !== $slide['background_play_once'] ) :
                                                        $video_tag_attributes .= ' loop';
                                                    endif;
                                                    ?>
                                                    <video class="elementor-background-video-hosted elementor-html5-video" <?php
                                                        echo $video_tag_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                    ?>></video>
                                                <?php endif; ?>
                                            </div>
                                            <?php
                                        endif;
                                    endif;



                                echo '<div class="elementor-section elementor-section-boxed">';
                                    echo '<div class="elementor-container elementor-column-gap-extended">';
                                        $row_class = (($add_video_button == 'yes' && 
                                                        $slide_video_button_position == 'column') && (
                                                            ( $slide_video_type == 'youtube' && !empty($slide_youtube_url) ) ||
                                                            ( $slide_video_type == 'vimeo' && !empty($slide_vimeo_url) ) ||
                                                            ( $slide_video_type == 'dailymotion' && !empty($slide_dailymotion_url) ) ||
                                                            ( $slide_video_type == 'hosted' && (
                                                                !empty($slide_insert_url) ||
                                                                !empty($slide_hosted_url) ||
                                                                !empty($slide_external_url)
                                                            ) )
                                                        )) ? 'row-text-video' : '';
                                        echo '<div class="elementor-row ' . esc_attr($row_class) . '">';

                                            echo '<div class="slide-content-column">';

                                                if ( !empty($slide['heading']) ) {
                                                    echo '<div class="industrium-content-wrapper-1">';
                                                        echo '<div class="industrium-heading content-slider-item-heading">';
                                                            if ( $slide['subheading_status'] == 'yes' && !empty($slide['subheading']) ) {
                                                                echo '<span class="industrium-subheading' . ($slide['remove_subheading_dot'] == 'yes' ? ' no-dot' : '') . '">' . esc_html($slide['subheading']) . '</span>';
                                                            }
                                                            echo '<span class="industrium-heading-content">';
                                                                echo wp_kses($slide['heading'], array(
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
                                                        echo '</div>';
                                                    echo '</div>';
                                                }

                                                if ( !empty($slide['text']) ) {
                                                    echo '<div class="industrium-content-wrapper-2">';
                                                        echo '<div class="content-slider-item-text">' . wp_kses_post($slide['text']) . '</div>';
                                                    echo '</div>';
                                                }

                                                if (
                                                    !empty($slide['button_text']) ||
                                                    (
                                                        $add_video_button == 'yes' && (
                                                            ( $slide_video_type == 'youtube' && !empty($slide_youtube_url) ) ||
                                                            ( $slide_video_type == 'vimeo' && !empty($slide_vimeo_url) ) ||
                                                            ( $slide_video_type == 'dailymotion' && !empty($slide_dailymotion_url) ) ||
                                                            ( $slide_video_type == 'hosted' && (
                                                                !empty($slide_insert_url) ||
                                                                !empty($slide_hosted_url) ||
                                                                !empty($slide_external_url)
                                                            ) )
                                                        )
                                                    )
                                                ) {
                                                    echo '<div class="industrium-content-wrapper-3">';
                                                        echo '<div class="content-slider-item-buttons">';

                                                            if ( !empty($slide['button_text']) ) {
                                                                if ( !empty($slide['button_link']['url']) ) {
                                                                    $button_url = $slide['button_link']['url'];
                                                                } else {
                                                                    $button_url = '#';
                                                                }
                                                                echo '<a class="industrium-button" href="' . esc_url($button_url) . '"' . (($slide['button_link']['is_external'] == true) ? ' target="_blank"' : '') . (($slide['button_link']['nofollow'] == 'on') ? ' rel="nofollow"' : '') . '>';
                                                                    echo '<span class="industrium-button-text">';
                                                                        echo esc_html($slide['button_text']);
                                                                    echo '</span>';
                                                                echo '</a>';
                                                            }

                                                            if (
                                                                $add_video_button == 'yes' && (
                                                                    ( $slide_video_type == 'youtube' && !empty($slide_youtube_url) ) ||
                                                                    ( $slide_video_type == 'vimeo' && !empty($slide_vimeo_url) ) ||
                                                                    ( $slide_video_type == 'dailymotion' && !empty($slide_dailymotion_url) ) ||
                                                                    ( $slide_video_type == 'hosted' && (
                                                                            !empty($slide_insert_url) ||
                                                                            !empty($slide_hosted_url) ||
                                                                            !empty($slide_external_url)
                                                                        ) )
                                                                )
                                                            ) {
                                                                    $slide_video_url = $slide[ 'slide_' . $slide_video_type . '_url' ];

                                                                    if ( 'hosted' === $slide_video_type ) {
                                                                        $slide_video_url = $this->get_hosted_video_url($slide_settings);
                                                                    } else {
                                                                        $slide_embed_params = $this->get_embed_params($slide_settings);
                                                                        $slide_embed_options = $this->get_embed_options($slide_settings);
                                                                    }

                                                                    if ( 'youtube' === $slide_video_type ) {
                                                                        $slide_video_html = '<div class="elementor-video"></div>';
                                                                    }

                                                                    if ( 'hosted' === $slide_video_type ) {
                                                                        $this->add_render_attribute( 'video-wrapper', 'class', 'e-hosted-video' );

                                                                        ob_start();

                                                                        $this->render_hosted_video($slide_settings);

                                                                        $slide_video_html = ob_get_clean();
                                                                    } else {
                                                                        $slide_is_static_render_mode = \Elementor\Plugin::$instance->frontend->is_static_render_mode();
                                                                        $slide_post_id = get_queried_object_id();

                                                                        if ( $slide_is_static_render_mode ) {
                                                                            $slide_video_html = \Elementor\Embed::get_embed_thumbnail_html( $slide_video_url, $slide_post_id );
                                                                        } else if ( 'youtube' !== $slide_video_type ) {
                                                                            $slide_video_html = \Elementor\Embed::get_embed_html( $slide_video_url, $slide_embed_params,
                                                                                $slide_embed_options );
                                                                        }
                                                                    }

                                                                    if ( empty( $slide_video_html ) ) {
                                                                        echo esc_url( $slide_video_url );

                                                                        return;
                                                                    }

                                                                    $this->add_render_attribute( 'video-wrapper', 'class', 'elementor-wrapper' );
                                                                    $this->add_render_attribute( 'video-wrapper', 'class', 'elementor-open-lightbox' );

                                                                    echo '<span class="industrium-video-button' . ($slide_video_button_position == 'column' ? ' video-button-hide-desktop' : '') . '">';
                                                                    ?>
                                                                        <span <?php $this->print_render_attribute_string( 'video-wrapper' ); ?>>
                                                                            <?php
                                                                                    if ( 'hosted' === $slide_video_type ) {
                                                                                        $slide_lightbox_url = $slide_video_url;
                                                                                    } else {
                                                                                        $slide_lightbox_url = \Elementor\Embed::get_embed_url( $slide_video_url, $slide_embed_params, $slide_embed_options );
                                                                                    }
                                                                                    $slide_lightbox_options = [];

                                                                                    $slide_lightbox_options = [
                                                                                        'type'          => 'video',
                                                                                        'videoType'     => $slide_video_type,
                                                                                        'url'           => $slide_lightbox_url,
                                                                                        'modalOptions'  => [
                                                                                            'id'                        => 'elementor-lightbox-' . esc_attr($slide['_id']),
                                                                                            'videoAspectRatio'          => '169'
                                                                                        ]
                                                                                    ];
                                                                                    if('hosted' === $slide_video_type) {
                                                                                        $slide_lightbox_options['videoParams'] = $this->get_hosted_params();
                                                                                    }
                                                                                    $overlay_attr = 'image-overlay' . esc_attr($slide['_id']);
                                                                                    $this->add_render_attribute( $overlay_attr, [
                                                                                        'data-elementor-open-lightbox'  => 'yes',
                                                                                        'data-elementor-lightbox'       => wp_json_encode( $slide_lightbox_options ),
                                                                                    ] );

                                                                                    if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                                                                                        $this->add_render_attribute( $overlay_attr, [
                                                                                            'class' => 'elementor-clickable',
                                                                                        ] );
                                                                                    }

                                                                                    ?> <span <?php $this->print_render_attribute_string( $overlay_attr ); ?>>
                                                                                    <span class="elementor-custom-embed-play" role="button">
                                                                                        <i class="eicon-play" aria-hidden="true"><svg viewBox="0 0 23 27"><path d="M22,13.5L1,26V1L22,13.5z"/></svg></i>
                                                                                        <span class="elementor-screen-only"><?php esc_html_e( 'Play Video', 'industrium_plugin' ); ?></span>
                                                                                    </span>
                                                                                 </span><?php
                                                                            ?>
                                                                        </span>
                                                                    <?php
                                                                echo '</span>';
                                                            }

                                                        echo '</div>';
                                                    echo '</div>';
                                                }

                                            echo '</div>';

                                            if($add_video_button == 'yes' && $slide_video_button_position == 'column') {
                                                echo '<div class="slide-video-column">';
                                                    if (
                                                        ($add_video_button == 'yes' && 
                                                        $slide_video_button_position == 'column') && (
                                                            ( $slide_video_type == 'youtube' && !empty($slide_youtube_url) ) ||
                                                            ( $slide_video_type == 'vimeo' && !empty($slide_vimeo_url) ) ||
                                                            ( $slide_video_type == 'dailymotion' && !empty($slide_dailymotion_url) ) ||
                                                            ( $slide_video_type == 'hosted' && (
                                                                    !empty($slide_insert_url) ||
                                                                    !empty($slide_hosted_url) ||
                                                                    !empty($slide_external_url)
                                                                ) )
                                                        )
                                                    ) {
                                                        echo '<div class="industrium-content-wrapper-4">';
                                                            $slide_video_url = $slide[ 'slide_' . $slide_video_type . '_url' ];

                                                            if ( 'hosted' === $slide_video_type ) {
                                                                $slide_video_url = $this->get_hosted_video_url($slide_settings);
                                                            } else {
                                                                $slide_embed_params = $this->get_embed_params($slide_settings);
                                                                $slide_embed_options = $this->get_embed_options($slide_settings);
                                                            }

                                                            if ( 'youtube' === $slide_video_type ) {
                                                                $slide_video_html = '<div class="elementor-video"></div>';
                                                            }

                                                            if ( 'hosted' === $slide_video_type ) {
                                                                $this->add_render_attribute( 'video-wrapper', 'class', 'e-hosted-video' );

                                                                ob_start();

                                                                $this->render_hosted_video($slide_settings);

                                                                $slide_video_html = ob_get_clean();
                                                            } else {
                                                                $slide_is_static_render_mode = \Elementor\Plugin::$instance->frontend->is_static_render_mode();
                                                                $slide_post_id = get_queried_object_id();

                                                                if ( $slide_is_static_render_mode ) {
                                                                    $slide_video_html = \Elementor\Embed::get_embed_thumbnail_html( $slide_video_url, $slide_post_id );
                                                                } else if ( 'youtube' !== $slide_video_type ) {
                                                                    $slide_video_html = \Elementor\Embed::get_embed_html( $slide_video_url, $slide_embed_params,
                                                                        $slide_embed_options );
                                                                }
                                                            }

                                                            if ( empty( $slide_video_html ) ) {
                                                                echo esc_url( $slide_video_url );

                                                                return;
                                                            }

                                                            $this->add_render_attribute( 'video-wrapper', 'class', 'elementor-wrapper' );
                                                            $this->add_render_attribute( 'video-wrapper', 'class', 'elementor-open-lightbox' );

                                                            echo '<span class="industrium-video-button">';
                                                            ?>
                                                                <span <?php $this->print_render_attribute_string( 'video-wrapper' ); ?>>
                                                                    <?php
                                                                            if ( 'hosted' === $slide_video_type ) {
                                                                                $slide_lightbox_url = $slide_video_url;
                                                                            } else {
                                                                                $slide_lightbox_url = \Elementor\Embed::get_embed_url( $slide_video_url, $slide_embed_params, $slide_embed_options );
                                                                            }

                                                                            $slide_lightbox_options = [
                                                                                'type'          => 'video',
                                                                                'videoType'     => $slide_video_type,
                                                                                'url'           => $slide_lightbox_url,
                                                                                'modalOptions'  => [
                                                                                    'id'                        => 'elementor-lightbox-' . esc_attr($slide['_id'] . '-column'),
                                                                                    'videoAspectRatio'          => '169'
                                                                                ],
                                                                            ];
                                                                            if('hosted' === $slide_video_type) {
                                                                                $slide_lightbox_options['videoParams'] = $this->get_hosted_params();
                                                                            }
                                                                            $overlay_attr = 'image-overlay' . esc_attr($slide['_id'] . '-column');
                                                                            $this->add_render_attribute( $overlay_attr, [
                                                                                'data-elementor-open-lightbox'  => 'yes',
                                                                                'data-elementor-lightbox'       => wp_json_encode( $slide_lightbox_options ),
                                                                            ] );

                                                                            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                                                                                $this->add_render_attribute( $overlay_attr, [
                                                                                    'class' => 'elementor-clickable',
                                                                                ] );
                                                                            }

                                                                            ?> <span <?php $this->print_render_attribute_string( $overlay_attr ); ?>>
                                                                            <span class="elementor-custom-embed-play" role="button">
                                                                                <i class="eicon-play" aria-hidden="true"><svg viewBox="0 0 23 27"><path d="M22,13.5L1,26V1L22,13.5z"/></svg></i>
                                                                                <span class="elementor-screen-only"><?php esc_html_e( 'Play Video', 'industrium_plugin' ); ?></span>
                                                                            </span>
                                                                         </span><?php
                                                                    ?>
                                                                </span>
                                                            <?php
                                                            echo '</span>';
                                                        echo '</div>';
                                                    }
                                                echo '</div>';
                                            }

                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';

                                if ( !empty($slide['additional_image']) ) {
                                    echo '<div class="slide-image-column">';
                                        echo '<div class="additional-image tilt-effect">' .
                                        wp_get_attachment_image( $slide['additional_image']['id'], 'full' ) . '</div>';
                                    echo '</div>';
                                }

                            echo '</div>';
                        }
                        ?>
                    </div>                                          
                    <?php if ( $add_scroll_down == 'yes' ) {
                        echo '<div class="content-slider-scroll-down' . ( !empty($scroll_down_position) ? ' button-position-' . esc_attr($scroll_down_position) : '' ) . '" aria-label="Scroll Down"></div>';
                    } ?>        
                </div>
                <?php
                	$progress_items = array();
                	foreach ($content_items as $content_item) {
                		if($content_item['hide_slide'] !== 'yes') {
                			$progress_items[] = $content_item;
                		}
                	}
                    if (!empty($progress_items) && $progress && $settings['progress_position'] != 'pagination' ) {
                        echo '<div class="aside-area aside-area-position-' . ( !empty($settings['progress_position']) ? esc_attr($settings['progress_position']) : 'left' ) . '">';
                            echo '<div class="slider-progress-wrapper progress-direction-vertical">';
                                echo '<div class="slider-progress-current">01</div>';
                                echo '<div class="slider-progress-track"><div class="progress" style="height: ' . round(1/count($progress_items)*100) . '%"></div></div>';
                                echo '<div class="slider-progress-all">' . ( count($progress_items) < 10 ? '0' . count($progress_items) : count($progress_items) ) . '</div>';
                            echo '</div>';
                        echo '</div>';
                    }

                    if (
                        $add_contacts == 'yes' ||
                        $settings['dots'] == 'yes' ||
                        (
                            $add_video == 'yes' && (
                                ( $video_type == 'youtube' && !empty($youtube_url) ) ||
                                ( $video_type == 'vimeo' && !empty($vimeo_url) ) ||
                                ( $video_type == 'dailymotion' && !empty($dailymotion_url) ) ||
                                ( $video_type == 'hosted' && (
                                        !empty($insert_url) ||
                                        !empty($hosted_url) ||
                                        !empty($external_url)
                                    ) )
                            )
                        )
                    ) {
                        echo '<div class="bottom-area dots-alignment-' . ( !empty($settings['dots_align']) ? esc_attr($settings['dots_align']) : 'left' ) . '">';
                        if (
                            $add_contacts == 'yes' && (
                                !empty($contact_phone_title) ||
                                !empty($contact_phone_text)
                            )
                        ) {
                            echo '<div class="content-slider-contacts contacts">';
                            if(($add_decoration == 'yes' && $decoration_position == 'contacts') || ($add_decoration == 'yes' && ($settings['dots'] != 'yes' && $add_video != 'yes'))) {
                                echo '<div class="slider-decoration"></div>';
                            }
                            if ( !empty($contact_phone_title) || !empty($contact_phone_text) ) {
                                echo '<div class="contact-item contact-item-phone">';
                                echo ( !empty($contact_phone_title) ? '<div class="contact-item-title">' . esc_html($contact_phone_title) . '</div>' : '' );
                                echo ( !empty($contact_phone_text) ? '<div class="contact-item-text">' . wp_kses_post($contact_phone_text) . '</div>' : '' );
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        
                        if ( $settings['dots'] == 'yes' ||
                            $add_video == 'yes' && (
                                ( $video_type == 'youtube' && !empty($youtube_url) ) ||
                                ( $video_type == 'vimeo' && !empty($vimeo_url) ) ||
                                ( $video_type == 'dailymotion' && !empty($dailymotion_url) ) ||
                                ( $video_type == 'hosted' && (
                                        !empty($insert_url) ||
                                        !empty($hosted_url) ||
                                        !empty($external_url)
                                    ) )
                            ) ) {
                            echo '<div class="pagination-wrapper">';
                            if($add_decoration == 'yes' && $decoration_position == 'pagination' || ($add_decoration == 'yes' && $add_contacts != 'yes')) {
                                echo '<div class="slider-decoration"></div>';
                            }
                        }
                        if ( $add_video == 'yes' && (
                                ( $video_type == 'youtube' && !empty($youtube_url) ) ||
                                ( $video_type == 'vimeo' && !empty($vimeo_url) ) ||
                                ( $video_type == 'dailymotion' && !empty($dailymotion_url) ) ||
                                ( $video_type == 'hosted' && (
                                        !empty($insert_url) ||
                                        !empty($hosted_url) ||
                                        !empty($external_url)
                                    ) )
                            ) ) {
                            $video_url = $settings[ $settings['video_type'] . '_url' ];

                            if ( 'hosted' === $settings['video_type'] ) {
                                $video_url = $this->get_hosted_video_url();
                            } else {
                                $embed_params = $this->get_embed_params();
                                $embed_options = $this->get_embed_options();
                            }

                            if ( 'youtube' === $settings['video_type'] ) {
                                $video_html = '<div class="elementor-video"></div>';
                            }

                            if ( 'hosted' === $settings['video_type'] ) {
                                $this->add_render_attribute( 'video-wrapper', 'class', 'e-hosted-video' );

                                ob_start();

                                $this->render_hosted_video();

                                $video_html = ob_get_clean();
                            } else {
                                $is_static_render_mode = \Elementor\Plugin::$instance->frontend->is_static_render_mode();
                                $post_id = get_queried_object_id();

                                if ( $is_static_render_mode ) {
                                    $video_html = \Elementor\Embed::get_embed_thumbnail_html( $video_url, $post_id );
                                } else if ( 'youtube' !== $settings['video_type'] ) {
                                    $video_html = \Elementor\Embed::get_embed_html( $video_url, $embed_params, $embed_options );
                                }
                            }

                            if ( empty( $video_html ) ) {
                                echo esc_url( $video_url );

                                return;
                            }

                            $this->add_render_attribute( 'video-wrapper', 'class', 'elementor-wrapper' );

                            $this->add_render_attribute( 'video-wrapper', 'class', 'elementor-open-lightbox' );
                            ?>
                            <div class="content-slider-video">
                                <div <?php $this->print_render_attribute_string( 'video-wrapper' ); ?>>
                                <?php
                                    if ( 'hosted' === $settings['video_type'] ) {
                                        $lightbox_url = $video_url;
                                    } else {
                                        $lightbox_url = \Elementor\Embed::get_embed_url( $video_url, $embed_params, $embed_options );
                                    }

                                    $lightbox_options = [
                                        'type'          => 'video',
                                        'videoType'     => $settings['video_type'],
                                        'url'           => $lightbox_url,
                                        'modalOptions'  => [
                                            'id'                        => 'elementor-lightbox-' . $this->get_id(),
                                            'videoAspectRatio'          => '169'
                                        ],
                                    ];
                                    if('hosted' === $video_type) {
                                        $slide_lightbox_options['videoParams'] = $this->get_hosted_params();
                                    }

                                    $this->add_render_attribute( 'image-overlay', 'class', 'elementor-custom-embed-image-overlay' );

                                    $this->add_render_attribute( 'image-overlay', [
                                        'data-elementor-open-lightbox'  => 'yes',
                                        'data-elementor-lightbox'       => wp_json_encode( $lightbox_options ),
                                    ] );

                                    if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                                        $this->add_render_attribute( 'image-overlay', [
                                            'class' => 'elementor-clickable',
                                        ] );
                                    }

                                    ?>
                                    <div <?php $this->print_render_attribute_string( 'image-overlay' ); ?>>
                                        <div class="elementor-custom-embed-play" role="button">
                                            <i class="eicon-play" aria-hidden="true"><svg viewBox="0 0 23 27"><path d="M22,13.5L1,26V1L22,13.5z"/></svg></i>
                                            <?php 
                                                if(!empty($settings['video_button_text'])) {
                                                    echo '<span class="video-button-text">' . esc_html($settings['video_button_text']) . '</span>';
                                                }
                                            ?>
                                            <span class="elementor-screen-only"><?php esc_html_e( 'Play Video', 'industrium_plugin' ); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }

                        if ( $settings['dots'] == 'yes' ) {
                            echo '<div class="owl-dots-wrapper">';
                                if (!empty($progress_items) && $progress && $settings['progress_position'] == 'pagination' ) {
                                    echo '<div class="slider-progress-wrapper progress-direction-horizontal">';
                                        echo '<div class="slider-progress-current">01</div>';
                                        echo '<div class="slider-progress-track"><div class="progress" style="width: ' . round(1/count($progress_items)*100) . '%"></div></div>';
                                        echo '<div class="slider-progress-all">' . ( count($progress_items) < 10 ? '0' . count($progress_items) : count($progress_items) ) . '</div>';
                                    echo '</div>';
                                }
                                echo '<div class="owl-dots' . (!empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '') . '"></div>';
                            echo '</div>';
                        }
                        if ( $settings['dots'] == 'yes' ||
                            $add_video == 'yes' && (
                                ( $video_type == 'youtube' && !empty($youtube_url) ) ||
                                ( $video_type == 'vimeo' && !empty($vimeo_url) ) ||
                                ( $video_type == 'dailymotion' && !empty($dailymotion_url) ) ||
                                ( $video_type == 'hosted' && (
                                        !empty($insert_url) ||
                                        !empty($hosted_url) ||
                                        !empty($external_url)
                                    ) )
                            ) ) {
                            echo '</div>';
                        }                        
                        echo '</div>';
                    }  
                ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function get_embed_params($slide_settings = null) {
        $settings = $this->get_settings_for_display();
        if($slide_settings) {
            $settings = array_merge($settings, $slide_settings);
        }        
        $params = [];
        $params_dictionary = [];
        if ( 'youtube' === $settings['video_type'] ) {
            $params_dictionary = [];
            $params['wmode'] = 'opaque';
        } elseif ( 'vimeo' === $settings['video_type'] ) {
            $params_dictionary = [
                'mute'              => 'muted',
                'vimeo_title'       => 'title',
                'vimeo_portrait'    => 'portrait',
                'vimeo_byline'      => 'byline'
            ];
            $params['color'] = str_replace( '#', '', $settings['color'] );
            $params['autopause'] = '0';
        } elseif ( 'dailymotion' === $settings['video_type'] ) {
            $params_dictionary = [
                'showinfo'  => 'ui-start-screen-info',
                'logo'      => 'ui-logo',
            ];
            $params['ui-highlight'] = str_replace( '#', '', $settings['color'] );
            $params['endscreen-enable'] = '0';
        }
        foreach ( $params_dictionary as $key => $param_name ) {
            $setting_name = $param_name;
            if ( is_string( $key ) ) {
                $setting_name = $key;
            }
            $setting_value = $settings[ $setting_name ] ? '1' : '0';
            $params[ $param_name ] = $setting_value;
        }

        return $params;
    }

    private function get_embed_options($slide_settings = null) {
        $settings = $this->get_settings_for_display();
        if($slide_settings) {
            $settings = array_merge($settings, $slide_settings);
        }
        $embed_options = [];
        if ( 'youtube' === $settings['video_type'] ) {
            $embed_options['privacy'] = 'no';
        }

        return $embed_options;
    }

    private function get_hosted_video_url($slide_settings = null) {
        $settings = $this->get_settings_for_display();
        if($slide_settings) {
            $settings = array_merge($settings, $slide_settings);
        }
        if ( ! empty( $settings['insert_url'] ) ) {
            $video_url = $settings['external_url']['url'];
        } else {
            $video_url = $settings['hosted_url']['url'];
        }
        if ( empty( $video_url ) ) {
            return '';
        }

        return $video_url;
    }

    private function get_hosted_params($slide_settings = null) {
        $settings = $this->get_settings_for_display();

        $video_params = ['autoplay' => true, 'loop' => false, 'controls' => true];

        return $video_params;
    }

    private function render_hosted_video($slide_settings = null) {
        $video_url = $this->get_hosted_video_url($slide_settings);
        if ( empty( $video_url ) ) {
            return;
        }
        $video_params = $this->get_hosted_params($slide_settings);
        ?>
        <video class="elementor-video"> src="<?php echo esc_url( $video_url ); ?>" <?php Utils::print_html_attributes( $video_params ); ?>></video>
        <?php
    }

    private function get_bg_video_embed_params($slide_settings = []) {
        $settings = $slide_settings;

        $params = [];

        if ( $settings['autoplay'] ) {
            $params['autoplay'] = '1';

            if ( $settings['play_on_mobile'] ) {
                $params['playsinline'] = '1';
            }
        }
        if(!$settings['play_once']) {
            $params['loop'] = '1';
            $video_properties = Embed::get_video_properties( $settings['video_url'] );

            $params['playlist'] = $video_properties['video_id'];
        }
        $params['controls'] = '0';
        $params['mute'] = '1';

        $params['start'] = $settings['start'];

        $params['end'] = $settings['end'];

        $params['wmode'] = 'opaque';

        return $params;
    }

    private function get_bg_video_embed_options($slide_settings = []) {
        $settings = $slide_settings;

        $embed_options = [];

        $embed_options['privacy'] = $settings['yt_privacy'];

        $embed_options['lazy_load'] = false;

        return $embed_options;
    }
}
