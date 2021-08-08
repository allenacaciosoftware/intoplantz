<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Wallet_System_For_Woocommerce
 * @subpackage Wallet_System_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace wallet_system_for_woocommerce_public.
 *
 * @package    Wallet_System_For_Woocommerce
 * @subpackage Wallet_System_For_Woocommerce/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Wallet_System_For_Woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function wsfw_public_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, WALLET_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'public/src/scss/wallet-system-for-woocommerce-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'mwb-public-min', WALLET_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'public/css/mwb-public.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function wsfw_public_enqueue_scripts() {

		wp_register_script( $this->plugin_name, WALLET_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'public/src/js/wallet-system-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'wsfw_public_param',
			array(
				'ajaxurl'                   => admin_url( 'admin-ajax.php' ),
				'nonce'                     => wp_create_nonce( 'ajax-nonce' ),
				'datatable_pagination_text' => __( 'Rows per page _MENU_', 'wallet-system-for-woocommerce' ),
				'datatable_info'            => __(
					'_START_ - _END_ of _TOTAL_',
					'wallet-system-for-woocommerce'
				),
				'wsfw_ajax_error'               => __( 'An error occured!', 'woocommerce-wallet-system' ),
				'wsfw_amount_error'             => __( 'Enter amount greater than 0', 'wallet-system-for-woocommerce' ),
				'wsfw_partial_payment_msg'      => __( 'Amount want to use from wallet', 'wallet-system-for-woocommerce' ),
				'wsfw_apply_wallet_msg'         => __( 'Apply wallet', 'wallet-system-for-woocommerce' ),
				'wsfw_transfer_amount_error'    => __( 'Transfer amount should be less than or equal to wallet balance.', 'wallet-system-for-woocommerce' ),
				'wsfw_withdrawal_amount_error'  => __( 'Withdrawal amount should be less than or equal to wallet balance.', 'wallet-system-for-woocommerce' ),
				'wsfw_recharge_minamount_error' => __( 'Recharge amount should be greater than or equal to ', 'wallet-system-for-woocommerce' ),
				'wsfw_recharge_maxamount_error' => __( 'Recharge amount should be less than or equal to ', 'wallet-system-for-woocommerce' ),
			)
		);
		wp_enqueue_script( $this->plugin_name );
		global $wp_query;
		$is_endpoint = isset( $wp_query->query_vars['mwb-wallet'] ) ? $wp_query->query_vars['mwb-wallet'] : '';
		if ( ( 'wallet-transactions' === $is_endpoint || 'wallet-withdrawal' === $is_endpoint ) && is_account_page() ) {
			wp_enqueue_script( 'mwb-public-min', WALLET_SYSTEM_FOR_WOOCOMMERCE_DIR_URL . 'public/js/mwb-public.min.js', array(), $this->version, 'all' );
		}

	}


	/**
	 * Unset COD if wallet topup product in cart.
	 *
	 * @param array $available_gateways   all the available payment gateways.
	 */
	public function mwb_wsfw_restrict_payment_gateway( $available_gateways ) {
		if ( isset( $available_gateways['mwb_wcb_wallet_payment_gateway'] ) ) {

			$mwb_cart_total = WC()->cart->total;
			$user_id        = get_current_user_id();
			$wallet_amount  = get_user_meta( $user_id, 'mwb_wallet', true );
			$wallet_amount  = empty( $wallet_amount ) ? 0 : $wallet_amount;

			$wallet_amount  = apply_filters( 'mwb_wsfw_show_converted_price', $wallet_amount );
			
			if ( WC()->session->__isset( 'is_wallet_partial_payment' ) ) {
				unset( $available_gateways['mwb_wcb_wallet_payment_gateway'] );
			} elseif ( WC()->session->__isset( 'recharge_amount' ) ) {
				unset( $available_gateways['mwb_wcb_wallet_payment_gateway'] );
				unset( $available_gateways['cod'] );
			} elseif ( isset( $wallet_amount ) && $wallet_amount >= 0 ) {
				if ( $wallet_amount < $mwb_cart_total ) {
					unset( $available_gateways['mwb_wcb_wallet_payment_gateway'] );
				}
			} elseif ( isset( $wallet_amount ) && $wallet_amount <= 0 ) {
				unset( $available_gateways['mwb_wcb_wallet_payment_gateway'] );
			}
		}
		return $available_gateways;
	}

	/**
	 * Show wallet as discount ( when wallet amount is less than cart total ) in review order table
	 *
	 * @return void
	 */
	public function checkout_review_order_custom_field() {
		$mwb_cart_total = WC()->cart->total;
		$user_id        = get_current_user_id();
		if ( $user_id ) {
			$wallet_amount = get_user_meta( $user_id, 'mwb_wallet', true );
			$wallet_amount = empty( $wallet_amount ) ? 0 : $wallet_amount;

			$wallet_amount = apply_filters( 'mwb_wsfw_show_converted_price', $wallet_amount );

			if ( isset( $wallet_amount ) && $wallet_amount > 0 ) {
				if ( $wallet_amount < $mwb_cart_total || $this->is_enable_wallet_partial_payment() ) {
					if ( ! WC()->session->__isset( 'recharge_amount' ) ) {
						?>	
					<tr class="partial_payment">
						<td><?php echo esc_html( 'Pay by wallet (' ) . wc_price( $wallet_amount ) . ')'; ?></td>
						<td>
							<p class="form-row checkbox_field woocommerce-validated" id="partial_payment_wallet_field">
								<input type="checkbox" class="input-checkbox " name="partial_payment_wallet" id="partial_payment_wallet" value="enable" <?php checked( $this->is_enable_wallet_partial_payment(), true, true ); ?> data-walletamount="<?php echo esc_attr( $wallet_amount ); ?>" >
							</p>
						</td>
					</tr>
						<?php
					}
				}
			}
		}

	}

	/**
	 * Remove all session set during partial payment and wallet recharge
	 *
	 * @param int $order_id order id.
	 * @return void
	 */
	public function remove_wallet_session( $order_id ) {
		$customer_id = get_current_user_id();
		if ( $customer_id > 0 ) {
			if ( WC()->session->__isset( 'custom_fee' ) ) {
				WC()->session->__unset( 'custom_fee' );
				WC()->session->__unset( 'is_wallet_partial_payment' );
			}

			if ( WC()->session->__isset( 'recharge_amount' ) ) {
				WC()->session->__unset( 'recharge_amount' );
			}
		}

	}

	/**
	 * Change wallet amount on order status change
	 *
	 * @param object $order object.
	 * @return void
	 */
	public function mwb_order_status_changed( $order ) {
		$order_id               = $order->get_id();
		$userid                 = $order->get_user_id();
		$payment_method         = $order->get_payment_method();
		$new_status             = $order->get_status();
		$order_items            = $order->get_items();
		$wallet_id              = get_option( 'mwb_wsfw_rechargeable_product_id', '' );
		$walletamount           = get_user_meta( $userid, 'mwb_wallet', true );
		$user                   = get_user_by( 'id', $userid );
		$name                   = $user->first_name . ' ' . $user->last_name;
		$wallet_payment_gateway = new Wallet_System_For_Woocommerce();
		$send_email_enable      = get_option( 'mwb_wsfw_enable_email_notification_for_wallet_update', '' );
		foreach ( $order_items as $item_id => $item ) {
			$product_id = $item->get_product_id();
			$total      = $item->get_total();

			if ( isset( $product_id ) && ! empty( $product_id ) && $product_id == $wallet_id ) {

				if ( 'completed' == $new_status ) {
					$amount          = $total;
					$credited_amount = apply_filters( 'mwb_wsfw_convert_to_base_price', $amount );
					$wallet_userid   = apply_filters( 'wsfw_check_order_meta_for_userid', $userid, $order_id );
					if ( $wallet_userid ) {
						$update_wallet_userid = $wallet_userid;
					} else {
						$update_wallet_userid = $userid;
					}
					$transfer_note = apply_filters( 'wsfw_check_order_meta_for_recharge_reason', '', $order_id );
					$walletamount  = get_user_meta( $update_wallet_userid, 'mwb_wallet', true );
					$wallet_user   = get_user_by( 'id', $update_wallet_userid );
					$walletamount += $credited_amount;
					update_user_meta( $update_wallet_userid, 'mwb_wallet', $walletamount );

					if ( isset( $send_email_enable ) && 'on' === $send_email_enable ) {
						$user_name  = $wallet_user->first_name . ' ' . $wallet_user->last_name;
						$mail_text  = sprintf( 'Hello %s,<br/>', $user_name );
						$mail_text .= __( 'Wallet credited by ', 'wallet-system-for-woocommerce' ) . wc_price( $amount, array( 'currency' => $order->get_currency() ) ) . __( ' through wallet recharging.', 'wallet-system-for-woocommerce' );
						$to         = $wallet_user->user_email;
						$from       = get_option( 'admin_email' );
						$subject    = __( 'Wallet updating notification', 'wallet-system-for-woocommerce' );
						$headers    = 'MIME-Version: 1.0' . "\r\n";
						$headers   .= 'Content-Type: text/html;  charset=UTF-8' . "\r\n";
						$headers   .= 'From: ' . $from . "\r\n" .
							'Reply-To: ' . $to . "\r\n";
						$wallet_payment_gateway->send_mail_on_wallet_updation( $to, $subject, $mail_text, $headers );

					}

					$transaction_type = 'Wallet credited through purchase <a href="' . admin_url( 'post.php?post=' . $order_id . '&action=edit' ) . '" >#' . $order_id . '</a>';
					$transaction_data = array(
						'user_id'          => $userid,
						'amount'           => $amount,
						'currency'         => $order->get_currency(),
						'payment_method'   => $payment_method,
						'transaction_type' => htmlentities( $transaction_type ),
						'order_id'         => $order_id,
						'note'             => $transfer_note,
					);

					$wallet_payment_gateway->insert_transaction_data_in_table( $transaction_data );

				}
			}
		}

		foreach ( $order->get_fees() as $item_fee ) {
			$fee_name  = $item_fee->get_name();
			$fee_total = $item_fee->get_total();
			if ( 'Via wallet' === $fee_name ) {
				$payment_status = array( 'processing', 'completed' );
				if ( in_array( $new_status, $payment_status ) ) {
					$fees   = abs( $fee_total );
					$amount = $fees;
					$debited_amount = apply_filters( 'mwb_wsfw_convert_to_base_price', $fees );
					if ( $walletamount < $debited_amount ) {
						$walletamount = 0;
					} else {
						$walletamount -= $debited_amount;
					}
					update_user_meta( $userid, 'mwb_wallet', $walletamount );

					if ( isset( $send_email_enable ) && 'on' === $send_email_enable ) {
						$mail_text  = esc_html__( 'Hello ', 'wallet-system-for-woocommerce' ) . esc_html( $name ) . __( ',<br/>', 'wallet-system-for-woocommerce' );
						$mail_text .= __( 'Wallet debited by ', 'wallet-system-for-woocommerce' ) . wc_price( $amount, array( 'currency' => $order->get_currency() ) ) . __( ' from your wallet through purchasing.', 'wallet-system-for-woocommerce' );
						$to         = $user->user_email;
						$from       = get_option( 'admin_email' );
						$subject    = __( 'Wallet updating notification', 'wallet-system-for-woocommerce' );
						$headers    = 'MIME-Version: 1.0' . "\r\n";
						$headers   .= 'Content-Type: text/html;  charset=UTF-8' . "\r\n";
						$headers   .= 'From: ' . $from . "\r\n" .
							'Reply-To: ' . $to . "\r\n";
						$wallet_payment_gateway->send_mail_on_wallet_updation( $to, $subject, $mail_text, $headers );

					}

					$transaction_type = 'Wallet debited through purchasing <a href="' . admin_url( 'post.php?post=' . $order_id . '&action=edit' ) . '" >#' . $order_id . '</a> as discount';

					$transaction_data = array(
						'user_id'          => $userid,
						'amount'           => $amount,
						'currency'         => $order->get_currency(),
						'payment_method'   => $payment_method,
						'transaction_type' => htmlentities( $transaction_type ),
						'order_id'         => $order_id,
						'note'             => '',

					);

					$wallet_payment_gateway->insert_transaction_data_in_table( $transaction_data );
				}
			}
		}

	}

	/**
	 * Insert the new endpoint into the My Account menu.
	 *
	 * @param array $items    All the items of the my account page.
	 */
	public function mwb_wsfw_add_wallet_item( $items ) {
		$logout = $items['customer-logout'];
		unset( $items['customer-logout'] );
		$items['mwb-wallet']      = __( 'Wallet', 'wallet-system-for-woocommerce' );
		$items['customer-logout'] = $logout;
		return $items;
	}

	/**
	 *  Register new endpoint to use for My Account page.
	 */
	public function mwb_wsfw_wallet_register_endpoint() {
		global $wp_rewrite;
		add_rewrite_endpoint( 'mwb-wallet', EP_ROOT | EP_PAGES );
		add_rewrite_endpoint( 'wallet-topup', EP_PERMALINK | EP_PAGES );
		add_rewrite_endpoint( 'wallet-transfer', EP_PERMALINK | EP_PAGES );
		add_rewrite_endpoint( 'wallet-withdrawal', EP_PERMALINK | EP_PAGES );
		add_rewrite_endpoint( 'wallet-transactions', EP_PERMALINK | EP_PAGES );
		$wp_rewrite->flush_rules();
	}

	/**
	 *  Add new query var.
	 *
	 * @param array $vars    Query variable.
	 */
	public function mwb_wsfw_wallet_query_var( $vars ) {
		$vars[] = 'mwb-wallet';
		return $vars;
	}

	/**
	 * Add content to the new endpoint.
	 */
	public function mwb_wsfw_display_wallet_endpoint_content() {
		include_once WALLET_SYSTEM_FOR_WOOCOMMERCE_DIR_PATH . 'public/partials/wallet-system-for-woocommerce-public-display.php';
	}

	/**
	 * Get WooCommerce cart total.
	 *
	 * @return number
	 */
	public function get_mwbwallet_cart_total() {
		$mwb_cart_total = WC()->cart->total;
		return $mwb_cart_total;
	}

	/**
	 * Check if enable partial payment.
	 *
	 * @return Boolean
	 */
	public function is_enable_wallet_partial_payment() {
		$is_enable = false;
		if ( is_user_logged_in() && ( ( ! is_null( wc()->session ) && wc()->session->get( 'is_wallet_partial_payment', false ) ) ) ) {
			$is_enable = true;
		}
		return $is_enable;
	}

	/**
	 * Add wallet amount as fee in cart during partial payment
	 *
	 * @return void
	 */
	public function wsfw_add_wallet_discount() {

		if ( WC()->session->__isset( 'custom_fee' ) ) {

			$discount = (float) WC()->session->get( 'custom_fee' );
			if ( $discount ) {
				$fee = array(
					'id'     => 'via_wallet_partial_payment',
					'name'   => __( 'Via wallet', 'wallet-system-for-woocommerce' ),
					'amount' => (float) -1 * $discount,
				);
			}
		}

		if ( $this->is_enable_wallet_partial_payment() ) {
			wc()->cart->fees_api()->add_fee( $fee );
		} else {
			$all_fees = wc()->cart->fees_api()->get_fees();
			if ( isset( $all_fees['via_wallet_partial_payment'] ) ) {
				unset( $all_fees['via_wallet_partial_payment'] );
				wc()->cart->fees_api()->set_fees( $all_fees );
			}
		}

	}

	/**
	 * Add wallet topup to cart
	 *
	 * @return void
	 */
	public function add_wallet_recharge_to_cart() {
		if ( WC()->session->__isset( 'wallet_recharge' ) ) {
			$wallet_recharge = WC()->session->get( 'wallet_recharge' );
			// check if product already in cart.
			if ( count( WC()->cart->get_cart() ) > 0 ) {
				$found = false;
				foreach ( WC()->cart->get_cart() as $cart_item ) {
					$product_in_cart = $cart_item['product_id'];
					if ( $product_in_cart == $wallet_recharge['productid'] ) {
						$found = true;
					}
				}
				// if product not found, add it.
				if ( ! $found ) {
					add_action( 'woocommerce_before_cart', array( $this, 'add_cart_custom_notice' ) );
					WC()->session->__unset( 'recharge_amount' );
				}
			} else {
				WC()->cart->empty_cart();
				// if no products in cart, add it.
				WC()->cart->add_to_cart( $wallet_recharge['productid'] );

				wp_safe_redirect( wc_get_checkout_url() );

			}
			WC()->session->__unset( 'wallet_recharge' );
		}
	}

	/**
	 * Add credit amount to cart data.
	 *
	 * @param array $cart_item_data  cart data.
	 * @param int   $product_id prduct id in cart.
	 */
	public function add_wallet_topup_product_in_cart( $cart_item_data, $product_id ) {
		if ( WC()->session->__isset( 'recharge_amount' ) ) {
			$wallet_recharge = WC()->session->get( 'recharge_amount' );
			if ( isset( $wallet_recharge ) && ! empty( $wallet_recharge ) ) {
				$cart_item_data['recharge_amount'] = $wallet_recharge;
			}
		}
		return $cart_item_data;
	}

	/**
	 * Add notice on cart page if cart is already added with products
	 *
	 * @return void
	 */
	public function add_cart_custom_notice() {
		wc_print_notice(
			sprintf(
				'<span class="subscription-reminder">' .
				__( 'Sorry we cannot recharge wallet with other products, either empty cart or recharge later when cart is empty', 'wallet-system-for-woocommerce' ) . '</span>',
				__( 'empty', 'wallet-system-for-woocommerce' )
			),
			'error'
		);
	}

	/**
	 * Add notice on cart page if cart is already added with wallet topup
	 *
	 * @param boolean $passed  check product can be add to cart.
	 * @param int     $product_id  product id.
	 * @return boolean
	 */
	public function show_message_addto_cart( $passed, $product_id ) {
		$wallet_id = get_option( 'mwb_wsfw_rechargeable_product_id', '' );
		if ( ! empty( $wallet_id ) ) {
			if ( ! WC()->cart->is_empty() ) {
				foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
					$_product = $values['data'];
					if ( $_product->id == $wallet_id ) {
						$passed = false;

						wc_add_notice(
							sprintf(
								'<span class="subscription-reminder">' .
								__( 'Sorry you cannot buy this product since wallet topup is added to cart. If you want to buy this product, please first remove wallet topup from cart.', 'wallet-system-for-woocommerce' ) . '</span>',
								__( 'empty', 'wallet-system-for-woocommerce' )
							),
							'error'
						);

					}
				}
			}
		}
		return $passed;
	}

	/**
	 * Update wallet top price in cart and checkout page
	 *
	 * @param object $cart_object cart object.
	 * @return void
	 */
	public function mwb_update_price_cart( $cart_object ) {
		$cart_items = $cart_object->cart_contents;
		if ( WC()->session->__isset( 'recharge_amount' ) ) {
			$wallet_recharge = WC()->session->get( 'recharge_amount' );
			$price           = $wallet_recharge;
			if ( ! empty( $cart_items ) ) {
				foreach ( $cart_items as $key => $value ) {
					$value['data']->set_price( $price );
				}
			}
		}

	}

	/**
	 * Unset session after wallet topup is removed from cart
	 *
	 * @param string $removed_cart_item_key removed cart item key.
	 * @param object $cart cart object.
	 * @return void
	 */
	public function after_remove_wallet_from_cart( $removed_cart_item_key, $cart ) {
		$line_item  = $cart->removed_cart_contents[ $removed_cart_item_key ];
		$product_id = $line_item['product_id'];
		$wallet_id  = get_option( 'mwb_wsfw_rechargeable_product_id', '' );
		if ( $wallet_id ) {
			if ( $product_id == $wallet_id ) {
				WC()->session->__unset( 'recharge_amount' );
			}
		}
		if ( WC()->session->__isset( 'custom_fee' ) ) {
			WC()->session->__unset( 'custom_fee' );
			WC()->session->__unset( 'is_wallet_partial_payment' );
		}
		do_action( 'mwb_wsfw_remove_value_from_session', $removed_cart_item_key );

	}

	/**
	 * Change post type to wallet_shop_order if wallet is recharge during new order place
	 *
	 * @param int $order_id order id.
	 * @return void
	 */
	public function change_order_type( $order_id ) {
		$order     = wc_get_order( $order_id );
		$wallet_id = get_option( 'mwb_wsfw_rechargeable_product_id', '' );
		foreach ( $order->get_items() as $item ) {
			$product_id = $item->get_product_id();
			if ( isset( $product_id ) && ! empty( $product_id ) && $product_id == $wallet_id ) {
				$order_obj            = get_post( $order_id );
				$order_obj->post_type = 'wallet_shop_order';
				wp_update_post( $order_obj );

				echo '<style type="text/css">
				.woocommerce-order .woocommerce-customer-details {
					display:none;
				}
				</style>';

			}
		}
		$this->mwb_order_status_changed( $order );
	}

	/**
	 * Remove billing fields from checkout page for wallet recharge.
	 *
	 * @param array $fields checkout fields.
	 * @return array
	 */
	public function mwb_wsfw_remove_billing_from_checkout( $fields ) {
		$wallet_product_id = get_option( 'mwb_wsfw_rechargeable_product_id' );
		$only_virtual      = false;
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = $cart_item['data'];
			if ( $_product->is_virtual() && ( $_product->get_id() == $wallet_product_id ) ) {
				$only_virtual = true;
			}
		}
		if ( $only_virtual ) {
			unset( $fields['billing']['billing_first_name'] );
			unset( $fields['billing']['billing_last_name'] );
			unset( $fields['billing']['billing_address_1'] );
			unset( $fields['billing']['billing_address_2'] );
			unset( $fields['billing']['billing_city'] );
			unset( $fields['billing']['billing_postcode'] );
			unset( $fields['billing']['billing_country'] );
			unset( $fields['billing']['billing_state'] );
			unset( $fields['billing']['billing_company'] );
			unset( $fields['billing']['billing_phone'] );
			unset( $fields['billing']['billing_email'] );
			add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
			echo '<style type="text/css">
			form.checkout .woocommerce-billing-fields h3 {
				display:none;
			}
			</style>';
		}
		return $fields;

	}

	/**
	 * Remove customer details from mail for wallet recharge.
	 *
	 * @param object $order order object.
	 * @return void
	 */
	public function mwb_wsfw_remove_customer_details_in_emails( $order ) {
		$wallet_id = get_option( 'mwb_wsfw_rechargeable_product_id', '' );
		foreach ( $order->get_items() as $item ) {
			$product_id = $item->get_product_id();
			if ( isset( $product_id ) && ! empty( $product_id ) && $product_id == $wallet_id ) {
				$mailer = WC()->mailer();
				remove_action( 'woocommerce_email_customer_details', array( $mailer, 'customer_details' ), 10 );
				remove_action( 'woocommerce_email_customer_details', array( $mailer, 'email_addresses' ), 20 );

			}
		}

	}


}
