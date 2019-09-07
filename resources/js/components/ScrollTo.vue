<template>
    <a :href="target" class="scroll-to-top rounded"><i class="fas fa-angle-up"></i></a>
</template>

<script>
    export default {
        name: "ScrollTop",

        props: ['target'],

        created() {
            // Scroll to top button appear
            $(document).scroll(function() {
                var scrollDistance = $(this).scrollTop();
                if (scrollDistance > 100) {
                    $('.scroll-to-top').fadeIn();
                } else {
                    $('.scroll-to-top').fadeOut();
                }
            });
            // Configure tooltips globally
            $('[data-toggle="tooltip"]').tooltip()
            // Smooth scrolling using jQuery easing
            $(document).on('click', 'a.scroll-to-top', function(event) {
                var $anchor = $(this);
                $('html, body').stop().animate({
                    scrollTop: ($($anchor.attr('href')).offset().top)
                }, 1000, 'easeInOutExpo');
                event.preventDefault();
            });
        }
    }
</script>

<style scoped>
    .scroll-to-top {
        position: fixed;
        right: 15px;
        bottom: 15px;
        display: none;
        width: 50px;
        height: 50px;
        text-align: center;
        color: #fff;
        background: rgba(52,58,64,.5);
        line-height: 46px;
    }
</style>
