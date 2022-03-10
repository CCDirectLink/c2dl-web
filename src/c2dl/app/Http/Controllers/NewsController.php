<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    static public function rssFeed(int $limit = 20)
    {
        $posts = [];
        $_newsList = News::where('active', 1)
            ->where('page_number', 1)
            ->orderBy('news_id', 'desc')
            ->take($limit)
            ->get();

        $_lastUpdate = NewsController::getLastUpdate();

        if (!isset($_newsList[0])) {
            return 'Something went horribly wrong, and no posts were found. Did you forget to seed the database?';
        }

        foreach ($_newsList as $post) {
            array_push($posts, NewsController::compileData($post));
        }

        return response()->view(
            'feed',
            [ 'posts' => $posts, 'lastUpdate' => $_lastUpdate ])
            ->header('Content-Type', 'application/atom+xml');
    }

    static public function getLastUpdate()
    {
        $_latest_created = News::where('active', 1)
            ->latest()
            ->first()?->created_at;

        $_latest_updated = News::where('active', 1)
            ->whereNotNull('updated_at')
            ->orderBy('updated_at', 'desc')
            ->first()?->updated_at;

        if ($_latest_updated < $_latest_created) {
            return $_latest_created ?? new DateTime();
        }
        else {
            return $_latest_updated ?? new DateTime();
        }
    }

    static public function getNewsList(bool $pinned = false,
                                       int $limit = 10,
                                       string $lang = null) : array
    {
        $list = [];
        $_newsList = News::where('active', 1)
            ->where('page_number', 1);

        if (isset($lang)) {
            $_newsList = $_newsList->where('lang', $lang);
        }

        $newsList = $_newsList->orderBy('news_id', 'desc')
            ->take($limit)
            ->get();

        if (!isset($newsList[0])) {
            return [];
        }

        foreach ($newsList as $news) {
            array_push($list, NewsController::compileData($news));
        }
        return $list;
    }

    static public function getNews(int $id,
                                   int $page = 1,
                                   string $lang = 'en') : ?\App\DTO\News
    {
        $newsData = News::where('active', 1)
            ->where('page_number', $page)
            ->where('news_id', $id)
            ->where('lang', $lang)
            ->get();
        if (isset($newsData[0])) {
            return NewsController::compileData($newsData[0]);
        }
        return null;
    }

    static public function getNewsPages(int $id,
                                        string $lang,
                                        int $current = null) : ?\App\DTO\Pagination
    {
        $_apge = [
            'list' => [],
            'before' => null,
            'next' => null,
            'current' => $current,
        ];
        $get_next = false;
        $newsList = News::where('active', 1)
            ->where('news_id', $id)
            ->where('lang', $lang)
            ->get();

        if (!isset($newsList[0])) {
            return null;
        }

        foreach ($newsList as $key => $news) {
            if ($get_next) {
                $get_next = false;
                $_apge['next'] = $news->page_number;
            }

            if ((isset($current)) && ($current == $news->page_number)) {
                $get_next = true;
                if ($key > 0) {
                    $_apge['before'] = $newsList[$key - 1]->page_number;
                }
            }
            array_push($_apge['list'], $news->page_number);
        }

        return new \App\DTO\Pagination($_apge);
    }

    static public function contentToPreview(string $content) : string
    {
        // no tags
        $content = strip_tags($content);
        $preview_cut = 175;

        $strlen = mb_strlen($content);
        $substring = mb_substr($content, 0, $preview_cut);
        if ($strlen > $preview_cut) {
            $substring .= '...';
        }
        return $substring;
    }

    static public function compileData(object $entry) : \App\DTO\News
    {
        $page_data = NewsController::getNewsPages($entry->news_id, $entry->lang, $entry->page_number);
        $preview = NewsController::contentToPreview($entry->content);

        $_author = 0;
        if (isset($entry->author_id) && is_int($entry->author_id)) {
            $_author = $entry->author_id;
        }

        try {
            $author = UserController::getUser($_author);
        }
        catch (\Throwable $e) {
            // should never happen (multiple users with same id)
            $author = null;
        }

        if (is_null($author)) {
            $author = new \App\DTO\User(0, "CCDirectLink");
        }

        return new \App\DTO\News($entry, $preview, $author, $page_data);
    }

    /**
     * Show the news
     *
     * @param Request $request
     * @param int $news_id
     * @param int $page
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request,
                         int $news_id,
                         int $page = 1) : \Illuminate\Contracts\Support\Renderable
    {

        if (is_null($news_id)) {
            abort(404,'Page not found');
        }

        $result = NewsController::getNews($news_id, $page);

        if (is_null($result)) {
            abort(404,'Page not found');
        }

        return view('news', [ 'entry' => $result ]);
    }
}
