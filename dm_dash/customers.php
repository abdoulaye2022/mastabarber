<?php
if (!isset($_SESSION['id'])) {
    header("location: accueil");
    exit();
};

$error = "";
$success = "";

// add
if(isset($_POST['add'])) {
    if(isset($_POST['firstname'], $_POST['lastname'], $_POST['phone'], $_POST['email'])) {
        if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['phone'])) {
            if(validatePhoneNumber($_POST['phone'])) {
                if(!empty($_POST['email']) && isValidEmail($_POST['email']) == false) {
                    $error = "The email adress is not valid!";
                } else {
                    $firstname = htmlspecialchars(trim($_POST['firstname']));
                    $lastname = htmlspecialchars(trim($_POST['lastname']));
                    $phone = htmlspecialchars(trim($_POST['phone']));
                    $email = htmlspecialchars(trim($_POST['email']));
                    if(isset( $_POST['newsletter']))
                        $newsletter = intval(htmlspecialchars(trim($_POST['newsletter'])));
                    else
                        $newsletter = 0;

                    try {
                        // Préparer la requête pour insérer les données utilisateur
                        $stmt = $cn->prepare("INSERT INTO customers (firstname, lastname, phone, email, newsletter, status) 
                                              VALUES (:firstname, :lastname, :phone, :email, :newsletter, :status)");
                        $status = 1;
                        // Lier les paramètres avec des valeurs sécurisées
                        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
                        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
                        $stmt->bindParam(':newsletter', $newsletter, PDO::PARAM_INT);
                    
                        // Exécuter la requête
                        $stmt->execute();
                    
                        $success = "User is created successfuly!";
                    } catch (PDOException $e) {
                        $error = 'Erreur du serveur : ' . $e->getMessage();
                    }
                }                    
            } else {
                $error = "The phone number is not valid!";
            }
        } else {
            $error = "All the fields ar required!";
        }
    }
}

$customers = $cn->query("SELECT * FROM customers");

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

    <!-- removeNotificationModal -->
    <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="NotificationModalbtn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete
                            It!</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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
                                <h4 class="card-title mb-0 flex-grow-1">List of customers</h4>
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
                                                    <th scope="col">Fullname</th>
                                                    <th scope="col">Phone</th>
                                                    <th scope="col">E-mail</th>
                                                    <th scope="col">Newsletters</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; while($row = $customers->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i; ?></th>
                                                    <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                                                    <td><?php echo $row['phone']; ?></td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td>
                                                        <?php 
                                                        if($row['newsletter']) { 
                                                            echo "<span class='badge bg-success'>Yes</span>"; 
                                                        } else { 
                                                            echo "<span class='badge bg-danger'>No</span>"; 
                                                        } 
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if($row['status']) { 
                                                            echo "<span class='badge bg-success'>Actif</span>"; 
                                                        } else { 
                                                            echo "<span class='badge bg-danger'>Inactif</span>"; 
                                                        } 
                                                        ?>
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
            <form action="" method="POST">
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Firstname</label>
                        <input type="text" name="firstname" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lastname</label>
                        <input type="text" name="lastname" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" value="1" name="newsletter"
                            id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Newsletters
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                        <button name="add" class="btn btn-primary btn-md" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
include __DIR__ . '/includes/footerDm.php';
?>