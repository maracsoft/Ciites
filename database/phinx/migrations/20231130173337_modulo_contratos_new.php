<?php

use App\AvanceEntregable;
use App\ContratoLocacion;
use App\ContratoPlazo;
use Phinx\Db\Adapter\MysqlAdapter;

class ModuloContratosNew extends Phinx\Migration\AbstractMigration
{
  public function change()
  {

    AvanceEntregable::query()->delete();
    ContratoPlazo::query()->delete();
    ContratoLocacion::query()->delete();


    $this->table('contrato_locacion', [
      'id' => false,
      'primary_key' => ['codContratoLocacion'],
      'engine' => 'InnoDB',
      'encoding' => 'utf8mb4',
      'collation' => 'utf8mb4_general_ci',
      'comment' => '',
      'row_format' => 'DYNAMIC',
    ])
      ->addColumn('codigo_unico', 'string', [
        'null' => false,
        'limit' => 30,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'codContratoLocacion',
      ])
      ->changeColumn('sexo', 'char', [
        'null' => true,
        'default' => null,
        'limit' => 1,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'ruc',
      ])
      ->addColumn('fecha_inicio_contrato', 'date', [
        'null' => false,
        'after' => 'fechaHoraGeneracion',
      ])
      ->addColumn('fecha_fin_contrato', 'date', [
        'null' => false,
        'after' => 'fecha_inicio_contrato',
      ])
      ->changeColumn('esPersonaNatural', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'after' => 'codSede',
      ])
      ->changeColumn('razonSocialPJ', 'string', [
        'null' => true,
        'default' => null,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'esPersonaNatural',
      ])
      ->changeColumn('nombreDelCargoPJ', 'string', [
        'null' => true,
        'default' => null,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'razonSocialPJ',
      ])
      ->changeColumn('nombreProyecto', 'string', [
        'null' => false,
        'limit' => 300,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'nombreDelCargoPJ',
      ])
      ->changeColumn('nombreFinanciera', 'string', [
        'null' => false,
        'limit' => 300,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'nombreProyecto',
      ])
      ->changeColumn('fechaHoraAnulacion', 'datetime', [
        'null' => true,
        'default' => null,
        'after' => 'nombreFinanciera',
      ])
      ->addColumn('provincia', 'string', [
        'null' => false,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'fechaHoraAnulacion',
      ])
      ->addColumn('departamento', 'string', [
        'null' => false,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'provincia',
      ])
      ->addColumn('es_borrador', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'after' => 'departamento',
      ])
      ->addColumn('distrito', 'string', [
        'null' => false,
        'limit' => 500,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'es_borrador',
      ])
      ->removeColumn('codigoCedepas')
      ->removeColumn('fechaInicio')
      ->removeColumn('fechaFin')
      ->removeColumn('provinciaYDepartamento')
      ->removeColumn('esDeCedepas')
      ->save();



    $this->table('contrato_plazo', [
      'id' => false,
      'primary_key' => ['codContratoPlazo'],
      'engine' => 'InnoDB',
      'encoding' => 'utf8mb4',
      'collation' => 'utf8mb4_general_ci',
      'comment' => '',
      'row_format' => 'DYNAMIC',
    ])
      ->changeColumn('nombres', 'string', [
        'null' => false,
        'limit' => 500,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'codContratoPlazo',
      ])
      ->changeColumn('dni', 'string', [
        'null' => false,
        'limit' => 500,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'nombres',
      ])
      ->changeColumn('apellidos', 'string', [
        'null' => false,
        'limit' => 500,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'dni',
      ])
      ->addColumn('codigo_unico', 'string', [
        'null' => false,
        'limit' => 500,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'apellidos',
      ])
      ->changeColumn('fechaHoraGeneracion', 'datetime', [
        'null' => false,
        'after' => 'codigo_unico',
      ])
      ->changeColumn('codMoneda', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'after' => 'fechaHoraGeneracion',
      ])
      ->changeColumn('codEmpleadoCreador', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'after' => 'codMoneda',
      ])
      ->addColumn('domicilio', 'string', [
        'null' => false,
        'limit' => 500,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'codEmpleadoCreador',
      ])
      ->addColumn('tipo_adenda_financiera', 'string', [
        'null' => false,
        'limit' => 500,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'domicilio',
      ])
      ->addColumn('nombre_financiera', 'string', [
        'null' => false,
        'limit' => 500,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'tipo_adenda_financiera',
      ])
      ->addColumn('duracion_convenio_numero', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'after' => 'nombre_financiera',
      ])
      ->addColumn('duracion_convenio_unidad_temporal', 'string', [
        'null' => false,
        'limit' => 500,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'duracion_convenio_numero',
      ])
      ->addColumn('nombre_contrato_locacion', 'string', [
        'null' => false,
        'limit' => 500,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'duracion_convenio_unidad_temporal',
      ])
      ->addColumn('puesto', 'string', [
        'null' => false,
        'limit' => 500,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'nombre_contrato_locacion',
      ])
      ->addColumn('fecha_inicio_prueba', 'date', [
        'null' => false,
        'after' => 'puesto',
      ])
      ->addColumn('fecha_fin_prueba', 'date', [
        'null' => false,
        'after' => 'fecha_inicio_prueba',
      ])
      ->addColumn('fecha_inicio_contrato', 'date', [
        'null' => false,
        'after' => 'fecha_fin_prueba',
      ])
      ->addColumn('fecha_fin_contrato', 'date', [
        'null' => false,
        'after' => 'fecha_inicio_contrato',
      ])
      ->addColumn('cantidad_dias_labor', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'after' => 'fecha_fin_contrato',
      ])
      ->addColumn('cantidad_dias_descanso', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'after' => 'cantidad_dias_labor',
      ])
      ->addColumn('remuneracion_mensual', 'float', [
        'null' => false,
        'after' => 'cantidad_dias_descanso',
      ])
      ->changeColumn('fechaHoraAnulacion', 'date', [
        'null' => true,
        'default' => null,
        'after' => 'remuneracion_mensual',
      ])
      ->addColumn('es_borrador', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'after' => 'fechaHoraAnulacion',
      ])
      ->addColumn('provincia', 'string', [
        'null' => false,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'es_borrador',
      ])
      ->addColumn('departamento', 'string', [
        'null' => false,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'provincia',
      ])
      ->changeColumn('sexo', 'string', [
        'null' => false,
        'limit' => 5,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'departamento',
      ])
      ->addColumn('distrito', 'string', [
        'null' => false,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'sexo',
      ])
      ->removeColumn('codigoCedepas')
      ->removeColumn('direccion')
      ->removeColumn('asignacionFamiliar')
      ->removeColumn('fechaInicio')
      ->removeColumn('fechaFin')
      ->removeColumn('sueldoBruto')
      ->removeColumn('nombrePuesto')
      ->removeColumn('codSede')
      ->removeColumn('codTipoContrato')
      ->removeColumn('nombreFinanciera')
      ->removeColumn('nombreProyecto')
      ->removeColumn('provinciaYDepartamento')
      ->removeIndexByName("fk_relation_contrato_plazo_and_sede")
      ->removeIndexByName("fk_relation_contrato_plazo_and_tipo_contrato")
      ->save();
    $this->table('tipo_contrato')->drop()->save();
  }
}
