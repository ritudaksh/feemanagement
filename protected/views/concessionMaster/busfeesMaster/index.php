<?php
/* @var $this BusfeesMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Busfees Masters',
);

$this->menu=array(
	array('label'=>'Create BusfeesMaster', 'url'=>array('create')),
	array('label'=>'Manage BusfeesMaster', 'url'=>array('admin')),
);
?>

<h1>Busfees Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
