<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

//do_action( 'woocommerce_before_account_orders', $has_orders ); ?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<style>
    table, td, th {
        border: 1px solid #78a2a2;
        font-weight: bold;
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
<?php //if ( $has_orders ) : ?>
    <h2>Items I bought</h2>
    <table id="ordersTable" class="display">
        <thead style="background: cadetblue; color: white">
        <th>Order</th>
        <th>Date</th>
        <th>Status</th>
        <th>Total</th>
        </thead>
        <tbody>
            <?php foreach( $customer_orders->orders as $customer_order) {
                $order      = wc_get_order( $customer_order );
                $item_count = $order->get_item_count() - $order->get_item_count_refunded();
            ?>

                <tr>
                    <td><?php echo esc_html( _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number() ); ?></td>
                    <td><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></td>
                    <td><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></td>
                    <td>
                        <?php
                        /* translators: 1: formatted order total 2: total order items */
                        echo wp_kses_post( sprintf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ) );
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            let table = $('#ordersTable').DataTable({
                "order": [[ 0, "desc" ]]
            });
            $("#ordersTable tr").css("cursor", "pointer");
            $('#ordersTable tbody').on('click', 'tr', function () {
                let data = table.row( this ).data();
                location.href = '/my-account/view-order/' + data[0].replace("#", "") + '/';
            });
        });
    </script>
