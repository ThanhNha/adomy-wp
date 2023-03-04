<?php
/*
 * Create blocks for site
 */
add_filter('block_categories_all', 'shin_block_category', 10, 2);
function shin_block_category($categories, $post)
{
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'shin-blocks',
                'title' => __('The Natives Blocks', 'shin-blocks'),
            ),
        )
    );
}


add_action('acf/init', 'shin_acf_init_block_types');

function shin_acf_init_block_types()
{
    // Check function exists.
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'Product',
            'title'             => __('Product'),
            'description'       => __('A custom Spacing block.'),
            'render_template'   => 'site-structure/blocks/product/index.php',
            'category'          => 'shin-blocks',
            'icon'              => 'admin-customizer',
            'keywords'          => array('core', 'space', 'Shin'),
            'mode'              => 'edit', // auto, preview, edit
        ));
    }
}
