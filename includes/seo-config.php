<?php
// Configuration SEO pour chaque page
function getSEOData($page = 'home') {
    $seoData = [
        'home' => [
            'title' => 'Masta Barber - Professional Barber Shop in Moncton, NB | Men\'s Haircuts & Beard Trim',
            'description' => 'Premium barber shop in Moncton offering professional men\'s haircuts, beard trimming, hot towel shaves. Expert stylists specializing in modern and classic men\'s grooming. Book your appointment today!',
            'keywords' => 'barber shop Moncton, men\'s haircuts Moncton, beard trim, professional barber, hot towel shave, men\'s grooming, hair styling, fade haircuts, traditional shaving, barbershop New Brunswick',
            'og_image' => 'assets/img/logo.png',
            'canonical' => ''
        ],
        'services' => [
            'title' => 'Our Services - Masta Barber | Haircuts, Beard Trim, Shaving Services Moncton',
            'description' => 'Discover our professional barber services: precision haircuts, beard trimming, hot towel shaves, hair washing. Quality grooming services at competitive prices in Moncton, NB.',
            'keywords' => 'barber services, haircut services, beard trimming, hot towel shave, hair washing, men\'s styling, professional grooming, barbershop services Moncton',
            'og_image' => 'assets/img/hero/heritage.jpg',
            'canonical' => 'services'
        ],
        'about-us' => [
            'title' => 'About Masta Barber - Expert Barbers in Moncton | Our Story & Mission',
            'description' => 'Learn about Masta Barber\'s passion for men\'s grooming excellence. Our experienced team provides top-quality barbering services with traditional techniques and modern style in Moncton.',
            'keywords' => 'about Masta Barber, professional barbers, experienced team, traditional barbering, modern grooming, Moncton barbershop history',
            'og_image' => 'assets/img/team/expart.png',
            'canonical' => 'about-us'
        ],
        'contact' => [
            'title' => 'Contact Masta Barber - Book Appointment | 95 Millennium Blvd, Moncton NB',
            'description' => 'Contact Masta Barber to book your appointment. Located at 95 Millennium Blvd, Suite 310, Moncton, NB. Call (506) 899-8186 or book online for professional men\'s grooming services.',
            'keywords' => 'contact Masta Barber, book appointment, Moncton barber contact, 95 Millennium Blvd, phone (506) 899-8186, barber appointment booking',
            'og_image' => 'assets/img/logo.png',
            'canonical' => 'contact'
        ]
    ];

    return isset($seoData[$page]) ? $seoData[$page] : $seoData['home'];
}

// Obtenir la page actuelle
function getCurrentPage() {
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $pathAfterPublic = str_replace(['/mastabarber/public', '/public'], '', $requestUri);
    $pathAfterPublic = trim($pathAfterPublic, '/');

    if (empty($pathAfterPublic) || $pathAfterPublic === 'accueil' || $pathAfterPublic === 'home') {
        return 'home';
    }

    return $pathAfterPublic;
}
?>