<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Discord widget
    |--------------------------------------------------------------------------
    |
    | Discord widget url to view the social plugin.
    |
    */

    'discord_social_widget' => env('DISCORD_SOCIAL_WIDGET',
        'https://discordapp.com/api/guilds/382339402338402315/widget.json'),

    'discord_join_fallback' => env('DISCORD_JOIN_FALLBACK',
    'https://discordapp.com/invite/TFs6n5v'
    ),

];
