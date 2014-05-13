<?php

// This is the Giphy API key for public beta access
// It will work up to a certain rate limit.
// See: https://github.com/giphy/GiphyAPI#access-and-api-keys
define('GIPHY_RESULT_LIMIT', 25);
define('GIPHY_API_KEY', 'dc6zaTOxFJmzC');

// Get request
$trigger = $_POST['trigger_word'];
$text    = $_POST['text'];

// Build search string
$search = trim(substr($text, strlen($trigger) + 1));

// Response with random GIF if no search is provided
if ($search == '') {
    sendResponse(randomGif());
}

// Pick a random GIF from result set
$gifs  = searchGifs($search);
$count = count($gifs);

// Make sure we have an image
if ($count) {
    $image    = $gifs[rand(0, $count - 1)]->images->original;
    $response = $image->url;
} else {
    $response = 'No image found for `' . $search . '`. Enjoy this random GIF instead. ' . randomGif();
}

// Respond
sendResponse($response);

exit;

/**
 * Get a GIF by search
 *
 * @param $search
 */
function searchGifs($search)
{
    $url      = 'http://api.giphy.com/v1/gifs/search?q=' . urlencode($search) . '&api_key=' . urlencode(GIPHY_API_KEY) . '&limit=' . urlencode(GIPHY_RESULT_LIMIT) . '&offset=0';
    $response = makeRequest($url);

    return $response->data;
}

/**
 * Get a random GIF
 *
 * @return
 */
function randomGif()
{
    $url      = 'http://api.giphy.com/v1/gifs/random?api_key=' . urlencode(GIPHY_API_KEY);
    $response = makeRequest($url);

    return $response->data->image_url;
}

/**
 * Make Giphy API request
 *
 * @param $url
 * @return string
 */
function makeRequest($url)
{
    $response = array();

    if (ini_get('allow_url_fopen')) {
        $response = file_get_contents($url);
    } elseif (function_exists('curl_version')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
    }

    return json_decode($response);
}

/**
 * Send JSON Response
 *
 * @param $response
 */
function sendResponse($response)
{
    header('Content-Type: application/json');
    die(json_encode(array(
        'text' => $response
    )));
}