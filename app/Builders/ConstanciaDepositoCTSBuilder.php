<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ConstanciaDepositoCTSCollection;
use App\ConstanciaDepositoCTS;

/**
 * @method static ConstanciaDepositoCTSBuilder query()
 * @method static ConstanciaDepositoCTSBuilder where(string $column,string $operator, string $value)
 * @method static ConstanciaDepositoCTSBuilder where(string $column,string $value)
 * @method static ConstanciaDepositoCTSBuilder whereNotNull(string $column)
 * @method static ConstanciaDepositoCTSBuilder whereNull(string $column)
 * @method static ConstanciaDepositoCTSBuilder whereIn(string $column,array $array)
 * @method static ConstanciaDepositoCTSBuilder orderBy(string $column,array $sentido)
 * @method static ConstanciaDepositoCTSBuilder select(array|string $columns)
 * @method static ConstanciaDepositoCTSBuilder distinct()
 * @method static ConstanciaDepositoCTSBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ConstanciaDepositoCTSBuilder whereBetween(string $column, array $values)
 * @method static ConstanciaDepositoCTSBuilder whereNotBetween(string $column, array $values)
 * @method static ConstanciaDepositoCTSBuilder whereNotIn(string $column, array $values)
 * @method static ConstanciaDepositoCTSBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ConstanciaDepositoCTSBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ConstanciaDepositoCTSBuilder whereYear(string $column, string $operator, int $value)
 * @method static ConstanciaDepositoCTSBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ConstanciaDepositoCTSBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ConstanciaDepositoCTSBuilder groupBy(string ...$groups)
 * @method static ConstanciaDepositoCTSBuilder limit(int $value)
 * @method static int count()
 * @method static ConstanciaDepositoCTSCollection get(array|string $columns = ["*"])
 * @method static ConstanciaDepositoCTS|null first()
 */
class ConstanciaDepositoCTSBuilder extends Builder {}
