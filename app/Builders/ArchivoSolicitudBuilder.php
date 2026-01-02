<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ArchivoSolicitudCollection;
use App\ArchivoSolicitud;

/**
 * @method static ArchivoSolicitudBuilder query()
 * @method static ArchivoSolicitudBuilder where(string $column,string $operator, string $value)
 * @method static ArchivoSolicitudBuilder where(string $column,string $value)
 * @method static ArchivoSolicitudBuilder whereNotNull(string $column)
 * @method static ArchivoSolicitudBuilder whereNull(string $column)
 * @method static ArchivoSolicitudBuilder whereIn(string $column,array $array)
 * @method static ArchivoSolicitudBuilder orderBy(string $column,array $sentido)
 * @method static ArchivoSolicitudBuilder select(array|string $columns)
 * @method static ArchivoSolicitudBuilder distinct()
 * @method static ArchivoSolicitudBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ArchivoSolicitudBuilder whereBetween(string $column, array $values)
 * @method static ArchivoSolicitudBuilder whereNotBetween(string $column, array $values)
 * @method static ArchivoSolicitudBuilder whereNotIn(string $column, array $values)
 * @method static ArchivoSolicitudBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ArchivoSolicitudBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ArchivoSolicitudBuilder whereYear(string $column, string $operator, int $value)
 * @method static ArchivoSolicitudBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ArchivoSolicitudBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ArchivoSolicitudBuilder groupBy(string ...$groups)
 * @method static ArchivoSolicitudBuilder limit(int $value)
 * @method static int count()
 * @method static ArchivoSolicitudCollection get(array|string $columns = ["*"])
 * @method static ArchivoSolicitud|null first()
 */
class ArchivoSolicitudBuilder extends Builder {}
