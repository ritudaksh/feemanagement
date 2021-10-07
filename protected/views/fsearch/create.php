<?php
/* @var $this FsearchController */
/* @var $model Fsearch */

$this->breadcrumbs=array(
	'Fsearches'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Fsearch', 'url'=>array('index')),
	array('label'=>'Manage Fsearch', 'url'=>array('admin')),
);
?>

<h1>Create Fsearch</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>