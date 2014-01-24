<?php
class main extends spController
{
	function index(){
		$article=$this->select();
		foreach($article as $art){
			echo "$art[title]<br>";
			echo "$art[user]<br>";
			echo "$art[cate]<br>";
			echo "$art[addtime]<br>";
			echo "$art[comments]<br><hr>";
		}
	}
	public function select(){
		$user=spClass('users');
		$cate=spClass('categories');
		$article=spClass('articles');
		
		
		$article_sql=$article->findAll();
		
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
}