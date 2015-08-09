<?php

class Product_Widget extends WP_Widget
{

    function __construct()
    {

        $widget_ops = array(
            'classname' => 'product-widget-class',
            'description' => __('Показывает информацию о продукте для текущей страници', 'product-plugin'));
        parent::__construct('product_widget', __('Продукты', 'product-plugin'), $widget_ops);

    }

    function widget($args, $instance)
    {
        global $post;

        $query = new WP_Query(array(
            'post_type' => array('post', 'page'),
            'shortcode' => '[product]'
        ));

        while ($query->have_posts()) {
            $query->the_post();

            extract($args);

            echo $before_widget;

            $product_data = get_post_meta($post->ID, '_product_data', true);

            if (!empty($product_data) && !empty($product_data['name'])) {
                wp_enqueue_style('product', plugin_dir_url(__FILE__) . 'inc/css/product.css');

                require plugin_dir_path(__FILE__) . 'views/product-info-widget.php';
            }


            echo $after_widget;
        }

        wp_reset_postdata();
    }

}

add_filter('posts_where', 'wpse18703_posts_where', 10, 2);

function wpse18703_posts_where($where, &$wp_query)
{
    global $wpdb;
    if ($shortcode = $wp_query->get('shortcode')) {
        $where .= ' AND ' . $wpdb->posts . '.post_content LIKE \'%' . esc_sql($wpdb->esc_like($shortcode)) . '%\'';
    }
    return $where;
}