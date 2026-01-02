<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\BusquedaRepoCollection;
use App\BusquedaRepo;

/**
 * @method static BusquedaRepoBuilder query()
 * @method static BusquedaRepoBuilder where(string $column,string $operator, string $value)
 * @method static BusquedaRepoBuilder where(string $column,string $value)
 * @method static BusquedaRepoBuilder whereNotNull(string $column)
 * @method static BusquedaRepoBuilder whereNull(string $column)
 * @method static BusquedaRepoBuilder whereIn(string $column,array $array)
 * @method static BusquedaRepoBuilder orderBy(string $column,array $sentido)
 * @method static BusquedaRepoBuilder select(array|string $columns)
 * @method static BusquedaRepoBuilder distinct()
 * @method static BusquedaRepoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static BusquedaRepoBuilder whereBetween(string $column, array $values)
 * @method static BusquedaRepoBuilder whereNotBetween(string $column, array $values)
 * @method static BusquedaRepoBuilder whereNotIn(string $column, array $values)
 * @method static BusquedaRepoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static BusquedaRepoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static BusquedaRepoBuilder whereYear(string $column, string $operator, int $value)
 * @method static BusquedaRepoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static BusquedaRepoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static BusquedaRepoBuilder groupBy(string ...$groups)
 * @method static BusquedaRepoBuilder limit(int $value)
 * @method static int count()
 * @method static BusquedaRepoCollection get(array|string $columns = ["*"])
 * @method static BusquedaRepo|null first()
 */
class BusquedaRepoBuilder extends Builder {}
