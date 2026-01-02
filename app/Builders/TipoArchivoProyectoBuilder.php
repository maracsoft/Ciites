<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\TipoArchivoProyectoCollection;
use App\TipoArchivoProyecto;

/**
 * @method static TipoArchivoProyectoBuilder query()
 * @method static TipoArchivoProyectoBuilder where(string $column,string $operator, string $value)
 * @method static TipoArchivoProyectoBuilder where(string $column,string $value)
 * @method static TipoArchivoProyectoBuilder whereNotNull(string $column)
 * @method static TipoArchivoProyectoBuilder whereNull(string $column)
 * @method static TipoArchivoProyectoBuilder whereIn(string $column,array $array)
 * @method static TipoArchivoProyectoBuilder orderBy(string $column,array $sentido)
 * @method static TipoArchivoProyectoBuilder select(array|string $columns)
 * @method static TipoArchivoProyectoBuilder distinct()
 * @method static TipoArchivoProyectoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static TipoArchivoProyectoBuilder whereBetween(string $column, array $values)
 * @method static TipoArchivoProyectoBuilder whereNotBetween(string $column, array $values)
 * @method static TipoArchivoProyectoBuilder whereNotIn(string $column, array $values)
 * @method static TipoArchivoProyectoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static TipoArchivoProyectoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static TipoArchivoProyectoBuilder whereYear(string $column, string $operator, int $value)
 * @method static TipoArchivoProyectoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static TipoArchivoProyectoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static TipoArchivoProyectoBuilder groupBy(string ...$groups)
 * @method static TipoArchivoProyectoBuilder limit(int $value)
 * @method static int count()
 * @method static TipoArchivoProyectoCollection get(array|string $columns = ["*"])
 * @method static TipoArchivoProyecto|null first()
 */
class TipoArchivoProyectoBuilder extends Builder {}
