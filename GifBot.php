<?php

// This is the Giphy API key for public beta access
// It will work up to a certain rate limit.
// See: https://github.com/giphy/GiphyAPI#access-and-api-keys
define('GIPHY_API_KEY', 'dc6zaTOxFJmzC');

// Get request
$trigger = $_POST['trigger_word'];
$search  = trim(substr($_POST['text'], strlen($trigger) + 1));

// Query Giphy - http://giphy.com/
$limit    = 25;
$response = json_decode(file_get_contents('http://api.giphy.com/v1/gifs/search?q=' . urlencode($search) . '&api_key=' . GIPHY_API_KEY . '&limit=' . $limit . '&offset=0'));

// Pick a random GIF
$gifs  = $response->data;
$count = count($gifs);
$image = $gifs[rand(0, $count - 1)]->images->original;

if($image) {
	$image_url = $image->url;
} else {
	$response = json_decode(file_get_contents('http://api.giphy.com/v1/gifs/random?api_key=dc6zaTOxFJmzC&limit=2'));
	// Pick a random GIF
	$image_url = 'I\'m very sorry - I was unable to find a gif with the search term _"' . $search . '"_. Instead, have a random one: ' . $response->data->image_url;
}

// Respond with GIF
header('Content-Type: application/json');
echo json_encode(array(
	'text' => $image_url
));
