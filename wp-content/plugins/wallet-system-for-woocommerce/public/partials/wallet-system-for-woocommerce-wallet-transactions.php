<?php
/**
 * Exit if accessed directly
 *
 * @package Wallet_System_For_Woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>

<style>
    table, td, th {
        border: 1px solid #78a2a2;
    }
    table {
        border-bottom: 1px solid #78a2a2 !important;
    }
    table thead th, table thead td {
        border-bottom: 0px !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #78a2a2;
        line-height: 17px;
        color: white !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #78a2a2;
        opacity: 0.7;
    }
</style>
<div class='content active'>
		<div class="mwb-wallet-transaction-container" style="display: flex; flex-direction: column; align-items: center;">
        <h3><b><?php echo esc_html( 'Transactions' ); ?></b></h3>
            <table id="walletTransactionsTable" class="display">
                <thead style="background: cadetblue; color: white">
                <th>Transaction</th>
                <th>Amount</th>
                <th>Details</th>
                <th>Method</th>
                <th>Date</th>
                </thead>
                <tbody>
                <?php
                global $wpdb;
                $table_name   = $wpdb->prefix . 'mwb_wsfw_wallet_transaction';
                $transactions = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'mwb_wsfw_wallet_transaction WHERE user_id = %s ORDER BY `Id` DESC', $user_id ) );
                if ( ! empty( $transactions ) && is_array( $transactions ) ) {
                    $i = 1;
                    foreach ( $transactions as $transaction ) {
                        $user           = get_user_by( 'id', $transaction->user_id );
                        $transaction_id = $transaction->id;
                        ?>
                        <tr>
                            <td><?php echo esc_html( $transaction_id ); ?></td>
                            <td><?php echo wc_price( $transaction->amount, array( 'currency' => $transaction->currency ) ); ?></td>
                            <td class="details" ><?php echo html_entity_decode( $transaction->transaction_type ); ?></td>
                            <td>
                                <?php
                                $payment_methods = WC()->payment_gateways->payment_gateways();
                                foreach ( $payment_methods as $key => $payment_method ) {
                                    if ( $key == $transaction->payment_method ) {
                                        $method = esc_html__( 'Online Payment', 'wallet-system-for-woocommerce' );
                                    } else {
                                        $method = esc_html( $transaction->payment_method );
                                    }
                                    break;
                                }
                                echo $method;
                                ?>
                            </td>
                            <td>
                                <?php
                                $date_format = get_option( 'date_format', 'm/d/Y' );
                                $date        = date_create( $transaction->date );
                                echo esc_html( date_format( $date, $date_format ) );
                                ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                }
                ?>
                </tbody>
            </table>
            <script>
                $(document).ready(function() {
                    let table = $('#walletTransactionsTable').DataTable({
                        "order": [[ 0, "desc" ]]
                    });
                });
            </script>

	<!-- removing the anchor tag href attibute using regular expression -->	
	<script>
	jQuery( "#walletTransactionsTable tr td" ).each(function( index ) {
		var details = jQuery( this ).html();
		var patt = new RegExp("<a");
		var res = patt.test(details);
		if ( res ) {
			jQuery(this).children('a').removeAttr("href");
		}
	});
	</script>
</div>   

