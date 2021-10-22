<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<style>

    ul li {
        box-shadow: 5px 5px 20px 0 rgb(0 0 0 / 10%) !important;
        padding-bottom: 20px;
        flex: 30%;
        flex-grow: 0;
    }
    ul li:last-child {
        content: "";
        margin-left: 20px !important;
    }
    ul li div.astra-shop-summary-wrap {
        padding-top: 10px;
        padding-left: 20px;
        padding-right: 20px;
    }
    .astra-shop-thumbnail-wrap {
        border-bottom: 1px solid #aaadac;
    }

    .woocommerce-loop-product__title {
        font-weight: 700;
        text-transform: uppercase;
        margin: 20px auto 0 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ast-article-post:last-child {
        margin-bottom: auto !important;
    }

    .woocommerce-loop-product__title {
        margin: 0;
    }

    ul.box.products {
        list-style: none;
    }
</style>
<ul class="box products" >
<!--<ul class="box products columns---><?php //echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?><!--" >-->
