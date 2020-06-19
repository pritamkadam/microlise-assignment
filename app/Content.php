<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['content_category_id', 'file_name', 'original_file_name', 'file_path'];

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

    /**
     * Get the content's created at date.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('M d, Y \a\t h:i A');
    }
}
