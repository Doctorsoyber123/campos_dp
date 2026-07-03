<?php

namespace App\Repositories;

use App\Models\Infraestructura;
use Illuminate\Support\Collection;

class EloquentInfraestructuraRepository implements InfraestructuraRepositoryInterface
{
    public function all(): Collection
    {
        return Infraestructura::orderBy('denominacion')->get();
    }

    public function find(int $id): ?Infraestructura
    {
        return Infraestructura::find($id);
    }

    public function create(array $core, array $detalle): Infraestructura
    {
        return Infraestructura::create(array_merge($core, ['detalle' => $detalle]));
    }

    public function update(Infraestructura $infraestructura, array $core, array $detalle): Infraestructura
    {
        $infraestructura->update(array_merge($core, [
            'detalle' => array_merge($infraestructura->detalle ?? [], $detalle),
        ]));

        return $infraestructura;
    }

    public function delete(Infraestructura $infraestructura): bool
    {
        return (bool) $infraestructura->delete();
    }
}
