<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SOF extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('sofs');
        $table->addColumn('DAD_DA_Reference', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('MODIFIED_DTG', 'datetime')
            ->create();

    }

}
