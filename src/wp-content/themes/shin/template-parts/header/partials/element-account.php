<?php
/**
 * Account element.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

$icon_style = get_theme_mod('account_icon_style');
?>
<?php if(is_woocommerce_activated()){ ?>
<li class="account-item has-icon
  <?php if(is_account_page()) echo ' active'; ?>
  <?php if ( is_user_logged_in() ) { ?> has-dropdown<?php } ?>"
>
<?php if($icon_style && $icon_style !== 'image' && $icon_style !== 'plain') echo '<div class="header-button">'; ?>

<?php if ( is_user_logged_in() ) { ?>
<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="account-link account-login
  <?php if($icon_style && $icon_style !== 'image') echo get_flatsome_icon_class($icon_style, 'small'); ?>"
  title="<?php _e('Tài khoản', 'woocommerce'); ?>">

	<?php if ( get_theme_mod( 'header_account_title', 1 ) ) { ?>
		<span class="header-account-title">
		<?php
		if ( get_theme_mod( 'header_account_username' ) ) {
			$current_user = wp_get_current_user();
			echo apply_filters( 'flatsome_header_account_username', esc_html( $current_user->display_name ) );
		} else {
			esc_html_e( 'Tài khoản', 'woocommerce' );
		}
		?>
		</span>
	<?php } ?>

  <?php if($icon_style == 'image'){
    echo '<i class="image-icon circle">'.get_avatar(get_current_user_id()).'</i>';
   } else  if($icon_style){
    echo '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M13.4375 5.625C13.2844 7.69023 11.7188 9.375 10 9.375C8.28128 9.375 6.71292 7.69063 6.56253 5.625C6.40628 3.47656 7.92972 1.875 10 1.875C12.0704 1.875 13.5938 3.51562 13.4375 5.625Z" stroke="#233559" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M9.99998 11.875C6.60154 11.875 3.15232 13.75 2.51404 17.2891C2.43708 17.7156 2.67849 18.125 3.12497 18.125H16.875C17.3219 18.125 17.5633 17.7156 17.4863 17.2891C16.8476 13.75 13.3984 11.875 9.99998 11.875Z" stroke="#233559" stroke-miterlimit="10"/>
    </svg>
    ';
   } ?>

</a>

<?php } else { ?>
<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"
    class="nav-top-link nav-top-not-logged-in account-link account-login <?php if($icon_style && $icon_style !== 'image') echo get_flatsome_icon_class($icon_style, 'small'); ?>"
    <?php if( get_theme_mod('account_login_style','lightbox') == 'lightbox' && !is_checkout() && !is_account_page() ) echo 'data-open="#login-form-popup"'; ?>
  >
  <?php if(get_theme_mod('header_account_title', 1)) { ?>
  <span class="header-account-title">
    <?php _e('Tài khoản', 'woocommerce'); ?>

    <?php if(get_theme_mod('header_account_register')){
        echo ' / '.__('Register', 'woocommerce');
      } ?>
  </span>
  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M13.4375 5.625C13.2844 7.69023 11.7188 9.375 10 9.375C8.28128 9.375 6.71292 7.69063 6.56253 5.625C6.40628 3.47656 7.92972 1.875 10 1.875C12.0704 1.875 13.5938 3.51562 13.4375 5.625Z" stroke="#233559" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M9.99998 11.875C6.60154 11.875 3.15232 13.75 2.51404 17.2891C2.43708 17.7156 2.67849 18.125 3.12497 18.125H16.875C17.3219 18.125 17.5633 17.7156 17.4863 17.2891C16.8476 13.75 13.3984 11.875 9.99998 11.875Z" stroke="#233559" stroke-miterlimit="10"/>
    </svg>
  <?php } else {
        echo get_flatsome_icon('icon-user');
    } ?>

</a>
<?php } ?>

<?php if($icon_style && $icon_style !== 'image' && $icon_style !== 'plain') echo '</div>'; ?>

<?php
// Show Dropdown for logged in users
if ( is_user_logged_in() ) { ?>
<ul class="nav-dropdown  <?php flatsome_dropdown_classes(); ?>">
    <?php wc_get_template('myaccount/account-links.php'); ?>
</ul>
<?php } ?>

</li>
<?php } else {
	fl_header_element_error( 'woocommerce' );
}
?>
