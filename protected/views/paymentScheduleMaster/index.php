<?php
/* @var $this PaymentScheduleMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Payment Schedule Masters',
);

$this->menu=array(
	array('label'=>'Create PaymentScheduleMaster', 'url'=>array('create')),
	array('label'=>'Manage PaymentScheduleMaster', 'url'=>array('admin')),
);
?>

<h1>Payment Schedule Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
