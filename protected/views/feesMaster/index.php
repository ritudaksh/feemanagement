<?php
/* @var $this FeesMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Fees Masters',
);

$this->menu=array(
	array('label'=>'Create FeesMaster', 'url'=>array('create')),
	array('label'=>'Manage FeesMaster', 'url'=>array('admin')),
);
?>

<h1>Fees Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
