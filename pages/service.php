<?php
// Services statiques - Mis à jour le 12 novembre 2025
$services = [
    // Coupes hommes
    ['name' => 'Fade/Dégradé 3 niveaux (High/Low/Mid) - No Beard', 'price' => 35, 'description' => 'Inclus fade + trim no beard add / Inclus un line up sans barbe - 40 min', 'category' => 'haircut'],
    ['name' => 'Fade + Beard + Trim / Dégradé 3 niveaux + Barbe', 'price' => 40, 'description' => 'Dégradé 3 niveaux + barbe et line up - 40 min', 'category' => 'haircut'],
    ['name' => 'Taper Fade (High/Low/Mid) - No Beard', 'price' => 35, 'description' => 'Taper fade sans barbe - 30 min', 'category' => 'haircut'],
    ['name' => 'Taper Fade + Beard', 'price' => 40, 'description' => 'Taper fade (high/low/mid) avec la barbe - 35 min', 'category' => 'haircut'],
    ['name' => 'Level 1 + Beard', 'price' => 30, 'description' => '1 niveau avec la barbe - 30 min', 'category' => 'haircut'],
    ['name' => 'Hair Color + Cut or Line Up', 'price' => 'Variable', 'description' => 'Couleur pour cheveux et coiffure - 55 min', 'category' => 'haircut'],
    ['name' => 'Infant/Enfant (4 to 14 years)', 'price' => 27, 'description' => 'Coupe pour enfants de 4 à 14 ans - 30 min', 'category' => 'haircut'],
    ['name' => 'Mullet or Buzz Cut', 'price' => 35, 'description' => 'Coupe mullet ou buzz cut - 35 min', 'category' => 'haircut'],
    ['name' => 'Zero Level + Hot Towel Blade Trim', 'price' => 45, 'description' => 'Boule à zéro avec serviette chaude - 30 min', 'category' => 'haircut'],

    // Services barbe et finitions
    ['name' => 'Line Up / Traçage de Ligne', 'price' => 17, 'description' => 'Service de line up seulement - 5 min', 'category' => 'finishing'],
    ['name' => 'Eyebrows Line Up', 'price' => 5, 'description' => 'Traçage des sourcils - 5 min', 'category' => 'finishing'],
    ['name' => 'Beard Only / Barbe Seulement', 'price' => 15, 'description' => 'Service barbe uniquement - 30 min', 'category' => 'finishing'],

    // Soins
    ['name' => 'Basic Express Facial', 'price' => 27, 'description' => 'Soin du visage express basique - 20 min', 'category' => 'care'],

    // Tresses et coiffures protectrices
    ['name' => 'Knotless Braids / Tresses sans nœuds', 'price' => 100, 'description' => 'Tresses faites avec cheveux naturels à la racine, mèches ajoutées progressivement - 7 hr', 'category' => 'braids'],
    ['name' => 'Yarn Braid / Tresses de laine', 'price' => 100, 'description' => 'Tresses au fil avec laine acrylique, ajoute longueur et volume - 7 hr', 'category' => 'braids'],
    ['name' => 'BOHO Braids', 'price' => 100, 'description' => 'Tresses avec mèches bouclées libres, style bohème décontracté - 5 hr', 'category' => 'braids'],
    ['name' => 'Twist with Extension', 'price' => 100, 'description' => 'Vanilles avec extensions, coiffure protectrice (-10$ sans extension) - 5 hr', 'category' => 'braids'],
    ['name' => 'Cornrows Boys and Girls', 'price' => 60, 'description' => 'Tresses collées pour garçons et filles - 2 hr', 'category' => 'braids'],
    ['name' => 'Crochet', 'price' => 100, 'description' => 'Coiffure crochet - 5 hr', 'category' => 'braids'],
    ['name' => 'Sewin', 'price' => 100, 'description' => 'Tissage cousu - 6 hr', 'category' => 'braids'],

    // Dreads
    ['name' => 'Dreads Locks from Scratch', 'price' => 400, 'description' => 'Création de dreads (+100$ avec extensions) - 7 hr', 'category' => 'dreads'],
    ['name' => 'Retwist Dreads', 'price' => 120, 'description' => 'Retwist des dreads - 3 hr 30 min', 'category' => 'dreads'],
    ['name' => 'Styling Dreads', 'price' => 50, 'description' => 'Coiffage des dreads - 30 min', 'category' => 'dreads'],
    ['name' => 'Dreads Detox', 'price' => 150, 'description' => 'Détox des dreads - 1 hr', 'category' => 'dreads'],
    ['name' => 'Dread Washing', 'price' => 80, 'description' => 'Lavage des dreads - 40 min', 'category' => 'dreads'],
    ['name' => 'Hair Washing', 'price' => 40, 'description' => 'Lavage des cheveux - 30 min', 'category' => 'dreads'],
];

include '../includes/header.php';
?>

<!--Hero Area Start-->

<div class="inner-hero inner-hero-2">

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="page-tittle">
                    <h2>Our Services</h2>
                    <ul class="breadcam">
                        <li><a href="home">Home</a></li>
                        <li><i class="fas fa-angle-right"></i></li>
                        <li>Our Services</li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

</div>

<!--Hero Area End-->

<!--Service Area Start-->
<div class="service">

    <div class="container">
        <h2>What we do</h2>
        <div class="row">

            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-scissors"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Fade/Dégradé</h3>

                        <p>Dégradé 3 niveaux (High/Low/Mid) avec ou sans barbe. Inclus fade, trim et line up pour un look moderne et professionnel.</p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-shaving-razor"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Taper Fade</h3>

                        <p>Service de taper fade (High/Low/Mid) disponible avec ou sans barbe. Technique professionnelle pour un rendu impeccable.</p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-scissors-1"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Level 1 + Beard</h3>

                        <p>Coupe niveau 1 avec barbe incluse. Service complet de 30 minutes pour un style classique et soigné.</p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-nail-scissors"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Hair Color + Cut</h3>

                        <p>Service de couleur pour cheveux et coiffure ou line up. Prix variable selon la demande. Service complet de 55 minutes.</p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-patient"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Basic Express Facial</h3>

                        <p>Soin du visage express basique pour une peau rafraîchie. Traitement rapide et efficace en seulement 20 minutes.</p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-dryer"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Braids & Tresses</h3>

                        <p>Knotless braids, BOHO braids, Yarn braids, Cornrows, Crochet, Sewin. Coiffures protectrices professionnelles.</p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-scissors-1"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Dreads Services</h3>

                        <p>Création de dreads, retwist, styling, detox et lavage. Services complets pour l'entretien de vos locks.</p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-shaving-razor"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Services Spéciaux</h3>

                        <p>Mullet, Buzz Cut, Zero Level, coupes enfants (4-14 ans), Line Up et Eyebrows. Services adaptés à tous.</p>

                    </div>

                </div>

            </div>


        </div>

    </div>

</div>

<!--Service Area End-->

<!--Heritage Start-->

<div class="heritage heritage-2">

    <h2>We're Here For You!
    </h2>
    <a href="#myModal" data-toggle="modal" class="btn-1">MAKE AN APPOINTMENT</a>
</div>

<!--Heritage End-->

<!--Service Area Start-->
<div class="service service-2 service-4">

    <div class="container">

        <div class="row">

            <div class="col-md-6">
                <div class="service-list">

                    <h2>Plans & pricing</h2>
                    <ul>
                    <?php foreach($services as $row) { ?>
                        <li style="display: flex;">
                            <p><?php echo $row['name']; ?></p>
                            <div style="flex: 1; display: flex; justify-content: center; align-items: center">
                                <div style="border-top: 1px dashed black; width: 90%;"></div>
                            </div>
                            <span><?php echo ($row['price'] === 'Variable') ? $row['price'] : 'CA$' . $row['price']; ?></span>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">

                <div class="service-img">
                    <img src="assets/img/coiffures/service1.jpeg" style="width: 475px; heigth: 276px;" alt="">
                </div>
                <div class="service-img">
                    <img src="assets/img/coiffures/service2.jpeg" style="width: 475px; heigth: 276px;" alt="">
                </div>
            </div>

        </div>

    </div>

</div>

<!--Service Area End-->

<?php
include __DIR__ . '/../includes/footer.php';
?>