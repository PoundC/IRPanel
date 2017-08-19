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
        if($userId != 0) {

            $data = $this->request->getData();

            $creditCard = $data['creditcard'];
            $creditExpiration = $data['creditcardexpiration'];

            $usersUtility = new Users();
            $userEntity = $usersUtility->getUserObject($userId);

            if(isset($userEntity)) {

                $authNet = new AuthorizeNet();
                $subscriptionResult = $authNet->createSubscription($userEntity, $creditCard, $creditExpiration);

                $subscriptionTable = TableRegistry::get('users_subscriptions');

                if (($subscriptionResult != null) && ($subscriptionResult->getMessages()->getResultCode() == "Ok")) {

                    $subscriptionEntity = $subscriptionTable->newEntity([
                        'ref_id' => $subscriptionResult->getRefId(),
                        'messages' => $subscriptionResult->getMessages(),
                        'subscription_id' => $subscriptionResult->getSubscriptionId(),
                        'customer_profile_id' => $subscriptionResult->getCustomerProfileId(),
                        'customer_payment_profile_id' => $subscriptionResult->getCustomerPaymentProfileId(),
                        'customer_address_id' => $subscriptionResult->getCustomerAddressId(),
                        'user_id' => $userId
                    ]);
                    $subscriptionTable->save($subscriptionEntity);

                    $usersTable = $usersUtility->getUserTable();
                    $userEntity->set('role', 'member');
                    $usersTable->save($userEntity);

                    $this->Flash->success("SUCCESS: Subscription ID : " . $subscriptionResult->getSubscriptionId());
                }
                else {

                    $this->Flash->error("Response : " . $subscriptionResult->getMessages()->getMessage()[0]->getCode() . "  " . $subscriptionResult->getMessages()->getMessage()[0]->getText());
                }
            }
            else {

                $this->Flash->error('Invalid User Entity');
            }
        }
        else {

            $this->Flash->error('Invalid User ID');
        }

        $this->redirect('/profile');
    }

    public function cancelSubscribe($id = 0)
    {
        $usersUtility = new Users();

        $userRole = $usersUtility->getUserRoleById($this->Auth->user('id'));

        $continue = false;

        if($userRole == 'admin') {

            $userId = $id;
            $continue = true;
        }

        if($this->Auth->user('id') == $id) {

            $userId = $this->Auth->user('id');
            $continue = true;
        }

        if($id != 0) {

            $usersUtility = new Users();
            $userEntity = $usersUtility->findSubscriptionIdByUserId($userId);

            $subscriptionId = $userEntity->subscription->id;

            $authNet = new AuthorizeNet();
            $response = $authNet->cancelSubscription($subscriptionId);

            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
            {
                $successMessages = $response->getMessages()->getMessage();

                $userEntity->set('role', 'user');
                $usersTable = $usersUtility->getUserTable();
                $usersTable->save($userEntity);

                $this->Flash->success("SUCCESS : " . $successMessages[0]->getCode() . "  " .$successMessages[0]->getText());
            }
            else
            {
                $errorMessages = $response->getMessages()->getMessage();

                $this->Flash->error("Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText());
            }
        }
        else {

            $this->Flash->error('Invalid User ID');
        }

        $this->redirect('/profile');
    }
}