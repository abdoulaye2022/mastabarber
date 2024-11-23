<?php
if (!isset($_SESSION['id'])) {
    header("location: accueil");
    exit();
};
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Notre template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="dm/assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="dm/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="dm/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="dm/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="dm/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="dm/assets/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<body>