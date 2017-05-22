<?php

Route::post('tag/bundle','\WoXuanWang\Tag\Controllers\TagController@bundle');
Route::get('tag/most-used','\WoXuanWang\Tag\Controllers\TagController@mostUsed');
Route::resource('tag', '\WoXuanWang\Tag\Controllers\TagController');
