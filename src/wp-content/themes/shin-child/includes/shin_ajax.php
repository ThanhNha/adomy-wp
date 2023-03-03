<?php
/*
 ==================
 * WooCommerce Ajax Product Search Code
 * Live search product Search with Category filter
======================	 
*/

// the ajax function
add_action('wp_ajax_data_fetch', 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch', 'data_fetch');


function data_fetch()
{
  if ($_POST['pcat']) {
    $product_cat_id = array(esc_attr($_POST['pcat']));
  } else {
    $terms = get_terms('product_cat');
    $product_cat_id = wp_list_pluck($terms, 'term_id');
  }

  $the_query = new WP_Query(
    array(
      'posts_per_page' => 8,
      'post_type' => array('product'),

      'tax_query' => array(
        array(
          'taxonomy'  => 'product_cat',
          'field'     => 'term_id',
          'terms'     => $product_cat_id,
          'operator'  => 'IN',
        )
      )
    )
  );
  $cat = get_the_category_by_ID($product_cat_id[0]);

  if ($the_query->have_posts()) {
    echo '<div class="row large-columns-4 medium-columns-3 small-columns-2 row-small">';
    while ($the_query->have_posts()) : $the_query->the_post();
      $id = get_the_ID();
      $image = get_post_thumbnail_id($id);
      $product = wc_get_product($id);
      $$size = 'thumbnail';
?>

      <div class="product-small col has-hover product type-product post-<?php echo $id ?> status-publish first instock product_cat-jomashop product_tag-man product_tag-river-island product_tag-t-shirt has-post-thumbnail shipping-taxable purchasable product-type-simple">
        <div class="col-inner">
        <?php do_action('flatsome_sale_flash'); ?>
          <div class="product-small box">
            <div class="box-image">
              <div class="image-fade_in_back">
                <a href="<?php echo esc_url(post_permalink()); ?>" aria-label="<?php the_title(); ?>">
                  <?php
                  if ($image != 10) {
                    echo wp_get_attachment_image($image, $size, "", array("class" => "attachment-woocommerce_thumbnail size-woocommerce_thumbnail"));
                  } else {
                    echo '<img width="240" height="240" src="wp-content/uploads/woocommerce-placeholder.png" class="woocommerce-placeholder wp-post-image" alt="Placeholder" loading="lazy">';
                  }
                  ?>
                </a>
              </div>
              <div class="image-tools is-small top right show-on-hover">
                <?php do_action('flatsome_product_box_tools_top'); ?>
              </div>
              <div class="image-tools is-small hide-for-small bottom left show-on-hover">

              </div>
            </div>

            <div class="box-text box-text-products">
              <div class="title-wrapper">
                <p class="category uppercase is-smaller no-text-overflow product-cat op-7">
                  <?php
                  echo $cat;
                  ?>

                </p>
                <p class="name product-title woocommerce-loop-product__title">
                  <a href="<?php echo esc_url(post_permalink()); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><?php the_title(); ?></a>
                </p>
              </div>
              <div class="price-wrapper">
                <?php echo flatsome_get_rating_html($product->get_average_rating()); ?>
                <span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span><?php echo $product->get_price_html() ?></bdi></span></span>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php endwhile;
    echo '</div>';
    wp_reset_postdata();
  } else {
    echo '<div> No Data </div>';
  }


  die();
}
