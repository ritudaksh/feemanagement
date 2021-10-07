<?php
/* @var $this ConcessionMasterController */
/* @var $model ConcessionMaster */

$this->breadcrumbs=array(
	'Concession'=>array('admin'),
	'Create',
);

$this->menu=array(
	
	array('label'=>'Manage Concession', 'url'=>array('admin')),
);
?>

<h1>Create Concession</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
