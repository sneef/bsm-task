<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Support\Facades\Http;

class QueueProcessingService
{
    private $cookies = [];
    private $stoken = '';

    /**
     * Creates new attemp to process all form steps from https://challenge.blackscale.media/
     */
    public function create()
    {
        try {
            //Choose an account:
            $account = Account::inRandomOrder()->first();

            if (! $account) {
                throw new \Exception('Account not found');
            }

            info('mail: ' . $account->username);

            //Step 1: get cookies:
            $response = Http::get(config('blackscale.step1.url'));

            if (! $response->ok()) {
                throw new \Exception('Something wrong with website (step 1)');
            }

            $headers = $response->headers();
            $pageHtml = $response->body();

            if (array_key_exists('Set-Cookie', $headers)) {
                $this->cookies = array_merge($this->cookies, $headers['Set-Cookie']);

                if (
                    count($this->cookies) == 1
                    && preg_match('/<input\s+type="hidden"\s+name="stoken"\s+value="([^"]+)"/i', $pageHtml, $matches)
                ) {
                    $this->stoken = $matches[1];
                    $this->cookies[] = 'stoken=' . $this->stoken . '; Path=/';
                } else {
                    $this->cookies[1] = 'stoken=' . $this->cookies[1] . '; Path=/';
                }
            } else {
                throw new \Exception('Cookies not found');
            }
            
            //Step 2: Submitting the form:
            $response = Http::withHeaders([
                'Cookie' => implode('; ', $this->cookies)
            ])->post(config('blackscale.step2.url'), [
                'email' => $account->username,
                'name' => 'Some user ' . rand(1000, 2000)
            ]);
            
            if (! $response->ok()) {
                throw new \Exception('Something wrong with website (step 2)');
            }



        } catch(\Exception $ex) {
            info($ex->getMessage());
        }
    }
}