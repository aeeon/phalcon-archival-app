$(document).ready(function () {
    var swiper1 = new Swiper('#newsletter-box .swiper-container', {
        autoplay: 12000,
        preloadImages: true,
        lazyLoading: false,
        pagination: '.swiper-pagination',
        paginationClickable: true
    });

    var swiper2 = new Swiper('#header-top .swiper-container', {
        autoplay: 6000,
        preloadImages: true,
        lazyLoading: false,
        pagination: '.swiper-pagination',
        paginationClickable: true,
        direction: 'vertical',
        onSlideChangeStart: function (swiper) {
          //  console.log("ee: " + swiper.activeIndex);
           // console.log("prev: " + swiper.previousIndex);
            var current = swiper.activeIndex;
            var prev = swiper.previousIndex;
            var prevEl = $(".slide-entry-" + prev);
            var currentEl = $(".slide-entry-" + current);
            if (prevEl.hasClass("active")) {
                prevEl.removeClass("active");
                currentEl.addClass("active");
            }
        }
    });




    /* var spv = 3, spv2 = 4;
     var win_width = $(window).width();
     if (win_width <= 1200) {
     spv = 2;
     if (win_width <= 868) {
     spv = 1;
     }
     } else {
     spv = 3;
     }*/
    var swiper = new Swiper('#our-team-box .swiper-container', {
        pagination: '.swiper-pagination',
        slidesPerView: 3,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        paginationClickable: true,
        spaceBetween: 30,
        loop: false,
        breakpoints: {
            1200: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            868: {
                slidesPerView: 1,
                spaceBetween: 10
            },
        }
    });
    /* $(window).resize(function () {
     var ww = $(window).width()
     if (ww > 1200)
     swiper.params.slidesPerView = 3;
     if (ww > 868 && ww <= 1200)
     swiper.params.slidesPerView = 2;
     if (ww <= 868)
     swiper.params.slidesPerView = 1;
     swiper.update();
     });
     $(window).trigger('resize');*/

    /*  var swiper2 = new Swiper('#oferta-subpage .oferta-akcesoria .swiper-container', {
     pagination: '.swiper-pagination',
     slidesPerView: spv2,
     paginationClickable: true,
     spaceBetween: 3
     });*/
    
    
    $('.porada-form').click(function()
    {
       location.href = "kontakt/"; 
    });
    
    $('.article-contact-form').click(function()
    {
       location.href = "kontakt/"; 
    });
    
    
    $('#add_comment').click(function()
    {
       $('#std_add_comment').click();
       return false;
    });
    
    
    $('#add_file').click(function()
    {
       $('#std_add_file').click();
       return false;
    });
});



