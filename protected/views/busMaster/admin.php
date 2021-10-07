<?php
/* @var $this BusMasterController */
/* @var $model BusMaster */

$this->breadcrumbs=array(
	'Bus Masters'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create BusMaster', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bus-master-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Bus Masters</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
 <p style="text-align:right">
       <?php echo CHtml::link('Export to Excel','index.php?r=busMaster/busexcel',array('class'=>'btn btn-success')); ?>

 </p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bus-master-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
		'bus_route',
		'bus_driver',
		'bus_conductor',
		'bus_attendant',
		'internal', 
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
