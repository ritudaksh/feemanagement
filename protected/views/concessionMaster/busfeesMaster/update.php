<?php
/* @var $this BusfeesMasterController */
/* @var $model BusfeesMaster */

$this->breadcrumbs=array(
	'Busfees'=>array('admin'),
	$model->bus_id=>array('view','id'=>$model->bus_id),
	'Update',
);

$this->menu=array(
	
	array('label'=>'Create Busfees', 'url'=>array('create')),
	//array('label'=>'View BusfeesMaster', 'url'=>array('view', 'id'=>$model->bus_id)),
	array('label'=>'Manage Busfees', 'url'=>array('admin')),
);
?>

<h1>Update Busfees <?php echo $model->bus_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'busroute'=>$busroute)); ?>
