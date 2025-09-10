<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\View\View;

use App\Models\Pedido;
use App\Models\Motivo;
use App\Models\Situacao;
use App\Models\Perpage;
use App\Models\Log;
use App\Rules\Cpf;

class PedidoController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('pedido-index');

        if (request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('pedidos.index', [
            'pedidos' => Pedido::orderBy('created_at', 'desc')
                            ->filter(request(['nome', 'cargo', 'setor', 'situacao_id', 'motivo_id', 'data_inicio', 'data_fim']))
                            ->paginate(session('perPage', '5'))
                            ->appends(request(['nome', 'cargo', 'setor', 'situacao_id', 'motivo_id', 'data_inicio', 'data_fim']))
                            ->withPath(env('APP_URL', null) . '/pedidos'),
            'perpages' => Perpage::orderBy('valor')->get(),
            'motivos' => Motivo::orderBy('descricao', 'asc')->get(),
            'situacaos' => Situacao::orderBy('descricao', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('pedido-create');

        return view('pedidos.create', [
            'motivos' => Motivo::orderBy('descricao', 'asc')->get(),
            'situacaos' => Situacao::orderBy('descricao', 'asc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('pedido-create');

        $pedido = $request->validate([
            'nome' => 'required|max:200',
            'cpf' => ['required', 'max:15', new Cpf()],
            'cargo' => 'required|max:150',
            'setor' => 'required|max:150',
            'motivo_id' => 'required|exists:motivos,id',
            'situacao_id' => 'required|exists:situacaos,id',
            'nota' => 'required|max:750',
        ]);

        $new_pedido = Pedido::create($pedido);

        // LOG
        Log::create([
            'model_id' => $new_pedido->id,
            'model' => 'Pedido',
            'action' => 'store',
            'changes' => json_encode($new_pedido),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('pedidos.edit', $new_pedido->id))->with('message', 'Pedido criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Pedido $pedido): View
    {
        $this->authorize('pedido-show');

        return view('pedidos.show', [
            'pedido' => $pedido,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido): View
    {
        $this->authorize('pedido-edit');

        return view('pedidos.edit', [
            'pedido' => $pedido,
            'motivos' => Motivo::orderBy('descricao', 'asc')->get(),
            'situacaos' => Situacao::orderBy('descricao', 'asc')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido): RedirectResponse
    {
        $this->authorize('pedido-edit');

        $input = $request->validate([
            'nome' => 'required|max:200',
            'cpf' => ['required', 'max:15', new Cpf()],
            'cargo' => 'required|max:150',
            'setor' => 'required|max:150',
            'motivo_id' => 'required|exists:motivos,id',
            'situacao_id' => 'required|exists:situacaos,id',
            'nota' => 'required|max:750',
        ]);

        $pedido->update($input);

        // LOG
        Log::create([
            'model_id' => $pedido->id,
            'model' => 'Pedido',
            'action' => 'update',
            'changes' => json_encode($pedido->getChanges()),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('pedidos.edit', $pedido->id))->with('message', 'Pedido atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido): RedirectResponse
    {
        $this->authorize('pedido-delete');

        // LOG
        Log::create([
            'model_id' => $pedido->id,
            'model' => 'Pedido',
            'action' => 'destroy',
            'changes' => json_encode($pedido),
            'user_id' => auth()->id(),
        ]);

        $pedido->delete();

        return redirect(route('pedidos.index'))->with('message', __('Pedido deleted successfully!'));
    }

    /**
     * Export CSV
     */
    public function exportcsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $this->authorize('pedido-export');

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            ,
            'Content-type' => 'text/csv; charset=UTF-8'
            ,
            'Content-Disposition' => 'attachment; filename=Pedidos_' . date("Y-m-d H:i:s") . '.csv'
            ,
            'Expires' => '0'
            ,
            'Pragma' => 'public'
        ];

        $pedidos = Pedido::select('nome', 'cpf', 'cargo', 'setor')
                    ->addSelect(['motivo_descricao' => Motivo::select('descricao')
                        ->whereColumn('motivos.id', 'pedidos.motivo_id')
                        ->limit(1)])
                    ->addSelect(['situacao_descricao' => Situacao::select('descricao')
                        ->whereColumn('situacaos.id', 'pedidos.situacao_id')
                        ->limit(1)])
                    ->orderBy('nome', 'asc')
                    ->filter(request(['nome', 'cargo', 'setor', 'situacao_id', 'motivo_id', 'data_inicio', 'data_fim']));

        $list = $pedidos->get()->toArray();

        # converte os objetos para uma array
        $list = json_decode(json_encode($list), true);

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            fputs($FH, chr(0xEF) . chr(0xBB) . chr(0xBF));
            foreach ($list as $row) {
                fputcsv($FH, $row, ',');
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf(): \Illuminate\Http\Response
    {
        $this->authorize('pedido-export');

        return Pdf::loadView('pedidos.report', [
            'dataset' => Pedido::orderBy('id', 'asc')
                        ->filter(request(['nome', 'cargo', 'setor', 'situacao_id', 'motivo_id', 'data_inicio', 'data_fim']))->get()
        ])->download(__('Pedidos') . '_' . date("Y-m-d H:i:s") . '.pdf');
    }
}
