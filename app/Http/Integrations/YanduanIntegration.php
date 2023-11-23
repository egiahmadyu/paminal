<?php

namespace App\Http\Integrations;

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

    public function importPangkat()
    {
        $url = 'api/v1/master/pangkat';
        return $this->get($url);
    }

    private function post($url, $body)
    {
        $response = Http::withHeaders([
            'Access-Key' => 'TThrauE38AOMq4rJKghhOi1BqOpAzyPiAgJQWdvyjlliiMAcdfqJkKo8x',
            'Secret-Key' => '02F0v4CFdNKGEFFxFckzKYQ9JlxSCPVPlcCoXOOwYzyBeV5ziF1U',
            'Token' => $this->token
        ])->withOptions(["verify"=>false])
        ->post($this->base_url . $url, $body);
        $res = json_decode($response->body());
        return $res;
    }

    private function get($url)
    {
        $response = Http::withOptions(["verify"=>false])->get($this->base_url . $url);
        $res = json_decode($response->body());
        return $res;
    }
}
