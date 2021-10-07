<?php
/* @var $this BusMasterController */
/* @var $model BusMaster */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bus-master-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
   
	
	<?php 	
	
	//$sql="select * from busfees_master  group by route order by route asc";
	//$busroute=Yii::app()->db->createCommand($sql)->queryAll();
	
	?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		
		Bus NO./Route<br/>
		<select id="busroute" name="busroute">
		<option id="" value="">Please select route</option>
		<?php for ($i=1;$i<=20;$i++){ 
		if($i==$model->bus_route){
		$selected="selected";
		}
		else{
		$selected="";
		}
		
		?>
		
		<option  <?php echo $selected; ?> id="<?php echo $i; ?>" value="<?php echo $i; ?>"><?php echo $i; ?></option>
		
		<?php }?>
		
		</select>
	</div>
	
    <div class="row">
		<?php echo $form->labelEx($model,'internal'); ?>
				 <?php echo $form->dropDownList($model,'internal',array('True' => 'True', 'False' => 'False')); ?>
		<?php echo $form->error($model,'internal'); ?>
	</div>
	
	
	<div class="row">
		<?php echo $form->labelEx($model,'bus_driver'); ?>
		<?php echo $form->textField($model,'bus_driver',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'bus_driver'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bus_conductor'); ?>
		<?php echo $form->textField($model,'bus_conductor',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'bus_conductor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bus_attendant'); ?>
		<?php echo $form->textField($model,'bus_attendant',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'bus_attendant'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->