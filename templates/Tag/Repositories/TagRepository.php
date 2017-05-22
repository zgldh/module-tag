<?php

namespace WoXuanWang\Tag\Repositories;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use WoXuanWang\Tag\Models\Tag;
use zgldh\Scaffold\BaseRepository;

class TagRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'slug',
        'name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tag::class;
    }

    public function getMostUsedTags($limit = 10)
    {
        $tags = Tag::orderBy('count', 'desc')->take($limit)->get();
        return $tags;
    }

    public static function syncTags(Model $model, $tags = [])
    {
        if (!method_exists($model, 'tags')) {
            return $model;
        }
        foreach ($tags as $key => $tag) {
            $tagId = null;
            if (is_numeric($tag)) {
                $tagId = intval($tag);
            } elseif (is_string($tag)) {
                $tagModel = Tag::firstOrCreate(['name' => $tag]);
                $tagModel->user_id = \Auth::id();
                $tagId = $tagModel->id;
            } elseif (is_array($tag)) {
                if (key_exists('id', $tag)) {
                    $tagId = $tag['id'];
                } else {
                    throw new InvalidParameterException("Array 'tag' doesn't have 'id' key.");
                }
            } elseif (is_object($tag)) {
                if (property_exists($tag, 'id')) {
                    $tagId = $tag->id;
                } else {
                    throw new InvalidParameterException("Object 'tag' doesn't have 'id' property.");
                }
            } else {
                throw new InvalidParameterException("Bad tag type: " . gettype($tag));
            }

            $tags[$key] = $tagId;
        }
        if (count($tags) <= 0) {
            $model->untag($model->tagNames());
        } else {
            $model->tagWithTagIds($tags);
        }
        return $model;
    }
}
