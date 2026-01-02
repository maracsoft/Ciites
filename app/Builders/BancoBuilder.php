<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\BancoCollection;
use App\Banco;

/**
 * @method static BancoBuilder query()
 * @method static BancoBuilder where(string $column,string $operator, string $value)
 * @method static BancoBuilder where(string $column,string $value)
 * @method static BancoBuilder whereNotNull(string $column)
 * @method static BancoBuilder whereNull(string $column)
 * @method static BancoBuilder whereIn(string $column,array $array)
 * @method static BancoBuilder orderBy(string $column,array $sentido)
 * @method static BancoBuilder select(array|string $columns)
 * @method static BancoBuilder distinct()
 * @method static BancoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static BancoBuilder whereBetween(string $column, array $values)
 * @method static BancoBuilder whereNotBetween(string $column, array $values)
 * @method static BancoBuilder whereNotIn(string $column, array $values)
 * @method static BancoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static BancoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static BancoBuilder whereYear(string $column, string $operator, int $value)
 * @method static BancoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static BancoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static BancoBuilder groupBy(string ...$groups)
 * @method static BancoBuilder limit(int $value)
 * @method static int count()
 * @method static BancoCollection get(array|string $columns = ["*"])
 * @method static Banco|null first()
 */
class BancoBuilder extends Builder {}
