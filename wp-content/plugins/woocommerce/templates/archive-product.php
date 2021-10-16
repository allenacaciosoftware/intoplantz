<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<style>
    /* Product Page */

    .products {
        margin-top: 100px;
    }

    .products .filters {
        text-align: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 60px;
    }

    .products .filters li {
        text-transform: uppercase;
        font-size: 13px;
        font-weight: 700;
        color: #121212;
        display: inline-block;
        margin: 0px 10px;
        transition: all .3s;
        cursor: pointer;
    }

    .products .filters ul li.active,
    .products .filters ul li:hover {
        color: #f33f3f;
    }

    .products ul.pages {
        margin-top: 30px;
        text-align: center;
    }

    .products ul.pages li {
        display: inline-block;
        margin: 0px 2px;
    }

    .products ul.pages li a {
        width: 44px;
        height: 44px;
        display: inline-block;
        line-height: 42px;
        border: 1px solid #eee;
        font-size: 15px;
        font-weight: 700;
        color: #121212;
        transition: all .3s;
    }

    .products ul.pages li a:hover,
    .products ul.pages li.active a {
        background-color: #f33f3f;
        border-color: #f33f3f;
        color: #fff;
    }

    /* Latest Produtcs */

    .latest-products {
        margin-top: 100px;
    }

    .latest-products .section-heading a {
        float: right;
        margin-top: -35px;
        text-transform: uppercase;
        font-size: 13px;
        font-weight: 700;
        color: #f33f3f;
    }

    .product-item {
        border: 1px solid #eee;
        margin-bottom: 30px;
    }

    .product-item .down-content {
        padding: 30px;
        position: relative;
    }

    .product-item img {
        width: 100%;
        overflow: hidden;
    }

    .product-item .down-content h4 {
        font-size: 17px;
        color: #1a6692;
        margin-bottom: 20px;
    }

    .product-item .down-content h6 {
        position: absolute;
        top: 30px;
        right: 30px;
        font-size: 18px;
        color: #121212;
    }

    .product-item .down-content p {
        margin-bottom: 20px;
    }

    .product-item .down-content ul li {
        display: inline-block;
    }

    .product-item .down-content ul li i {
        color: #f33f3f;
        font-size: 14px;
    }

    .product-item .down-content span {
        position: absolute;
        right: 30px;
        bottom: 30px;
        font-size: 13px;
        color: #f33f3f;
        font-weight: 500;
    }
</style>
<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<!--    <div class="products">-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="col-md-12">-->
<!--                    <div class="filters">-->
<!--                        <ul>-->
<!--                            <li class="active" data-filter="*">All Products</li>-->
<!--                            <li data-filter=".des">Featured</li>-->
<!--                            <li data-filter=".dev">Flash Deals</li>-->
<!--                            <li data-filter=".gra">Last Minute</li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-12">-->
<!--                    <div class="filters-content">-->
<!--                        <div class="row grid">-->
<!--                            <div class="col-lg-4 col-md-4 all des">-->
<!--                                <div class="product-item">-->
<!--                                    <a href="#"><img src="assets/images/product_01.jpg" alt=""></a>-->
<!--                                    <div class="down-content">-->
<!--                                        <a href="#"><h4>Tittle goes here</h4></a>-->
<!--                                        <h6>$18.25</h6>-->
<!--                                        <p>Lorem ipsume dolor sit amet, adipisicing elite. Itaque, corporis nulla aspernatur.</p>-->
<!--                                        <ul class="stars">-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                        </ul>-->
<!--                                        <span>Reviews (12)</span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-lg-4 col-md-4 all dev">-->
<!--                                <div class="product-item">-->
<!--                                    <a href="#"><img src="assets/images/product_02.jpg" alt=""></a>-->
<!--                                    <div class="down-content">-->
<!--                                        <a href="#"><h4>Tittle goes here</h4></a>-->
<!--                                        <h6>$16.75</h6>-->
<!--                                        <p>Lorem ipsume dolor sit amet, adipisicing elite. Itaque, corporis nulla aspernatur.</p>-->
<!--                                        <ul class="stars">-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                        </ul>-->
<!--                                        <span>Reviews (24)</span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-lg-4 col-md-4 all gra">-->
<!--                                <div class="product-item">-->
<!--                                    <a href="#"><img src="assets/images/product_03.jpg" alt=""></a>-->
<!--                                    <div class="down-content">-->
<!--                                        <a href="#"><h4>Tittle goes here</h4></a>-->
<!--                                        <h6>$32.50</h6>-->
<!--                                        <p>Lorem ipsume dolor sit amet, adipisicing elite. Itaque, corporis nulla aspernatur.</p>-->
<!--                                        <ul class="stars">-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                        </ul>-->
<!--                                        <span>Reviews (36)</span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-lg-4 col-md-4 all gra">-->
<!--                                <div class="product-item">-->
<!--                                    <a href="#"><img src="assets/images/product_04.jpg" alt=""></a>-->
<!--                                    <div class="down-content">-->
<!--                                        <a href="#"><h4>Tittle goes here</h4></a>-->
<!--                                        <h6>$24.60</h6>-->
<!--                                        <p>Lorem ipsume dolor sit amet, adipisicing elite. Itaque, corporis nulla aspernatur.</p>-->
<!--                                        <ul class="stars">-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                            <li><i class="fa fa-star"></i></li>-->
<!--                                        </ul>-->
<!--                                        <span>Reviews (48)</span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <script src="custom.js"></script>-->
<!--    <script src="../../assets/js/custom/owl.js"></script>-->
<!--    <script src="../../assets/js/custom/slick.js"></script>-->
<!--    <script src="../../assets/js/custom/isotope.js"></script>-->
<!--    <script src="../../assets/js/custom/accordions.js"></script>-->

<?php

//echo "test product loop 1";
if ( woocommerce_product_loop() ) {
//    echo "test product loop 2";
	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );
//    echo "test product loop 3";
	woocommerce_product_loop_start();
//    echo "test product loop 4";
//	if ( wc_get_loop_prop( 'total' ) ) {
//        echo "test product loop 5";
        while ( have_posts() ) {
//            echo "test product loop 6";
            the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
//	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
