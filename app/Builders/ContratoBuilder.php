<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ContratoCollection;
use App\Contrato;

/**
 * @method static ContratoBuilder query()
 * @method static ContratoBuilder where(string $column,string $operator, string $value)
 * @method static ContratoBuilder where(string $column,string $value)
 * @method static ContratoBuilder whereNotNull(string $column)
 * @method static ContratoBuilder whereNull(string $column)
 * @method static ContratoBuilder whereIn(string $column,array $array)
 * @method static ContratoBuilder orderBy(string $column,array $sentido)
 * @method static ContratoBuilder select(array|string $columns)
 * @method static ContratoBuilder distinct()
 * @method static ContratoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ContratoBuilder whereBetween(string $column, array $values)
 * @method static ContratoBuilder whereNotBetween(string $column, array $values)
 * @method static ContratoBuilder whereNotIn(string $column, array $values)
 * @method static ContratoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ContratoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ContratoBuilder whereYear(string $column, string $operator, int $value)
 * @method static ContratoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ContratoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ContratoBuilder groupBy(string ...$groups)
 * @method static ContratoBuilder limit(int $value)
 * @method static int count()
 * @method static ContratoCollection get(array|string $columns = ["*"])
 * @method static Contrato|null first()
 */
class ContratoBuilder extends Builder {}
