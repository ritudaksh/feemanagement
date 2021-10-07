<?php
/* @var $this LatefeeMasterController */
/* @var $model LatefeeMaster */

$this->breadcrumbs=array(
	'Latefee'=>array('admin'),
	$model->latefee_id=>array('view','id'=>$model->latefee_id),
	'Update',
);

$this->menu=array(
	
	array('label'=>'Create Latefee', 'url'=>array('create')),
    //array('label'=>'View LatefeeMaster', 'url'=>array('view', 'id'=>$model->latefee_id)),
	array('label'=>'Manage Latefee', 'url'=>array('admin')),
);
?>

<h1>Update Latefee <?php echo $model->latefee_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
