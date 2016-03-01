<?php
/**
 * Copyright (c) 2016, VOOV LLC.
 * All rights reserved.
 * Written by Daniel Fekete
 */

namespace voov\SeqDB\Client\Laravel;


use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade
{
	protected static function getFacadeAccessor()
	{
		return 'seqdb';
	}
	
}