<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/database.php';

use App\Comment;
use App\Post;
use App\User;

use Faker\Factory;
use Illuminate\Support\Collection;

$faker = Factory::create('pt_BR');

$users = new Collection;

for ($i = 0; $i < 10; $i++) {
    $users[] = User::query()->create([
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'birthday' => $faker->dateTimeThisCentury('10 years ago'),
        'address' => [
            'street' => $faker->streetAddress,
            'city' => $faker->city,
            'state' => $faker->state,
            'postcode' => $faker->postcode
        ],
    ]);
}

$users->each(function ($user) use ($users) {
    $randomUsers = $users->random(4)->reject(function ($pick) use ($user) {
        return $pick->id == $user->id;
    });
    $user->follows()->sync($randomUsers->pluck('id'));
});

$posts = new Collection;

for ($i = 0; $i < 50; $i++) {
    $posts[] = Post::query()->create([
        'title' => $faker->sentence,
        'content' => $faker->text,
        'user_id' => $users->random()->id,
    ]);
}

for ($i = 0; $i < 200; $i++) {
    Comment::query()->create([
        'content' => $faker->sentence,
        'name' => $faker->name,
        'email' => $faker->email,
        'post_id' => $posts->random()->id,
    ]);
}