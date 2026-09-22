<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Help Desk - Sistema de Chamados'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
        }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar-wrapper {
            position: sticky;
            top: 0;
            display: flex;
            width: var(--sidebar-width);
            height: 100vh;
            flex: 0 0 var(--sidebar-width);
            flex-direction: column;
            color: #fff;
            background: #212529;
        }

        .sidebar-heading {
            padding: 1.25rem 1.5rem;
            font-size: 1.2rem;
            font-weight: 700;
            background: #1a1d20;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        #sidebar-wrapper .list-group-item {
            display: flex;
            gap: .75rem;
            align-items: center;
            padding: .85rem 1.5rem;
            color: #adb5bd;
            background: transparent;
            border: 0;
            transition: background-color .2s, color .2s;
        }

        #sidebar-wrapper .list-group-item:hover,
        #sidebar-wrapper .list-group-item.active {
            color: #fff;
            background: #0d6efd;
        }

        #page-content-wrapper {
            min-width: 0;
            flex: 1;
        }

        .top-navbar {
            padding: .8rem 1.5rem;
            background: #fff;
            border-bottom: 1px solid #e3e6f0;
        }

        .stat-icon {
            display: grid;
            width: 46px;
            height: 46px;
            place-items: center;
            border-radius: .75rem;
            font-size: 1.25rem;
        }

        @media (max-width: 767.98px) {
            #wrapper {
                display: block;
            }

            #sidebar-wrapper {
                position: static;
                width: 100%;
                height: auto;
            }

            #sidebar-wrapper .list-group {
                flex-direction: row;
            }

            #sidebar-wrapper .list-group-item {
                justify-content: center;
                padding: .75rem;
            }

            .sidebar-footer,
            .top-navbar {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <aside id="sidebar-wrapper">
            <div class="sidebar-heading text-primary">
                <i class="bi bi-headset me-2"></i>TechAssist
            </div>

            <nav class="list-group list-group-flush mt-md-3">
                <a href="<?php echo e(route('tickets.index')); ?>"
                   class="list-group-item list-group-item-action <?php echo e(request()->routeIs('tickets.index') ? 'active' : ''); ?>">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Painel de Chamados</span>
                </a>
                <a href="<?php echo e(route('tickets.create')); ?>"
                   class="list-group-item list-group-item-action <?php echo e(request()->routeIs('tickets.create') ? 'active' : ''); ?>">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Abrir Novo Chamado</span>
                </a>
            </nav>

            <div class="sidebar-footer mt-auto p-3 text-secondary small">
                <hr class="border-secondary mb-2">
                Help Desk v2.0 &bull; SENAI
            </div>
        </aside>

        <div id="page-content-wrapper">
            <header class="top-navbar d-flex justify-content-between align-items-center">
                <span class="fw-semibold text-secondary">
                    <i class="bi bi-building me-1"></i>Sistema de Suporte por Departamento
                </span>
                <span class="badge bg-light text-dark border px-3 py-2">
                    <i class="bi bi-person-circle me-1"></i>Operador
                </span>
            </header>

            <main class="container-fluid p-3 p-lg-4">
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\RES0147476\Documents\HelpDesk-main\resources\views/layouts/app.blade.php ENDPATH**/ ?>