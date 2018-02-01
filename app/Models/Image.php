<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Image extends Eloquent {
    protected $connection = 'collection_systems';
    protected $collection = 'images';
    protected $dates = ['created_at', 'updated_at'];

}
