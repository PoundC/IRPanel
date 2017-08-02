<?php
use Migrations\AbstractMigration;

class FAQ extends AbstractMigration
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
        $table = $this->table('faq_topics');
        $table->addColumn('topic', 'string', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();

        $table = $this->table('faq_answers');
        $table->addColumn('faq_topic_id', 'string', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('subject', 'string', [
            'default' => null,
            'limit' => 1024,
            'null' => false,
        ]);
        $table->addColumn('answer', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();

        $table = $this->table('faq_questions');
        $table->addColumn('faq_answer_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('question', 'string', [
            'default' => null,
            'limit' =>1024,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();

        $table = $this->table('faq_tags');
        $table->addColumn('tag', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();

        $table = $this->table('faq_answer_tags');
        $table->addColumn('faq_answer_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('faq_tag_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();

    }
}
