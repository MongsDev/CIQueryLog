<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 쿼리 전부를 로깅
 */

class DbLog
{
	function logQueries()
	{
		$CI =& get_instance();

		if(!isset($CI) || empty($CI)) {
			return;
		}

		$ext = isset(pathinfo($_SERVER['SCRIPT_URL'])['extension']) ? strtolower(pathinfo($_SERVER['SCRIPT_URL'])['extension']) : '';
		$url = '/' . $CI->uri->uri_string;
		$url = empty($ext) ? $url : str_replace('.' . $ext, '', $url);
		$data = '';

		foreach($CI as $a) {
			if(!is_object($a)) {
				continue;
			}

			foreach($a as $b) {
				if(!is_object($b)) {
					continue;
				}

				if(is_object($b) && isset($b->queries)) {
					$querys = self::getQuery($b->queries);

					if(!empty($querys)) {
						foreach($querys as $row) {
							$data .= $row . "\n";
						}
					}
				}
			}
		}

		self::saveLog($url, $data);
	}

	function saveLog($url, $query)
	{
		if(empty($url) || empty($query)) {
			return;
		}

		// 파일로 로그 남길때
		//$log_path = FCPATH . 'data/log/query_log-' . date('Y-m-d') . '.php';
		//file_put_contents($log_path, $data, FILE_APPEND);

		$CI =& get_instance();
		$tranggle_log_db = $CI->load->database('tranggle_log', true);
		$url = db_escape($url, $tranggle_log_db);
		$query = db_escape($query, $tranggle_log_db);

		$tranggle_log_db->query("
			INSERT INTO api_query_log SET
				url = '$url',
				query = '$query',
				wdate = NOW()
		");
	}

	function getQuery($query)
	{
		if(!is_array($query) || empty($query)) {
			return;
		}

		$output = array();

		foreach($query as $row) {
      			// 쿼리 파라미터 제거, 중복 제거
			$row = preg_replace("/(\r\n|\t|\s)/", ' ', trim($row));
			$row = preg_replace('/\s\s+/', ' ', $row);
			$row = str_replace('"', "'", $row);
			$row = str_replace(' =', '=', $row);
			$row = str_replace('= ', '=', $row);
			$row = preg_replace("/='.*'/", "=''", $row);
			$row = preg_replace("/=[0-9]+/", "=''", $row);
			
			$row = preg_replace("/'[^']*'/", "''", $row);
			$row = preg_replace("/, [0-9]*,/", ' ', $row);
			$row = preg_replace("/\([0-9]*,/", '(,', $row);

			$row = trim($row);

			$row = str_replace('; ', ';', $row);
			$row = trim($row);

			if(!preg_match('/;$/', $row)) {
				$row .= ';';
			}

			$output[] = $row;
		}

		$output = array_unique($output);

		return $output;
	}
	
	function saveQueryLog()
	{
		$logdb = $this->load->database('logdb', true);

		$list = db_list("
			select
				no, url, `query`
			from api_query_log_sum_end
			limit 10
		", false, $logdb);

		foreach($list as $row) {
			if(empty($row['query'])) {
				continue;
			}

			$query = trim($row['query']);
			$arr = explode("\n", $query);
			$out = array();
			foreach($arr as $line) {
				if(empty($line)) {
					continue;
				}
				$out[] = $line;
			}

			$out = array_unique($out);
			asort($out);
			$query = implode("\n", $out);
			$query = db_escape($query, $logdb);
			$logdb->query("
				replace into api_query_log_sum_uniqe set
					`url` = '{$row['url']}',
					`query` = '$query'
			");
		}

		echo 'ok';
		exit;
	}

	function updateQueryLog()
	{
		$logdb = $this->load->database('logdb', true);

		$list = db_list("
			select
				no, url, `query`
			from api_query_log_sum_uniqe
			where result > 0
			limit 300
		", false, $logdb);

		foreach($list as $row) {
			if(empty($row['query'])) {
				continue;
			}

			$query = trim($row['query']);
			$arr = explode("\n", $query);
			$out = array();
			foreach($arr as $line) {
				if(empty($line)) {
					continue;
				}

				$line = preg_replace("/'[^']*'/", "''", $line);
				$line = preg_replace("/, [0-9]*,/", ' ', $line);
				$line = preg_replace("/\([0-9]*,/", '(,', $line);
				$out[] = $line;
			}

			$out = array_unique($out);
			asort($out);
			$query = implode("\n", $out);
			$query = db_escape($query, $logdb);
			$logdb->query("
				update api_query_log_sum_uniqe set
					`query` = '$query',
					result = 1
				where no = '{$row['no']}'
			");
		}

		echo 'ok';
		exit;
	}
}
