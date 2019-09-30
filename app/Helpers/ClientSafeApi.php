<?php

namespace App\Helpers;

use App\Setting;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class ClientSafeApi
{
    public function call($action, $data)
    {
        $settings = $this->getSettings('safe');
        $client_id = $settings->client_id ?? null;
        $client_secret = $settings->client_secret ?? null;
        $uri_oauth2 = $settings->uri_oauth2 ?? null;
        $uri_signin = $settings->uri_signin ?? null;
        $uri_transaction = $settings->uri_transaction ?? null;
        $uri_prompt = $settings->uri_prompt ?? null;
        $uri_checkclientaid = $settings->uri_checkclientaid ?? null;
        $uri_consumer = $settings->uri_consumer ?? null;
        $uri_application = $settings->uri_application ?? null;

        // {{client_id}}           edm_demo
        // {{client_secret}}       df640c00-a335-407b-bbf1-b63eb35b1a1a
        // {{safe_id}}             <leodev2
        // {{auth_code}}           Request 1 – Authorization Code          7ec355b2-e36b-4d0e-8008-02feae417e9c
        // {{access_token}}        Request 2 – Access Token                81347ca860ae5baee51c5fcb707ba00fd7c87448
    

        switch ($action) {          
            case 'prompt':
                $method = 'POST';
                $url = $uri_prompt;
                $auth =  array($client_id, $client_secret);
                $body = array(
                    'client_application_id' => $client_id,
                    'client_application_user_id' => $data['client_application_user_id'] ?? null,
                    'client_application_user_aid' => $data['client_application_user_aid'] ?? null,
                    'client_application_user_phone' => $data['client_application_user_phone'] ?? null,
                    'client_application_user_name' => $data['client_application_user_name'] ?? null,
                    'client_application_user_email' => $data['client_application_user_email'] ?? null,
                    'send_sms' => $data['send_sms'] ?? null,
                );
                $params = array(
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'auth' => $auth,
                    'json' => $body,
                );
            break;            

            //documented but not used in this demo
            case 'checkclientaid':
                $method = 'POST';
                $url = $uri_checkclientaid;
                $body = array(
                    'client_application_id' => $client_id,
                    'client_application_user_id' => $data['client_application_user_id'] ?? null,                    
                    'client_application_user_aid' => $data['client_application_user_aid'] ?? null,  
                );
                $params = array(
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => "Bearer {$data['access_token']}",
                    ],
                    'json' => $body,
                );
                break;   

            //documented, used in PublicController@preregistered, PublicController@preregisteredWeb
            case 'consumer':
                $method = 'GET';
                $url = $uri_consumer;
                $query = "id={$data['aid']}";
                $params = array(
                    'headers' => [
                        'Authorization' => "Bearer {$data['access_token']}"
                    ],
                    'query' => $query,
                );                
                break;

                    

            //documented
            case 'get_auth_code':
                $method = 'POST';
                $url = $uri_oauth2;
                $body = array(
                    'client_id' => $client_id,
                    'response_type' => 'code',
                    'anchorid' => $data['aid'],
                );
                $params = array(
                    'json' => $body,
                );
                break;

            //documented
            case "get_access_token":
                $method = 'POST';
                $url = $uri_oauth2;
                $auth =  array($client_id, $client_secret);
                $body = array(
                    'client_id' => $client_id,
                    'anchorid' => $data['aid'],
                    'grant_type' => 'authorization_code',
                    'code' => $data['code'],
                );
                $params = array(
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'auth' => $auth,
                    'json' => $body,
                );
                break;

            // documented, LoginController@initAnchor, returns sign-in transaction
            case "init_signin":
                $method = 'POST';
                $url = $uri_signin;
                
                $body = array(
                    'client_id' => $client_id,
                    'anchorid' => $data['aid'],
                    'grant_type' => 'authorization_code',
                );
                $params = array(
                    'headers' => [
                        'Authorization' => "Bearer {$data['access_token']}"
                    ],
                    'json' => $body,
                );
                break;

            
            // documented, LoginController@SignInStatusCheck
            case "signin_status_check":
                $method = 'GET';
                $url = $uri_transaction;
                $query = "id={$data['transactionId']}";
                $params = array(
                    'headers' => [
                        'Authorization' => "Bearer {$data['access_token']}"
                    ],
                    'query' => $query,
                );
                break;              
                

            // documented
            case "deactivate_user":
                $method = 'PUT';
                $url = $uri_application;
                
                $body = array(
                    'id' => $data['aid'],
                    'client_user_id' => $data['client_user_id'],
                    'active' => $data['active'],
                    'app_id' => $client_id,
                );
                $params = array(
                    'headers' => [
                        'Authorization' => "Bearer {$data['access_token']}"
                    ],
                    'json' => $body,
                );
                break;

        }

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request($method, $url, $params);
            } catch (RequestException $e) {
                // echo Psr7\str($e->getRequest());
                if ($e->hasResponse()) {
                    $error = true;
                    $error_response =  $e->getResponse();
                    $json_body = (string) $error_response->getBody();

                    return [
                        'error' => $error,
                        'msg' => $error_response,
                        'json_body' => $json_body,
                    ];
                }
            }

            $response_status = $response->getStatusCode(); 
            $response_contents = $response->getBody()->getContents();

            return [
                'error' => false,
                'response_status' => $response_status,
                'json_body' => $response_contents,
            ];
        
    }

    // returns settings object
    public function getSettings($service){
        $setting = Setting::where('service', '=', $service)->firstOrFail();
        return json_decode($setting->data);
    }

    //array
    public function getAccessToken($safe_id){
        $data = array('aid' => $safe_id);
        $code = $this->call('get_auth_code', $data);
        $r = json_decode($code['json_body']);
        $code = $r->description->code ?? null;
        $data['code'] = $code;
        $access_token = $this->call('get_access_token', $data);
        $r = json_decode($access_token['json_body']);  
        $token = $r->access_token ?? null;       
        return $token;        
    }
}