<?php

use Phinx\Db\Adapter\MysqlAdapter;

class AddTablesContratos extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('avance_entregable', [
                'id' => false,
                'primary_key' => ['codAvance'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codAvance', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codAvance',
            ])
            ->addColumn('fechaEntrega', 'date', [
                'null' => false,
                'after' => 'descripcion',
            ])
            ->addColumn('porcentaje', 'float', [
                'null' => false,
                'after' => 'fechaEntrega',
            ])
            ->addColumn('monto', 'float', [
                'null' => false,
                'after' => 'porcentaje',
            ])
            ->addColumn('codContratoLocacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'monto',
            ])
            ->addIndex(['codContratoLocacion'], [
                'name' => 'fk_relation_avance_entregable_and_contrato_locacion',
                'unique' => false,
            ])
            ->create();
        $this->table('contrato_locacion', [
                'id' => false,
                'primary_key' => ['codContratoLocacion'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codContratoLocacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codigo_unico', 'string', [
                'null' => false,
                'limit' => 30,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codContratoLocacion',
            ])
            ->addColumn('nombres', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codigo_unico',
            ])
            ->addColumn('apellidos', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombres',
            ])
            ->addColumn('direccion', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'apellidos',
            ])
            ->addColumn('dni', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'direccion',
            ])
            ->addColumn('ruc', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'dni',
            ])
            ->addColumn('sexo', 'char', [
                'null' => true,
                'default' => null,
                'limit' => 1,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'ruc',
            ])
            ->addColumn('fechaHoraGeneracion', 'datetime', [
                'null' => false,
                'after' => 'sexo',
            ])
            ->addColumn('fecha_inicio_contrato', 'date', [
                'null' => false,
                'after' => 'fechaHoraGeneracion',
            ])
            ->addColumn('fecha_fin_contrato', 'date', [
                'null' => false,
                'after' => 'fecha_inicio_contrato',
            ])
            ->addColumn('retribucionTotal', 'float', [
                'null' => false,
                'after' => 'fecha_fin_contrato',
            ])
            ->addColumn('motivoContrato', 'string', [
                'null' => false,
                'limit' => 1000,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'retribucionTotal',
            ])
            ->addColumn('codEmpleadoCreador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'motivoContrato',
            ])
            ->addColumn('codMoneda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoCreador',
            ])
            ->addColumn('codSede', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codMoneda',
            ])
            ->addColumn('esPersonaNatural', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codSede',
            ])
            ->addColumn('razonSocialPJ', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'esPersonaNatural',
            ])
            ->addColumn('nombreDelCargoPJ', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'razonSocialPJ',
            ])
            ->addColumn('nombreProyecto', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombreDelCargoPJ',
            ])
            ->addColumn('nombreFinanciera', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombreProyecto',
            ])
            ->addColumn('fechaHoraAnulacion', 'datetime', [
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
            ->addIndex(['codEmpleadoCreador'], [
                'name' => 'fk_relation_contrato_locacion_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codMoneda'], [
                'name' => 'fk_relation_contrato_locacion_and_moneda',
                'unique' => false,
            ])
            ->addIndex(['codSede'], [
                'name' => 'fk_relation_contrato_locacion_and_sede',
                'unique' => false,
            ])
            ->create();
        $this->table('contrato_plazo', [
                'id' => false,
                'primary_key' => ['codContratoPlazo'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codContratoPlazo', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombres', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codContratoPlazo',
            ])
            ->addColumn('dni', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombres',
            ])
            ->addColumn('apellidos', 'string', [
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
            ->addColumn('fechaHoraGeneracion', 'datetime', [
                'null' => false,
                'after' => 'codigo_unico',
            ])
            ->addColumn('codMoneda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraGeneracion',
            ])
            ->addColumn('codEmpleadoCreador', 'integer', [
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
            ->addColumn('fechaHoraAnulacion', 'date', [
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
            ->addColumn('sexo', 'string', [
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
            ->addIndex(['codEmpleadoCreador'], [
                'name' => 'fk_relation_contrato_plazo_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codMoneda'], [
                'name' => 'fk_relation_contrato_plazo_and_moneda',
                'unique' => false,
            ])
            ->create();
    }
}
