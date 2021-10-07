<?php
/* @var $this BusMasterController */
/* @var $model BusMaster */

$this->breadcrumbs=array(
	'Bus Masters'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage BusMaster', 'url'=>array('admin')),
);
?>

<h1>Create BusMaster</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>