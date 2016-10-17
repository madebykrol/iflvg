<?php
namespace yogi\framework\io\db\interfaces; 

interface IDal {
	public function getColumns($table = null);
	
	public /* boolean */ function get($table = null, $limit = null, $offset = null);
	
	public /* boolean */ function getWhere($table = null, $whereArray , $limit = null, $offset = null);
	
	public /* boolean */ function delete($table = null);
	
	/**mbk
	 * 
	 * @throws Exception
	 * @param string $table
	 */
	public /* void */ function truncate($table = null);
	
	public /* boolean */ function countAll($table = null);
	
	public /* int */ function countAllresults();
	
	public /* void */ function set($field, $value);
	
	public /* boolean */ function insert ($table = null, $dataSet = array());
	
	public /* boolean */ function insertBatch ($table = null, $dataSet);
	
	public /* boolean */ function update ($table = null, $dataSet = array());
	
	public /* boolean */ function updateBatch ($table = null, $dataSet);
	
	/**
	 * @param string $table
	 * @return boolean
	 */
	public /* boolean */ function tableExists($table);
	
	public /* boolean */ function createTable($table, array $definition);
	
	/**
	 * @param unknown $table
	 * @param array $definition
	 */
	public /* void */ function updateTable($table, array $definition);
	
	public /* void */ function select ($select);
	
	public /* void */ function selectMax($field, $as = null);
	
	public /* void */ function selectMin($field, $as = null);
	
	public /* void */ function selectSum($field, $as = null);
	
	public /* void */ function selectAvg($field, $as = null);
	
	public /* void */ function from($table);
	
	public /* void */ function join($table, $on, $direction = "");
	
	public /* void */ function where($where);
	
	public /* void */ function whereOR ($where);
	
	public /* void */ function groupBy($groupBy);
	
	public /* void */ function distinct ();
	
	public /* void */ function orderBy ($field, $direction = 'DESC');
	
	public /* void */ function limit($limit, $offset = null);
	
	public /* string */ function getLastExecutedQuery ();
	
	public /* array */ function getResult ();
	
	public /* string */ function flushResult ($flushCache = false);
	
	public /* void */ function query ();
	
	public /* void */ function useQueryCache ();
	
	public /* void */ function dontUseQueryCache ();
	
	public /* int */ function getLastInsertId();
	
	public /* void */ function clearCache ();
	
	/**
	 * Escaping characters \0 \n \r \\ ' " u00a5 u20a9 and 032
	 * use this with caution, it only escapes the given characters and queries should always be parameterized.
	 * !!! THIS METHOD SHOULD NOT BE USED TO ESCAPE USER INPUT POST DATA.. !!! 
	 * !!! ONLY USE PARAMETERIZED QUERIES FOR USER DATA. !!!
	 * @param unknown $input
	 */
	public /* string */ function sanitize ($input);
}