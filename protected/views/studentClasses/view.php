<?php
/* @var $this StudentClassesController */
/* @var $model StudentClasses */

$this->breadcrumbs=array(
	'Student Classes'=>array('index'),
	$model->student_class_id,
);

$this->menu=array(
	
	array('label'=>'Create StudentClasses', 'url'=>array('create')),
	//array('label'=>'Update StudentClasses', 'url'=>array('update', 'id'=>$model->student_class_id)),
	//array('label'=>'Delete StudentClasses', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->student_class_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StudentClasses', 'url'=>array('admin')),
);
?>

<h1>View StudentClasses #<?php echo $model->student_class_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'student_class_id',
		'student_id',
		'class_no',
		'section',
		'started_on',
		'ended_on',
		
	),
)); ?>
