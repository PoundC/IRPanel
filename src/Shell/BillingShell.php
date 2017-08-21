<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/18/17
 * Time: 12:55 PM
 */

namespace App\Shell;

use Aura\Intl\Exception;
use Cake\ORM\TableRegistry;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Cake\Core\Configure;
use App\Utility\Users;

define("AUTHORIZENET_LOG_FILE", "phplog");

/**
 * Get and Update Member Subscription Statuses
 */
class BillingShell extends CronjobShell
{
    public function main()
    {
        try {

            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName(Configure::read('Merchants.MERCHANT_LOGIN_ID'));
            $merchantAuthentication->setTransactionKey(Configure::read('Merchants.MERCHANT_TRANSACTION_KEY'));

            // Set the transaction's refId
            $refId = 'ref' . time();

            $sorting = new AnetAPI\ARBGetSubscriptionListSortingType();
            $sorting->setOrderBy("id");
            $sorting->setOrderDescending(false);

            $usersUtility = new Users();
            $membersCount = $usersUtility->countAllUsersBy('role', 'member');

            $subscriptionsHistoryTable = TableRegistry::get('users_subscriptions_history');
            $usersTable = $usersUtility->getUserTable();

            $foundSubscription = false;

            $searches[] = 'subscriptionInactive';
            $searches[] = 'subscriptionActive';

            foreach($searches as $search) {

                $y = 1;
                for ($x = 0; $x < $membersCount; $x = $x + 1000) {

                    $subscriptionDetailsArray = array();

                    $paging = new AnetAPI\PagingType();
                    $paging->setLimit("1000");
                    $paging->setOffset($y);

                    $request = new AnetAPI\ARBGetSubscriptionListRequest();
                    $request->setMerchantAuthentication($merchantAuthentication);
                    $request->setRefId($refId);
                    $request->setSearchType($search);
                    $request->setSorting($sorting);
                    $request->setPaging($paging);

                    $controller = new AnetController\ARBGetSubscriptionListController($request);

                    if (Configure::read('Merchants.MERCHANT_SANDBOX') == true) {

                        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
                    } else {

                        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                    }

                    if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {

                        $this->out("SUCCESS: Subscription Details:" . "\n");

                        foreach ($response->getSubscriptionDetails() as $subscriptionDetails) {

                            $this->out("Subscription ID: " . $subscriptionDetails->getId() . "\n");
                            $subscriptionDetailsArray[] = $subscriptionDetails;
                        }

                        $this->out("Total Number In Results:" . $response->getTotalNumInResultSet() . "\n");

                    } else {

                        $this->err("ERROR :  Invalid response\n");

                        $errorMessages = $response->getMessages()->getMessage();

                        $this->err("Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n");
                    }

                    if (count($subscriptionDetailsArray) > 0) {

                        foreach ($subscriptionDetailsArray as $subscriptionDetails) {

                            $subscriptionId = $subscriptionDetails->getId();

                            $subscriptionsHistoryEntity = $subscriptionsHistoryTable->newEntity([
                                'subscription_id' => $subscriptionId,
                                'subscription_status' => $subscriptionDetails->getStatus(),
                                'customer_profile_id' => $subscriptionDetails->getCustomerProfileId(),
                                'customer_payment_profile_id' => $subscriptionDetails->getCustomerPaymentProfileId(),
                                'created' => new \DateTime('now')
                            ]);

                            $subscriptionsHistoryTable->save($subscriptionsHistoryEntity);

                            if ($subscriptionDetails->getStatus() != 'active') {

                                $user = $usersUtility->findUserBySubscriptionId($subscriptionId);
                                if($user != null) {

                                    $user->set('role', 'user');

                                    $usersTable->save($user);
                                }
                            }
                            else {

                                $user = $usersUtility->findUserBySubscriptionId($subscriptionId);

                                if($user != null) {

                                    $user->set('role', 'member');

                                    $usersTable->save($user);
                                }
                            }

                            $foundSubscription = true;
                        }
                    }

                    $y = $y + 1;
                }
            }

            if($foundSubscription == false) {

                return -1;
            }
            else {

                return 0;
            }

        } catch (Exception $ex)
        {
            return -1;
        }
    }
}