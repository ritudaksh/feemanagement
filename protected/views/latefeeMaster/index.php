<?php
/* @var $this LatefeeMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Latefee Masters',
);

$this->menu=array(
	array('label'=>'Create LatefeeMaster', 'url'=>array('create')),
	array('label'=>'Manage LatefeeMaster', 'url'=>array('admin')),
);
?>

<h1>Latefee Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
