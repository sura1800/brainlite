(function ($) {
    "use strict";
    
    /*--
    currency active
    -----------------------------------*/
    if ($('.currency-wrap').length) {
        var $body2 = $('body'),
            $urdanDropdown2 = $('.currency-wrap'),
            $urdanDropdownMenu2 = $urdanDropdown2.find('.currency-dropdown');
        $urdanDropdown2.on('click', '.currency-active', function(e) {
            e.preventDefault();
            var $this = $(this);
            if (!$this.parent().hasClass('show')) {
                $this.siblings('.currency-dropdown').addClass('show').slideDown().parent().addClass('show');
            } else {
                $this.siblings('.currency-dropdown').removeClass('show').slideUp().parent().removeClass('show');
            }
        });
        /*Close When Click Outside*/
        $body2.on('click', function(e) {
            var $target = e.target;
            if (!$($target).is('.currency-wrap') && !$($target).parents().is('.currency-wrap') && $urdanDropdown2.hasClass('show')) {
                $urdanDropdown2.removeClass('show');
                $urdanDropdownMenu2.removeClass('show').slideUp();
            }
        });
    }
    
    /*--
    language active
    -----------------------------------*/
    if ($('.language-wrap').length) {
        var $body3 = $('body'),
            $urdanDropdown3 = $('.language-wrap'),
            $urdanDropdownMenu3 = $urdanDropdown3.find('.language-dropdown');
        $urdanDropdown3.on('click', '.language-active', function(e) {
            e.preventDefault();
            var $this = $(this);
            if (!$this.parent().hasClass('show')) {
                $this.siblings('.language-dropdown').addClass('show').slideDown().parent().addClass('show');
            } else {
                $this.siblings('.language-dropdown').removeClass('show').slideUp().parent().removeClass('show');
            }
        });
        /*Close When Click Outside*/
        $body3.on('click', function(e) {
            var $target = e.target;
            if (!$($target).is('.language-wrap') && !$($target).parents().is('.language-wrap') && $urdanDropdown3.hasClass('show')) {
                $urdanDropdown3.removeClass('show');
                $urdanDropdownMenu3.removeClass('show').slideUp();
            }
        });
    }


    var sliderActive = new Swiper('.slider-active', {
        loop: true,
        speed: 750,
        effect: 'fade',
        slidesPerView: 1,
        navigation: {
            nextEl: '.home-slider-next , .home-slider-next2 , .home-slider-next3',
            prevEl: '.home-slider-prev , .home-slider-prev2 , .home-slider-prev3',
        }
    });
    

    
    /*----------------------------
    	Cart Plus Minus Button
    ------------------------------ */
    var CartPlusMinus = $('.product-quality');
    CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
    CartPlusMinus.append('<div class="inc qtybutton">+</div>');
    $(".qtybutton").on("click", function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.text() === "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        $button.parent().find("input").val(newVal);
    });
    
    /*------ ScrollUp -------- */
    $.scrollUp({
        scrollText: '<i class=" ti-arrow-up "></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    });
    
    /*-----------------
        Menu Stick
    -----------------*/
    var header = $('.sticky-bar');
    var $window = $(window);
    $window.on('scroll', function() {
        var scroll = $window.scrollTop();
        if (scroll < 200) {
            header.removeClass('stick');
        } else {
            header.addClass('stick');
        }
    });
    
    /*-------------------------------
	   Header Search Toggle
    -----------------------------------*/
    var searchToggle = $('.search-toggle');
    searchToggle.on('click', function(e){
        e.preventDefault();
        if($(this).hasClass('open')){
           $(this).removeClass('open');
           $(this).siblings('.search-wrap-1').removeClass('open');
        }else{
           $(this).addClass('open');
           $(this).siblings('.search-wrap-1').addClass('open');
        }
    })
    
    /*====== SidebarCart ======*/
    function miniCart() {
        var navbarTrigger = $('.cart-active'),
            endTrigger = $('.cart-close'),
            container = $('.sidebar-cart-active'),
            wrapper = $('.main-wrapper');
        
        wrapper.prepend('<div class="body-overlay"></div>');
        
        navbarTrigger.on('click', function(e) {
            e.preventDefault();
            container.addClass('inside');
            wrapper.addClass('overlay-active');
        });
        
        endTrigger.on('click', function() {
            container.removeClass('inside');
            wrapper.removeClass('overlay-active');
        });
        
        $('.body-overlay').on('click', function() {
            container.removeClass('inside');
            wrapper.removeClass('overlay-active');
        });
    };
    miniCart();
    
    /*====== product-color-active ======*/
    $(".product-color-active ul li a").on('click', function(e) {
        e.preventDefault();
        $(".product-color-active ul li a").removeClass("active");
        $(this).addClass("active");
    });

    
    /*---------------------
        Price range
    --------------------- */
    var sliderrange = $('#slider-range');
    var amountprice = $('#amount');
    $(function() {
        sliderrange.slider({
            range: true,
            min: 20,
            max: 200,
            values: [0, 160],
            slide: function(event, ui) {
                amountprice.val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        amountprice.val("$" + sliderrange.slider("values", 0) +
            " - $" + sliderrange.slider("values", 1));
    }); 
    
    
    
    /*--- checkout toggle function ----*/
    $('.checkout-click1').on('click', function(e) {
        e.preventDefault();
        $('.checkout-login-info').slideToggle(900);
    });
    
    
    /*--- checkout toggle function ----*/
    $('.checkout-click3').on('click', function(e) {
        e.preventDefault();
        $('.checkout-login-info3').slideToggle(1000);
    });
    
    /*-------------------------
    Create an account toggle
    --------------------------*/
    $('.checkout-toggle2').on('click', function() {
        $('.open-toggle2').slideToggle(1000);
    });
    
    $('.checkout-toggle').on('click', function() {
        $('.open-toggle').slideToggle(1000);
    });
    
    /*-------------------------
    checkout one click toggle function
    --------------------------*/
    var checked = $( '.sin-payment input:checked' )
    if(checked){
        $(checked).siblings( '.payment-box' ).slideDown(900);
    };
	 $( '.sin-payment input' ).on('change', function() {
        $( '.payment-box' ).slideUp(900);
        $(this).siblings( '.payment-box' ).slideToggle(900);
    });
    
    // Instantiate EasyZoom instances
    var $easyzoom = $('.easyzoom').easyZoom();

    
    /*====== mobile-menu active ======*/
    const slinky = $('#mobile-menu').slinky();
    const slinky2 = $('#mobile-currency').slinky();
    const slinky3 = $('#mobile-language').slinky();
    
    /*====== off canvas active ======*/
    function mobileMainMenu() {
        var navbarTrigger = $('.mobile-menu-active-button'),
            endTrigger = $('.off-canvas-close'),
            container = $('.off-canvas-active'),
            wrapper = $('.main-wrapper-2');
        
        wrapper.prepend('<div class="body-overlay-2"></div>');
        
        navbarTrigger.on('click', function(e) {
            e.preventDefault();
            container.addClass('inside');
            wrapper.addClass('overlay-active-2');
        });
        
        endTrigger.on('click', function() {
            container.removeClass('inside');
            wrapper.removeClass('overlay-active-2');
        });
        
        $('.body-overlay-2').on('click', function() {
            container.removeClass('inside');
            wrapper.removeClass('overlay-active-2');
        });
    };
    mobileMainMenu();
    
    $('#drugTable').DataTable({
        responsive: {
            details: false
        }
    } );   

    

    /*-------------------------
      Scroll Animation
    --------------------------*/
    AOS.init({
        once: true,
        duration: 1000,
    });
    
})(jQuery);

