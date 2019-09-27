<?php
return [
    'site_name' =>  [
        'validation'    =>  'required|string|min:3|max:255',
        'type'          =>  'string',
        'default'       =>  'PBBG Topite'
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
    ]
];
