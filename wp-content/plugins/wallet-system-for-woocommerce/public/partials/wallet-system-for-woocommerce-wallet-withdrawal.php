<?php
/**
 * Exit if accessed directly
 *
 * @package Wallet_System_For_Woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$wallet_bal = get_user_meta( $user_id, 'mwb_wallet', true );
$wallet_bal = apply_filters( 'mwb_wsfw_show_converted_price', $wallet_bal );

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
    <?php
    if ( $wallet_bal > 0 ) {
        ?>
        <form method="post" action="" id="mwb_wallet_transfer_form">
            <h6 style="text-align: left; display: flex; margin-bottom: 0" for="mwb_wallet_withdrawal_amount">Enter amount($) greater than 0</h6>
            <div style="display: flex">
                <p class="mwb-wallet-field-container form-row form-row-wide">
                    <input style="padding: 2px 10px;" type="number" step="0.01" min="0" data-max="<?php echo esc_attr( $wallet_bal ); ?>" id="mwb_wallet_withdrawal_amount" name="mwb_wallet_withdrawal_amount" required="">
                </p>
            </div>
            <p class="mwb-wallet-field-container form-row form-row-wide">
            <h6 style="text-align: left; display: flex; margin-bottom: 0" for="mwb_wallet_note"><?php esc_html_e( 'Reference note', 'wallet-system-for-woocommerce' ); ?></h6>
            <textarea id="mwb_wallet_note" name="mwb_wallet_note" required></textarea>
            </p>
            <p class="mwb-wallet-field-container form-row">
                <input type="hidden" name="wallet_user_id" value="<?php echo esc_attr( $user_id ); ?>">
                <input type="submit" class="button" style="color: #ffffff; border-color: #328d5a; background-color: #328d5a;" id="mwb_withdrawal_request" name="mwb_withdrawal_request" value="Request For Withdrawal"/>
            </p>
        </form>
        <?php
    } else {
        show_message_on_form_submit( 'Your wallet amount is 0, you cannot withdraw money from wallet.', 'woocommerce-error' );
    }
    ?>

    <?php
    $args               = array(
        'numberposts' => -1,
        'post_type'   => 'wallet_withdrawal',
        'orderby'     => 'ID',
        'order'       => 'DESC',
        'post_status' => array( 'any' ),
    );
    $withdrawal_request = get_posts( $args );
    ?>
    <hr/>
    <div class='content active'>
        <h3><b><?php echo esc_html( 'Request withdrawal transactions' ); ?></b></h3>
        <table id="walletWithdrawalTable" class="display">
            <thead style="background: cadetblue; color: white">
            <th>ID</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Reference note</th>
            <th>Date</th>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ( $withdrawal_request as $key => $pending ) {
                $request_id = $pending->ID;
                $userid     = get_post_meta( $request_id, 'wallet_user_id', true );
                if ( $userid == $user_id ) {
                    $date = date_create( $pending->post_date );
                    echo '<tr>
                            <td>' . esc_html( $request_id ) . '</td>
                            <td>' . wc_price( get_post_meta( $request_id, 'mwb_wallet_withdrawal_amount', true ), array( 'currency' => get_woocommerce_currency() ) ) . '</td>
                            <td>' . esc_html( $pending->post_status ) . '</td>
                            <td>' . esc_html( get_post_meta( $request_id, 'mwb_wallet_note', true ) ) . '</td>
                            <td>' . esc_html( date_format( $date, 'd/m/Y' ) ) . '</td>
                            </tr>';
                    $i++;
                }
            }
            ?>
            </tbody>
        </table>
        <script>
            $(document).ready(function() {
                $('#walletWithdrawalTable').DataTable({
                    "order": [[ 0, "desc" ]]
                });
            });
        </script>
    </div>
</div>
