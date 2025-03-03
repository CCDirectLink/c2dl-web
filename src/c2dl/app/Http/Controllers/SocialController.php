<?php

namespace App\Http\Controllers;

use App\DTO\Social;

class SocialController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public static function redirectDiscordJoin(string $widget_url = null)
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

    public static function getDiscordData(string $widget_url = null): Social
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
        catch (\Throwable $_)
        {
            return new Social([
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

        return new Social([
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

    public static function getGithubData(): Social
    {
        return new Social([
            'type' => 'github',
            'name' => 'GitHub',
            'desc' => 'Visit CCDirectLink on GitHub',
            'logo' => 'github_logo',
            'main' => 'CCDirectLink',
            'link' => 'https://github.com/CCDirectLink',
            'card_type' => 'half',
        ]);
    }

    public static function getRedditData(): Social
    {
        return new Social([
            'type' => 'reddit',
            'name' => 'Reddit',
            'desc' => 'Visit CCDirectLink on Reddit',
            'logo' => 'reddit_logo',
            'main' => 'CCModding',
            'link' => 'https://www.reddit.com/r/CrossCodeModding/',
            'card_type' => 'half',
        ]);
    }

    public static function getSocial(): iterable
    {
        $discord_social = SocialController::getDiscordData();
        $github_social = SocialController::getGithubData();
        $reddit_social = SocialController::getRedditData();

        return [
            $discord_social->type => $discord_social,
            $github_social->type => $github_social,
            $reddit_social->type => $reddit_social,
        ];
    }

    public static function hasRecommended(): bool
    {
        return true;
    }

    public static function getRecommended(): iterable
    {
        $_discord_arcane = new Social([
            'type' => 'discord_arcane',
            'name' => 'Discord',
            'desc' => 'Join the recommended Discord "CC: Arcane Lab Mod"',
            'logo' => 'discord_logo',
            'main' => 'CC: Arcane Lab Mod',
            'link' => 'https://discord.gg/dUbdmqh',
        ]);

        $_discord_genesis = new Social([
            'type' => 'discord_genesis',
            'name' => 'Discord',
            'desc' => 'Join the recommended Discord "CC: Autumn\'s Genesis"',
            'logo' => 'discord_logo',
            'main' => 'CC: Autumn\'s Genesis',
            'link' => 'https://discord.gg/Seq9Kfq',
        ]);

        $_discord_bee = new Social([
            'type' => 'discord_bee',
            'name' => 'Discord',
            'desc' => 'Join the recommended Discord "CrossCode: BEE"',
            'logo' => 'discord_logo',
            'main' => 'CrossCode: BEE',
            'link' => 'https://discord.gg/zVRnU9q',
        ]);

        $_discord_monMod = new Social([
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
