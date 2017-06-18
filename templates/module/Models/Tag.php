<?php namespace WoXuanWang\Tag\Models;

use WoXuanWang\User\Models\User;


/**
 * Class Tag
 * @package WoXuanWang\Tag\Models
 * @version April 6, 2017, 3:40 pm CST
 */
class Tag extends \EstGroupe\Taggable\Model\Tag
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
