<?php $__env->startSection('title', 'Painel de Chamados - Help Desk'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Painel de Chamados</h1>
            <p class="text-muted small mb-0">Gerencie e acompanhe as solicitações de suporte técnico.</p>
        </div>
        <a href="<?php echo e(route('tickets.create')); ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i>Novo Chamado
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="stat-icon bg-secondary-subtle text-secondary"><i class="bi bi-collection"></i></span>
                    <div><div class="text-muted small">Total</div><div class="fs-4 fw-bold"><?php echo e($statistics['total']); ?></div></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-folder2-open"></i></span>
                    <div><div class="text-muted small">Abertos</div><div class="fs-4 fw-bold"><?php echo e($statistics['open']); ?></div></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="stat-icon bg-warning-subtle text-warning-emphasis"><i class="bi bi-tools"></i></span>
                    <div><div class="text-muted small">Em atendimento</div><div class="fs-4 fw-bold"><?php echo e($statistics['in_progress']); ?></div></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="stat-icon bg-success-subtle text-success"><i class="bi bi-check2-circle"></i></span>
                    <div><div class="text-muted small">Concluídos</div><div class="fs-4 fw-bold"><?php echo e($statistics['completed']); ?></div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="<?php echo e(route('tickets.index')); ?>" method="GET" class="row g-2">
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="search" name="search" class="form-control border-start-0"
                               placeholder="Buscar por título ou solicitante..." value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-5 col-lg-3">
                    <select name="department_id" class="form-select" aria-label="Filtrar por departamento">
                        <option value="">Todos os Departamentos</option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($department->id); ?>" <?php if((string) request('department_id') === (string) $department->id): echo 'selected'; endif; ?>>
                                <?php echo e($department->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4 col-lg-3">
                    <select name="status" class="form-select" aria-label="Filtrar por status">
                        <option value="">Todos os Status</option>
                        <option value="Aberto" <?php if(request('status') === 'Aberto'): echo 'selected'; endif; ?>>Aberto</option>
                        <option value="Em Atendimento" <?php if(request('status') === 'Em Atendimento'): echo 'selected'; endif; ?>>Em Atendimento</option>
                        <option value="Concluído" <?php if(request('status') === 'Concluído'): echo 'selected'; endif; ?>>Concluído</option>
                    </select>
                </div>
                <div class="col-md-3 col-lg-2 d-flex gap-2">
                    <button type="submit" class="btn btn-secondary flex-grow-1">
                        <i class="bi bi-funnel me-1"></i>Filtrar
                    </button>
                    <a href="<?php echo e(route('tickets.index')); ?>" class="btn btn-outline-secondary" title="Limpar filtros" aria-label="Limpar filtros">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID / Título</th>
                            <th>Departamento</th>
                            <th>Solicitante</th>
                            <th>Prioridade</th>
                            <th>Status</th>
                            <th>Abertura</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-semibold text-dark">#<?php echo e($ticket->id); ?> - <?php echo e($ticket->title); ?></span>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?php echo e($ticket->department->name); ?></span></td>
                                <td><i class="bi bi-person me-1 text-muted"></i><?php echo e($ticket->requester_name); ?></td>
                                <td>
                                    <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                        'badge',
                                        'bg-danger' => $ticket->priority === 'Urgente',
                                        'bg-warning text-dark' => $ticket->priority === 'Alta',
                                        'bg-info text-dark' => $ticket->priority === 'Média',
                                        'bg-secondary' => $ticket->priority === 'Baixa',
                                    ]); ?>"><?php echo e($ticket->priority); ?></span>
                                </td>
                                <td>
                                    <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                        'badge rounded-pill',
                                        'bg-primary' => $ticket->status === 'Aberto',
                                        'bg-warning text-dark' => $ticket->status === 'Em Atendimento',
                                        'bg-success' => $ticket->status === 'Concluído',
                                    ]); ?>"><?php echo e($ticket->status); ?></span>
                                </td>
                                <td class="small text-muted text-nowrap"><?php echo e($ticket->created_at->format('d/m/Y H:i')); ?></td>
                                <td class="text-end pe-4 text-nowrap">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Ações do chamado <?php echo e($ticket->id); ?>">
                                        <form action="<?php echo e(route('tickets.status', $ticket)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="btn btn-outline-primary rounded-end-0" title="Avançar status">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </form>
                                        <a href="<?php echo e(route('tickets.edit', $ticket)); ?>" class="btn btn-outline-secondary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?php echo e(route('tickets.destroy', $ticket)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger rounded-start-0" title="Excluir"
                                                    onclick="return confirm('Tem certeza que deseja remover este chamado?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                    Nenhum chamado encontrado para os filtros selecionados.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if($tickets->hasPages()): ?>
            <div class="card-footer bg-white border-0 py-3">
                <?php echo e($tickets->onEachSide(1)->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\RES0147476\Documents\HelpDesk-main\resources\views/tickets/index.blade.php ENDPATH**/ ?>