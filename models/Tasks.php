<?php

namespace models;

use \core\Model;

class Tasks extends Model{
	public $id;
	public $username;
	public $email;
	public $text;
	public $completed;
	public $edited;

	public $page;
	public $sort;

	public function fieldsTable()
	{
	 return array(
		 'username' => 'Имя пользователя',
		 'email' => 'Email',
		 'text' => 'Текст задачи',
		 'completed' => 'Выполнено'
	 );
 }

 static public function clean_email($value){
	 return filter_var($value, FILTER_VALIDATE_EMAIL);
 }
}
