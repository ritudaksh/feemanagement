<?php
/* @var $this BusMasterController */
/* @var $model BusMaster */

$this->breadcrumbs=array(
	'Bus Masters'=>array('index'),
	$model->busdetail_id=>array('view','id'=>$model->busdetail_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create BusMaster', 'url'=>array('create')),
	array('label'=>'Manage BusMaster', 'url'=>array('admin')),
);
?>

<h1>Update BusMaster <?php echo $model->busdetail_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>