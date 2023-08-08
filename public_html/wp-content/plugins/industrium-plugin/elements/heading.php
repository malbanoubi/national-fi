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

class Industrium_Heading_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_heading';
    }

    public function get_title() {
        return esc_html__('Heading', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-heading';
    }

    public function get_categories() {
        return ['industrium_widgets'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'heading',
            [
                'label'         => esc_html__('Heading', 'industrium_plugin'),
                'type'          => Controls_Manager::WYSIWYG,
                'rows'          => '10',
                'default'       => esc_html__( 'This is heading element', 'industrium_plugin' ),
                'placeholder'   => esc_html__( 'Enter Your Heading', 'industrium_plugin' )
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
                'label_on'      => esc_html__('Yes', 'industrium_plugin')
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
                    'add_subtitle'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'remove_subtitle_dot',
            [
                'label'         => esc_html__('Remove Subtitle Dot', 'industrium_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => '',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'industrium_plugin'),
                'label_on'      => esc_html__('Yes', 'industrium_plugin'),
                'condition'     => [
                    'add_subtitle'  => 'yes'
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
                'default'   => 'h2'
            ]
        );

        $this->add_responsive_control(
            'title_align',
            [
                'label'     => esc_html__('Alignment', 'industrium_plugin'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'=> [
                        'title'     => esc_html__('Left', 'industrium_plugin'),
                        'icon'      => 'eicon-text-align-left',
                    ],
                    'center'    => [
                        'title'     => esc_html__('Center', 'industrium_plugin'),
                        'icon'      => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title'     => esc_html__('Right', 'industrium_plugin'),
                        'icon'      => 'eicon-text-align-right',
                    ]
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .industrium-heading' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // -------------------------------------- //
        // ---------- Heading Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_heading_settings',
            [
                'label' => esc_html__('Heading Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
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

        $this->add_responsive_control(
            'space_subheading',
            [
                'label' => esc_html__( 'Space between Heading and Subheading', 'industrium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .industrium-heading .industrium-heading-content:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'add_subtitle' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings       = $this->get_settings();
        $title_tag      = $settings['title_tag'];
        $heading        = $settings['heading'];
        $add_subtitle   = $settings['add_subtitle'];
        $subtitle       = $settings['subtitle'];
        $remove_subtitle_dot = $settings['remove_subtitle_dot'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        if ( !empty($heading) ) {
            echo '<div class="industrium-heading-widget">';
                echo '<' . esc_html($title_tag) . ' class="industrium-heading">';
                    if ( $add_subtitle == 'yes' && !empty($subtitle) ) {
                        echo '<span class="industrium-subheading' . ($remove_subtitle_dot == 'yes' ? ' no-dot' : '') . '">' . esc_html($subtitle) . '</span>';
                    }
                    echo '<span class="industrium-heading-content">';
                        echo wp_kses($heading, array(
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
                echo '</' . esc_html($title_tag) . '>';
            echo '</div>';
        }
    }

    protected function content_template() {}

    public function render_plain_content() {}
}