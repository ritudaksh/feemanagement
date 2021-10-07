<?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */

$this->breadcrumbs=array(
	'Student Fees'=>array('admin'),
	'Manage',
);

$this->menu=array(
	
	array('label'=>'Create Student Fees', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#student-fees-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Student Fees</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'student-fees-grid',
	'htmlOptions' => array('style'=>'width:100%'),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
              /*  array(
            'name'=>'studentFee.addmission_no',
            'filter'=>CHtml::activeTextField($model,'admno'),
        ),*/
		
                //'student_name',
				//'fathers_name',
				//'student_class_id',
		array(
            'name'=>'student.addmission_no',
            'header'=>'Admission No',
            'filter'=>CHtml::activeTextField($model,'admno'),
        ),
		
		'student_class',
		'student_section',
			array(
            'name'=>'student.student_name',
            'filter'=>CHtml::activeTextField($model,'name'),
        ),
		
		//'fees_for_months',
		'fees_period_month',
		'year',
		array(
    'name'=>'date_payment',
    'header'=>'Date Payment',
   
    'value'=>'Yii::app()->dateFormatter->format("yyyy-MM-dd",strtotime($data->date_payment))'
),
             
                 
		/*'annual_fees_paid',
		'tuition_fees_paid',
		'funds_fees_paid',
		'sports_fees_paid',*/
		'annual_fees_paid',
		'tuition_fees_paid',
		'concession_applied',
		'funds_fees_paid',
		'admission_fees_paid',
		'security_paid',
		'dayboarding_fees_paid',
		'bus_fees_paid',
		'activity_fees',
		'Total_amount',
		'amount_paid',
		'payment_mode',
		'cheq_no',
		'bank_name',
		'cheque_status',		
		'realized_date',
		array(
    'name'=>'entry_date',
    'header'=>'Date of entry',
   
   'value'=>'$data->entry_date==NULL?"":date("d-m-Y",strtotime($data->entry_date))',
    'filter'=>CHtml::activeTextField($model, 'entry_date', 
                 array('placeholder'=>'yyyy-mm-dd'))
),
		array(
			'class'=>'CButtonColumn',
'template'=>'{update}{delete}',
'deleteConfirmation'=>"Are You Sure you want to delete this fees?",
  'buttons' =>array('update'=>array(

             'label'=>'Edit',
    
               array(
                            'visible'=>'true',
    ),

		),
 'delete'=>array(
                            'visible'=>'true',
    ),
	),


		),
	),
)); ?>
