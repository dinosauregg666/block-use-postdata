<?php
/**
 * Plugin Name: Block use post data
 */

if(!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'inc/generateHTML.php';

//wp.data.select('core').getEntityRecords('postType', 'post', {per_page: -1}) // 浏览器控制台可以通过这个查询帖子，需要键入2次

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
        if($attributes['postId']) {
            wp_enqueue_style('cusblockusepostcss');
            return generateHTML($attributes['postId']);
        } else {
            return NULL;
        }
    }
}

$blockUsePostData = new BlockUsePostData();