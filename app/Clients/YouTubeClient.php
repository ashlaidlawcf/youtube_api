<?php

namespace App\Clients;

use App\Libs\Curl;
use Illuminate\Http\Request;

/**
 * YouTubeClient class
 */
class YouTubeClient
{
    /**
     * @var string YOUTUBE_URL
     */
    const YOUTUBE_URL = 'https://www.googleapis.com/youtube/v3/videos';

    /**
     * @var string $apiKey
     */
    private $apiKey;

    /**
     * @var array $regions
     */
    private $regions = [];

    /**
     * @var int $maxResults
     */
    private $maxResults = 10;

    /**
     * Class constructor
     * @param Request $request The request object
     */
    public function __construct(Request $request)
    {
        $this->getRegions($request);
        $this->getMaxResults($request);
        $this->apiKey = env('YOUTUBE_API_KEY');
    }

    /**
     * Returns either a JSON object or an array of JSON strings
     * @return array|object The returned JSON
     */
    public function get()
    {
        try {
            if (!empty($this->regions)) {
                $responses = [];

                // One call for each region
                foreach ($this->regions as $region) {
                    $url = self::YOUTUBE_URL . '?part=snippet&regionCode=' . $region .
                    '&chart=mostpopular&maxResults=' . $this->maxResults . '&key=' . $this->apiKey;
                    $curl = new Curl($url);
                    $responses[] = json_decode($curl->get());
                }

                return $responses;
            } else {
                // One call for the US region
                $url = self::YOUTUBE_URL . '?part=snippet&regionCode=us&chart=mostpopular&maxResults=' .
                $this->maxResults . '&key=' . $this->apiKey;
                $curl = new Curl($url);
                $response = $curl->get();

                return $response;
            }
        } catch (Exception $ex) {
            return json_encode(['error' => $ex->getMessage()]);
        }
    }

    /**
     * Gets the region list of regions to check
     * @param Request $request The request object
     * @return void
     */
    private function getRegions(Request $request): void
    {
        if ($request->has('regionCode')) {
            $regions = $request->get('regionCode');
            $regions = str_replace(' ', '', $regions);
            $regions = explode(',', $regions);

            foreach ($regions as $region) {
                $this->regions[] = $region;
            }
        }
    }

    /**
     * Gets the max results query parameter if it's set
     * @param Request $request The request object
     * @return void
     */
    private function getMaxResults(Request $request): void
    {
        if ($request->has('maxResults')) {
            $maxResults = $request->get('maxResults');

            if (filter_var($maxResults, FILTER_VALIDATE_INT)) {
                $this->maxResuls = $maxResults;
            }
        }
    }
}
