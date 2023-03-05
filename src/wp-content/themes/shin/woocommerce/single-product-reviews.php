<?php

/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see              https://docs.woocommerce.com/document/template-structure/
 * @package          WooCommerce/Templates
 * @version          4.3.0
 * @flatsome-version 3.16.0
 */

defined('ABSPATH') || exit;

global $product;

if (!comments_open()) {
	return;
}

$tab_style              = get_theme_mod('product_display');
$review_ratings_enabled = wc_review_ratings_enabled();
?>
<div id="reviews" class="woocommerce-Reviews row">
	<div id="comments" class="col large-<?php if (get_comment_pages_count() == 0 || $tab_style == 'sections' || $tab_style == 'tabs_vertical') {
											echo '12';
										} else {
											echo '12';
										} ?>">
		<h3 class="woocommerce-Reviews-title normal">
			<?php
			$count = $product->get_review_count();
			if ($count && $review_ratings_enabled) {
				/* translators: 1: reviews count 2: product name */
				$reviews_title = sprintf(esc_html(_n('%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce')), esc_html($count), '<span>' . get_the_title() . '</span>');
				echo apply_filters('woocommerce_reviews_title', $reviews_title, $count, $product); // WPCS: XSS ok.
			} else {
				esc_html_e('Reviews', 'woocommerce');
			}
			?>
		</h3>

		<?php if (have_comments()) : ?>
			<ol class="commentlist">
				<?php wp_list_comments(apply_filters('woocommerce_product_review_list_args', array('callback' => 'woocommerce_comments'))); ?>
			</ol>

			<?php
			if (get_comment_pages_count() > 1 && get_option('page_comments')) :
				echo '<nav class="woocommerce-pagination">';
				$pagination = paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type'      => 'list',
							'echo'      => false,
						)
					)
				);
				$pagination = str_replace('page-numbers', 'page-number', $pagination);
				$pagination = str_replace("<ul class='page-number'>", '<ul class="page-numbers nav-pagination links text-center">', $pagination);
				echo $pagination;
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e('There are no reviews yet.', 'woocommerce'); ?></p>
		<?php endif; ?>
	</div>

	<?php if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())) : ?>
		<div id="review_form_wrapper" class="large-<?php if (get_comment_pages_count() == 0 || $tab_style == 'sections' || $tab_style == 'tabs_vertical') {
														echo '12';
													} else {
														echo '12';
													} ?> col">
			<div id="review_form" class="col-inner">
				<div class="review-form-inner">
					<?php
					$commenter    = wp_get_current_commenter();
					$comment_form = array(
						/* translators: %s is product title */
						'title_reply'          => have_comments() ? esc_html__('VIẾT ĐÁNH GIÁ', 'woocommerce') : sprintf(esc_html__('Be the first to review &ldquo;%s&rdquo;', 'woocommerce'), get_the_title()),
						/* translators: %s is product title */
						'title_reply_to'       => esc_html__('Leave a Reply to %s', 'woocommerce'),
						'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
						'title_reply_after'    => '</h3>',
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'label_submit'         => esc_html__('GỬI ĐÁNH GIÁ', 'woocommerce'),
						'logged_in_as'         => '',
						'comment_field'        => '',
					);
					$name_email_required = (bool) get_option('require_name_email', 1);
					$fields              = array(
						'author' => array(
							'label'    => __('Họ và tên', 'woocommerce'),
							'type'     => 'text',
							'value'    => $commenter['comment_author'],
							'required' => $name_email_required,
						),
						'email'  => array(
							'label'    => __('Email', 'woocommerce'),
							'type'     => 'email',
							'value'    => $commenter['comment_author_email'],
							'required' => $name_email_required,
						),
					);

					$comment_form['fields'] = array();

					foreach ($fields as $key => $field) {
						$field_html  = '<p class="comment-form-' . esc_attr($key) . '">';
						$field_html .= '<label for="' . esc_attr($key) . '">' . esc_html($field['label']);

						if ($field['required']) {
							$field_html .= '&nbsp;<span class="required">*</span>';
						}

						$field_html .= '</label><input id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" type="' . esc_attr($field['type']) . '" value="' . esc_attr($field['value']) . '" size="30" ' . ($field['required'] ? 'required' : '') . ' /></p>';

						$comment_form['fields'][$key] = $field_html;
					}

					$account_page_url = wc_get_page_permalink('myaccount');
					if ($account_page_url) {
						/* translators: %s opening and closing link tags respectively */
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf(esc_html__('You must be %1$slogged in%2$s to post a review.', 'woocommerce'), '<a href="' . esc_url($account_page_url) . '">', '</a>') . '</p>';
					}

					if ($review_ratings_enabled) {
						$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . (wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '') . '</label>

						<div class="rating">
					<input type="radio" id="star1" name="rating"
					value="1" /><label class="full" for="star1"
					title="'. esc_html__('Perfect', 'woocommerce') .'"></label>
					<input type="radio" id="star2" name="rating"
					value="2" />	<label class="full" for="star2"
					title="'. esc_html__('Not that bad', 'woocommerce') .'"></label>


					<input type="radio" id="star3" name="rating"
					value="3" /><label class="full" for="star3"
					title="'. esc_html__('Average', 'woocommerce') .'"></label>


					<input type="radio" id="star4" name="rating"
					value="4" />
					<label class="full" for="star4"
					title="' . esc_html__('Not that bad', 'woocommerce') . '"></label>
				
					<input type="radio" id="star5" name="rating"
					value="5" />
					<label class="full" for="star5"
					title="' . esc_html__('Very poor', 'woocommerce') . '"></label>
					
				</div>
						</div>
				
					';
					}
					$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__('Đánh giá của bạn', 'woocommerce') . '</label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

					comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
					?>
				</div>
			</div>
		</div>

	<?php else : ?>
		<div id="review_form_wrapper" class="large-<?php if (get_comment_pages_count() == 0 || $tab_style == 'sections' || $tab_style == 'tabs_vertical') {
														echo '12';
													} else {
														echo '12';
													} ?> col">
			<div id="review_form" class="col-inner">
				<div class="review-form-inner has-border">
					<p class="woocommerce-verification-required">
						<?php esc_html_e('Only logged in customers who have purchased this product may leave a review.', 'woocommerce'); ?>
					</p>
				</div>
			</div>
		</div>
	<?php endif; ?>

</div>