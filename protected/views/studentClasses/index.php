<?php
/* @var $this StudentClassesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Student Classes',
);

$this->menu=array(
	array('label'=>'Create StudentClasses', 'url'=>array('create')),
	array('label'=>'Manage StudentClasses', 'url'=>array('admin')),
);
?>

<h1>Student Classes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
