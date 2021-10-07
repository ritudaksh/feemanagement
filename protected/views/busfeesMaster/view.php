<?php
/* @var $this BusfeesMasterController */
/* @var $model BusfeesMaster */

$this->breadcrumbs=array(
	'Busfees Masters'=>array('index'),
	$model->bus_id,
);

$this->menu=array(
	
	array('label'=>'Create BusfeesMaster', 'url'=>array('create')),
	//array('label'=>'Update BusfeesMaster', 'url'=>array('update', 'id'=>$model->bus_id)),
	//array('label'=>'Delete BusfeesMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->bus_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BusfeesMaster', 'url'=>array('admin')),
);
?>

<h1>View BusfeesMaster #<?php echo $model->bus_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'bus_id',
		'route',
		'destination',
		'internal',
		'bus_fees',
	),
)); ?>
