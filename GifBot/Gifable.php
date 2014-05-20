<?php namespace GifBot;

interface Gifable {

    /**
     * Get a GIF by search term
     *
     * @param $term
     * @return array
     */
    public function search($term);

    /**
     * Get a random GIF
     *
     * @return \GifBot\Gif
     */
    public function random();
}