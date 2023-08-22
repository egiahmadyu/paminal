<?php

namespace App\Http\Integrations;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;

class YanduanIntegration
{
    private $base_url;
    private $token;
    public function __construct()
    {
       $this->base_url = ENV('URL_YANDUAN');
       $this->getToken();
    }

    public function getToken()
    {
        $url = 'api/v2/pis/generate-token';
        $body = null;
        $response = $this->post($url, null);
        $this->token = $response->data;
    }

    public function processed_reports($body)
    {
        $url = 'api/v2/pis/reports/processed-reports';
        return $this->post($url, $body);
    }

    private function post($url, $body)
    {
        // $client = new Client();
        // $headers = [
        // 'Access-Key' => 'TThrauE38AOMq4rJKghhOi1BqOpAzyPiAgJQWdvyjlliiMZhkAcdfqJkKo8x',
        // 'Secret-Key' => '02F0v4CFdNKGEFFxFckzKYQ9JlxSCPVPlxU6QA0aGcCoXOOwYzyBeV5ziF1U',
        // 'Token' => $this->token
        // ];
        // $request = new Request('POST', 'https://propam.admasolusi.space/api/v2/pis/generate-token', $headers);
        // $res = $client->sendAsync($request)->wait();
        $response = Http::withHeaders([
            'Access-Key' => 'TThrauE38AOMq4rJKghhOi1BqOpAzyPiAgJQWdvyjlliiMZhkAcdfqJkKo8x',
            'Secret-Key' => '02F0v4CFdNKGEFFxFckzKYQ9JlxSCPVPlxU6QA0aGcCoXOOwYzyBeV5ziF1U',
            'Token' => $this->token
            ])->post($this->base_url . $url, $body);
        $res = json_decode($response->body());
        return $res;

    }
}
