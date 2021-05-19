<?php
  use yii\bootstrap\Carousel;
  use yii\helpers\Html;
?>

<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<div class="site-index">

	<?php

	$firstSlide = null;

	$carousel = array();
	
	foreach($model as $key=>$news):

	if ($firstSlide == null)
	{
		$firstSlide = $news->id;
	}
	$carousel[] = array('content' => '<img width="100%" src_id='.$news->id.' src='.$news->image.'>', 'caption' => $news->title, 'options' => []);

	endforeach; ?>
	
	<?php
		echo Carousel::widget([
			'items' => $carousel,
			'options' => ['id'=> 'myCarousel', 'class' => 'carousel slide', 'data-interval' => '1200'],
			'controls' => [
			'<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
			'<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
			]
		]);
	?>
	
    <div class="body-content">
	
	</div>
	<?= Html::input('hidden', 'session_id', $session_id, ['id' => 'session_id']) ?>

<?php
$script = <<< JS
    $(".carousel-control").on("click", function(e) {
    //переключение
});

//вызывается перед сменой слайда
$("#myCarousel").on('slide.bs.carousel', function () {

});

//вызывается после смены слайда
$("#myCarousel").on('slid.bs.carousel', function () {
	addStatustic()
});


$("#myCarousel").load('slid.bs.carousel', function () {
	addStatustic()
});

function addStatustic() {
	var src = $('.item.active img');
	var src_id = src.attr('src_id');
	var session_id = $('#session_id').val();
	$.ajax({
  		type: 'POST',
  		url: 'statistic/create',
  		data: 'news_id='+src_id+'&view_count=1&session_id='+session_id,
  		//success: function(data){

  		//}
	});
}


JS;
$this->registerJs($script);
?>

