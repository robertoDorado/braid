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
        <ul class="navbar nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge"><?= empty(checkContactsOnHeader()) ? "" : count(checkContactsOnHeader()) ?></span>
                </a>
                <?php if (!empty(checkContactsOnHeader())) : ?>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <?php foreach (array_slice(checkContactsOnHeader(), 0, 3) as $contactHeader) : ?>
                            <a href="#" class="dropdown-item btnOpenChatHeader" data-csrf="<?= empty((new \Source\Core\Session())->csrf_token) ? "" : (new \Source\Core\Session())->csrf_token ?>" data-hash="<?= base64_encode($contactHeader->full_email) ?>">
                                <div class="media">
                                    <img src="<?= empty($contactHeader->path_photo) ?
                                                    theme("assets/img/user/default.png") :
                                                    theme("assets/img/user/" . $contactHeader->path_photo . "") ?>" alt="<?= empty($contactHeader->path_photo) ? "default.png" : $contactHeader->path_photo ?>" class="img-size-50 mr-3 img-circle">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            <?= $contactHeader->full_name ?>
                                            <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm"><?= $contactHeader->content ?></p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i><?= $contactHeader->date_time ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
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

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="<?= url("braid-system/my-profile") ?>" class="nav-link <?= $menuSelected == "my-profile" ? "bg-danger" : "" ?>">
                            <i class="nav-icon fas fa-user"></i>
                            Meu Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= url("/braid-system") ?>" class="nav-link <?= $menuSelected == "braid-system" ? "bg-danger" : "" ?>">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Editar Perfil
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= url("/braid-system/client-report") ?>" class="nav-link 
                        <?= $menuSelected == "client-report" ? "bg-danger" : "" ?>">
                            <i class="nav-icon fas fa-file"></i>
                            <?php if ($userType == "businessman") : ?>
                                <p>Lista de projetos</p>
                            <?php elseif ($userType == "designer") : ?>
                                <p>Projetos Disponíveis</p>
                            <?php endif ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= url("/braid-system/additional-data") ?>" class="nav-link
                        <?= $menuSelected == "additional-data" ? "bg-danger" : "" ?>">
                            <i class="nav-icon fas fa-bullseye"></i>
                            Dados Adicionais
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= url("/braid-system/chat-panel") ?>" class="nav-link
                        <?= $menuSelected == "chat-panel" ? "bg-danger" : "" ?>">
                            <i class="nav-icon fas fa-comments"></i>
                            Chat
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
                            <li class="breadcrumb-item"><a href="<?= empty($breadCrumbBefore) ? url("/braid-system/my-profile") : $breadCrumbBefore["url"] ?>"><?= empty($breadCrumbBefore) ? "Home" : $breadCrumbBefore["slug"] ?></a></li>
                            <li class="breadcrumb-item active"><?= !empty($breadCrumbTitle) ? $breadCrumbTitle : "" ?></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <?= $v->section('content') ?>
        <?php $v->insert("utils/chat-box") ?>
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