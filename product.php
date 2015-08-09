<?php
/*
Plugin Name: Product
Plugin URI: https://example.com/
Description: Display product information
Version: 1.0
Author: Max Romanov
Author URI: http://example.ua
License: GPLv2
Text Domain: product-plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

add_shortcode('product', 'product_shortcode');

add_action('widgets_init', 'product_register_widgets');
add_action('admin_enqueue_scripts', 'load_product_meta_box_style');
add_action('add_meta_boxes', 'product_register_meta_box');
add_action('save_post', 'product_save_meta_box');


function load_product_meta_box_style()
{
    wp_enqueue_script('product-meta', plugin_dir_url(__FILE__) . 'inc/js/product-meta.js', array('jquery'));
    wp_enqueue_style('product-meta', plugin_dir_url(__FILE__) . 'inc/css/product-meta.css');
    wp_enqueue_media();
}

function product_register_meta_box()
{

    $screens = array('post', 'page');

    foreach ($screens as $screen) {
        add_meta_box(
            'product_section',
            __('Product Information', 'product-plugin'),
            'product_meta_box',
            $screen
        );
    }
}

function product_meta_box($post)
{
    $product_meta = get_post_meta($post->ID, '_product_data', true);

    $product_currency = (!empty($product_meta['currency'])) ? $product_meta['currency'] : '';
    $product_price = (!empty($product_meta['price'])) ? $product_meta['price'] : '';
    $product_description = (!empty($product_meta['description'])) ? $product_meta['description'] : '';
    $product_name = (!empty($product_meta['name'])) ? $product_meta['name'] : '';
    $product_img = (!empty($product_meta['image'])) ? $product_meta['image'] : '';

    wp_nonce_field('meta-box-save', 'product-plugin');

    ob_start();
    require plugin_dir_path(__FILE__) . 'views/product-meta.php';
    ob_end_flush();
}

function product_save_meta_box($post_id)
{
    $post_type = get_post_type($post_id);

    if (($post_type == 'post' || $post_type == 'page') && isset($_POST['product'])) {

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        wp_verify_nonce('meta-box-save', 'product-plugin');

        $product_data = array();

        foreach ($_POST['product'] as $key => $val) {
            if ($key == 'image') {
                $product_data[$key] = esc_url($val);
            } else {
                $product_data[$key] = sanitize_text_field($val);
            }
        }

        update_post_meta($post_id, '_product_data', $product_data);
    }
}

function product_shortcode($atts)
{
    global $post;

    $atts = shortcode_atts(array('post' => ''), $atts);

    if (!empty($atts['post'])) {
        $product_data = get_post_meta($atts['post'], '_product_data', true);
    } else {
        $product_data = get_post_meta($post->ID, '_product_data', true);
    }

    if (!empty($product_data) && !empty($product_data['name'])) {

        wp_enqueue_style('product', plugin_dir_url(__FILE__) . 'inc/css/product.css');

        ob_start();
        require plugin_dir_path(__FILE__) . 'views/product-info.php';
        $res = ob_get_contents();
        ob_end_clean();
    }

    return $res;
}

function product_register_widgets()
{
    register_widget('Product_Widget');
}

require_once plugin_dir_path(__FILE__) . 'class-product-widget.php';
