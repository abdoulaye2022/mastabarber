<?php
include '../includes/header.php';
?>

<!--Hero Area Start-->
<div class="inner-hero inner-hero-2">

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="page-tittle">
                    <h2>Contact</h2>
                    <ul class="breadcam">
                        <li><a href="index.html">Home</a></li>
                        <li><i class="fas fa-angle-right"></i></li>
                        <li>Contact</li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

</div>

<!--Hero Area End-->

<!--Contact Info-->
<div class="contact-area">

    <div class="contact-info">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="single-info">
                        <i class="flaticon-placeholder"></i>
                        <h5>Address</h5>
                        <p>Materfront avenue,
                            street 2005F, USA</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="single-info">
                        <i class="flaticon-telephone"></i>
                        <h5>Phone</h5>
                        <p>+1 720.661.2231</p>
                        <p>+1 720.661.2231</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="single-info">
                        <i class="flaticon-email"></i>
                        <h5>Web</h5>
                        <p>admin@example.com</p>
                        <p>www.adminname.com</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="single-info">
                        <i class="flaticon-headset"></i>
                        <h5>Live Chat</h5>
                        <p>Dedicated support
                            Chat with me 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-details">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="cd-text">
                        <h2>Don’t Hesitate to
                            Contact us for any
                            Information.</h2>
                        <p>Whether you need a full product, consultation, tech investments or an extended team, our
                            expert will help you find the best solutions.
                        </p>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="cd-info">
                        <form class="row" id="cf" method="POST" action="assets/mail-sender/contact.php">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Your Name"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder ='Your Name'">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder ='Email'">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="subject" id="subject"
                                    placeholder="Subject" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder ='Subject'">
                            </div>
                            <div class="form-group col-md-12">
                                <textarea rows="6" class="form-control" name="msg" id="msg" placeholder="Message"
                                    onfocus="this.placeholder =''" onblur="this.placeholder ='Message'"></textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <div id="recaptcha"></div>

                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" id="submit" class="btn-1">Submit Now</button>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="cf-msg"></div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!--/Contact Info-->

<!--Google Map-->
<div class="g-map">
    <div class="map">
        <div class="" id="googleMap">

        </div>
    </div>
</div>
<!--/Google Map-->

<?php
include __DIR__ . '/../includes/footer.php';
?>