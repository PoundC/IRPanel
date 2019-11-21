<?php
use Migrations\AbstractMigration;

class AddMediaGalleries extends AbstractMigration
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
        $table = $this->table('i_r_c_media_galleries');
        $table->addColumn('i_r_c_media_id', 'integer');
        $table->addColumn('media_url', 'string', [
            'default' => '',
            'limit' => 3000,
            'null' => false
        ]);
        $table->addColumn('media_type', 'string', [
            'limit' => 16
        ]);
        $table->create();
    }
}
