<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="outer-form-wrapper">
    <h5><?php esc_html_e( 'Password Recovery', 'industrium' ); ?></h5>
    <form method="post" class="woocommerce-ResetPassword lost_reset_password">

        <p class="woocommerce-form-row form-row">
            <input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" placeholder="<?php esc_attr_e('Username or Email', 'industrium'); ?>" />
        </p>

        <div class="clear"></div>

        <?php do_action( 'woocommerce_lostpassword_form' ); ?>

        <p class="woocommerce-form-row form-row">
            <input type="hidden" name="wc_reset_password" value="true" />
            <button type="submit" class="woocommerce-Button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" value="<?php esc_attr_e( 'Reset password', 'industrium' ); ?>"><?php esc_html_e( 'Reset password', 'industrium' ); ?><svg viewBox="0 0 13 20"><polyline points="0.5 19.5 3 19.5 12.5 10 3 0.5"></polyline></svg></button>
        </p>

        <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

        <div class="form-attention">
            <?php echo wp_kses('<a href="' . esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') ) . '#customer_login') . '">Back</a> to Sign in', array(
                'a' => array(
                    'href' => true
                )
            )); ?>
        </div>

    </form>
</div>
<?php
do_action( 'woocommerce_after_lost_password_form' );
