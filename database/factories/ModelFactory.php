<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'activated' => true,
        'created_at' => $faker->dateTime,
        'deleted_at' => null,
        'email' => $faker->email,
        'first_name' => $faker->firstName,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'last_login_at' => $faker->dateTime,
        'last_name' => $faker->lastName,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'updated_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, static function (Faker\Generator $faker) {
    return [
        'activated' => $faker->boolean(),
        'address' => $faker->text(),
        'avatar' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'email' => $faker->email,
        'email_verified_at' => $faker->dateTime,
        'job' => $faker->sentence,
        'name' => $faker->firstName,
        'password' => bcrypt($faker->password),
        'phone' => $faker->sentence,
        'remember_token' => null,
        'updated_at' => $faker->dateTime,
        'uuid' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Request::class, static function (Faker\Generator $faker) {
    return [
        'activated' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'message' => $faker->text(),
        'sender_id' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'user_id' => $faker->sentence,
        
        
    ];
});
