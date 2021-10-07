<?php
/* @var $this StudentMasterController */
/* @var $model StudentMaster */

$this->breadcrumbs=array(
	'Student Masters'=>array('index'),
	$model->student_id,
);

$this->menu=array(
	
	array('label'=>'Create StudentMaster', 'url'=>array('create')),
	//array('label'=>'Update StudentMaster', 'url'=>array('update', 'id'=>$model->student_id)),
	//array('label'=>'Delete StudentMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->student_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StudentMaster', 'url'=>array('admin')),
);
?>

<h1>View Student Master <?php echo $model->student_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'student_id',
		'addmission_no',
		//'class',
		//'section',
		 array(
            'name'=>'studentMaster.class_no',
            'filter'=>CHtml::activeTextField($model,'class'),
        ),
		'student_name',
		'father_name',
		 array(
            'name'=>'studentMaster1.fees_for_months',
            'filter'=>CHtml::activeTextField($model,'feesformonths'),
        ),
		array(
            'name'=>'studentMaster1.fees_period_month',
            'filter'=>CHtml::activeTextField($model,'feesperiodmonth'),
        ),
		array(
            'name'=>'studentMaster1.bus_fees_paid',
            'filter'=>CHtml::activeTextField($model,'busfeespaid'),
        ),
		array(
            'name'=>'studentMaster1.security_paid',
            'filter'=>CHtml::activeTextField($model,'securitypaid'),
        ),
		array(
            'name'=>'studentMaster1.admission_fees_paid',
            'filter'=>CHtml::activeTextField($model,'admissionfeespaid'),
        ),
		array(
            'name'=>'studentMaster1.activity_fees',
            'filter'=>CHtml::activeTextField($model,'activityfees'),
        ),
		array(
            'name'=>'studentMaster1.dayboarding_fees_paid',
            'filter'=>CHtml::activeTextField($model,'dayboardingfeespaid'),
        ),
		array(
            'name'=>'studentMaster1.Total_amount',
            'filter'=>CHtml::activeTextField($model,'Totalamount'),
        ),
		array(
            'name'=>'studentMaster1.amount_paid',
            'filter'=>CHtml::activeTextField($model,'amountpaid'),
        ),
	),
)); ?>







