<?php
namespace webApp;
use \Symfony\Component\HttpFoundation as Http;
use  \Silex\Application as Application;
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/model.php';
require_once __DIR__ . '/../src/TableModel.php';

$app = new Application();
//получение всей таблицы
$app->get('/', function () {
    $model = new Model();
    $model->load();
    $response = Http\Response::create();
    $response->headers->set('Content-Type', 'json');
    $response->setContent(json_encode($model->getRows()));
    return $response;
});
//вывод одной строки с id
$app->get('/{id}', function ($id) {
    $model = new Model();
    $model->load();
    $response = Http\Response::create();
    $response->headers->set('Content-Type', 'json');
    $response->setContent(json_encode($model->getRow($id)));
    return $response;
});
//добавление новой строки
$app->post('/', function (Http\Request $request) {
    $model = new Model();
    $model->load();
    $response = Http\Response::create();
    if ($request->getContentType() == 'json') {
        $model->addRow(json_decode($request->getContent(), true));
    } else {
        $response->setStatusCode(400);
        $response->headers->set('Content-Type', 'text');
        $response->setContent('Content-Type must be json. Pls check your request');
    }
    $model->save();
    return $response;
});
//обновление одной строки
$app->put('/{id}', function (Http\Request $request, $id) {
    $model = new Model();
    $model->load();
    $response = Http\Response::create();
    if ($request->getContentType() == 'json') {
        if ($model->updateRow($id, json_decode($request->getContent(), true))) {
            $response->setStatusCode(200);
            $model->save();
        } else {
            $response->setStatusCode(404);
            $response->headers->set('Content-Type', 'text');
            $response->setContent('Not find this id');
        }
    } else {
        $response->setStatusCode(400);
        $response->headers->set('Content-Type', 'text');
        $response->setContent('Content-Type must be json. Pls check your request');
    }
    return $response;
});
//удаление одной строки
$app->delete('/{id}', function (Http\Request $request, $id) {
    $model = new Model();
    $model->load();
    $response = Http\Response::create();
    if ($model->deleteRow($id)) {
        $response->setStatusCode(200);
        $model->save();
    } else {
        $response->setStatusCode(404);
        $response->headers->set('Content-Type', 'text');
        $response->setContent('Not find this id');
    }
    return $response;
});

$app->run();