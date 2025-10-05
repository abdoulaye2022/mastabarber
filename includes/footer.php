<!--Footer Area Start-->
<?php
// Services statiques pour le footer
$services = [
    ['name' => 'Haircut & Styling'],
    ['name' => 'Beard Trim'],
    ['name' => 'Hot Towel Shave'],
    ['name' => 'Hair Wash']
];
?>
<div class="footer-area">

    <div class="footer-details">

        <div class="container">

            <div class="row">

                <div class="col-md-4">

                    <div class="fd-info">

                        <div class="f-logo">

                            <img src="<?php echo BASE_URL; ?>assets/img/logo.png" alt="">

                        </div>

                        <p>95 Millennium Blvd, Moncton Suite 310, E1E 2G7</p>

                        <p>+1 (506) 899 8186</p>

                        <div class="f-social">
                            <ul>
                                <!-- <li><a href=""><i class="flaticon-twitter"></i></a></li> -->

                                <li><a target="_blank"
                                        href="https://www.facebook.com/masta.barber.2024?mibextid=kFxxJD&rdid=gFvdZECWt8ODqUXG#"><i
                                            class="flaticon-facebook"></i></a></li>

                                <li><a
                                        href="https://www.instagram.com/masta.barber?igsh=MXdrZWpkdjRuNG44Yw%3D%3D&utm_source=qr"><i
                                            class="flaticon-instagram"></i></a></li>

                                <li><a href="https://snapchat.com/t/0HI9FRsS"><i class="fab fa-snapchat"></i></a></li>

                            </ul>
                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="f-link">

                        <h4>Useful Link</h4>

                        <div class="f-social">
                            <ul>
                                <li><a href="about-us">About Us</a></li>

                                <li><a href="services">Service</a></li>

                                <li><a href="services">Pricing</a></li>

                                <li><a target="_blank" href="https://book.squareup.com/appointments/e6i0mgt264qz3j/location/L6JV92H4GMYP0/services">Appointment</a></li>

                                <li><a href="contact">Contact</a></li>

                                <li><a href="privacy-policy">Privacy Policy</a></li>

                                <li><a href="privacy-choices">Privacy Choices</a></li>

                            </ul>
                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="f-link">

                        <h4>Download Our App</h4>

                        <div class="f-social">
                            <ul>
                                <li>
                                    <a href="https://apps.apple.com/app/mastabarber/id6752813029" target="_blank" rel="noopener noreferrer">
                                        <i class="fab fa-apple"></i> App Store
                                    </a>
                                </li>
                                <li>
                                    <a href="https://play.google.com/store/apps/details?id=com.m2atech.mastabarber" target="_blank" rel="noopener noreferrer">
                                        <i class="fab fa-google-play"></i> Google Play <span style="font-size: 0.75em; color: #c79e56;">(Soon)</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <h4 style="margin-top: 20px;">Follow Us</h4>
                        <div class="f-social">
                            <ul style="display: flex; gap: 10px; margin-top: 10px;">
                                <li style="list-style: none;">
                                    <a target="_blank" href="https://www.facebook.com/masta.barber.2024?mibextid=kFxxJD&rdid=gFvdZECWt8ODqUXG#"
                                       style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #c79e56; border-radius: 50%; color: white; transition: all 0.3s ease;"
                                       onmouseover="this.style.background='#a67c52'" onmouseout="this.style.background='#c79e56'">
                                        <i class="flaticon-facebook"></i>
                                    </a>
                                </li>
                                <li style="list-style: none;">
                                    <a href="https://www.instagram.com/masta.barber?igsh=MXdrZWpkdjRuNG44Yw%3D%3D&utm_source=qr"
                                       style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #c79e56; border-radius: 50%; color: white; transition: all 0.3s ease;"
                                       onmouseover="this.style.background='#a67c52'" onmouseout="this.style.background='#c79e56'">
                                        <i class="flaticon-instagram"></i>
                                    </a>
                                </li>
                                <li style="list-style: none;">
                                    <a href="https://snapchat.com/t/0HI9FRsS"
                                       style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #c79e56; border-radius: 50%; color: white; transition: all 0.3s ease;"
                                       onmouseover="this.style.background='#a67c52'" onmouseout="this.style.background='#c79e56'">
                                        <i class="fab fa-snapchat"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>


    <footer>
    <p>Copyright © 2024 Mastabarber. All rights reserved. Developed by <a href="https://m2atech.com" target="_blank">M2atech</a></p>
</footer>

</div>

<div id="imageModal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 1000; justify-content: center; align-items: center;"
    onclick="closeImage()">
    <img id="modalImage" src="" alt="" style="max-width: 400px; max-height: 400px;">
    <!-- <span onclick="closeImage()" style="position: absolute; top: 10px; right: 20px; color: white; font-size: 2rem; cursor: pointer;">&times;</span> -->
</div>


<!--Footer Area End-->

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Book Now</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <!--contact Us Section-->
            <div class="booked" style="padding-top: 0px;">
                <form class="row" style="padding-top: 0px;" method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="email" id="email" placeholder="E-mail">
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
                            <?php foreach($services as $row) { ?>
                            <option value="<?php echo $row['name']; ?>">
                                <?php echo $row['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12" style="display: flex; align-items: center;">
                        <input class="form-check-input" type="checkbox" value="1" name="newsletter"
                            id="flexCheckDefault" style="margin-left: 6px;">
                        &nbsp;
                        <label class="form-check-label" for="flexCheckDefault" style="margin-left: 20px;">
                            Newsletters
                        </label>
                    </div>

                    <button type="submit" name="book" id="submit" class="btn-1">send message</button>
                </form>
            </div>

            <!--/contact Us Section-->

        </div>
    </div>
</div>


<!-- Scripts -->

<!-- jQuery Plugin -->

<script>
function showImage(event, src) {
    event.preventDefault(); // Empêche l'ouverture du lien
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = src;
    modal.style.display = 'flex'; // Affiche le conteneur modal
}

function closeImage() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none'; // Cache le conteneur modal
}
document.getElementById('phone').addEventListener('blur', function() {
    const phone = this.value;

    if (phone.trim() !== "") {
        // Effectuer la requête AJAX
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
                    // Remplir les champs avec les données retournées
                    document.getElementById('fullname').value = data.fullname;
                    document.getElementById('email').value = data.email;
                } else {
                    // Réinitialiser les champs si aucun utilisateur n'est trouvé
                    document.getElementById('fullname').value = "";
                    document.getElementById('email').value = "";
                    // alert("No user found with this phone number.");
                }
            })
            .catch(error => console.error('Error:', error));
    }
});

document.getElementById('date').addEventListener('change', function() {
    const selectedDate = this.value;

    if (selectedDate.trim() !== "") {
        // Effectuer la requête AJAX pour récupérer les disponibilités
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
                '<option value="">Select Availability</option>'; // Réinitialiser les options

                if (data.success && data.availabilities.length > 0) {
                    // Ajouter les disponibilités au dropdown
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

<script src="<?php echo BASE_URL; ?>assets/js/jquery-3.4.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>

<!-- Aos Js Plugin-->
<script src="<?php echo BASE_URL; ?>assets/js/aos.js"></script>

<!-- Jquery ui JS-->
<script src="<?php echo BASE_URL; ?>assets/js/jquery-ui.js"></script>

<!--  Nav  -->
<script src="<?php echo BASE_URL; ?>assets/js/jquery.smartmenus.js"></script>

<!--Owl carousel Slider-->
<script src="<?php echo BASE_URL; ?>assets/js/owl.carousel.min.js"></script>

<!--Js Plugins-->
<script src="<?php echo BASE_URL; ?>assets/js/jquery.fancybox.min.js"></script>
<script src='<?php echo BASE_URL; ?>assets/js/jquery.magnific-popup.min.js'></script>
<!-- Main Script -->
<script src="<?php echo BASE_URL; ?>assets/js/theme.js"></script>



</body>

</html>