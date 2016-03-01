<?php
/**
 * Copyright (c) 2016, VOOV LLC.
 * All rights reserved.
 * Written by Daniel Fekete
 */

namespace voov\SeqDB\Client;


use voov\SeqDB\Client\Exceptions\ConnectionException;

class Connection
{
	private $host;
	private $port;

	private $conn;

	/**
	 * Connection constructor.
	 * @param $host
	 * @param $port
	 */
	public function __construct($host, $port)
	{
		$this->host = $host;
		$this->port = $port;

		$this->conn = fsockopen($host, $port);
	}

	/**
	 * Always close connection on destruct!
	 */
	function __destruct()
	{
		fclose($this->conn);
	}


	/**
	 * Close connection
	 */
	public function close()
	{
		fclose($this->conn);
	}

	/**
	 * Write to TCP server
	 * @param $cmd
	 * @return string
	 * @throws ConnectionException
	 */
	public function write($cmd)
	{
		if(!$this->conn) throw new ConnectionException;
		fwrite($this->conn, $cmd);
		$buf ="";
		while(!feof($this->conn)) {
			$buf .= fgets($this->conn);
		}

		return $buf;
	}
}