<?php
/**
 * Plugin Name: Block use post data
 */

if(!defined('ABSPATH')) exit;


class BlockUsePostData {
    function __construct() {
        add_action('init', array($this, 'adminAssets'));
    }
    function adminAssets() {
        wp_register_style('cusblockusepostcss', plugin_dir_url(__FILE__) . 'build/index.css');
        wp_register_script('cusblockusepostscript', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor'));
        register_block_type('my-block-use-post/blockusepostdata', array(
            'editor_script' => 'cusblockusepostscript',
            'editor_style' => 'cusblockusepostcss',
            'render_callback' => array($this, 'theHTML')
        ));
    }
    function theHTML($attributes) {
        ob_start(); ?>
        <div>123123123123</div>
        <?php return ob_get_clean();
    }
}

$blockUsePostData = new BlockUsePostData();