<?php
namespace Astroapp\Src\Models;
use Mysqli;

require_once '..\Models\MySQLConnector.php';

/**
 * Establishes connection to local SQL instance.
 *
 * @author Michael Follari
 *
 * Last updated 10/17/2019
 */
class LocalhostConnector extends MySQLCOnnector{

	private $sqlDSN;

	function __constructor(){
		$this->sqlDSN = '127.0.0.1';
	}

}
?>