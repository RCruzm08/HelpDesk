<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_department_seeder_populates_the_default_departments(): void
    {
        $this->artisan('db:seed')->assertSuccessful();

        $this->assertDatabaseCount('departments', 4);
        $this->assertDatabaseHas('departments', ['code' => 'TI', 'name' => 'TI / Suporte']);
    }

    public function test_complete_ticket_crud_and_status_flow(): void
    {
        $department = Department::query()->create([
            'name' => 'TI / Suporte',
            'code' => 'TI',
        ]);

        $payload = [
            'department_id' => $department->id,
            'title' => 'Falha no acesso à rede',
            'requester_name' => 'Ricardo Cruz',
            'priority' => 'Alta',
            'description' => 'O computador não consegue acessar a rede corporativa.',
        ];

        $this->get(route('tickets.index'))->assertOk();
        $this->get(route('tickets.create'))->assertOk()->assertSee('Abrir Novo Chamado');

        $this->post(route('tickets.store'), $payload)
            ->assertRedirect(route('tickets.index'))
            ->assertSessionHas('success');

        $ticket = Ticket::query()->firstOrFail();
        $this->assertSame('Aberto', $ticket->status);

        $this->get(route('tickets.edit', $ticket))
            ->assertOk()
            ->assertSee('Falha no acesso à rede');

        $this->put(route('tickets.update', $ticket), [
            ...$payload,
            'title' => 'Falha resolvida no acesso à rede',
            'status' => 'Concluído',
        ])->assertRedirect(route('tickets.index'));

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'title' => 'Falha resolvida no acesso à rede',
            'status' => 'Concluído',
        ]);

        $this->patch(route('tickets.status', $ticket))
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('tickets', ['id' => $ticket->id, 'status' => 'Aberto']);

        $this->delete(route('tickets.destroy', $ticket))
            ->assertRedirect(route('tickets.index'));

        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }

    public function test_ticket_form_request_rejects_invalid_data(): void
    {
        $this->post(route('tickets.store'), [
            'title' => 'abc',
            'department_id' => 999,
            'requester_name' => 'A',
            'priority' => 'Crítica',
            'description' => 'curta',
        ])->assertSessionHasErrors([
            'title',
            'department_id',
            'requester_name',
            'priority',
            'description',
        ]);
    }

    public function test_filters_and_pagination_are_applied_together(): void
    {
        $it = Department::query()->create(['name' => 'TI / Suporte', 'code' => 'TI']);
        $hr = Department::query()->create(['name' => 'Recursos Humanos', 'code' => 'RH']);

        foreach (range(1, 7) as $number) {
            Ticket::query()->create([
                'department_id' => $it->id,
                'title' => "Problema de rede {$number}",
                'requester_name' => "Solicitante {$number}",
                'priority' => 'Média',
                'description' => 'Descrição válida para o problema de conectividade.',
                'status' => 'Aberto',
            ]);
        }

        Ticket::query()->create([
            'department_id' => $hr->id,
            'title' => 'Dúvida sobre folha de pagamento',
            'requester_name' => 'Outro Solicitante',
            'priority' => 'Baixa',
            'description' => 'Descrição válida para a solicitação administrativa.',
            'status' => 'Concluído',
        ]);

        $response = $this->get(route('tickets.index', [
            'search' => 'rede',
            'department_id' => $it->id,
            'status' => 'Aberto',
        ]));

        $response->assertOk()
            ->assertDontSee('Dúvida sobre folha de pagamento');

        $tickets = $response->viewData('tickets');
        $this->assertSame(7, $tickets->total());
        $this->assertSame(6, $tickets->perPage());
        $this->assertStringContainsString('search=rede', $tickets->url(2));
        $this->assertStringContainsString('department_id='.$it->id, $tickets->url(2));
        $this->assertStringContainsString('status=Aberto', $tickets->url(2));
    }

    public function test_deleting_a_department_cascades_its_tickets(): void
    {
        $department = Department::query()->create(['name' => 'Infraestrutura', 'code' => 'INFRA']);
        $ticket = Ticket::query()->create([
            'department_id' => $department->id,
            'title' => 'Troca de lâmpada da sala',
            'requester_name' => 'Maria Silva',
            'priority' => 'Baixa',
            'description' => 'A lâmpada da sala principal está queimada.',
        ]);

        $department->delete();

        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }
}
