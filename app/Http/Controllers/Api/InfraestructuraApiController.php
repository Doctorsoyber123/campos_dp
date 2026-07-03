<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\InfraestructuraService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InfraestructuraApiController extends Controller
{
    public function __construct(
        private InfraestructuraService $service
    ) {
    }

    public function index(): JsonResponse
    {
        $infraestructuras = $this->service->listar()->map(
            fn ($i) => $i->toFormArray() + ['id' => $i->id]
        );

        return response()->json($infraestructuras);
    }

    public function show(int $id): JsonResponse
    {
        $infraestructura = $this->service->buscar($id);

        if (!$infraestructura) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        return response()->json($infraestructura->toFormArray() + ['id' => $infraestructura->id]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'denominacion' => ['required', 'string', 'max:255'],
            'aforo' => ['nullable', 'integer'],
            'imagen_referencia' => ['nullable', 'image', 'max:4096'],
        ]);

        $input = $request->except(['imagen_referencia']);
        $infraestructura = $this->service->crear($input, $request->file('imagen_referencia'));

        return response()->json($infraestructura->toFormArray() + ['id' => $infraestructura->id], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'denominacion' => ['required', 'string', 'max:255'],
            'aforo' => ['nullable', 'integer'],
            'imagen_referencia' => ['nullable', 'image', 'max:4096'],
        ]);

        $input = $request->except(['imagen_referencia']);
        $infraestructura = $this->service->actualizar($id, $input, $request->file('imagen_referencia'));

        if (!$infraestructura) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        return response()->json($infraestructura->toFormArray() + ['id' => $infraestructura->id]);
    }

    public function destroy(int $id): JsonResponse
    {
        $eliminado = $this->service->eliminar($id);

        if (!$eliminado) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        return response()->json(['message' => 'Registro eliminado correctamente']);
    }
}
