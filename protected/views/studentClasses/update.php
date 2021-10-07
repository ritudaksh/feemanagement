<?php
/* @var $this StudentClassesController */
/* @var $model StudentClasses */

$this->breadcrumbs=array(
	'Student Classes'=>array('admin'),
	$model->student_class_id=>array('view','id'=>$model->student_class_id),
	'Update',
);

$this->menu=array(
	
	array('label'=>'Create Student Class', 'url'=>array('create')),
	//array('label'=>'View StudentClasses', 'url'=>array('view', 'id'=>$model->student_class_id)),
	array('label'=>'Manage Student Class', 'url'=>array('admin')),
);
?>

<h1>Update Student Class <?php echo $model->student_class_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'searchbox'=>$searchbox)); ?>
