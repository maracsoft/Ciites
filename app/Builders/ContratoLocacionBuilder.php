<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ContratoLocacionCollection;
use App\ContratoLocacion;

/**
 * @method static ContratoLocacionBuilder query()
 * @method static ContratoLocacionBuilder where(string $column,string $operator, string $value)
 * @method static ContratoLocacionBuilder where(string $column,string $value)
 * @method static ContratoLocacionBuilder whereNotNull(string $column)
 * @method static ContratoLocacionBuilder whereNull(string $column)
 * @method static ContratoLocacionBuilder whereIn(string $column,array $array)
 * @method static ContratoLocacionBuilder orderBy(string $column,array $sentido)
 * @method static ContratoLocacionBuilder select(array|string $columns)
 * @method static ContratoLocacionBuilder distinct()
 * @method static ContratoLocacionBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ContratoLocacionBuilder whereBetween(string $column, array $values)
 * @method static ContratoLocacionBuilder whereNotBetween(string $column, array $values)
 * @method static ContratoLocacionBuilder whereNotIn(string $column, array $values)
 * @method static ContratoLocacionBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ContratoLocacionBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ContratoLocacionBuilder whereYear(string $column, string $operator, int $value)
 * @method static ContratoLocacionBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ContratoLocacionBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ContratoLocacionBuilder groupBy(string ...$groups)
 * @method static ContratoLocacionBuilder limit(int $value)
 * @method static int count()
 * @method static ContratoLocacionCollection get(array|string $columns = ["*"])
 * @method static ContratoLocacion|null first()
 */
class ContratoLocacionBuilder extends Builder {}
