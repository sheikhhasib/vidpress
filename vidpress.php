<?php
/**
 * Plugin Name:       VidPress
 * Plugin URI:        https://newsn360.com/
 * Description:       Provides common video blocks for the site.
 * Version:           1.0.1
 * Author:            Newsn360
 * Author URI:        https://newsn360.com/
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vidpress
 * Domain Path:       /languages
 *
 * @package           VidPress
 */

// Abort if this file is called directly.
if ( ! defined( 'WPINC' ) ) {
    exit;
}

// Autoload dependencies.
require_once __DIR__ . '/vendor/autoload.php';

// Load plugin textdomain for translations.
add_action( 'init', function () {
    load_plugin_textdomain( 'vidpress', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
});

// Initialize plugin after plugins are loaded.
add_action( 'plugins_loaded', array( 'VidPress', 'instance' ) );

/**
 * The main plugin class
 */
final class VidPress {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0.1';

    /**
     * VidPress constructor.
     */
    private function __construct() {
        $this->define_constants();
        $this->init_plugin();
        register_activation_hook( __FILE__, [ $this, 'activate' ] );
    }

    /**
     * Initialize singleton instance
     *
     * @return VidPress
     */
    public static function instance() {
        static $instance = null;

        if ( is_null( $instance ) ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define plugin constants
     */
    public function define_constants() {
        $theme_obj    = wp_get_theme();
        $parent_theme = $theme_obj->get( 'Template' );
        $template_dir = ! empty( $parent_theme ) ? get_stylesheet_directory() : get_template_directory();

        define( 'VIDPRESS_THEME_PATH', $template_dir );
        define( 'VIDPRESS_VERSION', self::version );
        define( 'VIDPRESS_FILE', __FILE__ );
        define( 'VIDPRESS_PATH', __DIR__ );
        define( 'VIDPRESS_URL', plugins_url( '', __FILE__ ) );
        define( 'VIDPRESS_ASSETS', VIDPRESS_URL . '/assets' );
    }

    /**
     * Initialize plugin parts
     */
    public function init_plugin() {
        if ( is_admin() ) {
            new VidPress\Admin();
        } else {
            new VidPress\Frontend();
        }

        new VidPress\Blocks();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new VidPress\Ajax();
        }
    }

    /**
     * Actions to run on plugin activation
     */
    public function activate() {
        $installer = new VidPress\Installer();
        $installer->run();
    }
}
