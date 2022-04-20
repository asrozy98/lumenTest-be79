<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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


$router->group(['prefix' => 'auth'], function ($router) {
    $router->post('/dosen/register', ['uses' => 'Api\Auth\AuthController@register']);
    $router->post('/dosen/login', ['uses' => 'Api\Auth\AuthController@login']);

    $router->post('/mahasiswa/register', ['uses' => 'Api\Auth\AuthController@register']);
    $router->post('/mahasiswa/login', ['uses' => 'Api\Auth\AuthController@login']);

    $router->post('/profile', ['uses' => 'Api\Auth\AuthController@profile']);
    $router->post('/refresh', ['uses' => 'Api\Auth\AuthController@refresh']);
    $router->post('/logout', ['uses' => 'Api\Auth\AuthController@logout']);
});

$router->group(['middleware' => ['jwtAuth', 'roleAuth'], 'prefix' => 'dosen'], function ($router) {
    $router->get('profile', ['uses' => 'Api\Auth\AuthController@profile']);
    $router->post('import', ['uses' => 'Api\Dosen\DosenController@importMahasiswa']);
    $router->put('import', ['uses' => 'Api\Dosen\DosenController@importMahasiswa']);
    $router->get('nilai', ['uses' => 'Api\Dosen\DosenController@nilai']);
    $router->put('nilai', ['uses' => 'Api\Dosen\DosenController@nilaiStore']);
    $router->post('nilai', ['uses' => 'Api\Dosen\DosenController@nilaiStore']);
    $router->delete('nilai/delete', ['uses' => 'Api\Dosen\DosenController@delete']);
});

$router->group(['middleware' => ['jwtAuth'], 'prefix' => 'mahasiswa'], function ($router) {
    $router->get('/', ['uses' => 'Api\Mahasiswa\MahasiswaController@indexNilai']);
    $router->get('/list', ['uses' => 'Api\Mahasiswa\MahasiswaController@index']);
    $router->get('profile', ['uses' => 'Api\Auth\AuthController@profile']);
    $router->get('rata-rata', ['uses' => 'Api\NilaiController@average']);
    $router->get('rata-rata/jurusan', ['uses' => 'Api\NilaiController@averageJurusan']);
});
