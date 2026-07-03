<?php

namespace App\Repositories;

use App\Models\Infraestructura;
use Illuminate\Support\Collection;

interface InfraestructuraRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Infraestructura;

    public function create(array $core, array $detalle): Infraestructura;

    public function update(Infraestructura $infraestructura, array $core, array $detalle): Infraestructura;

    public function delete(Infraestructura $infraestructura): bool;
}
