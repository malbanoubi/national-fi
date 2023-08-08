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

class Industrium_Products_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_products';
    }

    public function get_title() {
        return esc_html__('Products', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-products';
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
            'section_display_product',
            [
                'label' => esc_html__('Display Product', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'view_style',
            [
                'label'   => esc_html__('View Style', 'industrium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'standard',
                'options' => [
                    'standard' => esc_html__('Standard', 'industrium_plugin'),
                    'compact'  => esc_html__('Compact', 'industrium_plugin')
                ]
            ]
        );

        $this->add_control(
            'products_type',
            [
                'label'   => esc_html__('Products Type', 'industrium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'all',
                'options' => [
                    'all'           => esc_html__('All', 'industrium_plugin'),
                    'on_sale'       => esc_html__('On sale products', 'industrium_plugin'),
                    'best_selling'  => esc_html__('The best selling products', 'industrium_plugin'),
                    'top_rated'     => esc_html__('Top-rated products', 'industrium_plugin')
                ]
            ]
        );

        $this->add_control(
            'limit',
            [
                'label'         => esc_html__('Limit', 'industrium_plugin'),
                'description'   => esc_html__('The number of products to display', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'min'           => -1,
                'max'           => 50,
                'default'       => 4
            ]
        );

        $this->add_control(
            'columns',
            [
                'label'         => esc_html__('Columns', 'industrium_plugin'),
                'description'   => esc_html__('The number of columns to display.', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'min'           => 1,
                'max'           => 6,
                'default'       => 4
            ]
        );

        $this->add_control(
            'paginate',
            [
                'label'         => esc_html__('Show Pagination', 'industrium_plugin'),
                'description'   => esc_html__('Toggles pagination on. Use in conjunction with "limit"', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'no',
                'label_off'     => esc_html__('Hide', 'industrium_plugin'),
                'label_on'      => esc_html__('Show', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => esc_html__('Orderby', 'industrium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'description' => esc_html__('Sorts the products displayed by the entered option.', 'industrium_plugin'),
                'default' => 'date',
                'options' => [
                    'date'        => esc_html__('Date', 'industrium_plugin'),
                    'id'          => esc_html__('ID', 'industrium_plugin'),
                    'menu_order'  => esc_html__('Menu order', 'industrium_plugin'),
                    'popularity'  => esc_html__('Popularity', 'industrium_plugin'),
                    'rand'        => esc_html__('Random', 'industrium_plugin'),
                    'rating'      => esc_html__('Rating', 'industrium_plugin'),
                    'title'       => esc_html__('Title', 'industrium_plugin')
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => esc_html__('Order', 'industrium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => [
                    'ASC'        => esc_html__('ASC', 'industrium_plugin'),
                    'DESC'       => esc_html__('DESC', 'industrium_plugin')
                ]
            ]
        );

        $cat_args = array(
            'orderby'    => 'name',
            'order'      => 'asc',
            'hide_empty' => false,
        );
        $product_categories = get_terms( 'product_cat', $cat_args );
        $category_arr = [];
        if( !empty($product_categories) ){
            foreach ($product_categories as $key => $category) {
                $category_arr[$category->slug] = $category->name;
            }
        }
        $this->add_control(
            'category',
            [
                'label'         => esc_html__('Categories', 'industrium_plugin'),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'description'   => esc_html__('List of categories.', 'industrium_plugin'),
                'options'       => $category_arr
            ]
        );

        $this->add_control(
            'skus',
            [
                'label'         => esc_html__('SKUs', 'industrium_plugin'),
                'label_block'   => true,
                'description'   => esc_html__('Comma-separated list of product SKUs.', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'placeholder'   => esc_html__( 'Enter SKU list', 'industrium_plugin' )
            ]
        );

        $this->add_control(
            'tag',
            [
                'label'         => esc_html__('Tags', 'industrium_plugin'),
                'label_block'   => true,
                'description'   => esc_html__('Comma-separated list of tag slugs.', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'placeholder'   => esc_html__( 'Enter tags list', 'industrium_plugin' )
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Item Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_item_settings',
            [
                'label' => esc_html__('Product Item Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('item_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_item_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'product_shadow',
                        'label'     => esc_html__('Item Shadow', 'industrium_plugin'),
                        'selector'  => '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper'
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_item_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'product_shadow_hover',
                        'label'     => esc_html__('Item Shadow', 'industrium_plugin'),
                        'selector'  => '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper:hover'
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();



        // -------------------------------------- //
        // ---------- Content Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_content_settings',
            [
                'label' => esc_html__('Product Content Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Title Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .woocommerce-loop-product-title, {{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper h3'
            ]
        );

        $this->start_controls_tabs('title_settings_tabs' );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_title_normal',
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
                        '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .woocommerce-loop-product-title, {{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper h3, {{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .woocommerce-loop-product-title a, {{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper h3 a' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'border_color',
                [
                    'label'     => esc_html__('Border Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper' => 'border-color: {{VALUE}};'
                    ],
                    'separator' => 'after'
                ]
            );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_title_hover',
                [
                    'label' => esc_html__('Hover', 'industrium_plugin')
                ]
            );

            $this->add_control(
                'title_hover',
                [
                    'label'     => esc_html__('Title Hover', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .woocommerce-loop-product-title a:hover, {{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper h3 a:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'border_color_hover',
                [
                    'label'     => esc_html__('Border Hover', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper:hover' => 'border-color: {{VALUE}};'
                    ],
                    'separator' => 'after'
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'price_typography',
                'label'     => esc_html__('Price Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .product-info-wrapper .price',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'sale_color',
            [
                'label'     => esc_html__('Sale Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .attachment-woocommerce_flash .flash-item.sale' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'sale_bg_color',
            [
                'label'     => esc_html__('Sale Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .attachment-woocommerce_flash .flash-item.sale' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'current_price_color',
            [
                'label'     => esc_html__('Current Price Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .price' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'old_price_color',
            [
                'label'     => esc_html__('Old Price Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .price del' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'rating_default_color',
            [
                'label'     => esc_html__('Rating Inactive Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .star-rating:before' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'rating_active_color',
            [
                'label'     => esc_html__('Rating Active Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .star-rating span' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();



        // ------------------------------------- //
        // ---------- Button Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'section_button_settings',
            [
                'label' => esc_html__('Product Button Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'label'     => esc_html__('Button Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .product-buttons-wrapper a.button, {{WRAPPER}} .product-buttons-wrapper a.added_to_cart'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'button_bg',
                'label'     => esc_html__( 'Button Background', 'industrium_plugin' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .product-buttons-wrapper a.button:after, {{WRAPPER}} .product-buttons-wrapper a.added_to_cart:after'
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
                        'label'     => esc_html__('Button Text Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .product-buttons-wrapper a.button, {{WRAPPER}} .product-buttons-wrapper a.added_to_cart' => 'color: {{VALUE}};'
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
                    'button_hover_color',
                    [
                        'label'     => esc_html__('Button Text Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .product-buttons-wrapper a.button:hover, {{WRAPPER}} .product-buttons-wrapper a.added_to_cart:hover' => 'color: {{VALUE}};'
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
                    'paginate'   => 'yes'
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

        $products_type = $settings['products_type'];
        $view_style     = $settings['view_style'];

        $limit      = $settings['limit'];
        $columns    = $settings['columns'];
        $paginate   = $settings['paginate'] == 'yes' ? true : false;
        $orderby    = $settings['orderby'];
        $order      = $settings['order'];
        $category   = (!empty($settings['category']) ? implode(',', $settings['category']) : '');
        $skus       = $settings['skus'];
        $tag        = $settings['tag'];

        $classes    = (!empty($view_style) ? ' view-type-' . esc_attr($view_style) : '');

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>
        <div class="woocommerce products-widget<?php echo esc_attr($classes); ?>">
            <?php
                $atts = array(
                    'limit'          => $limit,
                    'columns'        => $columns,
                    'orderby'        => $orderby,
                    'order'          => $order,
                    'skus'           => $skus,
                    'category'       => $category,
                    'tag'            => $tag,
                    'visibility'     => 'visible',
                    'class'          => 'industrium_shop_loop',
                    'page'           => 1,
                    'paginate'       => $paginate,
                    'no_found_rows'  => false === $paginate
                );

                $type = 'products';
                if ( $products_type == 'on_sale' ) {
                    $atts['on_sale'] = 'true';
                    $type = 'sale_products';
                } elseif ( $products_type == 'best_selling' ) {
                    $atts['best_selling'] = 'true';
                    $type = 'best_selling_products';
                } elseif ( $products_type == 'top_rated' ) {
                    $atts['top_rated'] = 'true';
                    $type = 'top_rated_products';
                }

                if ( $paginate == false ) {
                    do_action( 'woocommerce_before_shop_loop' );
                }

                $shortcode = new \WC_Shortcode_Products( $atts, $type );
                echo $shortcode->get_content();

                if ( $paginate == false ) {
                    do_action( 'woocommerce_after_shop_loop' );
                }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
