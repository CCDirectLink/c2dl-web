<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the home view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        $news_list = NewsController::getNewsList(true);

        $discord_social = SocialController::getDiscordData();
        $twitter_social = SocialController::getTwitterData();
        $github_social = SocialController::getGithubData();
        $gitlab_social = SocialController::getGitlabData();
        $reddit_social = SocialController::getRedditData();

        return view('home', [
            'title' => 'CCDirectLink - CrossCode Community group',
            'news_list' => $news_list,
            'social' => [
                $discord_social->type => $discord_social,
                $twitter_social->type => $twitter_social,
                $github_social->type => $github_social,
                $gitlab_social->type => $gitlab_social,
                $reddit_social->type => $reddit_social,
            ],
        ]);
    }
}
