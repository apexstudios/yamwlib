<?php
/*
 * Standard values
 *
 * model => None
 * dbtype => mysql
 *
 *
 * Cave-ats
 *
 * prefix_name
 *     Set it to true if you want to use the value from config
 *     Set to empty string if you want none
 */

return array(
    'units_space' => array(
        'prefix_name' => true,
        'model' => 'SpaceUnit'
    ),

    'units_ground' => array(
        'prefix_name' => true,
        'model' => 'SpaceUnit'
    ),

    'forum_cache' => array(
        'prefix_name' => true
    ),

    'users' => array(
        'prefix_name' => 'mybb_',
        'model' => 'MybbUser'
    ),

    // MongoDB stuff
    'gallery' => array(
        'prefix_name' => '',
        'dbtype' => 'mongo'
    ),
);
