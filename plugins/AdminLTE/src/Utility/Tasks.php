<?php

namespace AdminLTE\Utility;

use Cake\ORM\TableRegistry;

class Tasks
{
    const Success = 'Success';
    const Info = 'Info';
    const Warning = 'Warning';
    const Danger = 'Danger';

    public static function getTasksTable()
    {
        return TableRegistry::get('AdminLTE.admin_l_t_e_tasks');
    }

    // Add Pending Task
    public static function addPendingTask($user_id, $title, $message, $link, $icon, $color, $button_text)
    {
        $tasksTable = self::getTasksTable();
        $taskEntity = $tasksTable->newEntity([
            'user_id' => $user_id,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'icon' => $icon,
            'color' => $color,
            'button_text' => $button_text,
            'seen' => 0,
            'completed' => 0,
            'created' => new \DateTime('now'),
            'modified' => new \DateTime('now')
        ]);
        $tasksTable->save($taskEntity);
    }

    // Mark Pending Task Seen
    public static function markPendingTaskSeen($task_id)
    {
        $tasksTable = self::getTasksTable();
        $task = $tasksTable->find('all')->where(['id' => $task_id])->first();
        $task->set('seen', 1);
        $tasksTable->save($task);
    }

    // Mark Pending Task Completed
    public static function markPendingTaskCompleted($task_id)
    {
        $tasksTable = self::getTasksTable();
        $task = $tasksTable->find('all')->where(['id' => $task_id])->first();
        $task->set('completed', 1);
        $tasksTable->save($task);
    }

    // Mark Pending Task Deleted
    public static function markPendingTaskDeleted($task_id)
    {
        $tasksTable = self::getTasksTable();
        $task = $tasksTable->find('all')->where(['id' => $task_id])->first();
        $task->set('completed', 2);
        $tasksTable->save($task);
    }
}
