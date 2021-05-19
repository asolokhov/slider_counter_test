<?php

/* @var $this yii\web\View */

$this->title = 'Статистика';
?>

<div class="site-index">

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">title</th>
      <th scope="col">Показов</th>
    </tr>
  </thead>
  <tbody>

<?php foreach($model as $key=>$statustic): ?>
	
    <tr>
      <th scope="row"><?= $statustic->news->id ?></th>
      <td><?= $statustic->news->title ?></td>
      <td><?= $statustic->view_count ?></td>
      
    </tr>
	
<?php endforeach; ?>


</tbody>
</table>
</div>