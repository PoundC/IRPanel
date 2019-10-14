<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/18/17
 * Time: 11:23 AM
 */

namespace AdminLTE\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;
use AdminLTE\Utility\Generator;
use Cake\Utility\Text;
use DateTime;
use DateTimeZone;
use AdminLTE\Utility\AuthorizeNet;
use AdminLTE\Utility\Users;

class BillingController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function dashboard()
    {

    }

    public function subscriptions()
    {
        $this->loadModel('AdminLTE.UsersSubscriptions');
        $usersSubscriptionsQuery = $this->UsersSubscriptions->find('all', ['contain' => ['Users']]);
        $usersSubscriptions = $this->paginate($usersSubscriptionsQuery);

        $this->set(compact('usersSubscriptions'));
        $this->set('_serialize', ['usersSubscriptions']);

        $this->set('title', 'View Subscriptions');
    }

    public function history($subscription_id)
    {
        $this->loadModel('AdminLTE.UsersSubscriptionsHistory');

        $usersSubscriptionsQuery = $this->UsersSubscriptionsHistory->find('all', ['contain' => ['users_subscriptions', 'users_subscriptions.Users']]);
        $usersSubscriptions = $this->paginate($usersSubscriptionsQuery);

        $this->set(compact('usersSubscriptionsHistory'));
        $this->set('_serialize', ['usersSubscriptionsHistory']);

        $this->set('title', 'View Subscription History');
    }

    public function subscribe($userId = '0')
    {
        if($userId != '0') {

            $data = $this->request->getData();

            $creditCard = $data['creditcardNumber'];
            $creditExpiration = $data['creditcardExpiration'];

            $usersUtility = new Users();
            $userEntity = $usersUtility->getUserObject($userId);

            if(isset($userEntity)) {

                $authNet = new AuthorizeNet();

                //@todo: database driven pricing
                $totalPrice = '10.29';

                //@todo: specify monthly or yearly payments
                $subscriptionResult = $authNet->createSubscription($data['first_name'], $data['last_name'], $creditCard, $creditExpiration);

                $this->loadModel('AdminLTE.UsersSubscriptions');

                if (($subscriptionResult != null) && ($subscriptionResult->getMessages()->getResultCode() == "Ok")) {

                    $subscriptionEntity = $this->UsersSubscriptions->newEntity([
                        'ref_id' => $subscriptionResult->getRefId(),
                        'messages' => $subscriptionResult->getMessages(),
                        'subscription_id' => $subscriptionResult->getSubscriptionId(),
                        'customer_profile_id' => '0',
                        'customer_payment_profile_id' => '0',
                        'customer_address_id' => '0',
                        'user_id' => $userId,
                        'price' => $totalPrice,
                        'created' => new \DateTime('now')
                    ]);
                    $this->UsersSubscriptions->save($subscriptionEntity);

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

    public function cancel($id = '0')
    {
        $usersUtility = new Users();

        $userRole = $usersUtility->getUserRoleById($this->Auth->user('id'));

        $continue = false;

        $userId = '0';

        if($userRole == 'admin') {

            $userId = $id;
            $continue = true;
        }

        if($this->Auth->user('id') == $id) {

            $userId = $this->Auth->user('id');
            $continue = true;
        }

        if($userId != '0' && $continue == true) {

            $usersUtility = new Users();
            $userEntity = $usersUtility->getUserById($userId);
            $subscriptionId = $usersUtility->findSubscriptionIdByUserId($userId);

            $authNet = new AuthorizeNet();
            $response = $authNet->cancelSubscription($subscriptionId);

            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
            {
                $successMessages = $response->getMessages()->getMessage();

                $userEntity->set('role', 'user');
                $usersTable = $usersUtility->getUserTable();
                $usersTable->save($userEntity);

                $this->Flash->success("SUCCESS : Canceled Subscription! - " . $successMessages[0]->getCode() . "  " .$successMessages[0]->getText());
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
