<?php
/* @var $this ConcessionMasterController */
/* @var $model ConcessionMaster */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'concession-master-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	

	<div class="row">
		<?php echo $form->labelEx($model,'concession_type'); ?>
		<?php echo $form->textField($model,'concession_type',array('name'=>'concname','size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'concession_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'concession_persent'); ?>
		<?php echo $form->radioButton($model, 'concession_persent', array(
    'value'=>'percentage', 
    'uncheckValue'=>null
)). 'Percentage';?>
 
<?php echo $form->radioButton($model, 'concession_persent', array('value'=>'amount','uncheckValue'=>null
)). 'Amount';?>
		<?php echo $form->error($model,'concession_persent'); ?>
	</div>
<!--<div class="row">
<input type="radio" value="Percentage" name="concmode">Percentage
<input type="radio" value="amount" name="concmode">Amount
</div>-->
	
	
<div class="row">
		<?php echo $form->labelEx($model,'concession_amount'); ?>
		<?php echo $form->textField($model,'concession_amount',array('name'=>'conamt','size'=>20,'maxlength'=>20,'name'=>'concamt')); ?>
		<?php echo $form->error($model,'concession_amount'); ?>
	</div>
	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
