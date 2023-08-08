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
use Elementor\Group_Control_Image_Size;
use Elementor\REPEATER;
use Elementor\Utils;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Industrium_Blog_Listing_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_blog_listing';
    }

    public function get_title() {
        return esc_html__('Blog Listing', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_categories() {
        return ['industrium_widgets'];
    }

    public function get_script_depends() {
        return ['elementor_widgets', 'wp-mediaelement', 'mediaelement-vimeo'];
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
                'label' => esc_html__('Blog Listing', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'listing_type',
            [
                'label'     => esc_html__('Type', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'classic',
                'options'   => [
                    'classic'   => esc_html__('Classic', 'industrium_plugin'),
                    'grid'      => esc_html__('Grid', 'industrium_plugin')
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
                'max'       => 6,
                'condition' => [
                    'listing_type'  => 'grid'
                ]
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'     => esc_html__('Items Per Page', 'industrium_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 3,
                'min'       => 1
            ]
        );

        $this->add_control(
            'filter_by',
            [
                'label'     => esc_html__('Filter by:', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'none',
                'options'   => [
                    'none'      => esc_html__('None', 'industrium_plugin'),
                    'cat'       => esc_html__('Category', 'industrium_plugin'),
                    'tag'       => esc_html__('Tag', 'industrium_plugin'),
                    'id'        => esc_html__('ID', 'industrium_plugin')
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'category',
            [
                'label'         => esc_html__('Categories', 'industrium_plugin'),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'description'   => esc_html__('List of categories.', 'industrium_plugin'),
                'options'       => industrium_get_all_taxonomy_terms('post', 'category'),
                'condition'     => [
                    'filter_by'     => 'cat'
                ]
            ]
        );

        $this->add_control(
            'tag',
            [
                'label'         => esc_html__('Tags', 'industrium_plugin'),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'description'   => esc_html__('List of tags.', 'industrium_plugin'),
                'options'       => industrium_get_all_taxonomy_terms('post', 'post_tag'),
                'condition'     => [
                    'filter_by'     => 'tag'
                ]
            ]
        );

        $this->add_control(
            'ids',
            [
                'label'         => esc_html__('IDs', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'Enter ID', 'industrium_plugin' ),
                'description'   => esc_html('Comma separated', 'industrium_plugin'),
                'default'       => '',
                'condition'     => [
                    'filter_by'     => 'id'
                ]
            ]
        );

        $this->add_control(
            'post_order_by',
            [
                'label'     => esc_html__('Order By', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'date',
                'options'   => [
                    'date'      => esc_html__('Post Date', 'industrium_plugin'),
                    'rand'      => esc_html__('Random', 'industrium_plugin'),
                    'ID'        => esc_html__('Post ID', 'industrium_plugin'),
                    'title'     => esc_html__('Post Title', 'industrium_plugin')
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'post_order',
            [
                'label'     => esc_html__('Order', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'desc',
                'options'   => [
                    'desc'      => esc_html__('Descending', 'industrium_plugin'),
                    'asc'       => esc_html__('Ascending', 'industrium_plugin')
                ]
            ]
        );

        $this->add_control(
            'show_cat',
            [
                'label'         => esc_html__('Categories', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin'),
                'default'       => 'yes',
                'separator'     => 'before',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'show_media',
            [
                'label'         => esc_html__('Media', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label'         => esc_html__('Author', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label'         => esc_html__('Date', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'show_tags',
            [
                'label'         => esc_html__('Tags', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin'),
                'default'       => 'no',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'         => esc_html__('Title', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes'
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
                'label'     => esc_html__('Excerpt Length, in simbols', 'industrium_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 0,
                'default'   => 190,
                'condition' => [
                    'show_excerpt' => 'yes'
                ]
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
                'return_value'  => 'yes'
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
            'pagination',
            [
                'label'         => esc_html__('Pagination', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin'),
                'default'       => 'yes',
                'separator'     => 'before',
                'return_value'  => 'yes'
            ]
        );

        $this->end_controls_section();


        // -------------------------------------- //
        // ---------- General Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'general_settings_section',
            [
                'label' => esc_html__('General Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE,
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
                    'size'      => 40
                ],
                'selectors' => [
                    '{{WRAPPER}} .archive-listing-wrapper.grid-listing' =>
                        'margin-left: calc(-{{SIZE}}{{UNIT}}/2); margin-right: calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .grid-listing .grid-item' => 'padding: 0 calc({{SIZE}}{{UNIT}}/2);',
                ],
                'condition' => [    
                    'listing_type' => 'grid'
                ]
            ]
        );

        $this->start_controls_tabs('general_colors_tabs');

            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_general_colors_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'post_bg_color',
                    [
                        'label'     => esc_html__('Item Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .blog-item' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'post_shadow',
                        'label'     => esc_html__('Item Shadow', 'industrium_plugin'),
                        'selector'  => '{{WRAPPER}} .blog-item'
                    ]
                );

                $this->add_group_control(
                    Group_Control_Css_Filter::get_type(),
                    [
                        'name' => 'css_filters',
                        'selector' => '{{WRAPPER}} .blog-item .post-media-wrapper img',
                    ]
                );

            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_general_colors_active',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'post_bg_hover',
                    [
                        'label'     => esc_html__('Item Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .blog-item:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'post_hover_shadow',
                        'label'     => esc_html__('Item Shadow', 'industrium_plugin'),
                        'selector'  => '{{WRAPPER}} .blog-item:hover'
                    ]
                );

                $this->add_group_control(
                    Group_Control_Css_Filter::get_type(),
                    [
                        'name' => 'css_filters_hover',
                        'selector' => '{{WRAPPER}} .blog-item:hover .post-media-wrapper img',
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
                'label'         => esc_html__('Content Settings', 'industrium_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'conditions'    => [
                    'relation'      => 'or',
                    'terms'         => [
                        [
                            'name'      => 'show_author',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ],
                        [
                            'name'      => 'show_date',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ],
                        [
                            'name'      => 'show_tags',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ],
                        [
                            'name'      => 'show_title',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ],
                        [
                            'name'      => 'show_excerpt',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ],
                        [
                            'name'      => 'show_read_more',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ]
                    ]
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Title Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .blog-item .post-title',
                'condition' => [
                    'show_title'    => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('content_title_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_title_normal',
                [
                    'label'     => esc_html__('Normal', 'industrium_plugin'),
                    'condition' => [
                        'show_title'    => 'yes'
                    ]
                ]
            );
                $this->add_control(
                    'title_color_normal',
                    [
                        'label'     => esc_html__('Title Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .blog-item .post-title, {{WRAPPER}} .blog-item .post-title a' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after',
                        'condition' => [
                            'show_title'    => 'yes'
                        ]
                    ]
                );
            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_title_hover',
                [
                    'label'     => esc_html__('Hover', 'industrium_plugin'),
                    'condition' => [
                        'show_title'    => 'yes'
                    ]
                ]
            );
                $this->add_control(
                    'title_color_hover',
                    [
                        'label'     => esc_html__('Title Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .blog-item .post-title a:hover' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'show_title'    => 'yes'
                        ]
                    ]
                );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'excerpt_typography',
                'label'     => esc_html__('Excerpt Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .post-content',
                'condition' => [
                    'show_excerpt' => 'yes'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'     => esc_html__('Excerpt Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-content' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'show_excerpt' => 'yes'
                ],
                'separator'     => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'meta_typography_day',
                'label'         => esc_html__('Meta Day Typography', 'industrium_plugin'),
                'selector'      => '{{WRAPPER}} .post-meta-header .post-meta-item-day',
                'condition'     => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'meta_typography_month_year',
                'label'         => esc_html__('Meta Month and Year Typography', 'industrium_plugin'),
                'selector'      => '{{WRAPPER}} .post-meta-header .post-meta-item-month-year',
                'condition'     => [
                    'show_date' => 'yes'
                ],
                'separator'     => 'after'
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'meta_typography_author',
                'label'         => esc_html__('Meta Author Typography', 'industrium_plugin'),
                'selector'      => '{{WRAPPER}} .post-meta-header .post-meta-item-author',
                'condition'     => [
                    'show_author' => 'yes'
                ],
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'meta_color_day',
            [
                'label'     => esc_html__('Day Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-meta-header .post-meta-item-day' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'meta_color_month_year',
            [
                'label'     => esc_html__('Month and Year Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-meta-header .post-meta-item-month-year' => 'color: {{VALUE}};'
                ],
                'separator' => 'after',
                'condition' => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'day_bg_color',
            [
                'label'     => esc_html__('Day Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-meta-header .post-meta-item-day' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'month_year_bg_color',
            [
                'label'     => esc_html__('Month and Year Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-meta-header .post-meta-item-month-year' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'show_date' => 'yes'
                ],
                'separator' => 'after'
            ]
        );

        $this->start_controls_tabs('content_meta_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_meta_normal',
                [
                    'label'         => esc_html__('Normal', 'industrium_plugin'),
                    'condition'    => [
                       'show_author' => 'yes'
                    ]
                ]
            );
                $this->add_control(
                    'meta_color_author_normal',
                    [
                        'label'     => esc_html__('Author Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-meta-header .post-meta-item-author, {{WRAPPER}} .post-meta-header .post-meta-item-author a' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after',
                        'condition' => [
                            'show_author' => 'yes'
                        ]
                    ]
                );
            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_meta_hover',
                [
                    'label'         => esc_html__('Hover', 'industrium_plugin'), 
                    'condition' => [
                        'show_author' => 'yes'
                    ]
                ]
            );
                $this->add_control(
                    'meta_color_author_hover',
                    [
                        'label'     => esc_html__('Author Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-meta-header .post-meta-item-author a:hover' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after',
                        'condition' => [
                            'show_author' => 'yes'
                        ]
                    ]
                );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'more_typography',
                'label'     => esc_html__('More Button Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .post-more-button a',
                'condition' => [
                    'show_read_more' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'more_color',
            [
                'label'     => esc_html__('More Button Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-more-button a' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'show_read_more' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'more_border_color',
            [
                'label'     => esc_html__('More Button Border Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-more-button a:after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .post-more-button a'  => 'background-image: linear-gradient(0deg, {{VALUE}} 0%, {{VALUE}} 100%);',
                    '{{WRAPPER}} .post-more-button a svg'   => 'stroke: {{VALUE}};'
                ],
                'condition' => [
                    'show_read_more' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'tags_typography',
                'label'     => esc_html__('Tags Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .post-meta-item-tags',
                'condition' => [
                    'show_tags' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('content_tags_tabs');

            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_tags_normal',
                [
                    'label'     => esc_html__('Normal', 'industrium_plugin'),
                    'condition' => [
                        'show_tags' => 'yes'
                    ]
                ]
            );

                $this->add_control(
                    'tags_color_normal',
                    [
                        'label'     => esc_html__('Tags Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'condition' => [
                            'show_tags' => 'yes'
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .post-meta-item-tags, {{WRAPPER}} .post-meta-item-tags a' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_tags_hover',
                [
                    'label'     => esc_html__('Hover', 'industrium_plugin'),
                    'condition' => [
                        'show_tags' => 'yes'
                    ]
                ]
            );

                $this->add_control(
                    'tags_color_hover',
                    [
                        'label'     => esc_html__('Meta Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-meta-item-tags a:hover' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'show_tags' => 'yes'
                        ]
                    ]
                );
            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'date_item_day_padding',
            [
                'label' => esc_html__( 'Day Padding', 'industrium_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .post-meta-header .post-meta-item .post-meta-item-day' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'date_item_width',
            [
                'label' => esc_html__( 'Date Width', 'industrium_plugin' ),
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
                    '{{WRAPPER}} .post-meta-header .post-meta-item-date' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'date_item_margin',
            [
                'label' => esc_html__( 'Date Margin', 'industrium_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .post-meta-header:not(:first-child) .post-meta-item-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
                    'pagination' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'pagination_typography',
                'label'     => esc_html__('Pagination Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .content-pagination .page-numbers, {{WRAPPER}} .content-pagination .post-page-numbers',
                'separator' => 'before'
            ]
        );

        $this->start_controls_tabs('pagination_tags_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_pagination_normal',
                [
                    'label'     => esc_html__('Normal', 'industrium_plugin'),
                    'condition' => [
                        'pagination' => 'yes'
                    ]
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
                    'label'     => esc_html__('Active', 'industrium_plugin'),
                    'condition' => [
                        'pagination' => 'yes'
                    ]
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


        // ----------------------------------------- //
        // ---------- Categories Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'categories_settings_section',
            [
                'label'     => esc_html__('Categories Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_cat'  => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cat_typography',
                'label'     => esc_html__('Categories Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .post-categories .post-category-item',
                'separator' => 'before'
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
                            '{{WRAPPER}} .post-categories .post-category-item, {{WRAPPER}} .sticky .blog-item:after, {{WRAPPER}} .status-sticky .blog-item:after' => 'color: {{VALUE}};'
                        ]
                    ]
                );
                $this->add_control(
                    'cat_bg_normal',
                    [
                        'label'     => esc_html__('Categories Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-categories .post-category-item, {{WRAPPER}} .sticky .blog-item:after, {{WRAPPER}} .status-sticky .blog-item:after' => 'background-color: {{VALUE}};'
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
                            '{{WRAPPER}} .post-categories .post-category-item:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );
                $this->add_control(
                    'cat_bg_hover',
                    [
                        'label'     => esc_html__('Categories Background Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-categories .post-category-item:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings               = $this->get_settings();

        $listing_type           = $settings['listing_type'];
        $columns_number         = ($listing_type == 'grid' && !empty($settings['columns_number']) ) ? (int)$settings['columns_number'] : 1;
        $posts_per_page         = (int)$settings['posts_per_page'];
        $post_order_by          = $settings['post_order_by'];
        $post_order             = $settings['post_order'];
        $pagination             = $settings['pagination'];
        $filter_by              = $settings['filter_by'];
        $category_filter        = !empty($settings['category']) && $filter_by == 'cat' ? implode(',', $settings['category']) : '';
        $tag_filter             = !empty($settings['tag']) && $filter_by == 'tag' ? implode(',', $settings['tag']) : '';
        $id_filter              = !empty($settings['ids']) && $filter_by == 'id' ? explode(',', str_replace(' ', '', $settings['ids'])) : '';

        global $wp;
        $base = home_url($wp->request);

        $ignore_sticky_posts    = !empty($settings['ids']) && $filter_by == 'id' ? true : false;

        $wrapper_class          = 'archive-listing-wrapper' . ($listing_type == 'grid' && !empty($columns_number) ? ' grid-listing columns-' . esc_attr($columns_number) : '');

        $widget_params          = array(
            'excerpt_length'        => $settings['excerpt_length'],
            'show_cat'              => $settings['show_cat'],
            'show_media'            => $settings['show_media'],
            'show_author'           => $settings['show_author'],
            'show_date'             => $settings['show_date'],
            'show_title'            => $settings['show_title'],
            'show_tags'             => $settings['show_tags'],
            'show_excerpt'          => $settings['show_excerpt'],
            'show_read_more'        => $settings['show_read_more'],
            'read_more_text'        => $settings['read_more_text'],
            'item_class'            => 'post' . ( $listing_type == 'grid' ? ' grid-item grid-blog-item-wrapper' : ' standard-blog-item-wrapper' ),
            'columns_number'        => $columns_number,
            'listing_type'          => $listing_type
        );
        $paged  = isset( $_GET[esc_attr($this->get_id()) . '-paged'] ) && $pagination == 'yes' ? (int)$_GET[esc_attr($this->get_id()) . '-paged'] : 1;

        $args   = array(
            'post_type'             => 'post',
            'posts_per_page'        => $posts_per_page,
            'orderby'               => $post_order_by,
            'order'                 => $post_order,
            'paged'                 => $paged,
            'category_name'         => $category_filter,
            'tag'                   => $tag_filter,
            'post__in'              => $id_filter,
            'ignore_sticky_posts'   => $ignore_sticky_posts,
            'link_base'             => esc_url($base)
        );

        $query = new \WP_Query($args);
        $ajax_data = wp_json_encode($args);
        $widget_data = wp_json_encode($widget_params);

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="archive-listing" data-ajax='<?php echo esc_attr($ajax_data); ?>' data-widget='<?php echo esc_attr($widget_data); ?>'>
            <div class="<?php echo esc_attr($wrapper_class); ?>">
                <?php
                    while( $query->have_posts() ){
                        $query->the_post();
                        get_template_part('content', null, $widget_params);
                    }
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
        wp_reset_query();
    }

    protected function content_template() {}

    public function render_plain_content() {}
}