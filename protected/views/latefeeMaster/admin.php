<?php
/* @var $this LatefeeMasterController */
/* @var $model LatefeeMaster */

$this->breadcrumbs=array(
	'Latefee'=>array('admin'),
	'Manage',
);

$this->menu=array(
	
	array('label'=>'Create Latefee', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#latefee-master-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Latefee</h1>

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
	'id'=>'latefee-master-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		/*'latefee_id',*/
		'days_from',
		'days_to',
		'latefee',
		array(
			'class'=>'CButtonColumn',
'template'=>'{update}{delete}',
'deleteConfirmation'=>"Are You Sure you want to delete this latefee?",
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
