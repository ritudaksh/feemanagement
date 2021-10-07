<?php
/* @var $this FsearchController */
/* @var $model Fsearch */

$this->breadcrumbs=array(
	'Fsearches'=>array('index'),
	$model->uid=>array('view','id'=>$model->uid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Fsearch', 'url'=>array('index')),
	array('label'=>'Create Fsearch', 'url'=>array('create')),
	array('label'=>'View Fsearch', 'url'=>array('view', 'id'=>$model->uid)),
	array('label'=>'Manage Fsearch', 'url'=>array('admin')),
);
?>

<h1>Update Fsearch <?php echo $model->uid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>