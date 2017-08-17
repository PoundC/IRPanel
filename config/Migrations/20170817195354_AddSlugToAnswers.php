<?php
use Migrations\AbstractMigration;

class AddSlugToAnswers extends AbstractMigration
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
        $table = $this->table('faq_answers');
        $table->addColumn('slug', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->update();
    }
}
