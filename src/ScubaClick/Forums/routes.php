<?php

Route::get('/{forum}/{topic}/{feed}', array(
    'as'   => $prefix .'forum.front.topic.feed',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@repliesFeed',
))
->where(array(
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
    'feed'  => 'rss.xml|atom.xml|feed.json'
));

Route::get('/{forum}/{topic}', array(
    'as'   => $prefix .'forum.front.topic',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@replies',
))
->where(array(
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
));

Route::get('/{forum}/{topic}/edit', array(
    'as'   => $prefix .'forum.front.topic.edit',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@editTopic',
))
->where(array(
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
));

Route::post('/{forum}/{topic}/edit', array(
    'as'   => $prefix .'forum.front.topic.edit.action',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@editTopicAction',
))
->where(array(
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
));

Route::delete('/{forum}/{topic}/delete', array(
    'as'   => $prefix .'forum.front.topic.delete',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@deleteTopic',
))
->where(array(
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
));

Route::post('/{forum}/{topic}/resolve', array(
    'as'   => $prefix .'forum.front.topic.resolve',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@resolveTopic',
))
->where(array(
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
));

Route::post('/{forum}/{topic}/reopen', array(
    'as'   => $prefix .'forum.front.topic.reopen',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@reopenTopic',
))
->where(array(
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
));

Route::post('/{forum}/{topic}', array(
    'as'   => $prefix .'forum.front.topic.reply',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@postReply',
))
->where(array(
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
));

Route::get('/{forum}/{topic}/reply/{id}/edit', array(
    'as'   => $prefix .'forum.front.reply.edit',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@editReply',
))
->where(array(
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
    'id'    => '[0-9]+',
));

Route::post('/{forum}/{topic}/reply/{id}/edit', array(
    'as'   => $prefix .'forum.front.reply.edit.action',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@editReplyAction',
))
->where(array(
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
    'id'    => '[0-9]+',
));

Route::delete('/{forum}/{topic}/reply/{id}/delete', array(
    'as'   => $prefix .'forum.front.reply.delete',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@deleteReply',
))
->where(array(
    'forum' => '[a-z-]+',
    'topic' => '[a-z-]+',
    'id'    => '[0-9]+',
));

Route::get('/{forum}/{feed}', array(
    'as'   => $prefix .'forum.front.forum.feed',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@topicsFeed',
))
->where(array(
    'forum' => '[a-z-]+',
    'feed'  => 'rss.xml|atom.xml|feed.json'
));

Route::get('/{forum}', array(
    'as'   => $prefix .'forum.front.forum',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@topics',
))
->where('forum', '[a-z-]+');

Route::post('/{forum}', array(
    'as'   => $prefix .'forum.front.forum.topic',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@postTopic',
))
->where('forum', '[a-z-]+');

Route::get('/', array(
    'as'   => $prefix .'forum.front.index',
    'uses' => '\\ScubaClick\\Forums\\Controllers\\FrontController@forums',
));
