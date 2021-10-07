<?php
/* @var $this StudentClassesController */
/* @var $model StudentClasses */

$this->breadcrumbs=array(
	'Student Classes'=>array('admin'),
	'Manage',
);

$this->menu=array(
	
	array('label'=>'Create Student Class', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#student-classes-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Student Classes</h1>

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
	'id'=>'student-classes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'student_class_id',
		//'student_id',
		 array(
            'name'=>'student.addmission_no',
            'filter'=>CHtml::activeTextField($model,'admno'),
        ),
		 array(
            'name'=>'student.student_name',
            'filter'=>CHtml::activeTextField($model,'name'),
        ),
		'class_no',
		'section',   
		array(
    'name'=>'started_on',
    'header'=>'Started On',
    
   //'value'=>'Yii::app()->dateFormatter->format("dd-MM-yyyy",strtotime($data->started_on))'
   'value'=>'$data->started_on=="0000-00-00" || $data->started_on==null?"":date("Y-m-d",strtotime($data->started_on))'

	),     
		array(
    'name'=>'ended_on',
    'header'=>'Ended On',
    
    //'value'=>'Yii::app()->dateFormatter->format("dd-MM-yyyy",strtotime($data->ended_on))'
   'value'=>'$data->ended_on==null || $data->ended_on=="0000-00-00"?"":date("Y-m-d",strtotime($data->ended_on))'

	),     
      
		array(
			'class'=>'CButtonColumn',
'template'=>'{update}{delete}',
'deleteConfirmation'=>"Are You Sure you want to delete this student class?",
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
