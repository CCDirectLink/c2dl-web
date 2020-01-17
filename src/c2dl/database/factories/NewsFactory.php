<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\News;
use Illuminate\Support\Facades\Log;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {
    static $index = 1;
    static $page = 0;

    if (($page > 4) || ($index > 1)) {
        $page = 1;
        $index++;
    }
    else {
        $page++;
    }

    $_content = '';
    for ($i = 0; $i < rand(3, 6); ++$i) {
        $_content .= '<p>' . $faker->text(rand(250, 400)) . '</p>';
    }

    return [
        // Post increment (add current index -> increment)
        'news_id' => $index,
        'lang' => 'en',
        'active' => 1,
        'page_number' => $page,
        'author_id' => 0,
        'title' => function (array $data) {
            return 'testTitle' . $data['news_id'] . '-' . $data['page_number'];
        },
        'content' => $_content,
    ];
});
