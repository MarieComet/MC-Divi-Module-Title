<?php
/**
 * Plugin Name: Divi Title Module
 * Plugin URI: https://github.com/MarieComet/MC-Divi-Module-Title/
 * Description: This plugin adds a new module to the Divi builder, it allows to easily insert titles without going through the text module.
 * Version: 1.0.1
 * Author: Marie Comet
 * Author URI: http://mariecomet.fr/
 * Requires at least: 4.4
 * Tested up to: 4.8
 *
 * Text Domain: mc-divi-title-module
 * Domain Path: /i18n/languages
 *
 * @package Divi Title Module
 * @author Marie Comet
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Display error if Divi not installed
function mc_dtm_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'Divi Title Module require the Divi Builder or the Divi theme to work', 'mc-divi-title-module' ); ?></p>
    </div>  
    <?php
}

function mc_init_divi_title_module() {

    if( class_exists("ET_Builder_Module") ) {
        class ET_Builder_Module_Title extends ET_Builder_Module {
            function init() {

                load_plugin_textdomain( 'mc-divi-title-module', false, plugin_basename( dirname( __FILE__ ) ) . '/i18n/languages/' );

                $this->name       = esc_html__( 'Title', 'mc-divi-title-module' );
                $this->slug       = 'et_pb_mc_title';
                $this->fb_support = true;

                $this->whitelisted_fields = array(
                    'title_level',
                    'background_layout',
                    'content_title',
                    'admin_label',
                    'module_id',
                    'module_class',
                );

                $this->fields_defaults = array(
                    'background_layout' => array( 'light' ),
                    'text_align'  => array( 'left' ),
                );

                $this->options_toggles = array(
                    'general'  => array(
                        'toggles' => array(
                            'main_content' => esc_html__( 'Text', 'mc-divi-title-module' ),
                        ),
                    ),
                    'advanced' => array(
                        'toggles' => array(
                            'text' => array(
                                'title'    => esc_html__( 'Text', 'mc-divi-title-module' ),
                                'priority' => 49,
                            ),
                        ),
                    ),
                );

                $this->main_css_element = '%%order_class%%';
                $this->advanced_options = array(
                    'fonts' => array(
                        'text'   => array(
                            'label'    => esc_html__( 'Text', 'mc-divi-title-module' ),
                            'css'      => array(
                                'main' => "{$this->main_css_element} .mc_title",
                                'line_height' => "{$this->main_css_element} .mc_title",
                                'color' => "{$this->main_css_element} .mc_title",
                                'font_size' => "{$this->main_css_element} .mc_title",
                            ),
                            'line_height' => array(
                                'default' => '1em',
                            ),
                            'font_size' => array(
                                'default' => '18px',
                                'range_settings' => array(
                                    'min'  => '12',
                                    'max'  => '44',
                                    'step' => '1',
                                ),
                            ),
                            'letter_spacing' => array(
                                'default' => '0px',
                                'range_settings' => array(
                                    'min'  => '0',
                                    'max'  => '8',
                                    'step' => '1',
                                ),
                            ),
                            'toggle_slug' => 'text',
                        )
                    ),
                    'background' => array(
                        'settings' => array(
                            'color' => 'alpha',
                        ),
                    ),
                    'custom_margin_padding' => array(
                        'css' => array(
                            'important' => 'all',
                        ),
                    ),
                );
            }

            function get_fields() {
                $fields = array(
                    'title_level' => array(
                        'label'             => esc_html__( 'Level', 'mc-divi-title-module' ),
                        'type'              => 'select',
                        'option_category'   => 'basic_option',
                        'options'           => array(
                            'h1' => esc_html__( 'H1', 'mc-divi-title-module' ),
                            'h2'  => esc_html__( 'H2', 'mc-divi-title-module' ),
                            'h3'  => esc_html__( 'H3', 'mc-divi-title-module' ),
                            'h4'  => esc_html__( 'H4', 'mc-divi-title-module' ),
                            'h5'  => esc_html__( 'H5', 'mc-divi-title-module' ),
                        ),
                        'tab_slug'          => 'general',
                        'toggle_slug'       => 'main_content',
                        'description'       => esc_html__( 'Choose the level title', 'mc-divi-title-module' ),
                    ),
                    'background_layout' => array(
                        'label'             => esc_html__( 'Text Color', 'mc-divi-title-module' ),
                        'type'              => 'select',
                        'option_category'   => 'configuration',
                        'options'           => array(
                            'light' => esc_html__( 'Dark', 'mc-divi-title-module' ),
                            'dark'  => esc_html__( 'Light', 'mc-divi-title-module' ),
                        ),
                        'tab_slug'          => 'advanced',
                        'toggle_slug'       => 'text',
                        'description'       => esc_html__( 'Here you can choose the value of your text. If you are working with a dark background, then your text should be set to light. If you are working with a light background, then your text should be dark.', 'mc-divi-title-module' ),
                    ),
                    'content_title' => array(
                        'label'           => esc_html__( 'Content', 'mc-divi-title-module' ),
                        'type'            => 'text',
                        'option_category' => 'basic_option',
                        'description'     => esc_html__( 'Here you can create the content that will be used within the module.', 'mc-divi-title-module' ),
                        'toggle_slug'     => 'main_content',
                    ),
                    'disabled_on' => array(
                        'label'           => esc_html__( 'Disable on', 'mc-divi-title-module' ),
                        'type'            => 'multiple_checkboxes',
                        'options'         => array(
                            'phone'   => esc_html__( 'Phone', 'mc-divi-title-module' ),
                            'tablet'  => esc_html__( 'Tablet', 'mc-divi-title-module' ),
                            'desktop' => esc_html__( 'Desktop', 'mc-divi-title-module' ),
                        ),
                        'additional_att'  => 'disable_on',
                        'option_category' => 'configuration',
                        'description'     => esc_html__( 'This will disable the module on selected devices', 'mc-divi-title-module' ),
                        'tab_slug'        => 'custom_css',
                        'toggle_slug'     => 'visibility',
                    ),
                    'admin_label' => array(
                        'label'       => esc_html__( 'Admin Label', 'mc-divi-title-module' ),
                        'type'        => 'text',
                        'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'mc-divi-title-module' ),
                        'toggle_slug' => 'admin_label',
                    ),
                    'module_id' => array(
                        'label'           => esc_html__( 'CSS ID', 'mc-divi-title-module' ),
                        'type'            => 'text',
                        'option_category' => 'configuration',
                        'tab_slug'        => 'custom_css',
                        'toggle_slug'     => 'classes',
                        'option_class'    => 'et_pb_custom_css_regular',
                    ),
                    'module_class' => array(
                        'label'           => esc_html__( 'CSS Class', 'mc-divi-title-module' ),
                        'type'            => 'text',
                        'option_category' => 'configuration',
                        'tab_slug'        => 'custom_css',
                        'toggle_slug'     => 'classes',
                        'option_class'    => 'et_pb_custom_css_regular',
                    ),
                );

                return $fields;
            }

            function shortcode_callback( $atts, $content = null, $function_name ) {
                $title = $this->shortcode_atts['content_title'];
                $title_level            = $this->shortcode_atts['title_level'];
                $module_id            = $this->shortcode_atts['module_id'];
                $module_class         = $this->shortcode_atts['module_class'];
                $background_layout    = $this->shortcode_atts['background_layout'];
                $title_font_size = $this->shortcode_atts['text_font_size'];

                $module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

                if ( '' !== $title_font_size ) {
                    ET_Builder_Element::set_style( $function_name, array(
                        'selector'    => '%%order_class%% %2$s;',
                        'declaration' => sprintf(
                            'font-size: %1$s;',
                            esc_html( $title_font_size ),
                            esc_html($title_level)
                        ),
                    ) );
                }

                $class = " et_pb_module et_pb_bg_layout_{$background_layout}";

                $output = sprintf(
                    '<div%3$s class="et_pb_mc_title%2$s%4$s">
                        <div class="et_pb_mc_title_inner">
                            <%5$s class="mc_title">%1$s</%5$s>
                        </div>
                    </div> <!-- .et_pb_mc_title -->',
                    $title,
                    esc_attr( $class ),
                    ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
                    ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
                    $title_level
                );

                return $output;
            }
        }
        new ET_Builder_Module_Title;
    } else {
        add_action( 'admin_notices', 'mc_dtm_admin_notice' );
        return;
    }
}
add_action('et_builder_ready', 'mc_init_divi_title_module');