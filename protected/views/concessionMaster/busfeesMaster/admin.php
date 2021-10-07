<?php
/* @var $this BusfeesMasterController */
/* @var $model BusfeesMaster */

$this->breadcrumbs=array(
	'Busfees'=>array('admin'),
	'Manage',
);

$this->menu=array(
	
	array('label'=>'Create Busfees', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#busfees-master-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Busfees</h1>

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
	'id'=>'busfees-master-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'bus_id',
		'route',
		'destination',
		'bus_fees',
		'driver',
		'conductor',
		'attendant',
		array(
			'class'=>'CButtonColumn',
'template'=>'{update}{delete}',
'deleteConfirmation'=>"Are You Sure you want to delete this bus route?",
    'buttons'=>array('update'=>array(

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
