<?php

namespace Resin\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait ChecksHTTPStatus
{
    /**
     * Fetches the HTTP status code for an URL through a HEAD request.
     */
    public function http_status($url)
    {
        $client = new Client();
        $http_status = "";
        try {
            $res = $client->head($url);
            $http_status = $res->getStatusCode();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                $http_status = $res->getStatusCode();
            }
        }

        return $http_status;
    }
}
