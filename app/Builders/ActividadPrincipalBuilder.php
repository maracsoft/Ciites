<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ActividadPrincipalCollection;
use App\ActividadPrincipal;

/**
 * @method static ActividadPrincipalBuilder query()
 * @method static ActividadPrincipalBuilder where(string $column,string $operator, string $value)
 * @method static ActividadPrincipalBuilder where(string $column,string $value)
 * @method static ActividadPrincipalBuilder whereNotNull(string $column)
 * @method static ActividadPrincipalBuilder whereNull(string $column)
 * @method static ActividadPrincipalBuilder whereIn(string $column,array $array)
 * @method static ActividadPrincipalBuilder orderBy(string $column,array $sentido)
 * @method static ActividadPrincipalBuilder select(array|string $columns)
 * @method static ActividadPrincipalBuilder distinct()
 * @method static ActividadPrincipalBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ActividadPrincipalBuilder whereBetween(string $column, array $values)
 * @method static ActividadPrincipalBuilder whereNotBetween(string $column, array $values)
 * @method static ActividadPrincipalBuilder whereNotIn(string $column, array $values)
 * @method static ActividadPrincipalBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ActividadPrincipalBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ActividadPrincipalBuilder whereYear(string $column, string $operator, int $value)
 * @method static ActividadPrincipalBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ActividadPrincipalBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ActividadPrincipalBuilder groupBy(string ...$groups)
 * @method static ActividadPrincipalBuilder limit(int $value)
 * @method static int count()
 * @method static ActividadPrincipalCollection get(array|string $columns = ["*"])
 * @method static ActividadPrincipal|null first()
 */
class ActividadPrincipalBuilder extends Builder {}
