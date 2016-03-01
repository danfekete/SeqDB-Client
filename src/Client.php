<?php
/**
 * Copyright (c) 2016, VOOV LLC.
 * All rights reserved.
 * Written by Daniel Fekete
 */

namespace voov\SeqDB\Client;


use voov\SeqDB\Client\Exceptions\InvalidCommandException;
use voov\SeqDB\Client\Exceptions\SetException;

class Client
{
	private $connection;

	/**
	 * Client constructor.
	 * @param Connection $connection
	 */
	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * Execute command on server
	 * @param $cmd
	 * @param array|null ...$arguments
	 * @return string
	 * @throws Exceptions\ConnectionException
	 * @throws InvalidCommandException
	 */
	protected function command($cmd, ...$arguments)
	{
		$argumentList = implode(' ', $arguments);
		$resp = $this->connection->write("{$cmd} {$argumentList}");
		if(strcmp($resp, "INVALID COMMAND")) throw new InvalidCommandException;
		return $resp;
	}


	/**
	 * Get value from bucket and sequence
	 * @param $bucket
	 * @param $seq
	 * @return int
	 * @throws Exceptions\ConnectionException
	 */
	public function get($bucket, $seq)
	{
		$response = $this->command("GET", $bucket, $seq);
		return intval($response);
	}

	/**
	 * Set a new value for the bucket and sequence
	 * @param $bucket
	 * @param $seq
	 * @param $value
	 * @throws SetException
	 */
	public function set($bucket, $seq, $value)
	{
		$response = $this->command("SET", $bucket, $seq, $value);
		if(strcmp($response, "OK") != 0) throw new SetException;
	}

	/**
	 * Increment bucket and sequence by one
	 * @param $bucket
	 * @param $seq
	 * @return int
	 */
	public function inc($bucket, $seq)
	{
		$response = $this->command("INC", $bucket, $seq);
		return intval($response);
	}
}