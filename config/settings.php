<?php
return [
    'seo_title' =>  [
        'validation'    =>  'required|string|min:3|max:255',
        'type'          =>  'string',
        'default'       =>  'PBBG Topsite'
    ],
    'site_online'  =>  [
        'validation'    =>  'sometimes|required|boolean',
        'type'          =>  'boolean',
        'default'       =>  '1'
    ],
    'discord_webhook'   =>  [
        'validation'    =>  'sometimes|nullable|url',
        'type'          =>  'url',
        'default'       =>  ''
    ],
    'seo_description'   =>  [
        'validation'    =>  'nullable|max:400',
        'type'          =>  'textarea',
        'default'       =>  'Top PBBG is an online directory of web games that lists games that can be played online. Owners can ask to players to vote for the game thus pushing up the rankings and gain more traffic.'
    ]
];
