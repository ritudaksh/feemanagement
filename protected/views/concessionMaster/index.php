<?php
/* @var $this ConcessionMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Concession Masters',
);

$this->menu=array(
	array('label'=>'Create ConcessionMaster', 'url'=>array('create')),
	array('label'=>'Manage ConcessionMaster', 'url'=>array('admin')),
);
?>

<h1>Concession Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
