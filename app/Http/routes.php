<?php

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::post('/', ['as' => 'home', 'uses' => 'HomeController@sendMail']);

Route::get('fetched', ['as' => 'fetched', 'uses' => 'HomeController@fetched']);

Route::get('fetch', 'HomeController@fetch');

Route::get('facebook/login', 'HomeController@facebookLogin');

Route::get('facebook/callback', 'HomeController@facebookCallback');
