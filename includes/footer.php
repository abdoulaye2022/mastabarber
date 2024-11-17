<!--Footer Area Start-->

<div class="footer-area">

    <div class="footer-details">

        <div class="container">

            <div class="row">

                <div class="col-md-4">

                    <div class="fd-info">

                        <div class="f-logo">

                            <img src="assets/img/logo.png" alt="">

                        </div>

                        <p>95 Millennium Blvd, Moncton Suite 310,  E1E 2G7</p>

                        <p>+1 720.661.2231</p>

                        <div class="f-social">
                            <ul>
                                <!-- <li><a href=""><i class="flaticon-twitter"></i></a></li> -->

                                <li><a target="_blank" href="https://www.facebook.com/masta.barber.2024?mibextid=kFxxJD&rdid=gFvdZECWt8ODqUXG#"><i class="flaticon-facebook"></i></a></li>

                                <li><a href="https://www.instagram.com/masta.barber?igsh=MXdrZWpkdjRuNG44Yw%3D%3D&utm_source=qr"><i class="flaticon-instagram"></i></a></li>

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

                                <li><a href="">Appointment</a></li>

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
                                <li><a href="#" onclick="showImage(event, 'assets/img/coiffures/5.jpeg')"><img src="assets/img/coiffures/5.jpeg" alt=""></a></li>

                                <li><a href="#" onclick="showImage(event, 'assets/img/coiffures/6.jpeg')"><img src="assets/img/coiffures/6.jpeg" alt=""></a></li>

                                <li><a href="#" onclick="showImage(event, 'assets/img/coiffures/7.jpeg')"><img src="assets/img/coiffures/7.jpeg" alt=""></a></li>

                                <li><a href="#" onclick="showImage(event, 'assets/img/coiffures/4.jpeg')"><img src="assets/img/coiffures/4.jpeg" alt=""></a></li>

                                <li><a href="#" onclick="showImage(event, 'assets/img/coiffures/8.jpeg')"><img src="assets/img/coiffures/8.jpeg" alt=""></a></li>

                                <li><a href="#" onclick="showImage(event, 'assets/img/coiffures/9.jpeg')"><img src="assets/img/coiffures/9.jpeg" alt=""></a></li>

                            </ul>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>


    <footer>
        <p>Copyright © 2024 Mastabarber Tous droits réservés. Créé par <a href="https://m2atech.com" target="_blank">M2atech</a></p>
    </footer>

</div>

<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 1000; justify-content: center; align-items: center;" onclick="closeImage()">
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
                <!--   <h4 class="modal-title">Information</h4> -->
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <!--contact Us Section-->
            <div class="booked">
                <h2>Book Now</h2>
                <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, </p>

                <form class="row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                            onfocus="this.placeholder = ''" onblur="this.placeholder ='Name'">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email"
                            onfocus="this.placeholder = ''" onblur="this.placeholder ='Email'">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone"
                            onfocus="this.placeholder = ''" onblur="this.placeholder ='Your phone'">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="date" class="form-control" name="both" id="both">
                    </div>
                    <div class="form-group col-md-6">
                        <select class="form-control">
                            <option>Select Services</option>
                            <option>Classic Cut</option>
                            <option>Buzz Cut</option>
                            <option>Deluxe Cut</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <select class="form-control">
                            <option>Choose Barbers</option>
                            <option>Alex Barber</option>
                            <option>Samim Barber</option>
                            <option>Smkit Barber</option>
                        </select>
                    </div>
                    <button type="submit" id="submit" class="btn-1">send message</button>
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

</script>

<script src="assets/js/jquery-3.4.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.min.js"></script>

<!-- Aos Js Plugin-->
<script src="assets/js/aos.js"></script>

<!-- Jquery ui JS-->
<script src="assets/js/jquery-ui.js"></script>

<!--  Nav  -->
<script src="assets/js/jquery.smartmenus.js"></script>

<!--Owl carousel Slider-->
<script src="assets/js/owl.carousel.min.js"></script>

<!--Js Plugins-->
<script src="assets/js/jquery.fancybox.min.js"></script>
<script src='assets/js/jquery.magnific-popup.min.js'></script>
<!-- Main Script -->
<script src="assets/js/theme.js"></script>



</body>

</html>