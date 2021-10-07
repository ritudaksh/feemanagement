<?php
/* @var $this StudentFeesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Student Fees',
);

$this->menu=array(
	array('label'=>'Create StudentFees', 'url'=>array('create')),
	array('label'=>'Manage StudentFees', 'url'=>array('admin')),
);
?>

<h1>Student Fees</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
