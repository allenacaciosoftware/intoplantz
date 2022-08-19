<?php
/**
 * The template for displaying vendor orders
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/vendor-dashboard/vendor-orders.php
 *
 * @author 		WC Marketplace
 * @package 	WCMp/Templates
 * @version   2.2.0
 */
if (!defined('ABSPATH')) {
    // Exit if accessed directly
    exit;
}
global $woocommerce, $WCMp;

$orders_list_table_headers = apply_filters('wcmp_datatable_order_list_table_headers', array(
    'select_order'  => array('label' => '', 'class' => 'text-center'),
    'order_id'      => array('label' => __( 'Order ID', 'dc-woocommerce-multi-vendor' )),
    'order_date'    => array('label' => __( 'Date', 'dc-woocommerce-multi-vendor' )),
    'vendor_earning'=> array('label' => __( 'Earnings', 'dc-woocommerce-multi-vendor' )),
    'order_status'  => array('label' => __( 'Status', 'dc-woocommerce-multi-vendor' )),
    'action'        => array('label' => __( 'Action', 'dc-woocommerce-multi-vendor' )),
), get_current_user_id());

$orders_list_table_headers2 = apply_filters('wcmp_datatable_order_list_table_headers', array(
    'order-number'      => array('label' => __( 'Order ID', 'dc-woocommerce-multi-vendor' )),
    'sub_order_id'      => array('label' => __( 'Sub-Order ID', 'dc-woocommerce-multi-vendor' )),
    'order-date'    => array('label' => __( 'Date', 'dc-woocommerce-multi-vendor' )),
    'order-status'  => array('label' => __( 'Status', 'dc-woocommerce-multi-vendor' )),
    'order-total'=> array('label' => __( 'Total', 'dc-woocommerce-multi-vendor' )),
), get_current_user_id());

$customer_orders = get_posts(
	apply_filters(
		'woocommerce_my_account_my_orders_query',
		array(
			'numberposts' => $order_count,
			'meta_key'    => '_customer_user',
			'meta_value'  => get_current_user_id(),
			'post_type'   => wc_get_order_types( 'view-orders' ),
			'post_status' => array_keys( wc_get_order_statuses() ),
		)
	)
);

?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="order_search pull-right">
                <input type="text" class="pro_search_key no_input form-control inline-input" id="pro_search_key" name="search_keyword" />
                <button class="wcmp_black_btn btn btn-secondary" type="button" id="pro_search_btn"><?php _e('Search', 'dc-woocommerce-multi-vendor'); ?></button>
            </div>
            <form name="wcmp_vendor_dashboard_orders" method="POST" class="form-inline">
                <div class="form-group">
                    <input type="date" name="wcmp_start_date_order" class="pickdate gap1 wcmp_start_date_order form-control" placeholder="<?php esc_attr_e('from', 'dc-woocommerce-multi-vendor'); ?>" value="<?php echo isset($_POST['wcmp_start_date_order']) ? wc_clean($_POST['wcmp_start_date_order']) : date('Y-m-01'); ?>" />
                    <!-- <span class="between">&dash;</span> -->
                </div>
                <div class="form-group">
                    <input type="date" name="wcmp_end_date_order" class="pickdate wcmp_end_date_order form-control" placeholder="<?php esc_attr_e('to', 'dc-woocommerce-multi-vendor'); ?>" value="<?php echo isset($_POST['wcmp_end_date_order']) ? wc_clean($_POST['wcmp_end_date_order']) : date('Y-m-d'); ?>" />
                </div>
                <button class="wcmp_black_btn btn btn-default" type="submit" name="wcmp_order_submit"><?php esc_html_e('Show', 'dc-woocommerce-multi-vendor'); ?></button>
            </form>
            <form method="post" name="wcmp_vendor_dashboard_completed_stat_export" id="wcmp_order_list_form">
                <div class="order-filter-actions alignleft actions">
                    <select id="order_bulk_actions" name="bulk_action" class="bulk-actions form-control inline-input">
                        <option value=""><?php esc_html_e('Bulk Actions', 'dc-woocommerce-multi-vendor'); ?></option>
                        <?php
                        $disallow_vendor_order_status = get_wcmp_vendor_settings('disallow_vendor_order_status', 'capabilities', 'product') && get_wcmp_vendor_settings('disallow_vendor_order_status', 'capabilities', 'product') == 'Enable' ? true : false;
                        if ($disallow_vendor_order_status) {
                            unset($bulk_actions['mark_processing'], $bulk_actions['mark_on-hold'], $bulk_actions['mark_completed']);
                        }
                        $bulk_actions['bulk_mark_shipped'] = __('Bulk Mark Shipped', 'dc-woocommerce-multi-vendor');
                        if( $bulk_actions ) :
                            foreach ( $bulk_actions as $key => $action ) {
                                echo '<option value="' . $key . '">' . $action . '</option>';
                            }
                        endif;
                        ?>
                    </select>
                    <button class="wcmp_black_btn btn btn-secondary" type="button" id="order_list_do_bulk_action"><?php esc_html_e('Apply', 'dc-woocommerce-multi-vendor'); ?></button>
                    <?php
                    $filter_by_status = apply_filters( 'wcmp_vendor_dashboard_order_filter_status_arr', array_merge(
                        array( 'all' => __('All', 'dc-woocommerce-multi-vendor'), 'request_refund' => __('Request Refund', 'dc-woocommerce-multi-vendor') ),
                        wc_get_order_statuses()
                    ) );
                    echo '<select id="filter_by_order_status" name="order_status" class="wcmp-filter-dtdd wcmp_filter_order_status form-control inline-input">';
                    if( $filter_by_status ) :
                    foreach ( $filter_by_status as $key => $status ) {
                        echo '<option value="' . $key . '">' . $status . '</option>';
                    }
                    endif;
                    echo '</select>';
                    ?>
                    <?php do_action( 'wcmp_vendor_order_list_add_extra_filters', get_current_user_id() ); ?>
                    <button class="wcmp_black_btn btn btn-secondary" type="button" id="order_list_do_filter"><?php esc_html_e('Filter', 'dc-woocommerce-multi-vendor'); ?></button>
                </div><br>
                <table class="table table-striped table-bordered" id="wcmp-vendor-orders" style="width:100%;">
                    <thead>
                        <tr>
                        <?php
                            if($orders_list_table_headers) :
                                foreach ($orders_list_table_headers as $key => $header) {
                                    if($key == 'select_order'){ ?>
                            <th class="<?php if(isset($header['class'])) echo $header['class']; ?>"><input type="checkbox" class="select_all_all" onchange="toggleAllCheckBox(this, 'wcmp-vendor-orders');" /></th>
                                <?php }else{ ?>
                            <th class="<?php if(isset($header['class'])) echo $header['class']; ?>"><?php if(isset($header['label'])) echo $header['label']; ?></th>
                                <?php }
                                }
                            endif;
                        ?>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            <?php if(apply_filters('can_wcmp_vendor_export_orders_csv', true, get_current_vendor_id())) : ?>
            <div class="wcmp-action-container" style="display: none;">
                <input class="btn btn-default" type="submit" name="wcmp_download_vendor_order_csv" value="<?php esc_attr_e('Download CSV', 'dc-woocommerce-multi-vendor') ?>" />
            </div>
            <?php endif; ?>
            <?php if (isset($_POST['wcmp_start_date_order'])) : ?>
                <input type="hidden" name="wcmp_start_date_order" value="<?php echo isset($_POST['wcmp_start_date_order']) ? wc_clean($_POST['wcmp_start_date_order']) : date('Y-m-d'); ?>" />
            <?php endif; ?>
            <?php if (isset($_POST['wcmp_end_date_order'])) : ?>
                <input type="hidden" name="wcmp_end_date_order" value="<?php echo isset($_POST['wcmp_end_date_order']) ? wc_clean($_POST['wcmp_end_date_order']) : date('Y-m-d'); ?>" />
            <?php endif; ?>
            </form>
        </div>
    </div>

    Order Items I bought
    <table class="table table-striped table-bordered" id="my-orders-datatable" style="width:100%;">
        <thead>
            <tr>
            <?php
                if($orders_list_table_headers2) :
                    foreach ($orders_list_table_headers2 as $key => $header) {
                        if($key == 'select_order'){ ?>`
                <th class="<?php if(isset($header['class'])) echo $header['class']; ?>"><input type="checkbox" class="select_all_all" onchange="toggleAllCheckBox(this, 'wcmp-vendor-orders');" /></th>
                    <?php }else{ ?>
                <th class="<?php if(isset($header['class'])) echo $header['class']; ?>"><?php if(isset($header['label'])) echo $header['label']; ?></th>
                    <?php }
                    }
                endif;
            ?>
            </tr>
        </thead>
        <tbody>
			<?php
			foreach ( $customer_orders as $customer_order ) :
				$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				$item_count = $order->get_item_count();
				?>
				<tr class="order">
					<?php foreach ( $orders_list_table_headers2 as $column_id => $column_name ) : ?>
						<td class="<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
								<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

							<?php elseif ( 'order-number' === $column_id ) : ?>
								<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
									<?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</a>

							<?php elseif ( 'order-date' === $column_id ) : ?>
								<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

							<?php elseif ( 'order-status' === $column_id ) : ?>
								<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

							<?php elseif ( 'order-total' === $column_id ) : ?>
								<?php
								/* translators: 1: formatted order total 2: total order items */
								printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>

							<?php elseif ( 'order-actions' === $column_id ) : ?>
								<?php
								$actions = wc_get_account_orders_actions( $order );

								if ( ! empty( $actions ) ) {
									foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
										echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
									}
								}
								?>
							<?php endif; ?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>


        </tbody>
    </table>


    <!-- Modal -->
    <div id="marke-as-ship-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?php esc_html_e('Shipment Tracking Details', 'dc-woocommerce-multi-vendor'); ?></h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tracking_url"><?php esc_html_e('Enter Tracking Url', 'dc-woocommerce-multi-vendor'); ?> *</label>
                            <input type="url" class="form-control" id="email" name="tracking_url" required="">
                        </div>
                        <div class="form-group">
                            <label for="tracking_id"><?php esc_html_e('Enter Tracking ID', 'dc-woocommerce-multi-vendor'); ?> *</label>
                            <input type="text" class="form-control" id="pwd" name="tracking_id" required="">
                        </div>
                    </div>
                    <input type="hidden" name="order_id" id="wcmp-marke-ship-order-id" />
                    <?php if (isset($_POST['wcmp_start_date_order'])) : ?>
                        <input type="hidden" name="wcmp_start_date_order" value="<?php echo wc_clean($_POST['wcmp_start_date_order']); ?>" />
                    <?php endif; ?>
                    <?php if (isset($_POST['wcmp_end_date_order'])) : ?>
                        <input type="hidden" name="wcmp_end_date_order" value="<?php echo wc_clean($_POST['wcmp_end_date_order']); ?>" />
                    <?php endif; ?>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="wcmp-submit-mark-as-ship"><?php esc_html_e('Submit', 'dc-woocommerce-multi-vendor'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function ($) {
        var orders_table;
        var columns = [];
        <?php if($orders_list_table_headers) {
        foreach ($orders_list_table_headers as $key => $header) { ?>
        obj = {};
        obj['data'] = '<?php echo esc_js($key); ?>';
        obj['className'] = '<?php if(isset($header['class'])) echo esc_js($header['class']); ?>';
        columns.push(obj);
        <?php }
        }
        ?>
        orders_table2 = $('#my-orders-datatable').DataTable({

        });

        orders_table = $('#wcmp-vendor-orders').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ordering: false,
            responsive: true,
            drawCallback: function (settings) {
                if(settings.json.notices.length > 0 ){
                    $('.wcmp-wrapper .notice-wrapper').html('');
                    $.each(settings.json.notices, function( index, notice ) {
                        if(notice.type == 'success'){
                            $('.wcmp-wrapper .notice-wrapper').append('<div class="woocommerce-message" role="alert">'+notice.message+'</div>');
                        }else{
                            $('.wcmp-wrapper .notice-wrapper').append('<div class="woocommerce-error" role="alert">'+notice.message+'</div>');
                        }
                    });
                }
            },
            language: {
                emptyTable: "<?php echo trim(__('No orders found!', 'dc-woocommerce-multi-vendor')); ?>",
                processing: "<?php echo trim(__('Processing...', 'dc-woocommerce-multi-vendor')); ?>",
                info: "<?php echo trim(__('Showing _START_ to _END_ of _TOTAL_ orders', 'dc-woocommerce-multi-vendor')); ?>",
                infoEmpty: "<?php echo trim(__('Showing 0 to 0 of 0 orders', 'dc-woocommerce-multi-vendor')); ?>",
                lengthMenu: "<?php echo trim(__('Number of rows _MENU_', 'dc-woocommerce-multi-vendor')); ?>",
                zeroRecords: "<?php echo trim(__('No matching orders found', 'dc-woocommerce-multi-vendor')); ?>",
                paginate: {
                    next: "<?php echo trim(__('Next', 'dc-woocommerce-multi-vendor')); ?>",
                    previous: "<?php echo trim(__('Previous', 'dc-woocommerce-multi-vendor')); ?>"
                }
            },
            ajax: {
                url: '<?php echo add_query_arg( 'action', 'wcmp_datatable_get_vendor_orders', $WCMp->ajax_url() ); ?>',
                type: "post",
                data: function (data) {
                    data.orders_filter_action = $('form#wcmp_order_list_form').serialize();
                    data.start_date = '<?php echo $start_date; ?>';
                    data.end_date = '<?php echo $end_date; ?>';
                    data.bulk_action = $('#order_bulk_actions').val();
                    data.order_status = $('#filter_by_order_status').val();
                    data.search_keyword = $('#pro_search_key').val();
                },
                error: function(xhr, status, error) {
                    $("#wcmp-vendor-orders tbody").append('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty" style="text-align:center;">'+error+' - <a href="javascript:window.location.reload();"><?php _e('Reload', 'dc-woocommerce-multi-vendor'); ?></a></td></tr>');
                    $("#wcmp-vendor-orders_processing").css("display","none");
                }
            },
            columns: columns
        });
        new $.fn.dataTable.FixedHeader( orders_table );
        $(document).on('click', '#order_list_do_filter', function (e) {
            orders_table.ajax.reload();
        });
        $(document).on('click', '#order_list_do_bulk_action', function (e) {
            orders_table.ajax.reload();
        });
        // Bulk mark as shipped
        $(document).on('change', '#order_bulk_actions', function () {
            if ($(this).val() == 'bulk_mark_shipped') {
                $('#wcmp-marke-ship-order-id').val($('form#wcmp_order_list_form').serialize());
                $('#marke-as-ship-modal').modal('show');
            }
        });
        // order search
        $(document).on('click', '#pro_search_btn', function () {
            orders_table.ajax.reload();
        });
    });

    function wcmpMarkeAsShip(self, order_id) {
        jQuery('#wcmp-marke-ship-order-id').val(order_id);
        jQuery('#marke-as-ship-modal').modal('show');
    }
</script>