<?php
/* @var $this StudentMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Student Masters',
);

$this->menu=array(
	array('label'=>'Create StudentMaster', 'url'=>array('create')),
	array('label'=>'Manage StudentMaster', 'url'=>array('admin')),
);
?>

<h1>Student Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
