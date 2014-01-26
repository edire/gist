<?php
class main extends spController
{
	function index(){
	if($_GET['cate']){
		$cateid=$_GET['cate'];
		$conditions=array('cid'=>$cateid);
	}else{
		$conditions=null;
	}
	if($_GET['page']){
		$page=$_GET['page'];
		
	}else{
		$page=1;
	}
	
	$article=$this->selectlist($conditions);
			$arr=$this->JSON($article);
			echo $arr;
	}
	
	function article(){
			if($_GET['id']){
				$pageid=$_GET['id'];
				$conditions=array('id'=>$pageid);
			}else{
				return false;
			}
			
			$article=$this->selectarc($conditions);
			$arr=$this->JSON($article);
			echo $arr;
			
	}						

	
	
 /**************************************************************
  *			数据库读取操作
  *************************************************************/
	public function selectlist($conditions){
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
			$result[$i][addtime]=date("m-d H:i:s",$arc[addtime]);
			$result[$i][edittime]=date("m-d H:i:s",$arc[edittime]);
			$result[$i][comments]=$arc[comments];
			$result[$i][favorites]=$arc[favorites];
			$i++;
		}
		return $result;

		
	}
	
	
	public function selectarc($conditions){
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
			$result[$i][addtime]=date("m-d H:i:s",$arc[addtime]);
			$result[$i][edittime]=date("m-d H:i:s",$arc[edittime]);
			$result[$i][comments]=$arc[comments];
			$result[$i][favorites]=$arc[favorites];
			$result[$i][content]=$arc[content];
			$i++;
		}
		return $result;

		
	}
	
	public function gsh($array){
	$i=0;
		foreach($array as $arc)
		{
				
				$arr[$i][title]=$this->geshihua($arc[title]);
				$arr[$i][content]=$this->geshihua($arc[content]);
				$arr[$i][cate]=$this->geshihua($arc[cate]);
				$arr[$i][user]=$this->geshihua($arc[user]);
				$arr[$i][addtime]=$this->geshihua($arc[addtime]);
				$arr[$i][edittime]=$this->geshihua($arc[edittime]);
				$arr[$i][comments]=$this->geshihua($arc[comments]);
				$arr[$i][favorites]=$this->geshihua($arc[favorites]);
				$i++;
		}
		return $arr;
	}
	
	
	
	public function JSON($array) {
			
	$array=$this->gsh($array);
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


//====================转json之前格式化========================================
public function geshihua($str){
	$search = array ("'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
	                 "'&(quot|#34);'i",                 // 替换 HTML 实体
	                 "'&(amp|#38);'i",
	                 "'&(lt|#60);'i",
	                 "'&(gt|#62);'i",
	                 "'&(nbsp|#160);'i",
	                 "'&(iexcl|#161);'i",
	                 "'&(cent|#162);'i",
	                 "'&(pound|#163);'i",
	                 "'&(copy|#169);'i",
	                 "'<[\/\!]*?[^<>]*?>'si",           // 去掉 HTML 标记
					 "'[\n]+'",
	                 "'([\r\n])[\s]+'",                 // 去掉空白字符
	                 "'&#(\d+);'e");                    // 作为 PHP 代码运行
	




	$replace = array ("",
	                  "\"",
	                  "&",
	                  "<",
	                  ">",
	                  " ",
	                  chr(161),
	                  chr(162),
	                  chr(163),
	                  chr(169),
	                  "",
	                  "<br>",
	                  "\\1",
	                  "chr(\\1)");
	
	$result = preg_replace ($search, $replace, $str);
	return $result;
}
}
