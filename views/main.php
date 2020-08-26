<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 13.07.20
 * Time: 0:02
 */
$totalItems = count( $pager->getAllRows() );
$pages      = ceil( $totalItems / 3 );

$page = ( $model['page'] == 0 ) ? 1 : ( $model['page'] > $totalItems ) ? $pages : $model['page'];
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-2 align-self-center">
            <span>Сортировать по: </span>
        </div>
        <div class="col-sm-12 col-md-9 task-filter d-flex flex-md-row flex-sm-column align-items-center justify-content-lg-around justify-content-sm-start flex-wrap my-3">
			<?php
			$fieldsTable = $model->fieldsTable();
			foreach ( $fieldsTable as $key => $value ):
				echo <<<TH
			    <div class="d-flex flex-row align-items-center">
    <span>{$value}</span>
    <div class="d-flex flex-column">
    <a class="arrow text-center px-2 mr-4" href="/?page={$model['page']}&sort={$key}+ASC">
        <svg xmlns="http://www.w3.org/2000/svg" height="8" width="8">
            <path fill="#C0C0C0" d="M0 4H8L4 0z"/>
        </svg>
    </a>
    <a class="arrow text-center px-2 mr-4" href="/?page={$model['page']}&sort={$key}+DESC">
        <svg xmlns="http://www.w3.org/2000/svg" height="8" width="8">
            <path fill="#C0C0C0" d="M0 0H8L4 4z"/>
        </svg>
    </a>
    </div>
</div>
TH;
			endforeach;
			?>
        </div>
    </div>
</div>

<table id="task" class="table table-striped">
    <thead>
    <tr>
        <th>Задача</th>
        <th>Статус</th>
    </tr>
    </thead>
    <tbody>
	<?php
	$data = $model->getAllRows();
	if ( empty( $data ) ):
		echo '<tr><td>Нет данных</td></tr>';
	else:
		foreach ( $data as $datum ) :
			$check = $datum['completed']
                ?'<span class="task-completed" data-id="'.$datum['id'] . '" data-completed="1"><img src="/assets/img/checkbox-checked.svg" alt="checkbox-checked"></span>'
                :'<span class="task-completed" data-id="'.$datum['id'] . '" data-completed="0"><img src="/assets/img/checkbox-unchecked.svg" alt="checkbox-unchecked"></span>';
            $edited = $datum['edited']
                ? '<img src="/assets/img/pencil.svg" alt="pencil" data-toggle="tooltip" data-placement="top" title="Отредактировано администратором">'
                :'';
			echo <<<EOT
<tr>
    <td>
        <div class="row">
            <div class="col-sm-12 task-text" data-id="{$datum['id']}" >{$datum['text']}</div>
            <div class="col-sm-12 text-muted">Пользователь <span class="text-reset ">{$datum['username']}</span> <span class="text-primary">{$datum['email']}</span></div>
        </div>
    </td>
    <td>{$check}&emsp;{$edited}</td>
</tr>
EOT;
		endforeach;
	endif;
	?>
    </tbody>
</table>

<nav aria-label="Page navigation example">
    <ul class="pagination">
		<?php
		echo "<li class=\"page-item\"><a class=\"page-link\" href=\"/?page=1&sort={$model['sort']}\">Первая</a></li>";
		for ( $i = 1; $i <= $pages; $i ++ ) {
			$active = $i == $page ? 'active' : '';
			echo "<li class=\"page-item {$active}\"><a class=\"page-link\" href=\"/?page={$i}&sort={$model['sort']}\">{$i}</a></li>";
		}
		echo "<li class=\"page-item\"><a class=\"page-link\" href=\"/?page={$pages}&sort={$model['sort']}\">Последняя</a></li>";
		?>
    </ul>
</nav>
<a href="/task/create"
   class="d-flex justify-content-center align-items-center new-task mx-auto text-center text-success text-decoration-none">
    <span>+ Добавить новую задачу</span>
</a>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<?php
if ($auth){
    echo '<script src="/assets/js/edit.js"></script>';
}
?>
