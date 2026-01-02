<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\EstadoSolicitudFondosCollection;
use App\EstadoSolicitudFondos;

/**
 * @method static EstadoSolicitudFondosBuilder query()
 * @method static EstadoSolicitudFondosBuilder where(string $column,string $operator, string $value)
 * @method static EstadoSolicitudFondosBuilder where(string $column,string $value)
 * @method static EstadoSolicitudFondosBuilder whereNotNull(string $column)
 * @method static EstadoSolicitudFondosBuilder whereNull(string $column)
 * @method static EstadoSolicitudFondosBuilder whereIn(string $column,array $array)
 * @method static EstadoSolicitudFondosBuilder orderBy(string $column,array $sentido)
 * @method static EstadoSolicitudFondosBuilder select(array|string $columns)
 * @method static EstadoSolicitudFondosBuilder distinct()
 * @method static EstadoSolicitudFondosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static EstadoSolicitudFondosBuilder whereBetween(string $column, array $values)
 * @method static EstadoSolicitudFondosBuilder whereNotBetween(string $column, array $values)
 * @method static EstadoSolicitudFondosBuilder whereNotIn(string $column, array $values)
 * @method static EstadoSolicitudFondosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static EstadoSolicitudFondosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static EstadoSolicitudFondosBuilder whereYear(string $column, string $operator, int $value)
 * @method static EstadoSolicitudFondosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static EstadoSolicitudFondosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static EstadoSolicitudFondosBuilder groupBy(string ...$groups)
 * @method static EstadoSolicitudFondosBuilder limit(int $value)
 * @method static int count()
 * @method static EstadoSolicitudFondosCollection get(array|string $columns = ["*"])
 * @method static EstadoSolicitudFondos|null first()
 */
class EstadoSolicitudFondosBuilder extends Builder {}
