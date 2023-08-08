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
use Elementor\Control_Date_Time;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Industrium_Countdown_Widget extends Widget_Base {

    public function get_name() {
        return 'industrium_countdown';
    }

    public function get_title() {
        return esc_html__('Countdown', 'industrium_plugin');
    }

    public function get_icon() {
        return 'eicon-countdown';
    }

    public function is_reload_preview_required() {
        return true;
    }

    public function get_categories() {
        return ['industrium_widgets'];
    }

    public function get_script_depends() {
        return ['countdown_widget'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Countdown', 'industrium_plugin')
            ]
        );

        $default_date = date_create( date('Y-m-d H:i:s') );
        date_modify($default_date, '+30 day');
        $default_date = date_format($default_date, 'Y-m-d H:i:s');
        $this->add_control(
            'due_date',
            [
                'label' => esc_html__('Due Date', 'industrium_plugin'),
                'type' => Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'enableTime'        => true,
                    'minuteIncrement'   => 1,
                    'enableSeconds'     => true
                ],
                'default' => $default_date
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__('View', 'industrium_plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'block' => esc_html__( 'Block', 'industrium_plugin' ),
                    'inline' => esc_html__( 'Inline', 'industrium_plugin' ),
                    'stacked' => esc_html__( 'Stacked', 'industrium_plugin' )
                ],
                'default' => 'block'
            ]
        );

        $this->add_responsive_control(
            'countdown_align',
            [
                'label' => esc_html__('Countdown Alignment', 'industrium_plugin'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'industrium_plugin'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'industrium_plugin'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'industrium_plugin'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .industrium_countdown_widget' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'view' => 'inline'
                ]
            ]
        );

        $this->add_control(
            'view_days',
            [
                'label' => esc_html__('Days', 'industrium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'industrium_plugin'),
                'label_on' => esc_html__('Show', 'industrium_plugin'),
                'default' => 'no',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'view_hours',
            [
                'label' => esc_html__('Hours', 'industrium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'industrium_plugin'),
                'label_on' => esc_html__('Show', 'industrium_plugin'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'view_minutes',
            [
                'label' => esc_html__('Minutes', 'industrium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'industrium_plugin'),
                'label_on' => esc_html__('Show', 'industrium_plugin'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'view_seconds',
            [
                'label' => esc_html__('Seconds', 'industrium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'industrium_plugin'),
                'label_on' => esc_html__('Show', 'industrium_plugin'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_label',
            [
                'label' => esc_html__('Show Label', 'industrium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'industrium_plugin'),
                'label_on' => esc_html__('Show', 'industrium_plugin'),
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'custom_label',
            [
                'label' => esc_html__('Custom Label', 'industrium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('No', 'industrium_plugin'),
                'label_on' => esc_html__('Yes', 'industrium_plugin'),
                'default' => 'no',
                'condition' => [
                    'show_label' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'label_days',
            [
                'label' => esc_html__('Days', 'industrium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Days', 'industrium_plugin' ),
                'condition' => [
                    'custom_label' => 'yes',
                    'show_label' => 'yes',
                    'view_days' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'label_hours',
            [
                'label' => esc_html__('Hours', 'industrium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Hours', 'industrium_plugin' ),
                'condition' => [
                    'custom_label' => 'yes',
                    'show_label' => 'yes',
                    'view_hours' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'label_minutes',
            [
                'label' => esc_html__('Minutes', 'industrium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Minutes', 'industrium_plugin' ),
                'condition' => [
                    'custom_label' => 'yes',
                    'show_label' => 'yes',
                    'view_minutes' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'label_seconds',
            [
                'label' => esc_html__('Seconds', 'industrium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Seconds', 'industrium_plugin' ),
                'condition' => [
                    'custom_label' => 'yes',
                    'show_label' => 'yes',
                    'view_seconds' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'action',
            [
                'label' => esc_html__('Actions After Expire', 'industrium_plugin'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'options' => [
                    'hide' => esc_html__( 'Hide', 'industrium_plugin' ),
                    'message' => esc_html__( 'Show Message', 'industrium_plugin' )
                ],
                'multiple' => true,
                'default' => [],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'message',
            [
                'label' => esc_html__('Message', 'industrium_plugin'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter Your Message', 'industrium_plugin' ),
                'condition' => [
                    'action' => 'message'
                ]
            ]
        );

        $this->end_controls_section();

        // --------------------------------------- //
        // ---------- Style Settings ---------- //
        // --------------------------------------- //
        $this->start_controls_section(
            'section_boxes_settings',
            [
                'label' => esc_html__('Boxes', 'industrium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

            $this->add_responsive_control(
                'container_width',
                [
                    'label' => esc_html__('Container Width', 'industrium_plugin'),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '100',
                        'unit' => '%'
                    ],
                    'size_units' => ['%', 'px'],
                    'range' => [
                        '%' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                        'px' => [
                            'min' => 10,
                            'max' => 1920,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .countdown_inner' => 'width: {{SIZE}}{{UNIT}};'
                    ],
                    'separator' => 'before'
                ]
            );

            $this->add_responsive_control(
                'box_width',
                [
                    'label' => esc_html__('Box Width', 'industrium_plugin'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['%', 'px'],
                    'range' => [
                        '%' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                        'px' => [
                            'min' => 10,
                            'max' => 500,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .countdown_digits' => 'width: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .countdown_digits_placeholder' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'separator' => 'before'
                ]
            );

            $this->add_responsive_control(
                'box_height',
                [
                    'label' => esc_html__('Box Height', 'industrium_plugin'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 500,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .countdown_digits' => 'height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .countdown_digits_placeholder' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'separator' => 'before'
                ]
            );

            $this->add_control(
                'boxes_bg',
                [
                    'label' => esc_html__('Background Color', 'industrium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .industrium_countdown_widget .countdown_digits' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'boxes_border',
                    'placeholder' => '1px',
                    'default' => '',
                    'selector' => '{{WRAPPER}} .industrium_countdown_widget .countdown_digits:before',
                    'separator' => 'before'
                ]
            );

            $this->add_responsive_control(
                'boxes_margin',
                [
                    'label' => esc_html__('Boxes shift', 'industrium_plugin'),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => -1,
                        'unit' => 'px'
                    ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 0,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .industrium_countdown_widget.display_stacked .countdown_item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                        'body.rtl {{WRAPPER}} .industrium_countdown_widget.display_stacked .countdown_item:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}};'
                    ],
                    'condition' => [
                        'view' => 'stacked'
                    ]
                ]
            );

            $this->add_control(
                'boxes_radius',
                [
                    'label' => esc_html__('Border Radius', 'industrium_plugin'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .industrium_countdown_widget .countdown_digits, {{WRAPPER}} .industrium_countdown_widget .countdown_digits:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );

            $this->add_responsive_control(
                'boxes_space',
                [
                    'label' => esc_html__('Space Between', 'industrium_plugin'),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '90',
                        'unit' => 'px'
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .countdown_separator' => 'width: {{SIZE}}{{UNIT}};'
                    ],
                    'condition' => [
                        'view!' => 'stacked'
                    ]
                ]
            );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_content_settings',
            [
                'label' => esc_html__('Content', 'industrium_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

            $this->add_control(
                'digit_title',
                [
                    'label' => esc_html__( 'Digits', 'industrium_plugin' ),
                    'type'  => Controls_Manager::HEADING
                ]
            );

            $this->add_control(
                'digits_color',
                [
                    'label' => esc_html__('Color', 'industrium_plugin'),
                    'type'  => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .countdown_digits'     => 'color: {{VALUE}};',
                        '{{WRAPPER}} .countdown_separator'  => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'      => 'digits_typography',
                    'label'     => esc_html__('Typography', 'industrium_plugin'),
                    'selector'  => '{{WRAPPER}} .countdown_digits, {{WRAPPER}} .countdown_separator, {{WRAPPER}} .countdown_digits_placeholder'
                ]
            );

            $this->add_control(
                'label_title',
                [
                    'label'     => esc_html__( 'Label', 'industrium_plugin' ),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before'
                ]
            );

            $this->add_control(
                'label_color',
                [
                    'label'     => esc_html__('Color', 'industrium_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .countdown_label' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'      => 'label_typography',
                    'label'     => esc_html__('Typography', 'industrium_plugin'),
                    'selector'  => '{{WRAPPER}} .countdown_label'
                ]
            );

            $this->add_responsive_control(
                'label_margin',
                [
                    'label'         => esc_html__('Space between number and label', 'industrium_plugin'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px'],
                    'range'         => [
                        'px'            => [
                            'min'           => 0,
                            'max'           => 100
                        ]
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .industrium_countdown_widget .countdown_label' => 'margin-top: {{SIZE}}{{UNIT}};'
                    ]
                ]
            );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_message_settings',
            [
                'label' => esc_html__('Message', 'industrium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'action' => 'message'
                ]
            ]
        );

        $this->add_responsive_control(
            'message_align',
            [
                'label' => esc_html__('Alignment', 'industrium_plugin'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'industrium_plugin'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'industrium_plugin'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'industrium_plugin'),
                        'icon' => 'fa fa-align-right',
                    ]
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .countdown_message' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'message_color',
            [
                'label' => esc_html__('Text Color', 'industrium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .countdown_message' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'action' => 'message'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'message_typography',
                'label' => esc_html__('Typography', 'industrium_plugin'),
                'selector' => '{{WRAPPER}} .countdown_message',
                'condition' => [
                    'action' => 'message'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        $due_date = $settings['due_date'];
        $view = $settings['view'];
        $action = implode(',', $settings['action']);
        $message = $settings['message'];

        $view_days = $settings['view_days'];
        $view_hours = $settings['view_hours'];
        $view_minutes = $settings['view_minutes'];
        $view_seconds = $settings['view_seconds'];

        $show_label = $settings['show_label'];
        $label_days = !empty($settings['label_days']) ? $settings['label_days'] : esc_html__('Days', 'industrium_plugin');
        $label_hours = !empty($settings['label_hours']) ? $settings['label_hours'] : esc_html__('Hours', 'industrium_plugin');
        $label_minutes = !empty($settings['label_minutes']) ? $settings['label_minutes'] : esc_html__('Minutes', 'industrium_plugin');
        $label_seconds = !empty($settings['label_seconds']) ? $settings['label_seconds'] : esc_html__('Seconds', 'industrium_plugin');

        $date = mysql2date('Y-m-d', $due_date);
        $time = mysql2date('H:i:s', $due_date);

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="industrium_countdown_widget display_<?php echo esc_attr($view); ?>">
            <?php
                echo '<div class="countdown" id="countdown" data-date="' . esc_attr(empty($date) ? date('Y-m-d') : $date) . '" data-time="' . esc_attr(empty($time) ? '00:00:00' : $time) . '" data-action="' . esc_attr($action) . '">';
                    echo '<div class="countdown_inner">';

                        echo '<div class="countdown_item countdown_days' . ( $view_days == 'yes' ? '' : ' hide') . '">';
                            echo '<span class="countdown_digits"><span>00</span><span></span><span></span></span>';
                            echo '<span class="countdown_digits_placeholder">444</span>';
                            echo ( $show_label == 'yes' ? '<span class="countdown_label">' . esc_html($label_days) . '</span>' : '');
                        echo '</div>';
                        if ( $view_days == 'yes' && ($view_hours == 'yes' || $view_minutes == 'yes' || $view_seconds == 'yes')) {
                            echo '<div class="countdown_separator">:</div>';
                        }

                        echo '<div class="countdown_item countdown_hours' . ( $view_hours == 'yes' ? '' : ' hide') . '">';
                            echo '<span class="countdown_digits"><span>00</span><span></span><span></span></span>';
                            echo '<span class="countdown_digits_placeholder">44</span>';
                            echo ( $show_label == 'yes' ? '<span class="countdown_label">' . esc_html($label_hours) . '</span>' : '');
                        echo '</div>';
                        if ( $view_hours == 'yes' && ($view_minutes == 'yes' || $view_seconds == 'yes') ) {
                            echo '<div class="countdown_separator">:</div>';
                        }

                        echo '<div class="countdown_item countdown_minutes' . ( $view_minutes == 'yes' ? '' : ' hide') . '">';
                            echo '<span class="countdown_digits"><span>00</span><span></span><span></span></span>';
                            echo '<span class="countdown_digits_placeholder">44</span>';
                            echo ( $show_label == 'yes' ? '<span class="countdown_label">' . esc_html($label_minutes) . '</span>' : '');
                        echo '</div>';
                        if ( $view_minutes == 'yes' && $view_seconds == 'yes') {
                            echo '<div class="countdown_separator">:</div>';
                        }

                        echo '<div class="countdown_item countdown_seconds' . ( $view_seconds == 'yes' ? '' : ' hide') . '">';
                            echo '<span class="countdown_digits"><span>00</span><span></span><span></span></span>';
                            echo '<span class="countdown_digits_placeholder">44</span>';
                            echo ( $show_label == 'yes' ? '<span class="countdown_label">' . esc_html($label_seconds) . '</span>' : '');
                        echo '</div>';

                    echo '</div>';

                    echo '<div class="countdown_placeholder"></div>';

                    if ( in_array('message', $settings['action'])  && !empty($message)  ) {
                        echo '<div class="countdown_message">';
                        echo wp_kses($message, array(
                            'br' => array()
                        ));
                        echo '</div>';
                    }
                echo '</div>';
            ?>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
            var due_date = new Date( settings.due_date ),
            now_date = new Date();

            var due_date_in_days = Math.floor(Math.abs(due_date.getTime() - now_date.getTime()) / 86400000);
            var due_date_in_hours = Math.floor( Math.abs( ( due_date.getTime() - now_date.getTime() - ( due_date_in_days * 86400000 ) ) ) / 3600000 );
            var due_date_in_minutes = Math.floor( Math.abs( ( due_date.getTime() - now_date.getTime() - ( due_date_in_days * 86400000 ) - ( due_date_in_hours * 3600000 ) ) ) / 60000 );
            var due_date_in_seconds = Math.floor( Math.abs( ( due_date.getTime() - now_date.getTime() - ( due_date_in_days * 86400000 ) - ( due_date_in_hours * 3600000 ) - ( due_date_in_minutes * 60000 ) ) ) / 1000 );

            if ( due_date_in_days < 10 ) due_date_in_days = '0' + due_date_in_days;
            if ( due_date_in_hours < 10 ) due_date_in_hours = '0' + due_date_in_hours;
            if ( due_date_in_minutes < 10 ) due_date_in_minutes = '0' + due_date_in_minutes;
            if ( due_date_in_seconds < 10 ) due_date_in_seconds = '0' + due_date_in_seconds;

            var is_view_days = '';
            if ( settings.view_days == 'yes' ) {
                is_view_days = '';
            } else {
                is_view_days = ' hide';
            }

            var is_view_hours = '';
            if ( settings.view_hours == 'yes' ) {
                is_view_hours = '';
            } else {
                is_view_hours = ' hide';
            }

            var is_view_minutes = '';
            if ( settings.view_minutes == 'yes' ) {
                is_view_minutes = '';
            } else {
                is_view_minutes = ' hide';
            }

            var is_view_seconds = '';
            if ( settings.view_seconds == 'yes' ) {
                is_view_seconds = '';
            } else {
                is_view_seconds = ' hide';
            }

            is_month = due_date.getMonth() + 1;
            if ( is_month < 10 ) is_month = '0' + is_month;
            is_date = due_date.getDate();
            if ( is_date < 10 ) is_date = '0' + is_date;
            is_hours = due_date.getHours();
            if ( is_hours < 10 ) is_hours = '0' + is_hours;
            is_minutes = due_date.getMinutes();
            if ( is_minutes < 10 ) is_minutes = '0' + is_minutes;
            is_seconds = due_date.getSeconds();
            if ( is_seconds < 10 ) is_seconds = '0' + is_seconds;

            var due_date_date = due_date.getFullYear() + '-' + is_month + '-' + is_date;
            var due_date_time = is_hours + ':' + is_minutes + ':' + is_seconds;

            is_action = settings.action.join(',');
        #>
        <div class="industrium_countdown_widget display_{{ settings.view }}">
            <div class="countdown" id="countdown" data-date="{{due_date_date}}" data-time="{{due_date_time}}" data-action="{{is_action}}">
                <div class="countdown_inner">

                    <div class="countdown_item countdown_days{{ is_view_days }}">
                        <span class="countdown_digits"><span>{{{ due_date_in_days }}}</span></span>
                        <span class="countdown_digits_placeholder">444</span>
                        <# if ( settings.show_label ) {
                            #><span class="countdown_label">{{{ settings.label_days }}}</span><#
                        } #>
                    </div>
                    <# if ( settings.view_days == 'yes' ) {
                        #><div class="countdown_separator">:</div><#
                    } #>

                    <div class="countdown_item countdown_hours{{ is_view_hours }}">
                        <span class="countdown_digits"><span>{{{ due_date_in_hours }}}</span></span>
                        <span class="countdown_digits_placeholder">44</span>
                        <# if ( settings.show_label ) {
                            #><span class="countdown_label">{{{ settings.label_hours }}}</span><#
                        } #>
                    </div>
                    <# if ( settings.view_hours == 'yes' ) {
                        #><div class="countdown_separator">:</div><#
                    } #>

                    <div class="countdown_item countdown_minutes{{ is_view_minutes }}">
                        <span class="countdown_digits"><span>{{{ due_date_in_minutes }}}</span></span>
                        <span class="countdown_digits_placeholder">44</span>
                        <# if ( settings.show_label ) {
                            #><span class="countdown_label">{{{ settings.label_minutes }}}</span><#
                        } #>
                    </div>
                    <# if ( settings.view_minutes == 'yes' ) {
                        #><div class="countdown_separator">:</div><#
                    } #>

                    <div class="countdown_item countdown_seconds{{ is_view_seconds }}">
                        <span class="countdown_digits"><span>{{{ due_date_in_seconds }}}</span></span>
                        <span class="countdown_digits_placeholder">44</span>
                        <# if ( settings.show_label == 'yes' ) {
                            #><span class="countdown_label">{{{ settings.label_seconds }}}</span><#
                        } #>
                    </div>

                </div>

                <div class="countdown_placeholder"></div>

            </div>
        </div>
        <?php
    }

    public function render_plain_content() {}
}