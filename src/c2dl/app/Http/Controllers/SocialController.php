<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    static public function getDiscordData(string $widget_url = null) : \App\DTO\Social
    {
        if (!isset($widget_url)) {
            $widget_url = config('social.discord_social_widget');
        }

        $discord_widget = file_get_contents($widget_url);
        $discord_widget_json = json_decode($discord_widget, true);

        return new \App\DTO\Social([
            'type' => 'discord',
            'main' => $discord_widget_json['name'] ?? null,
            'sub' => '#' . $discord_widget_json['id'] ?? null,
            'side' => $discord_widget_json['presence_count'] . ' ' . __('home.member') ?? null,
            'link' => $discord_widget_json['instant_invite'] ?? null,
            'link_type' => 'join',
        ]);
    }

    static public function getTwitterData() : \App\DTO\Social
    {
        return new \App\DTO\Social([
            'type' => 'twitter',
            'main' => 'CCDirectLink',
            'sub' => '@CCDirectLink',
            'link' => 'https://twitter.com/CCDirectLink',
        ]);
    }

    static public function getGithubData() : \App\DTO\Social
    {
        return new \App\DTO\Social([
            'type' => 'github',
            'main' => 'CCDirectLink',
            'link' => 'https://github.com/CCDirectLink',
        ]);
    }

    static public function getGitlabData() : \App\DTO\Social
    {
        return new \App\DTO\Social([
            'type' => 'gitlab',
            'main' => 'CCDirectLink',
            'link' => 'https://gitlab.com/CCDirectLink',
        ]);
    }

    static public function getRedditData() : \App\DTO\Social
    {
        return new \App\DTO\Social([
            'type' => 'reddit',
            'main' => 'CCDirectLink',
            'link' => 'https://www.reddit.com/r/CrossCodeModding/',
        ]);
    }

}
