<?php
/* @var $this LatefeeMasterController */
/* @var $model LatefeeMaster */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'latefee_id'); ?>
		<?php echo $form->textField($model,'latefee_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'days_from'); ?>
		<?php echo $form->textField($model,'days_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'days_to'); ?>
		<?php echo $form->textField($model,'days_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'latefee'); ?>
		<?php echo $form->textField($model,'latefee'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
