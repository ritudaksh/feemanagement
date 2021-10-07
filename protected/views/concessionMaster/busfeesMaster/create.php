<?php
/* @var $this BusfeesMasterController */
/* @var $model BusfeesMaster */

$this->breadcrumbs=array(
	'Busfees'=>array('admin'),
	'Create',
);

$this->menu=array(
	
	array('label'=>'Manage Busfees', 'url'=>array('admin')),
);
?>

<h1>Create Busfees</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'busroute'=>$busroute,'modelbusmaster'=>$modelbusmaster)); ?>
