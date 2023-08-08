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

class Industrium_Special_Text_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_special_text';
    }

    public function get_title() {
        return esc_html__('Special Text', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-t-letter';
    }

    public function get_categories() {
        return ['industrium_widgets'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_special_text',
            [
                'label' => esc_html__('Special Text', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'effect',
            [
                'label'     => esc_html__( 'Select Effect', 'industrium_plugin' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'stroke',
                'options'   => [
                    'stroke'    => esc_html__( 'Stroke', 'industrium_plugin' ),
                    'fill'      => esc_html__( 'Fill', 'industrium_plugin' ),
                    'combined'      => esc_html__( 'Combined', 'industrium_plugin' )
                ],
            ]
        );

        $this->add_control(
            'text',
            [
                'label'         => esc_html__( 'Text', 'industrium_plugin' ),
                'type'          => Controls_Manager::WYSIWYG
            ]
        );

        $this->add_control(
            'text_tag',
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
                'default'   => 'div',
                'condition' => [
                    'effect'    => ['fill', 'stroke']
                ]
            ]
        );

        $this->add_responsive_control(
            'text_align',
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
                    '{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .special-text-wrapper' => 'text-align: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Text Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_text_settings',
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
                'selector'  => '{{WRAPPER}} .special-text'
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__('Text Stroke Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .special-text-effect-stroke' => '-webkit-text-stroke: 1px {{VALUE}}; text-stroke: 1px {{VALUE}};'
                ],
                'condition' => [
                    'effect'    => ['stroke', 'combined']
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'text_background',
                'label'     => esc_html__( 'Text Background', 'plugin-domain' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .special-text-effect-fill',
                'condition' => [
                    'effect'    => ['fill', 'combined']
                ]
            ]
        );

        $this->add_control(
            'text_opacity',
            [
                'label'     => esc_html__('Opacity', 'industrium_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    '%'         => [
                        'min'       => 0,
                        'max'       => 1,
                        'step'      => .01
                    ]
                ],
                'default'   => [
                    'unit'      => '%',
                    'size'      => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .special-text' => 'opacity: {{SIZE}};'
                ]
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings       = $this->get_settings();
        $effect         = $settings['effect'];
        $text           = $settings['text'];
        $text_tag       = $settings['text_tag'];

        $block_classes  = 'special-text special-text-effect-' . ( !empty($effect) ? esc_attr($effect) : 'stroke' );

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        if($effect == 'combined') {
        	echo '<div class="special-text-wrapper">';
        	if ( !empty($text) ) {
	            echo '<span class="special-text special-text-effect-fill">';
	                echo wp_kses($text, array(
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
	                echo '<span class="special-text special-text-effect-stroke">';
		                echo wp_kses($text, array(
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
	        }
	        echo '</div>';
        } else {
        	if ( !empty($text) ) {
	            echo '<' . esc_html($text_tag) . ' class="' . esc_attr($block_classes) . '">';
	                echo wp_kses($text, array(
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
	            echo '</' . esc_html($text_tag) . '>';
	        }
        }        
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
