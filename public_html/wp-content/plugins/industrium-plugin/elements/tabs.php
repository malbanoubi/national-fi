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

class Industrium_Tabs_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_tabs';
    }

    public function get_title() {
        return esc_html__('Tabs', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_categories() {
        return ['industrium_widgets'];
    }

    public function get_script_depends() {
        return ['tabs_widget'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Tabs', 'industrium_plugin')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label'         => esc_html__('Tab Title', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Tab', 'industrium_plugin'),
                'placeholder'   => esc_html__('Enter Tab Title', 'industrium_plugin')
            ]
        );

        $repeater->add_control(
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

        $repeater->add_control(
            'default_icon',
            [
                'label'                     => esc_html__('Icon', 'industrium_plugin'),
                'type'                      => Controls_Manager::ICONS,
                'label_block'               => false,
                'default'                   => [],
                'skin'                      => 'inline',
                'exclude_inline_options'    => ['svg'],
                'condition'                 => [
                    'icon_type' => 'default'
                ]
            ]
        );

        $repeater->add_control(
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

        $repeater->add_control(
            'text',
            [
                'label' => esc_html__('Tab Content', 'industrium_plugin'),
                'type'  => Controls_Manager::WYSIWYG
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label'         => esc_html__('Tabs', 'industrium_plugin'),
                'type'          => Controls_Manager::REPEATER,
                'default'       => [],
                'fields'        => $repeater->get_controls(),
                'title_field'   => '{{{title}}}',
                'prevent_empty' => false
            ]
        );

        $this->add_responsive_control(
            'tabs_align',
            [
                'label'     => esc_html__('Heading Alignment', 'industrium_plugin'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start'      => [
                        'title'     => esc_html__('Left', 'industrium_plugin'),
                        'icon'      => 'eicon-text-align-left',
                    ],
                    'center'    => [
                        'title'     => esc_html__('Center', 'industrium_plugin'),
                        'icon'      => 'eicon-text-align-center',
                    ],
                    'flex-end'     => [
                        'title'     => esc_html__('Right', 'industrium_plugin'),
                        'icon'      => 'eicon-text-align-right',
                    ]
                ],
                'default'   => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .industrium_tabs_titles_container' => '-webkit-justify-content: {{VALUE}}; -moz-justify-content: {{VALUE}}; -ms-justify-content: {{VALUE}}; justify-content: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Tabs Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_controls_settings',
            [
                'label' => esc_html__('Tab Title Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
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
                    '{{WRAPPER}} .industrium_tab_title_item .tab-title-icon i'    => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .industrium_tab_title_item .tab-title-icon svg'  => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__( 'Icon Margin', 'industrium_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .industrium_tab_title_item .tab-title-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'controls_typography',
                'label'     => esc_html__('Tab Title Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .industrium_tabs_titles_container .industrium_tab_title_item a'
            ]
        );

        $this->start_controls_tabs('controls_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_control_normal',
                [
                    'label' => esc_html__('Normal', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'controls_color',
                    [
                        'label'     => esc_html__('Tab Title Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .industrium_tabs_titles_container .industrium_tab_title_item:not(.active) a' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'controls_bg',
                    [
                        'label'     => esc_html__('Tab Title Background', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .industrium_tabs_titles_container .industrium_tab_title_item:not(.active)' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'controls_bd',
                    [
                        'label'     => esc_html__('Tab Title Border', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .industrium_tabs_titles_container .industrium_tab_title_item:not(.active)' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'controls_icon',
                    [
                        'label'     => esc_html__('Tab Icon Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .industrium_tab_title_item:not(.active) .tab-title-icon i'    => 'color: {{VALUE}};',
                            '{{WRAPPER}} .industrium_tab_title_item:not(.active) .tab-title-icon svg'  => 'fill: {{VALUE}} !important;'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Active Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_control_active',
                [
                    'label' => esc_html__('Active', 'industrium_plugin')
                ]
            );

                $this->add_control(
                    'controls_color_active',
                    [
                        'label'     => esc_html__('Tab Title Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .industrium_tabs_titles_container .industrium_tab_title_item.active a' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'controls_bg_active',
                    [
                        'label'     => esc_html__('Tab Title Background', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .industrium_tabs_titles_container .industrium_tab_title_item.active' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'controls_bd_active',
                    [
                        'label'     => esc_html__('Tab Title Border', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .industrium_tabs_titles_container .industrium_tab_title_item.active' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'controls_icon_active',
                    [
                        'label'     => esc_html__('Tab Icon Color', 'industrium_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .industrium_tab_title_item.active .tab-title-icon i'    => 'color: {{VALUE}};',
                            '{{WRAPPER}} .industrium_tab_title_item.active .tab-title-icon svg'  => 'fill: {{VALUE}} !important;'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Text Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_content_text_settings',
            [
                'label' => esc_html__('Text Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'text_typography',
                'label'     => esc_html__('Text Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .industrium_tab_text_container, {{WRAPPER}} .industrium_tab_text_container p, {{WRAPPER}} .industrium_tab_text_container ul li, {{WRAPPER}} .industrium_tab_text_container ol li'
            ]
        );

        $this->add_control(
            'content_headings_color',
            [
                'label'     => esc_html__('Headings Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium_tab_text_container h1, {{WRAPPER}} .industrium_tab_text_container h2, {{WRAPPER}} .industrium_tab_text_container h3, {{WRAPPER}} .industrium_tab_text_container h4, {{WRAPPER}} .industrium_tab_text_container h5, {{WRAPPER}} .industrium_tab_text_container h6' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'content_text_color',
            [
                'label'     => esc_html__('Text Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium_tab_text_container, {{WRAPPER}} .industrium_tab_text_container strong' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'content_text_accent',
            [
                'label'     => esc_html__('Text Accent Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium_tab_text_container blockquote:before, {{WRAPPER}} .industrium_tab_text_container p a, {{WRAPPER}} .industrium_tab_text_container p a:hover, {{WRAPPER}} .industrium_tab_text_container ul li:before, {{WRAPPER}} .industrium_tab_text_container ul li::marker' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $tabs = $settings['tabs'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="industrium_tabs_widget">
            <div class="industrium_tabs_titles_container">
                <?php
                $i = 1;

                foreach ($tabs as $tab) {
                    echo '<div class="industrium_tab_title_item" data-id="industrium_tab_id_' . esc_attr($i) . '">';
                        echo '<a href="' . esc_js('javascript:void(0)') . '">';
                            if ( $tab['icon_type'] == 'default' && !empty($tab['default_icon']['value']) ) {
                                echo '<span class="tab-title-icon"><i class="' . esc_attr($tab['default_icon']['value']) . '"></i></span>';
                            }
                            if ( $tab['icon_type'] == 'svg' && !empty($tab['svg_icon']) ) {
                                echo '<span class="tab-title-icon">' . industrium_output_code($tab['svg_icon']) . '</span>';
                            }
                            echo esc_html($tab['title']);
                        echo '</a>';
                    echo '</div>';

                    $i++;
                }
                ?>
            </div>

            <div class="industrium_tabs_content_container">
                <?php
                $i = 1;
                foreach ($tabs as $tab) { ?>
                    <div class="industrium_tab_content_item" id="industrium_tab_id_<?php echo esc_attr($i); ?>">
                        <div class="industrium_tab_text_container">
                            <?php echo wp_kses($tab['text'], 'post'); ?>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
                ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}