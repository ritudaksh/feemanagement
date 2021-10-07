<?php
/* @var $this BusMasterController */
/* @var $model BusMaster */

$this->breadcrumbs=array(
	'Bus Masters'=>array('index'),
	$model->busdetail_id,
);

$this->menu=array(
	array('label'=>'Create BusMaster', 'url'=>array('create')),
	array('label'=>'Update BusMaster', 'url'=>array('update', 'id'=>$model->busdetail_id)),
	array('label'=>'Manage BusMaster', 'url'=>array('admin')),
);
?>

<h1>View BusMaster #<?php echo $model->busdetail_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'busdetail_id',
		'bus_route',
		'bus_driver',
		'bus_conductor',
		'bus_attendant',
	),
)); ?>
