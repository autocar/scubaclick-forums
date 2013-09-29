<?php

return array(
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
    | Holds all topic types
    |--------------------------------------------------------------------------
    | Should only be modified before migrations are run
    */
    'types' => array(
        'bug'         => 'Bug', 
        'enhancement' => 'Enhancement',
        'feature'     => 'Feature',
        'support'     => 'Support',
    ),

    /*
    |--------------------------------------------------------------------------
    | Holds all topic priorities
    |--------------------------------------------------------------------------
    | Should only be modified before migrations are run
    */
    'priorities' => array(
        'low'     => 'Low', 
        'normal'  => 'Normal',
        'high'    => 'High', 
        'critial' => 'Critical',
    ),

    /*
    |--------------------------------------------------------------------------
    | Holds all topic stati
    |--------------------------------------------------------------------------
    | Should only be modified before migrations are run
    */
    'stati' => array(
        'new'         => 'New', 
        'accepted'    => 'Accepted',
        'progressing' => 'Progressing', 
        'completed'   => 'Completed',
        'invalid'     => 'Invalid', 
    ),

    /*
    |--------------------------------------------------------------------------
    | Holds all css label classes
    |--------------------------------------------------------------------------
    | Based on Twitter Bootstrap
    */
    'labels' => array(
        'status' => array(
            'new'         => 'default', 
            'accepted'    => 'info',
            'progressing' => 'important', 
            'completed'   => 'success',
            'invalid'     => 'inverse', 
        ),
        'priority' => array(
            'low'     => 'default', 
            'normal'  => 'info',
            'high'    => 'warning', 
            'critial' => 'important',
        ),
        'type' => array(
            'bug'         => 'important', 
            'enhancement' => 'info',
            'feature'     => 'success',
            'support'     => 'default',
        ),
    ),

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
