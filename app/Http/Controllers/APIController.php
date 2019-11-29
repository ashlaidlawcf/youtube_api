<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Clients\YouTubeClient;
use Illuminate\Http\Request;

/**
 * APIController class
 */
class APIController
{
    /**
     * @var YouTubeClient $youtube;
     */
    private $youtube;

    /**
     * Class constructor
     * @param YouTubeClient $youtube The YouTubeClient object
     * @return void
     */
    public function __construct(YouTubeClient $youtube)
    {
        $this->youtube = $youtube;
    }

    /**
     * Returns results
     * @param Request $request
     * @return array
     */
    public function get(Request $request): array
    {
        return $this->youtube->get($request);
    }
}
