<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:150'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'requester_name' => ['required', 'string', 'min:3', 'max:100'],
            'priority' => ['required', Rule::in(['Baixa', 'Média', 'Alta', 'Urgente'])],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'status' => [
                $this->isMethod('post') ? 'sometimes' : 'required',
                Rule::in(['Aberto', 'Em Atendimento', 'Concluído']),
            ],
        ];
    }

    /**
     * Mensagens de validação exibidas nos formulários.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Informe o título do chamado.',
            'title.min' => 'O título deve ter pelo menos 5 caracteres.',
            'title.max' => 'O título não pode ter mais de 150 caracteres.',
            'department_id.required' => 'Selecione um departamento.',
            'department_id.exists' => 'O departamento selecionado não existe.',
            'requester_name.required' => 'Informe o nome do solicitante.',
            'requester_name.min' => 'O nome do solicitante deve ter pelo menos 3 caracteres.',
            'requester_name.max' => 'O nome do solicitante não pode ter mais de 100 caracteres.',
            'priority.required' => 'Selecione a prioridade do chamado.',
            'priority.in' => 'A prioridade selecionada é inválida.',
            'description.required' => 'Descreva o problema encontrado.',
            'description.min' => 'A descrição deve ter pelo menos 10 caracteres.',
            'description.max' => 'A descrição não pode ter mais de 2000 caracteres.',
            'status.required' => 'Selecione o status do chamado.',
            'status.in' => 'O status selecionado é inválido.',
        ];
    }
}
