<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Department;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $departmentId = $request->query('department_id');
        $status = $request->query('status');

        $tickets = Ticket::query()
            ->with('department')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('requester_name', 'like', "%{$search}%");
                });
            })
            ->when($departmentId, fn ($query) => $query->where('department_id', $departmentId))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $departments = Department::query()->orderBy('name')->get();
        $statistics = [
            'total' => Ticket::query()->count(),
            'open' => Ticket::query()->where('status', 'Aberto')->count(),
            'in_progress' => Ticket::query()->where('status', 'Em Atendimento')->count(),
            'completed' => Ticket::query()->where('status', 'Concluído')->count(),
        ];

        return view('tickets.index', compact('tickets', 'departments', 'statistics'));
    }

    public function create(): View
    {
        $departments = Department::query()->orderBy('name')->get();

        return view('tickets.create', compact('departments'));
    }

    public function store(TicketRequest $request): RedirectResponse
    {
        Ticket::query()->create($request->validated());

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Chamado aberto com sucesso!');
    }

    public function edit(Ticket $ticket): View
    {
        $departments = Department::query()->orderBy('name')->get();

        return view('tickets.edit', compact('ticket', 'departments'));
    }

    public function update(TicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $ticket->update($request->validated());

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Chamado atualizado com sucesso!');
    }

    public function toggleStatus(Ticket $ticket): RedirectResponse
    {
        $ticket->update([
            'status' => match ($ticket->status) {
                'Aberto' => 'Em Atendimento',
                'Em Atendimento' => 'Concluído',
                default => 'Aberto',
            },
        ]);

        return redirect()
            ->back()
            ->with('success', "Status do chamado #{$ticket->id} atualizado para {$ticket->status}.");
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Chamado excluído com sucesso!');
    }
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Models\Department;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
{
    $search = $request->get('search');
    $department_id = $request->get('department_id');
    $status = $request->get('status');

    $tickets = Ticket::with('department');

    if ($search) {
        $tickets->where(function ($query) use ($search) {
            $query->where('title', 'LIKE', "%$search%")
                  ->orWhere('requester_name', 'LIKE', "%$search%");
        });
    }

    if ($department_id) {
        $tickets->where('department_id', $department_id);
    }

    if ($status) {
        $tickets->where('status', $status);
    }

    $tickets = $tickets
        ->latest()
        ->paginate(6)
        ->withQueryString();

    $departments = Department::all();

    return view('tickets.index', compact('tickets', 'departments'));
}

  public function create()
{
    $departments = Department::all();

    return view('tickets.create', compact('departments'));
}

    public function store(TicketRequest $request)
{
    $dados = $request->validated();

    Ticket::create($dados);

    return redirect()
        ->route('tickets.index')
        ->with('success', 'Ticket criado com sucesso!');
}

    public function edit(Ticket $ticket){
        $departments = Department::all();
        return view ('tickets.edit', compact('ticket', 'departments'));
    }

    public function update(TicketRequest $request, Ticket $ticket){
    $dados = $request->validated();

    $ticket->update($dados);

    return redirect()
        ->route('tickets.index')
        ->with('success', 'Ticket atualizado com sucesso!');
}


    public function destroy (Ticket $ticket) {
        $ticket ->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'ticket apagado com sucesso!');
}
}
