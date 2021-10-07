<?php
/* @var $this StudentMasterController */
/* @var $model StudentMaster */

$this->breadcrumbs=array(
	'Student Masters'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StudentMaster', 'url'=>array('index')),
	array('label'=>'Manage StudentMaster', 'url'=>array('admin')),
);
?>

<h1>Create StudentMaster</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'admdate'=>$admdate,'modelclass'=>$modelclass,'route'=>$route, 'destination'=>$destination)); ?>
