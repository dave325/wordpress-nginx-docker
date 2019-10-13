<?php
/**
 * Plugin Name: HT Event
 * Description: WordPress plugins for elementor.
 * Plugin URI: http://demo.wphash.com/htevent/
 * Version: 1.3.0
 * Author: HT Plugins
 * Author URI: https://htplugins.com/
 * License:  GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: htevent
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'HTEVENT_VERSION', '1.0.0' );
define( 'HTEVENT_ADDONS_PL_URL', plugins_url( '/', __FILE__ ) );
define( 'HTEVENT_ADDONS_PL_PATH', plugin_dir_path( __FILE__ ) );
define( 'HTEVENT_ADDONS_PL_ROOT', __FILE__ );

// Required File
require_once HTEVENT_ADDONS_PL_PATH.'init.php';
require_once HTEVENT_ADDONS_PL_PATH.'includes/helper-function.php';
require_once HTEVENT_ADDONS_PL_PATH.'admin/htevent_custom-post-type.php';
require_once HTEVENT_ADDONS_PL_PATH.'admin/htevent_custom-metabox.php';
require_once HTEVENT_ADDONS_PL_PATH.'admin/retister-pagetemplate.php';
require_once HTEVENT_ADDONS_PL_PATH.'admin/custom_taxonomy_field.php';
require_once HTEVENT_ADDONS_PL_PATH.'includes/post-like.php';

//wp widgets
require_once HTEVENT_ADDONS_PL_PATH.'includes/wp-widgets/company-info-widget.php';
require_once HTEVENT_ADDONS_PL_PATH.'includes/wp-widgets/recent-post.php';
require_once HTEVENT_ADDONS_PL_PATH.'includes/wp-widgets/twitter.php';
require_once HTEVENT_ADDONS_PL_PATH.'includes/wp-widgets/twitteroauth.php';
require_once HTEVENT_ADDONS_PL_PATH.'includes/wp-widgets/twitter-sidebar.php';
require_once HTEVENT_ADDONS_PL_PATH.'includes/wp-widgets/widget-instagram.php';


// Load text domain
function htevent_load_textdomain() {
  load_plugin_textdomain( 'htevent', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'init', 'htevent_load_textdomain' );

// archive 
function htevent_archive_modify($archive) {
    global $post;
    /* Checks for archive template by post type */
    if ( $post->post_type == 'htevent' ) {
        if ( file_exists( HTEVENT_ADDONS_PL_PATH . 'templates/archive-htevent.php' ) ) {
            return HTEVENT_ADDONS_PL_PATH . 'templates/archive-htevent.php';
        }
    }
    return $archive;
}
add_filter('archive_template', 'htevent_archive_modify');

//single event
function htevent_single_template_modify($single) {
    global $post;
    /* Checks for single template by post type */
    if ( $post->post_type == 'htevent' ) {
        if ( file_exists( HTEVENT_ADDONS_PL_PATH . 'templates/single-htevent.php' ) ) {
            return HTEVENT_ADDONS_PL_PATH . 'templates/single-htevent.php';
        }
    }
     /* Checks for single template by post type speaker */
    if ( $post->post_type == 'speaker' ) {
        if ( file_exists( HTEVENT_ADDONS_PL_PATH . 'templates/single-speaker.php' ) ) {
            return HTEVENT_ADDONS_PL_PATH . 'templates/single-speaker.php';
        }
    }
    
    return $single;
}
add_filter('single_template', 'htevent_single_template_modify');

// include cmb2 lib
if(  ! class_exists( 'CMB2_Bootstrap_242' ) ) {
    require_once( HTEVENT_ADDONS_PL_PATH. '/admin/cmb2/init.php');
}

function htevent_woocommerce_product_categories(){
    $terms = get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
    ));
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        foreach ( $terms as $term ) {
            $options[ $term->slug ] = $term->name;
        }
        return $options;
    }
}
/*
 * Display tabs related to htevent in admin when user
 * viewing/editing htevent/category.
 */

function htevent_post_tabs() {
    if ( ! is_admin() ) {
        return;
    }
    $admin_tabs = apply_filters(
        'htevent_movie_tabs_info',
        array(

            10 => array(
                "link" => "edit.php?post_type=htevent",
                "name" => __( "HT Event", "htevent" ),
                "id"   => "edit-htevent",
            ),

            20 => array(
                "link" => "edit-tags.php?taxonomy=htevent_category&post_type=htevent",
                "name" => __( "Categories", "htevent" ),
                "id"   => "edit-htevent_category",
            ),

        )
    );

    ksort( $admin_tabs );
    $tabs = array();
    foreach ( $admin_tabs as $key => $value ) {
        array_push( $tabs, $key );
    }

    $pages = apply_filters(
        'htevent_admin_tabs_on_pages',
        array( 'edit-htevent', 'edit-htevent_category', 'htevent' )
    );
    $admin_tabs_on_page = array();

    foreach ( $pages as $page ) {
        $admin_tabs_on_page[ $page ] = $tabs;
    }

    $current_page_id = get_current_screen()->id;
    $current_user    = wp_get_current_user();
    if ( ! in_array( 'administrator', $current_user->roles ) ) {
        return;
    }
    if ( ! empty( $admin_tabs_on_page[ $current_page_id ] ) && count( $admin_tabs_on_page[ $current_page_id ] ) ) {
        echo '<h1 class="nav-tab-wrapper lp-nav-tab-wrapper">';
        foreach ( $admin_tabs_on_page[ $current_page_id ] as $admin_tab_id ) {

            $class = ( $admin_tabs[ $admin_tab_id ]["id"] == $current_page_id ) ? "nav-tab nav-tab-active" : "nav-tab";
            echo '<a href="' . admin_url( $admin_tabs[ $admin_tab_id ]["link"] ) . '" class="' . $class . ' nav-tab-' . $admin_tabs[ $admin_tab_id ]["id"] . '">' . $admin_tabs[ $admin_tab_id ]["name"] . '</a>';
        }
        echo '</h1>';
    }
}

add_action( 'all_admin_notices', 'htevent_post_tabs',10000 );



// Check Plugins is Installed or not
function htevent_is_plugins_active( $pl_file_path = NULL ){
    $installed_plugins_list = get_plugins();
    return isset( $installed_plugins_list[$pl_file_path] );
}
// This notice for Elementor is not installed or activated or both.
function htevent_check_elementor_status(){
    $elementor = 'elementor/elementor.php';
    if( htevent_is_plugins_active($elementor) ) {
        if( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }
        $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $elementor . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor );
        $message = __( '<strong>HTEvent Addons for Elementor</strong> requires Elementor plugin to be active. Please activate Elementor to continue.', 'htevent' );
        $button_text = __( 'Activate Elementor', 'htevent' );
    } else {
        if( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }
        $activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
        $message = sprintf( __( '<strong>HTEvent Addons for Elementor</strong> requires %1$s"Elementor"%2$s plugin to be installed and activated. Please install Elementor to continue.', 'htevent' ), '<strong>', '</strong>' );
        $button_text = __( 'Install Elementor', 'htevent' );
    }
    $button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';
    printf( '<div class="error"><p>%1$s</p>%2$s</div>', __( $message ), $button );
}

if( ! did_action( 'elementor/loaded' ) ) {
    add_action( 'admin_notices', 'htevent_check_elementor_status' );
}


//for post view
function htevent_getPostViews($postID){
    $count_key = 'post_views_count';
    $count =  get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "View: 0 ";
    }
    return ' View: '.$count;
}
function htevent_setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

//footer customize
function load_canvas_template( $single_template ) {

    global $post;

    if ( 'htevent_footer' == $post->post_type ) {

        $elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

        if ( file_exists( $elementor_2_0_canvas ) ) {
            return $elementor_2_0_canvas;
        } else {
            return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
        }
    }

    return $single_template;
}

add_filter( 'single_template', 'load_canvas_template' );


/**
* Usages: "htevent_wishlist_shortcode()" function is used in our product addon from "YITH WooCommerce Wishlist" plugins.
* Plugins URL: https://wordpress.org/plugins/yith-woocommerce-wishlist/
* File Path: yith-woocommerce-wishlist/templates/add-to-wishlist.php
* The below Function depends on YITH WooCommerce Wishlist plugins. If YITH WooCommerce Wishlist is installed and actived, then it will work.
*/
function htevent_wishlist_shortcode(){

    if( class_exists('YITH_WCWL') ){
     echo do_shortcode('[yith_wcwl_add_to_wishlist]');
    }
}
add_action('init','htevent_wishlist_shortcode');

//single post count
function htevent_post_count(){
    if(is_single()){
        htevent_setPostViews(get_the_ID());
    }
}
add_action('template_redirect', 'htevent_post_count');