
$(document).ready(function(){
	"use strict";

	var window_width 	 = $(window).width(),
	window_height 		 = window.innerHeight,
	header_height 		 = $(".default-header").height(),
	header_height_static = $(".site-header.static").outerHeight(),
	fitscreen 			 = window_height - header_height;


	$(".fullscreen").css("height", window_height)
	$(".fitscreen").css("height", fitscreen);

  //-------- Active Sticky Js ----------//
  $(".default-header").sticky({topSpacing:0});


     if(document.getElementById("default-select")){
          $('select').niceSelect();
    };

    $('.img-pop-up').magnificPopup({
        type: 'image',
        gallery:{
        enabled:true
        }
    });

  // $('.navbar-nav>li>a').on('click', function(){
  //     $('.navbar-collapse').collapse('hide');
  // });


    //  Counter Js

    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });

    $('.play-btn').magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });

    $('.active-works-carousel').owlCarousel({
        items:1,
        loop:true,
        margin: 100,
        dots: true,
        autoplay:true,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1,
            },
            768: {
                items: 1,
            }
        }
    });

    $('.active-gallery').owlCarousel({
        items:1,
        loop:true,
        dots: true,
        autoplay:true,
        nav:true,
        navText: ["<span class='lnr lnr-arrow-up'></span>",
        "<span class='lnr lnr-arrow-down'></span>"],
            responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1,
            },
            768: {
                items: 2,
            },
            900: {
                items: 6,
            }

        }
    });


$('.active-blog-slider').owlCarousel({
        loop: true,
        dots: false,
        items: 1,
        autoplay: true,
        autoplayTimeout: 2000,
        smartSpeed: 1000,
        animateOut: 'fadeOut',
      })


    // Select all links with hashes
    $('.navbar-nav a[href*="#"]')
    // Remove links that don't actually link to anything
    .not('[href="#"]')
    .not('[href="#0"]')
    .on('click',function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
      &&
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top-50
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
    });

      $(document).ready(function() {
          $('#mc_embed_signup').find('form').ajaxChimp();
      });

 });


function consult() {

    $('#myForm').submit(function (e) {
        e.preventDefault();
    });

    var data = $('#myForm').serializeArray();
  $.ajax({
    type: 'POST',
    url: '/register-new-user',
    headers: {
      "Ajax": "Ajax"
    },
    data: data ,
    cache: false,
    success: function(data) {

        switch (data){
            case '1':
                $('#results').html('Имя должно быть заполнено.');
                break;
            case '2':
                $('#results').html('Имя имеет не верный формат.');
                break;
            case '3':
                $('#results').html('Имейл должен быть заполнен.');
                break;
            case '4':
                $('#results').html('Имейл имеет не верный формат.');
                break;
            case '5':
                $('#results').html('Телефон должен быть заполнен.');
                break;
            case '6':
                $('#results').html('Телефон имеет не верный формат.');
                break;
            case '7':
                $('#results').html('Ваша заявка принята в обработку, ожидайте пока наш менеджер свяжется с вами.');
                document.getElementById('myForm').reset();
                break;
            case '8':
                $('#results').html('Вы уже подали заявку, ожидайте когда с вами свяжется наш преподователь.');
                document.getElementById('myForm').reset();
                break;
            default:
                $('#results').html(data);
                break;


        }
    },
    beforeSend: function() {
        $('#myForm').find(':input').attr("disabled", true);
    },
    complete: function() {
        $('#myForm').find(':input').attr("disabled", false);
    },
    error: function(xhr, str) {
      alert('Возникла ошибка: ' + xhr.responseCode);
    }
  });

}
