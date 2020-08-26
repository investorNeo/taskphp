<?php


namespace controllers;

use \core\Controller;
use \models\Tasks;

class Controller_Task extends Controller {
	public function action_index( $params = [] ) {
		$current_page = $params['page'] ?? 1;
		$current_sort = $params['sort'] ?? 'id ASC';
		$offset       = ( (int) $current_page - 1 ) * 3;
		$select       = array(
			'order'  => $current_sort,
			'limit'  => 3,
			'offset' => $offset
		);
		$model        = new Tasks( $select );

		$model['page'] = $current_page;
		$model['sort'] = $current_sort;

		$pager = new Tasks();

		$this->view->generate( 'main.php', 'layout.php', [ 'model' => $model, 'pager' => $pager ] );
	}

	public function action_create() {
		$this->view->generate( 'create.php', 'layout.php' );
	}

	public function action_save() {
		$model = new Tasks();
		$keys  = $model->fieldsTable();
		foreach ( $keys as $key => $value ) {

			if ( $_POST[ $key ] === '' ) {
				$response[ $key ] = "Необходимо заполнить поле {$value}";
				continue;
			}
			$newVal = $model->validate( $_POST[ $key ] );
			if ( $key === 'email' && ! $model::clean_email( $newVal ) ) {
				$response[ $key ] = "Адрес электронной почты указан некорректно.";
				continue;
			}
			$model->$key = $newVal;
		}
		if ( empty( $response ) ) {
			$model->save();
			$response['status'] = true;
		} else {
			$response['status'] = false;
		}
		echo json_encode( $response );
	}

	public function action_check() {
		$check = $_POST['completed'] ?? null;
		$id    = $_POST['id'] ?? null;
		$auth = $_SESSION['auth']??false;
		$response['status'] = false;
		if ( $auth && $check !== null && $id !== null):
			$model       = new Tasks();
			$model['id'] = (int)$id;
			$model['completed'] = (int)!$check;
			if ($model->update(['id','completed'])){
				$response['status'] = true;
				$response['completed'] = $model['completed'];
			}
		endif;
		echo json_encode( $response );
	}

	public function action_edit() {
		$text = $_POST['text'] ?? null;
		$id    = $_POST['id'] ?? null;
		$auth = $_SESSION['auth']??false;
		$response['status'] = false;
		if ( $auth && $text !== null && $id !== null):
			$model       = new Tasks();
			$model['id'] = (int)$id;
			$model['text'] = $text;
			$model['edited'] = true;
			if ($model->update(['id','text', 'edited'])){
				$response['status'] = true;
				$response['text'] = $model['text'];
				$response['edited'] = $model['edited'];
			}
		endif;
		echo json_encode( $response );
	}
}
