<?php
/* @var $this FeesMasterController */
/* @var $model FeesMaster */

$this->breadcrumbs=array(
	'Fees'=>array('admin'),
	'Manage',
);

$this->menu=array(
	
	array('label'=>'Create Fees', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#fees-master-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Fees</h1>

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
	'id'=>'fees-master-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'fees_id',
		'class_no',
		'annual_fees',
		'tuition_fees',
		'funds_fees',
		'sports_fees',
		'activity_fees',
		'admission_fees',
		'security_fees',
		'dayboarding_fees',
		array(
    'name'=>'valid_from',
    'header'=>'Valid From',
    
    'value'=>'Yii::app()->dateFormatter->format("yyyy-MM-dd",strtotime($data->valid_from))'
),
		
		array(
    'name'=>'valid_to',
    'header'=>'Valid To',
    
    'value'=>'Yii::app()->dateFormatter->format("yyyy-MM-dd",strtotime($data->valid_to))'
),
		
		
		
		
		//'valid_from',
		//'valid_to',
		
		array(
			'class'=>'CButtonColumn',
         'template'=>'{update}{delete}',
		 'deleteConfirmation'=>"Are You Sure you want to delete this class fee?",
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
