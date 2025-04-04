<?php

namespace App\Http\Controllers;

use App\Models\Motivo;
use App\Models\Perpage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class MotivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('motivo-index');

        if (request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('motivos.index', [
            'motivos' => Motivo::orderBy('descricao', 'asc')->paginate(session('perPage', '5'))->withPath(env('APP_URL', null) . '/motivos'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('motivo-create');

        return view('motivos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('motivo-create');

        $motivo = $request->validate([
            'descricao' => 'required|max:200',
        ]);

        $new_motivo = Motivo::create($motivo);

        // LOG
        Log::create([
            'model_id' => $new_motivo->id,
            'model' => 'Motivo',
            'action' => 'store',
            'changes' => json_encode($new_motivo),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('motivos.edit', $new_motivo->id))->with('message','Motivo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Motivo $motivo)
    {
        $this->authorize('motivo-show');

        return view('motivos.show', compact('motivo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Motivo $motivo)
    {
        $this->authorize('motivo-edit');

        return view('motivos.edit', compact('motivo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Motivo $motivo)
    {
        $this->authorize('motivo-edit');

        $input = $request->validate([
            'descricao' => 'required|max:200',
        ]);

        $motivo->update($input);

        // LOG
        Log::create([
            'model_id' => $motivo->id,
            'model' => 'Motivo',
            'action' => 'update',
            'changes' => json_encode($motivo->getChanges()),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('motivos.edit', $motivo->id))->with('message','Motivo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Motivo $motivo)
    {
        $this->authorize('motivo-delete');

        $motivo->delete();

        // LOG
        Log::create([
            'model_id' => $motivo->id,
            'model' => 'Motivo',
            'action' => 'destroy',
            'changes' => json_encode($motivo),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('motivos.index'))->with('message','Motivo excluído com sucesso!');
    }

    /**
     * Export CSV
     */
    public function exportcsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $this->authorize('motivo-export');

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            ,
            'Content-type' => 'text/csv; charset=UTF-8'
            ,
            'Content-Disposition' => 'attachment; filename=Motivos_' . date("Y-m-d H:i:s") . '.csv'
            ,
            'Expires' => '0'
            ,
            'Pragma' => 'public'
        ];

        $motivos = Motivo::select('descricao')->orderBy('descricao', 'asc');

        $list = $motivos->get()->toArray();

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
        $this->authorize('motivo-export');

        return Pdf::loadView('motivos.report', [
            'dataset' => Motivo::orderBy('descricao', 'asc')->get()
        ])->download('Motivos_' . date("Y-m-d H:i:s") . '.pdf');
    }
}
