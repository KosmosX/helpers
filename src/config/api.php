<?php
	
	return [
		'cors' => [
			'standard' => [
				'Access-Control-Allow-Origin'      => env('CORS_ALLOW_ORIGIN', '*'),
				'Access-Control-Allow-Credentials' => env('CORS_ALLOW_CREDENTIALS', 'false'),
				'Access-Control-Allow-Methods'     => env('CORS_ALLOW_METHODS', '*'),
				'Access-Control-Allow-Headers'     => env('CORS_ALLOW_HEADERS', '*'),
				'Access-Control-Max-Age'           => env('CORS_MAX_AGE', '8600'),
			],

			'production' => [
				'Access-Control-Allow-Origin'      => '',
				'Access-Control-Allow-Credentials' => '',
				'Access-Control-Allow-Methods'     => '',
				'Access-Control-Allow-Headers'     => '',
				'Access-Control-Max-Age'           => '',
			],

			'staging' => [
				'Access-Control-Allow-Origin'      => '',
				'Access-Control-Allow-Credentials' => '',
				'Access-Control-Allow-Methods'     => '',
				'Access-Control-Allow-Headers'     => '',
				'Access-Control-Max-Age'           => '',
			],

			'develop' => [
				'Access-Control-Allow-Origin'      => '',
				'Access-Control-Allow-Credentials' => '',
				'Access-Control-Allow-Methods'     => '',
				'Access-Control-Allow-Headers'     => '',
				'Access-Control-Max-Age'           => '',
			],
		]
	];