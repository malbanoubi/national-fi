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

class Industrium_Instagram_Feed_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_instagram_feed';
    }

    public function get_title() {
        return esc_html__('Instagram Feed', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-instagram-gallery';
    }

    public function is_reload_preview_required() {
        return true;
    }

    public function get_categories() {
        return ['industrium_widgets'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_instagram_feed',
            [
                'label' => esc_html__('Instagram Feed', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'num',
            [
                'label'         => esc_html__('Limit', 'industrium_plugin'),
                'description'   => esc_html__('The number of photos to display initially.', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'min'           => 1,
                'max'           => 33,
                'default'       => 6
            ]
        );

        $this->add_control(
            'cols',
            [
                'label'         => esc_html__('Columns', 'industrium_plugin'),
                'description'   => esc_html__('The number of columns to display.', 'industrium_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'min'           => 1,
                'max'           => 10,
                'default'       => 6
            ]
        );

        $this->add_control(
            'imageres',
            [
                'label'   => esc_html__('Resolution', 'industrium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'description' => esc_html__('The resolution/size of the photos including full, medium, thumbnail, and auto (based on size of image on page).', 'industrium_plugin'),
                'default' => 'medium',
                'options' => [
                    'auto'      => esc_html__('Auto', 'industrium_plugin'),
                    'thumb'     => esc_html__('Thumbnail', 'industrium_plugin'),
                    'medium'    => esc_html__('Medium', 'industrium_plugin'),
                    'full'      => esc_html__('Full', 'industrium_plugin')
                ]
            ]
        );

        $this->add_control(
            'add_name',
            [
                'label'     => esc_html__('Display user name', 'industrium_plugin'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'no',
                'label_off' => esc_html__('No', 'industrium_plugin'),
                'label_on'  => esc_html__('Yes', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'user_name',
            [
                'label'     => esc_html__('User Name', 'industrium_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => '',
                'condition' => [
                    'add_name'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'user_link',
            [
                'label'         => esc_html__('Link', 'industrium_plugin'),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'default'       => [
                    'url'           => '',
                    'is_external'   => 'true',
                ],
                'placeholder'   => esc_html__( 'http://your-link.com', 'industrium_plugin' ),
                'condition'     => [
                    'add_name'      => 'yes'
                ]
            ]
        );

        $this->add_control(
            'user_description',
            [
                'label'     => esc_html__('Description', 'industrium_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => '',
                'condition' => [
                    'add_name'  => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Images Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_images_settings',
            [
                'label' => esc_html__('Feed Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label'     => esc_html__('Overlay Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #sb_instagram .sbi_item .sbi_photo:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'overlay_opacity',
            [
                'label'     => esc_html__('Overlay Opacity on Hover', 'industrium_plugin'),
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
                    'size'      => 0.65,
                ],
                'selectors' => [
                    '{{WRAPPER}} #sb_instagram .sbi_item .sbi_photo:hover:before' => 'opacity: {{SIZE}};'
                ]
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Icon Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #sb_instagram .sbi_item .sbi_photo:after' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Info Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_info_settings',
            [
                'label' => esc_html__('Info Settings', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'info_bg_color',
            [
                'label'     => esc_html__('Info Background Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-instagram-feed .instagram-feed-info' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'info_bd_color',
            [
                'label'     => esc_html__('Info Border Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-instagram-feed .instagram-feed-info:before' => 'border-color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'user_name_typography',
                'label'     => esc_html__('User Name Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .industrium-instagram-feed .instagram-feed-info .user-name'
            ]
        );

        $this->add_control(
            'user_name_color',
            [
                'label'     => esc_html__('User Name Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-instagram-feed .instagram-feed-info .user-name, {{WRAPPER}} .industrium-instagram-feed .instagram-feed-info .user-name a' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'description_typography',
                'label'     => esc_html__('Description Typography', 'industrium_plugin'),
                'selector'  => '{{WRAPPER}} .industrium-instagram-feed .instagram-feed-info .user-description'
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__('Description Color', 'industrium_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .industrium-instagram-feed .instagram-feed-info .user-description' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings();
        $add_name           = $settings['add_name'];
        $user_name          = $settings['user_name'];
        $user_link          = $settings['user_link'];
        if ( $user_link['url'] !== '' ) {
            $user_url       = $user_link['url'];
        } else {
            $user_url       = '#';
        }
        $user_description   = $settings['user_description'];
        $shortcode_attr     = ' showheader=false showbutton=false showfollow=false sortby=none imagepadding=0 imagepaddingunit=px';

        $num                = $settings['num'];
        $shortcode_attr     .= (!empty($num) ? ' num="' . $num . '"' : '');

        $cols               = $settings['cols'];
        $shortcode_attr     .= (!empty($cols) ? ' cols="' . $cols . '"' : '');

        $imageres           = $settings['imageres'];
        $shortcode_attr     .= (!empty($imageres) ? ' imageres="' . $imageres . '"' : '');

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>
            <div class="industrium-instagram-feed">
                <?php
                    $shortcode = '[instagram-feed' . $shortcode_attr . ']';
                    echo do_shortcode($shortcode);

                    if ( $add_name == 'yes' && ( !empty($user_name) || !empty($user_description) ) ) {
                        echo '<div class="instagram-feed-info">';
                            echo ( !empty($user_name) ? '<div class="user-name">' : '' );
                                if ( !empty($user_link) ) {
                                    echo '<a href="' . esc_url($user_url) . '"' . ($user_link['is_external'] == true ? ' target="_blank"' : '') . ($user_link['nofollow'] == 'on' ? ' rel="nofollow"' : '') . '>';
                                }
                                    echo ( !empty($user_name) ? '@' . esc_html($user_name) : '' );
                                if ( !empty($user_link) ) {
                                    echo '</a>';
                                }
                            echo ( !empty($user_name) ? '</div>' : '' );
                            echo ( !empty($user_description) ? '<div class="user-description">' . esc_html($user_description) . '</div>' : '' );
                        echo '</div>';
                    }
                ?>
            </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
