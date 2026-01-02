<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\EntidadFinancieraCollection;
use App\EntidadFinanciera;

/**
 * @method static EntidadFinancieraBuilder query()
 * @method static EntidadFinancieraBuilder where(string $column,string $operator, string $value)
 * @method static EntidadFinancieraBuilder where(string $column,string $value)
 * @method static EntidadFinancieraBuilder whereNotNull(string $column)
 * @method static EntidadFinancieraBuilder whereNull(string $column)
 * @method static EntidadFinancieraBuilder whereIn(string $column,array $array)
 * @method static EntidadFinancieraBuilder orderBy(string $column,array $sentido)
 * @method static EntidadFinancieraBuilder select(array|string $columns)
 * @method static EntidadFinancieraBuilder distinct()
 * @method static EntidadFinancieraBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static EntidadFinancieraBuilder whereBetween(string $column, array $values)
 * @method static EntidadFinancieraBuilder whereNotBetween(string $column, array $values)
 * @method static EntidadFinancieraBuilder whereNotIn(string $column, array $values)
 * @method static EntidadFinancieraBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static EntidadFinancieraBuilder whereMonth(string $column, string $operator, int $value)
 * @method static EntidadFinancieraBuilder whereYear(string $column, string $operator, int $value)
 * @method static EntidadFinancieraBuilder whereColumn(string $first, string $operator, string $second)
 * @method static EntidadFinancieraBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static EntidadFinancieraBuilder groupBy(string ...$groups)
 * @method static EntidadFinancieraBuilder limit(int $value)
 * @method static int count()
 * @method static EntidadFinancieraCollection get(array|string $columns = ["*"])
 * @method static EntidadFinanciera|null first()
 */
class EntidadFinancieraBuilder extends Builder {}
