        <!-- ks float bag button begin -->
        <!-- <a class="bagbutton  animate__fadeInRight">
            <span class="fa-stack fa-2x">
                <i class="fas fa-circle fa-stack-2x"></i>
                <i class="fas fa-shopping-bag fa-stack-1x fa-inverse"></i>
            </span>
        </a> -->
        <!-- float bag button end -->
        <footer id="footer">
            <div class="container-fluid footer">
                <nav class="navbar navbar-expand-lg footerNavbar">
                    <button class="navbar-toggler footer-navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars fa-lg footer-fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse footer-navbar" id="navbarNavAltMarkup">
                        <div class="navbar-nav mx-auto">
                            <a class="nav-link footer-nav-link text-nowrap" href="https://www.hotelsogo.com/">Home</a>
                            <a class="nav-link footer-nav-link text-nowrap" href="https://www.hotelsogo.com/about-us">About Us</a>
                            <a class="nav-link footer-nav-link text-nowrap" href="https://www.hotelsogo.com/branches">Branches</a>
                            <a class="nav-link footer-nav-link text-nowrap" href="https://www.hotelsogo.com/promos">Promos and Discounts</a>
                            <a class="nav-link footer-nav-link text-nowrap" href="http://sogocares.ph/">Sogo Cares</a>
                            <a class="nav-link footer-nav-link text-nowrap" href="https://www.hotelsogo.com/careers">Careers</a>
                            <a class="nav-link footer-nav-link text-nowrap" href="https://www.hotelsogo.com/photos">Gallery</a>
                        </div>
                    </div>
                </nav>
                <hr style="height:1px;border-width:0;color:black;background-color:gray;">
                <div class="row">
                    <div class="social mr-auto p-2" style="margin-left:20px;">
                        <a class = "socialLink" href="#">
                            <span class="fa-stack">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-facebook fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                        <a class = "socialLink" href="#">
                            <span class="fa-stack">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                        <a class = "socialLink" href="#">
                            <span class="fa-stack">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-youtube fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                        <a class = "socialLink" href="#">
                            <span class="fa-stack">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-instagram fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                    </div>
                    <div class="copyright p-2">
                        <p>®2017-2018 Hotel Sogo. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- footer script begin -->
        <!-- ks Bootstrap Bundle with Popper begin -->
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <!-- Bootstrap Bundle with Popper end -->
        
        <script type="text/javascript" src="<?php echo base_url()."assets/js/jquery.shorten.js" ?>"></script>
        <!-- ks sidebar script begin -->

        <script>

            // ks sidebar slide
            function openNav() {
                $(".sidebar").addClass("toggled");
                $("#sidebarbtn").addClass("toggled");
            }
            function closeNav() {
                $(".sidebar").removeClass("toggled");
                $("#sidebarbtn").removeClass("toggled");
            }

            // ks bootstrap tooltip
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
            $(document).ready(function() {
	
                $(".comment").shorten();

            });
            </script>
        <!-- sidebar script end -->
        <!-- footer script end -->
    </body>
</html>
