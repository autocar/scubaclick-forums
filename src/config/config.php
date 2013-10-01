<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Frontend template files
    |--------------------------------------------------------------------------
    */
   'templates' => array(

        /*
        |--------------------------------------------------------------------------
        | Set to the main frontend layout
        |--------------------------------------------------------------------------
        */
        'layout'  => 'layouts.front.master',

        /*
        |--------------------------------------------------------------------------
        | Set to the template holding the listing of all forums
        |--------------------------------------------------------------------------
        */
        'forums'  => 'forum.front.forums',

        /*
        |--------------------------------------------------------------------------
        | Set to the template holding a single forum and its topics
        |--------------------------------------------------------------------------
        */
        'topics'  => 'forum.front.topics',

        /*
        |--------------------------------------------------------------------------
        | Set to the template holding a single topic and its replies
        |--------------------------------------------------------------------------
        */
        'replies' => 'forum.front.replies',

        /*
        |--------------------------------------------------------------------------
        | Set to the template holding a edit topic form
        |--------------------------------------------------------------------------
        */
        'edit_topic' => 'forum.front.edit.topic',

        /*
        |--------------------------------------------------------------------------
        | Set to the template holding a edit reply form
        |--------------------------------------------------------------------------
        */
        'edit_reply' => 'forum.front.edit.reply',

        /*
        |--------------------------------------------------------------------------
        | Set to the template holding a edit reply form
        |--------------------------------------------------------------------------
        */
        'labels' => 'forum.front.labels',
    ),

    /*
    |--------------------------------------------------------------------------
    | How many forums/topics/replies per page
    |--------------------------------------------------------------------------
    */
    'per_page' => 12,

    /*
    |--------------------------------------------------------------------------
    | Should the lead topic aways be shown
    |--------------------------------------------------------------------------
    | If set to true then the lead topic will be shown on all paged replies
    */
    'always_show_lead' => false,

    /*
    |--------------------------------------------------------------------------
    | Holds the default db connection
    |--------------------------------------------------------------------------
    | This should be set to your default connection as specified in 
    | app/config/database.php. For multi-tenant setups this connection
    | can be changed at runtime, so we hardcode it here again.
    */
    'default_connection' => 'master',

    /*
    |--------------------------------------------------------------------------
    | Holds the foreign user id table
    |--------------------------------------------------------------------------
    | Can be set to just a string, like `users`. The anonymous function below
    | allows setting the foreign key on a different database, e.g.
    | on a multi-tenant setup
    */

    'user_id_foreign' => function() {
        $db      = Config::get('database.connections');
        $default = Config::get('forums::default_connection');

        $prefix   = $db[$default]['prefix'];
        $database = $db[$default]['database'];

        return new \Illuminate\Database\Query\Expression($database .'.'. $prefix .'users');
    },
);
