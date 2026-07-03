<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infraestructura extends Model
{
    use HasFactory;

    /**
     * Campos con columna propia (se usan para filtrar/listar en el panel).
     * Todo lo demás que llegue del formulario se guarda en `detalle`.
     */
    public const CORE_FIELDS = [
        'denominacion',
        'tipo',
        'sector',
        'direccion',
        'aforo',
        'modalidad',
        'imagen_referencia',
    ];

    protected $fillable = [
        'denominacion',
        'tipo',
        'sector',
        'direccion',
        'aforo',
        'modalidad',
        'imagen_referencia',
        'detalle',
    ];

    protected $casts = [
        'detalle' => 'array',
        'aforo' => 'integer',
    ];

    /**
     * Aplana el registro (columnas propias + detalle) al array que espera
     * el formulario Blade, con todas las claves de los ~90 campos.
     */
    public function toFormArray(): array
    {
        return array_merge($this->detalle ?? [], array_intersect_key(
            $this->only(self::CORE_FIELDS),
            array_flip(self::CORE_FIELDS)
        ));
    }

    /**
     * Separa el array plano del formulario en columnas propias + detalle JSON.
     */
    public static function splitFormArray(array $input): array
    {
        $core = array_intersect_key($input, array_flip(self::CORE_FIELDS));
        $detalle = array_diff_key($input, array_flip(self::CORE_FIELDS));

        return [$core, $detalle];
    }
}
