<?php

namespace App\Http\Controllers;

use App\Models\Situacao;
use App\Models\Perpage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Log;
// Removed unnecessary use directive

class SituacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('situacao-index');

        if (request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('situacaos.index', [
            'situacaos' => Situacao::orderBy('descricao', 'asc')->paginate(session('perPage', '5'))->withPath(env('APP_URL', null) . '/situacaos'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('situacao-create');

        return view('situacaos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('situacao-create');

        $situacao = $request->validate([
            'descricao' => 'required|max:200',
        ]);

        $new_situacao = Situacao::create($situacao);

        // LOG
        Log::create([
            'model_id' => $new_situacao->id,
            'model' => 'Situacao',
            'action' => 'store',
            'changes' => json_encode($new_situacao),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('situacaos.edit', $new_situacao->id))->with('message','Situação criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Situacao $situacao)
    {
        $this->authorize('situacao-show');

        return view('situacaos.show', compact('situacao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Situacao $situacao)
    {
        $this->authorize('situacao-edit');

        return view('situacaos.edit', compact('situacao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Situacao $situacao)
    {
        $this->authorize('situacao-edit');

        $input = $request->validate([
            'descricao' => 'required|max:200',
        ]);

        $situacao->update($input);

        // LOG
        Log::create([
            'model_id' => $situacao->id,
            'model' => 'Situacao',
            'action' => 'update',
            'changes' => json_encode($situacao->getChanges()),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('situacaos.edit', $situacao->id))->with('message','Situação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Situacao $situacao)
    {
        $this->authorize('situacao-delete');

        $situacao->delete();

        // LOG
        Log::create([
            'model_id' => $situacao->id,
            'model' => 'Situacao',
            'action' => 'destroy',
            'changes' => json_encode($situacao),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('situacaos.index'))->with('message','Situação excluída com sucesso!');
    }

    /**
     * Export CSV
     */
    public function exportcsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $this->authorize('situacao-export');

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            ,
            'Content-type' => 'text/csv; charset=UTF-8'
            ,
            'Content-Disposition' => 'attachment; filename=Situacoes_' . date("Y-m-d H:i:s") . '.csv'
            ,
            'Expires' => '0'
            ,
            'Pragma' => 'public'
        ];

        $situacoes = Situacao::select('descricao')->orderBy('descricao', 'asc');

        $list = $situacoes->get()->toArray();

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
        $this->authorize('situacao-export');

        return Pdf::loadView('situacaos.report', [
            'dataset' => Situacao::orderBy('descricao', 'asc')->get()
        ])->download('Situacaos_' . date("Y-m-d H:i:s") . '.pdf');
    }
}
