<?php
/*
Template Name: Customer Info
*/

get_header('customer');
?>

	<main id="primary" class="site-main">


	<!-- Header with a short explanation -->
	<header class="masthead">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col">
                    <h1 class="text-grey-bg">At Firewood2Go, we offer only the finest firewood and camping packages for your journeys. When you're cold, we can help.</h1>
                    </div>
                </div>
            </div>
        </header>
        <!-- "Tutorial"-->
        <section class="features-icons text-center">
            <div class="container">
                <div class="row">
                <h3>How it Works:</h3>
                    <div class="col-lg-4">
                        <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                            <div class="features-icons-icon d-flex"><i class="bi-1-square m-auto"></i></div>
                            <h3>Select your products</h3>
                            <p class="lead mb-0">Select your location from the list on our home page and select the products you want.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                            <div class="features-icons-icon d-flex"><i class="bi-2-square m-auto"></i></div>
                            <h3>Purchase your products</h3>
                            <p class="lead mb-0">We support various methods of payment.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                            <div class="features-icons-icon d-flex"><i class="bi-3-square m-auto"></i></div>
                            <h3>Pick up your products</h3>
                            <p class="lead mb-0">After purchasing a product, the locker doors containing your items will open. This might take up to 5 minutes, so please be patient.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Image and About-->
        <section class="showcase">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('https://c.pxhere.com/photos/c6/c5/camp_campfire_campsite_camping_fire_flames_landscape_sky-1380524.jpg!d')"></div>
                    <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                        <h2>Multiple Locations</h2>
                        <p class="lead mb-0">We offer our services at different locations.</p>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-lg-6 text-white showcase-img" style="background-image: url('https://img.freepik.com/free-photo/wide-angle-shot-single-tree-growing-clouded-sky-sunset-surrounded-by-grass_181624-22807.jpg?t=st=1721035427~exp=1721039027~hmac=5770a9b5d91604e56c62980e3bd28c9d71bf6f089246bd2da510c2395adbc12b&w=1800')"></div>
                    <div class="col-lg-6 my-auto showcase-text">
                        <h2>Create your own device with us?</h2>
                        <p class="lead mb-0">Contact us below if you're interested in creating your device with us!</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact Info-->
        <section class="features-icons pt-5 pb-5 text-center bg-light">
            <div class="container">
                <h2 class="mb-5">Contact Us - Beiarntek AS</h2>

                <div class="row">
                    <div class="col-md-6 col-6">
                        <div class="features-icons-item mx-auto mb-5">
                            <div class="features-icons-icon d-flex"><i class="bi-envelope m-auto"></i></div>
                            <h5>Email</h5>
                            <a href= "mailto: Beiarntek@beiarntek.com"> <p class="font-weight-light mb-0">Beiarntek@beiarntek.com</p> </a>
                        </div>
                    </div>

                    <div class="col-md-6 col-6">
                        <div class="features-icons-item mx-auto mb-5">
                            <div class="features-icons-icon d-flex"><i class="bi-telephone m-auto"></i></div>
                            <h5>Mobile</h5>
                            <a href="tel:+4748012836"><p class="font-weight-light mb-0">+47 48012836</p></a>
                        </div>
                    </div>

					<div class="col-md-6 col-6">
                        <div class="features-icons-item mx-auto mb-5">
                            <div class="features-icons-icon d-flex"><i class="bi-geo-alt m-auto"></i></div>
                            <h5>Location</h5>
                            <p class="font-weight-light mb-0">Soløveien 25 8110 Moldjord Norway</p>
                        </div>
                    </div>

					<div class="col-md-6 col-6">
                        <div class="features-icons-item mx-auto mb-5">
                            <div class="features-icons-icon d-flex"><i class="bi-building m-auto"></i></div>
                            <h5>Organization Number</h5>
                            <p class="font-weight-light mb-0">931 248 723</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


		
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
