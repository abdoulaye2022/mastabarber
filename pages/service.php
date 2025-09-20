<?php
// Services statiques
$services = [
    ['name' => 'Haircut & Styling', 'price' => 25, 'description' => 'Professional haircut and styling'],
    ['name' => 'Beard Trim', 'price' => 15, 'description' => 'Expert beard trimming and shaping'],
    ['name' => 'Hot Towel Shave', 'price' => 20, 'description' => 'Traditional hot towel shave experience'],
    ['name' => 'Hair Wash', 'price' => 10, 'description' => 'Professional hair washing and conditioning']
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

                        <h3>Haircut</h3>

                        <p>Any cut to your taste followed by a shave with straight razor, skin toner and shoulder
                            massage</p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-shaving-razor"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Shaving</h3>

                        <p>Any cut to your taste followed by a shave with straight razor, skin toner and shoulder
                            massage</p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-scissors-1"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Beard</h3>

                        <p>Any cut to your taste followed by a shave with straight razor, skin toner and shoulder
                            massage</p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-nail-scissors"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Trimming</h3>

                        <p>Any cut to your taste followed by a shave with straight razor, skin toner and shoulder
                            massage</p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-patient"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Facial</h3>

                        <p>Any cut to your taste followed by a shave with straight razor, skin toner and shoulder
                            massage</p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="single-service">

                    <div class="ss-icon">

                        <i class="flaticon-dryer"></i>
                    </div>

                    <div class="ss-text">

                        <h3>Styling</h3>

                        <p>Any cut to your taste followed by a shave with straight razor, skin toner and shoulder
                            massage</p>

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
                            <span><?php echo '$' . $row['price']; ?></span>
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