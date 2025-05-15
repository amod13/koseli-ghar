
// Categories Carousel
$(window).on('load', function () {
    $('.categories-carousel').imagesLoaded(function () {
        toggleCarousel();
    });

    function toggleCarousel() {
        if ($(window).width() < 768) {
            if (!$('.categories-carousel').hasClass('owl-loaded')) {
                $('.categories-carousel').addClass('owl-carousel');
                $('.categories-carousel').owlCarousel({
                    loop: true,
                    margin: 20,
                    dots: true,
                    nav: false,
                    autoplay: true,
                    smartSpeed: 1200,
                    items: 3,
                });
            }
        } else {
            if ($('.categories-carousel').hasClass('owl-loaded')) {
                $('.categories-carousel').trigger('destroy.owl.carousel');
                $('.categories-carousel').removeClass('owl-carousel owl-loaded');
                $('.categories-carousel').find('.owl-stage-outer').children().unwrap();
                $('.categories-carousel').find('.owl-stage, .owl-item').children().unwrap();
            }
        }
    }

    $(window).on('resize', toggleCarousel);
});


// Show or hide the sticky Header
window.onscroll = function() {addStickyClass()};
function addStickyClass() {
    // Check if the window width is greater than 768px (non-mobile view)
    if (window.innerWidth > 768) {
        var header = document.querySelector('.header__info'); // Adjust this selector to match your header class
        if (window.pageYOffset > header.offsetTop) {
            header.classList.add('sticky_element');
        } else {
            header.classList.remove('sticky_element');
        }
    }
}
