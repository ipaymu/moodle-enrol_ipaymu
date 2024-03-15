<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *     Stores all the function needed to run the plugin for better readability
 *
 * @package   enrol_ipaymu
 * @copyright  2024 Syaifudin <syaifudin.ama@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_ipaymu;

use curl;
use Exception;

defined('MOODLE_INTERNAL') || die();

/**
 * Stores all reusable functions here.
 *
 * @author  2024 Syaifudin <syaifudin.ama@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class ipaymu_helper {


    public function header($body)
    {
        $environment = get_config('enrol_ipaymu', 'environment');

        if ($environment == 'sandbox') {
            $url = 'https://sandbox.ipaymu.com';
            $va     = get_config('enrol_ipaymu', 'ipaymu_va_sandbox');
            $secret = get_config('enrol_ipaymu', 'ipaymu_apikey_sandbox');
        } else {
            $url    = 'https://my.ipaymu.com';
            $va     = get_config('enrol_ipaymu', 'ipaymu_va');
            $secret = get_config('enrol_ipaymu', 'ipaymu_apikey');
        }
        // throw new Exception($secret);
        
        $method       = 'POST'; //method

        // *Don't change this
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $secret;
        $signature    = hash_hmac('sha256', $stringToSign, $secret);
        $timestamp    = Date('YmdHis');
        //End Generate Signature

        return [
            'signature' => $signature,
            'timestamp' => $timestamp,
            'va' => $va,
            'body' => $body,
            'url'=> $url
        ];
    }

    public function send($endPoint, $body){
        $header = $this->header($body);

        
        $curl = curl_init();
        $baseUrl = $header['url'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $baseUrl.$endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($header['body']),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'signature: '.$header['signature'],
                'va: '.$header['va'],
                'timestamp: '.$header['timestamp']
            ),
        ));

        $err = curl_error($curl);
        $response['res'] = json_decode(curl_exec($curl),true);
        $response['err'] = $err;
        curl_close($curl);
        
        // throw new Exception(json_encode($response));
        
        return $response;
    }

    public function create($product, $qty, $price, $name, $phone, $email, $returnurl, $callbackurl){

        $body['product']    = $product;
        $body['qty']        = $qty;
        $body['price']      = $price;

        $body['buyerName']  = $name;
        $body['buyerEmail'] = $email;
        $body['buyerPhone'] = $phone == null ? null : $phone;

        $body['returnUrl']  = $returnurl;
        $body['notifyUrl']  = $callbackurl;

        $body['feeDirection']  = 'BUYER';

        return $this->send('/api/v2/payment', $body);
    }

    public function check_transaction($transaction_id, $account = null)
    {

        $body['transactionId']    = $transaction_id;

        if ($account != null) {
            $body['account'] = $account;
        }

        return $this->send('/api/v2/transaction', $body);
    }

    public function log_request($eventarray) {
        $event = \enrol_ipaymu\event\ipaymu_request_log::create($eventarray);
        $event->trigger();
    }
}
