<?php
/**
 * Plugin Name: Divi Title Module
 * Plugin URI: https://github.com/MarieComet/MC-Divi-Module-Title/
 * Description: This plugin adds a new module to the Divi builder, it allows to easily insert titles without going through the text module.
 * Version: 1.0.2
 * Author: Marie Comet
 * Author URI: http://mariecomet.fr/
 * Requires at least: 4.4
 * Tested up to: 5.4
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
                $this->vb_support = 'partial';

                $this->fields_defaults = array(
                    'background_layout' => array( 'light' ),
                    'text_align'  => array( 'left' ),
                );

                $this->main_css_element = '%%order_class%%';

                $this->settings_modal_toggles = array(
                    'general'  => array(
                        'toggles' => array(
                            'main_content' => esc_html__( 'Text', 'mc-divi-title-module' ),
                        ),
                    ),
                    'advanced' => array(
                        'toggles' => array(
                            'title_level'     => array(
                                'title'    => esc_html__( 'Title', 'mc-divi-title-module' ),
                                'priority' => 49,
                            ),
                        ),
                    ),
                );

                $this->advanced_fields = array(
                    'fonts'                 => array(
                        'title_level' => array(
                            'label'    => esc_html__( 'Title', 'mc-divi-title-module' ),
                            'css'      => array(
                                'main' => "{$this->main_css_element} .mc_title",
                                'line_height' => "{$this->main_css_element} .mc_title",
                                'color' => "{$this->main_css_element} .mc_title",
                                'font_size' => "{$this->main_css_element} .mc_title",
                            ),
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
                        'default'         => 'h2',
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
                    )
                );

                return $fields;
            }

            function render( $attrs, $content = null, $render_slug ) {
                $title                = $this->props['content_title'];
                $title_level          = $this->props['title_level'];

                $output = sprintf(
                    '<%2$s class="mc_title">%1$s</%2$s>',
                    $title,
                    $title_level
                );

                return $this->_render_module_wrapper( $output, $render_slug );
            }
        }
        new ET_Builder_Module_Title;
    } else {
        add_action( 'admin_notices', 'mc_dtm_admin_notice' );
        return;
    }
}
add_action('et_builder_ready', 'mc_init_divi_title_module');