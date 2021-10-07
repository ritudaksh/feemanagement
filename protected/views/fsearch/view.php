<?php
/* @var $this FsearchController */
/* @var $model Fsearch */

$this->breadcrumbs=array(
	'Fsearches'=>array('index'),
	$model->uid,
);

$this->menu=array(
	array('label'=>'List Fsearch', 'url'=>array('index')),
	array('label'=>'Create Fsearch', 'url'=>array('create')),
	array('label'=>'Update Fsearch', 'url'=>array('update', 'id'=>$model->uid)),
	array('label'=>'Delete Fsearch', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->uid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Fsearch', 'url'=>array('admin')),
);
?>

<h1>View Fsearch #<?php echo $model->uid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'uid',
		'username',
		'email',
		'media',
		'country',
	),
)); ?>
