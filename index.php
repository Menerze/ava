<?php

require __DIR__ . '/vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$missoes = [
    [
        "id" => 1,
        "nome" => "Apollo 11",
        "ano" => 1969,
        "agencia" => "NASA",
        "status" => "Concluida"
    ],
    [
        "id" => 2,
        "nome" => "Voyager 1",
        "ano" => 1977,
        "agencia" => "NASA",
        "status" => "Em operacao"
    ],
    [
        "id" => 3,
        "nome" => "Artemis II",
        "ano" => 2026,
        "agencia" => "NASA",
        "status" => "Planejada"
    ],
    [
        "id" => 4,
        "nome" => "Mars Express",
        "ano" => 2003,
        "agencia" => "ESA",
        "status" => "Em operacao"
    ],
    [
        "id" => 5,
        "nome" => "Chang'e 6",
        "ano" => 2024,
        "agencia" => "CNSA",
        "status" => "Concluida"
    ]
];

$app->get('/status', function ($request, $response) {

    $response->getBody()->write(json_encode([
        "status" => "ok"
    ]));

    return $response->withHeader(
        'Content-Type',
        'application/json'
    );
});

$app->get('/missoes', function ($request, $response) use ($missoes) {

    $response->getBody()->write(json_encode($missoes));

    return $response->withHeader(
        'Content-Type',
        'application/json'
    );
});

$app->get('/missoes/{id}', function ($request, $response, $args) use ($missoes) {

    $id = $args['id'];

    foreach ($missoes as $missao) {

        if ($missao['id'] == $id) {

            $response->getBody()->write(json_encode($missao));

            return $response->withHeader(
                'Content-Type',
                'application/json'
            );
        }
    }

    $response->getBody()->write(json_encode([
        "erro" => "Missao nao encontrada"
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
});

$app->post('/missoes', function ($request, $response) {

    $dados = $request->getParsedBody();

    $response->getBody()->write(json_encode([
        "mensagem" => "Missao cadastrada com sucesso",
        "dados" => $dados
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(201);
});

$app->put('/missoes/{id}', function ($request, $response, $args) {

    $dados = $request->getParsedBody();

    $response->getBody()->write(json_encode([
        "mensagem" => "Missao atualizada com sucesso",
        "id" => $args['id'],
        "dados" => $dados
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->delete('/missoes/{id}', function ($request, $response, $args) {

    $response->getBody()->write(json_encode([
        "mensagem" => "Missao removida com sucesso",
        "id" => $args['id']
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json');
});

$app->run();
