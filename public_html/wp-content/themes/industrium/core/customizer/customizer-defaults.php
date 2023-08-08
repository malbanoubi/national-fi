<?php
/*
 * Created by Artureanec
*/

global $industrium_customizer_default_values;
$industrium_customizer_default_values = array(
    # General
        # Page Loader
        'page_loader_status'                        => 'on',
        'page_loader_image'                         => '',

    # Top Bar
        # Top Bar General
        'top_bar_status'                            => 'off',
        'top_bar_customize'                         => 'on',
        'top_bar_default_text_color'                => '',
        'top_bar_dark_text_color'                   => '',
        'top_bar_light_text_color'                  => '',
        'top_bar_accent_text_color'                 => '',
        'top_bar_border_color'                      => '#121c22',
        'top_bar_border_hover_color'                => '#43413e',
        'top_bar_background_color'                  => '',
        'top_bar_background_alter_color'            => '',
        'top_bar_button_text_color'                 => '',
        'top_bar_button_border_color'               => '',
        'top_bar_button_background_color'           => '',
        'top_bar_button_text_hover'                 => '',
        'top_bar_button_border_hover'               => '',
        'top_bar_button_background_hover'           => '',

        # Top Bar Social Buttons
        'top_bar_socials_status'                    => 'off',

        # Top Bar Additional Text
        'top_bar_additional_text_status'            => 'off',
        'top_bar_additional_text'                   => '',
        'top_bar_additional_text_title'             => '',

        # Top Bar Contacts
        'top_bar_contacts_email_status'             => 'off',
        'top_bar_contacts_email_title'              => esc_html__('Mail us:', 'industrium'),
        'top_bar_contacts_email'                    => '',
        'top_bar_contacts_phone_status'             => 'off',
        'top_bar_contacts_phone_title'              => esc_html__('Call us:', 'industrium'),
        'top_bar_contacts_phone'                    => '',
        'top_bar_contacts_address_status'           => 'off',
        'top_bar_contacts_address_title'            => esc_html__('Address:', 'industrium'),
        'top_bar_contacts_address'                  => '',

        # Top Bar Menu
        'top_bar_menu_status'                       => 'on',
        'top_bar_menu_select'                       => '',

    # Header Settings
        #General
        'header_status'                             => 'on',
        'header_style'                              => 'type-1',
        'header_position'                           => 'above',
        'header_customize'                          => 'on',
        'header_default_text_color'                 => '',
        'header_dark_text_color'                    => '#1f2531',
        'header_light_text_color'                   => '#818181',
        'header_accent_text_color'                  => '',
        'header_border_color'                       => '#d3d3d3',
        'header_border_hover_color'                 => '',
        'header_background_color'                   => '',
        'header_background_alter_color'             => '',
        'header_button_text_color'                  => '',
        'header_button_border_color'                => '',
        'header_button_background_color'            => '',
        'header_button_text_hover'                  => '#17262f',
        'header_button_border_hover'                => '#17262f',
        'header_button_background_hover'            => '',

        # Sticky Header
        'sticky_header_status'                      => 'off',

        # Mobile Header
        'mobile_header_breakpoint'                  => '1365',

        # Header Logo
        'header_logo_status'                        => 'on',
        'header_logo_customize'                     => 'off',
        'header_logo_image'                         => '',
        'header_logo_retina'                        => false,
        'header_logo_mobile_image'                  => '',
        'header_logo_mobile_retina'                 => false,

        # Header Button
        'header_button_status'                      => 'off',
        'header_button_text'                        => esc_html__('Get In Touch', 'industrium'),
        'header_button_url'                         => '#',

        # Header Menu
        'header_menu_status'                        => 'on',
        'header_menu_dots'                          => 'dots',
        'header_menu_select'                        => 'default',
        'header_menu_customize'                     => 'on',
        'header_menu_font'                          => '{"font_family":"Manrope","font_backup":"Arial, Helvetica, sans-serif","font_styles":"500","font_subset":"latin","font_size":"16","font_size_unit":"px","line_height":"1.875","line_height_unit":"em","text_transform":"none","letter_spacing":"0","letter_spacing_unit":"em","word_spacing":"0","word_spacing_unit":"px","font_style":"normal","font_weight":"500"}',
        'header_sub_menu_font'                      => '{"font_family":"Manrope","font_backup":"Arial, Helvetica, sans-serif","font_styles":"500","font_subset":"latin","font_size":"16","font_size_unit":"px","line_height":"1","line_height_unit":"em","text_transform":"none","letter_spacing":"0","letter_spacing_unit":"em","word_spacing":"0","word_spacing_unit":"px","font_style":"normal","font_weight":"500"}',

        # Header Callback
        'header_callback_status'                    => 'off',
        'header_callback_title'                     => '',
        'header_callback_text'                      => '',
        'header_callback_link'                      => '',

        # Header Side Panel
        'side_panel_status'                         => 'off',

        # Header Search
        'header_search_status'                      => 'on',

        # Header Minicart
        'header_minicart_status'                    => 'off',

        # Header Login/Logout
        'header_login_status'                       => 'off',

    # Page Title
        # General
        'page_title_status'                         => 'on',
        'page_title_overlay_status'                 => 'off',
        'page_title_overlay_color'                  => '',
        'page_title_customize'                      => 'on',
        'page_title_height'                         => '480',
        'page_title_default_text_color'             => '',
        'page_title_dark_text_color'                => '',
        'page_title_light_text_color'               => '',
        'page_title_accent_text_color'              => '',
        'page_title_border_color'                   => '',
        'page_title_border_hover_color'             => '',
        'page_title_background_color'               => '',
        'page_title_background_alter_color'         => '',
        'page_title_button_text_color'              => '',
        'page_title_button_border_color'            => '',
        'page_title_button_background_color'        => '',
        'page_title_button_text_hover'              => '',
        'page_title_button_border_hover'            => '',
        'page_title_button_background_hover'        => '',
        'page_title_background_image'               => '',
        'page_title_background_position'            => 'center center',
        'page_title_background_repeat'              => 'no-repeat',
        'page_title_background_size'                => 'cover',
        'hide_page_title_background_mobile'         => false,
        'hide_page_title_background_tablet'         => false,
        'page_title_decoration_status'              => 'off',

        # Heading
        'page_title_heading_customize'              => 'off',
        'page_title_heading_icon_status'            => 'off',
        'page_title_heading_icon_image'             => '',
        'page_title_heading_icon_retina'            => true,
        'page_title_heading_font'                   => '{"font_family":"Manrope","font_backup":"Arial, Helvetica, sans-serif","font_styles":"700","font_subset":"latin","font_size":"60","font_size_unit":"px","line_height":"1.2","line_height_unit":"em","text_transform":"none","letter_spacing":"-0.03","letter_spacing_unit":"em","word_spacing":"0","word_spacing_unit":"px","font_style":"normal","font_weight":"700"}',

        # Breadcrumbs
        'page_title_breadcrumbs_status'             => 'off',
        'page_title_breadcrumbs_customize'          => 'off',
        'page_title_breadcrumbs_font'               => '{"font_family":"Manrope","font_backup":"Arial, Helvetica, sans-serif","font_styles":"400","font_subset":"latin","font_size":"16","font_size_unit":"px","line_height":"30","line_height_unit":"px","text_transform":"none","letter_spacing":"0","letter_spacing_unit":"em","word_spacing":"0","word_spacing_unit":"px","font_style":"normal","font_weight":"400"}',

        # Additional
        'page_title_additional_text'                => '',
        'page_title_additional_customize'           => 'off',
        'page_title_additional_text_color'          => '',

    # Typography
        # Main Font
        'main_font'                                 => '{"font_family":"Manrope","font_backup":"Arial, Helvetica, sans-serif","font_styles":"400,500,600,700,800","font_subset":"latin","font_size":"18","font_size_unit":"px","line_height":"1.777","line_height_unit":"em","text_transform":"none","letter_spacing":"0","letter_spacing_unit":"em","word_spacing":"0","word_spacing_unit":"px","font_style":"normal","font_weight":"400"}',

        # Additional Font
        'additional_font'                           => '{"font_family":"Manrope","font_backup":"Arial, Helvetica, sans-serif","font_styles":"400","font_subset":"latin","font_size":"16","font_size_unit":"px","line_height":"1.875","line_height_unit":"em","text_transform":"none","letter_spacing":"0","letter_spacing_unit":"em","word_spacing":"0","word_spacing_unit":"px","font_style":"normal","font_weight":"400"}',

        # Headings
        'headings_font'                             => '{"font_family":"Manrope","font_backup":"Arial, Helvetica, sans-serif","font_styles":"700,800","font_subset":"latin","text_transform":"none","font_style":"normal"}',
        'h1_font'                                   => '{"font_size":"60","font_size_unit":"px","line_height":"1.1","line_height_unit":"em","letter_spacing":"-0.03","letter_spacing_unit":"em","word_spacing":"0","word_spacing_unit":"px","font_weight":"700"}',
        'h2_font'                                   => '{"font_size":"45","font_size_unit":"px","line_height":"1.2","line_height_unit":"em","letter_spacing":"-0.03","letter_spacing_unit":"em","word_spacing":"0","word_spacing_unit":"px","font_weight":"700"}',
        'h3_font'                                   => '{"font_size":"30","font_size_unit":"px","line_height":"1.3","line_height_unit":"em","font_weight":"700"}',
        'h4_font'                                   => '{"font_size":"25","font_size_unit":"px","line_height":"1.3","line_height_unit":"em","letter_spacing":"-0.03","letter_spacing_unit":"em","word_spacing":"0","word_spacing_unit":"px","font_weight":"700"}',
        'h5_font'                                   => '{"font_size":"20","font_size_unit":"px","line_height":"1.4","line_height_unit":"em","letter_spacing":"-0.03","letter_spacing_unit":"em","word_spacing":"0","word_spacing_unit":"px","font_weight":"700"}',
        'h6_font'                                   => '{"font_size":"18","font_size_unit":"px","line_height":"1.5","line_height_unit":"em","letter_spacing":"-0.03","letter_spacing_unit":"em","word_spacing":"0","word_spacing_unit":"px","font_weight":"700"}',

        # Buttons
        'buttons_font'                              => '{"font_family":"Manrope","font_backup":"Arial, Helvetica, sans-serif","font_styles":"500","font_subset":"latin","font_size":"14","font_size_unit":"px","text_transform":"uppercase","letter_spacing":"0","letter_spacing_unit":"em","word_spacing":"0","word_spacing_unit":"px","font_style":"normal","font_weight":"500"}',

    # Social Links
        'socials_target'                            => true,
        'social_buttons'                            => '',

    # Color Options
        # Standard colors
        'standard_default_text_color'               => '#4a5257',
        'standard_dark_text_color'                  => '#17262f',
        'standard_light_text_color'                 => '#abafb5',
        'standard_accent_text_color'                => '#e66445',
        'standard_border_color'                     => '#d3d3d3',
        'standard_border_hover_color'               => '#3a3a3a',
        'standard_background_color'                 => '#ffffff',
        'standard_background_alter_color'           => '#e1e6e9',
        'standard_button_text_color'                => '#e66445',
        'standard_button_border_color'              => '#e66445',
        'standard_button_background_color'          => 'rgba(255,255,255,0)',
        'standard_button_text_hover'                => '#e66445',
        'standard_button_border_hover'              => '#e66445',
        'standard_button_background_hover'          => 'rgba(255,255,255,0)',

        # Contrast colors
        'contrast_default_text_color'               => '#e0e1e4',
        'contrast_dark_text_color'                  => '#ffffff',
        'contrast_light_text_color'                 => '#abafb5',
        'contrast_accent_text_color'                => '#e66445',
        'contrast_border_color'                     => '#4a4f56',
        'contrast_border_hover_color'               => '#abafb5',
        'contrast_background_color'                 => '#121c22',
        'contrast_background_alter_color'           => '#222628',
        'contrast_button_text_color'                => '#e66445',
        'contrast_button_border_color'              => '#e66445',
        'contrast_button_background_color'          => 'rgba(255,255,255,0)',
        'contrast_button_text_hover'                => '#e66445',
        'contrast_button_border_hover'              => '#e66445',
        'contrast_button_background_hover'          => 'rgba(255,255,255,0)',

    # Footer
        # General
        'footer_status'                             => 'on',
        'footer_style'                              => 'type-1',
        'footer_customize'                          => 'off',
        'footer_default_text_color'                 => '',
        'footer_dark_text_color'                    => '',
        'footer_light_text_color'                   => '',
        'footer_accent_text_color'                  => '',
        'footer_border_color'                       => '',
        'footer_border_hover_color'                 => '',
        'footer_background_color'                   => '',
        'footer_background_alter_color'             => '',
        'footer_button_text_color'                  => '',
        'footer_button_border_color'                => '',
        'footer_button_background_color'            => '',
        'footer_button_text_hover'                  => '',
        'footer_button_border_hover'                => '',
        'footer_button_background_hover'            => '',
        'footer_background_image'                   => '',
        'footer_background_position'                => 'center center',
        'footer_background_repeat'                  => 'no-repeat',
        'footer_background_size'                    => 'cover',

        #Footer Logo
        'footer_logo_status'                        => 'off',
        'footer_logo_customize'                     => 'off',
        'footer_logo_image'                         => '',
        'footer_logo_retina'                        => false,

        # Footer Widgets
        'footer_sidebar_top_status'                 => 'off',
        'footer_sidebar_top_select'                 => 'sidebar-footer-top',
        'footer_sidebar_status'                     => 'on',
        'footer_sidebar_select'                     => 'sidebar-footer-style1',

        # Copyright
        'footer_copyright_status'                   => 'on',
        'footer_copyright_text'                     => esc_html__('2022 Industrium. All Rights reserved by Artureanec', 'industrium'),

        # Special Text
        'footer_special_text_status'                => 'off',
        'footer_special_text'                       => esc_html__('since 1980', 'industrium'),

        # Footer Menu
        'footer_menu_status'                        => 'on',
        'footer_menu_select'                        => '',

        # Footer Additional Menu
        'footer_additional_menu_status'             => 'on',
        'footer_additional_menu_select'             => '',

        #Footer Decoration
        'footer_decoration_status'                  => 'off',

        #Footer Scroll To Top
        'footer_scrolltop_status'                  => 'off',
        'footer_scrolltop_bg_color'                  => '',
        'footer_scrolltop_color'                  => '',

    # Sidebars
        'sidebar_position'                          => 'right',
        'archive_sidebar_position'                  => 'none',
        'post_sidebar_position'                     => 'right',
        'vacancy_sidebar_position'                  => 'left',
        'service_sidebar_position'                  => 'right',
        'catalog_sidebar_position'                  => 'right',

    #Sidebar Logo
        'sidebar_logo_status'                        => 'off',
        'sidebar_logo_customize'                     => 'off',
        'sidebar_logo_image'                         => '',
        'sidebar_logo_retina'                        => false,

    # Single Post
        # Post Settings
        'post_page_title'                           => esc_html__('%\s', 'industrium'),
        'post_media_image_status'                   => 'on',
        'post_category_status'                      => 'on',
        'post_date_status'                          => 'on',
        'post_author_status'                        => 'on',
        'post_title_status'                         => 'off',
        'post_tags_status'                          => 'on',
        'post_socials_status'                       => 'off',

        # Recent Posts Settings
        'recent_posts_status'                       => 'off',
        'recent_posts_customize'                    => 'off',
        'recent_posts_section_heading'              => esc_html__('Recent Posts', 'industrium'),
        'recent_posts_number'                       => '3',
        'recent_posts_order_by'                     => 'random',
        'recent_posts_order'                        => 'desc',
        'recent_posts_image'                        => 'on',
        'recent_posts_category'                     => 'on',
        'recent_posts_date'                         => 'on',
        'recent_posts_author'                       => 'on',
        'recent_posts_title'                        => 'on',
        'recent_posts_excerpt'                      => 'off',
        'recent_posts_excerpt_length'               => '120',
        'recent_posts_tags'                         => 'off',
        'recent_posts_more'                         => 'on',

    # Portfolio
        # Archive
        'portfolio_archive_page_title'              => esc_html__('Portfolios', 'industrium'),
        'portfolio_archive_columns_number'          => 3,
        'portfolio_archive_posts_per_page'          => 9,

        # Single
        'portfolio_single_page_title'               => esc_html__('Portfolio', 'industrium'),
        'portfolio_single_page_next_button'         => esc_html__('Next post', 'industrium'),
        'portfolio_single_page_prev_button'         => esc_html__('Prev post', 'industrium'),

    # Projects
        # Archive
        'project_archive_page_title'                => esc_html__('Projects', 'industrium'),
        'project_archive_columns_number'            => 3,
        'project_archive_posts_per_page'            => 9,

        # Single
        'project_single_page_title'                 => esc_html__('Project Details', 'industrium'),
        'project_single_page_next_button'           => esc_html__('Next projects', 'industrium'),
        'project_single_page_prev_button'           => esc_html__('Prev projects', 'industrium'),

    # Case Studies
        # Archive
        'case_studies_archive_page_title'           => esc_html__('Case Studies', 'industrium'),
        'case_studies_archive_excerpt_length'       => 83,
        'case_studies_archive_columns_number'       => 3,
        'case_studies_archive_posts_per_page'       => 9,

        #Single
        'case_studies_single_page_title'            => esc_html__('Case Study Details', 'industrium'),

    # Team
        # Archive
        'team_archive_page_title'                   => esc_html__('Team', 'industrium'),
        'team_archive_columns_number'               => 4,
        'team_archive_posts_per_page'               => 12,

        # Single
        'team_single_page_title'                    => esc_html__('Team Single', 'industrium'),

    # Vacancies
        # Archive
        'vacancy_archive_page_title'                => esc_html__('Career', 'industrium'),
        'vacancy_archive_excerpt_length'            => 195,
        'vacancy_archive_posts_per_page'            => 5,

        # Single
        'vacancy_single_page_title'                 => esc_html__('Careers Details', 'industrium'),
        'recent_vacancies_status'                   => 'on',
        'recent_vacancies_customize'                => 'off',
        'recent_vacancies_section_heading'          => esc_html__('Recent Careers', 'industrium'),
        'recent_vacancies_number'                   => 3,
        'recent_vacancies_order_by'                 => 'date',
        'recent_vacancies_order'                    => 'desc',

    # Services
        # Archive
        'service_archive_page_title'                => esc_html__('Services', 'industrium'),
        'service_archive_excerpt_length'            => 50,
        'service_archive_columns_number'            => 3,
        'service_archive_posts_per_page'            => 9,

        # Single
        'service_single_page_title'                 => esc_html__('Services Details', 'industrium'),

    # 404 Error Page
        'error_main_image'                          => '',
        'error_title'                               => esc_html__("Oops! Page not found!", 'industrium'),
        'error_text'                                => esc_html__("Bullhead shark sillago darter riffle dace. Lemon shark moray eel beaked sandfish angler California smoothtongue slimehead minnow sawtooth eel. Bonnetmouth frogmouth catfish eulachon minnow. ", 'industrium'),
        'error_title_color'                         => '',
        'error_text_color'                          => '',
        'error_logo_status'                         => 'on',
        'error_logo_image'                          => '',
        'error_socials_status'                      => 'on',
        'error_button_status'                       => 'on',
        'error_button_text'                         => esc_html__('Home Page', 'industrium'),
        'error_background_customize'                => 'on',
        'error_background_color'                    => '',
        'error_background_image'                    => get_template_directory_uri() . '/img/404.png',
        'error_background_position'                 => 'center center',
        'error_background_repeat'                   => 'no-repeat',
        'error_background_size'                     => 'cover',

    # WooCommerce
        'woo_single_product_show_related_section'   => 'on',
        'woo_related_subtitle'                      => esc_html__('Best products', 'industrium'),
        'woo_related_title'                         => esc_html__('Best Sellers Products', 'industrium'),
        'woo_single_product_title'                  => esc_html__('%\s', 'industrium'),
        'woo_single_product_show_name'              => false,
        'woo_upsells_title'                         => esc_html__('Up-Sells Products', 'industrium'),
        'woo_product_categories_title'              => esc_html__('Shop Category: %\s', 'industrium'),
        'woo_product_tags_title'                    => esc_html__('Product Tag: %\s', 'industrium')
);
