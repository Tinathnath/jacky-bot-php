<?php
/**
 * jacky_bot/Model.php
 * Created by: Nathan
 * Date: 05/04/2017
 */

namespace Jacky\Modules;

/**
 * Class Model
 * Base class for Imgur data models
 * @package Jacky\Modules\Imgur\Models
 */
abstract class Model
{
    /**
     * Hydates object with raw data
     * @param $data
     */
    public function _hydrate($data)
    {
        foreach ($data as $key => $value)
        {
            if(property_exists($this, $key))
                $this->{$key} = $value;
        }
    }
}