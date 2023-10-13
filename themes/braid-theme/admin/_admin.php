<?php $v->layout("admin/_theme") ?>
<div class="wrapper" style="min-width: 100%;">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-sm-inline-block">
                <a href="#" class="nav-link" id="exit">Sair</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <div class="container-logo">
            <img src="<?= theme("assets/img/logo-2-rbg-white.png") ?>" alt="Braid Logo" class="brand-image" style="opacity: .8">
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?= empty($pathPhoto) ?
                                    theme("assets/img/user/default.png") :
                                    theme("assets/img/user/" . $pathPhoto . "") ?>" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="<?= url("/braid-system") ?>" class="d-block">Olá <?= !empty($nickName) ? $nickName : "usuário" ?></a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="#" class="nav-link <?= !empty($enpoint) && $endpoint == "/braid/braid-system" ? "active" : "" ?> bg-danger">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Meu Perfil
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?= !empty($breadCrumbTitle) ? $breadCrumbTitle : "" ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= url("/braid-system") ?>">Home</a></li>
                            <li class="breadcrumb-item active"><?= !empty($breadCrumbTitle) ? $breadCrumbTitle : "" ?></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <?= $v->section('content') ?>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- Default to the left -->
        <div style="margin-left:1rem">
            <strong>Copyright &copy; <?= date("Y") ?>
                <a href="<?= url("/braid-system") ?>">Braid.pro</a>.</strong> Todos os direitos reservados.
        </div>
    </footer>
</div>