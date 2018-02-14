<?php

Route::group(['middleware' => 'auth.basic'], function () {
    Route::get('/', 'DashboardController@index');

    Route::get('secureimg', function() {
    	$url = request()->url;
    	$type = 'image/'.pathinfo($url, PATHINFO_EXTENSION);
    	
    	return response(file_get_contents(str_replace('%2F', '/', urlencode($url))))->header('Content-type', $type);
    });
});

Route::post('/webhook/github', 'GitHubWebhookController@gitRepoReceivedPush');

Route::ohDearWebhooks('/oh-dear-webhooks');
