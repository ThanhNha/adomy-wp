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

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 25);

//Change sort text 
add_filter('gettext', 'theme_sort_change', 20, 3);
function theme_sort_change($translated_text, $text, $domain){

     if (is_woocommerce()) {

          switch ($translated_text) {

               case 'Sort by latest':

                    $translated_text = __('Sắp xếp theo mới nhất', 'theme_text_domain');
                    break;
               case 'Sort by popularity':

                    $translated_text = __('Sắp xếp theo mức độ phổ biến', 'theme_text_domain');
                    break;
               case 'Sort by average rating':

                    $translated_text = __('Sắp xếp theo đánh giá', 'theme_text_domain');
                    break;
               case 'Sort by price: low to high':

                    $translated_text = __('Sắp xếp theo giá: thấp đến cao', 'theme_text_domain');
                    break;
               case 'Sort by price: high to low':

                    $translated_text = __('Sắp xếp theo giá: cao đến thấp', 'theme_text_domain');
                    break;

          }
     }
     return $translated_text;
}
