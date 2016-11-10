<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $query = http_build_query([
        'client_id' => '4',
        'redirect_uri' => 'http://tripbuilderclient.dev/callback',
        'response_type' => 'code',
        'scope' => ''
    ]);

    return redirect('http://tripbuilder.dev/oauth/authorize?'.$query);
});

Route::get('/callback', function (Illuminate\Http\Request $request) {
    $http = new \GuzzleHttp\Client;

    $response = $http->post('http://tripbuilder.dev/oauth/token', [
        'form_params' => [
            'client_id' => '4',
            'client_secret' => 'X4yse2MGKxFd3gy2ORaQApehXjYCgTkxe7bBSaKE',
            'grant_type' => 'authorization_code',
            'redirect_uri' => 'http://tripbuilderclient.dev/callback',
            'code' => $request->code,
        ],
    ]);
   $token =  json_decode((string) $response->getBody(), true);
   Session::set('access_token', $token['access_token']);
  
   //return view('trips.airports', ['token' => $token['access_token'], 'type' => $token['token_type']]);
  return $token;
});

Route::get('/airports', function(){    
    //return view('trips.airportsList');
    return view('trips.airports');
});