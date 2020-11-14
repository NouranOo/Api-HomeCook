<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('welcome','UserController@welcome');
$router->group(['prefix' => 'Api', 'middleware' => ['cors2', 'cors']], function () use ($router) {
    $router->post('/CookerSignUp', 'UserController@CookerSignUp');
    $router->post('/CookerSignIn', 'UserController@CookerSignIn');
    $router->post('/updatefcm', 'UserController@updateFcm');
    //---------------------User---------------
    $router->post('/UserSignUp', 'UserController@UserSignUp');
    $router->post('/UserSignIn', 'UserController@UserSignIn');
    $router->get('/verifyemail/{id}', 'UserController@verifyemail');
    $router->post('/getguesthome','UserController@getGuestHome');


});

$router->group(['prefix' => 'Api/Cooker', 'middleware' => ['cors2', 'cors', 'UserAuth']], function () use ($router) {
    $router->post('/getCookerMeals','UserController@getCookerMeals');
    $router->post('/addCookMeal','UserController@addCookMeal');
    $router->post('/getAllKitchenTypes','UserController@getAllKitchenTypes');
    $router->post('/updateProfile1','UserController@updateProfile1');
    $router->post('/updateProfile2','UserController@updateProfile2');
    $router->post('/changeOnlineStatus','UserController@changeOnlineStatus');
    $router->post('/TestDistance','UserController@TestDistance');
    $router->post('/getAllNotifications','UserController@getAllNotifications');
    $router->post('/changeAvailableNotification','UserController@changeAvailableNotification');
    $router->post('/editCookMeal','UserController@editCookMeal');
    $router->post('/getcookerinfo','UserController@getcookerinfo');
    $router->post('/checkKitchenName','UserController@checkKitchenName');
    $router->post('/uploadphoto','UserController@uploadphoto');


});

$router->group(['prefix' => 'Api/User', 'middleware' => ['cors2', 'cors', 'UserAuth']], function () use ($router) {
    $router->post('/getHome','UserController@getHome');
    $router->post('/searchmeal','UserController@searchmeal');
    $router->post('/getallmealsofone','UserController@getallmealsofone');
    $router->post('/getallnotifications','UserController@getallnotifs');
    $router->post('/filter','UserController@filter');
    $router->post('/getMealsOFKitchenType','UserController@getMealsOFKitchenType');
    $router->post('/getMealById','UserController@getMealById');
    $router->post('/getallMealsOfCooker','UserController@getallMealsOfCooker');
    $router->post('/addmealtocart','UserController@addmealtocart');
    $router->post('/deletemealfromocart','UserController@deletemealfromocart');
    $router->post('/emptyCart','UserController@emptyCart');
    $router->post('/getCart','UserController@getCart');
    $router->post('/checkCobon','UserController@checkCobon');
    $router->post('/addOrder','UserController@addOrder');
    $router->post('/changephoto','UserController@changephoto');
    $router->post('/changeUserName','UserController@changeUserName');
    $router->post('/changeEmail','UserController@changeEmail');
    $router->post('/changePhone','UserController@changePhone');
    $router->post('/addnewaddress','UserController@addNewAddresse');
    $router->post('/filterByKitchenType','UserController@filterByKitchenType');
    $router->post('/filterByLargestRate','UserController@filterByLargestRate');
    $router->post('/addcookerrate','UserController@addCookerRate');
    $router->post('/changedefaultaddress','UserController@changeDefaultAddress');





});

