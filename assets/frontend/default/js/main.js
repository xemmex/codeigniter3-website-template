var deviceAgent = navigator.userAgent.toLowerCase();
var iOS = deviceAgent.match(/(iphone|ipod|ipad)/);
var htmlScrollbar, menuScrollbar;

document.body.className = document.body.className.replace(/\bno\-js\b/gi, "");

jQuery(document).ready(function ($) {

    // initialize custom scrollbar
    if (!iOS) {
        htmlScrollbar = $("html").niceScroll({
            cursoropacitymax: 0.8,
            cursorcolor: '#000',
            cursorwidth: "8px",
            cursorborder: 'none',
            cursorborderradius: '6px',
            cursorminheight: 50,
            mousescrollstep: 50,
            grabcursorenabled: false,
            dblclickzoom: false
        });
        menuScrollbar = $("#header").niceScroll({
            cursoropacitymax: 0.8,
            cursorcolor: '#000',
            cursorwidth: "5px",
            cursorborder: 'none',
            cursorborderradius: '4px',
            cursorminheight: 50,
            mousescrollstep: 50,
            grabcursorenabled: false,
            dblclickzoom: false
        });
    }

    // Contact MAP
    if ($("#contact_us_map").length > 0) {
        var map_position = new google.maps.LatLng($("#contact_us_map").attr('data-latitude'), $("#contact_us_map").attr('data-longitude'));
        var map_options = {
            scrollwheel: false,
            center: map_position,
            zoom: parseInt($("#contact_us_map").attr('data-zoom')),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("contact_us_map"), map_options);
        new google.maps.Marker({
            position: map_position,
            map: map,
            title: $("#contact_us_map").attr('data-title')
        });
    }

    // Tabs
    if ($(".tabs").length > 0) {
        $('.tabs').tabify();
    }

    // Accordion
    $('.accordion .accordion-title').click(function (e) {
        $li = $(this).parent('li');
        $ul = $li.parent('.accordion');
        // check if only one accordion can be opened at a time
        if ($ul.hasClass('only-one-visible')) {
            $('li', $ul).not($li).removeClass('active');
        }
        $li.toggleClass('active');
        e.preventDefault();
    });

    // initialize tooltips
    $('.tooltip').tipsy({
        fade: true,
        live: true,
        opacity: 1,
        offset: 4,
        gravity: $.fn.tipsy.autoNS
    });

    $('form .help').tipsy({
        trigger: 'focus',
        opacity: 1,
        offset: 2,
        gravity: $.fn.tipsy.autoWE
    });

    // initialize supersized plugin, only if it's placed in the markup
    if ($("#supersized").length > 0) {
        $.supersized({
            horizontal_center: 1,
            vertical_center: 1,
            slideshow: 1,
            autoplay: 1,
            transition: 1,
            transition_speed: 500,
            image_protect: 1,
            slides: supersized_slides
        });

        theme = {
            beforeAnimation: function (state) {
                $('#supersized-info h2 a')
                        .html(api.getField('article_title'))
                        .attr('href', api.getField('article_url'));
                $('#supersized-info p').html(api.getField('article_text'));
            }
        }
        $('.supersized-prev, .supersized-next').click(function (e) {
            if ($(this).hasClass("supersized-next")) {
                api.nextSlide();
            } else if ($(this).hasClass("supersized-prev")) {
                api.prevSlide();
            }
            e.preventDefault();
        });

        $('.supersized-fullscreen').click(function (e) {
            if ($('body').hasClass("expand-supersized")) {
                if (!$('#header').hasClass('hide-menu-manual')) {
                    $('#header').removeClass('hide-menu');
                }
                $('body').removeClass('expand-supersized');
                $('#main,#footer').show();
                $('#supersized').css('right', '');
                $(window).trigger('resize');
            } else {
                $('body').addClass('expand-supersized');
                $('#header').addClass('hide-menu');
                $('#supersized').css('right', 0);
                $('#main,#footer').hide();
                $(window).trigger('resize');
            }
            e.preventDefault();
        });
    }

    $('#menu li').on('hover', function () {
        $(this).addClass("hover");
    }, function () {
        $(this).removeClass("hover");
    });

    $('#menu li.arrow a').on('click', function (e) {
        $el = $(this).parent();
        if ($el.hasClass('arrow')) {
            $el.toggleClass("hover");
            $el.toggleClass('expand-menu');
            if (!iOS) {
                htmlScrollbar.resize();
                menuScrollbar.resize();
            }
            e.preventDefault();
        }
    });

    $('.menu-toggle').on('click', function () {
        $('#header').toggleClass('hide-menu').toggleClass('hide-menu-manual');
        if (!iOS) {
            htmlScrollbar.resize();
        }
    });

    // Go to TOP
    $('#top-link').on('click', function (e) {
        $('html, body').animate({
            scrollTop: 0
        }, 750, 'linear');
        e.preventDefault();
        return false;
    });

});