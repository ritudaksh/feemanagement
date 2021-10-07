<?php
/* @var $this StudentClassesController */
/* @var $model StudentClasses */

$this->breadcrumbs=array(
	'Student Classes'=>array('admin'),
	'Create',
);

$this->menu=array(
	
	array('label'=>'Manage Student Classes', 'url'=>array('admin')),
);
?>

<h1>Create Student Class</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'searchbox'=>$searchbox)); ?>
