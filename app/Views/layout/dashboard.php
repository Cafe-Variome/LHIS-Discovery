<?php
/**
    *@author Mehdi Mehtarizadeh
    *Created 05/02/2020
    *This is the dashboard layout for administrator panel.
    *It is based on SB Admin 2.
*/
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="<?php echo $keywords ?>" />
        <meta name="author" content="<?php echo $author ?>" />
        <meta name="description" content="<?php echo $description ?>" />

        <title><?= $heading ?> - <?= $title ?></title>

        <!-- Custom fonts for this template-->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(CSS . "dashboard/sbadmin/sb-admin-2.css");?>" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(VENDOR . "components/font-awesome/css/fontawesome.css"); ?>" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(VENDOR . "components/font-awesome/css/brands.css"); ?>" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(VENDOR . "components/font-awesome/css/solid.css"); ?>" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(VENDOR . "select2/select2/dist/css/select2.css");?>" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(CSS . "dashboard/dashboard.css");?>" type="text/css"/>
        <!-- extra CSS-->
        <?php foreach($css as $c):?>
        <link rel="stylesheet" href="<?php echo base_url().$c?>">
        <?php endforeach;?>

        <!-- favicon -->
        <link rel="shortcut icon" href="<?php echo base_url(IMAGES.'logos/favicon.ico');?>" />
        <script type="text/javascript">
            var baseurl = "<?php print base_url(); ?>";
            var authurl = "<?php print rtrim($setting->settingData['auth_server'],"/"); // remove trailing slash from the auth_server config variable ?>";
        </script>

        <script src="<?php echo base_url(JS."jquery-3.4.1.js");?>"></script>
    </head>

    <body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('Admin/Index') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                <img src="<?= base_url(IMAGES . "cafevariome/cafevariome_icon.png") ?>" />
                </div>
                <div class="sidebar-brand-text mx-2 text-gray-900">Café Variome<sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Admin/Index') ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Discovery
            </div>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Discover/Index') ?>">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Query Interface</span></a>
            </li>

            <!-- Heading -->
            <div class="sidebar-heading">
                Data
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSource" aria-expanded="true" aria-controls="collapseSource">
                <i class="fas fa-fw fa-database"></i>
                <span>Sources</span>
                </a>
                <div id="collapseSource" class="collapse" aria-labelledby="headingSource" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('Source/Create') ?>">Create a Source</a>
                        <a class="collapse-item" href="<?= base_url('Source/List') ?>">View Sources</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseElastic" aria-expanded="true" aria-controls="collapseElastic">
                <i class="fas fa-fw fa-search"></i>
                <span>Elastic Search</span>
                </a>
                <div id="collapseElastic" class="collapse" aria-labelledby="headingElastic" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('Elastic/Status') ?>">Status</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Network
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNet" aria-expanded="true" aria-controls="collapseNet">
                <i class="fas fa-fw fa-network-wired"></i>
                    <span>Networks</span>
                </a>
                <div id="collapseNet" class="collapse" aria-labelledby="headingNet" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('Network/Create') ?>">Create a Network</a>
                        <a class="collapse-item" href="<?= base_url('Network/Join') ?>">Join a Network</a>
                        <a class="collapse-item" href="<?= base_url('Network/List') ?>">View Networks</a>
                        <a class="collapse-item" href="<?= base_url('Network/List') ?>">View Network Requests</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNetGroup" aria-expanded="true" aria-controls="collapseNetGroup">
                <i class="fas fa-fw fa-user-friends"></i>
                    <span>Network Groups</span>
                </a>
                <div id="collapseNetGroup" class="collapse" aria-labelledby="headingNetGroup" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('NetworkGroup/Create') ?>">Create a Network Group</a>
                        <a class="collapse-item" href="<?= base_url('NetworkGroup/List') ?>">View Network Groups</a>
                    </div>
                </div>
            </li>

            <!-- Heading -->
            <div class="sidebar-heading">   
                Access Control
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser" aria-expanded="true" aria-controls="collapseUser">
                <i class="fas fa-fw fa-user"></i>
                    <span>Users</span>
                </a>
                <div id="collapseUser" class="collapse" aria-labelledby="headingUser" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('User/Create') ?>">Create a User</a>
                        <a class="collapse-item" href="<?= base_url('User/List') ?>">View Users</a>
                    </div>
                </div>
            </li>

            <!-- Heading -->
            <div class="sidebar-heading">   
                System
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSet" aria-expanded="true" aria-controls="collapseSet">
                <i class="fas fa-fw fa-user"></i>
                    <span>Settings</span>
                </a>
                <div id="collapseSet" class="collapse" aria-labelledby="headingSet" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('Admin/Settings') ?>">System Settings</a>
                    </div>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Login Screens:</h6>
                    <a class="collapse-item" href="login.html">Login</a>
                    <a class="collapse-item" href="register.html">Register</a>
                    <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Other Pages:</h6>
                    <a class="collapse-item" href="404.html">404 Page</a>
                    <a class="collapse-item active" href="blank.html">Blank Page</a>
                </div>
                </div>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $auth->getName() ?></span>
                    <img class="img-profile rounded-circle" src="<?= base_url(IMAGES. '/cafevariome/dashboard/user-icon.png') ?>" width="32" height="32">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <?php if ($auth->getAuthEngineName() === "app\libraries\keycloak"): ?>
                    <a class="dropdown-item" href="<?= $setting->settingData['key_cloak_uri'] . "/realms/". $setting->settingData['key_cloak_realm'] ."/account/" ?>">
                    <?php else : ?>
                    <a class="dropdown-item" href="<?= base_url('Auth/Edit_User/'. $auth->getUserId()) ?>">
                    <?php endif ?>
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                    </a>
                    <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                    </a>
                    <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                    </a>
                </div>
                </li>
            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <?= $this->renderSection('content') ?>
        </div>
        <!-- /.container-fluid -->

    </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Powered by Café Variome <br> Copyright &copy; <?= date("Y") . ', ' . $heading; ?> </span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

        <!-- End of Content Wrapper -->

    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url(VENDOR."twbs/bootstrap/dist/js/bootstrap.bundle.js");?>"></script>
    <script src="<?php echo base_url(VENDOR."select2/select2/dist/js/select2.js");?>"></script>

    <!-- extra Java Script-->
    <?php foreach($javascript as $js):?>
    <script src="<?php echo base_url().$js?>"></script>
    <?php endforeach;?>    

    <script type="text/javascript">
        $('[data-toggle="tooltip"]').tooltip();
    </script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url(JS."dashboard/sbadmin/sb-admin-2.min.js")?>"></script>

    </body>

</html>