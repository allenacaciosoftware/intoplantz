<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to enable wallet, set min and max value for recharging wallet
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Wallet_System_For_Woocommerce
 * @subpackage Wallet_System_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wsfw_mwb_wsfw_obj;

if ( isset( $_POST['import_wallets'] ) && ! empty( $_POST['import_wallets'] ) ) {
	unset( $_POST['import_wallets'] );
	if ( ! empty( $_FILES['import_wallet_for_users'] ) ) {
		$image_name      = ( isset( $_FILES['import_wallet_for_users']['name'] ) ) ? sanitize_text_field( wp_unslash( $_FILES['import_wallet_for_users']['name'] ) ) : '';
		$image_size      = ( isset( $_FILES['import_wallet_for_users']['size'] ) ) ? sanitize_text_field( wp_unslash( $_FILES['import_wallet_for_users']['size'] ) ) : '';
		$image_file_type = strtolower( pathinfo( $image_name, PATHINFO_EXTENSION ) );
		// Allow certain file formats.
		if ( 'csv' !== $image_file_type ) {
			$mwb_wsfw_error_text = esc_html__( 'Sorry, only CSV file is allowed.', 'wallet-system-for-woocommerce' );
			$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $mwb_wsfw_error_text, 'error' );
		} else {
			$file_temp    = ( isset( $_FILES['import_wallet_for_users']['tmp_name'] ) ) ? sanitize_text_field( wp_unslash( $_FILES['import_wallet_for_users']['tmp_name'] ) ) : '';
			$file         = fopen( $file_temp, 'r' );
			$users_wallet = array();
			$first_row    = fgetcsv( $file );
			$user_id      = $first_row[0];
			$balance      = $first_row[1];
			if ( 'User Id' != $user_id || 'Wallet Balance' != $balance ) {
				$mwb_wsfw_error_text = esc_html__( 'You have not selected correct file(fields are not matching)', 'wallet-system-for-woocommerce' );
				$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $mwb_wsfw_error_text, 'error' );
			} else {
				$updated_users = 0;
				$number_of_users = 0;
				while ( ! feof( $file ) ) {
					$user_data   = fgetcsv( $file );
					if ( is_array( $user_data ) ) {
						$user_id = $user_data[0];
						$balance = $user_data[1];
					}
					if ( 'User Id' === $user_id && 'Wallet Balance' === $balance ) {
						continue;
					} else {
						$user = get_user_by( 'id', $user_id );
						if ( $user ) {

							$current_balance = get_user_meta( $user_id, 'mwb_wallet', true );
							if ( $current_balance < $balance ) {
								$net_balance = $balance - $current_balance;
								$transaction_type = 'Wallet credited during importing wallet';
								$mail_message     = __( 'Merchant has credited your wallet by ', 'wallet-system-for-woocommerce' ) . wc_price( $net_balance );
							} elseif ( $current_balance == $balance ) {
								$net_balance      = 0;
								$transaction_type = 'No money is added/deducted from wallet';
							} else {
								$net_balance = $current_balance - $balance;
								$transaction_type = 'Wallet debited during importing wallet';
								$mail_message     = __( 'Merchant has deducted ', 'wallet-system-for-woocommerce' ) . wc_price( $net_balance ) . __( ' from your wallet.', 'wallet-system-for-woocommerce' );
							}
							$updated_wallet = update_user_meta( $user_id, 'mwb_wallet', $balance );

							if ( $updated_wallet ) {
								$updated_users++;
								$send_email_enable = get_option( 'mwb_wsfw_enable_email_notification_for_wallet_update', '' );
								if ( isset( $send_email_enable ) && 'on' === $send_email_enable ) {
									$user       = get_user_by( 'id', $user_id );
									$name       = $user->first_name . ' ' . $user->last_name;
									$mail_text  = esc_html__( 'Hello ', 'wallet-system-for-woocommerce' ) . esc_html( $name ) . __( ',<br/>', 'wallet-system-for-woocommerce' );
									$mail_text .= $mail_message;
									$to         = $user->user_email;
									$from       = get_option( 'admin_email' );
									$subject    = __( 'Wallet updating notification', 'wallet-system-for-woocommerce' );
									$headers    = 'MIME-Version: 1.0' . "\r\n";
									$headers   .= 'Content-Type: text/html;  charset=UTF-8' . "\r\n";
									$headers   .= 'From: ' . $from . "\r\n" .
										'Reply-To: ' . $to . "\r\n";

									$wallet_payment_gateway->send_mail_on_wallet_updation( $to, $subject, $mail_text, $headers );
								}
							}

							$transaction_data = array(
								'user_id'          => $user_id,
								'amount'           => $net_balance,
								'currency'         => get_woocommerce_currency(),
								'payment_method'   => 'Through importing Wallet',
								'transaction_type' => $transaction_type,
								'order_id'         => '',
								'note'             => '',

							);
							$wallet_payment_gateway = new Wallet_System_For_Woocommerce();
							$result                 = $wallet_payment_gateway->insert_transaction_data_in_table( $transaction_data );

							$number_of_users++;
						}
					}
				}
				$mwb_wsfw_error_text = esc_html__( 'Updated wallet of ', 'wallet-system-for-woocommerce' ) . $updated_users . esc_html__( ' users out of ', 'wallet-system-for-woocommerce' ) . $number_of_users;
				$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $mwb_wsfw_error_text, 'success' );
			}

			fclose( $file );


		}
	} else {
		$mwb_wsfw_error_text = esc_html__( 'Please select any CSV file', 'wallet-system-for-woocommerce' );
		$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $mwb_wsfw_error_text, 'error' );
	}
}

if ( isset( $_POST['confirm_updatewallet'] ) && ! empty( $_POST['confirm_updatewallet'] ) ) {
	unset( $_POST['confirm_updatewallet'] );
	$update = true;
	if ( empty( $_POST['wsfw_wallet_amount_for_users'] ) ) {
		$mwb_wsfw_error_text = esc_html__( 'Please enter any amount', 'wallet-system-for-woocommerce' );
		$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $mwb_wsfw_error_text, 'error' );
		$update = false;
	}
	if ( empty( $_POST['wsfw_wallet_action_for_users'] ) ) {
		$mwb_wsfw_error_text = esc_html__( 'Please select any action', 'wallet-system-for-woocommerce' );
		$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $mwb_wsfw_error_text, 'error' );
		$update = false;
	}
	if ( $update ) {
		$wallet_payment_gateway = new Wallet_System_For_Woocommerce();
		$updated_amount         = sanitize_text_field( wp_unslash( $_POST['wsfw_wallet_amount_for_users'] ) );
		$wallet_action          = sanitize_text_field( wp_unslash( $_POST['wsfw_wallet_action_for_users'] ) );
		update_option( 'wsfw_wallet_amount_for_users', $updated_amount );
		update_option( 'wsfw_wallet_action_for_users', $wallet_action );
		$wallet_amount = get_option( 'wsfw_wallet_amount_for_users', '' );
		$wallet_option = get_option( 'wsfw_wallet_action_for_users', '' );
		if ( isset( $wallet_amount ) && ! empty( $wallet_amount ) ) {

			$users = get_users();
			$updated_users   = 0;
			$number_of_users = 0;
			foreach ( $users as $user ) {
				$user_id = $user->ID;
				$wallet = get_user_meta( $user_id, 'mwb_wallet', true );
				if ( 'credit' === $wallet_option ) {
					$wallet          += $wallet_amount;
					$updated_wallet   = update_user_meta( $user_id, 'mwb_wallet', $wallet );
					$transaction_type = 'Credited by admin';
					$mail_message     = __( 'Merchant has credited your wallet by ', 'wallet-system-for-woocommerce' ) . wc_price( $updated_amount );
				} elseif ( 'debit' === $wallet_option ) {
					if ( $wallet < $wallet_amount ) {
						$wallet = 0;
					} else {
						$wallet -= $wallet_amount;
					}

					$updated_wallet   = update_user_meta( $user_id, 'mwb_wallet', abs( $wallet ) );
					$transaction_type = 'Debited by admin';
					$mail_message     = __( 'Merchant has deducted ', 'wallet-system-for-woocommerce' ) . wc_price( $updated_amount ) . __( ' from your wallet.', 'wallet-system-for-woocommerce' );
				}

				if ( $updated_wallet ) {
					$updated_users++;
				}

				$send_email_enable = get_option( 'mwb_wsfw_enable_email_notification_for_wallet_update', '' );
				if ( isset( $send_email_enable ) && 'on' === $send_email_enable ) {
					$user       = get_user_by( 'id', $user_id );
					$name       = $user->first_name . ' ' . $user->last_name;
					$mail_text  = esc_html__( 'Hello ', 'wallet-system-for-woocommerce' ) . esc_html( $name ) . __( ',<br/>', 'wallet-system-for-woocommerce' );
					$mail_text .= $mail_message;
					$to         = $user->user_email;
					$from       = get_option( 'admin_email' );
					$subject    = __( 'Wallet updating notification', 'wallet-system-for-woocommerce' );
					$headers    = 'MIME-Version: 1.0' . "\r\n";
					$headers   .= 'Content-Type: text/html;  charset=UTF-8' . "\r\n";
					$headers   .= 'From: ' . $from . "\r\n" .
						'Reply-To: ' . $to . "\r\n";

					$wallet_payment_gateway->send_mail_on_wallet_updation( $to, $subject, $mail_text, $headers );
				}

				$transaction_data = array(
					'user_id'          => $user_id,
					'amount'           => $updated_amount,
					'currency'         => get_woocommerce_currency(),
					'payment_method'   => 'Manually By Admin',
					'transaction_type' => $transaction_type,
					'order_id'         => '',
					'note'             => '',

				);

				$result = $wallet_payment_gateway->insert_transaction_data_in_table( $transaction_data );

				$number_of_users++;
			}
		}

		if ( $result ) {
			$mwb_wsfw_error_text = esc_html__( 'Updated wallet of ', 'wallet-system-for-woocommerce' ) . $updated_users . esc_html__( ' users out of ', 'wallet-system-for-woocommerce' ) . $number_of_users;
			$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $mwb_wsfw_error_text, 'success' );
		} else {
			$mwb_wsfw_error_text = esc_html__( 'There is an error in database', 'wallet-system-for-woocommerce' );
			$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $mwb_wsfw_error_text, 'error' );
		}
	}
}

if ( isset( $_POST['update_wallet'] ) && ! empty( $_POST['update_wallet'] ) ) {
	$nonce = ( isset( $_POST['user_update_nonce'] ) ) ? sanitize_text_field( wp_unslash( $_POST['user_update_nonce'] ) ) : '';
	if ( wp_verify_nonce( $nonce ) ) {
		unset( $_POST['update_wallet'] );
		$update = true;
		if ( empty( $_POST['mwb_wallet-edit-popup-input'] ) ) {
			$msfw_wpg_error_text = esc_html__( 'Please enter any amount', 'wallet-system-for-woocommerce' );
			$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $msfw_wpg_error_text, 'error' );
			$update = false;
		}
		if ( $_POST['mwb_wallet-edit-popup-input'] < 0 ) {
			$msfw_wpg_error_text = esc_html__( 'Please enter amount in positive value.', 'wallet-system-for-woocommerce' );
			$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $msfw_wpg_error_text, 'error' );
			$update = false;
		}
		if ( empty( $_POST['action_type'] ) ) {
			$msfw_wpg_error_text = esc_html__( 'Please select any action', 'wallet-system-for-woocommerce' );
			$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $msfw_wpg_error_text, 'error' );
			$update = false;
		}
		if ( empty( $_POST['user_id'] ) ) {
			$msfw_wpg_error_text = esc_html__( 'User Id is not given', 'wallet-system-for-woocommerce' );
			$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $msfw_wpg_error_text, 'error' );
			$update = false;
		}
		if ( $update ) {

			$wallet_payment_gateway = new Wallet_System_For_Woocommerce();
			$updated_amount         = sanitize_text_field( wp_unslash( $_POST['mwb_wallet-edit-popup-input'] ) );
			$wallet_action          = sanitize_text_field( wp_unslash( $_POST['action_type'] ) );
			$user_id                = sanitize_text_field( wp_unslash( $_POST['user_id'] ) );
			$wallet                 = get_user_meta( $user_id, 'mwb_wallet', true );

			if ( 'credit' === $wallet_action ) {
				$wallet          += $updated_amount;
				$updated_wallet   = update_user_meta( $user_id, 'mwb_wallet', $wallet );
				$transaction_type = 'Credited by admin';
				$mail_message     = __( 'Merchant has credited your wallet by ', 'wallet-system-for-woocommerce' ) . wc_price( $updated_amount );
			} elseif ( 'debit' === $wallet_action ) {
				if ( $wallet < $updated_amount ) {
					$wallet = 0;
				} else {
					$wallet -= $updated_amount;
				}
				$updated_wallet   = update_user_meta( $user_id, 'mwb_wallet', abs( $wallet ) );
				$transaction_type = 'Debited by admin';
				$mail_message     = __( 'Merchant has deducted ', 'wallet-system-for-woocommerce' ) . wc_price( $updated_amount ) . __( ' from your wallet.', 'wallet-system-for-woocommerce' );
			}

			$send_email_enable = get_option( 'mwb_wsfw_enable_email_notification_for_wallet_update', '' );
			if ( isset( $send_email_enable ) && 'on' === $send_email_enable ) {
				$user       = get_user_by( 'id', $user_id );
				$name       = $user->first_name . ' ' . $user->last_name;
				$mail_text  = esc_html__( 'Hello ', 'wallet-system-for-woocommerce' ) . esc_html( $name ) . __( ',<br/>', 'wallet-system-for-woocommerce' );
				$mail_text .= $mail_message;
				$to         = $user->user_email;
				$from       = get_option( 'admin_email' );
				$subject    = __( 'Wallet updating notification', 'wallet-system-for-woocommerce' );
				$headers    = 'MIME-Version: 1.0' . "\r\n";
				$headers   .= 'Content-Type: text/html;  charset=UTF-8' . "\r\n";
				$headers   .= 'From: ' . $from . "\r\n" .
					'Reply-To: ' . $to . "\r\n";

				$wallet_payment_gateway->send_mail_on_wallet_updation( $to, $subject, $mail_text, $headers );
			}

			$transaction_data = array(
				'user_id'          => $user_id,
				'amount'           => $updated_amount,
				'currency'         => get_woocommerce_currency(),
				'payment_method'   => 'Manually By Admin',
				'transaction_type' => $transaction_type,
				'order_id'         => '',
				'note'             => '',

			);

			$result = $wallet_payment_gateway->insert_transaction_data_in_table( $transaction_data );
			if ( $result ) {
				$msfw_wpg_error_text = esc_html__( 'Updated wallet of user', 'wallet-system-for-woocommerce' );
				$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $msfw_wpg_error_text, 'success' );
			} else {
				$msfw_wpg_error_text = esc_html__( 'There is an error in database', 'wallet-system-for-woocommerce' );
				$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( $msfw_wpg_error_text, 'error' );
			}
		}
	} else {
		$wsfw_mwb_wsfw_obj->mwb_wsfw_plug_admin_notice( 'Failed security check', 'error' );
	}
}

$wsfw_wallet_topup_settings = apply_filters( 'wsfw_wallet_settings_array', array() );
$wsfw_update_wallet         = apply_filters( 'wsfw_update_wallet_array', array() );
$wsfw_import_settings       = apply_filters( 'wsfw_import_wallet_array', array() );


?>
<div class="mwb-wpg-gen-section-form-container">
	<div class="wpg-secion-wrap">
		<h3><?php esc_html_e( 'Credit/Debit amount from user\'s wallet', 'wallet-system-for-woocommerce' ); ?></h3>
	</div>
	<div class="mwb-wpg-gen-section-form-wrapper">
		<form action="" method="POST" class="mwb-wpg-gen-section-form" id="form_update_wallet"> 
			<div class="wpg-secion-wrap">
				<h3><?php esc_html_e( 'Edit wallet of all users at once', 'wallet-system-for-woocommerce' ); ?></h3>
				<?php
				$wsfw_general_html = $wsfw_mwb_wsfw_obj->mwb_wsfw_plug_generate_html( $wsfw_update_wallet );
				echo esc_html( $wsfw_general_html );
				?>
			</div>
			<div class="mwb_wallet-update--popupwrap">
				<div class="mwb_wallet-update-popup">
					<h3><?php esc_html_e( 'Are you sure to update wallet of all users?', 'wallet-system-for-woocommerce' ); ?></h3>
					<div class="mwb_wallet-update-popup-btn">
						<input type="submit" class="mwb-btn mwb-btn__filled" name="confirm_updatewallet" id="confirm_updatewallet" value="<?php esc_html_e( 'Yes, I\'m Sure', 'wallet-system-for-woocommerce' ); ?>" >
						<a href="javascript:void(0);" id="cancel_walletupdate" ><?php esc_html_e( 'Not now', 'wallet-system-for-woocommerce' ); ?></a>
					</div>
				</div>
			</div>
		</form>

		<button class="mdc-ripple-upgraded" id="export_user_wallet" > <img src="<?php echo esc_url( WALLET_SYSTEM_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/down-arrow.png" title="Download CSV file" >
		</button>

		<form action="" method="POST" class="mwb-wpg-gen-section-form" enctype="multipart/form-data">
			<div class="wpg-secion-wrap">
				<h3><?php esc_html_e( 'Import wallets for user', 'wallet-system-for-woocommerce' ); ?></h3>
				<?php
				$wsfw_general_html = $wsfw_mwb_wsfw_obj->mwb_wsfw_plug_generate_html( $wsfw_import_settings );
				echo esc_html( $wsfw_general_html );
				?>
			</div>
		</form>
	</div>
</div>

<div class="mwb-wpg-withdrawal-section-search">
	<table>
		<tbody>
			<tr>
				<th><?php esc_html_e( 'Search', 'wallet-system-for-woocommerce' ); ?></td>
				<td><input type="text" id="search_in_table"></td>
			</tr>
			<tr>
				<td><span id="clear_table" ><?php esc_html_e( 'Clear', 'wallet-system-for-woocommerce' ); ?></span></td>
			</tr>
		</tbody>
	</table>
</div>

<div class="mwb-wpg-gen-section-table-wrap">
	<h4><?php esc_html_e( 'Wallet', 'wallet-system-for-woocommerce' ); ?></h4>
	<div class="mwb-wpg-gen-section-table-container">
		<table id="mwb-wpg-gen-table" class="mwb-wpg-gen-section-table dt-responsive">
			<thead>
				<tr>
					<th><?php esc_html_e( 'ID', 'wallet-system-for-woocommerce' ); ?></th>
					<th><?php esc_html_e( 'Name', 'wallet-system-for-woocommerce' ); ?></th>
					<th><?php esc_html_e( 'Email', 'wallet-system-for-woocommerce' ); ?></th>
					<th><?php esc_html_e( 'Role', 'wallet-system-for-woocommerce' ); ?></th>
					<th><?php esc_html_e( 'Amount', 'wallet-system-for-woocommerce' ); ?></th>
					<th><?php esc_html_e( 'Actions', 'wallet-system-for-woocommerce' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$users = get_users( 'orderby=id' );
				if ( ! empty( $users ) ) {
					foreach ( $users as $user ) {
						$wallet_bal = get_user_meta( $user->ID, 'mwb_wallet', true );
						?>
						<tr>
							<td><img src="<?php echo esc_url( WALLET_SYSTEM_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/eva_close-outline.svg"><?php echo esc_html( $user->ID ); ?></td>
							<td><?php echo esc_html( $user->display_name ); ?></td>
							<td><?php echo esc_html( $user->user_email ); ?></td>
							<td><?php echo esc_html( $user->roles[0] ); ?></td>
							<td><?php echo wc_price( $wallet_bal ); ?></td>
							<td>
								<span>
									<a class="edit_wallet" data-userid="<?php echo esc_attr( $user->ID ); ?>" href="" title="Edit Wallet" >
										<img src="<?php echo esc_url( WALLET_SYSTEM_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/edit.svg">
									</a>	
									<a href="<?php echo esc_url( admin_url( 'admin.php?page=wallet_system_for_woocommerce_menu' ) . '&wsfw_tab=mwb-user-wallet-transactions&id=' . $user->ID ); ?>" title="View Transactions" >
										<img src="<?php echo esc_url( WALLET_SYSTEM_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/eye.svg">
									</a>
								</span>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>

<div class="mwb_wallet-edit--popupwrap">
	<div class="mwb_wallet-edit-popup">
		<p><span id="close_wallet_form"><img src="<?php echo esc_url( WALLET_SYSTEM_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/cancel.svg"></span></p>
		<form method="post">
			<div class="mwb_wallet-edit-popup-content">
				<div class="mwb_wallet-edit-popup-amount">
					<div class="mwb_wallet-edit-popup-label">
						<label for="mwb_wallet-edit-popup-input" class="mwb_wallet-edit-popup-input">
							<?php echo esc_html__( 'Select Amount (', 'wallet-system-for-woocommerce' ) . esc_html( get_woocommerce_currency_symbol() ) . '):'; ?>
						</label>
					</div>
					<div class="mwb_wallet-edit-popup-control">
						<input type="number" name="mwb_wallet-edit-popup-input" step="0.01" id="mwb_wallet-edit-popup-input"  class="mwb_wallet-edit-popup-fill">
						<p class="error"></p>
					</div>
				</div>
				<div class="mwb_wallet-edit-popup-amount">
					<div class="mwb_wallet-edit-popup-label">
						<label for="mwb_wallet-edit-popup-card" class="mwb_wallet-edit-popup-card"><?php esc_html_e( 'Select Action:', 'wallet-system-for-woocommerce' ); ?></label>
					</div>
					<div class="mwb_wallet-edit-popup-control">
						<div class="mwb-form-select-card">
							<input type="radio" id="debit" name="action_type" value="debit">
							<label for="debit"><?php esc_html_e( 'Debit Wallet', 'wallet-system-for-woocommerce' ); ?></label>
						</div>
						<div class="mwb-form-select-card">
							<input type="radio" id="credit" name="action_type" value="credit">
							<label for="credit"><?php esc_html_e( 'Credit Wallet', 'wallet-system-for-woocommerce' ); ?></label>
						</div>
					</div>
				</div>
			</div>
			<div class="mwb_wallet-edit-popup-btn">
				<input type="hidden" id="user_update_nonce" name="user_update_nonce" value="<?php echo esc_attr( wp_create_nonce() ); ?>" />
				<input type="submit" name="update_wallet" class="mwb-btn mwb-btn__filled" value="Update Wallet">
			</div>
		</form>
	</div>
</div>
