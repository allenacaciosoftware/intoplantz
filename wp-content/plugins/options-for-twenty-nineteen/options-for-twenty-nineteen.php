<?php
/*
 * Plugin Name: Options for Twenty Nineteen
 * Version: 1.4.6
 * Plugin URI: https://webd.uk/product/options-for-twenty-nineteen-upgrade/
 * Description: Adds powerful customizer options to modify all aspects of the default Wordpress theme Twenty Nineteen
 * Author: Webd Ltd
 * Author URI: https://webd.uk
 * Text Domain: options-for-twenty-nineteen
 */



if (!defined('ABSPATH')) {
    exit('This isn\'t the page you\'re looking for. Move along, move along.');
}



if (!class_exists('options_for_twenty_nineteen_class')) {

	class options_for_twenty_nineteen_class {

        public static $version = '1.4.6';

        public $oftn_archive_description_shown;

		function __construct() {

            $this->oftn_archive_description_shown = false;

            add_action('customize_register', array($this, 'oftn_customize_register'), 999);
            add_action('wp_head' , array($this, 'oftn_header_output'));
            add_action('customize_controls_enqueue_scripts', array($this, 'oftn_enqueue_customizer_css'));
            add_action('customize_preview_init', array($this, 'oftn_enqueue_customize_preview_js'));
            add_action('customize_controls_enqueue_scripts', array($this, 'oftn_enqueue_customize_controls_js'));
            add_action('after_setup_theme', array($this, 'oftn_add_theme_support'), 11);

            if (is_admin()) {

                add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'oftn_add_plugin_action_links'));
                add_action('admin_notices', 'oftnCommon::admin_notices');
                add_action('wp_ajax_dismiss_oftn_notice_handler', 'oftnCommon::ajax_notice_handler');

            }

		}

		function oftn_add_plugin_action_links($links) {

			$settings_links = oftnCommon::plugin_action_links(admin_url('customize.php'));

			return array_merge($settings_links, $links);

		}

        function oftn_customize_register($wp_customize) {

            $section_description = oftnCommon::control_section_description();
            $upgrade_nag = oftnCommon::control_setting_upgrade_nag();



            $wp_customize->add_section('oftn_general', array(
                'title'     => __('General Options', 'options-for-twenty-nineteen'),
                'description'  => __('Use these options to customise the overall site design.', 'options-for-twenty-nineteen') . ' ' . $section_description,
                'priority'     => 0
            ));



            $wp_customize->add_setting('body_font_size', array(
                'default'       => '1000',
                'type'          => 'theme_mod',
                'transport'     => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('body_font_size', array(
                'label'         => __('Font Size', 'options-for-twenty-nineteen'),
                'description'   => __('Set the default base font size.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_general',
                'settings'      => 'body_font_size',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 500,
                    'max'   => 2000,
                    'step'  => 25
                )
            ));

            $wp_customize->add_setting('mobile_font_size', array(
                'default'       => '100',
                'type'          => 'theme_mod',
                'transport'     => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('mobile_font_size', array(
                'label'         => __('Mobile Font Size', 'options-for-twenty-nineteen'),
                'description'   => __('Set the font size on small screens (less than 768px wide) as a percentage of the font size above.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_general',
                'settings'      => 'mobile_font_size',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 100,
                    'step'  => 1
                )
            ));

            $wp_customize->add_setting('tablet_font_size', array(
                'default'       => '100',
                'type'          => 'theme_mod',
                'transport'     => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('tablet_font_size', array(
                'label'         => __('Tablet Font Size', 'options-for-twenty-nineteen'),
                'description'   => __('Set the font size on medium screens (between 768px and 1168px wide) as a percentage of the font size above.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_general',
                'settings'      => 'tablet_font_size',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 100,
                    'step'  => 1
                )
            ));

            $wp_customize->add_setting('hide_dashes', array(
                'default'           => false,
                'type'              => 'theme_mod',
                'transport'         => 'refresh',
                'sanitize_callback' => 'oftnCommon::sanitize_boolean'
            ));
            $wp_customize->add_control('hide_dashes', array(
                'label'         => __('Hide Dashes', 'options-for-twenty-nineteen'),
                'description'   => __('Hide the dashes that appear through the theme.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_general',
                'settings'      => 'hide_dashes',
                'type'          => 'checkbox'
            ));



            $wp_customize->add_section('oftn_header', array(
                'title'     => __('Header Options', 'options-for-twenty-nineteen'),
                'description'  => __('Use these options to customise the header.', 'options-for-twenty-nineteen') . ' ' . $section_description,
                'priority'     => 0
            ));



            $wp_customize->add_setting('logo_width', array(
                'default'       => '64',
                'type'          => 'theme_mod',
                'transport'     => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('logo_width', array(
                'label'         => __('Logo Width', 'options-for-twenty-nineteen'),
                'description'   => __('Set the width of the logo on large screens.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_header',
                'settings'      => 'logo_width',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 190,
                    'step'  => 1
                )
            ));

            $wp_customize->add_setting('remove_logo_background', array(
                'default'           => false,
                'type'              => 'theme_mod',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'oftnCommon::sanitize_boolean'
            ));
            $wp_customize->add_control('remove_logo_background', array(
                'label'         => __('Remove Logo Background', 'options-for-twenty-nineteen'),
                'description'   => __('Remove the white background from the logo.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_header',
                'settings'      => 'remove_logo_background',
                'type'          => 'checkbox'
            ));

            $wp_customize->add_setting('site_title_align', array(
                'default'       => '',
                'type'          => 'theme_mod',
                'transport'     => 'postMessage',
                'sanitize_callback' => array($this, 'oftn_sanitize_slug_options')
            ));
            $wp_customize->add_control('site_title_align', array(
                'label'         => __('Site Title Alignment', 'options-for-twenty-nineteen'),
                'description'   => __('Align the site title to the left, center or right.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_header',
                'settings'      => 'site_title_align',
                'type'          => 'select',
                'choices'       => array(
                    '' => __('Left', 'options-for-twenty-nineteen'),
                    'center' => __('Center', 'options-for-twenty-nineteen'),
                    'right' => __('Right', 'options-for-twenty-nineteen')
                )
            ));

            $wp_customize->add_setting('site_description_align', array(
                'default'       => '',
                'type'          => 'theme_mod',
                'transport'     => 'postMessage',
                'sanitize_callback' => array($this, 'oftn_sanitize_slug_options')
            ));
            $wp_customize->add_control('site_description_align', array(
                'label'         => __('Site Description Alignment', 'options-for-twenty-nineteen'),
                'description'   => __('Align the site description to the left, center or right.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_header',
                'settings'      => 'site_description_align',
                'type'          => 'select',
                'choices'       => array(
                    '' => __('Left', 'options-for-twenty-nineteen'),
                    'center' => __('Center', 'options-for-twenty-nineteen'),
                    'right' => __('Right', 'options-for-twenty-nineteen')
                )
            ));



            $wp_customize->add_section('oftn_navigation', array(
                'title'        => __('Nav Options', 'options-for-twenty-nineteen'),
                'description'  => __('Use these options to customise the navigation.', 'options-for-twenty-nineteen') . ' ' . $section_description,
                'priority'     => 0
            ));



            $wp_customize->add_setting('navigation_font_size', array(
                'default'           => 1125,
                'type'              => 'theme_mod',
                'transport'         => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('navigation_font_size', array(
                'label'         => __('Navigation Font Size', 'options-for-twenty-nineteen'),
                'description'   => __('Change the font size of the primary navigation menu.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_navigation',
                'settings'      => 'navigation_font_size',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 550,
                    'max'   => 2250,
                    'step'  => 25
                ),
            ));

            $wp_customize->add_setting('sub_nav_font_size', array(
                'default'           => 1125,
                'type'              => 'theme_mod',
                'transport'         => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('sub_nav_font_size', array(
                'label'         => __('Sub Nav Font Size', 'options-for-twenty-nineteen'),
                'description'   => __('Change the font size of the child menu items in the primary navigation menu.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_navigation',
                'settings'      => 'sub_nav_font_size',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 550,
                    'max'   => 2250,
                    'step'  => 25
                ),
            ));

            $wp_customize->add_setting('sub_sub_nav_font_size', array(
                'default'           => 1125,
                'type'              => 'theme_mod',
                'transport'         => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('sub_sub_nav_font_size', array(
                'label'         => __('Sub Sub Nav Font Size', 'options-for-twenty-nineteen'),
                'description'   => __('Change the font size of the grandchild menu items in the primary navigation menu.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_navigation',
                'settings'      => 'sub_sub_nav_font_size',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 550,
                    'max'   => 2250,
                    'step'  => 25
                ),
            ));



            $wp_customize->add_section('oftn_content', array(
                'title'     => __('Content Options', 'options-for-twenty-nineteen'),
                'description'  => __('Use these options to customise the content.', 'options-for-twenty-nineteen') . ' ' . $section_description,
                'priority'     => 0
            ));



            $wp_customize->add_setting('page_title_font_weight', array(
                'default'           => 700,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('page_title_font_weight', array(
                'label'         => __('Page Title Font Weight', 'options-for-twenty-nineteen'),
                'description'   => __('Change the font weight of page titles.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_content',
                'settings'      => 'page_title_font_weight',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 100,
                    'max'   => 900,
                    'step'  => 100
                )
            ));

            $wp_customize->add_setting('page_title_text_transform', array(
                'default'       => '',
                'transport'     => 'postMessage',
                'sanitize_callback' => 'oftnCommon::sanitize_options'
            ));
            $wp_customize->add_control('page_title_text_transform', array(
                'label'         => __('Page Title Font Case', 'options-for-twenty-nineteen'),
                'description'   => __('Change the font case of page titles.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_content',
                'settings'      => 'page_title_text_transform',
                'type'          => 'select',
                'choices'       => array(
                    '' => __('None (Default)', 'options-for-twenty-nineteen'),
                    'capitalize' => __('Capitalise', 'options-for-twenty-nineteen'),
                    'uppercase' => __('Uppercase', 'options-for-twenty-nineteen'),
                    'lowercase' => __('Lowercase', 'options-for-twenty-nineteen')
                )
            ));

            $wp_customize->add_setting('post_meta_location', array(
                'default'       => '',
                'type'          => 'theme_mod',
                'transport'     => 'postMessage',
                'sanitize_callback' => array($this, 'oftn_sanitize_slug_options')
            ));
            $wp_customize->add_control('post_meta_location', array(
                'label'         => __('Post Date / Author Location', 'options-for-twenty-nineteen'),
                'description'   => __('Sets the postion of the post date and author line.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_content',
                'settings'      => 'post_meta_location',
                'type'          => 'select',
                'choices'       => array(
                    'none' => __('None', 'options-for-twenty-nineteen'),
                    'above' => __('Above post content', 'options-for-twenty-nineteen'),
                    'below' => __('Below post content', 'options-for-twenty-nineteen'),
                    '' => __('Above and below', 'options-for-twenty-nineteen')
                )
            ));

            $wp_customize->add_setting('remove_posted_on', array(
                'default'           => false,
                'type'              => 'theme_mod',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'oftnCommon::sanitize_boolean'
            ));
            $wp_customize->add_control('remove_posted_on', array(
                'label'         => __('Hide Post Dates', 'options-for-twenty-nineteen'),
                'description'   => __('Prevents Wordpress from displaying the date of a post.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_content',
                'settings'      => 'remove_posted_on',
                'type'          => 'checkbox'
            ));

            $wp_customize->add_setting('remove_author', array(
                'default'           => false,
                'type'              => 'theme_mod',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'oftnCommon::sanitize_boolean'
            ));
            $wp_customize->add_control('remove_author', array(
                'label'         => __('Hide Post Author', 'options-for-twenty-nineteen'),
                'description'   => __('Hides the author of a post in the browser.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_content',
                'settings'      => 'remove_author',
                'type'          => 'checkbox'
            ));



            $wp_customize->add_section('oftn_footer', array(
                'title'     => __('Footer Options', 'options-for-twenty-nineteen'),
                'description'  => __('Use these options to customise the footer.', 'options-for-twenty-nineteen') . ' ' . $section_description,
                'priority'     => 0
            ));



            $wp_customize->add_setting('footer_background_color', array(
                'default'       => '',
                'type'          => 'theme_mod',
                'transport'     => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_background_color', array(
                'label'         => __('Footer Background Color', 'options-for-twenty-nineteen'),
                'description'   => __('Choose a backgroud color for the footer.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_footer',
            	'settings'      => 'footer_background_color'
            )));

            $wp_customize->add_setting('remove_powered_by_wordpress', array(
                'default'       => false,
                'type'          => 'theme_mod',
                'transport'     => 'refresh',
                'sanitize_callback' => 'oftnCommon::sanitize_boolean'
            ));
            $wp_customize->add_control('remove_powered_by_wordpress', array(
                'label'         => __('Remove Powered by WordPress', 'options-for-twenty-nineteen'),
                'description'   => __('Removes the "Proudly powered by WordPress" text displayed in the website footer.', 'options-for-twenty-nineteen'),
                'section'       => 'oftn_footer',
                'settings'      => 'remove_powered_by_wordpress',
                'type'          => 'checkbox'
            ));



            $wp_customize->add_setting('body_background_color', array(
                'default'       => '#ffffff',
                'type'          => 'theme_mod',
                'transport'     => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'body_background_color', array(
                'label'         => __('Background Color', 'options-for-twenty-nineteen'),
                'description'   => __('Change the site\'s background color.', 'options-for-twenty-nineteen'),
                'section'       => 'colors',
            	'settings'      => 'body_background_color'
            )));

            $wp_customize->add_setting('hex_primary_color', array(
                'default'       => '',
                'type'          => 'theme_mod',
                'transport'     => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hex_primary_color', array(
                'label'         => __('Hex Primary Color', 'options-for-twenty-nineteen'),
                'description'   => __('Set the hue, saturation and lightness of the primary color using a HEX control.', 'options-for-twenty-nineteen'),
                'section'       => 'colors',
            	'settings'      => 'hex_primary_color'
            )));

            $wp_customize->add_setting('opacity_level', array(
                'default'       => '71',
                'type'          => 'theme_mod',
                'transport'     => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('opacity_level', array(
                'label'         => __('Opacity Level', 'options-for-twenty-nineteen'),
                'description'   => __('Adjust the default opacity level on featured images when not using the filter.', 'options-for-twenty-nineteen'),
                'section'       => 'colors',
                'settings'      => 'opacity_level',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 101,
                    'step'  => 1
                )
            ));

            $wp_customize->add_setting('saturation_level', array(
                'default'       => '101',
                'type'          => 'theme_mod',
                'transport'     => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('saturation_level', array(
                'label'         => __('Saturation Level', 'options-for-twenty-nineteen'),
                'description'   => __('Adjust the default saturation level.', 'options-for-twenty-nineteen'),
                'section'       => 'colors',
                'settings'      => 'saturation_level',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 101,
                    'step'  => 1
                )
            ));

            $wp_customize->add_setting('lightness_level', array(
                'default'       => '34',
                'type'          => 'theme_mod',
                'transport'     => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('lightness_level', array(
                'label'         => __('Lightness Level', 'options-for-twenty-nineteen'),
                'description'   => __('Adjust the default lightness level.', 'options-for-twenty-nineteen'),
                'section'       => 'colors',
                'settings'      => 'lightness_level',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 101,
                    'step'  => 1
                )
            ));

            $wp_customize->add_setting('hover_lightness_level', array(
                'default'       => '24',
                'type'          => 'theme_mod',
                'transport'     => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('hover_lightness_level', array(
                'label'         => __('Hover Lightness Level', 'options-for-twenty-nineteen'),
                'description'   => __('Adjust the default hover lightness level.', 'options-for-twenty-nineteen'),
                'section'       => 'colors',
                'settings'      => 'hover_lightness_level',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 101,
                    'step'  => 1
                )
            ));

            $wp_customize->add_setting('selection_saturation_level', array(
                'default'       => '51',
                'type'          => 'theme_mod',
                'transport'     => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('selection_saturation_level', array(
                'label'         => __('Selection Saturation Level', 'options-for-twenty-nineteen'),
                'description'   => __('Adjust the default selection saturation level.', 'options-for-twenty-nineteen'),
                'section'       => 'colors',
                'settings'      => 'selection_saturation_level',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 101,
                    'step'  => 1
                )
            ));

            $wp_customize->add_setting('selection_lightness_level', array(
                'default'       => '91',
                'type'          => 'theme_mod',
                'transport'     => 'refresh',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('selection_lightness_level', array(
                'label'         => __('Selection Lightness Level', 'options-for-twenty-nineteen'),
                'description'   => __('Adjust the default selection lightness level.', 'options-for-twenty-nineteen'),
                'section'       => 'colors',
                'settings'      => 'selection_lightness_level',
                'type'          => 'range',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 101,
                    'step'  => 1
                )
            ));

            $control_label = __('Show Featured Image on Posts Page', 'options-for-twenty-nineteen');
            $control_description = __('Show the featured image selected on the page chosen to be the posts page.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'show_featured_image_on_posts_page', 'oftn_header', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Show Title on Posts Page', 'options-for-twenty-nineteen');
            $control_description = __('Show the page title on the page chosen to be the posts page.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'show_title_on_pasts_page', 'oftn_header', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Move Logo Above Title', 'options-for-twenty-nineteen');
            $control_description = __('Repositions the logo above the site title. This option will override the above setting and show the full size logo.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'reposition_logo', 'oftn_header', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Logo Alignment', 'options-for-twenty-nineteen');
            $control_description = __('Align the logo to the left, center or right. For use with the above option only.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'logo_align', 'oftn_header', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Remove Logo Circle Mask', 'options-for-twenty-nineteen');
            $control_description = __('Removes the circle effect and allows the logo to be its own shape.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'remove_logo_border_radius', 'oftn_header', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Hide Site Title', 'options-for-twenty-nineteen');
            $control_description = __('Hides the site title.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'hide_site_title', 'oftn_header', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Hide Site Description', 'options-for-twenty-nineteen');
            $control_description = __('Hides the site description.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'hide_site_description', 'oftn_header', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Scroll to Content Arrow', 'options-for-twenty-nineteen');
            $control_description = __('Show an arrow to scroll to the main content in the header.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'scroll_to_content', 'oftn_header', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Bounce Scroll to Content Arrow', 'options-for-twenty-nineteen');
            $control_description = __('Animates the scroll down arrow in the header.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'bounce_scroll_to_content_arrow', 'oftn_header', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Scroll to Content Dashicon', 'options-for-twenty-nineteen');
            $control_description = sprintf(wp_kses(__('Choose your own <a href="%s">dashicon</a> for the arrow that scrolls to the main content.', 'options-for-twenty-nineteen'), array('a' => array('href' => array()))), esc_url('https://developer.wordpress.org/resource/dashicons/'));

            oftnCommon::add_hidden_control($wp_customize, 'scroll_to_content_dashicon', 'oftn_header', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Implement Yoast SEO Breadcrumbs', 'options-for-twenty-nineteen');

            $query_args = array(
                's' => 'wordpress-seo',
                'tab' => 'search',
                'type' => 'term'
            );

            $control_description = sprintf(wp_kses(__('Inject <a href="%s">Yoast SEO</a> breadcrumbs above and / or below single post and page content.', 'options-for-twenty-nineteen'), array('a' => array('href' => array()))), esc_url(add_query_arg($query_args, admin_url('plugin-install.php'))));

            oftnCommon::add_hidden_control($wp_customize, 'implement_yoast_breadcrumbs', 'oftn_content', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Show Archive Description', 'options-for-twenty-nineteen');
            $control_description = __('Show the tag or category description on archive pages.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'show_archive_description', 'oftn_content', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Show Full Content in Archive', 'options-for-twenty-nineteen');
            $control_description = __('Show the full post content rather than an excerpt in archive pages.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'show_full_content_in_archive', 'oftn_content', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Activate Jetpack Infinite Scroll', 'options-for-twenty-nineteen');
            $control_description = __('Turns on infinite scroll when using Jetpack, remember not to use footer widgets as they won\'t be accessible.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'infinite_scroll', 'oftn_content', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Replace "Powered by" Text', 'options-for-twenty-nineteen');
            $control_description = __('Provide alternate text to replace "Proudly powered by Wordpress".', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'replace_powered_by_wordpress', 'oftn_footer', $control_label, $control_description . ' ' . $upgrade_nag);

            $control_label = __('Featured Content Layout', 'options-for-twenty-nineteen');
            $control_description = __('Show the Featured Content as posts or a grid of featured images.', 'options-for-twenty-nineteen');

            oftnCommon::add_hidden_control($wp_customize, 'featured_content_layout', 'featured_content', $control_label, $control_description . ' ' . $upgrade_nag);

        }

        function oftn_sanitize_slug_options($input, $setting) {

            $input =  sanitize_key($input);
            $choices = $setting->manager->get_control($setting->id)->choices;

            return (array_key_exists($input, $choices) ? $input : $setting->default);

        }

        function oftn_sanitize_html($input) {

            return wp_kses_post($input);

        }

        function oftn_header_output() {

            $mobile_font_size = absint(get_theme_mod('mobile_font_size')) / 100;
            $tablet_font_size = absint(get_theme_mod('tablet_font_size')) / 100;

?>
<!--Customizer CSS-->
<style type="text/css">
.site-logo .custom-logo-link {
    height: auto;
}
.site-logo .custom-logo-link .custom-logo {
	display: block;
}
<?php

            oftnCommon::generate_css('body', 'font-size', 'body_font_size', '', 'em', get_theme_mod('body_font_size') / 1000);

            $mod = absint(get_theme_mod('body_font_size')) / 1000;

            if ($mod) {

?>
body {
    font-size: <?php echo $mod; ?>em;
}
<?php

                if ($mobile_font_size) { 

?>
@media only screen and (max-width: 768px) {
	body {
        font-size: <?php echo $mod * $mobile_font_size; ?>em;
    }
}
<?php

                }

                if ($tablet_font_size) { 

?>
@media only screen and (min-width: 768px) and (max-width: 1168px) {
	body {
        font-size: <?php echo $mod * $tablet_font_size; ?>em;
    }
}
<?php

                }

            }

            if (get_theme_mod('hide_dashes')) {

?>
.site-description:before,
h1:not(.site-title):before, h2:before,
.entry .entry-title:before,
.comments-area .comments-title-wrap .comments-title:before,
.post-navigation .nav-links .nav-previous .meta-nav:before {
	display: none;
}
<?php

            }

            $mod = get_theme_mod('logo_width');

            if ($mod) {

?>
@media only screen and (min-width: 768px) {
	.site-logo .custom-logo-link {
        width: <?php echo $mod; ?>px;
    }
}
<?php

            }

            $mod = get_theme_mod('site_title_align');

            if ($mod == 'center') {

?>
.site-title, .featured-image .site-title {
	display: block;
	text-align: center;
}
<?php

            } elseif ($mod == 'right') {

?>
.site-title, .featured-image .site-title {
	display: block;
	text-align: right;
}
<?php

            }

            oftnCommon::generate_css('.site-title, .featured-image .site-title', 'display', 'hide_site_title', '', '', 'none');

            $mod = get_theme_mod('site_description_align');

            if ($mod == 'center') {

?>
.site-description {
	display: block;
	text-align: center;
}
<?php

            } elseif ($mod == 'right') {

?>
.site-description {
	display: block;
	text-align: right;
}
<?php

            }

            oftnCommon::generate_css('.site-description', 'display', 'hide_site_description', '', '', 'none');

            $mod = absint(get_theme_mod('navigation_font_size')) / 1000;

            if ($mod) {

?>
.main-navigation {
    font-size: <?php echo $mod; ?>rem;
}
<?php

                if ($mobile_font_size) { 

?>
@media only screen and (max-width: 768px) {
	.main-navigation {
        font-size: <?php echo $mod * $mobile_font_size; ?>rem;
    }
}
<?php

                }

                if ($tablet_font_size) { 

?>
@media only screen and (min-width: 768px) and (max-width: 1168px) {
	.main-navigation {
        font-size: <?php echo $mod * $tablet_font_size; ?>rem;
    }
}
<?php

                }

            }

            $mod = absint(get_theme_mod('sub_nav_font_size')) / 1000;

            if ($mod) {

?>
.main-navigation div>ul>li>ul>li {
    font-size: <?php echo $mod; ?>rem;
}
<?php

                if ($mobile_font_size) { 

?>
@media only screen and (max-width: 768px) {
	.main-navigation div>ul>li>ul>li {
        font-size: <?php echo $mod * $mobile_font_size; ?>rem;
    }
}
<?php

                }

                if ($tablet_font_size) { 

?>
@media only screen and (min-width: 768px) and (max-width: 1168px) {
	.main-navigation div>ul>li>ul>li {
        font-size: <?php echo $mod * $tablet_font_size; ?>rem;
    }
}
<?php

                }

            }

            $mod = absint(get_theme_mod('sub_sub_nav_font_size')) / 1000;

            if ($mod) {

?>
.main-navigation div>ul>li>ul>li>ul>li {
    font-size: <?php echo $mod; ?>rem;
}
<?php

                if ($mobile_font_size) { 

?>
@media only screen and (max-width: 768px) {
	.main-navigation div>ul>li>ul>li>ul>li {
        font-size: <?php echo $mod * $mobile_font_size; ?>rem;
    }
}
<?php

                }

                if ($tablet_font_size) { 

?>
@media only screen and (min-width: 768px) and (max-width: 1168px) {
	.main-navigation div>ul>li>ul>li>ul>li {
        font-size: <?php echo $mod * $tablet_font_size; ?>rem;
    }
}
<?php

                }

            }






            oftnCommon::generate_css('.site-header.featured-image .custom-logo-link', 'background', 'remove_logo_background', '', '', 'none');

            oftnCommon::generate_css('.entry .entry-title', 'font-weight', 'page_title_font_weight');
            oftnCommon::generate_css('.entry .entry-title', 'text-transform', 'page_title_text_transform');

            $mod = get_theme_mod('post_meta_location');

            if ($mod == 'none' || $mod == 'above') {

?>
.single-post .entry-footer {
    display: none;
}
<?php

            }

            if ($mod == 'none' || $mod == 'below') {

?>
.single-post .entry-meta {
    display: none;
}
<?php

            }

            oftnCommon::generate_css('.twentynineteen-customizer .entry .entry-meta > .posted-on, .twentynineteen-customizer .entry .entry-footer > .posted-on, .entry .entry-meta > .posted-on, .entry .entry-footer > .posted-on, .site-header.featured-image .site-featured-image .entry-header .entry-meta > .posted-on', 'display', 'remove_posted_on', '', '', 'none');
            oftnCommon::generate_css('.twentynineteen-customizer .entry .entry-meta > .byline, .twentynineteen-customizer .entry .entry-footer > .byline, .entry .entry-meta > .byline, .entry .entry-footer > .byline, .site-header.featured-image .site-featured-image .entry-header .entry-meta > .byline', 'display', 'remove_author', '', '', 'none');

            oftnCommon::generate_css('.site-footer', 'background-color', 'footer_background_color');

            if (get_theme_mod('remove_powered_by_wordpress') && !get_theme_mod('replace_powered_by_wordpress')) {

                add_action('wp_footer', array($this, 'oftn_remove_site_info_comma'));

?>
.site-info>.imprint {
    display: none;
}
.site-name {
    margin-right: 1rem;
}
#infinite-footer .blog-credits {
    display: none;
}
<?php

            }

            oftnCommon::generate_css('body', 'background-color', 'body_background_color');

            oftnCommon::generate_css('.site-header.featured-image:after', 'opacity', 'opacity_level', '', '', number_format((float)((get_theme_mod('opacity_level') / 100) - 0.01), 2, '.', ''));

            if (get_theme_mod('saturation_level')) {

                add_filter('twentynineteen_custom_colors_saturation', array($this, 'oftn_custom_colors_saturation'));

            }

            if (get_theme_mod('lightness_level')) {

                add_filter('twentynineteen_custom_colors_lightness', array($this, 'oftn_custom_colors_lightness'));

            }

            if (get_theme_mod('hover_lightness_level')) {

                add_filter('twentynineteen_custom_colors_lightness_hover', array($this, 'oftn_custom_colors_lightness_hover'));

            }

            if (get_theme_mod('selection_saturation_level')) {

                add_filter('twentynineteen_custom_colors_saturation_selection', array($this, 'oftn_custom_colors_saturation_selection'));

            }

            if (get_theme_mod('selection_lightness_level')) {

                add_filter('twentynineteen_custom_colors_lightness_selection', array($this, 'oftn_custom_colors_lightness_selection'));

            }

?>
</style> 
<!--/Customizer CSS-->
<?php

        }

        function oftn_remove_site_info_comma() {

?>
<script type="text/javascript">
    (function() {
        document.getElementsByClassName('site-info')[0].innerHTML = document.getElementsByClassName('site-info')[0].innerHTML.split('</a>,\n\t\t\t\t\t\t').join('</a>');
    })();
</script>
<?php

        }

        function oftn_custom_colors_saturation() {

            return get_theme_mod('saturation_level') - 1;

        }

        function oftn_custom_colors_lightness() {

            return get_theme_mod('lightness_level') - 1;

        }

        function oftn_custom_colors_lightness_hover() {

            return get_theme_mod('hover_lightness_level') - 1;

        }

        function oftn_custom_colors_saturation_selection() {

            return get_theme_mod('selection_saturation_level') - 1;

        }

        function oftn_custom_colors_lightness_selection() {

            return get_theme_mod('selection_lightness_level') - 1;

        }

        function oftn_enqueue_customize_preview_js() {

            wp_enqueue_script('oftn-customize-preview', plugin_dir_url(__FILE__) . 'js/customize-preview.js', array('jquery', 'customize-preview'), oftnCommon::plugin_version(), true);


        }

        function oftn_enqueue_customize_controls_js() {

            wp_enqueue_script('oftn-customize-controls', plugin_dir_url(__FILE__) . 'js/customize-controls.js', array('jquery', 'customize-controls'), oftnCommon::plugin_version(), true);


        }

        function oftn_enqueue_customizer_css() {

            wp_enqueue_style('oftn-customizer-css', plugin_dir_url(__FILE__) . 'css/theme-customizer.css', array(), oftnCommon::plugin_version());

        }

        function oftn_add_theme_support() {

    		add_theme_support('custom-logo', array(
    			'height'      => 190,
    			'width'       => 190,
    			'flex-width'  => true,
    			'flex-height' => true,
    		));

        }

	}

    if (!class_exists('oftnCommon')) {

        require_once(dirname(__FILE__) . '/includes/class-oftn-common.php');

    }

    if (oftnCommon::is_theme_being_used('twentynineteen')) {

	    $options_for_twenty_nineteen_object = new options_for_twenty_nineteen_class();

    } else {

        if (is_admin()) {

            $themes = wp_get_themes();

            if (!isset($themes['twentynineteen'])) {

                add_action('admin_notices', 'oftn_wrong_theme_notice');

            }

        }

    }

    function oftn_wrong_theme_notice() {

?>

<div class="notice notice-error">

<p><strong><?php _e('Options for Twenty Nineteen Plugin Error', 'options-for-twenty-nineteen'); ?></strong><br />
<?php
        printf(
            __('This plugin requires the default Wordpress theme Twenty Nineteen to be active or live previewed in order to function. Your theme "%s" is not compatible.', 'options-for-twenty-nineteen'),
            get_template()
        );
?>

<a href="<?php echo add_query_arg('search', 'twentynineteen', admin_url('theme-install.php')); ?>" title="<?php _e('Twenty Nineteen', 'options-for-twenty-nineteen'); ?>"><?php
        _e('Please install and activate or live preview the Twenty Nineteen theme (or a child theme thereof)', 'options-for-twenty-nineteen');
?></a>.</p>

</div>

<?php

    }

}

?>
