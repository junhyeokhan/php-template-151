<?php

namespace junhyeokhan\Service\Statistics;

class StatisticsPdoService implements StatisticsServiceInterface
{
	/**
	 * @var \PDO
	 */
	private $pdo;
	
	/**
	 * @param \PDO
	 */
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function getStatistics($email, $year, $month)
	{
		
		
		
	}
}
