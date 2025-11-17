<?php
/**
 * Plugin Name: No Comments on Media
 * Plugin URI: https://github.com/Bitwise-SoftwarePR/NoCommentsOnMedia
 * Description: Disables comments on all media attachments. Simple, lightweight, effective.
 * Version: 1.0.0
 * Author: Bitwise Software
 * Author URI: https://github.com/Bitwise-SoftwarePR
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: no-comments-on-media
 * Requires at least: 5.0
 * Requires PHP: 7.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main plugin class
 */
class No_Comments_On_Media {
    
    /**
     * Option name for plugin settings
     */
    const OPTION_NAME = 'ncom_disable_comments';
    
    /**
     * Option name for delete comments setting
     */
    const DELETE_OPTION_NAME = 'ncom_delete_comments';
    
    /**
     * Initialize the plugin
     */
    public static function init() {
        // Check if plugin is enabled (default: enabled)
        if ( self::is_enabled() ) {
            // Disable comments on attachments
            add_filter( 'comments_open', array( __CLASS__, 'disable_comments' ), 10, 2 );
            add_filter( 'pings_open', array( __CLASS__, 'disable_comments' ), 10, 2 );
            add_filter( 'comments_array', array( __CLASS__, 'remove_comments_array' ), 10, 2 );
            
            // Remove comment support from attachment post type
            add_action( 'init', array( __CLASS__, 'remove_comment_support' ) );
            
            // Hide comments sections on attachment pages
            add_action( 'template_redirect', array( __CLASS__, 'hide_comments_template' ) );
        }
        
        // Add settings to Media settings page
        add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
        
        // Plugin activation
        register_activation_hook( __FILE__, array( __CLASS__, 'activate' ) );
        
        // Register WP-CLI commands if WP-CLI is available
        if ( defined( 'WP_CLI' ) && WP_CLI ) {
            WP_CLI::add_command( 'media-comments', 'No_Comments_On_Media_CLI' );
        }
    }
    
    /**
     * Check if plugin functionality is enabled
     * 
     * @return bool
     */
    private static function is_enabled() {
        return (bool) get_option( self::OPTION_NAME, true );
    }
    
    /**
     * Disable comments and pings on attachments
     * 
     * @param bool $open    Whether comments are open
     * @param int  $post_id Post ID
     * @return bool
     */
    public static function disable_comments( $open, $post_id ) {
        $post = get_post( $post_id );
        if ( $post && 'attachment' === $post->post_type ) {
            return false;
        }
        return $open;
    }
    
    /**
     * Remove comments array for attachments
     * 
     * @param array $comments Array of comments
     * @param int   $post_id  Post ID
     * @return array
     */
    public static function remove_comments_array( $comments, $post_id ) {
        $post = get_post( $post_id );
        if ( $post && 'attachment' === $post->post_type ) {
            return array();
        }
        return $comments;
    }
    
    /**
     * Remove comment support from attachment post type
     */
    public static function remove_comment_support() {
        if ( post_type_supports( 'attachment', 'comments' ) ) {
            remove_post_type_support( 'attachment', 'comments' );
        }
    }
    
    /**
     * Hide comments template on attachment pages
     */
    public static function hide_comments_template() {
        if ( is_attachment() ) {
            add_filter( 'comments_template', array( __CLASS__, 'blank_comments_template' ), 20 );
        }
    }
    
    /**
     * Return empty template for comments
     * 
     * @return string
     */
    public static function blank_comments_template() {
        return __DIR__ . '/blank.php';
    }
    
    /**
     * Register plugin settings
     */
    public static function register_settings() {
        // Register the main setting
        register_setting(
            'media',
            self::OPTION_NAME,
            array(
                'type'              => 'boolean',
                'default'           => true,
                'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
            )
        );
        
        // Register the delete comments setting
        register_setting(
            'media',
            self::DELETE_OPTION_NAME,
            array(
                'type'              => 'boolean',
                'default'           => false,
                'sanitize_callback' => array( __CLASS__, 'sanitize_delete_option' ),
            )
        );
        
        // Add settings section
        add_settings_section(
            'ncom_section',
            __( 'Comments on Media', 'no-comments-on-media' ),
            array( __CLASS__, 'section_callback' ),
            'media'
        );
        
        // Add settings field
        add_settings_field(
            self::OPTION_NAME,
            __( 'Disable Comments on Media Attachments', 'no-comments-on-media' ),
            array( __CLASS__, 'field_callback' ),
            'media',
            'ncom_section'
        );
    }
    
    /**
     * Settings section callback
     */
    public static function section_callback() {
        echo '<p>' . esc_html__( 'Control whether comments are allowed on media attachments.', 'no-comments-on-media' ) . '</p>';
    }
    
    /**
     * Settings field callback
     */
    public static function field_callback() {
        $value = get_option( self::OPTION_NAME, true );
        $delete_value = get_option( self::DELETE_OPTION_NAME, false );
        ?>
        <label>
            <input type="checkbox" 
                   name="<?php echo esc_attr( self::OPTION_NAME ); ?>" 
                   value="1" 
                   <?php checked( $value, true ); ?> />
            <?php esc_html_e( 'Disable comments on all media attachments', 'no-comments-on-media' ); ?>
        </label>
        <p class="description">
            <?php esc_html_e( 'When enabled, comments and pingbacks/trackbacks will be disabled on all media attachment pages.', 'no-comments-on-media' ); ?>
        </p>
        
        <hr style="margin: 20px 0;">
        
        <label>
            <input type="checkbox" 
                   name="<?php echo esc_attr( self::DELETE_OPTION_NAME ); ?>" 
                   value="1" 
                   <?php checked( $delete_value, true ); ?> />
            <?php esc_html_e( 'Delete existing comments on attachments', 'no-comments-on-media' ); ?>
        </label>
        <p class="description" style="color: #d63638;">
            <?php esc_html_e( '⚠️ Warning: This will permanently delete all existing comments on media attachments. This action cannot be undone!', 'no-comments-on-media' ); ?>
        </p>
        <?php
    }
    
    /**
     * Sanitize checkbox value
     * 
     * @param mixed $value
     * @return bool
     */
    public static function sanitize_checkbox( $value ) {
        return (bool) $value;
    }
    
    /**
     * Sanitize delete option and perform deletion if enabled
     * 
     * @param mixed $value
     * @return bool
     */
    public static function sanitize_delete_option( $value ) {
        $should_delete = (bool) $value;
        
        // If user wants to delete comments, do it now
        if ( $should_delete ) {
            self::delete_existing_comments();
            
            // Add admin notice
            add_settings_error(
                self::DELETE_OPTION_NAME,
                'ncom_deleted',
                __( 'All comments on media attachments have been permanently deleted.', 'no-comments-on-media' ),
                'success'
            );
            
            // Reset the option to false after deletion
            return false;
        }
        
        return false;
    }
    
    /**
     * Plugin activation
     */
    public static function activate() {
        // Set default option
        if ( false === get_option( self::OPTION_NAME ) ) {
            add_option( self::OPTION_NAME, true );
        }
        
        // Close comments on existing attachments
        self::close_existing_comments();
    }
    
    /**
     * Close comments on existing attachments
     * Runs only on activation
     */
    private static function close_existing_comments() {
        global $wpdb;
        
        // Close comments and pingbacks/trackbacks on all attachments
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Bulk operation on activation, no caching needed
        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->posts} 
                 SET comment_status = %s, 
                     ping_status = %s 
                 WHERE post_type = %s",
                'closed',
                'closed',
                'attachment'
            )
        );
    }
    
    /**
     * Delete existing comments on attachments
     * Only runs when explicitly requested by user
     * 
     * @return int Number of comments deleted
     */
    public static function delete_existing_comments() {
        global $wpdb;
        
        // Get count of comments to delete
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Count query for user-initiated bulk operation
        $count = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->comments} 
                 WHERE comment_post_ID IN (
                     SELECT ID FROM {$wpdb->posts} 
                     WHERE post_type = %s
                 )",
                'attachment'
            )
        );
        
        // Delete comments on attachments
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Bulk delete operation, caching not applicable
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->comments} 
                 WHERE comment_post_ID IN (
                     SELECT ID FROM {$wpdb->posts} 
                     WHERE post_type = %s
                 )",
                'attachment'
            )
        );
        
        // Clean up orphaned comment meta
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Cleanup of orphaned meta, no caching needed
        $wpdb->query(
            "DELETE cm FROM {$wpdb->commentmeta} cm
             LEFT JOIN {$wpdb->comments} c ON cm.comment_id = c.comment_ID
             WHERE c.comment_ID IS NULL"
        );
        
        // Update comment count for attachments
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Bulk update operation
        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->posts} 
                 SET comment_count = %d 
                 WHERE post_type = %s",
                0,
                'attachment'
            )
        );
        
        return (int) $count;
    }
}

// Initialize the plugin
add_action( 'plugins_loaded', array( 'No_Comments_On_Media', 'init' ) );

/**
 * WP-CLI Commands for No Comments on Media
 */
if ( defined( 'WP_CLI' ) && WP_CLI ) {
    
    // phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound -- WP-CLI command class follows WP-CLI naming conventions
    class No_Comments_On_Media_CLI {
        
        /**
         * Disable comments on all media attachments
         * 
         * ## EXAMPLES
         * 
         *     wp media-comments disable
         * 
         * @when after_wp_load
         */
        public function disable( $args, $assoc_args ) {
            global $wpdb;
            
            WP_CLI::log( 'Disabling comments on media attachments...' );
            
            // Enable the plugin option
            update_option( No_Comments_On_Media::OPTION_NAME, true );
            
            // Close comments on all attachments
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- WP-CLI bulk operation
            $result = $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->posts} 
                     SET comment_status = %s, 
                         ping_status = %s 
                     WHERE post_type = %s",
                    'closed',
                    'closed',
                    'attachment'
                )
            );
            
            WP_CLI::success( sprintf( 
                'Comments disabled! %d attachment(s) updated.', 
                $result 
            ) );
        }
        
        /**
         * Enable comments on all media attachments
         * 
         * ## EXAMPLES
         * 
         *     wp media-comments enable
         * 
         * @when after_wp_load
         */
        public function enable( $args, $assoc_args ) {
            WP_CLI::log( 'Enabling comments on media attachments...' );
            
            // Disable the plugin option
            update_option( No_Comments_On_Media::OPTION_NAME, false );
            
            WP_CLI::success( 'Plugin disabled. Comments are now allowed on media attachments.' );
        }
        
        /**
         * Delete all existing comments on media attachments
         * 
         * ## OPTIONS
         * 
         * [--yes]
         * : Skip confirmation and proceed with deletion
         * 
         * ## EXAMPLES
         * 
         *     wp media-comments cleanup
         *     wp media-comments cleanup --yes
         * 
         * @when after_wp_load
         */
        public function cleanup( $args, $assoc_args ) {
            global $wpdb;
            
            // Get count first
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- WP-CLI count query
            $count = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(*) FROM {$wpdb->comments} 
                     WHERE comment_post_ID IN (
                         SELECT ID FROM {$wpdb->posts} 
                         WHERE post_type = %s
                     )",
                    'attachment'
                )
            );
            
            if ( $count == 0 ) {
                WP_CLI::success( 'No comments found on media attachments.' );
                return;
            }
            
            WP_CLI::warning( sprintf( 
                'Found %d comment(s) on media attachments.', 
                $count 
            ) );
            
            // Confirm deletion unless --yes flag is provided
            if ( ! isset( $assoc_args['yes'] ) ) {
                WP_CLI::confirm( 
                    'This will permanently delete all comments on media attachments. Continue?',
                    $assoc_args 
                );
            }
            
            WP_CLI::log( 'Deleting comments...' );
            
            // Perform deletion
            $deleted = No_Comments_On_Media::delete_existing_comments();
            
            WP_CLI::success( sprintf( 
                'Deleted %d comment(s) from media attachments.', 
                $deleted 
            ) );
        }
        
        /**
         * Show current status of the plugin
         * 
         * ## EXAMPLES
         * 
         *     wp media-comments status
         * 
         * @when after_wp_load
         */
        public function status( $args, $assoc_args ) {
            global $wpdb;
            
            $enabled = get_option( No_Comments_On_Media::OPTION_NAME, true );
            
            // Count attachments with open comments
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- WP-CLI status query
            $open_count = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(*) FROM {$wpdb->posts} 
                     WHERE post_type = %s 
                     AND comment_status = %s",
                    'attachment',
                    'open'
                )
            );
            
            // Count comments on attachments
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- WP-CLI status query
            $comment_count = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(*) FROM {$wpdb->comments} 
                     WHERE comment_post_ID IN (
                         SELECT ID FROM {$wpdb->posts} 
                         WHERE post_type = %s
                     )",
                    'attachment'
                )
            );
            
            WP_CLI::log( '=== No Comments on Media - Status ===' );
            WP_CLI::log( '' );
            WP_CLI::log( sprintf( 'Plugin Status: %s', $enabled ? 'ENABLED' : 'DISABLED' ) );
            WP_CLI::log( sprintf( 'Attachments with open comments: %d', $open_count ) );
            WP_CLI::log( sprintf( 'Total comments on attachments: %d', $comment_count ) );
            WP_CLI::log( '' );
            
            if ( $enabled ) {
                WP_CLI::success( 'Comments are disabled on media attachments.' );
            } else {
                WP_CLI::warning( 'Comments are currently allowed on media attachments.' );
            }
        }
    }
    // phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
}
