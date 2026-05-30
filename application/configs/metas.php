<?php


return [

	// modulo
	'main' => [

		// seta os valores default do main
		'defaults' => [
			'title' => "",
			'description' => "",
			'keywords' => "",
			'og:type' => "",
			'og:title' => "",
			'og:description' => "",
			'og:url' => "__SELF_URL__", // palavra chave para a propria URL
			'og:image' => "",
			'og:site_name' => "",
		],

		// controller (isso é um exemplo)
		'index' => [

			// action (isso é um exemplo)
			'index' => [
				'title' => "",
				'og:title' => "",
				'description' => "",
				'og:description' => "",
				'keywords' => "",
			],

			// action (isso é um exemplo)
			'sobre' => [
				'title' => "",
				'og:title' => "",
				'description' => "",
				'og:description' => "",
				'keywords' => "",
			]

		],

		// controller (isso é um exemplo)
		'leiloes' => [

			// action (isso é um exemplo)
			'index' => [
				'title' => "",
				'og:title' => "",
				'description' => "",
				'og:description' => "",
				'keywords' => "",
			],

		],

	],

];
