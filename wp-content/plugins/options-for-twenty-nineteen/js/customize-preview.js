(function($) {

	wp.customize('logo_align', function(value) {
		value.bind(function(newval) {
		    if (newval === '') {
                $('.site-logo').css('text-align', 'left');
    		}
		    if (newval == 'center') {
                $('.site-logo').css('text-align', 'center');
    		}
		    if (newval == 'right') {
                $('.site-logo').css('text-align', 'right');
    		}
        });
	});

	wp.customize('site_title_align', function(value) {
		value.bind(function(newval) {
		    if (newval === '') {
                $('.site-title, .featured-image .site-title').css('display', 'inline');
                $('.site-title, .featured-image .site-title').css('text-align', 'left');
    		}
		    if (newval == 'center') {
                $('.site-title, .featured-image .site-title').css('display', 'block');
                $('.site-title, .featured-image .site-title').css('text-align', 'center');
    		}
		    if (newval == 'right') {
                $('.site-title, .featured-image .site-title').css('display', 'block');
                $('.site-title, .featured-image .site-title').css('text-align', 'right');
    		}
        });
	});

	wp.customize('site_description_align', function(value) {
		value.bind(function(newval) {
		    if (newval === '') {
                $('.site-description').css('display', 'inline');
                $('.site-description').css('text-align', 'left');
    		}
		    if (newval == 'center') {
                $('.site-description').css('display', 'block');
                $('.site-description').css('text-align', 'center');
    		}
		    if (newval == 'right') {
                $('.site-description').css('display', 'block');
                $('.site-description').css('text-align', 'right');
    		}
        });
	});

	wp.customize('remove_logo_background', function(value) {
		value.bind(function(newval) {
		    if (newval == 1) {
                $('.site-header.featured-image .custom-logo-link').css('background', 'none');
		    } else {
                $('.site-header.featured-image .custom-logo-link').css('background', 'white');
		    }
        });
	});

	wp.customize('page_title_font_weight', function(value) {
		value.bind(function(newval) {
		    if (newval === '') {
                $('.entry .entry-title').css('font-weight', '700');
		    } else {
                $('.entry .entry-title').css('font-weight', newval);
		    }
		});
	});

	wp.customize('page_title_text_transform', function(value) {
		value.bind(function(newval) {
		    if (newval === '') {
                $('.entry .entry-title').css('text-transform', 'none');
		    } else {
                $('.entry .entry-title').css('text-transform', newval);
		    }
		});
	});

	wp.customize('post_meta_location', function(value) {
		value.bind(function(newval) {
		    if (newval === '') {
                $('.single-post .entry-meta, .single-post .entry-footer').css('display', 'block');
    		}
		    if (newval == 'above') {
                $('.single-post .entry-meta').css('display', 'block');
                $('.single-post .entry-footer').css('display', 'none');
    		}
		    if (newval == 'below') {
                $('.single-post .entry-meta').css('display', 'none');
                $('.single-post .entry-footer').css('display', 'block');
    		}
		    if (newval == 'none') {
                $('.single-post .entry-meta, .single-post .entry-footer').css('display', 'none');
    		}
        });
	});

	wp.customize('remove_posted_on', function(value) {
		value.bind(function(newval) {
		    if (newval == 1) {
                $('.twentynineteen-customizer .entry .entry-meta > .posted-on, .twentynineteen-customizer .entry .entry-footer > .posted-on, .entry .entry-meta > .posted-on, .entry .entry-footer > .posted-on, .site-header.featured-image .site-featured-image .entry-header .entry-meta > .posted-on').css('display', 'none');
		    } else {
                $('.twentynineteen-customizer .entry .entry-meta > .posted-on, .twentynineteen-customizer .entry .entry-footer > .posted-on, .entry .entry-meta > .posted-on, .entry .entry-footer > .posted-on, .site-header.featured-image .site-featured-image .entry-header .entry-meta > .posted-on').css('display', 'inline-block');
		    }
        });
	});

	wp.customize('remove_author', function(value) {
		value.bind(function(newval) {
		    if (newval == 1) {
                $('.twentynineteen-customizer .entry .entry-meta > .byline, .twentynineteen-customizer .entry .entry-footer > .byline, .entry .entry-meta > .byline, .entry .entry-footer > .byline, .site-header.featured-image .site-featured-image .entry-header .entry-meta > .byline').css('display', 'none');
		    } else {
                $('.twentynineteen-customizer .entry .entry-meta > .byline, .twentynineteen-customizer .entry .entry-footer > .byline, .entry .entry-meta > .byline, .entry .entry-footer > .byline, .site-header.featured-image .site-featured-image .entry-header .entry-meta > .byline').css('display', 'inline-block');
		    }
        });
	});

	wp.customize('footer_background_color', function(value) {
		value.bind(function(newval) {
		    if (newval === '') {
                $('.site-footer').css('background-color', 'transparent');
		    } else {
                $('.site-footer').css('background-color', newval);
		    }
		});
	});

	wp.customize('body_background_color', function(value) {
		value.bind(function(newval) {
		    if (newval === '') {
                $('body').css('background-color', '#ffffff');
		    } else {
                $('body').css('background-color', newval);
		    }
		});
	});

})(jQuery);
