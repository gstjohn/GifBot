<?php namespace GifBot;

class Giphy implements Gifable
{

    const RESULT_LIMIT = 25;

    /**
     * This is the Giphy API key for public beta access
     * It will work up to a certain rate limit.
     * See: https://github.com/giphy/GiphyAPI#access-and-api-keys
     *
     * @param $api_key
     */
    private $api_key = 'dc6zaTOxFJmzC';

    /**
     * Get a GIF by search term
     *
     * @param $term
     * @return array
     */
    public function search($term)
    {
        $url      = 'http://api.giphy.com/v1/gifs/search?q=' . urlencode($term) . '&api_key=' . urlencode($this->api_key) . '&limit=' . urlencode(self::RESULT_LIMIT) . '&offset=0';
        $response = $this->sendRequest($url);

        $images = array();
        foreach ($response->data as $image) {
            if ($image->images->original->width > $image->images->original->height) {
                $images[] = new Gif($image->images->fixed_height->url);
            } else {
                $images[] = new Gif($image->images->fixed_width->url);
            }
        }

        return $images;
    }

    /**
     * Get a random GIF
     *
     * @return \GifBot\Gif
     */
    public function random()
    {
        $url      = 'http://api.giphy.com/v1/gifs/random?api_key=' . urlencode($this->api_key);
        $response = $this->sendRequest($url);

        return new Gif($response->data->image_url);
    }

    /**
     * Make API request
     *
     * @param $url
     * @return string
     */
    private function sendRequest($url)
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
}