<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/18/17
 * Time: 11:23 AM
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;
use App\Utility\Generator;
use Cake\Utility\Text;
use DateTime;
use DateTimeZone;
use App\Utility\AuthorizeNet;
use App\Utility\Users;

class BillingController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function subscribe($userId = 0)
    {
        if($userId > 0) {

            $data = $this->request->getData();

            $creditCard = $data['creditcard'];
            $creditExpiration = $data['creditcardexpiration'];

            $usersUtility = new Users();
            $userEntity = $usersUtility->getUserObject($userId);

            $authNet = new AuthorizeNet();
            $subscriptionResult = $authNet->createSubscription($userEntity, $creditCard, $creditExpiration);

            if (($subscriptionResult != null) && ($subscriptionResult->getMessages()->getResultCode() == "Ok") )
            {
                echo "SUCCESS: Subscription ID : " . $subscriptionResult->getSubscriptionId() . "\n";
            }
            else
            {
                echo "ERROR :  Invalid response\n";
                echo "Response : " . $subscriptionResult->getMessages()->getMessage()[0]->getCode() . "  " .$subscriptionResult->getMessages()->getMessage()[0]->getText() . "\n";
            }
        }
    }

    public function cancelSubscribe($id = 0)
    {
        print_r($id); die();
        if($id == 0) {

            $userId = $this->Auth->user('id');
        }
        else {

            $userId = $id;
        }

        $usersUtility = new Users();
        $userEntity = $usersUtility->getUserObject($userId);

        $authNet = new AuthorizeNet();
        $authNet->cancelSubscription($userEntity);


    }
}