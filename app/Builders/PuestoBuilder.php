<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\PuestoCollection;
use App\Puesto;

/**
 * @method static PuestoBuilder query()
 * @method static PuestoBuilder where(string $column,string $operator, string $value)
 * @method static PuestoBuilder where(string $column,string $value)
 * @method static PuestoBuilder whereNotNull(string $column)
 * @method static PuestoBuilder whereNull(string $column)
 * @method static PuestoBuilder whereIn(string $column,array $array)
 * @method static PuestoBuilder orderBy(string $column,array $sentido)
 * @method static PuestoBuilder select(array|string $columns)
 * @method static PuestoBuilder distinct()
 * @method static PuestoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static PuestoBuilder whereBetween(string $column, array $values)
 * @method static PuestoBuilder whereNotBetween(string $column, array $values)
 * @method static PuestoBuilder whereNotIn(string $column, array $values)
 * @method static PuestoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static PuestoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static PuestoBuilder whereYear(string $column, string $operator, int $value)
 * @method static PuestoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static PuestoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static PuestoBuilder groupBy(string ...$groups)
 * @method static PuestoBuilder limit(int $value)
 * @method static int count()
 * @method static PuestoCollection get(array|string $columns = ["*"])
 * @method static Puesto|null first()
 */
class PuestoBuilder extends Builder {}
