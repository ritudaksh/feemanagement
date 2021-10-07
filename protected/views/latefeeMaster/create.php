<?php
/* @var $this LatefeeMasterController */
/* @var $model LatefeeMaster */

$this->breadcrumbs=array(
	'Latefee'=>array('admin'),
	'Create',
);

$this->menu=array(
	
	array('label'=>'Manage Latefee', 'url'=>array('admin')),
);
?>

<h1>Create Latefee</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
