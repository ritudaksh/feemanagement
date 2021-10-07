<?php
/* @var $this FsearchController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Fsearches',
);

$this->menu=array(
	array('label'=>'Create Fsearch', 'url'=>array('create')),
	array('label'=>'Manage Fsearch', 'url'=>array('admin')),
);
?>

<h1>Fsearches</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
