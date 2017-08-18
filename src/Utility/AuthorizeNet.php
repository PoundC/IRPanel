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
    public function createSubscription($userObject, $creditCardNumber, $creditCardExpiration)
    {
        define("AUTHORIZENET_LOG_FILE", "phplog");

        // Common Set Up for API Credentials
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName( Configure::read('MERCHANT_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(Configure::read('MERCHANT_TRANSACTION_KEY'));
        $refId = 'ref' . time();

        // Subscription Type Info
        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName('Automatic Dating Subscription');

        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $interval->setLength("1");
        $interval->setUnit("months");

        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        $paymentSchedule->setStartDate(new \DateTime('now'));
        $paymentSchedule->setTotalOccurrences("9999");
        $paymentSchedule->setTrialOccurrences("0");

        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setAmount("10.29");
        $subscription->setTrialAmount("0.00");

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($creditCardNumber);
        $creditCard->setExpirationDate($creditCardExpiration);

        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);

        $subscription->setPayment($payment);

        $billTo = new AnetAPI\NameAndAddressType();
        $billTo->setFirstName($userObject->first_name);
        $billTo->setLastName($userObject->last_name);

        $subscription->setBillTo($billTo);

        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setmerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscription($subscription);

        $controller = new AnetController\ARBCreateSubscriptionController($request);

        if(Configure::read('MERCHANT_SANDBOX') == true) {

            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        }
        else {

            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        }

        return $response;
    }

    public function cancelSubscription()
    {

    }
}