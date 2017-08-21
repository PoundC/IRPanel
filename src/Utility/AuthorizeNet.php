<?php

namespace App\Utility;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Cake\Core\Configure;

/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/12/17
 * Time: 8:10 PM
 */

class AuthorizeNet
{
    public function createSubscription($first_name, $last_name, $creditCardNumber, $creditCardExpiration, $months = true)
    {
        define("AUTHORIZENET_LOG_FILE", "/tmp/phplog");

        // Common Set Up for API Credentials
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(Configure::read('Merchants.MERCHANT_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(Configure::read('Merchants.MERCHANT_TRANSACTION_KEY'));
        $refId = 'ref' . time();

        // Subscription Type Info
        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName('Automatic Dating Subscription');

        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $interval->setLength("1");

        if($months == true) {

            $interval->setUnit("months");
        }
        else {

            $interval->setUnit("years");
        }

        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        $paymentSchedule->setStartDate(new \DateTime('now'));
        $paymentSchedule->setTotalOccurrences("100");
        $paymentSchedule->setTrialOccurrences("0");

        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setTrialAmount("0.00");

        if($months == true) {

            $subscription->setAmount("10.29");
        }
        else {

            $subscription->setAmount("99.99");
        }

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($creditCardNumber);
        $creditCard->setExpirationDate($creditCardExpiration);

        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);

        $subscription->setPayment($payment);

        $billTo = new AnetAPI\NameAndAddressType();
        $billTo->setFirstName($first_name);
        $billTo->setLastName($last_name);

        $subscription->setBillTo($billTo);

        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setmerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscription($subscription);

        $controller = new AnetController\ARBCreateSubscriptionController($request);

        if(Configure::read('Merchants.MERCHANT_SANDBOX') == true) {

            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        }
        else {

            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        }

        return $response;
    }

    public function cancelSubscription($subscriptionId)
    {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(Configure::read('Merchants.MERCHANT_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(Configure::read('Merchants.MERCHANT_TRANSACTION_KEY'));

        // Set the transaction's refId
        $refId = 'ref' . time();

        $request = new AnetAPI\ARBCancelSubscriptionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId($subscriptionId);

        $controller = new AnetController\ARBCancelSubscriptionController($request);

        if(Configure::read('Merchants.MERCHANT_SANDBOX') == true) {

            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        }
        else {

            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        }

        return $response;
    }
}