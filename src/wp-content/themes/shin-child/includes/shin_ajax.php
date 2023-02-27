<?php 
/*
 ==================
 * WooCommerce Ajax Product Search Code
 * Live search product Search with Category filter
======================	 
*/

// the ajax function
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){
    if ($_POST['pcat']) {
        $product_cat_id = array(esc_attr( $_POST['pcat'] ));
    }else {
        $terms = get_terms( 'product_cat' ); 
        $product_cat_id = wp_list_pluck( $terms, 'term_id' );
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
    $cat = get_the_category_by_ID($product_cat_id);
    echo $cat;

    if( $the_query->have_posts() ) {
      echo '<div class="row large-columns-4 medium-columns-3 small-columns-2 row-small">';
      while( $the_query->have_posts() ): $the_query->the_post();
      $id = get_the_ID();
      $image = get_post_thumbnail_id($id);
      $product = wc_get_product($id);

      
      ?>

          <div
      class="product-small col has-hover product type-product post-<?php echo $id?> status-publish first instock product_cat-jomashop product_tag-man product_tag-river-island product_tag-t-shirt has-post-thumbnail shipping-taxable purchasable product-type-simple"
    >
      <div class="col-inner">
        <div class="badge-container absolute left top z-1"></div>
        <div class="product-small box">
          <div class="box-image">
            <div class="image-fade_in_back">
              <a
                href="<?php echo esc_url( post_permalink() ); ?>"
                aria-label="<?php the_title();?>"
              >
              <?php
              if( $image != 10){
                echo wp_get_attachment_image( $image, $size, "", array( "class" => "attachment-woocommerce_thumbnail size-woocommerce_thumbnail" ) );
              } else{
                echo '<img width="247" height="247" src="wp-content/uploads/woocommerce-placeholder.png" class="woocommerce-placeholder wp-post-image" alt="Placeholder" loading="lazy">';
              }
              ?>
              </a>
            </div>
            <div class="image-tools is-small top right show-on-hover">
              <div class="wishlist-icon">
                <button
                  class="wishlist-button button is-outline circle icon"
                  aria-label="Wishlist"
                >
                  <i class="icon-heart"></i>
                </button>
                <div class="wishlist-popup dark">
                  <div
                    class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo $id?> wishlist-fragment on-first-load"
                    data-fragment-ref="<?php echo $id?>"
                    data-fragment-options='{"base_url":"","in_default_wishlist":false,"is_single":false,"show_exists":false,"product_id":<?php echo $id?>,"parent_product_id":<?php echo $id?>,"product_type":"simple","show_view":false,"browse_wishlist_text":"Browse wishlist","already_in_wishslist_text":"The product is already in your wishlist!","product_added_text":"Product added!","heading_icon":"fa-heart-o","available_multi_wishlist":false,"disable_wishlist":false,"show_count":false,"ajax_loading":false,"loop_position":"after_add_to_cart","item":"add_to_wishlist"}'
                  >
                    <!-- ADD TO WISHLIST -->

                    <div class="yith-wcwl-add-button">
                      <a
                        href="?add_to_wishlist=<?php echo $id?>;_wpnonce=0cbb51d2a5"
                        class="add_to_wishlist single_add_to_wishlist"
                        data-product-id="<?php echo $id?>"
                        data-product-type="simple"
                        data-original-product-id="<?php echo $id?>"
                        data-title="Add to wishlist"
                        rel="nofollow"
                      >
                        <i class="yith-wcwl-icon fa fa-heart-o"></i>
                        <span>Add to wishlist</span>
                      </a>
                    </div>

                    <!-- COUNT TEXT -->
                  </div>
                </div>
              </div>
            </div>
            <div
              class="image-tools is-small hide-for-small bottom left show-on-hover"
            ></div>
          </div>

          <div class="box-text box-text-products">
            <div class="title-wrapper">
              <p
                class="category uppercase is-smaller no-text-overflow product-cat op-7"
              >
                <?php 
                  echo  $product->cat_name;
                ?>
                
              </p>
              <p class="name product-title woocommerce-loop-product__title">
                <a
                  href="<?php echo esc_url( post_permalink() ); ?>"
                  class="woocommerce-LoopProduct-link woocommerce-loop-product__link"
                  ><?php the_title();?></a
                >
              </p>
            </div>
            <div class="price-wrapper">
              <div
                class="star-rating star-rating--inline"
                role="img"
                aria-label="Rated 3.67 out of 5"
              >
                <span style="width: 73.4%"
                  >Rated <strong class="rating">3.67</strong> out of 5</span
                >
              </div>
              <span class="price"
                ><span class="woocommerce-Price-amount amount"
                  ><bdi
                    ><span class="woocommerce-Price-currencySymbol">$</span
                    ><?php echo $product->get_price_html()?></bdi
                  ></span
                ></span
              >
            </div>
          </div>
        </div>
      </div>
    </div>

      <?php endwhile;
     echo '</div>';



      wp_reset_postdata();  
    }
        else{
          echo '<div> No Data </div>';
        }


    die();
}