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
     * Returns results
     * @param Request $request
     * @return array|object
     */
    public function get(Request $request)
    {
        $youTubeClient = new YouTubeClient($request);

        return $youTubeClient->get();
    }
}
