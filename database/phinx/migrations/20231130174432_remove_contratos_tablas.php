<?php

use Phinx\Db\Adapter\MysqlAdapter;

class RemoveContratosTablas extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('avance_entregable')->drop()->save();
        $this->table('contrato_locacion')->drop()->save();
        $this->table('contrato_plazo')->drop()->save();
    }
}
