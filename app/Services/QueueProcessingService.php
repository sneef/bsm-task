<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Support\Facades\Http;

class QueueProcessingService
{
    private $cookies = [];

    /**
     * Creates new attemp to process all form steps from https://challenge.blackscale.media/
     */
    public function create()
    {
        try {
            //Choose an account:
            $account = Account::sortBy('updated_at', 'desc')->first();

            info('id:' . $account->id);

            if (! $account) {
                throw new \Exception('Account not found');
            }

            //Step 1: get cookies:
            $response = Http::get(config('blackscale.step1.url'));

            info('stat: ' . $response->ok());

        } catch(\Exception $ex) {
            info($ex->getMessage());
        }
    }
}