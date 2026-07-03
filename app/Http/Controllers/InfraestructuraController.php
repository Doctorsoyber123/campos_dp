<?php

namespace App\Http\Controllers;

use App\Services\InfraestructuraService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InfraestructuraController extends Controller
{
    public function __construct(
        private InfraestructuraService $service
    ) {
    }

    public function index(): View
    {
        return view('reginde.panel', [
            'infraestructuras' => $this->service->listar(),
        ]);
    }

    public function create(): View
    {
        return view('reginde.create', ['mode' => 'new', 'data' => []]);
    }

    public function store(Request $request): RedirectResponse
    {
        $input = $this->validado($request);

        $this->service->crear($input, $request->file('imagen_referencia'));

        return redirect()->route('reginde.panel')->with('status', 'Registro guardado correctamente.');
    }

    public function show(int $id): View
    {
        return view('reginde.create', [
            'mode' => 'ver',
            'data' => $this->service->datosParaFormulario($id),
        ]);
    }

    public function edit(int $id): View
    {
        return view('reginde.create', [
            'mode' => 'editar',
            'id' => $id,
            'data' => $this->service->datosParaFormulario($id),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $input = $this->validado($request);

        $this->service->actualizar($id, $input, $request->file('imagen_referencia'));

        return redirect()->route('reginde.panel')->with('status', 'Registro actualizado correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->service->eliminar($id);

        return redirect()->route('reginde.panel')->with('status', 'Registro eliminado.');
    }

    private function validado(Request $request): array
    {
        $request->validate([
            'denominacion' => ['required', 'string', 'max:255'],
            'aforo' => ['nullable', 'integer'],
            'imagen_referencia' => ['nullable', 'image', 'max:4096'],
        ]);

        return $request->except(['_token', '_method', 'imagen_referencia']);
    }
}
