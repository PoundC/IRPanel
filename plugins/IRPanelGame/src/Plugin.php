<?php

namespace IRPanelGame;

use IRPanel\Core\AbstractPlugin;
use Cake\ORM\TableRegistry;
use Phergie\Irc\Bot\React\EventQueueInterface;
use Phergie\Irc\Plugin\React\Command\CommandEvent;
use IRPanel\Utility\Database;

/**
 * Plugin for IRPanelQuotes
 */
class Plugin extends AbstractPlugin
{
    // Get Cash by Working
    // Spend Cash (Buy Items, Animals, People, Properties)
    // Use Items to Power Up Commands (Work, Buy, Use, Sex, Fight, Hack, Steal, Smack, Visit)
    // Sex Animals/People to Create Mutants/Offspring and Earn Points
    // Fight Animals/People to Earn Cash and Points
    // Hack Shit to Earn Cash and Points and Advantages Over Items, Animals, People, Properties
    // Steal Cash, Items, Animals, People, Properties
    // Smack Another User To Start Shit
    // Visit Properties, People, Animals to Earn Cash, Points, and Advantages

    public function getSubscribedEvents()
    {
        if (!$this->connection) {
            return [];
        }
        return [
            'command.work' => 'handleWork'
        ];
    }

    public function handleWork(CommandEvent $event, EventQueueInterface $queue)
    {

    }
}
