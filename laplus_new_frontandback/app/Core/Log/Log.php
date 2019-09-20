<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Core\Log;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'id',
        'activity',
        'user_id',
        'action_time',
        'descriptions','updated_at','created_at','deleted_at'

    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
