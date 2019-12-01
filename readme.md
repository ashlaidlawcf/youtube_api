# YouTube Region API
#### By Ash Laidlaw (c) 2019

## Description

Basically, this is a simple `GET` request to YouTube's trending videos. It will return the top 10 trending videos for the US region, unless the parameters are changed. It will extract the trending videos' titles, description, and thumbnail URLs. The response is as follows:

[
    {
        "region: "US",
        "title": "Best Video",
        "description: "This is a good video!",
        "thumbnail": "https://www.youtube.com/myvideo/thumbnail"
    }
],
[
    {
        "region: "NL",
        "title": "Best Video",
        "description: "This is a good video!",
        "thumbnail": "https://www.youtube.com/myvideo/thumbnail"
    }
]

## How to Use

To access the videos, the URL is: [http://localhost:8000/api/v1/video]. There are two parameters you can pass in: `regionCode` and `maxResults`. `regionCode` takes the standard two-letter region codes, seperated by commas. The default if no `regionCode` is passed in, it defaults to "us". Example: "us,nl,gb,de" for the United States, Netherlands, Great Britain, and Germany.

`maxResults` takes an integer, and it's how many videos for each region you want. The default is 10 videos per region.

## Setup

To use this API, you must have PHP > 7.1 installed, as well as Composer. You will also need a Google API key to use with YouTube.

1. Run `composer install`, which will install the required dependencies.
2. In the `.env` file, add the following `KEY='VALUE'` pair: `YOUTUBE_API_KEY=<YOUR API HEY HERE>`.
3. Navigate to the root directory, and start your server by typing `php -S localhost:8000 -t public`.
4. You are good to go!

## Tech Used

* Lumen
* PHP 7.3
* Composer