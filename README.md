# TechAssist Help Desk

Sistema de Help Desk desenvolvido em Laravel para abertura e gestão de chamados por departamento.

## Funcionalidades

- CRUD completo de chamados;
- departamentos e chamados relacionados em 1:N;
- busca por título ou solicitante;
- filtros por departamento e status;
- paginação de seis chamados com preservação dos filtros;
- atualização rápida de status: Aberto -> Em Atendimento -> Concluído -> Aberto;
- validação isolada com `TicketRequest` e mensagens em português;
- painel responsivo com estatísticas por status;
- banco SQLite e departamentos iniciais por seeder;
- testes automatizados do fluxo principal.

## Requisitos

- PHP 8.2 ou superior;
- Composer 2;
- extensão PHP para SQLite habilitada.

## Instalação

```bash
composer install
cp .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate --seed
php artisan serve
```

No Windows, se o comando `cp` não estiver disponível, copie manualmente `.env.example` para `.env`.

A aplicação ficará disponível, por padrão, em `http://127.0.0.1:8000`.

As telas usam Bootstrap por CDN, portanto não é necessário executar `npm install` para iniciar o sistema.

## Testes

```bash
php artisan test
```

Os testes usam SQLite em memória e verificam seeder, CRUD, validação, filtros, paginação, troca de status e exclusão em cascata.

## Rotas principais

| Método | URI | Nome |
| --- | --- | --- |
| GET | `/tickets` | `tickets.index` |
| GET | `/tickets/create` | `tickets.create` |
| POST | `/tickets` | `tickets.store` |
| GET | `/tickets/{ticket}/edit` | `tickets.edit` |
| PUT/PATCH | `/tickets/{ticket}` | `tickets.update` |
| PATCH | `/tickets/{ticket}/status` | `tickets.status` |
| DELETE | `/tickets/{ticket}` | `tickets.destroy` |
