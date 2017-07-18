<script src="/lander/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<script src="/lander/js/jquery.isotope.min.js"></script>
<script src="/lander/js/jquery.nicescroll.min.js"></script>
<script src="/lander/js/fancybox/jquery.fancybox.pack.js"></script>
<script src="/lander/js/skrollr.min.js"></script>
<script src="/lander/js/jquery.scrollTo-1.4.3.1-min.js"></script>
<script src="//cdn.jsdelivr.net/jquery.localscroll/1.4.0/jquery.localScroll.min.js"></script>
<script src="/lander/js/stellar.js"></script>
<script src="/lander/js/responsive-slider.js"></script>
<script src="/lander/js/jquery.appear.js"></script>
<script src="/lander/js/grid.js"></script>
<script src="/lander/js/main.js"></script>
<script src="/lander/js/wow.min.js"></script>
<script>wow = new WOW({}).init();</script>


<script>
    // When the document is loaded...
    $(document).ready(function()
    {
        // Scroll the whole document
        $('#sidebar-links').localScroll({
            target:'body'
        });

        // Scroll the content inside the #scroll-container div
        $('#small-box-links').localScroll({
            target:'#small-box-container'
        });

        $('#sidebar-links').localScroll();

    });
</script>

