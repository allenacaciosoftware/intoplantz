<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>

<?php if ( $price_html = $product->get_price_html() ) : ?>
    <?php
        $stock_quantity = $product->get_stock_quantity();
        $product_avail  = $product->get_availability();
        $availability   = $product_avail['availability'];
    ?>
	<h2 class="price"  style="font-size: xx-large; margin-bottom: 0"><?php echo $price_html; ?></h2>
    <?php if ( $stock_quantity > 0 ) : ?>
	    <span class="price"  style="font-size: large; margin-bottom: 0"><?php echo $availability; ?></span>
    <?php endif; ?>
<?php endif; ?>

