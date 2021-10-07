<?php
/* @var $this BusMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bus Masters',
);

$this->menu=array(
	array('label'=>'Create BusMaster', 'url'=>array('create')),
	array('label'=>'Manage BusMaster', 'url'=>array('admin')),
);
?>

<h1>Bus Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
