<?php

namespace App\Clients;

use App\Libs\Curl;
use App\Models\YouTube;
use Illuminate\Http\Request;

/**
 * YouTubeClient class
 */
class YouTubeClient extends BaseClient
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
        parent::__construct($request);
        $this->getRegions();
        $this->getMaxResults();
        $this->apiKey = env('YOUTUBE_API_KEY');
    }

    /**
     * Returns either a JSON object or an array of JSON objects
     * @return array The returned JSON
     */
    public function get(): array
    {
        $responses = [];

        foreach ($this->regions as $region) {
            $url = self::YOUTUBE_URL . '?part=snippet&regionCode=' . $region .
            '&chart=mostpopular&maxResults=' . $this->maxResults . '&key=' . $this->apiKey;
            $curl = new Curl($url);
            $responses[] = json_decode($curl->get());
        }

        return $this->parseRegions($responses);
    }

    /**
     * Extracts the relevant parts of the video list
     * @param array $responses
     * @return array Array of parsed YouTube videos
     */
    private function parseRegions(array $responses): array
    {
        $regionCounter = 0;

        // Go through each response (one response for each region)
        foreach ($responses as $response) {
            $videos = $response->items;

            // Go through each video for each response (X number of JSON objects for each region)
            $parsedVideos = $this->parseVideosForRegion($videos, $regionCounter);
            $regionCounter++;
        }

        return $parsedVideos;
    }

    /**
     * Parses out the information from each video within a region
     * @param array $videos The array of videos for a region
     * @param int $regionCounter
     */
    private function parseVideosForRegion(array $videos, int $regionCounter): array
    {
        $parsedVideos = [];

        foreach ($videos as $video) {
            $snippet = $video->snippet;
            $youTube = new YouTube($this->regions[$regionCounter], $snippet->title,
                $snippet->description, $snippet->thumbnails->default->url);
            $parsedVideos[] = $youTube;
        }

        return $parsedVideos;
    }

    /**
     * Gets the region list of regions to check
     * @return void
     */
    private function getRegions(): void
    {
        if ($this->request->has('regionCode')) {
            $regions = $this->request->get('regionCode');
            $regions = str_replace(' ', '', $regions);
            $regions = explode(',', $regions);

            foreach ($regions as $region) {
                $this->regions[] = $region;
            }
        } else {
            $this->regions[] = 'us';
        }
    }

    /**
     * Gets the max results query parameter if it's set
     * @return void
     */
    private function getMaxResults(): void
    {
        if ($this->request->has('maxResults')) {
            $maxResults = $this->request->get('maxResults');

            if (filter_var($maxResults, FILTER_VALIDATE_INT)) {
                $this->maxResuls = $maxResults;
            }
        }
    }
}
