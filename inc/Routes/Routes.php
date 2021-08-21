<?php


use Inc\Controllers\BaseController;
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\SimpleRouter\Router;
use Pecee\Http\Request;
use Pecee\SimpleRouter\Handlers\IExceptionHandler;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

/**
 * App controllers
 */
use Inc\Controllers\HomeController;


$helper = new BaseController();
$helper->helperFile();

// SimpleRouter::get('/', function () {
//     return 'Hello world';
// });

SimpleRouter::get('/', [HomeController::class,'start']);

SimpleRouter::get('/test', function () {
    return 'test route';
});

SimpleRouter::post('/submit', function(){
    $url = input('url','none','post');
    HomeController::form($url);
});

SimpleRouter::get('/not-found', function () {
    return 'page not found';
});

SimpleRouter::get('/forbidden', 'PageController@notFound');

SimpleRouter::error(function (Request $request, \Exception $exception) {

    switch ($exception->getCode()) {
            // Page not found
        case 404:
           response()->redirect('/not-found');
            
            // Forbidden
        case 403:
            response()->redirect('/forbidden');
    }
});