<?php

use Phinx\Seed\AbstractSeed;
include_once('db/xls/XlsReader.php');

class SOFSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $seeds = XlsReader::getFormattedDataForPage(2);
        $posts = $this->table('sofs');
        $posts->insert($seeds)
            ->save();

    }
}
