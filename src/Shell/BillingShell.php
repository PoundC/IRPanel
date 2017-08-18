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
            $merchantAuthentication->setName(Configure::read('MERCHANT_LOGIN_ID'));
            $merchantAuthentication->setTransactionKey(Configure::read('MERCHANT_TRANSACTION_KEY'));

            // Set the transaction's refId
            $refId = 'ref' . time();

            $sorting = new AnetAPI\ARBGetSubscriptionListSortingType();
            $sorting->setOrderBy("id");
            $sorting->setOrderDescending(false);

            $paging = new AnetAPI\PagingType();
            $paging->setLimit("1000");
            $paging->setOffset("1");

            $request = new AnetAPI\ARBGetSubscriptionListRequest();
            $request->setMerchantAuthentication($merchantAuthentication);
            $request->setRefId($refId);
            $request->setSearchType("subscriptionInactive");
            $request->setSorting($sorting);
            $request->setPaging($paging);

            $controller = new AnetController\ARBGetSubscriptionListController($request);

            if(Configure::read('MERCHANT_SANDBOX') == true) {

                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
            }
            else {

                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
            }

            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
                echo "SUCCESS: Subscription Details:" . "\n";
                foreach ($response->getSubscriptionDetails() as $subscriptionDetails) {
                    echo "Subscription ID: " . $subscriptionDetails->getId() . "\n";
                }
                echo "Total Number In Results:" . $response->getTotalNumInResultSet() . "\n";
            } else {
                echo "ERROR :  Invalid response\n";
                $errorMessages = $response->getMessages()->getMessage();
                echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
            }

            return 0;

        } catch (Exception $ex)
        {
            return -1;
        }
    }
}