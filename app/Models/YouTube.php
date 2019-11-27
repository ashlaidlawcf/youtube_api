<?php

namespace App\Models;

/**
 * YouTube class
 */
class YouTube
{
    /**
     * @var string $region
     */
    public $region;

    /**
     * @var string $title
     */
    public $title;

    /**
     * @var string $description
     */
    public $description;

    /**
     * @var string $thumbnail
     */
    public $thumbnail;

    /**
     * Class constructor
     * @param string $region
     * @param string $title
     * @param string $description
     * @param string $thumbnailUrl
     * @return void
     */
    public function __construct(string $region, string $title, string $description, string $thumbnailUrl)
    {
        $this->region = strtoupper($region);
        $this->title = $title;
        $this->description = $description;
        $this->thumbnail = $thumbnailUrl;
    }
}
