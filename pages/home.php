<?php
if (!isset($_COOKIE['has_visited'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt = $cn->prepare("INSERT INTO visits (ip_address) VALUES (:ip)");
    $stmt->bindParam(':ip', $ip);
    $stmt->execute();

    // Définir un cookie pour 24 heures
    setcookie('has_visited', 'true', time() + 86400); // 86400 = 24 heures
}


include '../includes/header.php';
?>

<!--Hero Area Start-->
<div class="hero-area" style="background-color: white;">

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="hero-content" style="padding-top: 150px; padding-bottom: 150px;">

                    <img src="<?php echo BASE_URL; ?>assets/img/logo.png" style="width: 200px; height: 100px; margin-bottom: 40px;" alt="">

                    <h1 data-aos="fade-up" data-aos-duration="1500" style="color: black;">The beauty of Afro and Canadian men hair</h1>

                    <p data-aos="fade-up" data-aos-duration="2000" style="color: black;">WELCOME</p>

                    <a target="_blank" href="https://book.squareup.com/appointments/e6i0mgt264qz3j/location/L6JV92H4GMYP0/services" class="btn-1">Appointment</a>

                </div>

            </div>

        </div>

    </div>

</div>

<!--Hero Area End-->

<!--About Area Start-->

<div class="about">

    <div class="container">

        <div class="row">

            <div class="col-md-6">

                <div class="about-content">

                    <h2>Mastabarber</h2>

                    <!-- <p class="ab-p"></p> -->

                    <p>Welcome to our website dedicated to the beauty of Afro and Canadian hair!
                        We are excited to welcome you into our world where every hair type is celebrated.
                        Whether you are looking for unique designs or vibrant dyes, our team is here to
                        help you express your personal style. Explore our services and let us transform
                        your hair into a work of art. Thank you for visiting us!</p>

                </div>

            </div>
            <div class="col-md-6">

                <div class="about-img">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="as-img" data-aos="fade-up" data-aos-duration="3000">

                                <img src="assets/img/coiffures/1.jpeg" alt="">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="as-img as-img2" data-aos="fade-down-left" data-aos-duration="3000">

                                <img src="assets/img/coiffures/2.jpeg" alt="">

                            </div>

                            <div class="as-img" data-aos="fade-up-left" data-aos-duration="3000">

                                <img src="assets/img/coiffures/3.jpeg" alt="">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<!--About Area End-->

<!--Service Area Start-->
<div class="service">

    <div class="container">
        <h2 data-aos="fade-up" data-aos-duration="3000">What we do</h2>
        <div class="row">

            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-scissors"></i>
                    </div>

                    <div class="ss-text">

                        <h3>High fade</h3>

                        <p>A high fade begins higher up on the sides, creating a more pronounced contrast with the
                             longer hair on top</p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-shaving-razor"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Mid fade</h3>

                        <p>A mid fade haircut is a popular style for men featuring medium length hair toward the top 
                            and tapered short hair on the sides that fades out at the bottom.</p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-scissors-1"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Low fade</h3>

                        <p>A low fade starts close to the ear, just above the ears. The fade line drops down behind the ears and around the 
                            back of the head. It keeps an inch or less of skin exposed above the natural hairline. </p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-nail-scissors"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Higth taper</h3>

                        <p>A less subtle with a larger fade area - it begins tapering near the 
                            crown or higher up on the side. Both styles: Highly customizable with different lengths 
                            and finishes to suit your preferences.</p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-patient"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Mid taper</h3>

                        <p>gradually decreases in hair length from the top of the head to the neckline.</p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-dryer"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Low taper</h3>

                        <p>This type of taper cuts the hair length down around the lower edge of your ear.</p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-scissors-1"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Level 1 cut</h3>

                        <p>Number 1 haircut – This guard length is slightly longer than the zero, usually ⅛ of an inch</p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-scissors-1"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Zero level all shave </h3>

                        <p>Blunt or Bob haircut</p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-scissors-1"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Beard +Trime </h3>

                        <p>Any cut to your taste followed by a shave with straight razor, skin toner and shoulder
                            massage</p>

                    </div>

                </div>

            </div>


        </div>

    </div>

</div>

<!--Service Area End-->

<!--Team Sectiom Start-->

<div class="team">

    <div class="container">

        <h2 data-aos="fade-up" data-aos-duration="3000">Licensed Barbers</h2>

        <div class="row">

            <div class="col-md-3">

                <div class="single-t-member" data-aos="fade-up" data-aos-duration="1500">

                    <div class="t-img">

                        <img src="assets/img/coiffures/dm.jpeg" alt="">
                    </div>

                    <div class="st-text">

                        <h4>Djibril Mahaman</h4>

                        <ul>
                            <li><a href=""><i class="flaticon-twitter"></i></a></li>

                            <li><a href=""><i class="flaticon-facebook"></i></a></li>

                            <li><a href=""><i class="flaticon-instagram"></i></a></li>

                            <li><a href=""><i class="flaticon-linkedin"></i></a></li>

                        </ul>

                    </div>

                </div>

            </div>
            <!-- <div class="col-md-3">

                <div class="single-t-member" data-aos="fade-up" data-aos-duration="2000">

                    <div class="t-img">

                        <img src="assets/img/team/team2.jpg" alt="">
                    </div>

                    <div class="st-text">

                        <h4>Max Alin</h4>

                        <ul>
                            <li><a href=""><i class="flaticon-twitter"></i></a></li>

                            <li><a href=""><i class="flaticon-facebook"></i></a></li>

                            <li><a href=""><i class="flaticon-instagram"></i></a></li>

                            <li><a href=""><i class="flaticon-linkedin"></i></a></li>

                        </ul>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="single-t-member" data-aos="fade-up" data-aos-duration="2500">

                    <div class="t-img">

                        <img src="assets/img/team/team3.jpg" alt="">
                    </div>

                    <div class="st-text">

                        <h4>Haydik Takir</h4>

                        <ul>
                            <li><a href=""><i class="flaticon-twitter"></i></a></li>

                            <li><a href=""><i class="flaticon-facebook"></i></a></li>

                            <li><a href=""><i class="flaticon-instagram"></i></a></li>

                            <li><a href=""><i class="flaticon-linkedin"></i></a></li>

                        </ul>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="single-t-member" data-aos="fade-up" data-aos-duration="3000">

                    <div class="t-img">

                        <img src="assets/img/team/team4.jpg" alt="">
                    </div>

                    <div class="st-text">

                        <h4>Brusly Dion</h4>

                        <ul>
                            <li><a href=""><i class="flaticon-twitter"></i></a></li>

                            <li><a href=""><i class="flaticon-facebook"></i></a></li>

                            <li><a href=""><i class="flaticon-instagram"></i></a></li>

                            <li><a href=""><i class="flaticon-linkedin"></i></a></li>

                        </ul>

                    </div>

                </div>

            </div> -->


        </div>

    </div>

</div>

<!--Team Sectiom End-->

<!--Video area Start-->

<!-- <div class="video">

    <a href="https://www.youtube.com/watch?v=e954hXxSwnE" class="expand-video btn-h"><i class="fa fa-play"></i></a>

</div> -->

<!--Video area End-->

<!--Testimonial Start-->

<div class="testimonial">


    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="test-img" data-aos="fade-up" data-aos-duration="2000">
                    <img src="assets/img/team/expart.png" alt="">
                </div>

                <h2 data-aos="fade-up" data-aos-duration="2500">Testimonials</h2>

                <div class="client owl-carousel">

                    <div class="item" data-aos="fade-up" data-aos-duration="3000">

                        <div class="single-client">



                            <p>I just got out of Masta barber and I'm super satisfied with my cut! The team is professional 
                                and really attentive to my needs. The atmosphere is pleasant, and I felt like a king during 
                                the whole session. I highly recommend this place to anyone looking for a quality service. 
                                Thank you, Masta barber!</p>
                            <span>JAMES ROBICHAUD</span>
                        </div>
                    </div>
                    <div class="item" data-aos="fade-up" data-aos-duration="3000">

                        <div class="single-client">



                            <p>I recently visited Masta barber and I am delighted with the result! The cut is perfect and the 
                                team really took the time to understand what I wanted. I won't hesitate to come back!</p>
                            <span>MAIK HERRY</span>

                        </div>

                    </div>

                    <div class="item" data-aos="fade-up" data-aos-duration="3000">

                        <div class="single-client">



                            <p>Masta barber has become my favorite hair salon! Every time I get out of there, I feel 
                                confident and stylish. The barbers are experts, and the atmosphere is always at the top. 
                                Thank you for your excellent service!</p>
                            <span>ISSA HASSANE</span>

                        </div>

                    </div>

                    <div class="item" data-aos="fade-up" data-aos-duration="3000">

                        <div class="single-client">



                            <p>I can only recommend Masta barber! I had an incredible experience, from the consultation 
                                to the cut. The team is super friendly and really talented. I am very satisfied with 
                                my new look!</p>
                            <span>DRUBA SAMANDEEP</span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!--Testimonial End-->

<!--Blog Area Start-->


<!-- <div class="blog">

    <div class="container">

        <h2 data-aos="fade-up" data-aos-duration="3000">Latest News</h2>

        <div class="row">

            <div class="col-md-4">

                <div class="single-blog" data-aos="fade-up" data-aos-duration="3000">

                    <div class="sb-img">

                        <img src="assets/img/blog/blog1.jpg" alt="">

                    </div>

                    <div class="sb-text">
                        <span>April 16, 2020</span>
                        <span>01 Comments</span>

                        <a href="">
                            <h3>We have best barber how to give your hair a beautiful cut. </h3>
                        </a>

                        <p>These barbers really took the time with my cut and I got a beard trim as well beard
                            trim...</p>
                        <a href="">Read More <i class="flaticon-right-1"></i></a>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="single-blog" data-aos="fade-up" data-aos-duration="3000">

                    <div class="sb-img">

                        <img src="assets/img/blog/blog2.jpg" alt="">

                    </div>

                    <div class="sb-text">
                        <span>April 16, 2020</span>
                        <span>01 Comments</span>

                        <a href="">
                            <h3>Best barbershops in new yourk city Maecenas eleifend ex </h3>
                        </a>

                        <p>Sed interdum porttitor purus, ut maximus ante luctus quis. Etiam vel vehicula nibh, in
                            malesuada...
                            .</p>
                        <a href="">Read More <i class="flaticon-right-1"></i></a>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="single-blog" data-aos="fade-up" data-aos-duration="3000">

                    <div class="sb-img">

                        <img src="assets/img/blog/blog3.jpg" alt="">

                    </div>

                    <div class="sb-text">
                        <span>April 16, 2020</span>
                        <span>01 Comments</span>

                        <a href="">
                            <h3>Beginners Guide To Hair Styling Maecenas eleifend ex</h3>
                        </a>

                        <p>Phasellus sit amet elit sem. Maecenas eleifend ex id magna pretium tincidunt...</p>
                        <a href="">Read More <i class="flaticon-right-1"></i></a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div> -->

<!--Blog Area End-->

<?php
include __DIR__ . '/../includes/footer.php';
?>