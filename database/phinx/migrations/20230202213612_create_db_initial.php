<?php

use Phinx\Db\Adapter\MysqlAdapter;

class CreateDbInitial extends Phinx\Migration\AbstractMigration
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
                'after' => 'codEntidadFinanciera',
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
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'estadoError',
            ])
            ->addColumn('solucion', 'string', [
                'null' => true,
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
                'after' => 'formulario',
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
                'after' => 'codIndicadorActividad',
            ])
            ->addColumn('tasaEjecucion', 'float', [
                'null' => true,
                'after' => 'desviacion',
            ])
            ->addColumn('fechaRegistroEjecucion', 'datetime', [
                'null' => true,
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
                'limit' => 1,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'edadMomentanea',
            ])
            ->addColumn('direccion', 'string', [
                'null' => true,
                'limit' => 300,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'sexo',
            ])
            ->addColumn('nroTelefono', 'string', [
                'null' => true,
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
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoSolicitante',
            ])
            ->addColumn('codEmpleadoAdmin', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoEvaluador',
            ])
            ->addColumn('codEmpleadoConta', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoAdmin',
            ])
            ->addColumn('fechaHoraRevisionGerente', 'datetime', [
                'null' => true,
                'after' => 'codEmpleadoConta',
            ])
            ->addColumn('fechaHoraRevisionAdmin', 'datetime', [
                'null' => true,
                'after' => 'fechaHoraRevisionGerente',
            ])
            ->addColumn('fechaHoraRevisionConta', 'datetime', [
                'null' => true,
                'after' => 'fechaHoraRevisionAdmin',
            ])
            ->addColumn('observacion', 'string', [
                'null' => true,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fechaHoraRevisionConta',
            ])
            ->addColumn('cantArchivos', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'observacion',
            ])
            ->addColumn('terminacionesArchivos', 'string', [
                'null' => true,
                'limit' => 100,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'cantArchivos',
            ])
            ->addColumn('fechaHoraRenderizadoVistaCrear', 'datetime', [
                'null' => true,
                'limit' => 3,
                'after' => 'terminacionesArchivos',
            ])
            ->addColumn('codigoContrapartida', 'string', [
                'null' => true,
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'fechaHoraRenderizadoVistaCrear',
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
                'after' => 'fechaHoraEmision',
            ])
            ->addColumn('fechaHoraAtendido', 'datetime', [
                'null' => true,
                'after' => 'fechaHoraRevision',
            ])
            ->addColumn('fechaHoraConta', 'datetime', [
                'null' => true,
                'after' => 'fechaHoraAtendido',
            ])
            ->addColumn('codEmpleadoSolicitante', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraConta',
            ])
            ->addColumn('codEmpleadoEvaluador', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoSolicitante',
            ])
            ->addColumn('codEmpleadoAdministrador', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoEvaluador',
            ])
            ->addColumn('codEmpleadoContador', 'integer', [
                'null' => true,
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
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'codEstadoRequerimiento',
            ])
            ->addColumn('nombresArchivosEmp', 'string', [
                'null' => true,
                'limit' => 500,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'cantArchivosEmp',
            ])
            ->addColumn('cantArchivosAdmin', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'nombresArchivosEmp',
            ])
            ->addColumn('nombresArchivosAdmin', 'string', [
                'null' => true,
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
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'codProyecto',
            ])
            ->addColumn('cuentaBancariaProveedor', 'string', [
                'null' => true,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'observacion',
            ])
            ->addColumn('tieneFactura', 'integer', [
                'null' => true,
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
                'limit' => 200,
                'collation' => 'latin1_swedish_ci',
                'encoding' => 'latin1',
                'after' => 'facturaContabilizada',
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
                'limit' => 3,
                'after' => 'fechaHoraInicioBuscar',
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
        $this->table('cite-actividad', [
                'id' => false,
                'primary_key' => ['codActividad'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codActividad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codActividad',
            ])
            ->addColumn('codTipoServicio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombre',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 1000,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoServicio',
            ])
            ->addColumn('indice', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'descripcion',
            ])
            ->create();
        $this->table('cite-archivo_servicio', [
                'id' => false,
                'primary_key' => ['codArchivoServicio'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codArchivoServicio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codArchivo', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codArchivoServicio',
            ])
            ->addColumn('codServicio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codArchivo',
            ])
            ->create();
        $this->table('cite-asistencia_servicio', [
                'id' => false,
                'primary_key' => ['codAsistenciaServicio'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codAsistenciaServicio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codUsuario', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codAsistenciaServicio',
            ])
            ->addColumn('codServicio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codUsuario',
            ])
            ->addColumn('externo', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codServicio',
            ])
            ->addIndex(['codUsuario', 'codServicio'], [
                'name' => 'unique_asistencia_cite',
                'unique' => true,
            ])
            ->create();
        $this->table('cite-cadena', [
                'id' => false,
                'primary_key' => ['codCadena'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codCadena', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codCadena',
            ])
            ->create();
        $this->table('cite-clasificacion_rango_ventas', [
                'id' => false,
                'primary_key' => ['codClasificacion'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codClasificacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codClasificacion',
            ])
            ->addColumn('minimo', 'float', [
                'null' => false,
                'after' => 'nombre',
            ])
            ->addColumn('maximo', 'float', [
                'null' => false,
                'after' => 'minimo',
            ])
            ->create();
        $this->table('cite-estado_documento', [
                'id' => false,
                'primary_key' => ['codEstadoDocumento'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codEstadoDocumento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codEstadoDocumento',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombre',
            ])
            ->create();
        $this->table('cite-estado_reporte_mensual', [
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
            ->addColumn('explicacion', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombre',
            ])
            ->addColumn('icono', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'explicacion',
            ])
            ->addColumn('claseBoton', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'icono',
            ])
            ->create();
        $this->table('cite-modalidad_servicio', [
                'id' => false,
                'primary_key' => ['codModalidad'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codModalidad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codModalidad',
            ])
            ->create();
        $this->table('cite-relacion_usuario_unidad', [
                'id' => false,
                'primary_key' => ['codRelacionUsuarioUnidad'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codRelacionUsuarioUnidad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codUsuario', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codRelacionUsuarioUnidad',
            ])
            ->addColumn('codUnidadProductiva', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codUsuario',
            ])
            ->addIndex(['codUsuario', 'codUnidadProductiva'], [
                'name' => 'unique_usuario_unidad_productiva_cite',
                'unique' => true,
            ])
            ->create();
        $this->table('cite-reporte_mensual', [
                'id' => false,
                'primary_key' => ['codReporte'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codReporte', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('año', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codReporte',
            ])
            ->addColumn('codMes', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'año',
            ])
            ->addColumn('codEmpleado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codMes',
            ])
            ->addColumn('comentario', 'string', [
                'null' => true,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codEmpleado',
            ])
            ->addColumn('fechaHoraMarcacion', 'datetime', [
                'null' => true,
                'after' => 'comentario',
            ])
            ->addColumn('debeReportar', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraMarcacion',
            ])
            ->addColumn('codEstado', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'debeReportar',
            ])
            ->addColumn('observacion', 'string', [
                'null' => true,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codEstado',
            ])
            ->create();
        $this->table('cite-servicio', [
                'id' => false,
                'primary_key' => ['codServicio'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codServicio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codUnidadProductiva', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codServicio',
            ])
            ->addColumn('codTipoServicio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codUnidadProductiva',
            ])
            ->addColumn('descripcion', 'string', [
                'null' => false,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoServicio',
            ])
            ->addColumn('codMesAño', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'descripcion',
            ])
            ->addColumn('cantidadServicio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codMesAño',
            ])
            ->addColumn('totalParticipantes', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'cantidadServicio',
            ])
            ->addColumn('nroHorasEfectivas', 'float', [
                'null' => false,
                'after' => 'totalParticipantes',
            ])
            ->addColumn('fechaInicio', 'date', [
                'null' => false,
                'after' => 'nroHorasEfectivas',
            ])
            ->addColumn('fechaTermino', 'date', [
                'null' => false,
                'after' => 'fechaInicio',
            ])
            ->addColumn('codTipoAcceso', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaTermino',
            ])
            ->addColumn('codDistrito', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codTipoAcceso',
            ])
            ->addColumn('codModalidad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codDistrito',
            ])
            ->addColumn('fechaHoraCreacion', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codModalidad',
            ])
            ->addColumn('codTipoCDP', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraCreacion',
            ])
            ->addColumn('nroComprobante', 'string', [
                'null' => true,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoCDP',
            ])
            ->addColumn('baseImponible', 'float', [
                'null' => true,
                'after' => 'nroComprobante',
            ])
            ->addColumn('igv', 'float', [
                'null' => true,
                'after' => 'baseImponible',
            ])
            ->addColumn('total', 'float', [
                'null' => true,
                'after' => 'igv',
            ])
            ->addColumn('codEmpleadoCreador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'total',
            ])
            ->addColumn('codActividad', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoCreador',
            ])
            ->create();
        $this->table('cite-tipo_acceso', [
                'id' => false,
                'primary_key' => ['codTipoAcceso'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoAcceso', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoAcceso',
            ])
            ->create();
        $this->table('cite-tipo_personeria', [
                'id' => false,
                'primary_key' => ['codTipoPersoneria'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoPersoneria', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoPersoneria',
            ])
            ->addColumn('letra', 'string', [
                'null' => false,
                'limit' => 5,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombre',
            ])
            ->create();
        $this->table('cite-tipo_servicio', [
                'id' => false,
                'primary_key' => ['codTipoServicio'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codTipoServicio', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('nombre', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codTipoServicio',
            ])
            ->create();
        $this->table('cite-unidad_productiva', [
                'id' => false,
                'primary_key' => ['codUnidadProductiva'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codUnidadProductiva', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('ruc', 'string', [
                'null' => true,
                'limit' => 50,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codUnidadProductiva',
            ])
            ->addColumn('razonSocial', 'string', [
                'null' => true,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'ruc',
            ])
            ->addColumn('dni', 'string', [
                'null' => true,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'razonSocial',
            ])
            ->addColumn('nombrePersona', 'string', [
                'null' => true,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'dni',
            ])
            ->addColumn('codTipoPersoneria', 'string', [
                'null' => false,
                'limit' => 11,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombrePersona',
            ])
            ->addColumn('fechaHoraCreacion', 'datetime', [
                'null' => true,
                'after' => 'codTipoPersoneria',
            ])
            ->addColumn('direccion', 'string', [
                'null' => true,
                'limit' => 500,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'fechaHoraCreacion',
            ])
            ->addColumn('codDistrito', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'direccion',
            ])
            ->addColumn('codClasificacion', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codDistrito',
            ])
            ->addColumn('nroServiciosHistorico', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codClasificacion',
            ])
            ->addColumn('codCadena', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nroServiciosHistorico',
            ])
            ->addColumn('codEstadoDocumento', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codCadena',
            ])
            ->addColumn('enTramite', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'codEstadoDocumento',
            ])
            ->addColumn('codEmpleadoCreador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'enTramite',
            ])
            ->addColumn('tieneCadena', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoCreador',
            ])
            ->addColumn('codUsuarioGerente', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'tieneCadena',
            ])
            ->addColumn('codUsuarioPresidente', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codUsuarioGerente',
            ])
            ->create();
        $this->table('cite-usuario', [
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
            ->addColumn('dni', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codUsuario',
            ])
            ->addColumn('nombres', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'dni',
            ])
            ->addColumn('apellidoPaterno', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombres',
            ])
            ->addColumn('apellidoMaterno', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'apellidoPaterno',
            ])
            ->addColumn('telefono', 'string', [
                'null' => true,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'apellidoMaterno',
            ])
            ->addColumn('correo', 'string', [
                'null' => true,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'telefono',
            ])
            ->addColumn('fechaHoraCreacion', 'datetime', [
                'null' => true,
                'after' => 'correo',
            ])
            ->addColumn('fechaHoraActualizacion', 'datetime', [
                'null' => true,
                'after' => 'fechaHoraCreacion',
            ])
            ->addColumn('codEmpleadoCreador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraActualizacion',
            ])
            ->addIndex(['dni'], [
                'name' => 'unique_dni_cite_usuario',
                'unique' => true,
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
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'esPersonaNatural',
            ])
            ->addColumn('nombreDelCargoPJ', 'string', [
                'null' => true,
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
                'after' => 'nombreFinanciera',
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
                'after' => 'provinciaYDepartamento',
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
                'after' => 'fechaRegistro',
            ])
            ->addColumn('codSede', 'integer', [
                'null' => true,
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
                'after' => 'codEstado',
            ])
            ->addColumn('codEmpleadoQueReviso', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraUltimoCambio',
            ])
            ->addColumn('codRazonBaja', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoQueReviso',
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
        $this->table('mes_a??o', [
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
                'after' => 'fechaHoraCreacion',
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
                'after' => 'fechaHoraCreacion',
            ])
            ->addColumn('fechaHoraActualizacion', 'datetime', [
                'null' => true,
                'after' => 'fechaHoraBaja',
            ])
            ->addColumn('codTipoParametro', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraActualizacion',
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
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nombre',
            ])
            ->addColumn('codSedePrincipal', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoDirector',
            ])
            ->addColumn('nombreLargo', 'string', [
                'null' => true,
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
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'importeFinanciamiento',
            ])
            ->addColumn('contacto_telefono', 'string', [
                'null' => true,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'contacto_nombres',
            ])
            ->addColumn('contacto_correo', 'string', [
                'null' => true,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'contacto_telefono',
            ])
            ->addColumn('contacto_cargo', 'string', [
                'null' => true,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'contacto_correo',
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
                'after' => 'codigoCedepas',
            ])
            ->addColumn('totalImporteRendido', 'float', [
                'null' => true,
                'after' => 'totalImporteRecibido',
            ])
            ->addColumn('saldoAFavorDeEmpleado', 'float', [
                'null' => true,
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
                'after' => 'codEstadoRendicion',
            ])
            ->addColumn('fechaHoraRevisado', 'datetime', [
                'null' => true,
                'after' => 'fechaHoraRendicion',
            ])
            ->addColumn('observacion', 'string', [
                'null' => true,
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
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoSolicitante',
            ])
            ->addColumn('codEmpleadoContador', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoEvaluador',
            ])
            ->addColumn('cantArchivos', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codEmpleadoContador',
            ])
            ->addColumn('terminacionesArchivos', 'string', [
                'null' => true,
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
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codProyecto',
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
                'limit' => 350,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codBanco',
            ])
            ->addColumn('codEmpleadoEvaluador', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'justificacion',
            ])
            ->addColumn('fechaHoraRevisado', 'datetime', [
                'null' => true,
                'after' => 'codEmpleadoEvaluador',
            ])
            ->addColumn('codEstadoSolicitud', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraRevisado',
            ])
            ->addColumn('fechaHoraAbonado', 'datetime', [
                'null' => true,
                'after' => 'codEstadoSolicitud',
            ])
            ->addColumn('observacion', 'string', [
                'null' => true,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'fechaHoraAbonado',
            ])
            ->addColumn('terminacionArchivo', 'string', [
                'null' => true,
                'limit' => 10,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'observacion',
            ])
            ->addColumn('codEmpleadoAbonador', 'integer', [
                'null' => true,
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
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codMoneda',
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
                'limit' => MysqlAdapter::INT_BIG,
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
        $this->table('failed_jobs', [
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
            ->addColumn('connection', 'text', [
                'null' => false,
                'limit' => 65535,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('queue', 'text', [
                'null' => false,
                'limit' => 65535,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'connection',
            ])
            ->addColumn('payload', 'text', [
                'null' => false,
                'limit' => MysqlAdapter::TEXT_LONG,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'queue',
            ])
            ->addColumn('exception', 'text', [
                'null' => false,
                'limit' => MysqlAdapter::TEXT_LONG,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'payload',
            ])
            ->addColumn('failed_at', 'timestamp', [
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP',
                'after' => 'exception',
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
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'client_id',
            ])
            ->addColumn('scopes', 'text', [
                'null' => true,
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
                'after' => 'revoked',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
                'after' => 'created_at',
            ])
            ->addColumn('expires_at', 'datetime', [
                'null' => true,
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
                'limit' => 100,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'name',
            ])
            ->addColumn('provider', 'string', [
                'null' => true,
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
                'after' => 'revoked',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
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
                'after' => 'client_id',
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
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
                'after' => 'revoked',
            ])
            ->addIndex(['access_token_id'], [
                'name' => 'oauth_refresh_tokens_access_token_id_index',
                'unique' => false,
            ])
            ->create();
    }
}
