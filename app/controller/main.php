<?php
class main extends spController
{
	function index(){
		$article=$this->select();
		print_r($article);
	}
	public function select(){
		$user=spClass('users');
		$fenlei=spClass('categories');
		$article=spClass('articles');
		
		
		$article_sql=$article->findAll();
		
		i=0;
		foreach($article_sql as $arc){
			$result[i][title]=$arc[title];
		}
		return $result;
		
	}
}