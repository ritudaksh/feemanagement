<?php
/* @var $this StudentClassesController */
/* @var $model StudentClasses */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'student_class_id'); ?>
		<?php echo $form->textField($model,'student_class_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'student_id'); ?>
		<?php echo $form->textField($model,'student_id'); ?>
	</div>
	

	<div class="row">
		<?php echo $form->label($model,'class_no'); ?>
		<?php echo $form->textField($model,'class_no',array('size'=>50,'maxlength'=>50)); ?>
	</div>
	
	

	<div class="row">
		<?php echo $form->label($model,'started_on'); ?>
		<?php echo $form->textField($model,'started_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ended_on'); ?>
		<?php echo $form->textField($model,'ended_on'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->