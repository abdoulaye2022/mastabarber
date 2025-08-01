<!--Footer Area Start-->
<?php
$services = $cn->query("SELECT * FROM services");

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
                                <li><a href="">About Us</a></li>

                                <li><a href="">Service</a></li>

                                <li><a href="">Pricing</a></li>

                                <li><a target="_blank" href="https://book.squareup.com/appointments/e6i0mgt264qz3j/location/L6JV92H4GMYP0/services">Appointment</a></li>

                                <li><a href="">Contact</a></li>

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
                                            src="<?php echo BASE_URL; ?>assets/img/coiffures/5.jpeg" alt=""></a></li>

                                <li><a href="#"
                                        onclick="showImage(event, '<?php echo BASE_URL; ?>assets/img/coiffures/6.jpeg')"><img
                                            src="<?php echo BASE_URL; ?>assets/img/coiffures/6.jpeg" alt=""></a></li>

                                <li><a href="#"
                                        onclick="showImage(event, '<?php echo BASE_URL; ?>assets/img/coiffures/7.jpeg')"><img
                                            src="<?php echo BASE_URL; ?>assets/img/coiffures/7.jpeg" alt=""></a></li>

                                <li><a href="#"
                                        onclick="showImage(event, '<?php echo BASE_URL; ?>assets/img/coiffures/4.jpeg')"><img
                                            src="<?php echo BASE_URL; ?>assets/img/coiffures/4.jpeg" alt=""></a></li>

                                <li><a href="#"
                                        onclick="showImage(event, '<?php echo BASE_URL; ?>assets/img/coiffures/8.jpeg')"><img
                                            src="<?php echo BASE_URL; ?>assets/img/coiffures/8.jpeg" alt=""></a></li>

                                <li><a href="#"
                                        onclick="showImage(event, '<?php echo BASE_URL; ?>assets/img/coiffures/9.jpeg')"><img
                                            src="<?php echo BASE_URL; ?>assets/img/coiffures/9.jpeg" alt=""></a></li>

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
                            <?php while($row = $services->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo $row['name'] . '- $ ' . $row['price']; ?></option>
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