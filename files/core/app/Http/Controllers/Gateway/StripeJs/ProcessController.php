<?php

namespace App\Http\Controllers\Gateway\StripeJs;

use App\Constants\Status;
use App\Models\Deposit;
use App\Http\Controllers\Gateway\PaymentController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;


class ProcessController extends Controller
{

    public static function process($deposit)
    {
        $StripeJSAcc = json_decode($deposit->gatewayCurrency()->gateway_parameter);
        $val['key'] = $StripeJSAcc->publishable_key;
        $val['name'] = currentAuth()['user']->username;
        $val['description'] = "Payment with Stripe";
        $val['amount'] = round($deposit->final_amo, 2) * 100;
        $val['currency'] = $deposit->method_currency;
        $send['val'] = $val;


        $alias = $deposit->gateway->alias;

        $send['src'] = "https://checkout.stripe.com/checkout.js";
        $send['view'] = currentAuth()['type'] . '.payment.' . $alias;
        $send['method'] = 'post';
        $send['url'] = route('ipn.' . $deposit->gateway->alias);
        return json_encode($send);
    }

    public function ipn(Request $request)
    {

        $track = Session::get('Track');
        $deposit = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        if ($deposit->status == Status::PAYMENT_SUCCESS) {
            $notify[] = ['error', 'Invalid request.'];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
        $StripeJSAcc = json_decode($deposit->gatewayCurrency()->gateway_parameter);


        Stripe::setApiKey($StripeJSAcc->secret_key);

        Stripe::setApiVersion("2020-03-02");

        try {
            $customer =  Customer::create([
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken,
            ]);
        } catch (\Exception $e) {
            $notify[] = ['error', $e->getMessage()];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }

        try {
            $charge = Charge::create([
                'customer' => $customer->id,
                'description' => 'Payment with Stripe',
                'amount' => round($deposit->final_amo, 2) * 100,
                'currency' => $deposit->method_currency,
            ]);
        } catch (\Exception $e) {
            $notify[] = ['error', $e->getMessage()];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }


        if ($charge['status'] == 'succeeded') {
            PaymentController::userDataUpdate($deposit);
            $notify[] = ['success', 'Payment captured successfully'];
            return to_route(gatewayRedirectUrl(true))->withNotify($notify);
        } else {
            $notify[] = ['error', 'Failed to process'];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
    }
}
