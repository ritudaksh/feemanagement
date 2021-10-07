<?php
/* @var $this StudentMasterController */
/* @var $model StudentMaster */

$this->breadcrumbs=array(
	'Student Masters'=>array('index'),
	$model->student_id=>array('view','id'=>$model->student_id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List StudentMaster', 'url'=>array('index')),
	array('label'=>'Create StudentMaster', 'url'=>array('create')),
	array('label'=>'View Student Fees', 'url'=>array('view', 'id'=>$model->student_id)),
	//array('label'=>'Manage StudentMaster', 'url'=>array('admin')),
);
?>

<h1>Update StudentMaster <?php echo $model->student_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'admdate'=>$admdate,'route'=>$route, 'destination'=>$destination)); ?>
