<?php
if (!isset($_SESSION['id'])) {
    header("location: accueil");
    exit();
};

$error = "";
$success = "";
$info = "";

// add
if(isset($_POST['add'])) {
    if(isset($_POST['date'], $_POST['start_time'], $_POST['end_time'])) {
        if(!empty($_POST['date']) && !empty($_POST['start_time'])  && !empty($_POST['end_time'])) {
            $date = htmlspecialchars(trim($_POST['date']));
            $start_time = htmlspecialchars(trim($_POST['start_time']));
            $end_time = htmlspecialchars(trim($_POST['end_time']));
            $duree = 40; // Durée en minutes
            $pauses = [
                ['debut' => '16:30', 'fin' => '17:20']
            ];

            $creneaux = genererCreneauxAvecPause($start_time, $end_time, $duree, $pauses);

            // Affichage
            foreach ($creneaux as $creneau) {
                try {
                    // Vérifier si l'entrée existe déjà
                    $checkStmt = $cn->prepare("SELECT COUNT(*) FROM availabilities 
                                               WHERE date = :date AND start_time = :start_time AND end_time = :end_time");
                    $checkStmt->bindParam(':date', $date, PDO::PARAM_STR);
                    $checkStmt->bindParam(':start_time', $creneau['heure_debut'], PDO::PARAM_STR);
                    $checkStmt->bindParam(':end_time', $creneau['heure_fin'], PDO::PARAM_STR);
                    $checkStmt->execute();
            
                    // Si aucune correspondance, effectuer l'insertion
                    if ($checkStmt->fetchColumn() == 0) {
                        $stmt = $cn->prepare("INSERT INTO availabilities (date, start_time, end_time, status) 
                                              VALUES (:date, :start_time, :end_time, :status)");
                        $status = "available";
                        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                        $stmt->bindParam(':start_time', $creneau['heure_debut'], PDO::PARAM_STR);
                        $stmt->bindParam(':end_time', $creneau['heure_fin'], PDO::PARAM_STR);
                        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            
                        // Exécuter la requête d'insertion
                        $stmt->execute();
            
                        $success = "Availabilities are created successfully!";
                    } else {
                        $info = "Availability for {$date} from {$creneau['heure_debut']} to {$creneau['heure_fin']} already exists.";
                    }
                } catch (PDOException $e) {
                    $error = 'Erreur du serveur : ' . $e->getMessage();
                }
            }
            
        } else {
            $error = "All the fields ar required!";
        }
    }
}

$availabilities = $cn->query("SELECT * FROM availabilities");

include __DIR__ . '/includes/headerDm.php';
?>

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="" height="17">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-light.png" alt="" height="17">
                            </span>
                        </a>
                    </div>

                    <button type="button"
                        class="btn btn-md px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                        id="topnav-hamburger-icon">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>

                <div class="d-flex align-items-center">

                    <div class="dropdown d-md-none topbar-head-dropdown header-item">
                        <button type="button"
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                            id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="bx bx-search fs-22"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                            aria-label="Recipient's username">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="mdi mdi-magnify"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button"
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                            <i class='bx bx-moon fs-22'></i>
                        </button>
                    </div>

                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user"
                                    src="dm/assets/images/users/avatar-1.jpg" alt="Header Avatar">
                                <span class="text-start ms-xl-2">
                                    <span
                                        class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?></span>
                                    <span
                                        class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Founder</span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome <?php echo $_SESSION['firstname']; ?>!</h6>
                            <a class="dropdown-item" href="pages-profile.html"><i
                                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Profile</span></a>
                            <a class="dropdown-item" href="logout"><i
                                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle" data-key="t-logout">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <?php
    include __DIR__ . '/includes/sidebarDm.php';
    ?>


    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col">

                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">List of availabilities</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <button type="button" class="btn btn-primary add-btn btn-md" id="create-btn"
                                                data-bs-toggle="modal" data-bs-target="#addModal"><i
                                                    class="ri-add-line align-bottom me-1"></i> Add</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php if($error != "") { ?>
                                        <div class="col-lg-12">
                                            <div class="alert alert-danger alert-borderless shadow mb-xl-0"
                                                role="alert">
                                                <?php echo $error; ?>
                                            </div>
                                        </div>
                                        <?php } else if($success != "") { ?>
                                        <div class="col-lg-12" style="color: green;">
                                            <div class="alert alert-success alert-borderless shadow" role="alert">
                                                <?php echo $success; ?>
                                            </div>
                                        </div>
                                        <?php } else if($info != "") { ?>
                                        <div class="col-lg-12" style="color: yellow;">
                                            <div class="alert alert-warning alert-borderless shadow" role="alert">
                                                <?php echo $info; ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <!-- <input type="text" class="form-control search" placeholder="Search..."> -->
                                                <!-- <i class="ri-search-line search-icon"></i> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="live-preview">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Descriptions</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; while($row = $availabilities->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i; ?></th>
                                                    <td><?php echo $row['date']; ?></td>
                                                    <td><?php echo $row['start_time']; ?></td>
                                                    <td><?php echo $row['end_time']; ?></td>
                                                    <td><?php echo $row['status']; ?></td>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-md btn-warning edit-item-btn"><i
                                                                class="bx bx-show"></i></button>
                                                        <button class="btn btn-md btn-success edit-item-btn"><i
                                                                class="bx bx-edit"></i></button>
                                                        <button class="btn btn-md btn-danger remove-item-btn"><i
                                                                class="bx bx-trash"></i></button>
                                                    </td>
                                                </tr>
                                                <?php $i++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->

                    </div> <!-- end col -->
                </div>

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add user</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="availability-form">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                    <button name="add" class="btn btn-primary btn-md" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.getElementById('availability-form').addEventListener('submit', function(e) {
    const startTime = document.querySelector('input[name="start_time"]').value;
    const endTime = document.querySelector('input[name="end_time"]').value;

    if (startTime && endTime) {
        // Convertir les heures en objets Date
        const start = new Date(`1970-01-01T${startTime}:00`);
        const end = new Date(`1970-01-01T${endTime}:00`);

        // Calculer la différence en minutes
        const differenceInMinutes = (end - start) / 60000;

        // Vérifier si c'est un multiple de 45
        if (differenceInMinutes % 45 !== 0) {
            e.preventDefault(); // Empêcher la soumission
            alert("The selected time range must allow for full 40-minute slots.");
        }
    }
});
</script>
<?php
include __DIR__ . '/includes/footerDm.php';
?>