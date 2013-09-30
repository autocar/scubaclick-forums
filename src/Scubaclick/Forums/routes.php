<?php

Route::get('/{forum}/{topic}/{feed}', [
    'as'   => 'forum.front.topic.feed',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@repliesFeed',
])
->where([
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
    'feed'  => 'rss.xml|atom.xml|feed.json'
]);

Route::get('/{forum}/{topic}', [
    'as'   => 'forum.front.topic',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@replies',
])
->where([
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
]);

Route::post('/{forum}/{topic}', [
    'as'   => 'forum.front.topic.reply',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@postReply',
])
->where([
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
]);

Route::get('/{forum}/{feed}', [
    'as'   => 'forum.front.forum.feed',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@topicsFeed',
])
->where([
    'forum' => '[a-z-]+',
    'feed'  => 'rss.xml|atom.xml|feed.json'
]);

Route::get('/{forum}', [
    'as'   => 'forum.front.forum',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@topics',
])
->where('forum', '[a-z-]+');

Route::post('/{forum}', [
    'as'   => 'forum.front.forum.topic',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@postTopic',
])
->where('forum', '[a-z-]+');

Route::get('/', [
    'as'   => 'forum.front.index',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@forums',
]);
