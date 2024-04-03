<?php

use Phinx\Db\Adapter\MysqlAdapter;

class AddedPeriodoDirectorAndContratoPlazoNuevo extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->execute('SET unique_checks=0; SET foreign_key_checks=0;');
        $this->table('contrato_plazo_nuevo', [
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
            ->addColumn('nombre_proyecto', 'string', [
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
                'after' => 'nombre_proyecto',
            ])
            ->addColumn('fecha_inicio_prueba', 'date', [
                'null' => true,
                'default' => null,
                'after' => 'puesto',
            ])
            ->addColumn('fecha_fin_prueba', 'date', [
                'null' => true,
                'default' => null,
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
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fecha_fin_contrato',
            ])
            ->addColumn('cantidad_dias_descanso', 'integer', [
                'null' => true,
                'default' => null,
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
            ->addColumn('tipo_contrato', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'distrito',
            ])
            ->addColumn('tiene_periodo_prueba', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'tipo_contrato',
            ])
            ->addColumn('codPeriodoDirector', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'tiene_periodo_prueba',
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



            
        $this->table('periodo_director_general', [
            'id' => false,
            'primary_key' => ['codPeriodoDirector'],
            'engine' => 'InnoDB',
            'encoding' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'comment' => 'almacena los periodos y datos de los directores de cedepas',
            'row_format' => 'DYNAMIC',
        ])
            ->addColumn('codPeriodoDirector', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('fecha_inicio', 'date', [
                'null' => false,
                'after' => 'codPeriodoDirector',
            ])
            ->addColumn('fecha_fin', 'date', [
                'null' => true,
                'default' => null,
                'after' => 'fecha_inicio',
            ])
            ->addColumn('nombres', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'fecha_fin',
            ])
            ->addColumn('apellidos', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombres',
            ])
            ->addColumn('dni', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'apellidos',
            ])
            ->addColumn('sexo', 'string', [
                'null' => false,
                'limit' => 5,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'dni',
            ])
            ->addColumn('fechaHoraCreacion', 'datetime', [
                'null' => false,
                'after' => 'sexo',
            ])
            ->create();
            
        $this->execute('SET unique_checks=1; SET foreign_key_checks=1;');
    }
}
