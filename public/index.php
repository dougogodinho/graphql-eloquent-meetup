<?php

use GraphQL\Server\ServerConfig;
use GraphQL\Server\StandardServer;
use GraphQL\Utils\BuildSchema;

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../config/database.php';

$rootValues = [
    'hello' => 'world!',
    'user' => function ($source, $arg) {
        return \App\User::query()->find($arg['id']);
    },
    'users' => function () {
        return \App\User::query()->get();
    },
    'createUser' => function ($source, $arg) {
        return \App\User::query()->create($arg['user']);
    },
    'paginatedUsers' => function ($source, $arg) {
        return \App\User::query()->paginate($arg['size'] ?? null, ['*'], null, $arg['page'] ?? null)->toArray();
    },

];

$schema = BuildSchema::build(file_get_contents(__DIR__ . '/../config/schema.graphql'));

$config = ServerConfig::create()->setDebug(1)->setSchema($schema)->setRootValue($rootValues);

$server = new StandardServer($config);
$server->handleRequest();