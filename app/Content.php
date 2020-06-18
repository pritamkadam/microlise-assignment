<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['file_name', 'content_category_id'];

    /**
     * Get the user that owns the content.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the content category that owns the content.
     */
    public function content_category()
    {
        return $this->belongsTo('App\ContentCategory');
    }
}
