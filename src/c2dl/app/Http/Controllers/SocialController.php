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

    static public function redirectDiscordJoin(string $widget_url = null)
    {
        $fallback = config('social.discord_join_fallback');

        if (!isset($widget_url)) {
            $widget_url = config('social.discord_social_widget');
        }

        try {
            $discord_widget = file_get_contents($widget_url);
            $discord_widget_json = json_decode($discord_widget, true);
        }
        catch (\Throwable $e)
        {
            return $fallback;
        }

        return redirect($discord_widget_json['instant_invite'] ?? $fallback);
    }

    static public function getDiscordData(string $widget_url = null): \App\DTO\Social
    {
        $fallback = [
            'main' => 'CrossCode Modding',
            'sub' => '#382339402338402315',
            'link' => config('social.discord_join_fallback'),
        ];

        if (!isset($widget_url)) {
            $widget_url = config('social.discord_social_widget');
        }

        try {
            $discord_widget = file_get_contents($widget_url);
            $discord_widget_json = json_decode($discord_widget, true);
        }
        catch (\Throwable $e)
        {
            return new \App\DTO\Social([
                'type' => 'discord',
                'name' => 'Discord',
                'desc' => 'Join the CCDirectLink Discord',
                'logo' => 'discord_logo',
                'main' => $fallback['main'],
                'sub' => $fallback['sub'],
                'side' => null,
                'link' => $fallback['link'],
                'link_type' => 'join',
            ]);
        }

        return new \App\DTO\Social([
            'type' => 'discord',
            'name' => 'Discord',
            'desc' => 'Join the CCDirectLink Discord',
            'logo' => 'discord_logo',
            'main' => $discord_widget_json['name'] ?? $fallback['main'],
            'sub' => '#' . $discord_widget_json['id'] ?? $fallback['sub'],
            'side' => trans_choice('home.member', $discord_widget_json['presence_count']) ?? null,
            'link' => $discord_widget_json['instant_invite'] ?? $fallback['link'],
            'link_type' => 'join',
        ]);
    }

    static public function getTwitterData() : \App\DTO\Social
    {
        return new \App\DTO\Social([
            'type' => 'twitter',
            'name' => 'Twitter',
            'desc' => 'Visit CCDirectLink on Twitter',
            'logo' => 'twitter_logo',
            'main' => 'CCDirectLink',
            'sub' => '@CCDirectLink',
            'link' => 'https://twitter.com/CCDirectLink',
            'card_type' => 'half',
        ]);
    }

    static public function getGithubData() : \App\DTO\Social
    {
        return new \App\DTO\Social([
            'type' => 'github',
            'name' => 'GitHub',
            'desc' => 'Visit CCDirectLink on GitHub',
            'logo' => 'github_logo',
            'main' => 'CCDirectLink',
            'link' => 'https://github.com/CCDirectLink',
            'card_type' => 'half',
        ]);
    }

    static public function getGitlabData() : \App\DTO\Social
    {
        return new \App\DTO\Social([
            'type' => 'gitlab',
            'name' => 'GitLab',
            'desc' => 'Visit CCDirectLink on GitLab',
            'logo' => 'gitlab_color_logo',
            'main' => 'CCDirectLink',
            'link' => 'https://gitlab.com/CCDirectLink',
            'card_type' => 'half',
        ]);
    }

    static public function getRedditData() : \App\DTO\Social
    {
        return new \App\DTO\Social([
            'type' => 'reddit',
            'name' => 'Reddit',
            'desc' => 'Visit CCDirectLink on Reddit',
            'logo' => 'reddit_logo',
            'main' => 'CCModding',
            'link' => 'https://www.reddit.com/r/CrossCodeModding/',
            'card_type' => 'half',
        ]);
    }

    static public function getSocial()
    {
        $discord_social = SocialController::getDiscordData();
        $twitter_social = SocialController::getTwitterData();
        $github_social = SocialController::getGithubData();
        $gitlab_social = SocialController::getGitlabData();
        $reddit_social = SocialController::getRedditData();

        return [
            $discord_social->type => $discord_social,
            $twitter_social->type => $twitter_social,
            $github_social->type => $github_social,
            $gitlab_social->type => $gitlab_social,
            $reddit_social->type => $reddit_social,
        ];
    }

    static public function hasRecommended()
    {
        return true;
    }

    static public function getRecommended()
    {
        $_discord_arcane = new \App\DTO\Social([
            'type' => 'discord_arcane',
            'name' => 'Discord',
            'desc' => 'Join the recommended Discord "CC: Arcane Lab Mod"',
            'logo' => 'discord_logo',
            'main' => 'CC: Arcane Lab Mod',
            'link' => 'https://discord.gg/dUbdmqh',
        ]);

        $_discord_genesis = new \App\DTO\Social([
            'type' => 'discord_genesis',
            'name' => 'Discord',
            'desc' => 'Join the recommended Discord "CC: Autumn\'s Genesis"',
            'logo' => 'discord_logo',
            'main' => 'CC: Autumn\'s Genesis',
            'link' => 'https://discord.gg/Seq9Kfq',
        ]);

        $_discord_bee = new \App\DTO\Social([
            'type' => 'discord_bee',
            'name' => 'Discord',
            'desc' => 'Join the recommended Discord "CrossCode: BEE"',
            'logo' => 'discord_logo',
            'main' => 'CrossCode: BEE',
            'link' => 'https://discord.gg/zVRnU9q',
        ]);

        $_discord_monMod = new \App\DTO\Social([
            'type' => 'discord_mon_mod',
            'name' => 'Discord',
            'desc' => 'Join the recommended Discord "MonMod and Emotes"',
            'logo' => 'discord_logo',
            'main' => 'MonMod and Emotes',
            'link' => 'https://discord.gg/TfaPvqZ',
        ]);

        return [
            $_discord_arcane->type => $_discord_arcane,
            $_discord_genesis->type => $_discord_genesis,
            $_discord_bee->type => $_discord_bee,
            $_discord_monMod->type => $_discord_monMod
        ];
    }

}
