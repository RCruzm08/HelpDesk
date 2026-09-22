@extends('layouts.app')

@section('title', 'Editar Chamado #' . $ticket->id)

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 fw-bold text-dark mb-0">Editar Chamado #{{ $ticket->id }}</h1>
                <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Voltar
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="title" class="form-label fw-semibold">Título do Chamado <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                       value="{{ old('title', $ticket->title) }}" minlength="5" maxlength="150" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="department_id" class="form-label fw-semibold">Departamento <span class="text-danger">*</span></label>
                                <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id" required>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" @selected((string) old('department_id', $ticket->department_id) === (string) $department->id)>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">Status do Atendimento <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    @foreach (['Aberto', 'Em Atendimento', 'Concluído'] as $status)
                                        <option value="{{ $status }}" @selected(old('status', $ticket->status) === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="requester_name" class="form-label fw-semibold">Solicitante <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('requester_name') is-invalid @enderror" id="requester_name"
                                       name="requester_name" value="{{ old('requester_name', $ticket->requester_name) }}"
                                       minlength="3" maxlength="100" required>
                                @error('requester_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="priority" class="form-label fw-semibold">Prioridade <span class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                    @foreach (['Baixa', 'Média', 'Alta', 'Urgente'] as $priority)
                                        <option value="{{ $priority }}" @selected(old('priority', $ticket->priority) === $priority)>{{ $priority }}</option>
                                    @endforeach
                                </select>
                                @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Descrição <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                          rows="5" minlength="10" maxlength="2000" required>{{ old('description', $ticket->description) }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 text-end pt-3">
                                <a href="{{ route('tickets.index') }}" class="btn btn-light me-2">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-1"></i>Salvar Alterações
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
