<?php
/**
 * Checkout terms and conditions area.
 *
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

 defined( 'ABSPATH' ) || exit;

 if ( apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) {
	 do_action( 'woocommerce_checkout_before_terms_and_conditions' );
 
	 ?>
	 <div class="woocommerce-terms-and-conditions-wrapper">
		 <?php
		 /**
		  * Terms and conditions hook used to inject content.
		  *
		  * @since 3.4.0.
		  * @hooked wc_checkout_privacy_policy_text() Shows custom privacy policy text. Priority 20.
		  * @hooked wc_terms_and_conditions_page_content() Shows t&c page content. Priority 30.
		  */
		 do_action( 'woocommerce_checkout_terms_and_conditions' );
		 ?>
 
		 <?php if ( wc_terms_and_conditions_checkbox_enabled() ) : ?>
			 <p class="form-row validate-required">
				 <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					 <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', false ), false ); ?> id="terms" />
					 <span class="woocommerce-terms-and-conditions-checkbox-text"><?php wc_terms_and_conditions_checkbox_text(); ?></span>&nbsp;<abbr class="required" title="<?php esc_attr_e( 'required', 'woocommerce' ); ?>">*</abbr>
				 </label>
				 <input type="hidden" name="terms-field" value="1" />
			 </p>
		 <?php endif; ?>
 
		 <!-- Custom Checkbox -->
		 <p class="form-row validate-required">
			 <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				 <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="legal_terms" <?php checked(false); ?> id="legal_terms"/>
				 <span class="woocommerce-legal-terms-checkbox-text">
					 <?php printf( __( 'I have read the legal terms available at %s', 'woocommerce' ), '<a href="' . esc_url( get_home_url() . '/legal/' ) . '" target="_blank">' . esc_html__( 'this link', 'woocommerce' ) . '</a>' ); ?>
				 </span>&nbsp;<abbr class="required" title="<?php esc_attr_e( 'required', 'woocommerce' ); ?>">*</abbr>
			 </label>
			 <input type="hidden" name="legal-terms-field" value="0" />
		 </p>
		 <!-- End Custom Checkbox -->
 
	 </div>
	 <?php
 
	 do_action( 'woocommerce_checkout_after_terms_and_conditions' );
 }
 ?>