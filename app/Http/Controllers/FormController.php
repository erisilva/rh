<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Motivo;
use App\Models\Pedido;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('forms.create', [
            'motivos' => Motivo::orderBy('descricao', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('forms.create', [
            'motivos' => Motivo::orderBy('descricao', 'asc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $pedido = $request->validate([
            'nome' => 'required|max:200',
            'matricula' => 'required|max:25',
            'cargo' => 'required|max:150',
            'setor' => 'required|max:150',
            'motivo_id' => 'required|exists:motivos,id',
            'captcha' => 'required|captcha'
        ],
        [
            'captcha.required' => __('Enter the characters shown in the figure above'),
            'captcha.captcha' => __('Captcha typed incorrectly'),
        ]);

        $pedido['nota'] = $request->input('nota');
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
