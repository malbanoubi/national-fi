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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Industrium_Step_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_step';
    }

    public function get_title() {
        return esc_html__('Step', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-editor-list-ol';
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
                'label'         => esc_html__('Step', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'step_number',
            [
                'label'     => esc_html__('Step Number', 'industrium_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => '01',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'step_number_big',
            [
                'label'     => esc_html__('Step Number Big', 'industrium_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => '01',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'step_title',
            [
                'label'         => esc_html__('Title', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => ''
            ]
        );

        $this->add_control(
            'step_description',
            [
                'label'         => esc_html__('Description', 'industrium_plugin'),
                'description'   => esc_html__('Enter description', 'industrium_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => ''
            ]
        );

        $this->add_responsive_control(
            'step_align',
            [
                'label'     => esc_html__('Alignment', 'industrium_plugin'),
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
                'selectors' => [
                    '{{WRAPPER}} .step-item' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Item Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_item_settings',
            [
                'label'         => esc_html__('Step Item Settings', 'industrium_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'item_background_color',
            [
                'label'         => esc_html__('Background Color', 'industrium_plugin'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '',
                'selectors'     => [
                    '{{WRAPPER}} .step-item' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'item_shadow',
                'label'         => esc_html__('Item Shadow', 'industrium_plugin'),
                'selector'      => '{{WRAPPER}} .step-item'
            ]
        );

        $this->add_control(
            'item_padding',
            [
                'label'         => esc_html__('Item Padding', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .step-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .step-item .step-bg-number' => 'left: {{LEFT}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .step-item .step-bg-number' => 'right: {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'bg_number_typography',
                'label'         => esc_html__('Background Number Typography', 'industrium_plugin'),
                'selector'      => '{{WRAPPER}} .step-item .step-bg-number',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'bg_number_color',
            [
                'label'         => esc_html__('Background Number Color', 'industrium_plugin'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '',
                'selectors'     => [
                    '{{WRAPPER}} .step-item .step-bg-number' => '-webkit-text-stroke: 1px {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------- //
        // ---------- Number Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'section_number_settings',
            [
                'label'         => esc_html__('Number Settings', 'industrium_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'number_typography',
                'label'         => esc_html__('Number Typography', 'industrium_plugin'),
                'selector'      => '{{WRAPPER}} .step-item .step-number'
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label'         => esc_html__('Number Color', 'industrium_plugin'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '',
                'selectors'     => [
                    '{{WRAPPER}} .step-item .step-number' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'number_spacing',
            [
                'label'         => esc_html__('Space between number and title', 'industrium_plugin'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'            => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .step-item .step-number:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
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
                'label'         => esc_html__('Title Settings', 'industrium_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'step_content_padding',
            [
                'label'         => esc_html__('Step Content Padding', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .step-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'title_typography',
                'label'         => esc_html__('Title Typography', 'industrium_plugin'),
                'selector'      => '{{WRAPPER}} .step-title'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'         => esc_html__('Title Color', 'industrium_plugin'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '',
                'selectors'     => [
                    '{{WRAPPER}} .step-title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'title_hover',
            [
                'label'         => esc_html__('Title Hover', 'industrium_plugin'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '',
                'selectors'     => [
                    '{{WRAPPER}} .step-item:hover .step-title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'         => esc_html__('Space between title and description', 'industrium_plugin'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'            => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .step-title:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------------ //
        // ---------- Description Settings ---------- //
        // ------------------------------------------ //
        $this->start_controls_section(
            'section_description_settings',
            [
                'label' => esc_html__('Description Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'description_typography',
                'label'     => esc_html__('Description Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .step-description'
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__('Description Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .step-description' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings();

        $step_number        = $settings['step_number'];
        $step_number_big    = $settings['step_number_big'];
        $step_title         = $settings['step_title'];
        $step_description   = $settings['step_description'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="industrium-step-widget">
            <div class="step-item">

                <?php
                    if ( !empty($step_number)) {
                        echo '<div class="step-bg-number">' . esc_html($step_number_big) . '</div>';
                        echo '<div class="step-number">' . esc_html($step_number) . '</div>';
                    }
                    if ( !empty($step_title) || !empty($step_description) ) {
                        echo '<div class="step-content">';
                            if ( !empty($step_title) ) {
                                echo '<h3 class="step-title">' . wp_kses($step_title, array('br' => array())) . '</h3>';
                            }
                            if ( !empty($step_description) ) {
                                echo '<div class="step-description">' . esc_html($step_description) . '</div>';
                            }
                        echo '</div>';
                    }                    
                ?>

            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
