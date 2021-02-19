<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
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
            $_content .= '<p>' . $this->faker->text(rand(250, 400)) . '</p>';
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
    }
}
