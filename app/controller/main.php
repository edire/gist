<?php
class main extends spController
{
	function index(){
	$cateid=$_GET['cate'];
	$conditions=array('cid'=>$cateid);
	$article=$this->select($conditions);
    echo $this->JSON($article);
	}
	
 /**************************************************************
  *			数据库读取操作
  *************************************************************/
	public function select($conditions){
		$user=spClass('users');
		$cate=spClass('categories');
		$article=spClass('articles');
		
		
		$article_sql=$article->findAll($conditions);
		
		$i=0;
		foreach($article_sql as $arc){
			$result[$i][title]=$arc[title];
			$user_sql=$user->findAll(array('id'=>$arc[uid]));
			$result[$i][user]=$user_sql[0][name];//id
			$cate_sql=$cate->findAll(array('id'=>$arc[cid]));
			$result[$i][cate]=$cate_sql[0][name];//cate
			$result[$i][addtime]=$arc[addtime];
			$result[$i][comments]=$arc[comments];
			$i++;
		}
		return $result;
		
	}
	
	public function JSON($array) {
			
  /**************************************************************
 *
 *  使用特定function对数组中所有元素做处理
 *  @param  string  &$array     要处理的字符串
 *  @param  string  $function   要执行的函数
 *  @return boolean $apply_to_keys_also     是否也应用到key上
 *  @access public
 *
 *************************************************************/
			function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
			{
				static $recursive_counter = 0;
				if (++$recursive_counter > 1000) {
					die('possible deep recursion attack');
				}
				foreach ($array as $key => $value) {
					if (is_array($value)) {
						arrayRecursive($array[$key], $function, $apply_to_keys_also);
					} else {
						$array[$key] = $function($value);
					}
			  
					if ($apply_to_keys_also && is_string($key)) {
						$new_key = $function($key);
						if ($new_key != $key) {
							$array[$new_key] = $array[$key];
							unset($array[$key]);
						}
					}
				}
				$recursive_counter--;
			}
			  
	  
/**************************************************************
 *
 *  将数组转换为JSON字符串（兼容中文）
 *  @param  array   $array      要转换的数组
 *  @return string      转换得到的json字符串
 *  @access public
 *
 *************************************************************/
        arrayRecursive($array, 'urlencode', true);
        $json = json_encode($array);
        return urldecode($json);
    }
}