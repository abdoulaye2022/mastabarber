<?php
if (!isset($_SESSION['id'])) {
    header("location: accueil");
    exit();
};

include '../includes/headerDm.php';
?>



<?php
include '../includes/footerDm.php';
?>