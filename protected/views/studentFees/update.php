<style>
#loader_img
{
	display:none;
	    margin-left: 50%;
    margin-bottom: 10px;
}

</style>
<?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */

$this->breadcrumbs=array(
	'Student Fees'=>array('admin'),
	$model->student_fee_id=>array('view','id'=>$model->student_fee_id),
	'Update',
);

$this->menu=array(
	
	array('label'=>'Create Student Fees', 'url'=>array('create')),
	//array('label'=>'View StudentFees', 'url'=>array('view', 'id'=>$model->student_fee_id)),
	array('label'=>'Manage Student Fees', 'url'=>array('admin')),
);
?>

<h1>Update Student Fees <?php echo $model->student_fee_id; ?></h1>
 <img src="images/ajax-loader.gif" id="loader_img">

<?php $this->renderPartial('_form', array('model'=>$model,'fees'=>$fees,'m'=>$m,'contyp'=>$contyp)); ?>
