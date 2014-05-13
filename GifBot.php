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

// Fail if search string is empty
if ($search == '') {
    echo 'OK';
    exit;
}


// Pick a random GIF
$gifs  = getGif($search);
$count = count($gifs);

// Make sure we have an image
if ($count) {
    $image    = $gifs[rand(0, $count - 1)]->images->original;
    $response = $image->url;
} else {
    $response = 'No image found for `' . $search . '`';
}

// Respond
header('Content-Type: application/json');
echo json_encode(array(
    'text' => $response
));

exit;

/**
 * Get a GIF
 *
 * @param $search
 */
function getGif($search)
{
    // Query Giphy - http://giphy.com/
    $response = file_get_contents('http://api.giphy.com/v1/gifs/search?q=' . urlencode($search) . '&api_key=' . urlencode(GIPHY_API_KEY) . '&limit=' . urlencode(GIPHY_RESULT_LIMIT) . '&offset=0');
    $response = json_decode($response);

    return $response->data;
}