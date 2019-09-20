<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Frontend\Post;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'lists';

    protected $fillable = [
        'id',
        'name',
        'user_id',
        'descriptions','updated_at','created_at','deleted_at'

    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
