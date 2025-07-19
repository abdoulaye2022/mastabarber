<?php
include '../includes/header.php';
?>

<!-- Hero Area Start -->
<div class="inner-hero inner-hero-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-tittle">
                    <h2>Contact</h2>
                    <ul class="breadcam">
                        <li><a href="home">Home</a></li>
                        <li><i class="fas fa-angle-right"></i></li>
                        <li>Contact</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero Area End -->

<!-- Contact Info -->
<div class="contact-area">
    <div class="contact-info">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-info">
                        <i class="flaticon-placeholder"></i>
                        <h5>Address</h5>
                        <p>95 Millennium Blvd, Suite 310<br>Moncton, NB E1E 2G7, Canada</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-info">
                        <i class="flaticon-telephone"></i>
                        <h5>Phone</h5>
                        <p>+1 (506) 899 8186</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-info">
                        <i class="flaticon-email"></i>
                        <h5>Web</h5>
                        <p>contact@mastabarber.com</p>
                        <p>www.mastabarber.com</p>
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
                        <h2>Don't Hesitate to Contact us for any Information.</h2>
                        <p>Whether you need a consultation, appointment booking, or have questions about our services, our team will help you find the best solutions for your grooming needs.</p>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="cd-info">
                        <form class="row" id="cf" method="POST" action="assets/mail-sender/contact.php">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Your Name"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder ='Your Name'" required>
                            </div>
                            <div class="form-group col-md-12">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder ='Email Address'" required>
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="subject" id="subject"
                                    placeholder="Subject" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder ='Subject'" required>
                            </div>
                            <div class="form-group col-md-12">
                                <textarea rows="6" class="form-control" name="msg" id="msg" placeholder="Message"
                                    onfocus="this.placeholder =''" onblur="this.placeholder ='Message'" required></textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <div id="recaptcha"></div>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" id="submit" class="btn-1">Send Message</button>
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
<!-- /Contact Info -->

<!-- Google Maps Section -->
<div class="map-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="map-container">
                    <h3 style="text-align: center; margin-bottom: 20px;">Find Us</h3>
                    <!-- Google Map Container -->
                    <div id="googleMap" style="width: 100%; height: 400px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); background: #f8f9fa;">
                        <div style="padding: 50px; text-align: center; color: #666;">
                            <div id="mapLoader" style="display: block;">
                                <i class="fas fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 10px;"></i>
                                <p>Loading map...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Google Map -->

<!-- Load Google Maps directly in head -->
<script>
console.log('Starting Google Maps initialization...');

// Variables globales
var mapInstance = null;
var mapInitialized = false;

// Fonction d'initialisation de la carte
function initializeGoogleMap() {
    console.log('initializeGoogleMap called');
    
    var mapElement = document.getElementById("googleMap");
    if (!mapElement) {
        console.error('Map element not found');
        return;
    }

    if (mapInitialized) {
        console.log('Map already initialized');
        return;
    }

    // Vérifier que Google Maps est chargé
    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
        console.log('Google Maps not ready, retrying in 500ms...');
        setTimeout(initializeGoogleMap, 500);
        return;
    }

    try {
        console.log('Creating Google Map...');
        
        // Coordonnées exactes pour 95 Millennium Blvd, Moncton
        var mastaBarberLocation = {
            lat: 46.0904689,
            lng: -64.8082733
        };

        // Créer la carte
        mapInstance = new google.maps.Map(mapElement, {
            center: mastaBarberLocation,
            zoom: 17,
            scrollwheel: false,
            mapTypeControl: true,
            streetViewControl: true,
            fullscreenControl: true,
            zoomControl: true
        });

        // Créer le marqueur
        var marker = new google.maps.Marker({
            position: mastaBarberLocation,
            map: mapInstance,
            title: "Masta Barber - 95 Millennium Blvd, Suite 310, Moncton",
            animation: google.maps.Animation.DROP
        });

        // Info window
        var infoWindow = new google.maps.InfoWindow({
            content: 
                '<div style="padding: 15px; font-family: Arial, sans-serif; max-width: 300px;">' +
                '<h4 style="margin: 0 0 10px 0; color: #333;">Masta Barber</h4>' +
                '<p style="margin: 0 0 10px 0; color: #666;">' +
                '<strong>Address:</strong><br>' +
                '95 Millennium Blvd, Suite 310<br>' +
                'Moncton, NB E1E 2G7, Canada' +
                '</p>' +
                '<p style="margin: 0 0 10px 0; color: #666;">' +
                '<strong>Phone:</strong> +1 (506) 899 8186' +
                '</p>' +
                '<a href="https://www.google.com/maps/dir/?api=1&destination=95+Millennium+Blvd,+Suite+310,+Moncton,+NB+E1E+2G7,+Canada" ' +
                'target="_blank" style="background: #007cba; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">Get Directions</a>' +
                '</div>'
        });

        // Event listener pour le marqueur
        marker.addListener("click", function() {
            infoWindow.open(mapInstance, marker);
        });

        // Ouvrir l'info window automatiquement
        setTimeout(function() {
            infoWindow.open(mapInstance, marker);
        }, 1000);

        mapInitialized = true;
        console.log('✅ Google Map initialized successfully!');

        // Cacher le loader
        var loader = document.getElementById('mapLoader');
        if (loader) {
            loader.style.display = 'none';
        }

    } catch (error) {
        console.error('❌ Error creating map:', error);
        showMapError();
    }
}

// Fonction d'erreur
function showMapError() {
    var mapElement = document.getElementById("googleMap");
    if (mapElement) {
        mapElement.innerHTML = 
            '<div style="padding: 20px; text-align: center; color: #666; background: #f8f9fa; border-radius: 8px;">' +
            '<h4 style="color: #dc3545;">Map Temporarily Unavailable</h4>' +
            '<p>We\'re working to resolve this issue.</p>' +
            '<div style="margin: 15px 0; padding: 15px; background: white; border-radius: 4px;">' +
            '<strong>Visit us at:</strong><br>' +
            '95 Millennium Blvd, Suite 310<br>' +
            'Moncton, NB E1E 2G7, Canada<br>' +
            '<strong>Phone:</strong> +1 (506) 899 8186' +
            '</div>' +
            '<a href="https://www.google.com/maps/dir/?api=1&destination=95+Millennium+Blvd,+Suite+310,+Moncton,+NB+E1E+2G7,+Canada" ' +
            'target="_blank" style="background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Get Directions on Google Maps</a>' +
            '</div>';
    }
}

// Callback global pour Google Maps
window.initMap = function() {
    console.log('🗺️ Google Maps callback triggered');
    initializeGoogleMap();
};

// Gestion des erreurs d'authentification
window.gm_authFailure = function() {
    console.error('❌ Google Maps authentication failed');
    showMapError();
};

// Charger l'API Google Maps
function loadGoogleMapsScript() {
    console.log('📡 Loading Google Maps API...');
    
    // Vérifier si déjà chargé
    if (window.google && window.google.maps) {
        console.log('Google Maps already loaded');
        initializeGoogleMap();
        return;
    }

    var script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCx3hzJXv9dG54w69-OkTgoP2kJne7xs8M&callback=initMap';
    script.async = true;
    script.defer = true;
    
    script.onload = function() {
        console.log('📡 Google Maps script loaded successfully');
    };
    
    script.onerror = function() {
        console.error('❌ Failed to load Google Maps script');
        showMapError();
    };
    
    document.head.appendChild(script);
}

// Initialisation au chargement du DOM
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 DOM loaded, initializing map...');
    
    var mapElement = document.getElementById("googleMap");
    if (mapElement) {
        console.log('✅ Map element found');
        
        // Délai pour s'assurer que tout est prêt
        setTimeout(function() {
            loadGoogleMapsScript();
        }, 500);
        
        // Fallback : réessayer après 3 secondes si pas initialisé
        setTimeout(function() {
            if (!mapInitialized) {
                console.log('🔄 Map not initialized, retrying...');
                initializeGoogleMap();
            }
        }, 3000);
        
    } else {
        console.log('❌ Map element not found on this page');
    }
});

// Fallback : réessayer au chargement de la fenêtre
window.addEventListener('load', function() {
    if (!mapInitialized) {
        console.log('🔄 Window loaded, trying to initialize map...');
        setTimeout(initializeGoogleMap, 1000);
    }
});
</script>

<?php
include __DIR__ . '/../includes/footer.php';
?>