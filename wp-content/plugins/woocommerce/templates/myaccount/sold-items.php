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
//do_action( 'woocommerce_account_sold-items_endpoint' );

// do_action( 'woocommerce_before_account_orders', $has_orders ); ?>
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
<?php
global $wpdb, $current_user;

$soldItems = $wpdb->get_results(
        "
select wz6b8gwoi.order_id, wp_z6b8gq_wc_order_product_lookup.date_created, status, product_qty, order_item_name, meta_value
from wp_z6b8gq_wc_order_product_lookup
join wp_z6b8gq_posts on ID = product_id
join wp_z6b8gq_woocommerce_order_items wz6b8gwoi on wp_z6b8gq_wc_order_product_lookup.order_item_id = wz6b8gwoi.order_item_id
join wp_z6b8gq_wc_order_stats wz6b8gwos on wz6b8gwoi.order_id = wz6b8gwos.order_id
join wp_z6b8gq_woocommerce_order_itemmeta w on wp_z6b8gq_wc_order_product_lookup.order_item_id = w.order_item_id and wz6b8gwoi.order_item_id = w.order_item_id
where post_author in ($current_user->ID) and meta_key='_line_subtotal'
order by wp_z6b8gq_wc_order_product_lookup.date_created desc;
			"
);
?>
    <h2>Items I sold</h2>
    <table id="ordersTable" class="display">
        <thead style="background: cadetblue; color: white">
        <th>Order</th>
        <th>Product</th>
        <th>Date</th>
        <th>Status</th>
        <th>Total</th>
        </thead>
        <tbody>
            <?php foreach( $soldItems as $soldItem) {
                $itemText = "item";
                if ($soldItem->product_qty > 1) {
                    $itemText = "items";
                }
            ?>

                <tr>
                    <td><?php echo esc_html( $soldItem->order_id ); ?></td>
                    <td><?php echo esc_html( $soldItem->order_item_name ); ?></td>
                    <td><?php echo esc_html( $soldItem->date_created ); ?></td>
                    <td><?php echo esc_html( ucfirst(str_replace("wc-","", $soldItem->status)) ); ?></td>
                    <td><?php echo esc_html( "$" . $soldItem->meta_value . " for " . $soldItem->product_qty . " $itemText"); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            let table = $('#ordersTable').DataTable({
                "order": [[ 0, "desc" ]]
            });
            // $("#ordersTable tr").css("cursor", "pointer");
            // $('#ordersTable tbody').on('click', 'tr', function () {
            //     let data = table.row( this ).data();
            //     location.href = '/my-account/view-order/' + data[0].replace("#", "") + '/';
            // });
        });
    </script>
