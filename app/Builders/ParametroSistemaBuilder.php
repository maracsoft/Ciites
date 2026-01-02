<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ParametroSistemaCollection;
use App\ParametroSistema;

/**
 * @method static ParametroSistemaBuilder query()
 * @method static ParametroSistemaBuilder where(string $column,string $operator, string $value)
 * @method static ParametroSistemaBuilder where(string $column,string $value)
 * @method static ParametroSistemaBuilder whereNotNull(string $column)
 * @method static ParametroSistemaBuilder whereNull(string $column)
 * @method static ParametroSistemaBuilder whereIn(string $column,array $array)
 * @method static ParametroSistemaBuilder orderBy(string $column,array $sentido)
 * @method static ParametroSistemaBuilder select(array|string $columns)
 * @method static ParametroSistemaBuilder distinct()
 * @method static ParametroSistemaBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ParametroSistemaBuilder whereBetween(string $column, array $values)
 * @method static ParametroSistemaBuilder whereNotBetween(string $column, array $values)
 * @method static ParametroSistemaBuilder whereNotIn(string $column, array $values)
 * @method static ParametroSistemaBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ParametroSistemaBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ParametroSistemaBuilder whereYear(string $column, string $operator, int $value)
 * @method static ParametroSistemaBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ParametroSistemaBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ParametroSistemaBuilder groupBy(string ...$groups)
 * @method static ParametroSistemaBuilder limit(int $value)
 * @method static int count()
 * @method static ParametroSistemaCollection get(array|string $columns = ["*"])
 * @method static ParametroSistema|null first()
 */
class ParametroSistemaBuilder extends Builder {}
