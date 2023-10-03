<?php

use Phinx\Db\Adapter\MysqlAdapter;

class AddInitialBd extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('actividad_principal', [
                'id' => false,
                'primary_key' => ['codActividadPrincipal'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codActividadPrincipal', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codActividadPrincipal',
            ])
            ->create();
        $this->table('actividad_res', [
                'id' => false,
                'primary_key' => ['codActividad'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codActividad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 600,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codActividad',
            ])
            ->addColumn('codResultadoEsperado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcion',
            ])
            ->addIndex(['codResultadoEsperado'], [
                'name' => 'fk_relation_actividad_res_and_resultado_esperado',
                'unique' => false,
            ])
            ->create();
        $this->table('archivo_orden', [
                'id' => false,
                'primary_key' => ['codArchivoOrden'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codArchivoOrden', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombreGuardado', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codArchivoOrden',
            ])
            ->addColumn('codOrdenCompra', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombreGuardado',
            ])
            ->addColumn('nombreAparente', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codOrdenCompra',
            ])
            ->addIndex(['codOrdenCompra'], [
                'name' => 'fk_relation_archivo_orden_and_orden_compra',
                'unique' => false,
            ])
            ->create();
        $this->table('archivo_proyecto', [
                'id' => false,
                'primary_key' => ['codArchivoProyecto'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codArchivoProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombreDeGuardado', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codArchivoProyecto',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombreDeGuardado',
            ])
            ->addColumn('fechaHoraSubida', 'datetime', [
                'null' => false,
                'after' => 'codProyecto',
            ])
            ->addColumn('codTipoArchivoProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraSubida',
            ])
            ->addColumn('nombreAparente', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoArchivoProyecto',
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_archivo_proyecto_and_proyecto',
                'unique' => false,
            ])
            ->addIndex(['codTipoArchivoProyecto'], [
                'name' => 'fk_relation_archivo_proyecto_and_tipo_archivo_proyecto',
                'unique' => false,
            ])
            ->create();
        $this->table('archivo_rend', [
                'id' => false,
                'primary_key' => ['codArchivoRend'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codArchivoRend', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombreDeGuardado', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codArchivoRend',
            ])
            ->addColumn('codRendicionGastos', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombreDeGuardado',
            ])
            ->addColumn('nombreAparente', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codRendicionGastos',
            ])
            ->addIndex(['codRendicionGastos'], [
                'name' => 'fk_relation_archivo_rend_and_rendicion_gastos',
                'unique' => false,
            ])
            ->create();
        $this->table('archivo_repo', [
                'id' => false,
                'primary_key' => ['codArchivoRepo'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codArchivoRepo', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombreDeGuardado', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codArchivoRepo',
            ])
            ->addColumn('codReposicionGastos', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombreDeGuardado',
            ])
            ->addColumn('nombreAparente', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codReposicionGastos',
            ])
            ->addIndex(['codReposicionGastos'], [
                'name' => 'fk_relation_archivo_repo_and_reposicion_gastos',
                'unique' => false,
            ])
            ->create();
        $this->table('archivo_req_admin', [
                'id' => false,
                'primary_key' => ['codArchivoReqAdmin'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codArchivoReqAdmin', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombreDeGuardado', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codArchivoReqAdmin',
            ])
            ->addColumn('codRequerimiento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombreDeGuardado',
            ])
            ->addColumn('nombreAparente', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codRequerimiento',
            ])
            ->addIndex(['codRequerimiento'], [
                'name' => 'fk_relation_archivo_req_admin_and_requerimiento_bs',
                'unique' => false,
            ])
            ->create();
        $this->table('archivo_req_emp', [
                'id' => false,
                'primary_key' => ['codArchivoReqEmp'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codArchivoReqEmp', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombreDeGuardado', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codArchivoReqEmp',
            ])
            ->addColumn('codRequerimiento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombreDeGuardado',
            ])
            ->addColumn('nombreAparente', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codRequerimiento',
            ])
            ->addIndex(['codRequerimiento'], [
                'name' => 'fk_relation_archivo_req_emp_and_requerimiento_bs',
                'unique' => false,
            ])
            ->create();
        $this->table('archivo_solicitud', [
                'id' => false,
                'primary_key' => ['codArchivoSolicitud'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codArchivoSolicitud', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombreDeGuardado', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codArchivoSolicitud',
            ])
            ->addColumn('codSolicitud', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombreDeGuardado',
            ])
            ->addColumn('nombreAparente', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codSolicitud',
            ])
            ->addIndex(['codSolicitud'], [
                'name' => 'fk_relation_archivo_solicitud_and_solicitud_fondos',
                'unique' => false,
            ])
            ->create();
        $this->table('contacto_financiera', [
                'id' => false,
                'primary_key' => ['codContacto'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codContacto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombres', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codContacto',
            ])
            ->addColumn('apellidos', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'nombres',
            ])
            ->addColumn('telefono', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'apellidos',
            ])
            ->addColumn('correo', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'telefono',
            ])
            ->addColumn('documentoIdentidad', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'correo',
            ])
            ->addColumn('codNacionalidad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'documentoIdentidad',
            ])
            ->addColumn('codEntidadFinanciera', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codNacionalidad',
            ])
            ->addColumn('fechaDeBaja', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'codEntidadFinanciera',
            ])
            ->addIndex(['codEntidadFinanciera'], [
                'name' => 'cite_contacto_financiera" y "entidad_financiera',
                'unique' => false,
            ])
            ->addIndex(['codNacionalidad'], [
                'name' => 'fk_relation_cite_contacto_financiera_and_nacionalidad',
                'unique' => false,
            ])
            ->create();
        $this->table('departamento', [
                'id' => false,
                'primary_key' => ['codDepartamento'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDepartamento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codDepartamento',
            ])
            ->create();
        $this->table('detalle_dj_gastosmovilidad', [
                'id' => false,
                'primary_key' => ['codDetalleMovilidad'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDetalleMovilidad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('fecha', 'date', [
                'null' => false,
                'after' => 'codDetalleMovilidad',
            ])
            ->addColumn('lugar', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fecha',
            ])
            ->addColumn('detalle', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'lugar',
            ])
            ->addColumn('importe', 'float', [
                'null' => false,
                'after' => 'detalle',
            ])
            ->addColumn('codDJGastosMovilidad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'importe',
            ])
            ->addIndex(['codDJGastosMovilidad'], [
                'name' => 'fk_relation_detalle_dj_gastosmovilidad_and_dj_gastosmovilidad',
                'unique' => false,
            ])
            ->create();
        $this->table('detalle_dj_gastosvarios', [
                'id' => false,
                'primary_key' => ['codDetalleVarios'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDetalleVarios', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('fecha', 'date', [
                'null' => false,
                'after' => 'codDetalleVarios',
            ])
            ->addColumn('concepto', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fecha',
            ])
            ->addColumn('importe', 'float', [
                'null' => false,
                'after' => 'concepto',
            ])
            ->addColumn('codDJGastosVarios', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'importe',
            ])
            ->addIndex(['codDJGastosVarios'], [
                'name' => 'fk_relation_detalle_dj_gastosvarios_and_dj_gastosvarios',
                'unique' => false,
            ])
            ->create();
        $this->table('detalle_dj_gastosviaticos', [
                'id' => false,
                'primary_key' => ['codDetalleViaticos'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDetalleViaticos', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('fecha', 'date', [
                'null' => false,
                'after' => 'codDetalleViaticos',
            ])
            ->addColumn('lugar', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fecha',
            ])
            ->addColumn('montoDesayuno', 'float', [
                'null' => false,
                'after' => 'lugar',
            ])
            ->addColumn('montoAlmuerzo', 'float', [
                'null' => false,
                'after' => 'montoDesayuno',
            ])
            ->addColumn('montoCena', 'float', [
                'null' => false,
                'after' => 'montoAlmuerzo',
            ])
            ->addColumn('totalDia', 'float', [
                'null' => false,
                'after' => 'montoCena',
            ])
            ->addColumn('codDJGastosViaticos', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'totalDia',
            ])
            ->addIndex(['codDJGastosViaticos'], [
                'name' => 'fk_relation_detalle_dj_gastosviaticos_and_dj_gastosviaticos',
                'unique' => false,
            ])
            ->create();
        $this->table('detalle_orden_compra', [
                'id' => false,
                'primary_key' => ['codDetalleOrdenCompra'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDetalleOrdenCompra', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('cantidad', 'float', [
                'null' => false,
                'after' => 'codDetalleOrdenCompra',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'cantidad',
            ])
            ->addColumn('valorDeVenta', 'float', [
                'null' => false,
                'after' => 'descripcion',
            ])
            ->addColumn('precioVenta', 'float', [
                'null' => false,
                'after' => 'valorDeVenta',
            ])
            ->addColumn('subtotal', 'float', [
                'null' => false,
                'after' => 'precioVenta',
            ])
            ->addColumn('codOrdenCompra', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'subtotal',
            ])
            ->addColumn('exoneradoIGV', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'codOrdenCompra',
            ])
            ->addColumn('codUnidadMedida', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'exoneradoIGV',
            ])
            ->addIndex(['codOrdenCompra'], [
                'name' => 'fk_relation_detalle_orden_compra_and_orden_compra',
                'unique' => false,
            ])
            ->addIndex(['codUnidadMedida'], [
                'name' => 'fk_relation_detalle_orden_compra_and_unidad_medida',
                'unique' => false,
            ])
            ->create();
        $this->table('detalle_reposicion_gastos', [
                'id' => false,
                'primary_key' => ['codDetalleReposicion'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDetalleReposicion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codReposicionGastos', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codDetalleReposicion',
            ])
            ->addColumn('fechaComprobante', 'date', [
                'null' => false,
                'after' => 'codReposicionGastos',
            ])
            ->addColumn('nroComprobante', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fechaComprobante',
            ])
            ->addColumn('concepto', 'string', [
                'null' => false,
                'limit' => 250,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nroComprobante',
            ])
            ->addColumn('importe', 'float', [
                'null' => false,
                'after' => 'concepto',
            ])
            ->addColumn('codigoPresupuestal', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'importe',
            ])
            ->addColumn('nroEnReposicion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codigoPresupuestal',
            ])
            ->addColumn('codTipoCDP', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nroEnReposicion',
            ])
            ->addColumn('contabilizado', 'integer', [
                'null' => true,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'codTipoCDP',
            ])
            ->addColumn('pendienteDeVer', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'contabilizado',
            ])
            ->addIndex(['codTipoCDP'], [
                'name' => 'fk_relation_detalle_reposicion_gastos_and_cdp',
                'unique' => false,
            ])
            ->addIndex(['codReposicionGastos'], [
                'name' => 'fk_relation_detalle_reposicion_gastos_and_reposicion_gastos',
                'unique' => false,
            ])
            ->create();
        $this->table('detalle_requerimiento_bs', [
                'id' => false,
                'primary_key' => ['codDetalleRequerimiento'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDetalleRequerimiento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codRequerimiento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codDetalleRequerimiento',
            ])
            ->addColumn('cantidad', 'float', [
                'null' => false,
                'after' => 'codRequerimiento',
            ])
            ->addColumn('codUnidadMedida', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'cantidad',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codUnidadMedida',
            ])
            ->addColumn('codigoPresupuestal', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'descripcion',
            ])
            ->addIndex(['codRequerimiento'], [
                'name' => 'fk_relation_detalle_requerimiento_bs_and_requerimiento_bs',
                'unique' => false,
            ])
            ->addIndex(['codUnidadMedida'], [
                'name' => 'fk_relation_detalle_requerimiento_bs_and_unidad_medida',
                'unique' => false,
            ])
            ->create();
        $this->table('distrito', [
                'id' => false,
                'primary_key' => ['codDistrito'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDistrito', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codDistrito',
            ])
            ->addColumn('codProvincia', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombre',
            ])
            ->addIndex(['codProvincia'], [
                'name' => 'fk_relation_distrito_and_provincia',
                'unique' => false,
            ])
            ->create();
        $this->table('dj_gastosmovilidad', [
                'id' => false,
                'primary_key' => ['codDJGastosMovilidad'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('fechaHoraCreacion', 'datetime', [
                'null' => false,
            ])
            ->addColumn('domicilio', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fechaHoraCreacion',
            ])
            ->addColumn('importeTotal', 'float', [
                'null' => false,
                'after' => 'domicilio',
            ])
            ->addColumn('codMoneda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'importeTotal',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codMoneda',
            ])
            ->addColumn('codDJGastosMovilidad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
                'after' => 'codEmpleado',
            ])
            ->addColumn('codigoCedepas', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codDJGastosMovilidad',
            ])
            ->addIndex(['codEmpleado'], [
                'name' => 'fk_relation_dj_gastosmovilidad_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codMoneda'], [
                'name' => 'fk_relation_dj_gastosmovilidad_and_moneda',
                'unique' => false,
            ])
            ->create();
        $this->table('dj_gastosvarios', [
                'id' => false,
                'primary_key' => ['codDJGastosVarios'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDJGastosVarios', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('fechaHoraCreacion', 'datetime', [
                'null' => false,
                'after' => 'codDJGastosVarios',
            ])
            ->addColumn('domicilio', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fechaHoraCreacion',
            ])
            ->addColumn('importeTotal', 'float', [
                'null' => false,
                'after' => 'domicilio',
            ])
            ->addColumn('codMoneda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'importeTotal',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codMoneda',
            ])
            ->addColumn('codigoCedepas', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codEmpleado',
            ])
            ->addIndex(['codEmpleado'], [
                'name' => 'fk_relation_dj_gastosvarios_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codMoneda'], [
                'name' => 'fk_relation_dj_gastosvarios_and_moneda',
                'unique' => false,
            ])
            ->create();
        $this->table('dj_gastosviaticos', [
                'id' => false,
                'primary_key' => ['codDJGastosViaticos'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDJGastosViaticos', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('fechaHoraCreacion', 'datetime', [
                'null' => false,
                'after' => 'codDJGastosViaticos',
            ])
            ->addColumn('domicilio', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fechaHoraCreacion',
            ])
            ->addColumn('importeTotal', 'float', [
                'null' => false,
                'after' => 'domicilio',
            ])
            ->addColumn('codMoneda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'importeTotal',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codMoneda',
            ])
            ->addColumn('codigoCedepas', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codEmpleado',
            ])
            ->addIndex(['codEmpleado'], [
                'name' => 'fk_relation_dj_gastosviaticos_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codMoneda'], [
                'name' => 'fk_relation_dj_gastosviaticos_and_moneda',
                'unique' => false,
            ])
            ->create();
        $this->table('entidad_financiera', [
                'id' => false,
                'primary_key' => ['codEntidadFinanciera'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codEntidadFinanciera', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codEntidadFinanciera',
            ])
            ->create();
        $this->table('error_historial', [
                'id' => false,
                'primary_key' => ['codErrorHistorial'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codErrorHistorial', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codErrorHistorial',
            ])
            ->addColumn('controllerDondeOcurrio', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codEmpleado',
            ])
            ->addColumn('funcionDondeOcurrio', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'controllerDondeOcurrio',
            ])
            ->addColumn('fechaHora', 'datetime', [
                'null' => false,
                'after' => 'funcionDondeOcurrio',
            ])
            ->addColumn('ipEmpleado', 'string', [
                'null' => false,
                'limit' => 40,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fechaHora',
            ])
            ->addColumn('descripcionError', 'string', [
                'null' => false,
                'limit' => 25000,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'ipEmpleado',
            ])
            ->addColumn('estadoError', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'descripcionError',
            ])
            ->addColumn('razon', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'estadoError',
            ])
            ->addColumn('solucion', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 500,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'razon',
            ])
            ->addColumn('formulario', 'string', [
                'null' => false,
                'limit' => 3000,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'solucion',
            ])
            ->addColumn('fechaHoraSolucion', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'formulario',
            ])
            ->addIndex(['codEmpleado'], [
                'name' => 'fk_relation_error_historial_and_empleado',
                'unique' => false,
            ])
            ->create();
        $this->table('estado_proyecto', [
                'id' => false,
                'primary_key' => ['codEstadoProyecto'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codEstadoProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codEstadoProyecto',
            ])
            ->create();
        $this->table('estado_rendicion_gastos', [
                'id' => false,
                'primary_key' => ['codEstadoRendicion'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codEstadoRendicion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codEstadoRendicion',
            ])
            ->addColumn('ordenListadoEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombre',
            ])
            ->addColumn('ordenListadoGerente', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'ordenListadoEmpleado',
            ])
            ->addColumn('ordenListadoAdministrador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'ordenListadoGerente',
            ])
            ->addColumn('ordenListadoContador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'ordenListadoAdministrador',
            ])
            ->create();
        $this->table('estado_reposicion_gastos', [
                'id' => false,
                'primary_key' => ['codEstadoReposicion'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codEstadoReposicion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codEstadoReposicion',
            ])
            ->addColumn('ordenListadoEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombre',
            ])
            ->addColumn('ordenListadoGerente', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'ordenListadoEmpleado',
            ])
            ->addColumn('ordenListadoAdministrador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'ordenListadoGerente',
            ])
            ->addColumn('ordenListadoContador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'ordenListadoAdministrador',
            ])
            ->create();
        $this->table('estado_requerimiento_bs', [
                'id' => false,
                'primary_key' => ['codEstadoRequerimiento'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codEstadoRequerimiento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codEstadoRequerimiento',
            ])
            ->addColumn('ordenListadoEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombre',
            ])
            ->addColumn('ordenListadoGerente', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'ordenListadoEmpleado',
            ])
            ->addColumn('ordenListadoAdministrador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'ordenListadoGerente',
            ])
            ->addColumn('ordenListadoContador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'ordenListadoAdministrador',
            ])
            ->create();
        $this->table('indicador_actividad', [
                'id' => false,
                'primary_key' => ['codIndicadorActividad'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codIndicadorActividad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codActividad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codIndicadorActividad',
            ])
            ->addColumn('meta', 'float', [
                'null' => false,
                'after' => 'codActividad',
            ])
            ->addColumn('unidadMedida', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'meta',
            ])
            ->addColumn('saldoPendiente', 'float', [
                'null' => false,
                'after' => 'unidadMedida',
            ])
            ->addIndex(['codActividad'], [
                'name' => 'fk_relation_indicador_actividad_and_actividad_res',
                'unique' => false,
            ])
            ->create();
        $this->table('indicador_objespecifico', [
                'id' => false,
                'primary_key' => ['codIndicadorObj'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codIndicadorObj', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codIndicadorObj',
            ])
            ->addColumn('codObjEspecifico', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcion',
            ])
            ->addIndex(['codObjEspecifico'], [
                'name' => 'fk_relation_indicador_objespecifico_and_objetivo_especifico',
                'unique' => false,
            ])
            ->create();
        $this->table('indicador_resultado', [
                'id' => false,
                'primary_key' => ['codIndicadorResultado'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codIndicadorResultado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codIndicadorResultado',
            ])
            ->addColumn('codResultadoEsperado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcion',
            ])
            ->addIndex(['codResultadoEsperado'], [
                'name' => 'fk_relation_indicador_resultado_and_resultado_esperado',
                'unique' => false,
            ])
            ->create();
        $this->table('logeo_historial', [
                'id' => false,
                'primary_key' => ['codLogeoHistorial'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codLogeoHistorial', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codLogeoHistorial',
            ])
            ->addColumn('fechaHoraLogeo', 'datetime', [
                'null' => false,
                'after' => 'codEmpleado',
            ])
            ->addColumn('ipLogeo', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fechaHoraLogeo',
            ])
            ->addIndex(['codEmpleado'], [
                'name' => 'fk_relation_logeo_historial_and_empleado',
                'unique' => false,
            ])
            ->create();
        $this->table('lugar_ejecucion', [
                'id' => false,
                'primary_key' => ['codLugarEjecucion'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codLugarEjecucion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codLugarEjecucion',
            ])
            ->addColumn('codDistrito', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codProyecto',
            ])
            ->addColumn('zona', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codDistrito',
            ])
            ->addIndex(['codDistrito'], [
                'name' => 'fk_relation_lugar_ejecucion_and_distrito',
                'unique' => false,
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_lugar_ejecucion_and_proyecto',
                'unique' => false,
            ])
            ->create();
        $this->table('medio_verificacion_meta', [
                'id' => false,
                'primary_key' => ['codMedioVerificacion'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codMedioVerificacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombreGuardado', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codMedioVerificacion',
            ])
            ->addColumn('nombreAparente', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'nombreGuardado',
            ])
            ->addColumn('codMetaEjecutada', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombreAparente',
            ])
            ->addIndex(['codMetaEjecutada'], [
                'name' => 'fk_relation_medio_verificacion_meta_and_meta_ejecutada',
                'unique' => false,
            ])
            ->create();
        $this->table('medio_verificacion_resultado', [
                'id' => false,
                'primary_key' => ['codMedioVerificacion'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codMedioVerificacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 600,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codMedioVerificacion',
            ])
            ->addColumn('nombreGuardado', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'descripcion',
            ])
            ->addColumn('nombreAparente', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'nombreGuardado',
            ])
            ->addColumn('codIndicadorResultado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombreAparente',
            ])
            ->addIndex(['codIndicadorResultado'], [
                'name' => 'fk_relation_medio_verificacion_resultado_and_indicador_resultado',
                'unique' => false,
            ])
            ->create();
        $this->table('mes', [
                'id' => false,
                'primary_key' => ['codMes'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codMes', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 30,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codMes',
            ])
            ->addColumn('abreviacion', 'string', [
                'null' => false,
                'limit' => 30,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'nombre',
            ])
            ->addColumn('codDosDig', 'string', [
                'null' => false,
                'limit' => 2,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'abreviacion',
            ])
            ->create();
        $this->table('meta_ejecutada', [
                'id' => false,
                'primary_key' => ['codMetaEjecutada'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codMetaEjecutada', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('cantidadProgramada', 'float', [
                'null' => false,
                'after' => 'codMetaEjecutada',
            ])
            ->addColumn('cantidadEjecutada', 'float', [
                'null' => true,
                'default' => null,
                'after' => 'cantidadProgramada',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'cantidadEjecutada',
            ])
            ->addColumn('fechaRegistroProgramacion', 'datetime', [
                'null' => false,
                'after' => 'codEmpleado',
            ])
            ->addColumn('mesAñoObjetivo', 'date', [
                'null' => false,
                'after' => 'fechaRegistroProgramacion',
            ])
            ->addColumn('codIndicadorActividad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'mesAñoObjetivo',
            ])
            ->addColumn('desviacion', 'float', [
                'null' => true,
                'default' => null,
                'after' => 'codIndicadorActividad',
            ])
            ->addColumn('tasaEjecucion', 'float', [
                'null' => true,
                'default' => null,
                'after' => 'desviacion',
            ])
            ->addColumn('fechaRegistroEjecucion', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'tasaEjecucion',
            ])
            ->addColumn('ejecutada', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'fechaRegistroEjecucion',
            ])
            ->addColumn('esReprogramada', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'ejecutada',
            ])
            ->addIndex(['codEmpleado'], [
                'name' => 'fk_relation_meta_ejecutada_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codIndicadorActividad'], [
                'name' => 'fk_relation_meta_ejecutada_and_indicador_actividad',
                'unique' => false,
            ])
            ->create();
        $this->table('moneda', [
                'id' => false,
                'primary_key' => ['codMoneda'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codMoneda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 10,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codMoneda',
            ])
            ->addColumn('abreviatura', 'string', [
                'null' => false,
                'limit' => 10,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'nombre',
            ])
            ->addColumn('simbolo', 'string', [
                'null' => false,
                'limit' => 10,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'abreviatura',
            ])
            ->create();
        $this->table('nacionalidad', [
                'id' => false,
                'primary_key' => ['codNacionalidad'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codNacionalidad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codNacionalidad',
            ])
            ->addColumn('pais', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'nombre',
            ])
            ->addColumn('abreviacion', 'string', [
                'null' => false,
                'limit' => 10,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'pais',
            ])
            ->create();
        $this->table('numeracion', [
                'id' => false,
                'primary_key' => ['codNumeracion'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codNumeracion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombreDocumento', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codNumeracion',
            ])
            ->addColumn('año', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_SMALL,
                'after' => 'nombreDocumento',
            ])
            ->addColumn('numeroLibreActual', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'año',
            ])
            ->create();
        $this->table('objetivo_especifico', [
                'id' => false,
                'primary_key' => ['codObjEspecifico'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codObjEspecifico', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 600,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codObjEspecifico',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcion',
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_objetivo_especifico_and_proyecto',
                'unique' => false,
            ])
            ->create();
        $this->table('objetivo_estrategico_cedepas', [
                'id' => false,
                'primary_key' => ['codObjetivoEstrategico'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codObjetivoEstrategico', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 1000,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codObjetivoEstrategico',
            ])
            ->addColumn('codPEI', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcion',
            ])
            ->addColumn('item', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codPEI',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'item',
            ])
            ->addIndex(['codPEI'], [
                'name' => 'fk_relation_objetivo_estrategico_cedepas_and_plan_estrategico_in',
                'unique' => false,
            ])
            ->create();
        $this->table('objetivo_milenio', [
                'id' => false,
                'primary_key' => ['codObjetivoMilenio'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codObjetivoMilenio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codObjetivoMilenio',
            ])
            ->addColumn('item', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcion',
            ])
            ->create();
        $this->table('orden_compra', [
                'id' => false,
                'primary_key' => ['codOrdenCompra'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codOrdenCompra', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('señores', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codOrdenCompra',
            ])
            ->addColumn('ruc', 'string', [
                'null' => false,
                'limit' => 13,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'señores',
            ])
            ->addColumn('direccion', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'ruc',
            ])
            ->addColumn('atencion', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'direccion',
            ])
            ->addColumn('referencia', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'atencion',
            ])
            ->addColumn('total', 'float', [
                'null' => false,
                'after' => 'referencia',
            ])
            ->addColumn('partidaPresupuestal', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'total',
            ])
            ->addColumn('observacion', 'string', [
                'null' => false,
                'limit' => 350,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'partidaPresupuestal',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'observacion',
            ])
            ->addColumn('codMoneda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codProyecto',
            ])
            ->addColumn('codEmpleadoCreador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codMoneda',
            ])
            ->addColumn('fechaHoraCreacion', 'datetime', [
                'null' => false,
                'after' => 'codEmpleadoCreador',
            ])
            ->addColumn('codigoCedepas', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fechaHoraCreacion',
            ])
            ->addColumn('codSede', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codigoCedepas',
            ])
            ->addIndex(['codEmpleadoCreador'], [
                'name' => 'fk_relation_orden_compra_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codMoneda'], [
                'name' => 'fk_relation_orden_compra_and_moneda',
                'unique' => false,
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_orden_compra_and_proyecto',
                'unique' => false,
            ])
            ->addIndex(['codSede'], [
                'name' => 'fk_relation_orden_compra_and_sede',
                'unique' => false,
            ])
            ->create();
        $this->table('persona_juridica_poblacion', [
                'id' => false,
                'primary_key' => ['codPersonaJuridica'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codPersonaJuridica', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('ruc', 'string', [
                'null' => false,
                'limit' => 15,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codPersonaJuridica',
            ])
            ->addColumn('razonSocial', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'ruc',
            ])
            ->addColumn('direccion', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'razonSocial',
            ])
            ->addColumn('numeroSociosHombres', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'direccion',
            ])
            ->addColumn('numeroSociosMujeres', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'numeroSociosHombres',
            ])
            ->addColumn('codTipoPersonaJuridica', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'numeroSociosMujeres',
            ])
            ->addColumn('representante', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codTipoPersonaJuridica',
            ])
            ->addIndex(['codTipoPersonaJuridica'], [
                'name' => 'fk_relation_persona_juridica_poblacion_and_tipo_persona_juridica',
                'unique' => false,
            ])
            ->create();
        $this->table('persona_natural_poblacion', [
                'id' => false,
                'primary_key' => ['codPersonaNatural'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codPersonaNatural', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('dni', 'string', [
                'null' => false,
                'limit' => 15,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codPersonaNatural',
            ])
            ->addColumn('nombres', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'dni',
            ])
            ->addColumn('apellidos', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'nombres',
            ])
            ->addColumn('fechaNacimiento', 'date', [
                'null' => false,
                'after' => 'apellidos',
            ])
            ->addColumn('edadMomentanea', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaNacimiento',
            ])
            ->addColumn('sexo', 'char', [
                'null' => true,
                'default' => null,
                'limit' => 1,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'edadMomentanea',
            ])
            ->addColumn('direccion', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 300,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'sexo',
            ])
            ->addColumn('nroTelefono', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 20,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'direccion',
            ])
            ->addColumn('codLugarEjecucion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nroTelefono',
            ])
            ->addIndex(['codLugarEjecucion'], [
                'name' => 'fk_relation_persona_natural_poblacion_and_lugar_ejecucion',
                'unique' => false,
            ])
            ->create();
        $this->table('plan_estrategico_institucional', [
                'id' => false,
                'primary_key' => ['codPEI'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codPEI', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('añoInicio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codPEI',
            ])
            ->addColumn('añoFin', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'añoInicio',
            ])
            ->create();
        $this->table('poblacion_beneficiaria', [
                'id' => false,
                'primary_key' => ['codPoblacionBeneficiaria'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codPoblacionBeneficiaria', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codPoblacionBeneficiaria',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcion',
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_poblacion_beneficiaria_and_proyecto',
                'unique' => false,
            ])
            ->create();
        $this->table('provincia', [
                'id' => false,
                'primary_key' => ['codProvincia'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codProvincia', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codProvincia',
            ])
            ->addColumn('codDepartamento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombre',
            ])
            ->addIndex(['codDepartamento'], [
                'name' => 'fk_relation_provincia_and_departamento',
                'unique' => false,
            ])
            ->create();
        $this->table('proyecto_contador', [
                'id' => false,
                'primary_key' => ['codProyectoContador'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codProyectoContador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codEmpleadoContador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codProyectoContador',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoContador',
            ])
            ->addIndex(['codEmpleadoContador', 'codProyecto'], [
                'name' => 'proy_cont_restriccion_unica',
                'unique' => true,
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_proyecto_contador_and_proyecto',
                'unique' => false,
            ])
            ->create();
        $this->table('relacion_personajuridica_actividad', [
                'id' => false,
                'primary_key' => ['codRelacion'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codRelacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codActividadPrincipal', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codRelacion',
            ])
            ->addColumn('codPersonaJuridica', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codActividadPrincipal',
            ])
            ->addIndex(['codActividadPrincipal'], [
                'name' => 'k_relation_relacion_personajuridica_actividad_and_actividad_prin',
                'unique' => false,
            ])
            ->addIndex(['codPersonaJuridica'], [
                'name' => 'fk_relation_relacion_personajuridica_actividad_and_persona_jurid',
                'unique' => false,
            ])
            ->create();
        $this->table('relacion_personajur_poblacion', [
                'id' => false,
                'primary_key' => ['codRelacionJur'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codRelacionJur', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codPoblacionBeneficiaria', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codRelacionJur',
            ])
            ->addColumn('codPersonaJuridica', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codPoblacionBeneficiaria',
            ])
            ->addIndex(['codPersonaJuridica'], [
                'name' => 'fk_relation_relacion_personajur_poblacion_and_persona_juridica_p',
                'unique' => false,
            ])
            ->addIndex(['codPoblacionBeneficiaria'], [
                'name' => 'fk_relation_relacion_personajur_poblacion_and_poblacion_benefici',
                'unique' => false,
            ])
            ->create();
        $this->table('relacion_personanatural_actividad', [
                'id' => false,
                'primary_key' => ['codRelacion'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codRelacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codActividadPrincipal', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codRelacion',
            ])
            ->addColumn('codPersonaNatural', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codActividadPrincipal',
            ])
            ->addIndex(['codActividadPrincipal'], [
                'name' => 'fk_relation_relacion_personanatural_actividad_and_actividad_prin',
                'unique' => false,
            ])
            ->addIndex(['codPersonaNatural'], [
                'name' => 'fk_relation_relacion_personanatural_actividad_and_persona_natura',
                'unique' => false,
            ])
            ->create();
        $this->table('relacion_personanat_poblacion', [
                'id' => false,
                'primary_key' => ['codRelacionNat'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codRelacionNat', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codPersonaNatural', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codRelacionNat',
            ])
            ->addColumn('codPoblacionBeneficiaria', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codPersonaNatural',
            ])
            ->addIndex(['codPersonaNatural'], [
                'name' => 'fk_relation_relacion_personanat_poblacion_and_persona_natural_po',
                'unique' => false,
            ])
            ->addIndex(['codPoblacionBeneficiaria'], [
                'name' => 'fk_relation_relacion_personanat_poblacion_and_poblacion_benefici',
                'unique' => false,
            ])
            ->create();
        $this->table('relacion_proyecto_objestrategicos', [
                'id' => false,
                'primary_key' => ['codRelacion'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codRelacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codObjetivoEstrategico', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codRelacion',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codObjetivoEstrategico',
            ])
            ->addColumn('porcentajeDeAporte', 'float', [
                'null' => false,
                'after' => 'codProyecto',
            ])
            ->addIndex(['codObjetivoEstrategico'], [
                'name' => 'fk_relation_relacion_proyecto_objestrategicos_and_objetivo_estra',
                'unique' => false,
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_relacion_proyecto_objestrategicos_and_proyecto',
                'unique' => false,
            ])
            ->create();
        $this->table('relacion_proyecto_objmilenio', [
                'id' => false,
                'primary_key' => ['codRelacion'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codRelacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('porcentaje', 'float', [
                'null' => false,
                'after' => 'codRelacion',
            ])
            ->addColumn('codObjetivoMilenio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'porcentaje',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codObjetivoMilenio',
            ])
            ->addIndex(['codObjetivoMilenio'], [
                'name' => 'fk_relation_relacion_proyecto_objmilenio_and_objetivo_milenio',
                'unique' => false,
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_relacion_proyecto_objmilenio_and_proyecto',
                'unique' => false,
            ])
            ->create();
        $this->table('reposicion_gastos', [
                'id' => false,
                'primary_key' => ['codReposicionGastos'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codReposicionGastos', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codEstadoReposicion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codReposicionGastos',
            ])
            ->addColumn('totalImporte', 'float', [
                'null' => true,
                'default' => null,
                'after' => 'codEstadoReposicion',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'totalImporte',
            ])
            ->addColumn('codMoneda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codProyecto',
            ])
            ->addColumn('codigoCedepas', 'string', [
                'null' => false,
                'limit' => 30,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codMoneda',
            ])
            ->addColumn('girarAOrdenDe', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codigoCedepas',
            ])
            ->addColumn('numeroCuentaBanco', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'girarAOrdenDe',
            ])
            ->addColumn('codBanco', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'numeroCuentaBanco',
            ])
            ->addColumn('resumen', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codBanco',
            ])
            ->addColumn('fechaHoraEmision', 'datetime', [
                'null' => false,
                'limit' => 3,
                'after' => 'resumen',
            ])
            ->addColumn('codEmpleadoSolicitante', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraEmision',
            ])
            ->addColumn('codEmpleadoEvaluador', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoSolicitante',
            ])
            ->addColumn('codEmpleadoAdmin', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoEvaluador',
            ])
            ->addColumn('codEmpleadoConta', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoAdmin',
            ])
            ->addColumn('fechaHoraRevisionGerente', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'codEmpleadoConta',
            ])
            ->addColumn('fechaHoraRevisionAdmin', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'fechaHoraRevisionGerente',
            ])
            ->addColumn('fechaHoraRevisionConta', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'fechaHoraRevisionAdmin',
            ])
            ->addColumn('observacion', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fechaHoraRevisionConta',
            ])
            ->addColumn('cantArchivos', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'observacion',
            ])
            ->addColumn('terminacionesArchivos', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'cantArchivos',
            ])
            ->addColumn('fechaHoraRenderizadoVistaCrear', 'datetime', [
                'null' => true,
                'default' => null,
                'limit' => 3,
                'after' => 'terminacionesArchivos',
            ])
            ->addColumn('codigoContrapartida', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fechaHoraRenderizadoVistaCrear',
            ])
            ->addIndex(['codBanco'], [
                'name' => 'fk_relation_reposicion_gastos_and_banco',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoAdmin'], [
                'name' => 'fk_relation_reposicion_gastos_and_empleado_admin',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoConta'], [
                'name' => 'fk_relation_reposicion_gastos_and_empleado_conta',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoEvaluador'], [
                'name' => 'fk_relation_reposicion_gastos_and_empleado_evaluador',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoSolicitante'], [
                'name' => 'fk_relation_reposicion_gastos_and_empleado_solicitante',
                'unique' => false,
            ])
            ->addIndex(['codEstadoReposicion'], [
                'name' => 'fk_relation_reposicion_gastos_and_estado_reposicion_gastos',
                'unique' => false,
            ])
            ->addIndex(['codMoneda'], [
                'name' => 'fk_relation_reposicion_gastos_and_moneda',
                'unique' => false,
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_reposicion_gastos_and_proyecto',
                'unique' => false,
            ])
            ->create();
        $this->table('requerimiento_bs', [
                'id' => false,
                'primary_key' => ['codRequerimiento'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codRequerimiento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codigoCedepas', 'string', [
                'null' => false,
                'limit' => 30,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codRequerimiento',
            ])
            ->addColumn('fechaHoraEmision', 'datetime', [
                'null' => false,
                'after' => 'codigoCedepas',
            ])
            ->addColumn('fechaHoraRevision', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'fechaHoraEmision',
            ])
            ->addColumn('fechaHoraAtendido', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'fechaHoraRevision',
            ])
            ->addColumn('fechaHoraConta', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'fechaHoraAtendido',
            ])
            ->addColumn('codEmpleadoSolicitante', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraConta',
            ])
            ->addColumn('codEmpleadoEvaluador', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoSolicitante',
            ])
            ->addColumn('codEmpleadoAdministrador', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoEvaluador',
            ])
            ->addColumn('codEmpleadoContador', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoAdministrador',
            ])
            ->addColumn('justificacion', 'string', [
                'null' => false,
                'limit' => 350,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codEmpleadoContador',
            ])
            ->addColumn('codEstadoRequerimiento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'justificacion',
            ])
            ->addColumn('cantArchivosEmp', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'codEstadoRequerimiento',
            ])
            ->addColumn('nombresArchivosEmp', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 500,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'cantArchivosEmp',
            ])
            ->addColumn('cantArchivosAdmin', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'nombresArchivosEmp',
            ])
            ->addColumn('nombresArchivosAdmin', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 500,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'cantArchivosAdmin',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombresArchivosAdmin',
            ])
            ->addColumn('observacion', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codProyecto',
            ])
            ->addColumn('cuentaBancariaProveedor', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'observacion',
            ])
            ->addColumn('tieneFactura', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'cuentaBancariaProveedor',
            ])
            ->addColumn('facturaContabilizada', 'integer', [
                'null' => true,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'tieneFactura',
            ])
            ->addColumn('codigoContrapartida', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'facturaContabilizada',
            ])
            ->addIndex(['codEmpleadoAdministrador'], [
                'name' => 'fk_relation_requerimiento_bs_and_empleado_administrador',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoContador'], [
                'name' => 'fk_relation_requerimiento_bs_and_empleado_contador',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoEvaluador'], [
                'name' => 'fk_relation_requerimiento_bs_and_empleado_evaluador',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoSolicitante'], [
                'name' => 'fk_relation_requerimiento_bs_and_empleado_solicitante',
                'unique' => false,
            ])
            ->addIndex(['codEstadoRequerimiento'], [
                'name' => 'fk_relation_requerimiento_bs_and_estado_requerimiento_bs',
                'unique' => false,
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_requerimiento_bs_and_proyecto',
                'unique' => false,
            ])
            ->create();
        $this->table('resultado_esperado', [
                'id' => false,
                'primary_key' => ['codResultadoEsperado'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codResultadoEsperado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codResultadoEsperado',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcion',
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_resultado_esperado_and_proyecto',
                'unique' => false,
            ])
            ->create();
        $this->table('tipo_archivo_proyecto', [
                'id' => false,
                'primary_key' => ['codTipoArchivoProyecto'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoArchivoProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codTipoArchivoProyecto',
            ])
            ->create();
        $this->table('tipo_financiamiento', [
                'id' => false,
                'primary_key' => ['codTipoFinanciamiento'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoFinanciamiento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codTipoFinanciamiento',
            ])
            ->create();
        $this->table('tipo_persona_juridica', [
                'id' => false,
                'primary_key' => ['codTipoPersonaJuridica'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoPersonaJuridica', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codTipoPersonaJuridica',
            ])
            ->addColumn('siglas', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'nombre',
            ])
            ->create();
        $this->table('unidad_medida', [
                'id' => false,
                'primary_key' => ['codUnidadMedida'],
                'engine' => 'InnoDB',
                'encoding' => 'latin1',
                'collation' => 'latin1_swedish_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codUnidadMedida', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codUnidadMedida',
            ])
            ->create();
        $this->table('archivo_general', [
                'id' => false,
                'primary_key' => ['codArchivo'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codArchivo', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombreAparente', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codArchivo',
            ])
            ->addColumn('nombreGuardado', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombreAparente',
            ])
            ->addColumn('codTipoArchivo', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombreGuardado',
            ])
            ->addIndex(['codTipoArchivo'], [
                'name' => 'fk_relation_archivo_general_and_tipo_archivo_general',
                'unique' => false,
            ])
            ->create();
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
        $this->table('banco', [
                'id' => false,
                'primary_key' => ['codBanco'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codBanco', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombreBanco', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codBanco',
            ])
            ->create();
        $this->table('busqueda_repo', [
                'id' => false,
                'primary_key' => ['codBusqueda'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codBusqueda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codBusqueda',
            ])
            ->addColumn('fechaHoraInicioBuscar', 'datetime', [
                'null' => false,
                'limit' => 3,
                'after' => 'codEmpleado',
            ])
            ->addColumn('fechaHoraVerPDF', 'datetime', [
                'null' => true,
                'default' => null,
                'limit' => 3,
                'after' => 'fechaHoraInicioBuscar',
            ])
            ->addIndex(['codEmpleado'], [
                'name' => 'fk_relation_busqueda_repo_and_empleado',
                'unique' => false,
            ])
            ->create();
        $this->table('cdp', [
                'id' => false,
                'primary_key' => ['codTipoCDP'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoCDP', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombreCDP', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoCDP',
            ])
            ->addColumn('codigoSUNAT', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'nombreCDP',
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
            ->addColumn('codigoCedepas', 'string', [
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
                'after' => 'codigoCedepas',
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
                'null' => false,
                'limit' => 1,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'ruc',
            ])
            ->addColumn('fechaHoraGeneracion', 'datetime', [
                'null' => false,
                'after' => 'sexo',
            ])
            ->addColumn('fechaInicio', 'date', [
                'null' => false,
                'after' => 'fechaHoraGeneracion',
            ])
            ->addColumn('fechaFin', 'date', [
                'null' => false,
                'after' => 'fechaInicio',
            ])
            ->addColumn('retribucionTotal', 'float', [
                'null' => false,
                'after' => 'fechaFin',
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
            ->addColumn('provinciaYDepartamento', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codSede',
            ])
            ->addColumn('esDeCedepas', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'provinciaYDepartamento',
            ])
            ->addColumn('esPersonaNatural', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'esDeCedepas',
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
            ->addColumn('codigoCedepas', 'string', [
                'null' => false,
                'limit' => 30,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codContratoPlazo',
            ])
            ->addColumn('nombres', 'string', [
                'null' => false,
                'limit' => 30,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codigoCedepas',
            ])
            ->addColumn('apellidos', 'string', [
                'null' => false,
                'limit' => 30,
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
            ->addColumn('sexo', 'char', [
                'null' => false,
                'limit' => 1,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'dni',
            ])
            ->addColumn('asignacionFamiliar', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'sexo',
            ])
            ->addColumn('fechaHoraGeneracion', 'datetime', [
                'null' => false,
                'after' => 'asignacionFamiliar',
            ])
            ->addColumn('fechaInicio', 'date', [
                'null' => false,
                'after' => 'fechaHoraGeneracion',
            ])
            ->addColumn('fechaFin', 'date', [
                'null' => false,
                'after' => 'fechaInicio',
            ])
            ->addColumn('sueldoBruto', 'float', [
                'null' => false,
                'after' => 'fechaFin',
            ])
            ->addColumn('nombrePuesto', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'sueldoBruto',
            ])
            ->addColumn('codMoneda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombrePuesto',
            ])
            ->addColumn('codSede', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codMoneda',
            ])
            ->addColumn('codTipoContrato', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codSede',
            ])
            ->addColumn('codEmpleadoCreador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codTipoContrato',
            ])
            ->addColumn('nombreFinanciera', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codEmpleadoCreador',
            ])
            ->addColumn('nombreProyecto', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombreFinanciera',
            ])
            ->addColumn('provinciaYDepartamento', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombreProyecto',
            ])
            ->addColumn('fechaHoraAnulacion', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'provinciaYDepartamento',
            ])
            ->addIndex(['codEmpleadoCreador'], [
                'name' => 'fk_relation_contrato_plazo_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codMoneda'], [
                'name' => 'fk_relation_contrato_plazo_and_moneda',
                'unique' => false,
            ])
            ->addIndex(['codSede'], [
                'name' => 'fk_relation_contrato_plazo_and_sede',
                'unique' => false,
            ])
            ->addIndex(['codTipoContrato'], [
                'name' => 'fk_relation_contrato_plazo_and_tipo_contrato',
                'unique' => false,
            ])
            ->create();
        $this->table('detalle_rendicion_gastos', [
                'id' => false,
                'primary_key' => ['codDetalleRendicion'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDetalleRendicion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codRendicionGastos', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codDetalleRendicion',
            ])
            ->addColumn('fecha', 'date', [
                'null' => false,
                'after' => 'codRendicionGastos',
            ])
            ->addColumn('nroComprobante', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'fecha',
            ])
            ->addColumn('concepto', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nroComprobante',
            ])
            ->addColumn('importe', 'float', [
                'null' => false,
                'after' => 'concepto',
            ])
            ->addColumn('codigoPresupuestal', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'importe',
            ])
            ->addColumn('codTipoCDP', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codigoPresupuestal',
            ])
            ->addColumn('terminacionArchivo', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 10,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoCDP',
            ])
            ->addColumn('nroEnRendicion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'terminacionArchivo',
            ])
            ->addColumn('contabilizado', 'integer', [
                'null' => true,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'nroEnRendicion',
            ])
            ->addColumn('pendienteDeVer', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'contabilizado',
            ])
            ->addIndex(['codTipoCDP'], [
                'name' => 'fk_relation_detalle_rendicion_gastos_and_cdp',
                'unique' => false,
            ])
            ->addIndex(['codRendicionGastos'], [
                'name' => 'fk_relation_detalle_rendicion_gastos_and_rendicion_gastos',
                'unique' => false,
            ])
            ->create();
        $this->table('detalle_solicitud_fondos', [
                'id' => false,
                'primary_key' => ['codDetalleSolicitud'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDetalleSolicitud', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codSolicitud', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codDetalleSolicitud',
            ])
            ->addColumn('nroItem', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codSolicitud',
            ])
            ->addColumn('concepto', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nroItem',
            ])
            ->addColumn('importe', 'float', [
                'null' => false,
                'after' => 'concepto',
            ])
            ->addColumn('codigoPresupuestal', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'importe',
            ])
            ->addIndex(['codSolicitud'], [
                'name' => 'fk_relation_detalle_solicitud_fondos_and_solicitud_fondos',
                'unique' => false,
            ])
            ->create();
        $this->table('empleado', [
                'id' => false,
                'primary_key' => ['codEmpleado'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codUsuario', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleado',
            ])
            ->addColumn('codigoCedepas', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codUsuario',
            ])
            ->addColumn('nombres', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codigoCedepas',
            ])
            ->addColumn('apellidos', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombres',
            ])
            ->addColumn('correo', 'string', [
                'null' => false,
                'limit' => 60,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'apellidos',
            ])
            ->addColumn('dni', 'char', [
                'null' => false,
                'limit' => 8,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'correo',
            ])
            ->addColumn('codPuesto', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'dni',
            ])
            ->addColumn('activo', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codPuesto',
            ])
            ->addColumn('fechaRegistro', 'date', [
                'null' => false,
                'after' => 'activo',
            ])
            ->addColumn('fechaDeBaja', 'date', [
                'null' => true,
                'default' => null,
                'after' => 'fechaRegistro',
            ])
            ->addColumn('codSede', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaDeBaja',
            ])
            ->addColumn('sexo', 'char', [
                'null' => false,
                'limit' => 1,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codSede',
            ])
            ->addColumn('fechaNacimiento', 'date', [
                'null' => false,
                'after' => 'sexo',
            ])
            ->addColumn('nombreCargo', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'fechaNacimiento',
            ])
            ->addColumn('direccion', 'string', [
                'null' => false,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombreCargo',
            ])
            ->addColumn('nroTelefono', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'direccion',
            ])
            ->addColumn('codSedeContador', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nroTelefono',
            ])
            ->addColumn('mostrarEnListas', 'integer', [
                'null' => false,
                'default' => '1',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'codSedeContador',
            ])
            ->addIndex(['codPuesto'], [
                'name' => 'fk_relation_empleado_and_puesto',
                'unique' => false,
            ])
            ->addIndex(['codSede'], [
                'name' => 'fk_relation_empleado_and_sede',
                'unique' => false,
            ])
            ->addIndex(['codSedeContador'], [
                'name' => 'fk_relation_empleado_and_sede_contador',
                'unique' => false,
            ])
            ->addIndex(['codUsuario'], [
                'name' => 'fk_relation_empleado_and_usuario',
                'unique' => false,
            ])
            ->create();
        $this->table('empleado_puesto', [
                'id' => false,
                'primary_key' => ['codEmpleadoPuesto'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codEmpleadoPuesto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoPuesto',
            ])
            ->addColumn('codPuesto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleado',
            ])
            ->addIndex(['codEmpleado', 'codPuesto'], [
                'name' => 'emp_puesto_restriccion_unicidad',
                'unique' => true,
            ])
            ->addIndex(['codPuesto'], [
                'name' => 'empleado_puesto-puesto',
                'unique' => false,
            ])
            ->create();
        $this->table('estado_solicitud_fondos', [
                'id' => false,
                'primary_key' => ['codEstadoSolicitud'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codEstadoSolicitud', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codEstadoSolicitud',
            ])
            ->addColumn('ordenListadoEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombre',
            ])
            ->addColumn('ordenListadoGerente', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'ordenListadoEmpleado',
            ])
            ->addColumn('ordenListadoAdministrador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'ordenListadoGerente',
            ])
            ->addColumn('ordenListadoContador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'ordenListadoAdministrador',
            ])
            ->create();
        $this->table('inv-activo_inventario', [
                'id' => false,
                'primary_key' => ['codActivo'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codActivo', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codActivo',
            ])
            ->addColumn('caracteristicas', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombre',
            ])
            ->addColumn('placa', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'caracteristicas',
            ])
            ->addColumn('codCategoriaActivo', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'placa',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codCategoriaActivo',
            ])
            ->addColumn('codEstado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codProyecto',
            ])
            ->addColumn('codEmpleadoResponsable', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEstado',
            ])
            ->addColumn('codSede', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoResponsable',
            ])
            ->addColumn('codRazonBaja', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codSede',
            ])
            ->addColumn('codigoAparente', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codRazonBaja',
            ])
            ->addIndex(['codEmpleadoResponsable'], [
                'name' => 'fk_relation_inv_activo_inventario_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codCategoriaActivo'], [
                'name' => 'fk_relation_inv_activo_inventario_and_inv_categoria_activo_inven',
                'unique' => false,
            ])
            ->addIndex(['codEstado'], [
                'name' => 'fk_relation_inv_activo_inventario_and_inv_estado_activo_inventar',
                'unique' => false,
            ])
            ->addIndex(['codRazonBaja'], [
                'name' => 'fk_relation_inv_activo_inventario_and_inv_razon_baja_activo',
                'unique' => false,
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_inv_activo_inventario_and_proyecto',
                'unique' => false,
            ])
            ->addIndex(['codSede'], [
                'name' => 'fk_relation_inv_activo_inventario_and_sede',
                'unique' => false,
            ])
            ->create();
        $this->table('inv-categoria_activo_inventario', [
                'id' => false,
                'primary_key' => ['codCategoriaActivo'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codCategoriaActivo', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codCategoriaActivo',
            ])
            ->create();
        $this->table('inv-detalle_revision', [
                'id' => false,
                'primary_key' => ['codDetalleRevision'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codDetalleRevision', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codActivo', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codDetalleRevision',
            ])
            ->addColumn('codRevision', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codActivo',
            ])
            ->addColumn('codEstado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codRevision',
            ])
            ->addColumn('fechaHoraUltimoCambio', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'codEstado',
            ])
            ->addColumn('codEmpleadoQueReviso', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraUltimoCambio',
            ])
            ->addColumn('codRazonBaja', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoQueReviso',
            ])
            ->addIndex(['codActivo'], [
                'name' => 'fk_relation_inv_detalle_revision_and_inv_activo_inventario',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoQueReviso'], [
                'name' => 'fk_relation_inv_detalle_revision_and_inv_empleado_revisador',
                'unique' => false,
            ])
            ->addIndex(['codEstado'], [
                'name' => 'fk_relation_inv_detalle_revision_and_inv_estado_activo_inventari',
                'unique' => false,
            ])
            ->addIndex(['codRazonBaja'], [
                'name' => 'fk_relation_inv_detalle_revision_and_inv_razon_baja_activo',
                'unique' => false,
            ])
            ->addIndex(['codRevision'], [
                'name' => 'fk_relation_inv_detalle_revision_and_inv_revision_inventario',
                'unique' => false,
            ])
            ->create();
        $this->table('inv-empleado_revisador', [
                'id' => false,
                'primary_key' => ['codEmpleadoRevisador'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codEmpleadoRevisador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codRevision', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoRevisador',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codRevision',
            ])
            ->addColumn('codSede', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleado',
            ])
            ->addIndex(['codEmpleado'], [
                'name' => 'fk_relation_inv_empleado_revisador_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codRevision'], [
                'name' => 'fk_relation_inv_empleado_revisador_and_inv_revision_inventario',
                'unique' => false,
            ])
            ->addIndex(['codSede'], [
                'name' => 'fk_relation_inv_empleado_revisador_and_sede',
                'unique' => false,
            ])
            ->create();
        $this->table('inv-estado_activo_inventario', [
                'id' => false,
                'primary_key' => ['codEstado'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codEstado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codEstado',
            ])
            ->create();
        $this->table('inv-razon_baja_activo', [
                'id' => false,
                'primary_key' => ['codRazonBaja'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codRazonBaja', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codRazonBaja',
            ])
            ->create();
        $this->table('inv-revision_inventario', [
                'id' => false,
                'primary_key' => ['codRevision'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codRevision', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('fechaHoraInicio', 'datetime', [
                'null' => false,
                'after' => 'codRevision',
            ])
            ->addColumn('fechaHoraCierre', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'fechaHoraInicio',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'fechaHoraCierre',
            ])
            ->addColumn('codEmpleadoResponsable', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcion',
            ])
            ->addColumn('año', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoResponsable',
            ])
            ->addIndex(['codEmpleadoResponsable'], [
                'name' => 'fk_relation_inv_revision_inventario_and_empleado',
                'unique' => false,
            ])
            ->create();
        $this->table('job', [
                'id' => false,
                'primary_key' => ['codJob'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codJob', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codJob',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 1000,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombre',
            ])
            ->addColumn('functionName', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'descripcion',
            ])
            ->addColumn('fechaHoraCreacion', 'datetime', [
                'null' => false,
                'after' => 'functionName',
            ])
            ->addColumn('fechaHoraEjecucion', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'fechaHoraCreacion',
            ])
            ->addColumn('ejecutado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraEjecucion',
            ])
            ->addIndex(['nombre'], [
                'name' => 'nombre_unico',
                'unique' => true,
            ])
            ->create();
        $this->table('mes_anio', [
                'id' => false,
                'primary_key' => ['codMesAño'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codMesAño', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('año', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codMesAño',
            ])
            ->addColumn('codMes', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'año',
            ])
            ->addIndex(['codMes'], [
                'name' => 'fk_relation_mes_anio_and_mes',
                'unique' => false,
            ])
            ->create();
        $this->table('notificacion', [
                'id' => false,
                'primary_key' => ['codNotificacion'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codNotificacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codTipoNotificacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codNotificacion',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoNotificacion',
            ])
            ->addColumn('visto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'descripcion',
            ])
            ->addColumn('link', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'visto',
            ])
            ->addColumn('descripcionAbreviada', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'link',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcionAbreviada',
            ])
            ->addColumn('fechaHoraCreacion', 'datetime', [
                'null' => false,
                'after' => 'codEmpleado',
            ])
            ->addColumn('fechaHoraVisto', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'fechaHoraCreacion',
            ])
            ->addIndex(['codEmpleado'], [
                'name' => 'fk_relation_notificacion_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codTipoNotificacion'], [
                'name' => 'fk_relation_notificacion_and_tipo_notificacion',
                'unique' => false,
            ])
            ->create();
        $this->table('operacion_documento', [
                'id' => false,
                'primary_key' => ['codOperacionDocumento'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codOperacionDocumento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codTipoDocumento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codOperacionDocumento',
            ])
            ->addColumn('codTipoOperacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codTipoDocumento',
            ])
            ->addColumn('codDocumento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codTipoOperacion',
            ])
            ->addColumn('fechaHora', 'datetime', [
                'null' => false,
                'after' => 'codDocumento',
            ])
            ->addColumn('descripcionObservacion', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'fechaHora',
            ])
            ->addColumn('codPuesto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcionObservacion',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codPuesto',
            ])
            ->addIndex(['codEmpleado'], [
                'name' => 'fk_relation_operacion_documento_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codTipoDocumento'], [
                'name' => 'fk_relation_operacion_documento_and_tipo_documento',
                'unique' => false,
            ])
            ->addIndex(['codTipoOperacion'], [
                'name' => 'fk_relation_operacion_documento_and_tipo_operacion',
                'unique' => false,
            ])
            ->addIndex(['codPuesto'], [
                'name' => 'fk_relation_operación_documento_and_puesto',
                'unique' => false,
            ])
            ->create();
        $this->table('parametro_sistema', [
                'id' => false,
                'primary_key' => ['codParametro'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codParametro', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codParametro',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'descripcion',
            ])
            ->addColumn('valor', 'string', [
                'null' => false,
                'limit' => 1000,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombre',
            ])
            ->addColumn('fechaHoraCreacion', 'datetime', [
                'null' => false,
                'after' => 'valor',
            ])
            ->addColumn('fechaHoraBaja', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'fechaHoraCreacion',
            ])
            ->addColumn('fechaHoraActualizacion', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'fechaHoraBaja',
            ])
            ->addColumn('codTipoParametro', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraActualizacion',
            ])
            ->addColumn('modulo', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoParametro',
            ])
            ->addIndex(['codTipoParametro'], [
                'name' => 'fk_relation_parametro_sistema_and_tipo_parametro_sistema',
                'unique' => false,
            ])
            ->create();
        $this->table('proyecto', [
                'id' => false,
                'primary_key' => ['codProyecto'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codigoPresupuestal', 'string', [
                'null' => false,
                'limit' => 5,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codProyecto',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codigoPresupuestal',
            ])
            ->addColumn('codEmpleadoDirector', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombre',
            ])
            ->addColumn('codSedePrincipal', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoDirector',
            ])
            ->addColumn('nombreLargo', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codSedePrincipal',
            ])
            ->addColumn('codEntidadFinanciera', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombreLargo',
            ])
            ->addColumn('codPEI', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEntidadFinanciera',
            ])
            ->addColumn('objetivoGeneral', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codPEI',
            ])
            ->addColumn('fechaInicio', 'date', [
                'null' => false,
                'after' => 'objetivoGeneral',
            ])
            ->addColumn('importePresupuestoTotal', 'float', [
                'null' => false,
                'after' => 'fechaInicio',
            ])
            ->addColumn('importeContrapartidaCedepas', 'float', [
                'null' => false,
                'after' => 'importePresupuestoTotal',
            ])
            ->addColumn('importeContrapartidaPoblacionBeneficiaria', 'float', [
                'null' => false,
                'after' => 'importeContrapartidaCedepas',
            ])
            ->addColumn('importeContrapartidaOtros', 'float', [
                'null' => false,
                'after' => 'importeContrapartidaPoblacionBeneficiaria',
            ])
            ->addColumn('codMoneda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'importeContrapartidaOtros',
            ])
            ->addColumn('codTipoFinanciamiento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codMoneda',
            ])
            ->addColumn('codEstadoProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codTipoFinanciamiento',
            ])
            ->addColumn('fechaFinalizacion', 'date', [
                'null' => false,
                'after' => 'codEstadoProyecto',
            ])
            ->addColumn('importeFinanciamiento', 'float', [
                'null' => false,
                'after' => 'fechaFinalizacion',
            ])
            ->addColumn('contacto_nombres', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'importeFinanciamiento',
            ])
            ->addColumn('contacto_telefono', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'contacto_nombres',
            ])
            ->addColumn('contacto_correo', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'contacto_telefono',
            ])
            ->addColumn('contacto_cargo', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'contacto_correo',
            ])
            ->addIndex(['codTipoFinanciamiento'], [
                'name' => 'fk_relation_proyecto_and_tipo_financiamiento',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoDirector'], [
                'name' => 'fk_relation_proyecto_and_empleado',
                'unique' => false,
            ])
            ->addIndex(['codEntidadFinanciera'], [
                'name' => 'fk_relation_proyecto_and_entidad_financiera',
                'unique' => false,
            ])
            ->addIndex(['codEstadoProyecto'], [
                'name' => 'fk_relation_proyecto_and_estado_proyecto',
                'unique' => false,
            ])
            ->addIndex(['codMoneda'], [
                'name' => 'fk_relation_proyecto_and_moneda',
                'unique' => false,
            ])
            ->addIndex(['codPEI'], [
                'name' => 'fk_relation_proyecto_and_plan_estrategico_institucional',
                'unique' => false,
            ])
            ->addIndex(['codSedePrincipal'], [
                'name' => 'fk_relation_proyecto_and_sede',
                'unique' => false,
            ])
            ->create();
        $this->table('proyecto_observador', [
                'id' => false,
                'primary_key' => ['codProyectoObservador'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codProyectoObservador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codProyectoObservador',
            ])
            ->addColumn('codEmpleadoObservador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codProyecto',
            ])
            ->addIndex(['codProyecto', 'codEmpleadoObservador'], [
                'name' => 'unicidadd',
                'unique' => true,
            ])
            ->addIndex(['codEmpleadoObservador'], [
                'name' => 'empleado',
                'unique' => false,
            ])
            ->create();
        $this->table('puesto', [
                'id' => false,
                'primary_key' => ['codPuesto'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codPuesto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codPuesto',
            ])
            ->addColumn('estado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombre',
            ])
            ->addColumn('nombreAparente', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'estado',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 250,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombreAparente',
            ])
            ->addColumn('ordenListado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcion',
            ])
            ->create();
        $this->table('rendicion_gastos', [
                'id' => false,
                'primary_key' => ['codRendicionGastos'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codRendicionGastos', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codSolicitud', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codRendicionGastos',
            ])
            ->addColumn('codMoneda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codSolicitud',
            ])
            ->addColumn('codigoCedepas', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codMoneda',
            ])
            ->addColumn('totalImporteRecibido', 'float', [
                'null' => true,
                'default' => null,
                'after' => 'codigoCedepas',
            ])
            ->addColumn('totalImporteRendido', 'float', [
                'null' => true,
                'default' => null,
                'after' => 'totalImporteRecibido',
            ])
            ->addColumn('saldoAFavorDeEmpleado', 'float', [
                'null' => true,
                'default' => null,
                'after' => 'totalImporteRendido',
            ])
            ->addColumn('resumenDeActividad', 'string', [
                'null' => false,
                'limit' => 350,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'saldoAFavorDeEmpleado',
            ])
            ->addColumn('codEstadoRendicion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'resumenDeActividad',
            ])
            ->addColumn('fechaHoraRendicion', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'codEstadoRendicion',
            ])
            ->addColumn('fechaHoraRevisado', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'fechaHoraRendicion',
            ])
            ->addColumn('observacion', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'fechaHoraRevisado',
            ])
            ->addColumn('codEmpleadoSolicitante', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'observacion',
            ])
            ->addColumn('codEmpleadoEvaluador', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoSolicitante',
            ])
            ->addColumn('codEmpleadoContador', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoEvaluador',
            ])
            ->addColumn('cantArchivos', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoContador',
            ])
            ->addColumn('terminacionesArchivos', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'cantArchivos',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'terminacionesArchivos',
            ])
            ->addColumn('codigoContrapartida', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codProyecto',
            ])
            ->addIndex(['codEmpleadoContador'], [
                'name' => 'fk_relation_rendicion_gastos_and_empleado_contador',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoEvaluador'], [
                'name' => 'fk_relation_rendicion_gastos_and_empleado_evaluador',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoSolicitante'], [
                'name' => 'fk_relation_rendicion_gastos_and_empleado_solicitante',
                'unique' => false,
            ])
            ->addIndex(['codEstadoRendicion'], [
                'name' => 'fk_relation_rendicion_gastos_and_estado_rendicion_gastos',
                'unique' => false,
            ])
            ->addIndex(['codMoneda'], [
                'name' => 'fk_relation_rendicion_gastos_and_moneda',
                'unique' => false,
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_rendicion_gastos_and_proyecto',
                'unique' => false,
            ])
            ->addIndex(['codSolicitud'], [
                'name' => 'fk_relation_rendicion_gastos_and_solicitud_fondos',
                'unique' => false,
            ])
            ->create();
        $this->table('sede', [
                'id' => false,
                'primary_key' => ['codSede'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codSede', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codSede',
            ])
            ->addColumn('esSedePrincipal', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'nombre',
            ])
            ->addColumn('codEmpleadoAdministrador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'esSedePrincipal',
            ])
            ->addIndex(['codEmpleadoAdministrador'], [
                'name' => 'fk_relation_sede_and_empleado_administrador',
                'unique' => false,
            ])
            ->create();
        $this->table('semestre', [
                'id' => false,
                'primary_key' => ['codSemestre'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codSemestre', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('anio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codSemestre',
            ])
            ->addColumn('numero', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'anio',
            ])
            ->addColumn('fecha_inicio', 'date', [
                'null' => false,
                'after' => 'numero',
            ])
            ->addColumn('fecha_fin', 'date', [
                'null' => false,
                'after' => 'fecha_inicio',
            ])
            ->create();
        $this->table('solicitud_fondos', [
                'id' => false,
                'primary_key' => ['codSolicitud'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codSolicitud', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codProyecto', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codSolicitud',
            ])
            ->addColumn('codigoCedepas', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codProyecto',
            ])
            ->addColumn('codEmpleadoSolicitante', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codigoCedepas',
            ])
            ->addColumn('fechaHoraEmision', 'datetime', [
                'null' => false,
                'after' => 'codEmpleadoSolicitante',
            ])
            ->addColumn('totalSolicitado', 'float', [
                'null' => true,
                'default' => null,
                'after' => 'fechaHoraEmision',
            ])
            ->addColumn('girarAOrdenDe', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'totalSolicitado',
            ])
            ->addColumn('numeroCuentaBanco', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'girarAOrdenDe',
            ])
            ->addColumn('codBanco', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'numeroCuentaBanco',
            ])
            ->addColumn('justificacion', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 350,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codBanco',
            ])
            ->addColumn('codEmpleadoEvaluador', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'justificacion',
            ])
            ->addColumn('fechaHoraRevisado', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'codEmpleadoEvaluador',
            ])
            ->addColumn('codEstadoSolicitud', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraRevisado',
            ])
            ->addColumn('fechaHoraAbonado', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'codEstadoSolicitud',
            ])
            ->addColumn('observacion', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'fechaHoraAbonado',
            ])
            ->addColumn('terminacionArchivo', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 10,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'observacion',
            ])
            ->addColumn('codEmpleadoAbonador', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'terminacionArchivo',
            ])
            ->addColumn('estaRendida', 'integer', [
                'null' => true,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoAbonador',
            ])
            ->addColumn('codEmpleadoContador', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'estaRendida',
            ])
            ->addColumn('codMoneda', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoContador',
            ])
            ->addColumn('codigoContrapartida', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codMoneda',
            ])
            ->addIndex(['codBanco'], [
                'name' => 'fk_relation_solicitud_fondos_and_banco',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoAbonador'], [
                'name' => 'fk_relation_solicitud_fondos_and_empleado_abonador',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoContador'], [
                'name' => 'fk_relation_solicitud_fondos_and_empleado_contador',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoEvaluador'], [
                'name' => 'fk_relation_solicitud_fondos_and_empleado_evaluador',
                'unique' => false,
            ])
            ->addIndex(['codEmpleadoSolicitante'], [
                'name' => 'fk_relation_solicitud_fondos_and_empleado_solicitante',
                'unique' => false,
            ])
            ->addIndex(['codEstadoSolicitud'], [
                'name' => 'fk_relation_solicitud_fondos_and_estado_solicitud_fondos',
                'unique' => false,
            ])
            ->addIndex(['codMoneda'], [
                'name' => 'fk_relation_solicitud_fondos_and_moneda',
                'unique' => false,
            ])
            ->addIndex(['codProyecto'], [
                'name' => 'fk_relation_solicitud_fondos_and_proyecto',
                'unique' => false,
            ])
            ->create();
        $this->table('tipo_archivo_general', [
                'id' => false,
                'primary_key' => ['codTipoArchivo'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoArchivo', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoArchivo',
            ])
            ->create();
        $this->table('tipo_contrato', [
                'id' => false,
                'primary_key' => ['codTipoContrato'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoContrato', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoContrato',
            ])
            ->create();
        $this->table('tipo_documento', [
                'id' => false,
                'primary_key' => ['codTipoDocumento'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoDocumento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoDocumento',
            ])
            ->addColumn('abreviacion', 'string', [
                'null' => false,
                'limit' => 10,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombre',
            ])
            ->create();
        $this->table('tipo_notificacion', [
                'id' => false,
                'primary_key' => ['codTipoNotificacion'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoNotificacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoNotificacion',
            ])
            ->create();
        $this->table('tipo_operacion', [
                'id' => false,
                'primary_key' => ['codTipoOperacion'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoOperacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codTipoDocumento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codTipoOperacion',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoDocumento',
            ])
            ->addIndex(['codTipoDocumento'], [
                'name' => 'fk_relation_tipo_operacion_and_tipo_documento',
                'unique' => false,
            ])
            ->create();
        $this->table('tipo_parametro_sistema', [
                'id' => false,
                'primary_key' => ['codTipoParametro'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoParametro', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoParametro',
            ])
            ->addColumn('componente_frontend', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombre',
            ])
            ->addColumn('comentario', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'componente_frontend',
            ])
            ->create();
        $this->table('usuario', [
                'id' => false,
                'primary_key' => ['codUsuario'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codUsuario', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('usuario', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codUsuario',
            ])
            ->addColumn('password', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'usuario',
            ])
            ->addColumn('isAdmin', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'password',
            ])
            ->create();
        $this->table('migrations', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => '10',
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('migration', 'string', [
                'null' => false,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('batch', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'migration',
            ])
            ->create();
        $this->table('oauth_access_tokens', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
            ])
            ->addColumn('user_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_BIG,
                'signed' => false,
                'after' => 'id',
            ])
            ->addColumn('client_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_BIG,
                'signed' => false,
                'after' => 'user_id',
            ])
            ->addColumn('name', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'client_id',
            ])
            ->addColumn('scopes', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'name',
            ])
            ->addColumn('revoked', 'boolean', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'scopes',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'revoked',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ])
            ->addColumn('expires_at', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'updated_at',
            ])
            ->addIndex(['user_id'], [
                'name' => 'oauth_access_tokens_user_id_index',
                'unique' => false,
            ])
            ->create();
        $this->table('oauth_auth_codes', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
            ])
            ->addColumn('user_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_BIG,
                'signed' => false,
                'after' => 'id',
            ])
            ->addColumn('client_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_BIG,
                'signed' => false,
                'after' => 'user_id',
            ])
            ->addColumn('scopes', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'client_id',
            ])
            ->addColumn('revoked', 'boolean', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'scopes',
            ])
            ->addColumn('expires_at', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'revoked',
            ])
            ->addIndex(['user_id'], [
                'name' => 'oauth_auth_codes_user_id_index',
                'unique' => false,
            ])
            ->create();
        $this->table('oauth_clients', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_BIG,
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('user_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_BIG,
                'signed' => false,
                'after' => 'id',
            ])
            ->addColumn('name', 'string', [
                'null' => false,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'user_id',
            ])
            ->addColumn('secret', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 100,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'name',
            ])
            ->addColumn('provider', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'secret',
            ])
            ->addColumn('redirect', 'text', [
                'null' => false,
                'limit' => 65535,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'provider',
            ])
            ->addColumn('personal_access_client', 'boolean', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'redirect',
            ])
            ->addColumn('password_client', 'boolean', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'personal_access_client',
            ])
            ->addColumn('revoked', 'boolean', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'password_client',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'revoked',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ])
            ->addIndex(['user_id'], [
                'name' => 'oauth_clients_user_id_index',
                'unique' => false,
            ])
            ->create();
        $this->table('oauth_personal_access_clients', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_BIG,
                'signed' => false,
                'identity' => 'enable',
            ])
            ->addColumn('client_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_BIG,
                'signed' => false,
                'after' => 'id',
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'client_id',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ])
            ->create();
        $this->table('oauth_refresh_tokens', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
            ])
            ->addColumn('access_token_id', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('revoked', 'boolean', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'access_token_id',
            ])
            ->addColumn('expires_at', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'revoked',
            ])
            ->addIndex(['access_token_id'], [
                'name' => 'oauth_refresh_tokens_access_token_id_index',
                'unique' => false,
            ])
            ->create();
    }
}
