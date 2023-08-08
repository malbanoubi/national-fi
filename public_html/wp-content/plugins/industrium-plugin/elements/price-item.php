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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Industrium_Price_Item_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_price_item';
    }

    public function get_title() {
        return esc_html__('Price Item', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-price-table';
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
                'label' => esc_html__('Price Item', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'block_type',
            [
                'label'     => esc_html__('Price Item Type', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'standard',
                'options'   => [
                    'standard'  => esc_html__('Standard', 'industrium_plugin'),
                    'wide'      => esc_html__('Wide', 'industrium_plugin')
                ]
            ]
        );

        $this->add_control(
            'active_block_status',
            [
                'label'         => esc_html__('Highlight this block?', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'no'
            ]
        );

        $this->add_control(
            'best_choice_text',
            [
                'label'     => esc_html__('Best Choice Text', 'industrium_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('Best Choice', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'title',
            [
                'label'     => esc_html__('Title', 'industrium_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => ''
            ]
        );

        $this->add_control(
            'image',
            [
                'label'     => esc_html__('Image', 'industrium_plugin'),
                'type'      => Controls_Manager::MEDIA,
                'condition' => [
                    'block_type' => 'standard'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail',
                'exclude'   => ['1536x1536', '2048x2048', 'post-thumbnail', 'industrium_post_thumbnail_mobile', 'industrium_post_thumbnail_tablet', 'industrium_post_thumbnail_default', 'industrium_post_thumbnail_full', 'industrium_post_grid_2_columns', 'industrium_post_grid_3_columns', 'industrium_post_grid_4_columns', 'industrium_post_grid_5_columns', 'industrium_post_grid_6_columns', 'industrium_portfolio_thumbnail', 'industrium_portfolio_grid_1_columns', 'industrium_portfolio_grid_2_columns', 'industrium_portfolio_grid_3_columns', 'industrium_portfolio_grid_4_columns', 'industrium_portfolio_grid_5_columns', 'industrium_portfolio_grid_6_columns', 'industrium_team_thumbnail', 'woocommerce_thumbnail', 'woocommerce_single', 'woocommerce_gallery_thumbnail'],
                'default'   => 'full',
                'condition' => [
                    'block_type' => 'standard'
                ]
            ]
        );

        $this->add_control(
            'currency',
            [
                'label'         => esc_html__('Currency', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => '$',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'currency_position',
            [
                'label'     => esc_html__('Currency Position', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'before',
                'options'   => [
                    'before'    => esc_html__('Before Price', 'industrium_plugin'),
                    'after'     => esc_html__('After Price', 'industrium_plugin')
                ]
            ]
        );

        $this->add_control(
            'price',
            [
                'label'     => esc_html__('Price', 'industrium_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => ''
            ]
        );

        $this->add_control(
            'period',
            [
                'label'         => esc_html__('Period', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__('month', 'industrium_plugin')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text',
            [
                'label'         => esc_html__( 'Text', 'industrium_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => '',
                'placeholder'   => esc_html__( 'Enter Text', 'industrium_plugin' ),
            ]
        );

        $repeater->add_control(
            'is_active',
            [
                'label'         => esc_html__('Highlight this field', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'return_value'  => 'yes',
                'default'       => 'no'
            ]
        );

        $this->add_control(
            'custom_fields',
            [
                'label'         => esc_html__('Custom Fields', 'industrium_plugin'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'prevent_empty' => false,
                'separator'     => 'before',
                'default'       => [
                    [
                        'text'      => '',
                        'is_active' => 'no'
                    ]
                ]
            ]
        );

        $this->add_control(
            'price_button_text',
            [
                'label'         => esc_html__('Button Text', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Get Started', 'industrium_plugin'),
                'placeholder'   => esc_html__('Button Text', 'industrium_plugin'),
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label'         => esc_html__('Button Link', 'industrium_plugin'),
                'type'          => Controls_Manager::URL,
                'placeholder'   => esc_url('http://your-link.com'),
                'default'       => [
                    'url'   => '',
                ]
            ]
        );

        $this->end_controls_section();

        // ----------------------------------------- //
        // ---------- Price Item Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Price Item Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label'     => esc_html__( 'Item Background Color', 'industrium_plugin' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .price-item .price-wrapper' => 'color:  {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label'     => esc_html__('Item Border Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item' => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'item_shadow',
                'label'     => esc_html__('Item Shadow', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .price-item',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'         => esc_html__('Item Padding', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .price-item.price-item-type-standard .price-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .price-item.price-item-type-wide .price-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        // ----------------------------------------- //
        // ---------- Best Choice Settings --------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'section_best_choice_settings',
            [
                'label' => esc_html__('Best Choice Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'best_choice_typography',
                'label'     => esc_html__('Best Choice Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .price-item-best-label'
            ]
        );

        $this->add_control(
            'best_choice_color',
            [
                'label'     => esc_html__('Best Choice Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-best-label' => 'color: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'best_choice_bg_color',
            [
                'label'     => esc_html__('Best Choice Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-best-label' => 'background-color: {{VALUE}};'
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
                'label' => esc_html__('Title Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Title Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .price-item-title'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Title Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'title_bg_color',
            [
                'label'     => esc_html__('Title Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item.price-item-type-standard .price-item-title' => 'background-color: {{VALUE}};'
                ],
                'separator' => 'after',
                'condition' => [
                    'block_type'    => 'standard'
                ]
            ]
        );

        $this->add_control(
            'title_margin',
            [
                'label'     => esc_html__('Space After Title', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .price-item-title-wrapper:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'block_type'    => 'standard'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Image Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_image_settings',
            [
                'label'     => esc_html__('Image Settings', 'industrium_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type'    => 'standard'
                ]
            ]
        );

        $this->add_control(
            'image_margin',
            [
                'label'     => esc_html__('Space After Image', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .price-item-image:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'block_type'    => 'standard'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------------ //
        // ---------- Price Block Settings ---------- //
        // ------------------------------------------ //
        $this->start_controls_section(
            'section_price_settings',
            [
                'label' => esc_html__('Price Block Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'price_typography',
                'label'     => esc_html__('Price Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .price-item .price-wrapper .price'
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__('Price Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-wrapper .price' => 'text-shadow: 1px 1px 0 {{VALUE}}, -1px -1px 0 {{VALUE}}, 1px -1px 0 {{VALUE}}, -1px 1px 0 {{VALUE}}, 1px 1px 0 {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'currency_typography',
                'label'     => esc_html__('Currency Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .price-item .price-wrapper .currency'
            ]
        );

        $this->add_control(
            'currency_color',
            [
                'label'     => esc_html__('Currency Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-wrapper .currency' => 'text-shadow: 1px 1px 0 {{VALUE}}, -1px -1px 0 {{VALUE}}, 1px -1px 0 {{VALUE}}, -1px 1px 0 {{VALUE}}, 1px 1px 0 {{VALUE}}'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'period_typography',
                'label'     => esc_html__('Period Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .price-item .price-item-period'
            ]
        );

        $this->add_control(
            'period_color',
            [
                'label'     => esc_html__('Period Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-period' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'price_margin',
            [
                'label'     => esc_html__('Space After Price', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .price-item-container:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'block_type'    => 'standard'
                ]
            ]
        );

        $this->end_controls_section();

        // -------------------------------------- //
        // ---------- Content Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_content_settings',
            [
                'label' => esc_html__('Content Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label'     => esc_html__('Separator Line Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-custom-fields' => 'border-color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'fields_margin',
            [
                'label'     => esc_html__('Space Between Fields', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 20
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-custom-field:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'fields_typography',
                'label'     => esc_html__('Custom Fields Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .price-item .price-item-custom-field',
                'separator' => 'after'
            ]
        );

        $this->start_controls_tabs(
            'fields_settings_tabs'
        );

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
                    'fields_color',
                    [
                        'label'     => esc_html__('Custom Fields Text Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .price-item .price-item-custom-field:not(.active)' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'fields_icon_color',
                    [
                        'label'     => esc_html__('Custom Fields Icon Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .price-item .price-item-custom-field:not(.active):before' => 'color: {{VALUE}};'
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
                    'active_fields_color',
                    [
                        'label'     => esc_html__('Custom Fields Text Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .price-item .price-item-custom-field.active' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'active_fields_icon_color',
                    [
                        'label'     => esc_html__('Custom Fields Icon Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .price-item .price-item-custom-field.active:before' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // ------------------------------------- //
        // ---------- Button Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'section_button_settings',
            [
                'label' => esc_html__('Button Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'label'     => esc_html__('Button Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .price-item-button-container .industrium-button'
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
                            '{{WRAPPER}} .price-item-button-container .industrium-button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name'      => 'button_bg',
                        'label'     => esc_html__( 'Button Background', 'industrium_plugin' ),
                        'types'     => [ 'classic', 'gradient' ],
                        'selector'  => '{{WRAPPER}} .price-item-button-container .industrium-button'
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
                            '{{WRAPPER}} .price-item-button-container .industrium-button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name'      => 'button_bg_hover',
                        'label'     => esc_html__( 'Button Background', 'industrium_plugin' ),
                        'types'     => [ 'classic', 'gradient' ],
                        'selector'  => '{{WRAPPER}} .price-item-button-container .industrium-button:hover'
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'button_padding',
            [
                'label'         => esc_html__('Button Padding', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .price-item-button-container .industrium-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings               = $this->get_settings();

        $block_type             = $settings['block_type'];
        $title                  = $settings['title'];
        $image                  = $settings['image'];
        $active_block_status    = $settings['active_block_status'];
        $best_choice_text       = $settings['best_choice_text'];
        $currency               = $settings['currency'];
        $currency_position      = $settings['currency_position'];
        $price                  = $settings['price'];
        $period                 = $settings['period'];
        $custom_fields          = $settings['custom_fields'];
        $price_button_text      = $settings['price_button_text'];
        $button_link            = $settings['button_link'];
        $button_url             = $button_link['url'];

        if ( !empty($price_button_text) && empty($button_url) ) {
            $button_url         = '#';
        }

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="industrium-price-item-widget">
            <div class="price-item<?php echo ($active_block_status == 'yes' ? ' active' : '') . ' price-item-type-' . esc_attr($block_type); ?>">
                <?php
                    if($best_choice_text !== '') {
                    	if($block_type == 'wide') {
                    		echo '<div class="price-item-best-wrapper">';
                    	}
                        echo '<div class="price-item-best-label">';
                            echo esc_html($best_choice_text);
                        echo '</div>';
                        if($block_type == 'wide') {
                    		echo '</div>';
                    	}
                    }
                ?>
                <div class="price-item-inner">

                    <?php   

                    if ( !empty($image) && $image['id'] !== '') {
                        echo '<div class="price-item-image">';
                            echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );
                        echo '</div>';
                    }

                    if($block_type == 'wide') { ?>
                    	<div class="price-item-title-price-wrapper">
                    <?php }
                    if ( isset($price) ) {
                        ?>
                        <div class="price-item-container price-item-currency-position-<?php echo esc_attr($currency_position); ?>">
                            <div class="price-wrapper">
                                <?php
                                if ( !empty($currency) && $currency_position == 'before' ) {
                                    echo '<span class="currency">' . esc_html($currency) . '</span>';
                                }

                                echo '<span class="price">' . esc_html($price) . '</span>';

                                if ( !empty($currency) && $currency_position == 'after' ) {
                                    echo '<span class="currency">' . esc_html($currency) . '</span>';
                                }
                                ?>
                            </div>

                            <?php
                            if ( !empty($period) ) {
                                echo '<div class="price-item-period">' . esc_html($period) . '</div>';
                            }
                            ?>
                        </div>
                        <?php
                    }

                    if ($title !== '') {
                        echo '<div class="price-item-title-wrapper">';
                            echo '<div class="price-item-title">' . esc_html($title) . '</div>';
                        echo '</div>';
                    }
                    if($block_type == 'wide') { ?>
                    	</div>
                    <?php }

                    if ( !empty($custom_fields) ) {
                        ?>
                        <div class="price-item-custom-fields">
                            <?php
                            foreach ($custom_fields as $field) {
                                $field_status_class = $field['is_active'] == 'yes' ? ' active' : '';
                                if ( !empty($field['text']) ) { ?>
                                    <div class="price-item-custom-field <?php echo esc_attr($field_status_class); ?>"><?php echo esc_html($field['text']); ?></div>
                                <?php }
                            }
                            ?>
                        </div>
                        <?php
                    }
                    if ( $block_type == 'wide' && !empty($price_button_text) ) { ?>
                    	<div class="price-item-button-container">
                            <a class="industrium-button" href="<?php echo esc_url($button_url); ?>" <?php echo (($button_link['is_external'] == true) ? 'target="_blank"' : ''); echo (($button_link['nofollow'] == 'on') ? 'rel="nofollow"' : ''); ?>><?php echo esc_html($price_button_text); ?></a>
                        </div>
                    <?php }
                    ?>                    
                </div>
                <?php
                    if ( $block_type == 'standard' && !empty($price_button_text) ) { ?>
                        <div class="price-item-button-container">
                            <a class="industrium-button" href="<?php echo esc_url($button_url); ?>" <?php echo (($button_link['is_external'] == true) ? 'target="_blank"' : ''); echo (($button_link['nofollow'] == 'on') ? 'rel="nofollow"' : ''); ?>><?php echo esc_html($price_button_text); ?></a>
                        </div>
                    <?php }
                ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}