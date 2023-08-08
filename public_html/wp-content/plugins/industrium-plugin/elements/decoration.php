<?php
/*
 * Created by Artureanec
*/

namespace Industrium\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Industrium_Decoration_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_decoration';
    }

    public function get_title() {
        return esc_html__('Decoration', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-shape';
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
                'label' => esc_html__('Decoration', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'decoration_type',
            [
                'label'     => esc_html__('Type', 'industrium_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'type-1',
                'options'   => [
                    'type-1'   => esc_html__('Type 1', 'industrium_plugin'),
                    'type-2'   => esc_html__('Type 2', 'industrium_plugin'),
                    'type-3'   => esc_html__('Type 3', 'industrium_plugin'),
                    'type-4'   => esc_html__('Type 4', 'industrium_plugin')
                ],
                'prefix_class' => 'decoration-'
            ]
        );

        $this->add_responsive_control(
            'decoration_align',
            [
                'label'     => esc_html__('Decoration Alignment', 'industrium_plugin'),
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
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .decoration-widget' => 'text-align: {{VALUE}};',
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
                'label' => esc_html__('Decoration Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__( 'Block Height', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .decoration-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Block Width', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
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
                    '{{WRAPPER}} .decoration-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height_type_3',
            [
                'label' => esc_html__( 'Block 2 Height', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .decoration-container .industrium-decoration > div:first-child' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .decoration-container .industrium-decoration > div:nth-child(3n)' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'decoration_type' => ['type-3', 'type-4']
                ]
            ]
        );

        $this->add_responsive_control(
            'width_type_3',
            [
                'label' => esc_html__( 'Block 2 Width', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
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
                    '{{WRAPPER}} .decoration-container .industrium-decoration > div:first-child' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .decoration-container .industrium-decoration > div:nth-child(3n)' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'decoration_type' => ['type-3', 'type-4']
                ]
            ]
        );

        $this->add_control(
            'decoration_bg_color',
            [
                'label'     => esc_html__('Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-decoration > div' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_control(
            'decoration_bg_color_add',
            [
                'label'     => esc_html__('Addittional Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-decoration > div:nth-child(2n)' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'decoration_bg_color_sec',
            [
                'label'     => esc_html__('Secondary Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-decoration > div:nth-child(3n)' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'decoration_type' => 'type-4'
                ]
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $settings        = $this->get_settings();

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>
        <div class="decoration-widget">
            <div class="decoration-container">
                <div class="industrium-decoration">
                    <div></div><div></div><div></div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
