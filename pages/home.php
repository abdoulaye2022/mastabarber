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

<!-- Hero Area Start -->
<div class="hero-area" style="background-color: white;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="hero-content">
                    <h1 data-aos="fade-up" data-aos-duration="1500" style="color: black;">The Beauty of Afro and Canadian Men's Hair</h1>
                    <p data-aos="fade-up" data-aos-duration="2000" style="color: black;">WELCOME</p>
                    <a target="_blank" href="https://book.squareup.com/appointments/e6i0mgt264qz3j/location/L6JV92H4GMYP0/services" class="btn-1">Book Appointment</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero Area End -->

<!-- About Area Start -->
<div class="about">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="about-content">
                    <h2>Masta Barber</h2>
                    <p>Welcome to our website dedicated to the beauty of Afro and Canadian hair!
                        We are excited to welcome you into our world where every hair type is celebrated.
                        Whether you are looking for unique designs or vibrant styles, our team is here to
                        help you express your personal style. Explore our services and let us transform
                        your hair into a work of art. Thank you for visiting us!</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="about-img">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="as-img" data-aos="fade-up" data-aos-duration="3000">
                                <img src="assets/img/coiffures/1.jpeg" alt="Professional haircut style 1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="as-img as-img2" data-aos="fade-down-left" data-aos-duration="3000">
                                <img src="assets/img/coiffures/2.jpeg" alt="Professional haircut style 2">
                            </div>
                            <div class="as-img" data-aos="fade-up-left" data-aos-duration="3000">
                                <img src="assets/img/coiffures/3.jpeg" alt="Professional haircut style 3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About Area End -->

<!-- Service Area Start -->
<div class="service">
    <div class="container">
        <h2 data-aos="fade-up" data-aos-duration="3000">What We Do</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="single-service">
                    <div class="ss-icon">
                        <i class="flaticon-scissors"></i>
                    </div>
                    <div class="ss-text">
                        <h3>High Fade</h3>
                        <p>A high fade begins higher up on the sides, creating a more pronounced contrast with the
                             longer hair on top.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="single-service">
                    <div class="ss-icon">
                        <i class="flaticon-shaving-razor"></i>
                    </div>
                    <div class="ss-text">
                        <h3>Mid Fade</h3>
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
                        <h3>Low Fade</h3>
                        <p>A low fade starts close to the ear, just above the ears. The fade line drops down behind the ears and around the 
                            back of the head. It keeps an inch or less of skin exposed above the natural hairline.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="single-service">
                    <div class="ss-icon">
                        <i class="flaticon-nail-scissors"></i>
                    </div>
                    <div class="ss-text">
                        <h3>High Taper</h3>
                        <p>A less subtle style with a larger fade area - it begins tapering near the 
                            crown or higher up on the side. Both styles are highly customizable with different lengths 
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
                        <h3>Mid Taper</h3>
                        <p>Gradually decreases in hair length from the top of the head to the neckline.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="single-service">
                    <div class="ss-icon">
                        <i class="flaticon-dryer"></i>
                    </div>
                    <div class="ss-text">
                        <h3>Low Taper</h3>
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
                        <h3>Level 1 Cut</h3>
                        <p>Number 1 haircut – This guard length is slightly longer than the zero, usually ⅛ of an inch.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="single-service">
                    <div class="ss-icon">
                        <i class="flaticon-scissors-1"></i>
                    </div>
                    <div class="ss-text">
                        <h3>Zero Level All Shave</h3>
                        <p>Complete buzz cut or skin fade haircut.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="single-service">
                    <div class="ss-icon">
                        <i class="flaticon-scissors-1"></i>
                    </div>
                    <div class="ss-text">
                        <h3>Beard + Trim</h3>
                        <p>Any cut to your taste followed by a shave with straight razor, skin toner and shoulder
                            massage.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service Area End -->

<!-- Team Section Start -->
<div class="team">
    <div class="container">
        <h2 data-aos="fade-up" data-aos-duration="3000">Licensed Barbers</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="single-t-member" data-aos="fade-up" data-aos-duration="1500">
                    <div class="t-img">
                        <img src="assets/img/coiffures/dm.jpeg" alt="Djibril Mahaman - Licensed Barber">
                    </div>
                    <div class="st-text">
                        <h4>Djibril Mahaman</h4>
                        <ul>
                            <li><a href="#" aria-label="Twitter"><i class="flaticon-twitter"></i></a></li>
                            <li><a href="#" aria-label="Facebook"><i class="flaticon-facebook"></i></a></li>
                            <li><a href="#" aria-label="Instagram"><i class="flaticon-instagram"></i></a></li>
                            <li><a href="#" aria-label="LinkedIn"><i class="flaticon-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Team Section End -->

<!-- Testimonial Start -->
<div class="testimonial">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="test-img" data-aos="fade-up" data-aos-duration="2000">
                    <img src="assets/img/team/expart.png" alt="Expert barber">
                </div>
                <h2 data-aos="fade-up" data-aos-duration="2500">Testimonials</h2>
                <div class="client owl-carousel">
                    <div class="item" data-aos="fade-up" data-aos-duration="3000">
                        <div class="single-client">
                            <p>I just got out of Masta Barber and I'm super satisfied with my cut! The team is professional 
                                and really attentive to my needs. The atmosphere is pleasant, and I felt like a king during 
                                the whole session. I highly recommend this place to anyone looking for a quality service. 
                                Thank you, Masta Barber!</p>
                            <span>JAMES ROBICHAUD</span>
                        </div>
                    </div>
                    <div class="item" data-aos="fade-up" data-aos-duration="3000">
                        <div class="single-client">
                            <p>I recently visited Masta Barber and I am delighted with the result! The cut is perfect and the 
                                team really took the time to understand what I wanted. I won't hesitate to come back!</p>
                            <span>MAIK HERRY</span>
                        </div>
                    </div>
                    <div class="item" data-aos="fade-up" data-aos-duration="3000">
                        <div class="single-client">
                            <p>Masta Barber has become my favorite hair salon! Every time I get out of there, I feel 
                                confident and stylish. The barbers are experts, and the atmosphere is always at the top. 
                                Thank you for your excellent service!</p>
                            <span>ISSA HASSANE</span>
                        </div>
                    </div>
                    <div class="item" data-aos="fade-up" data-aos-duration="3000">
                        <div class="single-client">
                            <p>I can only recommend Masta Barber! I had an incredible experience, from the consultation 
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
<!-- Testimonial End -->

<?php
include __DIR__ . '/../includes/footer.php';
?>