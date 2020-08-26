<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 14.07.20
 * Time: 15:29
 */
?>
<h3 class="text-center">Добавить новую задачу</h3>
<form id="saveForm" action="/task/save" method="post">
	<div class="form-group">
		<label for="username_field">Имя пользователя *</label>
		<input class="form-control" type="text" name="username" id="username_field">
        <span id="username" class="task-info text-danger font-italic"></span>
	</div>
	<div class="form-group">
		<label for="email_field">Email *</label>
		<input class="form-control" type="email" name="email" id="email_field">
        <span id="email" class="task-info text-danger font-italic"></span>
	</div>
	<div class="form-group">
		<label for="text_field">Текст задачи *</label>
        <textarea class="form-control" name="text" id="text_field" cols="30" rows="10"></textarea>
        <span id="text" class="task-info text-danger font-italic"></span>
	</div>
	<button id="saveButton" class="btn btn-success">Сохранить</button>
</form>
<div id="successModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Задача успешно сохранена.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Ещё одну?</button>
                <a href="/" class="btn btn-secondary">Назад</a>
            </div>
        </div>
    </div>
</div>
<script src="/assets/js/save.js"></script>
