<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contents';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content_category_id',
        'file_name',
        'original_file_name',
        'file_path'
    ];

    /**
     * The created at date associated with the model.
     *
     * @var datetime
     */
    const CREATED_AT = 'created_at';

    /**
     * The updated at date associated with the model.
     *
     * @var datetime
     */
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the user that owns the content.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Get the content category that owns the content.
     */
    public function content_category()
    {
        return $this->belongsTo('App\ContentCategory', 'content_category_id', 'id');
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
