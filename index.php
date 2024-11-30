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
        add_action('rest_api_init', [$this, 'postHTML']); // 创建自定义 REST API
    }

    function postHTML() {
        // 参数1: 通常是插件或主题的唯一标识符，例如 'my-plugin/v1'
        // 参数2: 字符串，定义路由的路径
        // 参数3:
        //  - methods: 指定支持的 HTTP 方法，如 'GET', 'POST', 'PUT', 'DELETE'。
        //  - callback: 指定处理请求的回调函数。
        //  - permission_callback: 检查权限的回调函数，返回 true 允许访问。
        //  - args: 定义请求参数及其验证规则。
        register_rest_route('blockusepostdata/v1', 'getHTML', array(
            'methods' => WP_REST_SERVER::READABLE, // 通常对应于 'GET' 方法，类似于内置常量
            'callback' => [$this, 'getPostHTML']
        ));
    }

    function getPostHTML($data) {
        return generateHTML($data['postId']);
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