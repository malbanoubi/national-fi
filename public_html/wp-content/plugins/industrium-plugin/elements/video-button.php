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
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Industrium_Video_Button_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_video_button';
    }

    public function get_title() {
        return esc_html__('Video Button', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-play';
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
                'label' => esc_html__('Video', 'industrium_plugin')
            ]
        );

        $this->add_control(
            'video_type',
            [
                'label'     => esc_html__( 'Source', 'industrium_plugin' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'youtube',
                'options'   => [
                    'youtube'       => esc_html__( 'YouTube', 'industrium_plugin' ),
                    'vimeo'         => esc_html__( 'Vimeo', 'industrium_plugin' ),
                    'dailymotion'   => esc_html__( 'Dailymotion', 'industrium_plugin' ),
                    'hosted'        => esc_html__( 'Self Hosted', 'industrium_plugin' )
                ],
                'frontend_available' => true
            ]
        );

        $this->add_control(
            'youtube_url',
            [
                'label'         => esc_html__( 'Link', 'industrium_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
                'placeholder'   => esc_html__( 'Enter your URL', 'industrium_plugin' ) . ' (YouTube)',
                'default'       => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                'label_block'   => true,
                'condition'     => [
                    'video_type'    => 'youtube'
                ],
                'frontend_available' => true
            ]
        );

        $this->add_control(
            'vimeo_url',
            [
                'label'         => esc_html__( 'Link', 'industrium_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ],
                ],
                'placeholder'   => esc_html__( 'Enter your URL', 'industrium_plugin' ) . ' (Vimeo)',
                'default'       => 'https://vimeo.com/235215203',
                'label_block'   => true,
                'condition'     => [
                    'video_type'    => 'vimeo'
                ]
            ]
        );

        $this->add_control(
            'dailymotion_url',
            [
                'label'         => esc_html__( 'Link', 'industrium_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ],
                ],
                'placeholder'   => esc_html__( 'Enter your URL', 'industrium_plugin' ) . ' (Dailymotion)',
                'default'       => 'https://www.dailymotion.com/video/x6tqhqb',
                'label_block'   => true,
                'condition'     => [
                    'video_type'    => 'dailymotion'
                ]
            ]
        );

        $this->add_control(
            'insert_url',
            [
                'label'     => esc_html__( 'External URL', 'industrium_plugin' ),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'video_type'    => 'hosted'
                ]
            ]
        );

        $this->add_control(
            'hosted_url',
            [
                'label'         => esc_html__( 'Choose File', 'industrium_plugin' ),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::MEDIA_CATEGORY
                    ],
                ],
                'media_type'    => 'video',
                'condition'     => [
                    'video_type'    => 'hosted',
                    'insert_url'    => ''
                ]
            ]
        );

        $this->add_control(
            'external_url',
            [
                'label'         => esc_html__( 'URL', 'industrium_plugin' ),
                'type'          => Controls_Manager::URL,
                'autocomplete'  => false,
                'options'       => false,
                'label_block'   => true,
                'show_label'    => false,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
                'media_type'    => 'video',
                'placeholder'   => esc_html__( 'Enter your URL', 'industrium_plugin' ),
                'condition'     => [
                    'video_type'    => 'hosted',
                    'insert_url'    => 'yes'
                ],
            ]
        );
        
        $this->add_responsive_control(
            'button_align',
            [
                'label'     => esc_html__('Button Alignment', 'industrium_plugin'),
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
                    '{{WRAPPER}} .industrium_video_button_container' => 'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Video Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Video Button Settings', 'industrium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control(
            'button_padding',
            [
                'label'         => esc_html__('Button Padding', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .industrium_video_button_widget .eicon-play' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_button_size',
            [
                'label' => esc_html__('Trigger Button Size', 'industrium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 150,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .industrium_video_button_widget' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .industrium_video_button_widget .eicon-play' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'industrium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .industrium_video_button_widget .eicon-play' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'button_radius',
            [
                'label'         => esc_html__('Border Radius', 'industrium_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .industrium_video_button_widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                    'icon_color',
                    [
                        'label' => esc_html__('Icon Color', 'industrium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .industrium_video_button_widget .eicon-play svg' => 'stroke: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'icon_bg',
                        'label' => esc_html__( 'Icon Background', 'industrium_plugin' ),
                        'types' => [ 'classic', 'gradient'],
                        'selector' => '{{WRAPPER}} .industrium_video_button_widget .eicon-play',
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
                    'icon_hover',
                    [
                        'label' => esc_html__('Icon Hover', 'industrium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .industrium_video_button_widget .eicon-play:hover svg' => 'stroke: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'icon_bg_hover',
                        'label' => esc_html__( 'Icon Background', 'industrium_plugin' ),
                        'types' => [ 'classic', 'gradient'],
                        'selector' => '{{WRAPPER}} .industrium_video_button_widget .eicon-play:hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $youtube_url = $settings['youtube_url'];
        $vimeo_url = $settings['vimeo_url'];
        $dailymotion_url = $settings['dailymotion_url'];
        $video_type = $settings['video_type'];
        $insert_url = $settings['insert_url'];        
        $hosted_url = $settings['hosted_url'];
        $external_url = $settings['external_url'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>
        <div class="industrium_video_button_container">
            <div class="industrium_video_button_widget">
                <?php 
                    if( ( $video_type == 'youtube' && !empty($youtube_url) ) ||
                        ( $video_type == 'vimeo' && !empty($vimeo_url) ) ||
                        ( $video_type == 'dailymotion' && !empty($dailymotion_url) ) ||
                        ( $video_type == 'hosted' && (
                                !empty($insert_url) ||
                                !empty($hosted_url) ||
                                !empty($external_url)
                            ) ) 
                    ) {
                        $video_url = $settings[ $settings['video_type'] . '_url' ];

                        if ( 'hosted' === $settings['video_type'] ) {
                            $video_url = $this->get_hosted_video_url();
                        } else {
                            $embed_params = $this->get_embed_params();
                            $embed_options = $this->get_embed_options();
                        }

                        if ( 'youtube' === $settings['video_type'] ) {
                            $video_html = '<div class="elementor-video"></div>';
                        }

                        if ( 'hosted' === $settings['video_type'] ) {
                            $this->add_render_attribute( 'video-wrapper', 'class', 'e-hosted-video' );

                            ob_start();

                            $this->render_hosted_video();

                            $video_html = ob_get_clean();
                        } else {
                            $is_static_render_mode = \Elementor\Plugin::$instance->frontend->is_static_render_mode();
                            $post_id = get_queried_object_id();

                            if ( $is_static_render_mode ) {
                                $video_html = \Elementor\Embed::get_embed_thumbnail_html( $video_url, $post_id );
                            } else if ( 'youtube' !== $settings['video_type'] ) {
                                $video_html = \Elementor\Embed::get_embed_html( $video_url, $embed_params, $embed_options );
                            }
                        }

                        if ( empty( $video_html ) ) {
                            echo esc_url( $video_url );

                            return;
                        }
                        $this->add_render_attribute( 'video-wrapper', 'class', 'elementor-wrapper' );

                        $this->add_render_attribute( 'video-wrapper', 'class', 'elementor-open-lightbox' );
                        ?>
                        <div <?php $this->print_render_attribute_string( 'video-wrapper' ); ?>>
                            <?php
                                if ( 'hosted' === $settings['video_type'] ) {
                                    $lightbox_url = $video_url;
                                } else {
                                    $lightbox_url = \Elementor\Embed::get_embed_url( $video_url, $embed_params, $embed_options );
                                }

                                $lightbox_options = [
                                    'type'          => 'video',
                                    'videoType'     => $settings['video_type'],
                                    'url'           => $lightbox_url,
                                    'modalOptions'  => [
                                        'id'                        => 'elementor-lightbox-' . $this->get_id(),
                                        'videoAspectRatio'          => '169'
                                    ],
                                ];
                                if('hosted' === $video_type) {
                                    $slide_lightbox_options['videoParams'] = $this->get_hosted_params();
                                }

                                $this->add_render_attribute( 'image-overlay', 'class', 'elementor-custom-embed-image-overlay' );

                                $this->add_render_attribute( 'image-overlay', [
                                    'data-elementor-open-lightbox'  => 'yes',
                                    'data-elementor-lightbox'       => wp_json_encode( $lightbox_options ),
                                ] );

                                if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                                    $this->add_render_attribute( 'image-overlay', [
                                        'class' => 'elementor-clickable',
                                    ] );
                                }
                            ?>
                            <div <?php $this->print_render_attribute_string( 'image-overlay' ); ?>>
                                <div class="elementor-custom-embed-play" role="button">
                                    <i class="eicon-play" aria-hidden="true"><svg viewBox="0 0 23 27"><path d="M22,13.5L1,26V1L22,13.5z"/></svg></i>
                                    <span class="elementor-screen-only"><?php esc_html_e( 'Play Video', 'industrium_plugin' ); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php }
                ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function get_embed_params() {
        $settings = $this->get_settings_for_display();      
        $params = [];
        $params_dictionary = [];
        if ( 'youtube' === $settings['video_type'] ) {
            $params_dictionary = [];
            $params['wmode'] = 'opaque';
        } elseif ( 'vimeo' === $settings['video_type'] ) {
            $params_dictionary = [
                'mute'              => 'muted',
                'vimeo_title'       => 'title',
                'vimeo_portrait'    => 'portrait',
                'vimeo_byline'      => 'byline'
            ];
            $params['color'] = str_replace( '#', '', $settings['color'] );
            $params['autopause'] = '0';
        } elseif ( 'dailymotion' === $settings['video_type'] ) {
            $params_dictionary = [
                'showinfo'  => 'ui-start-screen-info',
                'logo'      => 'ui-logo',
            ];
            $params['ui-highlight'] = str_replace( '#', '', $settings['color'] );
            $params['endscreen-enable'] = '0';
        }
        foreach ( $params_dictionary as $key => $param_name ) {
            $setting_name = $param_name;
            if ( is_string( $key ) ) {
                $setting_name = $key;
            }
            $setting_value = $settings[ $setting_name ] ? '1' : '0';
            $params[ $param_name ] = $setting_value;
        }

        return $params;
    }

    private function get_hosted_video_url() {
        $settings = $this->get_settings_for_display();

        if ( ! empty( $settings['insert_url'] ) ) {
            $video_url = $settings['external_url']['url'];
        } else {
            $video_url = $settings['hosted_url']['url'];
        }
        if ( empty( $video_url ) ) {
            return '';
        }
        return $video_url;
    }    

    private function get_embed_options() {
        $settings = $this->get_settings_for_display();
        $embed_options = [];
        if ( 'youtube' === $settings['video_type'] ) {
            $embed_options['privacy'] = 'no';
        }
        return $embed_options;
    }

    private function get_hosted_params() {
        $settings = $this->get_settings_for_display();

        $video_params = ['autoplay' => true, 'loop' => false, 'controls' => true];

        return $video_params;
    }

    private function render_hosted_video() {
        $video_url = $this->get_hosted_video_url();
        if ( empty( $video_url ) ) {
            return;
        }
        $video_params = $this->get_hosted_params();
        ?>
        <video class="elementor-video"> src="<?php echo esc_url( $video_url ); ?>" <?php Utils::print_html_attributes( $video_params ); ?>></video>
        <?php
    }
}
