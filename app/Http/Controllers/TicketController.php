<?php

namespace App\Http\Controllers;
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
