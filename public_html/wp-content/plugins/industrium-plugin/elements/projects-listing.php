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

class Industrium_Projects_Listing_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_projects_listing';
    }

    public function get_title() {
        return esc_html__('Projects Listing', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-gallery-justified';
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
            'section_content_settings',
            [
                'label'         => esc_html__('Projects Listing', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'listing_type',
            [
                'label'         => esc_html__('Type', 'industrium_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'grid',
                'options'       => [
                    'grid'          => esc_html__('Grid', 'industrium_plugin'),
                    'masonry'       => esc_html__('Masonry', 'industrium_plugin'),
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
                    'type-2'       => esc_html__('Type 2', 'industrium_plugin')
                ],
                'condition' => [
                    'listing_type' => 'slider'
                ]
            ]
        );

        $this->add_control(
            'title',
            [
                'label'         => esc_html__('Title', 'industrium_plugin'),
                'type'          => Controls_Manager::WYSIWYG,
                'condition'     => [
                    'listing_type'  => 'slider'
                ]
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
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'condition'     => [
                    'listing_type'  => 'slider'
                ]
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
                    'add_subtitle'  => 'yes',
                    'listing_type'  => 'slider'
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
                    'listing_type'  => 'slider'
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
                'default'   => 'h2',
                'condition' => [
                    'listing_type'  => 'slider'
                ]
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
                ],
                'condition'     => [
                    'listing_type'  => 'slider'
                ]
            ]
        );

        $this->add_control(
            'text_position',
            [
                'label'         => esc_html__('Content Position', 'industrium_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'outside',
                'options'       => [
                    'inside'        => esc_html__('Inside', 'industrium_plugin'),
                    'outside'       => esc_html__('Outside', 'industrium_plugin')
                ],
                'condition' => [
                    'listing_type!' => 'slider'
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
                ],
                'separator'     => 'before'
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
                    'cat'           => esc_html__('Category', 'industrium_plugin'),
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
                'options'       => industrium_get_all_taxonomy_terms('industrium_project', 'industrium_project_category'),
                'condition'     => [
                    'filter_by'     => 'cat'
                ]
            ]
        );

        $this->add_control(
            'projects',
            [
                'label'         => esc_html__('Choose Projects', 'industrium_plugin'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => industrium_get_all_post_list('industrium_project'),
                'label_block'   => true,
                'multiple'      => true,
                'condition'     => [
                    'filter_by'     => 'id'
                ]
            ]
        );

        $this->add_control(
            'show_categories',
            [
                'label'         => esc_html__('Show Categories', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label'         => esc_html__('Excerpt', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'     => esc_html__('Excerpt Length, in symbols', 'industrium_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 0,
                'default'   => 71
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label'         => esc_html__("'Read More' Button", 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes',
                'condition'     => [
                    'listing_type!' => 'slider'
                ]
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'         => esc_html__('Button Text', 'industrium_plugin'),
                'placeholder'   => esc_html__('Enter text', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Read More', 'industrium_plugin'),
                'condition'     => [
                    'show_read_more'    => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_filter',
            [
                'label'         => esc_html__('Show Filter', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'separator'     => 'before',
                'condition'     => [
                    'filter_by'     => 'cat',
                    'listing_type' => 'masonry'
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
                'condition'     => [
                    'listing_type!'  => 'slider'
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
                'label'         => esc_html__('Grid Settings', 'industrium_plugin'),
                'condition'     => [
                    'listing_type'  => 'grid'
                ]
            ]
        );

        $this->add_control(
            'grid_columns_number',
            [
                'label'         => esc_html__('Columns Number', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3,
                'min'           => 1,
                'max'           => 6
            ]
        );

        $this->add_control(
            'grid_posts_per_page',
            [
                'label'         => esc_html__('Items Per Page', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3,
                'min'           => -1
            ]
        );

        $this->end_controls_section();


        // -------------------------------------- //
        // ---------- Masonry Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_masonry_settings',
            [
                'label'         => esc_html__('Masonry Settings', 'industrium_plugin'),
                'condition'     => [
                    'listing_type'  => 'masonry'
                ]
            ]
        );

        $this->add_control(
            'masonry_columns_number',
            [
                'label'         => esc_html__('Columns Number', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3,
                'min'           => 1,
                'max'           => 6
            ]
        );

        $this->add_control(
            'masonry_posts_per_page',
            [
                'label'         => esc_html__('Items Per Page', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3,
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
                'label'         => esc_html__('Slider Settings', 'industrium_plugin'),
                'condition'     => [
                    'listing_type'  => 'slider'
                ]
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

        $this->end_controls_section();


        // -------------------------------------- //
        // ---------- Filter Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'filter_settings_section',
            [
                'label'     => esc_html__('Filter Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'filter_by'     => 'cat',
                    'listing_type!' => 'slider',
                    'show_filter'   => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'filter_typography',
                'label'     => esc_html__('Filter Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .filter-control-wrapper .filter-control-item'
            ]
        );

        $this->start_controls_tabs('filter_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_filter_normal',
                [
                    'label'     => esc_html__('Normal', 'industrium_plugin')
                ]
            );
                $this->add_control(
                    'filter_color_normal',
                    [
                        'label'     => esc_html__('Filter Item Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .filter-control-wrapper .filter-control-item' => 'color: {{VALUE}};'
                        ]
                    ]
                );
            $this->end_controls_tab();

            // ------ Active Tab ------ //
            $this->start_controls_tab(
                'tab_filter_active',
                [
                    'label'         => esc_html__('Active', 'industrium_plugin')
                ]
            );
                $this->add_control(
                    'filter_color_hover',
                    [
                        'label'     => esc_html__('Filter Item Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .filter-control-wrapper .filter-control-item:hover, {{WRAPPER}} .filter-control-wrapper .filter-control-item.active' => 'color: {{VALUE}};'
                        ]
                    ]
                );
            $this->end_controls_tab();
        $this->end_controls_tabs();

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
                    'listing_type'  => 'slider'
                ]
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

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'      => 'title_shadow',
                'label'     => esc_html__('Heading Text Shadow', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .industrium-heading .industrium-heading-content'
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
                    'listing_type' => 'slider'
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
                    '{{WRAPPER}} .project-listing-wrapper.project-grid-listing.text-position-outside, {{WRAPPER}} .project-listing-wrapper.project-masonry-listing.text-position-outside' =>
                        'margin-left: calc(-{{SIZE}}{{UNIT}}/2); margin-right: calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .project-listing-wrapper.project-grid-listing.text-position-outside .project-item-wrapper, {{WRAPPER}} .project-listing-wrapper.project-masonry-listing.text-position-outside .project-item-wrapper' => 'padding-left: calc({{SIZE}}{{UNIT}}/2); padding-right: calc({{SIZE}}{{UNIT}}/2);',

                    '{{WRAPPER}} .project-listing-wrapper.owl-carousel' => 'margin-left: calc(-{{SIZE}}{{UNIT}}/2); margin-right: calc(-{{SIZE}}{{UNIT}}/2); width: calc(100% + {{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .project-listing-wrapper.owl-carousel .project-item-wrapper' => 'padding-left: calc({{SIZE}}{{UNIT}}/2); padding-right: calc({{SIZE}}{{UNIT}}/2);',

                    '{{WRAPPER}} .project-listing-wrapper.project-masonry-listing.text-position-inside, {{WRAPPER}} .project-listing-wrapper.project-grid-listing.text-position-inside' => 'margin: calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .project-listing-wrapper.project-masonry-listing.text-position-inside .project-item-wrapper, {{WRAPPER}} .project-listing-wrapper.project-grid-listing.text-position-inside .project-item-wrapper' => 'padding: calc({{SIZE}}{{UNIT}}/2);'
                ]
            ]
        );

        $this->add_responsive_control(
            'item_height',
            [
                'label'     => esc_html__('Slider Item Height', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 800
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 645
                ],
                'selectors' => [
                    '{{WRAPPER}} .project-slider-listing .project-item-link' =>
                        'height: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'listing_type' => 'slider'
                ]
            ]
        );

        $this->add_control(
            'slider_item_border_color',
            [
                'label'     => esc_html__('Item Border Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-listing-wrapper.project-slider-listing .slider-item' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .project-listing-wrapper.project-slider-listing .slider-item:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .project-slider-listing.view-type-2 .owl-item.active + .active .slider-item .project-item-content' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .project-slider-listing.view-type-2 .owl-item.active + .active .slider-item .button-container' => 'border-color: {{VALUE}};'
                ],
                'condition' => [
                    'listing_type' => 'slider'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------ //
        // ---------- Media Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'media_settings_section',
            [
                'label'     => esc_html__('Media Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'media_background_color',
            [
                'label'     => esc_html__('Image Overlay Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-item-wrapper .project-item-link .project-item-media:before' => 'background-color: {{VALUE}};'
                ]
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
                'name'      => 'name_typography',
                'label'     => esc_html__('Project Name Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .project-item .post-title'
            ]
        );

        $this->start_controls_tabs('content_name_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_name_normal',
                [
                    'label'     => esc_html__('Normal', 'industrium_plugin')
                ]
            );
                $this->add_control(
                    'name_color_normal',
                    [
                        'label'     => esc_html__('Name Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .project-item .post-title, {{WRAPPER}} .project-item .post-title a' => 'color: {{VALUE}};'
                        ]
                    ]
                );
            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_name_hover',
                [
                    'label'     => esc_html__('Hover', 'industrium_plugin')
                ]
            );
                $this->add_control(
                    'name_color_hover',
                    [
                        'label'     => esc_html__('Name Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .project-item .post-title a:hover, {{WRAPPER}} .project-item .project-item-link:hover .post-title' => 'color: {{VALUE}};'
                        ]
                    ]
                );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cat_typography',
                'label'     => esc_html__('Categories Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .project-item-categories'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'excerpt_typography',
                'label'     => esc_html__('Excerpt Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .project-item .project-item-excerpt'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'counter_typography',
                'label'     => esc_html__('Counter Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .project-item .slide-counter-big',
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-2'
                ]
            ]
        );

        $this->start_controls_tabs('content_cat_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_cat_normal',
                [
                    'label'     => esc_html__('Normal', 'industrium_plugin')
                ]
            );
                $this->add_control(
                    'cat_color_normal',
                    [
                        'label'     => esc_html__('Categories Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .project-item-categories, {{WRAPPER}} .project-item-categories a' => 'color: {{VALUE}};'
                        ]
                    ]
                );                    

                $this->add_control(
                    'excerpt_color',
                    [
                        'label'     => esc_html__('Excerpt Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .project-item .project-item-excerpt' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'counter_big_color',
                    [
                        'label'     => esc_html__('Counter Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .project-slider-listing.view-type-2 .slider-item .slide-counter-big' => '-webkit-text-stroke: 1px {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type' => 'slider',
                            'view_type' => 'type-2'
                        ]
                    ]
                );
            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_cat_hover',
                [
                    'label'     => esc_html__('Hover', 'industrium_plugin')
                ]
            );
                $this->add_control(
                    'cat_color_hover',
                    [
                        'label'     => esc_html__('Categories Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .project-item-categories a:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'excerpt_color_hover',
                    [
                        'label'     => esc_html__('Excerpt Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .project-item .project-item-link:hover .project-item-excerpt' => 'color: {{VALUE}};'
                        ]
                    ]
                );
                $this->add_control(
                    'counter_big_hover',
                    [
                        'label'     => esc_html__('Counter Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .project-slider-listing.view-type-2 .slider-item .project-item-content .slide-counter-big' => '-webkit-text-stroke: 1px {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type' => 'slider',
                            'view_type' => 'type-2'
                        ]
                    ]
                );
            $this->end_controls_tab();
        $this->end_controls_tabs();    

        $this->add_control(
            'more_bg_color',
            [
                'label'     => esc_html__('More Button Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-slider-listing.view-type-2 .slider-item .button-container' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-2'
                ]
            ]
        );
        $this->add_control(
            'more_button_color',
            [
                'label'     => esc_html__('More Button Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-slider-listing.view-type-2 .slider-item .button-container .industrium-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .project-slider-listing.view-type-2 .slider-item .button-container .industrium-button:after' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-2'
                ]
            ]
        );


        $this->add_responsive_control(
            'content_width',
            [
                'label' => esc_html__( 'Content Width', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .project-item .project-item-content .post-title > span' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .project-item .project-item-content .project-item-categories' => 'max-width: {{SIZE}}{{UNIT}};',                    
                    '{{WRAPPER}} .project-item .project-item-content .project-item-excerpt' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'text_position',
                            'operator' => '==',
                            'value' => 'inside',
                        ],
                        [
                            'name' => 'listing_type',
                            'operator' => '==',
                            'value' => 'slider',
                        ]
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__( 'Title Padding', 'industrium_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .project-item .project-item-content .post-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Content Padding', 'industrium_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .project-item .project-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .project-item .project-item-content-alt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('content_bg_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_bg_normal',
                [
                    'label'     => esc_html__('Normal', 'industrium_plugin'),
                    'separator' => 'after'
                ]
            );
                $this->add_control(
                    'content_bg_color_normal',
                    [
                        'label'     => esc_html__('Content Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .project-item .project-item-content' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );
            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_bg_hover',
                [
                    'label'     => esc_html__('Hover', 'industrium_plugin')
                ]
            );
                $this->add_control(
                    'content_bg_color_hover',
                    [
                        'label'     => esc_html__('Content Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .project-item .project-item-link:hover .project-item-content' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'content_button_color',
            [
                'label'     => esc_html__('Content Button Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-item-wrapper .project-item-content .project-item-button' => 'color: {{VALUE}};'
                ],
                'condition'     => [
                    'listing_type!' => 'slider'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'more_typography',
                'label'     => esc_html__('More Button Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .post-more-button .industrium-button',
                'condition' => [
                    'show_read_more' => 'yes'
                ],
                'separator' => 'before'
            ]
        );

        $this->start_controls_tabs('more_button_settings_tabs',
            [
                'condition' => [
                    'show_read_more' => 'yes'
                ]
            ]            
        );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_more_button_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'more_color',
                    [
                        'label'     => esc_html__('More Button Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-more-button .industrium-button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'more_border_color',
                    [
                        'label'     => esc_html__('More Button Border Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-more-button .industrium-button:after' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .post-more-button .industrium-button'  => 'background-image: linear-gradient(0deg, {{VALUE}} 0%, {{VALUE}} 100%);',
                            '{{WRAPPER}} .post-more-button .industrium-button svg'   => 'stroke: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_more_button_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'more_color_hover',
                    [
                        'label'     => esc_html__('Button Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-more-button .industrium-button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'more_border_color_hover',
                    [
                        'label'     => esc_html__('More Button Border Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-more-button .industrium-button:hover svg'   => 'stroke: {{VALUE}};',
                            '{{WRAPPER}} .post-more-button .industrium-button:hover'  => 'background-image: linear-gradient(0deg, {{VALUE}} 0%, {{VALUE}} 100%);',
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
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'listing_type'  => 'slider'
                ]
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

        $this->start_controls_tabs('slider_nav_settings_tabs');

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
                        'label' => esc_html__('Slider Arrows Color', 'industrium_plugin'),
                        'type' => Controls_Manager::COLOR,
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
                    'label' => esc_html__('Hover', 'industrium_plugin')
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


        // ----------------------------------------- //
        // ---------- Pagination Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'pagination_settings_section',
            [
                'label'     => esc_html__('Pagination Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'listing_type!'     => 'slider',
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
                            '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover)' => 'color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_control(
                    'pagination_border_color',
                    [
                        'label'     => esc_html__('Pagination Border Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover)' => 'border-color: {{VALUE}};'
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

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'pagination_shadow',
                        'label'     => esc_html__('Item Shadow', 'industrium_plugin'),
                        'selector'  => '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover)'
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

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'pagination_shadow_active',
                        'label'     => esc_html__('Item Shadow', 'industrium_plugin'),
                        'selector'  => '{{WRAPPER}} .content-pagination .page-numbers.current, {{WRAPPER}} .content-pagination .post-page-numbers.current, {{WRAPPER}} .content-pagination .page-numbers:hover, {{WRAPPER}} .content-pagination .post-page-numbers:hover'
                    ]
                );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings               = $this->get_settings();

        $listing_type           = $settings['listing_type'];
        $view_type              = $settings['view_type'];
        $title                  = $settings['title'];
        $title_tag              = $settings['title_tag'];
        $add_subtitle           = $settings['add_subtitle'];
        $subtitle               = $settings['subtitle'];
        $add_button             = $settings['add_button'];
        $text_position          = $settings['text_position'];
        $post_order_by          = $settings['post_order_by'];
        $post_order             = $settings['post_order'];
        $filter_by              = $settings['filter_by'];
        $categories             = $settings['categories'];
        $projects               = $settings['projects'];
        $show_filter            = $settings['show_filter'];
        $pagination             = $settings['show_pagination'];
        $show_categories        = $settings['show_categories'];
        $show_excerpt           = $settings['show_excerpt'];
        $show_read_more         = $settings['show_read_more'];
        $read_more_text         = $settings['read_more_text'];
        $excerpt_length         = $settings['excerpt_length'];
        $paged                  = isset( $_GET[esc_attr($this->get_id()) . '-paged'] ) && $pagination == 'yes' ? (int)$_GET[esc_attr($this->get_id()) . '-paged'] : 1;

        $grid_columns_number    = $settings['grid_columns_number'];
        $grid_posts_per_page    = $settings['grid_posts_per_page'];

        $masonry_columns_number = $settings['masonry_columns_number'];
        $masonry_posts_per_page = $settings['masonry_posts_per_page'];

        $items                  = $settings['items'];
        $nav                    = $settings['nav'];
        $dots                   = $settings['dots'];
        $speed                  = $settings['speed'];
        $infinite               = $settings['infinite'];
        $autoplay               = $settings['autoplay'];
        $autoplay_speed         = $settings['autoplay_speed'];
        $autoplay_timeout       = $settings['autoplay_timeout'];
        $pause_on_hover         = $settings['pause_on_hover'];

        $widget_class           = 'industrium-projects-listing-widget';
        $wrapper_class          = 'archive-listing-wrapper project-listing-wrapper' . ( (!empty($text_position) && ($listing_type == 'grid' || $listing_type == 'masonry')) ? ' text-position-' . esc_attr($text_position) : '' );
        $widget_attr            = '';
        $wrapper_attr           = '';

        $button_text    = $settings['button_text'];
        $button_link    = $settings['button_link'];

        if ($button_link['url'] !== '') {
            $button_url = $button_link['url'];
        } else {
            $button_url = '#';
        }

        global $wp;
        $base = home_url($wp->request);

        $query_options          = [
            'post_type'             => 'industrium_project',
            'ignore_sticky_posts'   => true,
            'suppress_filters'      => true,
            'orderby'               => sanitize_key($post_order_by),
            'order'                 => sanitize_key($post_order),
            'link_base'             => esc_url($base)
        ];

        if ( $filter_by == 'cat' ) {
            $query_options = array_merge($query_options, [
                'industrium_project_category'  => $categories
            ]);
        } elseif ( $filter_by == 'id' ) {
            $query_options = array_merge($query_options, [
                'post__in'          => $projects
            ]);
        };

        if ( $listing_type == 'masonry' ) {
            $widget_class       .= ' isotope' . ( $show_filter == 'yes' && $filter_by == 'cat' ? esc_attr(' isotope-filter') : '' );
            $wrapper_class      .= ' isotope-trigger project-masonry-listing' . ( !empty($grid_columns_number) ? ' columns-' . esc_attr($grid_columns_number) : '' );
            $widget_options     = array(
                'item_class'            => 'project-item-wrapper isotope-item',
                'columns_number'        => absint($masonry_columns_number),
                'listing_type'          => 'masonry',
                'text_position'         => $text_position,
                'show_categories'       => $show_categories,
                'show_excerpt'          => $show_excerpt,
                'excerpt_length'        => $excerpt_length,
                'show_read_more'        => $show_read_more,
                'read_more_text'        => $read_more_text,
                'listing_type'          => $listing_type
            );
            $widget_attr        .= ( $show_filter == 'yes' && $filter_by == 'cat' ? ' data-columns=' . esc_attr($masonry_columns_number) . ' data-spacings=true' : '');
            $query_options      = array_merge($query_options, [
                'posts_per_page'        => ( !empty($masonry_posts_per_page) ? $masonry_posts_per_page : -1 ),
                'paged'                 => $paged
            ]);
        } elseif ( $listing_type == 'slider' ) {
            $widget_id              = $this->get_id();
            $dots_container_desktop = ( !empty($title) && !empty($widget_id) ? '.owl-dots-desktop.owl-dots-' . esc_attr($widget_id) : '.owl-dots-' . esc_attr($widget_id) );
            $dots_container_mobile  = ( !empty($title) && !empty($widget_id) ? '.owl-dots-mobile.owl-dots-' . esc_attr($widget_id) : $dots_container_desktop );
            $slider_options         = [
                'items'                 => !empty($items) ? (int)$items : 1,
                'nav'                   => ('yes' === $nav),
                'dots'                  => ('yes' === $dots),
                'dotsContainer'         => $dots_container_desktop,
                'dotsContainerMobile'   => $dots_container_mobile,
                'autoplayHoverPause'    => ('yes' === $pause_on_hover),
                'autoplay'              => ('yes' === $autoplay),
                'autoplaySpeed'         => absint($autoplay_speed),
                'autoplayTimeout'       => absint($autoplay_timeout),
                'loop'                  => ('yes' === $infinite),
                'speed'                 => absint($speed)
            ];
            $widget_options     = array(
                'item_class'            => 'project-item-wrapper slider-item',
                'columns_number'        => absint($items),
                'listing_type'          => 'slider',
                'text_position'         => $text_position,
                'show_categories'       => $show_categories,
                'show_excerpt'          => $show_excerpt,
                'excerpt_length'        => $excerpt_length,
                'listing_type'          => $listing_type,
                'view_type'             => $view_type
            );
            $query_options      = array_merge($query_options, [
                'posts_per_page'        => -1
            ]);
            $wrapper_attr       = ' data-slider-options=' . esc_attr(wp_json_encode($slider_options));
            $wrapper_class      .= ' project-slider-listing owl-carousel owl-theme' . (!empty($view_type) ? ' view-' . $view_type : '');
        } else {
            $wrapper_class      .= ' project-grid-listing' . ( !empty($grid_columns_number) ? ' columns-' . esc_attr($grid_columns_number) : '' );
            $widget_options     = array(
                'item_class'            => 'project-item-wrapper',
                'columns_number'        => absint($grid_columns_number),
                'listing_type'          => 'grid',
                'text_position'         => $text_position,
                'show_categories'       => $show_categories,
                'show_excerpt'          => $show_excerpt,
                'excerpt_length'        => $excerpt_length,
                'show_read_more'        => $show_read_more,
                'read_more_text'        => $read_more_text,
                'listing_type'          => $listing_type
            );
            $query_options      = array_merge($query_options, [
                'posts_per_page'        => ( !empty($grid_posts_per_page) ? $grid_posts_per_page : -1 ),
                'columns_number'        => $grid_columns_number,
                'paged'                 => $paged
            ]);
        }

        $query = new \WP_Query($query_options);
        $ajax_data = wp_json_encode($query_options);
        $widget_data = wp_json_encode($widget_options);

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="<?php echo esc_attr($widget_class); ?>"<?php echo esc_html($widget_attr); ?>>

            <?php
                if ( $show_filter == 'yes' && $filter_by == 'cat' && $listing_type == 'masonry' ) {
                    $terms = array();
                    foreach ($categories as $category) {
                        $current_terms = get_term_by('slug', $category, 'industrium_project_category');
                        $terms[] = $current_terms;
                    }

                    if ( count( $terms ) > 1 ) {
                        echo "<div class='filter-control-wrapper'>";

                        foreach ( $terms as $term ) {
                            $term_name = $term->name;
                            $filter_vals[$term->slug] = $term_name;
                        }
                        if ( $filter_vals > 1 ){
                            echo "<nav class='nav filter-control-list' data-taxonomy='industrium_project_category'>";
                                echo "<div class='dots'>";
                                    echo "<span class='dot filter-control-item all active' data-value='all'>";
                                        esc_html_e( 'All', 'industrium' );
                                    echo "</span>";
                                    foreach ( $filter_vals as $term_slug => $term_name ){
                                        echo "<span class='dot filter-control-item' data-value='" . esc_html( $term_slug ) . "'>";
                                            echo esc_html( $term_name );
                                        echo "</span>";
                                    }
                                echo "</div>";
                            echo "</nav>";
                        }
                        echo "</div>";
                    }
                }
            ?>

            <?php
                if ( $listing_type == 'slider' && !empty($title) ) {
                    echo '<' . esc_html($title_tag) . ' class="industrium-heading heading-with-pagination' . '">';
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
                        if($add_button == 'yes' || $dots == 'yes') {
                            echo '<span class="pagination_wrapper">';
                                if($add_button == 'yes') { ?>
                                    <a class="industrium-button" href="<?php echo esc_url($button_url); ?>" <?php echo (($button_link['is_external'] == true) ? 'target="_blank"' : ''); echo (($button_link['nofollow'] == 'on') ? 'rel="nofollow"' : ''); ?>><?php echo esc_html($button_text); ?><svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5"></polyline></svg></a>
                                <?php }
                                if ( $dots == 'yes' ) {
                                    echo '<span class="owl-dots owl-dots-desktop' . (!empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '') . '"></span>';
                                }
                            echo '</span>';
                        }                        
                    echo '</' . esc_html($title_tag) . '>';
                }
            ?>

            <div class="archive-listing" data-ajax='<?php echo esc_attr($ajax_data); ?>' data-widget='<?php echo esc_attr($widget_data); ?>'>
                <div class="<?php echo esc_attr($wrapper_class); ?>"<?php echo esc_html($wrapper_attr); ?>>
                    <?php
                        if($listing_type == 'slider' && $view_type == 'type-2') {
                            $count = 0;
                        }
                        while( $query->have_posts() ){
                            if($listing_type == 'slider' && $view_type == 'type-2') {
                                $count++;
                                $widget_options['slide_count'] = $count;
                            }
                            $query->the_post();
                            get_template_part('content', 'industrium_project', $widget_options);
                        };
                        wp_reset_postdata();
                    ?>
                </div>

                <?php
                    if ( $pagination == 'yes' && $listing_type != 'slider' ) {
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
                if ( $listing_type == 'slider' && $dots == 'yes' ) {
                    if(empty($title) && $view_type == 'type-1') {
                        echo '<div class="owl-dots' . ( !empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '' ) . '"></div>';
                    }
                    if(!empty($title) && $view_type == 'type-2') {
                        echo '<div class="owl-dots owl-dots-mobile' . ( !empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '' ) . '"></div>';      
                    } else if(empty($title) && $view_type == 'type-2') {
                        echo '<div class="owl-dots' . ( !empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '' ) . '"></div>';
                    }
                }
            ?>

        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}