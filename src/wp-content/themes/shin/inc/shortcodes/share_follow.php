<?php
// [share]
function flatsome_share($atts, $content = null)
{
	extract(shortcode_atts(array(
		'title'  => '',
		'class'	=> '',
		'visibility' => '',
		'size' => '',
		'align' => '',
		'scale' => '',
		'style' => '',
	), $atts));

	// Get Custom Share icons if set
	if (get_theme_mod('custom_share_icons')) {
		return do_shortcode(get_theme_mod('custom_share_icons'));
	}

	$wrapper_class = array('social-icons', 'share-icons', 'share-row', 'relative');
	if ($class) $wrapper_class[] = $class;
	if ($visibility) $wrapper_class[] = $visibility;
	if ($align) {
		$wrapper_class[] = 'full-width';
		$wrapper_class[] = 'text-' . $align;
	}
	if ($style) $wrapper_class[] = 'icon-style-' . $style;


	$link = get_permalink();

	if (is_woocommerce_activated()) {
		if (is_shop()) {
			$link = get_permalink(wc_get_page_id('shop'));
		}
		if (is_product_category() || is_category()) {
			$link = get_category_link(get_queried_object()->term_id);
		}
	}

	if (is_home() && !is_front_page()) {
		$link = get_permalink(get_option('page_for_posts'));
	}

	$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
	$share_img      = $featured_image ? $featured_image['0'] : '';
	$post_title     = rawurlencode(get_the_title());
	$whatsapp_text  = $post_title . ' - ' . $link;

	if ($title) $title = '<span class="share-icons-title">' . $title . '</span>';

	// Style default

	// Get Custom Theme Style
	if (!$style) $style = get_theme_mod('social_icons_style', 'outline');

	$classes = get_flatsome_icon_class($style);
	$classes = $classes . ' tooltip';

	$share = get_theme_mod('social_icons', array('facebook', 'twitter', 'email', 'linkedin', 'pinterest', 'whatsapp'));

	// Scale
	if ($scale) $scale = 'style="font-size:' . $scale . '%"';


	// Fix old depricated
	if (!isset($share[0])) {
		$fix_share = array();
		foreach ($share as $key => $value) {
			if ($value == '1') $fix_share[] = $key;
		}
		$share = $fix_share;
	}

	ob_start();

?>

	<div class="<?php echo implode(' ', $wrapper_class); ?>" <?php echo $scale; ?>>
		<div class="text-social"><span>Chia sẻ</span></div>
		<div class="wrapper-icons-social">
			<?php echo $title; ?>
			<?php if (in_array('whatsapp', $share)) { ?>
				<a href="whatsapp://send?text=<?php echo $whatsapp_text; ?>" data-action="share/whatsapp/share" class="<?php echo $classes; ?> whatsapp show-for-medium" title="<?php _e('Share on WhatsApp', 'flatsome'); ?>" aria-label="<?php esc_attr_e('Share on WhatsApp', 'flatsome'); ?>"><i class="icon-whatsapp"></i></a>
			<?php }
			if (in_array('facebook', $share)) { ?>
				<a href="https://www.facebook.com/sharer.php?u=<?php echo $link; ?>" data-label="Facebook" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" target="_blank" class="<?php echo $classes; ?> facebook" title="<?php _e('Share on Facebook', 'flatsome'); ?>" aria-label="<?php esc_attr_e('Share on Facebook', 'flatsome'); ?>"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M18.75 10.0527C18.75 5.2207 14.832 1.30273 10 1.30273C5.16797 1.30273 1.25 5.2207 1.25 10.0527C1.25 14.4199 4.44922 18.0398 8.63281 18.6969V12.5828H6.41055V10.0527H8.63281V8.125C8.63281 5.93242 9.93945 4.72031 11.9379 4.72031C12.8953 4.72031 13.8969 4.89141 13.8969 4.89141V7.04492H12.793C11.7066 7.04492 11.3668 7.71914 11.3668 8.41211V10.0527H13.7934L13.4059 12.5828H11.3672V18.6977C15.5508 18.041 18.75 14.4211 18.75 10.0527Z" fill="currentColor" />
					</svg></a>
			<?php }
			if (in_array('pinterest', $share)) { ?>
				<a href="https://www.instagram.com?url=<?php echo $link; ?>" data-label="Instagram" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" target="_blank" class="<?php echo $classes; ?> pinterest" title="<?php _e('Share on Instagram', 'flatsome'); ?>" aria-label="<?php esc_attr_e('Pin on Pinterest', 'flatsome'); ?>"><svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M14.114 2.7082C15.0801 2.71109 16.0058 3.09616 16.689 3.77931C17.3721 4.46246 17.7572 5.38818 17.7601 6.3543V13.6457C17.7572 14.6118 17.3721 15.5375 16.689 16.2207C16.0058 16.9038 15.0801 17.2889 14.114 17.2918H6.82256C5.85644 17.2889 4.93072 16.9038 4.24757 16.2207C3.56442 15.5375 3.17935 14.6118 3.17646 13.6457V6.3543C3.17935 5.38818 3.56442 4.46246 4.24757 3.77931C4.93072 3.09616 5.85644 2.71109 6.82256 2.7082H14.114ZM14.114 1.25H6.82256C4.01514 1.25 1.71826 3.54687 1.71826 6.3543V13.6457C1.71826 16.4531 4.01514 18.75 6.82256 18.75H14.114C16.9214 18.75 19.2183 16.4531 19.2183 13.6457V6.3543C19.2183 3.54687 16.9214 1.25 14.114 1.25Z" fill="currentColor" />
						<path d="M15.2077 6.35449C14.9914 6.35449 14.7799 6.29035 14.6001 6.17016C14.4202 6.04998 14.28 5.87916 14.1972 5.6793C14.1144 5.47945 14.0928 5.25953 14.135 5.04736C14.1772 4.8352 14.2814 4.64031 14.4343 4.48734C14.5873 4.33438 14.7822 4.23021 14.9943 4.18801C15.2065 4.14581 15.4264 4.16747 15.6263 4.25025C15.8261 4.33303 15.997 4.47322 16.1171 4.65309C16.2373 4.83295 16.3015 5.04442 16.3015 5.26074C16.3018 5.40446 16.2737 5.54683 16.2188 5.67967C16.164 5.81251 16.0834 5.9332 15.9818 6.03483C15.8802 6.13646 15.7595 6.21701 15.6266 6.27186C15.4938 6.32672 15.3514 6.3548 15.2077 6.35449ZM10.4683 7.0834C11.0452 7.0834 11.6091 7.25447 12.0887 7.57497C12.5684 7.89547 12.9423 8.35101 13.163 8.88399C13.3838 9.41696 13.4416 10.0034 13.329 10.5692C13.2165 11.135 12.9387 11.6548 12.5308 12.0627C12.1228 12.4706 11.6031 12.7484 11.0373 12.8609C10.4715 12.9735 9.88503 12.9157 9.35205 12.695C8.81908 12.4742 8.36354 12.1003 8.04304 11.6207C7.72253 11.141 7.55147 10.5771 7.55147 10.0002C7.55229 9.22687 7.85986 8.48545 8.40669 7.93862C8.95352 7.3918 9.69494 7.08423 10.4683 7.0834ZM10.4683 5.6252C9.60297 5.6252 8.75711 5.88178 8.03764 6.36252C7.31818 6.84325 6.75742 7.52653 6.42629 8.32595C6.09516 9.12538 6.00852 10.005 6.17733 10.8537C6.34614 11.7024 6.76282 12.4819 7.37467 13.0938C7.98653 13.7056 8.76608 14.1223 9.61474 14.2911C10.4634 14.4599 11.3431 14.3733 12.1425 14.0422C12.9419 13.711 13.6252 13.1503 14.1059 12.4308C14.5867 11.7113 14.8433 10.8655 14.8433 10.0002C14.8433 8.83987 14.3823 7.72708 13.5619 6.9066C12.7414 6.08613 11.6286 5.6252 10.4683 5.6252Z" fill="currentColor" />
					</svg></a>
			<?php }
			if (in_array('twitter', $share)) { ?>
				<a href="https://twitter.com/share?url=<?php echo $link; ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" target="_blank" class="<?php echo $classes; ?> twitter" title="<?php _e('Share on Twitter', 'flatsome'); ?>" aria-label="<?php esc_attr_e('Share on Twitter', 'flatsome'); ?>"><svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_1242_2523)">
							<path d="M20.3115 4.27735C19.6082 4.58296 18.864 4.7843 18.1025 4.87501C18.9028 4.4064 19.5046 3.66195 19.7951 2.78126C19.0385 3.22368 18.2121 3.5341 17.3514 3.69923C16.9889 3.31935 16.553 3.01716 16.0701 2.811C15.5872 2.60484 15.0674 2.49904 14.5424 2.50001C12.4166 2.50001 10.6963 4.19532 10.6963 6.28516C10.6948 6.57585 10.7281 6.86568 10.7955 7.14844C9.27117 7.07698 7.77853 6.68813 6.41308 6.00675C5.04763 5.32537 3.83945 4.36648 2.86582 3.19141C2.52425 3.76724 2.34361 4.42424 2.34277 5.09376C2.34277 6.40626 3.02754 7.56641 4.06152 8.2461C3.44892 8.23156 2.84886 8.06942 2.3123 7.77344V7.82032C2.3123 9.65626 3.64043 11.1836 5.39824 11.5313C5.06769 11.6194 4.72706 11.664 4.38496 11.6641C4.14222 11.6645 3.90003 11.6409 3.66191 11.5938C4.15059 13.0977 5.57285 14.1914 7.25762 14.2227C5.88862 15.2777 4.20786 15.848 2.47949 15.8438C2.1727 15.8433 1.8662 15.825 1.56152 15.7891C3.3198 16.9118 5.36365 17.5057 7.4498 17.5C14.5342 17.5 18.4045 11.7305 18.4045 6.72657C18.4045 6.56251 18.4002 6.39844 18.3924 6.23829C19.1436 5.70394 19.7935 5.03989 20.3115 4.27735Z" fill="currentColor" />
						</g>
						<defs>
							<clipPath id="clip0_1242_2523">
								<rect width="20" height="20" fill="white" transform="translate(0.936523)" />
							</clipPath>
						</defs>
					</svg></a>
			<?php }
			if (in_array('email', $share)) { ?>
				<a href="mailto:enteryour@addresshere.com?subject=<?php echo $post_title; ?>&amp;body=Check%20this%20out:%20<?php echo $link; ?>" rel="nofollow" class="<?php echo $classes; ?> email" title="<?php _e('Email to a Friend', 'flatsome'); ?>" aria-label="<?php esc_attr_e('Email to a Friend', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-envelop'); ?></a>
			<?php }

			if (in_array('vk', $share)) { ?>
				<a href="https://vkontakte.ru/share.php?url=<?php echo $link; ?>" target="_blank" class="<?php echo $classes; ?> vk" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" title="<?php _e('Share on VKontakte', 'flatsome'); ?>" aria-label="<?php esc_attr_e('Share on VKontakte', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-vk'); ?></a>
			<?php }
			if (in_array('linkedin', $share)) { ?>
				<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $link; ?>&title=<?php echo $post_title; ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" target="_blank" class="<?php echo $classes; ?> linkedin" title="<?php _e('Share on LinkedIn', 'flatsome'); ?>" aria-label="<?php esc_attr_e('Share on LinkedIn', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-linkedin'); ?></a>
			<?php }
			if (in_array('tumblr', $share)) { ?>
				<a href="https://tumblr.com/widgets/share/tool?canonicalUrl=<?php echo $link; ?>" target="_blank" class="<?php echo $classes; ?> tumblr" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" title="<?php _e('Share on Tumblr', 'flatsome'); ?>" aria-label="<?php esc_attr_e('Share on Tumblr', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-tumblr'); ?></a>
			<?php }
			if (in_array('telegram', $share)) { ?>
				<a href="https://telegram.me/share/url?url=<?php echo $link; ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" target="_blank" class="<?php echo $classes; ?> telegram" title="<?php _e('Share on Telegram', 'flatsome'); ?>" aria-label="<?php esc_attr_e('Share on Telegram', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-telegram'); ?></a>
			<?php } ?>
		</div>
	</div>

<?php
	$content = ob_get_contents();
	ob_end_clean();
	$content = flatsome_sanitize_whitespace_chars($content);
	return $content;
}
add_shortcode('share', 'flatsome_share');


// [follow]
function flatsome_follow($atts, $content = null)
{

	extract(shortcode_atts(array(
		'title' => '',
		'class' => '',
		'visibility' => '',
		'style' => 'outline',
		'align' => '',
		'scale' => '',
		'twitter' => '',
		'facebook' => '',
		'pinterest' => '',
		'email' => '',
		'phone' => '',
		'instagram' => '',
		'tiktok' => '',
		'rss' => '',
		'linkedin' => '',
		'youtube' => '',
		'flickr' => '',
		'vkontakte' => '',
		'px500' => '',
		'telegram' => '',
		'twitch' => '',
		'discord' => '',
		'snapchat' => '',

		// Depricated
		'size' => '',

	), $atts));
	ob_start();


	$wrapper_class = array('social-icons', 'follow-icons');
	if ($class) $wrapper_class[] = $class;
	if ($visibility) $wrapper_class[] = $visibility;
	if ($align) {
		$wrapper_class[] = 'full-width';
		$wrapper_class[] = 'text-' . $align;
	}

	// Use global follow links if non is set individually.
	$has_custom_link = $twitter || $facebook || $instagram || $tiktok || $snapchat || $youtube || $pinterest || $linkedin || $px500 || $vkontakte || $telegram || $flickr || $email || $phone || $rss || $twitch || $discord;

	if (!$has_custom_link) {
		$twitter   = get_theme_mod('follow_twitter');
		$facebook  = get_theme_mod('follow_facebook');
		$instagram = get_theme_mod('follow_instagram');
		$tiktok    = get_theme_mod('follow_tiktok');
		$snapchat  = get_theme_mod('follow_snapchat');
		$youtube   = get_theme_mod('follow_youtube');
		$pinterest = get_theme_mod('follow_pinterest');
		$linkedin  = get_theme_mod('follow_linkedin');
		$px500     = get_theme_mod('follow_500px');
		$vkontakte = get_theme_mod('follow_vk');
		$telegram  = get_theme_mod('follow_telegram');
		$flickr    = get_theme_mod('follow_flickr');
		$email     = get_theme_mod('follow_email');
		$phone     = get_theme_mod('follow_phone');
		$rss       = get_theme_mod('follow_rss');
		$twitch    = get_theme_mod('follow_twitch');
		$discord   = get_theme_mod('follow_discord');
	}

	if ($size == 'small') $style = 'small';
	$style = get_flatsome_icon_class($style);

	// Scale
	if ($scale) $scale = 'style="font-size:' . $scale . '%"';


?>
	<div class="<?php echo implode(' ', $wrapper_class); ?>" <?php echo $scale; ?>>
		<?php if ($title) { ?>
			<span><?php echo $title; ?></span>
		<?php } ?>
		<?php if ($facebook) { ?>
			<a href="<?php echo $facebook; ?>" target="_blank" data-label="Facebook" rel="noopener noreferrer nofollow" class="<?php echo $style; ?> facebook tooltip" title="<?php _e('Follow on Facebook', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on Facebook', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-facebook'); ?>
			</a>
		<?php } ?>
		<?php if ($instagram) { ?>
			<a href="<?php echo $instagram; ?>" target="_blank" rel="noopener noreferrer nofollow" data-label="Instagram" class="<?php echo $style; ?>  instagram tooltip" title="<?php _e('Follow on Instagram', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on Instagram', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-instagram'); ?>
			</a>
		<?php } ?>
		<?php if ($tiktok) { ?>
			<a href="<?php echo $tiktok; ?>" target="_blank" rel="noopener noreferrer nofollow" data-label="TikTok" class="<?php echo $style; ?> tiktok tooltip" title="<?php _e('Follow on TikTok', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on TikTok', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-tiktok'); ?>
			</a>
		<?php } ?>
		<?php if ($snapchat) { ?>
			<a href="#" data-open="#follow-snapchat-lightbox" data-color="dark" data-pos="center" target="_blank" rel="noopener noreferrer nofollow" data-label="SnapChat" class="<?php echo $style; ?> snapchat tooltip" title="<?php _e('Follow on SnapChat', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on SnapChat', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-snapchat'); ?>
			</a>
			<div id="follow-snapchat-lightbox" class="mfp-hide">
				<div class="text-center">
					<?php echo do_shortcode(flatsome_get_image($snapchat)); ?>
					<p><?php _e('Point the SnapChat camera at this to add us to SnapChat.', 'flatsome'); ?></p>
				</div>
			</div>
		<?php } ?>
		<?php if ($twitter) { ?>
			<a href="<?php echo $twitter; ?>" target="_blank" data-label="Twitter" rel="noopener noreferrer nofollow" class="<?php echo $style; ?>  twitter tooltip" title="<?php _e('Follow on Twitter', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on Twitter', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-twitter'); ?>
			</a>
		<?php } ?>
		<?php if ($email) { ?>
			<a href="mailto:<?php echo $email; ?>" data-label="E-mail" rel="nofollow" class="<?php echo $style; ?>  email tooltip" title="<?php _e('Send us an email', 'flatsome') ?>" aria-label="<?php esc_attr_e('Send us an email', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-envelop'); ?>
			</a>
		<?php } ?>
		<?php if ($phone) { ?>
			<a href="tel:<?php echo $phone; ?>" target="_blank" data-label="Phone" rel="noopener noreferrer nofollow" class="<?php echo $style; ?>  phone tooltip" title="<?php _e('Call us', 'flatsome') ?>" aria-label="<?php esc_attr_e('Call us', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-phone'); ?>
			</a>
		<?php } ?>
		<?php if ($pinterest) { ?>
			<a href="<?php echo $pinterest; ?>" target="_blank" rel="noopener noreferrer nofollow" data-label="Pinterest" class="<?php echo $style; ?>  pinterest tooltip" title="<?php _e('Follow on Pinterest', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on Pinterest', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-pinterest'); ?>
			</a>
		<?php } ?>
		<?php if ($rss) { ?>
			<a href="<?php echo $rss; ?>" target="_blank" rel="noopener noreferrer nofollow" data-label="RSS Feed" class="<?php echo $style; ?>  rss tooltip" title="<?php _e('Subscribe to RSS', 'flatsome') ?>" aria-label="<?php esc_attr_e('Subscribe to RSS', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-feed'); ?></a>
		<?php } ?>
		<?php if ($linkedin) { ?>
			<a href="<?php echo $linkedin; ?>" target="_blank" rel="noopener noreferrer nofollow" data-label="LinkedIn" class="<?php echo $style; ?>  linkedin tooltip" title="<?php _e('Follow on LinkedIn', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on LinkedIn', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-linkedin'); ?></a>
		<?php } ?>
		<?php if ($youtube) { ?>
			<a href="<?php echo $youtube; ?>" target="_blank" rel="noopener noreferrer nofollow" data-label="YouTube" class="<?php echo $style; ?>  youtube tooltip" title="<?php _e('Follow on YouTube', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on YouTube', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-youtube'); ?>
			</a>
		<?php } ?>
		<?php if ($flickr) { ?>
			<a href="<?php echo $flickr; ?>" target="_blank" rel="noopener noreferrer nofollow" data-label="Flickr" class="<?php echo $style; ?>  flickr tooltip" title="<?php _e('Flickr', 'flatsome') ?>" aria-label="<?php esc_attr_e('Flickr', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-flickr'); ?>
			</a>
		<?php } ?>
		<?php if ($px500) { ?>
			<a href="<?php echo $px500; ?>" target="_blank" data-label="500px" rel="noopener noreferrer nofollow" class="<?php echo $style; ?> px500 tooltip" title="<?php _e('Follow on 500px', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on 500px', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-500px'); ?>
			</a>
		<?php } ?>
		<?php if ($vkontakte) { ?>
			<a href="<?php echo $vkontakte; ?>" target="_blank" data-label="VKontakte" rel="noopener noreferrer nofollow" class="<?php echo $style; ?> vk tooltip" title="<?php _e('Follow on VKontakte', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on VKontakte', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-vk'); ?>
			</a>
		<?php } ?>
		<?php if ($telegram) { ?>
			<a href="<?php echo $telegram; ?>" target="_blank" data-label="Telegram" rel="noopener noreferrer nofollow" class="<?php echo $style; ?> telegram tooltip" title="<?php _e('Follow on Telegram', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on Telegram', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-telegram'); ?>
			</a>
		<?php } ?>
		<?php if ($twitch) { ?>
			<a href="<?php echo $twitch; ?>" target="_blank" data-label="Twitch" rel="noopener noreferrer nofollow" class="<?php echo $style; ?> twitch tooltip" title="<?php _e('Follow on Twitch', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on Twitch', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-twitch'); ?>
			</a>
		<?php } ?>
		<?php if ($discord) { ?>
			<a href="<?php echo $discord; ?>" target="_blank" data-label="Discord" rel="noopener noreferrer nofollow" class="<?php echo $style; ?> discord tooltip" title="<?php _e('Follow on Discord', 'flatsome') ?>" aria-label="<?php esc_attr_e('Follow on Discord', 'flatsome'); ?>"><?php echo get_flatsome_icon('icon-discord'); ?>
			</a>
		<?php } ?>
	</div>

<?php
	$content = ob_get_contents();
	ob_end_clean();
	$content = flatsome_sanitize_whitespace_chars($content);
	return $content;
}
add_shortcode("follow", "flatsome_follow");
