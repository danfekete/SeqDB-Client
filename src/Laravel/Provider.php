<?php
/**
 * Copyright (c) 2016, VOOV LLC.
 * All rights reserved.
 * Written by Daniel Fekete
 */

namespace voov\SeqDB\Client\Laravel;


use Illuminate\Support\ServiceProvider;
use voov\SeqDB\Client\Client;
use voov\SeqDB\Client\Connection;

class Provider extends ServiceProvider
{
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('seqdb', function() {
			$conn = new Connection(config('seqdb.host', 'localhost'), config('seqdb.port', '3333'));
			return new Client($conn);
		});

		// register the class name alias too
		$this->app->alias('seqdb', Client::class);
	}

	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			 __DIR__.'/config/seqdb.php' => config_path('seqdb.php'),
		 ]);
	}
}