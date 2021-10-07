<?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */

$this->breadcrumbs=array(
	'Student Fees'=>array('index'),
	$model->student_fee_id,
);

$this->menu=array(
	
	array('label'=>'Create StudentFees', 'url'=>array('create')),
	//array('label'=>'Update StudentFees', 'url'=>array('update', 'id'=>$model->student_fee_id)),
	//array('label'=>'Delete StudentFees', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->student_fee_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StudentFees', 'url'=>array('admin')),
);
?>

<h1>View StudentFees #<?php echo $model->student_fee_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'student_fee_id',
		'student_id',
		'student_name',
		'student_class_id',
		'section',
		'fees_for_months',
		'fees_period_month',
		'annual_fees_paid',
		'tuition_fees_paid',
		'funds_fees_paid',
		'sports_fees_paid',
		'activity_fees',
		'admission_fees_paid',
		'security_paid',
		'late_fees_paid',
		'dayboarding_fees_paid',
		'bus_fees_paid',
		'date_payment',
		'payment_mode',
		'cheq_no',
		'bank_name',
		'concession_applied',
		'concession_type_id',
		'Total_amount',
		'amount_paid',
	),
)); ?>
