<?php

namespace App\Libs;

/**
 * Curl class
 */
class Curl
{
    /**
     * @var cURL $curl The open curl connection
     */
    private $curl;

    /**
     * @var string $url The URL to hit
     */
    private $url;

    /**
     * Class constructor
     * @param string $curl
     * @return void
     */
    public function __construct(string $url)
    {
        $this->url = $url;
        $this->curl = curl_init();
    }

    /**
     * Connects to the URL and returns a response
     * @return string JSON response
     */
    public function get(): string
    {
        try {
            curl_setopt_array($this->curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->url
            ]);

            $response = curl_exec($this->curl);
        } catch (Exception $ex) {
            $response = json_encode(['error' => $ex->getMessage()]);
        }

        return $response;
    }

    /**
     * Closes cURL connection
     * @return void
     */
    public function __destruct()
    {
        curl_close($this->curl);
    }
}
