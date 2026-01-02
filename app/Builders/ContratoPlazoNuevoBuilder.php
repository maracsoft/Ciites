<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ContratoPlazoNuevoCollection;
use App\ContratoPlazoNuevo;

/**
 * @method static ContratoPlazoNuevoBuilder query()
 * @method static ContratoPlazoNuevoBuilder where(string $column,string $operator, string $value)
 * @method static ContratoPlazoNuevoBuilder where(string $column,string $value)
 * @method static ContratoPlazoNuevoBuilder whereNotNull(string $column)
 * @method static ContratoPlazoNuevoBuilder whereNull(string $column)
 * @method static ContratoPlazoNuevoBuilder whereIn(string $column,array $array)
 * @method static ContratoPlazoNuevoBuilder orderBy(string $column,array $sentido)
 * @method static ContratoPlazoNuevoBuilder select(array|string $columns)
 * @method static ContratoPlazoNuevoBuilder distinct()
 * @method static ContratoPlazoNuevoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ContratoPlazoNuevoBuilder whereBetween(string $column, array $values)
 * @method static ContratoPlazoNuevoBuilder whereNotBetween(string $column, array $values)
 * @method static ContratoPlazoNuevoBuilder whereNotIn(string $column, array $values)
 * @method static ContratoPlazoNuevoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ContratoPlazoNuevoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ContratoPlazoNuevoBuilder whereYear(string $column, string $operator, int $value)
 * @method static ContratoPlazoNuevoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ContratoPlazoNuevoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ContratoPlazoNuevoBuilder groupBy(string ...$groups)
 * @method static ContratoPlazoNuevoBuilder limit(int $value)
 * @method static int count()
 * @method static ContratoPlazoNuevoCollection get(array|string $columns = ["*"])
 * @method static ContratoPlazoNuevo|null first()
 */
class ContratoPlazoNuevoBuilder extends Builder {}
