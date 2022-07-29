<?php
use Migrations\AbstractMigration;

class FirstTest extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('tests');
	$table->addColumn('test2', 'text', [
	            'default' => null,
	            'null' => false,
	        ]);
	$table->addColumn('test3', 'integer', [
	            'default' => null,
	            'null' => false,
	        ]);
	$table->addColumn('test4', 'string', [
	            'default' => null,
	            'limit' => 255,
	            'null' => false,
	        ]);
	$table->create();
    }
}