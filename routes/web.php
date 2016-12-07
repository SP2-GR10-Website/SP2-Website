<?php

//Route-info
Route::group(['prefix' => 'route-info'], function () {
	Route::get('/', 'PagesController@getRouteInfo');
	Route::get('/getRoute', 'InfoController@getRouteInfo');
});

//Trein-info
Route::group(['prefix' => 'trein-info'], function () {
	Route::get('/', 'PagesController@getTreinInfo');
	Route::get('/getTrein', 'InfoController@getTreinInfo');
});

//Station-info
Route::group(['prefix' => 'station-info'], function () {
	Route::get('/', 'PagesController@getStationInfo');
	Route::get('/getStation', 'InfoController@getStationInfo');
});

//Contact
Route::group(['prefix' => 'contact'], function () {
	Route::get('/', 'PagesController@getContact');
});

//Tarieven
Route::group(['prefix' => 'tarieven'], function () {
	Route::get('/', 'PagesController@getTarieven');
});

Route::get('/autofillStation','InfoController@autofillStation');

Route::get('/testDB', 'InfoController@testDB');

Route::get('/', 'PagesController@getIndex');


