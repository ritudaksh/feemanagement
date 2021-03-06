<?php
	/* @var $this StudentMasterController */
	/* @var $model StudentMaster */
	
	$this->breadcrumbs=array(
	'Student Records'=>array('admin'),
	'Manage',
	);
	
	$this->menu=array(
	
	array('label'=>'Create Student', 'url'=>array('create')),
	);
	
	Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
	});
	$('.search-form form').submit(function(){
	$('#student-master-grid').yiiGridView('update', {
	data: $(this).serialize()
	});
	return false;
	});
	");
?>
<style>
.sms {
  background-color: #76ACC7;
  border: 1px none #000000;
  border-radius: 4px 4px 4px 4px;
  color: #FFFFFF;
  font-weight: bold;
  padding: 10px;
  text-transform: uppercase;
}
</style>
<h1>Manage Student</h1>
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div style="float:right">
<?php 
$this->widget('zii.widgets.jui.CJuiButton', array(
    'buttonType'=>'link',
    'name'=>'btnGo',
    'caption'=>'Download CSV',
    'url'=>array('site/export'),
)); ?>
<!--<input class="sms" type="button" value="SMS Export" name="excelbtn" id="excelbtn" onclick="generateexcel()"/>-->
</div>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
</div><!-- search-form -->
<div id="statusMsg">
	<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
	</div>
	<?php endif; ?>
	
	<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
	</div>
	<?php endif; ?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'student-master-grid',
	'htmlOptions' => array('style'=>'width:100%'),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
	//'student_id',
	array(
	'name'=>'addmission_no',
	'header'=>'Admission No',
	'filter'=>CHtml::activeTextField($model,'addmission_no'),
	),
	array(
	'name'=>'studentClasses.class_no',
	'filter'=>CHtml::activeTextField($model,'class'),
	),
	array(
	'name'=>'studentClasses.section',
	'filter'=>CHtml::activeTextField($model,'section'),
	), /* category has been added to display */
	'student_name',
	array(
	'name'=>'studentMaster.category',
	'filter'=>CHtml::activeTextField($model,'category'),
	), 
	array(
	'name' => 'concession.concession_type',
	'filter' => CHtml::activeTextField($model, 'concessiontype'),
	), 
	
	array(
	'name' => 'bus.route',
	'filter' => CHtml::activeTextField($model, 'route'),
	),
	array(
	'name' => 'bus.destination',
	'filter' => CHtml::activeTextField($model, 'destination'),
	),
	'father_name',
	'mother_name',
		'mobile_no',
		'phone_no',
		'address',
		'city',
	//'bus_id',
	/*'birth_date', */
	
	//'bus_destination',
	//'gender',
	array(
    'name'=>'admission_date',
    'header'=>'Admission Date',
    
    //'value'=>'Yii::app()->dateFormatter->format("dd-MM-yyyy",strtotime($data->admission_date))'
	'value'=>'$data->admission_date==0000-00-00?"":Yii::app()->dateFormatter->format("dd-MM-yyyy",strtotime($data->admission_date))',
	
	'filter'=>CHtml::activeTextField($model, 'admission_date', 
	array('placeholder'=>'yyyy-mm-dd'))
	
	),
	//'admission_date',
	//'student_concessiontype',
	'status',
	//'passedout_date',
	array(
    'name'=>'passedout_date',
    'header'=>'passed out date',
    
	//'value'=>'Yii::app()->dateFormatter->format("dd-MM-yyyy",strtotime($data->started_on))'
	'value'=>'$data->passedout_date==0000-00-00?"":date("d-m-Y",strtotime($data->passedout_date))',
	'filter'=>CHtml::activeTextField($model, 'passedout_date', 
	array('placeholder'=>'yyyy-mm-dd'))
	
	),     
	
	array(
	'class'=>'CButtonColumn',
	
	'template'=>'{update}{delete}{view}',
	'deleteConfirmation'=>"Are You Sure you want to delete this student? It will also delete all records of this student from Student Classes.",
	'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
	'buttons' =>array('update'=>array(
	
	'label'=>'Edit',
    
	array(
	'visible'=>'true',
    ),
	
	),
	'delete'=>array(
	'visible'=>'true',
	
    ),
	'view'=>array(
	'visible'=>'true',
	'label'=>'view fees', 
	
    ),
	
	
	),
	),
	),
)); ?>
