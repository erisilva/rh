<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Motivo;
use App\Models\Pedido;
use App\Rules\Cpf;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        # vai chamar uma página index.php
        # vai ser uma listagem de formulários diferentes
        # cada rota para o create passará por GET a varivel form_type
        # e o controller irá renderizar a view correta
        // Exemplo de como poderia ser implementado
        // if (request('form_type') == 1) {
        //     return view('forms.create_1');
        // } elseif (request('form_type') == '2') {
        //     return view('forms.create_2');
        // }
        // Para o exemplo atual, vamos apenas retornar a view de criação de pedidos
        // para criar a rota na view {{ route('forms.create', ['form_type' => 1]) }}
        // esse número está relacionado a tabela motivos
        return view('forms.create', [
            'motivos' => Motivo::orderBy('descricao', 'asc')->get()
        ]);

        /*
        Formulário de Solicitação de Funcionário

            Campos Fixos (Sempre Visíveis):

            Nome Completo do Funcionário: (Campo de texto)
            CPF do Funcionário: (Campo de texto ou número)
            Tipo de Solicitação: (Caixa de seleção - dropdown) com as seguintes opções:
            Demissão
            Contratação (Observação: Geralmente, contratação é um processo interno do RH e não uma solicitação do funcionário. Talvez o solicitante tenha outro contexto em mente?)
            Férias (com um período)
            Férias (com dois períodos)
            Licença Médica (com opção de anexar atestado médico):
                Licença Médica (até 15 dias)
                Licença Médica (acima de 15 dias)
            Licença Maternidade
            Transferência
            Campos Dinâmicos (Mostrados/Ocultados dependendo da seleção em "Tipo de Solicitação"):

            Para Demissão:

            Data da Demissão: (Seletor de data)
            Motivo da Demissão (Opcional): (Área de texto)
            Para Contratação:

            Observação: Geralmente, um funcionário não solicita sua própria contratação. Se o objetivo é registrar informações de um novo funcionário, este formulário seria mais para uso interno do RH. Campos relevantes seriam:
            Nome do Novo Funcionário: (Campo de texto)
            Cargo: (Campo de texto)
            Data de Admissão: (Seletor de data)
            Departamento: (Campo de texto ou seleção)
            Para Férias (com um período):

            Data de Início das Férias: (Seletor de data)
            Data de Fim das Férias: (Seletor de data)
            Para Férias (com dois períodos):

            Primeiro Período - Data de Início: (Seletor de data)
            Primeiro Período - Data de Fim: (Seletor de data)
            Segundo Período - Data de Início: (Seletor de data)
            Segundo Período - Data de Fim: (Seletor de data)
            Para Licença Médica:

            Data de Início da Licença: (Seletor de data)
            Data de Fim da Licença (Estimada): (Seletor de data)
            Anexar Atestado Médico: (Campo para upload de arquivo)
            Para Licença Maternidade:

            Data de Início da Licença: (Seletor de data)
            Data de Fim da Licença (Estimada): (Seletor de data)
            Data do Nascimento do Bebê (Opcional): (Seletor de data)
            Para Transferência:

            Novo Departamento (Desejado): (Campo de texto ou seleção)
            Nova Função (Desejada - Opcional): (Campo de texto ou seleção)
            Data Desejada para Transferência (Opcional): (Seletor de data)
            Outros Campos:

            Observações (Opcional): (Área de texto para qualquer informação adicional)
            Data da Solicitação: (Preenchimento automático com a data atual)
        */
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        # if form_type from requet is null turn to 1
        if (!$request->has('form_type')) {
            $request->merge(['form_type' => 1]);
        }

        return view('forms.create_'. $request->input('form_type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $pedido = $request->validate([
            'nome' => 'required|max:200',
            'cpf' => ['required', 'max:15', new Cpf()],
            'cargo' => 'required|max:150',
            'setor' => 'required|max:150',
            'gestor' => 'required|max:255',
            'matricula' => 'required|max:50',
            'motivo_id' => 'required|exists:motivos,id',
            'captcha' => 'required|captcha',
            'nota' => 'required|max:750',
        ],
        [
            'captcha.required' => __('Enter the characters shown in the figure above'),
            'captcha.captcha' => __('Captcha typed incorrectly'),
        ]);

        $pedido['situacao_id'] = 1; // Default situation

        $new_pedido = Pedido::create($pedido);

        return redirect(route('forms.show', $new_pedido->id))->with('message', 'Pedido criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pedido = Pedido::findOrFail($id);

        return view('forms.show', [
            'pedido' => $pedido,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
