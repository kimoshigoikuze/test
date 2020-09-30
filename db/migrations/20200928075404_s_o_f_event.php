<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SOFEvent extends AbstractMigration
{
    public function change(): void
    {

        $table = $this->table('sof_events');
        $table->addColumn('SOF_ID', 'integer')
            ->addColumn('ORIGINAL_EVENT', 'text', ['null' => true])
            ->addColumn('STD_EVENT_CODE', 'integer')
            ->addColumn('DATE_TIME', 'datetime')
            ->create();
    }
}