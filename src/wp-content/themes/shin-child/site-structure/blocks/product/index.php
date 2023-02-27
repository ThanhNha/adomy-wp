<?php
$args = array(
  'taxonomy' =>
'product_cat', 'orderby' => 'name', 'pad_counts' => false, 'hierarchical' => 1,
'hide_empty' => false ); $categories = get_categories( $args ); ?>

<section class="section" id="section_940871986">
		<div class="section-content relative">
    	<div id="gap-328431422" class="gap-element clearfix" style="display:block; height:auto;">
        <style>
        #gap-328431422 {
          padding-top: 30px;
        }
        #text-989852705 {
          font-size: 1.1rem;
          text-align: center;
          color: rgb(35, 53, 89);
        }
        #text-989852705 > * {
          color: rgb(35, 53, 89);
        }
        </style>
	  </div>
    <div class="row" id="row-2140920540">
      <div id="col-185877730" class="col no-padding small-12 large-12">
            <div class="col-inner">
              <div id="text-989852705" class="text">
                <h2 class="uppercase">Xu hướng mua sắm phổ biến</h2>
            </div>
        </div>
            
      </div>

      

    </div>
   
    <div class="row">
      <div class="col small-12 large-12">
          <div class="tabbed-content home-tab-categories">
            <ul
              class="nav nav-line slider nav-uppercase nav-size-normal nav-left"
              role="tablist"
              data-flickity-options='{
                "contain": true,
                "cellAlign": "left",
                "prevNextButtons"
                :true, "pageDots" :
                false, "rightToLeft" : false }'
            >
            <?php
            $index = 0;
              foreach ( $categories as $category ) { $index++;?>
              <li id="<?php echo $category->cat_ID ;?>"  class="tab has-icon <?php if($index === 1)  {echo 'active'; }?>" role="presentation">
                <a onclick="fetch(<?php echo $category->cat_ID ; ?>)"
                href="#<?php echo $category->cat_ID ; ?> "
                role="tab"
                  aria-selected="true"
                  aria-controls="<?php echo $category->slug ; ?><" ><span class="uppercase"><?php echo $category->name ; ?></span></a
                >
              </li>

              <?php } ?>

            </ul>
          </div>
          <div class="search_bar">
            <div class="search_result" id="datafetch">
            
            </div>
          </div>
        </div>
      </div>
		</div>
	</section>
