
 <?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */

$this->breadcrumbs=array(
	'Accountheads',
);
?>


<div class="form">

	
	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accounts-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<h1 style="margin-left:560px">Create Accounts</h1>
	<p class="note" style="margin-left:560px">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	
	
	
	
	
	
<div class="accounts">
<div class="formConInner" >
 <table>
    <tr>
      
	<td valign="top">
	<?php echo $form->labelEx($model,'account_code'); ?>
    <?php echo $form->textField($model,'account_code',array('readonly'=>true)); ?>
    <?php echo $form->error($model,'account_code'); ?>
	</td>
	
	<!--<td valign="top">
	<?php //echo $form->labelEx($model,'parentaccount_id'); ?>
    <?php //echo $form->textField($model,'parentaccount_id'); ?>
    <?php //echo $form->error($model,'parentaccount_id'); ?>
	</td>-->
	
	<td valign="top">
	<?php echo $form->labelEx($model,'parentaccount_id'); ?>
    <?php echo $form->dropDownList($model, 'parentaccount_id', $list, array('prompt'=>'Please select account')); ?>
    <?php echo $form->error($model,'parentaccount_id'); ?>
	</td>
	
	
	
	<td valign="top">
	<?php echo $form->labelEx($model,'account_name'); ?>
    <?php echo $form->textField($model,'account_name'); ?>
    <?php echo $form->error($model,'account_name'); ?>
	</td>
	
	
	<td valign="top">
	<?php echo $form->labelEx($model,'account_desc'); ?>
    <?php echo $form->textArea($model,'account_desc'); ?>
    <?php echo $form->error($model,'account_desc'); ?>
	</td>
	
	<td>
	<div class="row buttons" style="margin-left:40%">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
	</td>
	</tr>
	
	

</table>
</div>



	


</div>
<?php $this->endWidget(); ?>
</div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'accounts-grid',
	'dataProvider'=>$accountheads->search(),
	'filter'=>$accountheads,
	
	'columns'=>array(
		
		
		
		 array(
		   'name'=>'account_code',
           'header'=>'Account code',
            'value' => 'CHtml::textField("AccountHeads[account_code]",$data->account_code,array("readonly"=>true))',
            'type' => 'raw',
        ),
		
		/* array(
		   'name'=>'parentaccount_id',
           'header'=>'parent account',
            'value' => 'CHtml::textField("AccountHeads[parentaccount_id]",$data->parentaccount_id)',
            'type' => 'raw',
        ),*/
		array(
            'header' => 'Parent account',
			'name'=>'parentaccount_id',
			'value' => 'CHtml::dropDownList("accname", $data->parentaccount_id,
					CHtml::listData(AccountHeads::model()->findAll(), "account_id", "account_name") , array("prompt"=>"Please select account"),array("class"=>"editacc","options"=>array($data->parentaccount_id=> array("selected"=>true))
				)
				)',
				 'filter'=>CHtml::listData(AccountHeads::model()->findAll(), "account_id", "account_name"),
				
            'type' => 'raw',
        ),
		
		
		 array(
            'header' => 'Account name',
			 'name'=>'account_name',
            'value' => 'CHtml::textField("AccountHeads[account_name]",$data->account_name)',
            'type' => 'raw',
        ),
		 array(
			 'header' => 'Account description',
			 'name'=>'account_desc',
            'value' => 'CHtml::textArea("accdesc",$data->account_desc)',
            'type' => 'raw',
        ),
		
		
		array(
			'class'=>'CButtonColumn',
'template'=>'{update}{delete}',
  'buttons' =>array('update'=>array(

            'options' => array('class' => 'save-ajax-button'),
                    'url' => 'Yii::app()->createUrl("site/SaveAccounts", array("id"=>$data->account_id))',

		),
 'delete'=>array(
                           
			 			
			'url' => 'Yii::app()->createUrl("site/DeleteAccounts",  array("id"=>$data->account_id))',
    ),
	),
),
),
)); ?>

<script>
    $('#accounts-grid a.save-ajax-button').live('click', function(e)
    {
        var row = $(this).parent().parent();
 
         var data = $('input', row).serializeObject();
		 var desc = $('textarea', row).serializeObject();
		 var paccname = $('select', row).serializeObject();
		
         if(data['AccountHeads[account_name]'].match(/^[A-Za-z]+$/)) {
         var url=jQuery(this).attr('href')+"&desc="+desc['accdesc']+"&paccname="+paccname['accname'];
		
        $.ajax({
            type: 'POST',
            data: data,
            url: url,
            success: function(data, textStatus, jqXHR) {
                console.log(data);
                
				alert("Data updated successsfully");
				location.reload(true);	
            },
            error: function(textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
		}
		else{
		alert("Account name should contain only alphabets characters");
		
		}
        return false;
    });
 
 
    $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
</script>

