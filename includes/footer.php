<!-- Footer Area Start -->
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
                            <img src="<?php echo BASE_URL; ?>assets/img/logo.png" alt="Masta Barber Logo">
                        </div>
                        <p>95 Millennium Blvd, Suite 310<br>Moncton, NB E1E 2G7</p>
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
                                <li><a href="contact">Contact</a></li>
                                <li><a target="_blank" href="https://book.squareup.com/appointments/e6i0mgt264qz3j/location/L6JV92H4GMYP0/services">Book Appointment</a></li>
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
    <img id="modalImage" src="" alt="Gallery image preview" style="max-width: 90%; max-height: 90%; border-radius: 8px;">
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
                        <select class="form-control" name="service" id="service" required>
                            <option value="">Select Services</option>
                            <?php 
                            // Reset the result pointer to fetch again
                            $services = $cn->query("SELECT * FROM services");
                            while($row = $services->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo htmlspecialchars($row['name']) . ' - $' . number_format($row['price'], 2); ?>
                                </option>
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

                    <div class="form-group col-md-12">
                        <button type="submit" name="book" id="submit" class="btn-1">Book Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Load jQuery first -->
<script src="<?php echo BASE_URL; ?>assets/js/jquery-3.4.1.min.js"></script>

<!-- JavaScript Functions -->
<script>
$(document).ready(function() {
    console.log('Footer JavaScript loaded');
    
    // Image gallery functions
    window.showImage = function(event, src) {
        event.preventDefault();
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        if (modal && modalImage) {
            modalImage.src = src;
            modal.style.display = 'flex';
        }
    };

    window.closeImage = function() {
        const modal = document.getElementById('imageModal');
        if (modal) {
            modal.style.display = 'none';
        }
    };

    // Phone lookup functionality
    $('#phone').on('blur', function() {
        const phone = $(this).val().trim();
        
        if (phone !== "") {
            $.ajax({
                url: 'ajax_check_user',
                method: 'POST',
                data: { phone: phone },
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#fullname').val(data.fullname || '');
                        $('#email').val(data.email || '');
                    } else {
                        $('#fullname').val('');
                        $('#email').val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
    });

    // Date availability functionality
    $('#date').on('change', function() {
        const selectedDate = $(this).val();
        
        if (selectedDate.trim() !== "") {
            $.ajax({
                url: 'ajax_get_availabilities',
                method: 'POST',
                data: { date: selectedDate },
                dataType: 'json',
                success: function(data) {
                    const availabilityDropdown = $('#availability');
                    availabilityDropdown.html('<option value="">Select Availability</option>');

                    if (data.success && data.availabilities && data.availabilities.length > 0) {
                        $.each(data.availabilities, function(index, avail) {
                            const option = $('<option></option>')
                                .attr('value', avail.id)
                                .text(avail.start_time + ' - ' + avail.end_time);
                            availabilityDropdown.append(option);
                        });
                    } else {
                        alert("No available slots for the selected date.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert("Error loading availabilities. Please try again.");
                }
            });
        }
    });

    // Form validation
    $('#myModal form').on('submit', function(e) {
        const requiredFields = ['phone', 'fullname', 'date', 'availability', 'service'];
        let isValid = true;
        
        requiredFields.forEach(function(field) {
            const value = $('#' + field).val();
            if (!value || value.trim() === '') {
                isValid = false;
                $('#' + field).addClass('is-invalid');
            } else {
                $('#' + field).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });

    // Reset form when modal is hidden
    $('#myModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('.is-invalid').removeClass('is-invalid');
        $('#availability').html('<option value="">Select Availability</option>');
    });
});

// Close image modal when clicking outside the image
document.addEventListener('click', function(e) {
    if (e.target.id === 'imageModal') {
        closeImage();
    }
});

// Escape key to close image modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImage();
    }
});
</script>

<!-- Load other JavaScript files -->
<script src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/aos.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/jquery.smartmenus.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/owl.carousel.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/jquery.fancybox.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/theme.js"></script>

</body>
</html>