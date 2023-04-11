<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class StripeWebhookController extends CashierController
{
    /**
     * Handle customer subscription deleted hook
     * @param array $payload
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionDeleted(array $payload)
    {
        try {
            $user = $this->getUserByStripeId($payload['data']['object']['customer']);

            if ($user) {
                $user->subscriptions->filter(function ($subscription) use ($payload) {
                    return $subscription->stripe_id === $payload['data']['object']['id'];
                })->each(function ($subscription) {
                    $subscription->delete();
                });

                $user->current_billing_plan = null;
                $user->save();
            }

            return new Response('Webhook Handled', 200);
        } catch (\Exception $e) {
            report($e);
            return new Response('Internal Server Error', 500);
        }
    }
}
