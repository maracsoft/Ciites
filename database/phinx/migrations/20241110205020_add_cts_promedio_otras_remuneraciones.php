<?php

use Phinx\Db\Adapter\MysqlAdapter;

class AddCtsPromedioOtrasRemuneraciones extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->execute('SET unique_checks=0; SET foreign_key_checks=0;');
        $this->table('constancia_deposito_cts', [
                'id' => false,
                'primary_key' => ['codConstancia'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('promedio_otras_remuneraciones', 'float', [
                'null' => false,
                'after' => 'nombre_banco',
            ])
            ->save();
        $this->execute('SET unique_checks=1; SET foreign_key_checks=1;');
    }
}
