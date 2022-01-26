<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>
<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css'>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.4/css/tether.min.css'>
<style>
    @import url('https://fonts.googleapis.com/css?family=Roboto&display=swap');
    @import url('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    /**{ margin: 0; padding: 0;}*/
    /*body{*/
    /*    font-family: 'Roboto', sans-serif;*/
    /*    font-style: normal;*/
    /*    font-weight: 300;*/
    /*    font-smoothing: antialiased;*/
    /*    -webkit-font-smoothing: antialiased;*/
    /*    -moz-osx-font-smoothing: grayscale;*/
    /*    font-size: 15px;*/
    /*    background: #eee;*/
    /*}*/
    .intro{
        background: #fff;
        padding: 60px 30px;
        color: #333;
        margin-bottom: 15px;
        line-height: 1.5;
        text-align: center;
    }
    .intro h1 {
        font-size: 18pt;
        padding-bottom: 15px;

    }
    .intro p{
        font-size: 14px;
    }

    .action{
        text-align: center;
        display: block;
        margin-top: 20px;
    }

    a.btn {
        text-decoration: none;
        color: #666;
        border: 2px solid #666;
        padding: 10px 15px;
        display: inline-block;
        margin-left: 5px;
    }
    a.btn:hover{
        background: #666;
        color: #fff;
        transition: .3s;
        -webkit-transition: .3s;
    }
    .btn:before{
        font-family: FontAwesome;
        font-weight: normal;
        margin-right: 10px;
    }
    .github:before{content: "\f09b"}
    .down:before{content: "\f019"}
    .back:before{content:"\f112"}
    .credit{
        background: #fff;
        padding: 12px;
        font-size: 9pt;
        text-align: center;
        color: #333;
        margin-top: 40px;

    }
    .credit span:before{
        font-family: FontAwesome;
        color: #e41b17;
        content: "\f004";


    }
    .credit a{
        color: #333;
        text-decoration: none;
    }
    .credit a:hover{
        color: #1DBF73;
    }
    .credit a:hover:after{
        font-family: FontAwesome;
        content: "\f08e";
        font-size: 9pt;
        position: absolute;
        margin: 3px;
    }
    /*body {*/
    /*    position: relative;*/
    /*    overflow-x: hidden;*/
    /*    background-color: #CFD8DC;*/
    /*}*/
    /*body,*/
    /*html { height: 100%;}*/
    .nav .open > a,
    .nav .open > a:hover,
    .nav .open > a:focus {background-color: transparent;}

    /*-------------------------------*/
    /*           Wrappers            */
    /*-------------------------------*/

    #wrapper {
        padding-left: 0;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    #wrapper.toggled {
        padding-left: 220px;
    }

    /*#sidebar-wrapper {*/
    /*    z-index: 1000;*/
    /*    left: 220px;*/
    /*    width: 0;*/
    /*    height: 100%;*/
    /*    margin-left: -220px;*/
    /*    overflow-y: auto;*/
    /*    overflow-x: hidden;*/
    /*    background: #1a1a1a;*/
    /*    -webkit-transition: all 0.5s ease;*/
    /*    -moz-transition: all 0.5s ease;*/
    /*    -o-transition: all 0.5s ease;*/
    /*    transition: all 0.5s ease;*/
    /*}*/

    /*#sidebar-wrapper::-webkit-scrollbar {*/
    /*    display: none;*/
    /*}*/

    /*#wrapper.toggled #sidebar-wrapper {*/
    /*    width: 220px;*/
    /*}*/

    #page-content-wrapper {
        width: 100%;
        padding-top: 70px;
    }

    #wrapper.toggled #page-content-wrapper {
        position: absolute;
        margin-right: -220px;
    }

    /*-------------------------------*/
    /*     Sidebar nav styles        */
    /*-------------------------------*/
    .navbar {
        padding: 0;
    }

    .sidebar-nav {
        position: absolute;
        top: 0;
        width: 220px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .sidebar-nav li {
        position: relative;
        line-height: 20px;
        display: inline-block;
        width: 100%;
        background: cadetblue;
        border-bottom: 1px solid black;
    }

    .sidebar-nav li:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        z-index: -1;
        height: 100%;
        width: 3px;
        background-color: #1c1c1c;
        -webkit-transition: width .2s ease-in;
        -moz-transition:  width .2s ease-in;
        -ms-transition:  width .2s ease-in;
        transition: width .2s ease-in;

    }
    .sidebar-nav li:first-child a {
        color: #fff;
        background-color: #1a1a1a;
    }
    .sidebar-nav li:nth-child(5n+1):before {
        background-color: #ec1b5a;
    }
    .sidebar-nav li:nth-child(5n+2):before {
        background-color: #79aefe;
    }
    .sidebar-nav li:nth-child(5n+3):before {
        background-color: #314190;
    }
    .sidebar-nav li:nth-child(5n+4):before {
        background-color: #279636;
    }
    .sidebar-nav li:nth-child(5n+5):before {
        background-color: #7d5d81;
    }

    .sidebar-nav li:hover:before,
    .sidebar-nav li.open:hover:before {
        width: 100%;
        -webkit-transition: width .2s ease-in;
        -moz-transition:  width .2s ease-in;
        -ms-transition:  width .2s ease-in;
        transition: width .2s ease-in;
    }

    .sidebar-nav li a {
        display: block;
        color: #ddd;
        text-decoration: none;
        padding: 10px 15px 10px 30px;
    }

    ul.dropdown-menu li a{
        background: black;
    }

    .sidebar-nav li a:active,
    .sidebar-nav li a:focus,
    .sidebar-nav li.open a:active,
    .sidebar-nav li.open a:focus{
        color: #fff;
        text-decoration: none;
        background-color: cadetblue;
    }

    .sidebar-nav li a:hover,
    .sidebar-nav li.open a:hover {
        color: #fff;
        text-decoration: none;
        background-color: dimgrey;
    }

    .sidebar-header {
        text-align: center;
        font-size: 20px;
        position: relative;
        width: 100%;
        display: inline-block;
    }
    .sidebar-brand {
        height: 65px;
        position: relative;
        background:#212531;
        background: linear-gradient(to right bottom, #2f3441 50%, #212531 50%);
        padding-top: 1em;
    }
    .sidebar-brand a {
        color: #ddd;
    }
    .sidebar-brand a:hover {
        color: #fff;
        text-decoration: none;
    }
    .dropdown-header {
        text-align: center;
        font-size: 1em;
        color: #ddd;
        background:#212531;
        background: linear-gradient(to right bottom, #2f3441 50%, #212531 50%);
    }
    .sidebar-nav .dropdown-menu {
        position: relative;
        width: 100%;
        padding: 0;
        margin: 0;
        border-radius: 0;
        border: none;
        background-color: #222;
        box-shadow: none;
    }
    .dropdown-menu.show {
        top: 0;
    }
    /*Fontawesome icons*/
    .nav.sidebar-nav li a::before {
        font-family: fontawesome;
        content: "\f12e";
        vertical-align: baseline;
        display: inline-block;
        padding-right: 5px;
    }
    a[href*="#home"]::before {
        content: "\f015" !important;
    }
    a[href*="#about"]::before {
        content: "\f129" !important;
    }
    a[href*="#events"]::before {
        content: "\f073" !important;
    }
    a[href*="#events"]::before {
        content: "\f073" !important;
    }
    a[href*="#team"]::before {
        content: "\f0c0" !important;
    }
    a[href*="#works"]::before {
        content: "\f0b1" !important;
    }
    a[href*="#pictures"]::before {
        content: "\f03e" !important;
    }
    a[href*="#videos"]::before {
        content: "\f03d" !important;
    }
    a[href*="#books"]::before {
        content: "\f02d" !important;
    }
    a[href*="#art"]::before {
        content: "\f1fc" !important;
    }
    a[href*="#awards"]::before {
        content: "\f02e" !important;
    }
    a[href*="#services"]::before {
        content: "\f013" !important;
    }
    a[href*="#contact"]::before {
        content: "\f086" !important;
    }
    a[href*="#followme"]::before {
        content: "\f099" !important;
        color: #0084b4;
    }
</style>
<nav class="navbar navbar-inverse " id="sidebar-wrapper" role="navigation" style="width: 30%">
    <ul class="nav sidebar-nav">
        <div class="sidebar-header"><div class="sidebar-brand"><a href="#">My Account</a></div></div>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle"  data-toggle="dropdown">Buying<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="/my-account/orders/">Items I bought</a></li>
            </ul>
            </a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle"  data-toggle="dropdown">Selling<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="/my-account/sold-items/">Sold items</a></li>
                <li><a href="/my-account/wcj-my-products/">My products</a></li>
                <li><a href="/my-account/wcj-my-products/?wcj_edit_product">Add product</a></li>
            </ul>
            </a>
        </li>
        <li><a href="/my-account/edit-address/">Addresses</a></li>
        <li><a href="/my-account/edit-account/">Account Details</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle"  data-toggle="dropdown">Wallet<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="/my-account/mwb-wallet/wallet-withdrawal/">Request Withdrawal</a></li>
                    <li><a href="/my-account/mwb-wallet/wallet-transactions/">Transactions</a></li>
                </ul>
            </a>
        </li>
    </ul>
</nav>


<script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'></script>
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.4/js/tether.min.js'></script>
<script>
    $(document).ready(function () {
        var trigger = $('.hamburger'),
            overlay = $('.overlay'),
            isClosed = false;

        trigger.click(function () {
            hamburger_cross();
        });

        function hamburger_cross() {

            if (isClosed == true) {
                overlay.hide();
                trigger.removeClass('is-open');
                trigger.addClass('is-closed');
                isClosed = false;
            } else {
                overlay.show();
                trigger.removeClass('is-closed');
                trigger.addClass('is-open');
                isClosed = true;
            }
        }

        $('[data-toggle="offcanvas"]').click(function () {
            $('#wrapper').toggleClass('toggled');
        });
    });
</script>


<?php do_action( 'woocommerce_after_account_navigation' ); ?>
