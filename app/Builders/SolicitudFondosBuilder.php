<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\SolicitudFondosCollection;
use App\SolicitudFondos;

/**
 * @method static SolicitudFondosBuilder query()
 * @method static SolicitudFondosBuilder where(string $column,string $operator, string $value)
 * @method static SolicitudFondosBuilder where(string $column,string $value)
 * @method static SolicitudFondosBuilder whereNotNull(string $column)
 * @method static SolicitudFondosBuilder whereNull(string $column)
 * @method static SolicitudFondosBuilder whereIn(string $column,array $array)
 * @method static SolicitudFondosBuilder orderBy(string $column,array $sentido)
 * @method static SolicitudFondosBuilder select(array|string $columns)
 * @method static SolicitudFondosBuilder distinct()
 * @method static SolicitudFondosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static SolicitudFondosBuilder whereBetween(string $column, array $values)
 * @method static SolicitudFondosBuilder whereNotBetween(string $column, array $values)
 * @method static SolicitudFondosBuilder whereNotIn(string $column, array $values)
 * @method static SolicitudFondosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static SolicitudFondosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static SolicitudFondosBuilder whereYear(string $column, string $operator, int $value)
 * @method static SolicitudFondosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static SolicitudFondosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static SolicitudFondosBuilder groupBy(string ...$groups)
 * @method static SolicitudFondosBuilder limit(int $value)
 * @method static int count()
 * @method static SolicitudFondosCollection get(array|string $columns = ["*"])
 * @method static SolicitudFondos|null first()
 */
class SolicitudFondosBuilder extends Builder {}
