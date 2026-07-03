<?php

namespace App\Services;

use App\Models\Infraestructura;
use App\Repositories\InfraestructuraRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class InfraestructuraService
{
    public function __construct(
        private InfraestructuraRepositoryInterface $repository
    ) {
    }

    public function listar(): Collection
    {
        return $this->repository->all();
    }

    public function buscar(int $id): ?Infraestructura
    {
        return $this->repository->find($id);
    }

    /**
     * Datos listos para pintar en el formulario (Ver / Editar), con todos
     * los campos aplanados en un solo array asociativo.
     */
    public function datosParaFormulario(int $id): array
    {
        $infraestructura = $this->buscar($id);

        return $infraestructura ? $infraestructura->toFormArray() : [];
    }

    public function crear(array $input, ?UploadedFile $imagen = null): Infraestructura
    {
        [$core, $detalle] = Infraestructura::splitFormArray($input);

        if ($imagen) {
            $core['imagen_referencia'] = $this->guardarImagen($imagen);
        }

        return $this->repository->create($core, $detalle);
    }

    public function actualizar(int $id, array $input, ?UploadedFile $imagen = null): ?Infraestructura
    {
        $infraestructura = $this->buscar($id);

        if (!$infraestructura) {
            return null;
        }

        [$core, $detalle] = Infraestructura::splitFormArray($input);

        if ($imagen) {
            $this->eliminarImagen($infraestructura->imagen_referencia);
            $core['imagen_referencia'] = $this->guardarImagen($imagen);
        }

        return $this->repository->update($infraestructura, $core, $detalle);
    }

    public function eliminar(int $id): bool
    {
        $infraestructura = $this->buscar($id);

        if (!$infraestructura) {
            return false;
        }

        $this->eliminarImagen($infraestructura->imagen_referencia);

        return $this->repository->delete($infraestructura);
    }

    private function guardarImagen(UploadedFile $imagen): string
    {
        return $imagen->store('infraestructuras', 'public');
    }

    private function eliminarImagen(?string $ruta): void
    {
        if ($ruta) {
            Storage::disk('public')->delete($ruta);
        }
    }
}
