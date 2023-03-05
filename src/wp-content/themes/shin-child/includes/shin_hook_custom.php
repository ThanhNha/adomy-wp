<?php
function get_product_category_by_id($category_id)
{
     $term = get_term_by('id', $category_id, 'product_cat', 'ARRAY_A');
     return $term['name'];
}

/**
 * Custom currency and currency symbol
 */
add_filter('woocommerce_currencies', 'add_my_currency');
function add_my_currency($currencies)
{
     $currencies['Dong'] = __('Viet Nam Dong', 'woocommerce');
     return $currencies;
}
add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);
function add_my_currency_symbol($currency_symbol, $currency)
{
     switch ($currency) {
          case 'Dong':
               $currency_symbol = 'đ';
               break;
     }
     return $currency_symbol;
}

add_action('woocommerce_before_add_to_cart_quantity', 'shin_before_add_to_cart_btn');

function shin_before_add_to_cart_btn()
{
     echo '  <div class="text-quantity"><span>Số lượng</span></div>';
}
// To change add to cart text on single product page
add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text');
function woocommerce_custom_single_add_to_cart_text()
{
     return __('Thêm vào giỏ hàng', 'woocommerce');
}
// remove product meta
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
//remove product short description
// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
// add_action('woocommerce_single_product_summary', 'shin_woocommerce_template_single_excerpt', 20);

// function shin_woocommerce_template_single_excerpt()
// {
     
// }
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 25);