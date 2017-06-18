<?php namespace WoXuanWang\Tag;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use WoXuanWang\Tag\Models\Tag;

class TagServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views',
            'WoXuanWang\Tag');

        Tag::creating(
            function ($tag) {
                //
                $tag->created_at = Carbon::now();
                $tag->updated_at = $tag->created_at;
            }
        );
        Tag::updating(
            function ($tag) {
                //
                $tag->updated_at = Carbon::now();
            }
        );
    }
}