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
<section class="hero-area" id="home" style="background: white !important; background-color: white !important;">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-10 col-xl-8 mx-auto">
                <div class="hero-content">
                    <h1 data-aos="fade-up" data-aos-duration="1500" style="color: #333333 !important; text-shadow: none !important;">
                        The Beauty of Afro and Canadian Men Hair
                    </h1>
                    <p data-aos="fade-up" data-aos-duration="2000" class="lead" style="color: #666666 !important; text-shadow: none !important;">
                        Welcome
                    </p>
                    <div data-aos="fade-up" data-aos-duration="2500">
                        <a target="_blank" 
                           href="https://book.squareup.com/appointments/e6i0mgt264qz3j/location/L6JV92H4GMYP0/services" 
                           class="btn-1"
                           rel="noopener noreferrer"
                           style="color: white !important; background: #c79e56 !important;">
                            Book Appointment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Hero Area End-->

<!--About Area Start-->
<section class="about" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1500">
                <div class="about-content">
                    <h2>Mastabarber</h2>
                    <p class="ab-p lead">Your premier destination for professional hair styling</p>
                    <p>Welcome to our website dedicated to the beauty of Afro and Canadian hair!
                        We are excited to welcome you into our world where every hair type is celebrated.
                        Whether you are looking for unique designs or vibrant styles, our team is here to
                        help you express your personal style. Explore our services and let us transform
                        your hair into a work of art. Thank you for visiting us!</p>
                    <div class="mt-4">
                        <a href="#services" class="btn-1">Discover Our Services</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1500">
                <div class="about-img">
                    <div class="row">
                        <div class="col-6">
                            <div class="as-img" data-aos="fade-up" data-aos-duration="2000">
                                <img src="assets/img/coiffures/1.jpeg" alt="Professional Hair Cut Style 1" class="img-fluid rounded">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="as-img as-img2" data-aos="fade-up" data-aos-duration="2500">
                                <img src="assets/img/coiffures/2.jpeg" alt="Professional Hair Cut Style 2" class="img-fluid rounded">
                            </div>
                            <div class="as-img" data-aos="fade-up" data-aos-duration="3000">
                                <img src="assets/img/coiffures/3.jpeg" alt="Professional Hair Cut Style 3" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--About Area End-->

<!--Service Area Start-->
<section class="service" id="services">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 data-aos="fade-up" data-aos-duration="1500">What We Do</h2>
                <p class="text-center mb-5" data-aos="fade-up" data-aos-duration="2000">
                    Discover our professional hair styling services designed for every style and preference
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="single-service" data-aos="fade-up" data-aos-duration="1500">
                    <div class="ss-icon">
                        <i class="flaticon-scissors" aria-hidden="true"></i>
                    </div>
                    <div class="ss-text">
                        <h3>High Fade</h3>
                        <p>A high fade begins higher up on the sides, creating a more pronounced contrast with the
                           longer hair on top. Perfect for a modern, clean look.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="single-service" data-aos="fade-up" data-aos-duration="2000">
                    <div class="ss-icon">
                        <i class="flaticon-shaving-razor" aria-hidden="true"></i>
                    </div>
                    <div class="ss-text">
                        <h3>Mid Fade</h3>
                        <p>A mid fade haircut is a popular style for men featuring medium length hair toward the top 
                           and tapered short hair on the sides that fades out at the bottom.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="single-service" data-aos="fade-up" data-aos-duration="2500">
                    <div class="ss-icon">
                        <i class="flaticon-scissors-1" aria-hidden="true"></i>
                    </div>
                    <div class="ss-text">
                        <h3>Low Fade</h3>
                        <p>A low fade starts close to the ear, just above the ears. The fade line drops down behind the ears and around the 
                           back of the head. Subtle and professional.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="single-service" data-aos="fade-up" data-aos-duration="1500">
                    <div class="ss-icon">
                        <i class="flaticon-nail-scissors" aria-hidden="true"></i>
                    </div>
                    <div class="ss-text">
                        <h3>High Taper</h3>
                        <p>A less subtle style with a larger fade area - it begins tapering near the 
                           crown or higher up on the side. Highly customizable with different lengths.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="single-service" data-aos="fade-up" data-aos-duration="2000">
                    <div class="ss-icon">
                        <i class="flaticon-patient" aria-hidden="true"></i>
                    </div>
                    <div class="ss-text">
                        <h3>Mid Taper</h3>
                        <p>Gradually decreases in hair length from the top of the head to the neckline.
                           A classic choice for professional and casual looks.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="single-service" data-aos="fade-up" data-aos-duration="2500">
                    <div class="ss-icon">
                        <i class="flaticon-dryer" aria-hidden="true"></i>
                    </div>
                    <div class="ss-text">
                        <h3>Low Taper</h3>
                        <p>This type of taper cuts the hair length down around the lower edge of your ear.
                           Perfect for a clean, conservative appearance.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="single-service" data-aos="fade-up" data-aos-duration="1500">
                    <div class="ss-icon">
                        <i class="flaticon-scissors-1" aria-hidden="true"></i>
                    </div>
                    <div class="ss-text">
                        <h3>Level 1 Cut</h3>
                        <p>Number 1 haircut – This guard length is slightly longer than the zero, usually ⅛ of an inch.
                           Ideal for a very short, neat appearance.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="single-service" data-aos="fade-up" data-aos-duration="2000">
                    <div class="ss-icon">
                        <i class="flaticon-scissors-1" aria-hidden="true"></i>
                    </div>
                    <div class="ss-text">
                        <h3>Zero Level All Shave</h3>
                        <p>Complete head shave for the ultimate clean look. 
                           Perfect for those who prefer the bold, minimalist style.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="single-service" data-aos="fade-up" data-aos-duration="2500">
                    <div class="ss-icon">
                        <i class="flaticon-scissors-1" aria-hidden="true"></i>
                    </div>
                    <div class="ss-text">
                        <h3>Beard + Trim</h3>
                        <p>Any cut to your taste followed by a professional beard trim with straight razor, 
                           skin toner and relaxing shoulder massage.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Service Area End-->

<!--Team Section Start-->
<section class="team" id="team">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 data-aos="fade-up" data-aos-duration="1500">Licensed Barbers</h2>
                <p class="text-center mb-5" data-aos="fade-up" data-aos-duration="2000">
                    Meet our professional team of experienced barbers
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="single-t-member" data-aos="fade-up" data-aos-duration="2000">
                    <div class="t-img">
                        <img src="assets/img/coiffures/dm.jpeg" alt="Djibril Mahaman - Professional Barber">
                    </div>
                    <div class="st-text">
                        <h4>Djibril Mahaman</h4>
                        <p class="text-white mb-3">Master Barber & Founder</p>
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
</section>
<!--Team Section End-->

<!--Testimonial Start-->
<section class="testimonial" id="testimonials">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="test-img" data-aos="fade-up" data-aos-duration="1500">
                    <img src="assets/img/team/expart.png" alt="Expert Barber Badge" class="img-fluid">
                </div>
                <h2 data-aos="fade-up" data-aos-duration="2000">Client Testimonials</h2>
                <p class="text-center mb-5" data-aos="fade-up" data-aos-duration="2500">
                    What our satisfied customers say about our services
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="client owl-carousel" data-aos="fade-up" data-aos-duration="3000">
                    <div class="item">
                        <div class="single-client">
                            <p>"I just got out of Masta barber and I'm super satisfied with my cut! The team is professional 
                               and really attentive to my needs. The atmosphere is pleasant, and I felt like a king during 
                               the whole session. I highly recommend this place to anyone looking for a quality service. 
                               Thank you, Masta barber!"</p>
                            <span>James Robichaud</span>
                        </div>
                    </div>
                    
                    <div class="item">
                        <div class="single-client">
                            <p>"I recently visited Masta barber and I am delighted with the result! The cut is perfect and the 
                               team really took the time to understand what I wanted. I won't hesitate to come back!"</p>
                            <span>Maik Herry</span>
                        </div>
                    </div>

                    <div class="item">
                        <div class="single-client">
                            <p>"Masta barber has become my favorite hair salon! Every time I get out of there, I feel 
                               confident and stylish. The barbers are experts, and the atmosphere is always at the top. 
                               Thank you for your excellent service!"</p>
                            <span>Issa Hassane</span>
                        </div>
                    </div>

                    <div class="item">
                        <div class="single-client">
                            <p>"I can only recommend Masta barber! I had an incredible experience, from the consultation 
                               to the cut. The team is super friendly and really talented. I am very satisfied with 
                               my new look!"</p>
                            <span>Druba Samandeep</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Testimonial End-->

<!--Call to Action Section-->
<section class="appointment" id="contact">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="appoint-text" data-aos="fade-right" data-aos-duration="1500">
                    <h2>Ready for Your Next Cut?</h2>
                    <p>Book your appointment today and experience the Mastabarber difference. 
                       Professional styling for the modern gentleman.</p>
                </div>
            </div>
            <div class="col-lg-4 text-center" data-aos="fade-left" data-aos-duration="1500">
                <a target="_blank" 
                   href="https://book.squareup.com/appointments/e6i0mgt264qz3j/location/L6JV92H4GMYP0/services" 
                   class="btn-1"
                   rel="noopener noreferrer">
                    Book Now
                </a>
            </div>
        </div>
    </div>
</section>

<?php
include __DIR__ . '/../includes/footer.php';
?>