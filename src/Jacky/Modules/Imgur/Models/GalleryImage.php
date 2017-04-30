<?php

/**
 * jacky_bot/GalleryImage.php
 * Created by: Nathan
 * Date: 05/04/2017
 */

namespace Jacky\Modules;

/**
 * Class GalleryImage
 * @package Jacky\Modules\Imgur\Models
 */
class GalleryImage extends Model
{
    public $id;
    public $title;
    public $description;
    public $datetime;
    public $type;
    public $animated;
    public $width;
    public $heigth;
    public $size;
    public $views;
    public $bandwith;
    public $deletehash;
    public $link;
    public $gifv;
    public $mp4;
    public $mp4_size;
    public $looping;
    public $vote;
    public $favorite;
    public $nsfw;
    public $comment_count;
    public $topic;
    public $topic_id;
    public $section;
    public $account_id;
    public $account_url;
    public $ups;
    public $downs;
    public $points;
    public $score;
    public $is_album;

    /**
     * The image is an album of images
     * @return bool
     */
    public function isAlbum()
    {
        return $this->is_album != null ? $this->is_album : false;
    }

    /**
     * Is the image nsfw
     * @return bool
     */
    public function isNsfw()
    {
        return $this->nsfw != null ? $this->nsfw : false;
    }
}