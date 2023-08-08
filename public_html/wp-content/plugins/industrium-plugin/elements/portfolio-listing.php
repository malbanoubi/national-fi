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

class Industrium_Portfolio_Listing_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_portfolio_listing';
    }

    public function get_title() {
        return esc_html__('Portfolio Listing', 'industrium_plugin');
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
            'section_content',
            [
                'label' => esc_html__('Portfolio Listing', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'listing_type',
            [
                'label'     => esc_html__('Type', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'industrium_plugin'),
                    'masonry'   => esc_html__('Masonry', 'industrium_plugin'),
                    'slider'    => esc_html__('Slider', 'industrium_plugin')
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
                    'type-1'       => esc_html__('Type 1', 'industrium_plugin'),
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
                    'listing_type'  => 'slider',
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
                'options'       => industrium_get_all_taxonomy_terms('industrium_portfolio', 'industrium_portfolio_category'),
                'condition'     => [
                    'filter_by'     => 'cat'
                ]
            ]
        );

        $this->add_control(
            'portfolios',
            [
                'label'         => esc_html__('Choose Portfolio', 'industrium_plugin'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => industrium_get_all_post_list('industrium_portfolio'),
                'label_block'   => true,
                'multiple'      => true,
                'condition'     => [
                    'filter_by'     => 'id'
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
                    'listing_type!' => 'slider'
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
                'default'       => 4,
                'min'           => 1,
                'max'           => 6
            ]
        );

        $this->add_control(
            'masonry_posts_per_page',
            [
                'label'         => esc_html__('Items Per Page', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 8,
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
            'next_button',
            [
                'label'         => esc_html__('Show Next Button', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => '',
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
            'slider_container_padding',
            [
                'label' => esc_html__( 'Slider Widget Padding', 'industrium_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .industrium-portfolios-listing-widget.view-type-2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-2'
                ]
            ]
        );

        $this->add_control(
            'slider_container_bg',
            [
                'label'     => esc_html__('Slider Widget Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-portfolios-listing-widget.view-type-2' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-2'
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
                    '{{WRAPPER}} .portfolio-listing-wrapper.portfolio-grid-listing' =>
                        'margin: calc(-{{SIZE}}{{UNIT}}/2);width: calc(100% + {{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .portfolio-listing-wrapper.portfolio-masonry-listing' =>
                        'margin: calc(-{{SIZE}}{{UNIT}}/2);width: calc(100% + {{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .portfolio-listing-wrapper.portfolio-grid-listing .portfolio-item' => 'padding: calc({{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .portfolio-listing-wrapper.owl-carousel' => 'margin-left: calc(-{{SIZE}}{{UNIT}}/2); margin-right: calc(-{{SIZE}}{{UNIT}}/2);width: calc(100% + {{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .portfolio-listing-wrapper.owl-carousel .portfolio-item' => 'padding-left: calc({{SIZE}}{{UNIT}}/2);padding-right: calc({{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .portfolio-listing-wrapper.portfolio-masonry-listing .portfolio-item-wrapper .portfolio-item-link' => 
                        'top: calc({{SIZE}}{{UNIT}}/2);
                         right: calc({{SIZE}}{{UNIT}}/2);
                         bottom: calc({{SIZE}}{{UNIT}}/2);
                         left: calc({{SIZE}}{{UNIT}}/2);',
                ]
            ]
        );

        $this->add_responsive_control(
            'slider_height',
            [
                'label'     => esc_html__('Slider Height', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 1200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-listing-wrapper.portfolio-slider-listing .slider-item .portfolio-item-link' =>
                        'height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .portfolio-item-wrapper .portfolio-item-link .portfolio-item-media:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'overlay_opacity',
            [
                'label' => esc_html__( 'Overlay Opacity', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item-link .portfolio-item-media:before' => 'opacity: {{SIZE}};',
                ]
            ]
        );

        $this->add_control(
            'overlay_opacity_hover',
            [
                'label' => esc_html__( 'Hover Overlay Opacity', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item-link:hover .portfolio-item-media:before' => 'opacity: {{SIZE}};',
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
                'label'     => esc_html__('Portfolio Name Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .portfolio-item .post-title'
            ]
        );

        $this->start_controls_tabs('content_tabs');
        // ------ Normal Tab ------ //
        $this->start_controls_tab(
            'tab_content_normal',
            [
                'label'     => esc_html__('Normal', 'industrium_plugin')
            ]
        );
        $this->add_control(
            'content_bg_color_normal',
            [
                'label'     => esc_html__('Content Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item .portfolio-item-content-inner' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        $this->end_controls_tab();

        // ------ Hover Tab ------ //
        $this->start_controls_tab(
            'tab_content_hover',
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
                    '{{WRAPPER}} .portfolio-slider-listing .portfolio-item-link:hover .portfolio-item-content-inner' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .portfolio-grid-listing .portfolio-item .portfolio-item-content-inner:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .portfolio-masonry-listing .portfolio-item .portfolio-item-content-inner:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

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
                    '{{WRAPPER}} .portfolio-item .post-title, {{WRAPPER}} .portfolio-item .post-title a' => 'color: {{VALUE}};'
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
                    '{{WRAPPER}} .portfolio-item .portfolio-item-link:hover .post-title' => 'color: {{VALUE}};'
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

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
                    '{{WRAPPER}} .portfolio-slider-listing .portfolio-item .portfolio-item-content-inner' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'listing_type' => 'slider'
                ]
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Content Padding', 'industrium_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item .portfolio-item-content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

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
                'selector'  => '{{WRAPPER}} .portfolio-item-categories'
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
                    '{{WRAPPER}} .post-category-item' => 'color: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'cat_bg_color_normal',
            [
                'label'     => esc_html__('Categories Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-category-item' => 'background-color: {{VALUE}};'
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
                    '{{WRAPPER}} .portfolio-item-link:hover .post-category-item' => 'color: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'cat_bg_color_hover',
            [
                'label'     => esc_html__('Categories Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item-link:hover .post-category-item' => 'background-color: {{VALUE}};'
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

        $this->start_controls_tabs('next_button_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'next_button_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin'),
                    'condition' => [
                        'listing_type' => 'slider',
                        'next_button' => 'yes'
                    ]
                ]
            );

                $this->add_control(
                    'next_button_color',
                    [
                        'label'     => esc_html__('Next Button Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-next-button' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type' => 'slider',
                            'next_button' => 'yes'
                        ]
                    ]
                );
                $this->add_control(
                    'next_button_bg',
                    [
                        'label'     => esc_html__('Next Button Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-next-button' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type' => 'slider',
                            'next_button' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'next_button_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin'),
                    'condition' => [
                        'listing_type' => 'slider',
                        'next_button' => 'yes'
                    ]
                ]
            );

                $this->add_control(
                    'next_button_color_hover',
                    [
                        'label'     => esc_html__('Next Button Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-next-button:hover' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type' => 'slider',
                            'next_button' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'next_button_bg_hover',
                    [
                        'label'     => esc_html__('Next Button Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-next-button:hover' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type' => 'slider',
                            'next_button' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'next_button_width',
            [
                'label' => esc_html__( 'Next Button Width', 'industrium_plugin' ),
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
                    '{{WRAPPER}} .slider-next-button' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'next_button' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'slider_padding',
            [
                'label' => esc_html__( 'Slider Padding', 'industrium_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .industrium-portfolios-listing-widget.view-type-2 .portfolio-slider-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'listing_type' => 'slider',
                    'view_type' => 'type-2'
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
        $settings       = $this->get_settings();

        $listing_type           = $settings['listing_type'];
        $view_type              = $settings['view_type'];
        $title                  = $settings['title'];
        $title_tag              = $settings['title_tag'];
        $add_subtitle           = $settings['add_subtitle'];
        $subtitle               = $settings['subtitle'];
        $add_button             = $settings['add_button'];
        $post_order_by          = $settings['post_order_by'];
        $post_order             = $settings['post_order'];
        $filter_by              = $settings['filter_by'];
        $categories             = $settings['categories'];
        $portfolios             = $settings['portfolios'];
        $show_filter            = $settings['show_filter'];
        $pagination             = $settings['show_pagination'];
        $paged                  = isset( $_GET[esc_attr($this->get_id()) . '-paged'] ) && $pagination == 'yes' ? (int)$_GET[esc_attr($this->get_id()) . '-paged'] : 1;

        $grid_columns_number    = $settings['grid_columns_number'];
        $grid_posts_per_page    = $settings['grid_posts_per_page'];

        $masonry_columns_number = $settings['masonry_columns_number'];
        $masonry_posts_per_page = $settings['masonry_posts_per_page'];

        $items                  = $settings['items'];
        $nav                    = $settings['nav'];
        $dots                   = $settings['dots'];
        $next_button            = $settings['next_button'];
        $speed                  = $settings['speed'];
        $infinite               = $settings['infinite'];
        $autoplay               = $settings['autoplay'];
        $autoplay_speed         = $settings['autoplay_speed'];
        $autoplay_timeout       = $settings['autoplay_timeout'];
        $pause_on_hover         = $settings['pause_on_hover'];

        $widget_class           = 'industrium-portfolios-listing-widget';
        $wrapper_class          = 'archive-listing-wrapper portfolio-listing-wrapper';
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
            'post_type'             => 'industrium_portfolio',
            'ignore_sticky_posts'   => true,
            'suppress_filters'      => true,
            'orderby'               => sanitize_key($post_order_by),
            'order'                 => sanitize_key($post_order),
            'link_base'             => esc_url($base)
        ];

        if ( $filter_by == 'cat' ) {
            $query_options = array_merge($query_options, [
                'industrium_portfolio_category'  => $categories
            ]);
        } elseif ( $filter_by == 'id' ) {
            $query_options = array_merge($query_options, [
                'post__in'          => $portfolios
            ]);
        };

        if ( $listing_type == 'masonry' ) {
            $widget_class       .= ' isotope' . ( $show_filter == 'yes' && $filter_by == 'cat' ? esc_attr(' isotope-filter') : '' );
            $wrapper_class      .= ' isotope-trigger portfolio-masonry-listing' . ( !empty($masonry_columns_number) ? ' columns-' . esc_attr($masonry_columns_number) : '' );
            $widget_options     = array(
                'item_class'            => 'portfolio-item-wrapper isotope-item',
                'columns_number'        => absint($masonry_columns_number),
                'listing_type'          => 'masonry'
            );
            $widget_attr        .= ( $show_filter == 'yes' && $filter_by == 'cat' ? ' data-columns=' . esc_attr($masonry_columns_number) . ' data-spacings=true' : '');
            $query_options      = array_merge($query_options, [
                'posts_per_page'        => ( !empty($masonry_posts_per_page) ? $masonry_posts_per_page : -1 ),
                'paged'                 => $paged
            ]);
        } elseif ( $listing_type == 'slider' ) {
            $widget_class .= (!empty($view_type) ? ' view-' . $view_type : '');
            $widget_id              = $this->get_id();
            $dots_container = !empty($widget_id) ? '.owl-dots-' . esc_attr($widget_id) : '';
            $slider_options     = [
                'items'                 => !empty($items) ? (int)$items : 1,
                'nav'                   => ('yes' === $nav),
                'dots'                  => ('yes' === $dots),
                'dotsContainer'         => $dots_container,
                'autoplayHoverPause'    => ('yes' === $pause_on_hover),
                'autoplay'              => ('yes' === $autoplay),
                'autoplaySpeed'         => absint($autoplay_speed),
                'autoplayTimeout'       => absint($autoplay_timeout),
                'loop'                  => ('yes' === $infinite),
                'speed'                 => absint($speed),
                'view_type'             => $view_type
            ];
            $widget_options     = array(
                'item_class'            => 'portfolio-item-wrapper slider-item',
                'columns_number'        => absint($items),
                'listing_type'          => 'slider',
                'view_type'             => $view_type
            );
            $query_options      = array_merge($query_options, [
                'posts_per_page'        => -1
            ]);
            $wrapper_attr       = ' data-slider-options=' . esc_attr(wp_json_encode($slider_options));
            $wrapper_class      .= ' owl-carousel owl-theme portfolio-slider-listing';
        } else {
            $wrapper_class      .= ' portfolio-grid-listing' . ( !empty($grid_columns_number) ? ' columns-' . esc_attr($grid_columns_number) : '' );
            $widget_options     = array(
                'item_class'            => 'portfolio-item-wrapper',
                'columns_number'        => absint($grid_columns_number),
                'listing_type'          => 'grid'
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
                if ( $show_filter == 'yes' && $filter_by == 'cat' && $listing_type != 'slider' ) {
                    $terms = array();
                    foreach ($categories as $category) {
                        $current_terms = get_term_by('slug', $category, 'industrium_portfolio_category');
                        $terms[] = $current_terms;
                    }

                    if ( count( $terms ) > 1 ) {

                        echo "<div class='filter-control-wrapper'>";

                        foreach ( $terms as $term ) {
                            $term_name = $term->name;
                            $filter_vals[$term->slug] = $term_name;
                        }
                        if ( $filter_vals > 1 ){
                            echo "<nav class='nav filter-control-list' data-taxonomy='industrium_portfolio_category'>";
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
                        if($add_button == 'yes' || $dots == 'yes') {
                            echo '<span class="pagination_wrapper">';
                                if($add_button == 'yes') { ?>
                                    <a class="industrium-button" href="<?php echo esc_url($button_url); ?>" <?php echo (($button_link['is_external'] == true) ? 'target="_blank"' : ''); echo (($button_link['nofollow'] == 'on') ? 'rel="nofollow"' : ''); ?>><?php echo esc_html($button_text); ?><svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5"></polyline></svg></a>
                                <?php }
                                if ( $dots == 'yes' ) {
                                    echo '<span class="owl-dots' . (!empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '') . '"></span>';
                                }
                            echo '</span>';
                        }
                    echo '</' . esc_html($title_tag) . '>';
                }
            ?>

           <?php 
                if($listing_type == 'slider') {
                    echo '<div class="portfolio-slider-wrapper">';
                }
           ?>
            <div class="archive-listing" data-ajax='<?php echo esc_attr($ajax_data); ?>' data-widget='<?php echo esc_attr($widget_data); ?>'>
                <div class="<?php echo esc_attr($wrapper_class); ?>"<?php echo esc_html($wrapper_attr); ?>>
                    <?php
                        $count = 0;
                        while( $query->have_posts() ){
                            $query->the_post();
                            $count++;
                            if ($count % 2 == 0 ) {
                                $widget_options['item_position'] = 'even';
                            } else {
                                $widget_options['item_position'] = 'odd';
                            }
                            get_template_part('content', 'industrium_portfolio', $widget_options);
                        };
                        if ( $listing_type == 'masonry' ) {
                            echo '<div class="grid-sizer"></div>';
                        }
                        wp_reset_postdata();
                    ?>
                </div>                
                <?php
                    if($listing_type == 'slider' && $next_button == 'yes') {
                        echo '<div class="slider-next-button-wrapper">';
                            echo '<span class="slider-next-button"></span>';
                        echo '</div>';
                    }
                ?>
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
                if($listing_type == 'slider') {
                    echo '</div>';
                }
            ?>
            <?php 
                if ( $listing_type == 'slider' && $dots == 'yes' ) {
                    if(empty($title)) {
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