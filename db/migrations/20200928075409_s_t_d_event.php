<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class STDEvent extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('std_events', ['id' => false, 'primary_key' => ['STD_EVENT_CODE']]);
        $table->addColumn('STD_EVENT_CODE', 'integer')
            ->addColumn('STD_EVENT_NAME', 'string', ['limit' => 255, 'null' => true])
            ->addIndex(['STD_EVENT_CODE'], ['unique' => true])
            ->create();
    }
}
