<!--Footer Area Start-->
<?php
$services = $cn->query("SELECT * FROM services");

?>
<!-- Footer Area Start -->
<div class="footer-area">
    <div class="footer-details">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="fd-info">
                        <div class="f-logo">
                            <img src="<?php echo BASE_URL; ?>assets/img/logo.png" alt="Masta Barber Logo">
                        </div>
                        <p>95 Millennium Blvd, Moncton Suite 310, E1E 2G7</p>
                        <p>+1 (506) 899 8186</p>
                        <div class="f-social">
                            <ul>
                                <li><a target="_blank"
                                        href="https://www.facebook.com/masta.barber.2024?mibextid=kFxxJD&rdid=gFvdZECWt8ODqUXG#"
                                        aria-label="Facebook"><i class="flaticon-facebook"></i></a></li>
                                <li><a target="_blank"
                                        href="https://www.instagram.com/masta.barber?igsh=MXdrZWpkdjRuNG44Yw%3D%3D&utm_source=qr"
                                        aria-label="Instagram"><i class="flaticon-instagram"></i></a></li>
                                <li><a href="https://snapchat.com/t/0HI9FRsS" target="_blank" aria-label="Snapchat"><i class="fab fa-snapchat"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="f-link">
                        <h4>Useful Links</h4>
                        <div class="f-social">
                            <ul>
                                <li><a href="about-us">About Us</a></li>
                                <li><a href="services">Services</a></li>
                                <li><a href="pricing">Pricing</a></li>
                                <li><a target="_blank" href="https://book.squareup.com/appointments/e6i0mgt264qz3j/location/L6JV92H4GMYP0/services">Book Appointment</a></li>
                                <li><a href="contact">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="f-gallery">
                        <h4>Gallery</h4>
                        <div class="fg-img">
                            <ul>
                                <li><a href="#"
                                        onclick="showImage(event, '<?php echo BASE_URL; ?>assets/img/coiffures/5.jpeg')"><img
                                            src="<?php echo BASE_URL; ?>assets/img/coiffures/5.jpeg" alt="Haircut style gallery image 1"></a></li>
                                <li><a href="#"
                                        onclick="showImage(event, '<?php echo BASE_URL; ?>assets/img/coiffures/6.jpeg')"><img
                                            src="<?php echo BASE_URL; ?>assets/img/coiffures/6.jpeg" alt="Haircut style gallery image 2"></a></li>
                                <li><a href="#"
                                        onclick="showImage(event, '<?php echo BASE_URL; ?>assets/img/coiffures/7.jpeg')"><img
                                            src="<?php echo BASE_URL; ?>assets/img/coiffures/7.jpeg" alt="Haircut style gallery image 3"></a></li>
                                <li><a href="#"
                                        onclick="showImage(event, '<?php echo BASE_URL; ?>assets/img/coiffures/4.jpeg')"><img
                                            src="<?php echo BASE_URL; ?>assets/img/coiffures/4.jpeg" alt="Haircut style gallery image 4"></a></li>
                                <li><a href="#"
                                        onclick="showImage(event, '<?php echo BASE_URL; ?>assets/img/coiffures/8.jpeg')"><img
                                            src="<?php echo BASE_URL; ?>assets/img/coiffures/8.jpeg" alt="Haircut style gallery image 5"></a></li>
                                <li><a href="#"
                                        onclick="showImage(event, '<?php echo BASE_URL; ?>assets/img/coiffures/9.jpeg')"><img
                                            src="<?php echo BASE_URL; ?>assets/img/coiffures/9.jpeg" alt="Haircut style gallery image 6"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>Copyright © 2024 Masta Barber. All rights reserved. Created by <a href="https://m2atech.com"
                target="_blank">M2atech</a></p>
    </footer>
</div>

<!-- Image Modal -->
<div id="imageModal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 1000; justify-content: center; align-items: center;"
    onclick="closeImage()">
    <img id="modalImage" src="" alt="Gallery image preview" style="max-width: 400px; max-height: 400px;">
</div>

<!-- Booking Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Book Now</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="booked" style="padding-top: 0px;">
                <form class="row" style="padding-top: 0px;" method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="date" class="form-control" name="date" id="date" required>
                    </div>
                    <div class="form-group col-md-6">
                        <select class="form-control" id="availability" name="availability" required>
                            <option value="">Select Availability</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <select class="form-control" name="service" required>
                            <option>Select Services</option>
                            <?php while($row = $services->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo $row['name'] . ' - $' . $row['price']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12" style="display: flex; align-items: center;">
                        <input class="form-check-input" type="checkbox" value="1" name="newsletter"
                            id="flexCheckDefault" style="margin-left: 6px;">
                        &nbsp;
                        <label class="form-check-label" for="flexCheckDefault" style="margin-left: 20px;">
                            Subscribe to Newsletter
                        </label>
                    </div>

                    <button type="submit" name="book" id="submit" class="btn-1">Book Appointment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function showImage(event, src) {
    event.preventDefault(); // Prevent link opening
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = src;
    modal.style.display = 'flex'; // Show modal container
}

function closeImage() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none'; // Hide modal container
}

document.getElementById('phone').addEventListener('blur', function() {
    const phone = this.value;

    if (phone.trim() !== "") {
        // Perform AJAX request
        fetch('ajax_check_user', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `phone=${encodeURIComponent(phone)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Fill fields with returned data
                    document.getElementById('fullname').value = data.fullname;
                    document.getElementById('email').value = data.email;
                } else {
                    // Reset fields if no user found
                    document.getElementById('fullname').value = "";
                    document.getElementById('email').value = "";
                }
            })
            .catch(error => console.error('Error:', error));
    }
});

document.getElementById('date').addEventListener('change', function() {
    const selectedDate = this.value;

    if (selectedDate.trim() !== "") {
        // Perform AJAX request to get availabilities
        fetch('ajax_get_availabilities', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `date=${encodeURIComponent(selectedDate)}`
            })
            .then(response => response.json())
            .then(data => {
                const availabilityDropdown = document.getElementById('availability');
                availabilityDropdown.innerHTML =
                '<option value="">Select Availability</option>'; // Reset options

                if (data.success && data.availabilities.length > 0) {
                    // Add availabilities to dropdown
                    data.availabilities.forEach(avail => {
                        const option = document.createElement('option');
                        option.value = avail.id;
                        option.textContent = `${avail.start_time} - ${avail.end_time}`;
                        availabilityDropdown.appendChild(option);
                    });
                } else {
                    alert("No available slots for the selected date.");
                }
            })
            .catch(error => console.error('Error:', error));
    }
});
</script>

<!-- jQuery Plugin -->
<script src="<?php echo BASE_URL; ?>assets/js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
<!-- AOS JS Plugin -->
<script src="<?php echo BASE_URL; ?>assets/js/aos.js"></script>
<!-- jQuery UI JS -->
<script src="<?php echo BASE_URL; ?>assets/js/jquery-ui.js"></script>
<!-- Navigation JS -->
<script src="<?php echo BASE_URL; ?>assets/js/jquery.smartmenus.js"></script>
<!-- Owl Carousel Slider -->
<script src="<?php echo BASE_URL; ?>assets/js/owl.carousel.min.js"></script>
<!-- JS Plugins -->
<script src="<?php echo BASE_URL; ?>assets/js/jquery.fancybox.min.js"></script>
<script src='<?php echo BASE_URL; ?>assets/js/jquery.magnific-popup.min.js'></script>
<!-- Main Script -->
<script src="<?php echo BASE_URL; ?>assets/js/theme.js"></script>

</body>
</html>