
 <?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */

$this->breadcrumbs=array(
	'Expenses',
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

    <h1 style="margin-left:560px">Create Expense</h1>
	<p class="note" style="margin-left:560px">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	
	
<div class="accounts">
<div class="formConInner" >
 <table>
    <tr>
	
    
	 
	<td valign="top">
	<?php echo $form->labelEx($model,'account_id'); ?>
    <?php  echo $form->dropDownList($model, 'account_id', $list); ?>
    <?php echo $form->error($model,'account_id'); ?>
	</td>
	
	
	<td valign="top">
	<?php echo $form->labelEx($model,'expense_desc'); ?>
    <?php echo $form->textArea($model,'expense_desc'); ?>
    <?php echo $form->error($model,'expense_desc'); ?>
	</td>
	
	
	<?php $date=date('Y-m-d');  ?>
	<td valign="top">
	<?php echo $form->labelEx($model,'expense_date'); ?>
	<?php //echo $form->textField($model,'expense_date'); ?>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'model' => $model,
    'attribute' => 'expense_date',
	 'options'=>array(
            'dateFormat'=>'yy-mm-dd',
            ),
    'htmlOptions' => array(
        'size' => '10',         // textField size
        'maxlength' => '10',    // textField maxlength
		'value'=>$date,	
    ),
)); ?>
    <?php echo $form->error($model,'expense_date'); ?>
	</td>
	
	
	<td valign="top">
	<?php echo $form->labelEx($model,'amount'); ?>
    <?php echo $form->textField($model,'amount'); ?>
    <?php echo $form->error($model,'amount'); ?>
	</td>
	
	
	
	<td>
	<?php echo $form->labelEx($model,'paid_to'); ?>
    <?php echo $form->textField($model,'paid_to'); ?>
    <?php echo $form->error($model,'paid_to'); ?>
	</td>
	<td>
		<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
	
	</td>
	
	
	</tr>

</table>
</div>





<?php $this->endWidget(); ?>
</div>
</div>

<?php Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    jQuery('#date').datepicker({
        
    });
}
");   ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'expense-grid',
	'dataProvider'=>$Expenses->search(),
	'filter'=>$Expenses,
	 'afterAjaxUpdate' => 'reinstallDatePicker',
	'columns'=>array(
		
		
		
		/* array(
            'header' => 'account_id',
            'value' => 'CHtml::textField("Expenses[account_id]",$data->account_id)',
            'type' => 'raw',
        ),*/
		
		array(
            'header' => 'Account name',
			'name'=>'account_id',
			'value' => 'CHtml::dropDownList("accname", $data->account_id,
					CHtml::listData(AccountHeads::model()->findAll(), "account_id", "account_name"), array("class"=>"editacc","options"=>array($data->account_id=> array("selected"=>true))
				)
				)',
				 'filter'=>CHtml::listData(AccountHeads::model()->findAll(), "account_id", "account_name"),
				
            'type' => 'raw',
        ),
		
		
		
		 array(
           
			 'header' => 'Expense description',
			'name'=>'expense_desc',
            'value' => 'CHtml::textArea("expdesc",$data->expense_desc)',
            'type' => 'raw',
			
           ),   
		
		 array(
            'header' => 'Expense date',
			'name'=>'expense_date',
           //'value' => 'CHtml::textField("Expenses[expense_date]",$data->expense_date)',
			'value' => 'CHtml::textField("expdate",$data->expense_date, array("class"=>"expensedate"))',
			'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $Expenses,
            'attribute' => 'expense_date',
            'options'=>array(
            'dateFormat'=>'yy-mm-dd',
            ),
            'htmlOptions'=>array(
            'id'=>'date',
            ),

            ),
            true),
            'type' => 'raw',
        ),
		
		
		 array(
            'header' => 'Amount',
			'name' => 'amount',
            'value' => 'CHtml::textField("Expenses[amount]",$data->amount)',
            'type' => 'raw',
        ),
		
		 array(
            'header' => 'Paid to',
			'name'=>'paid_to',
            'value' => 'CHtml::textField("Expenses[paid_to]",$data->paid_to)',
            'type' => 'raw',
        ),
		
		
		
		array(
			'class'=>'CButtonColumn',
'template'=>'{update}{delete}',
  'buttons' =>array('update'=>array(

            'options' => array('class' => 'save-ajax-button'),
                    'url' => 'Yii::app()->createUrl("site/SaveExpense", array("id"=>$data->expense_id))',

		),
 'delete'=>array(
                           
			 			
			'url' => 'Yii::app()->createUrl("site/DeleteExpense",  array("id"=>$data->expense_id))',
    ),
	),
),
),
)); ?>

<script>
$(document).ready(function () {
var accountid="";
    var date = new Date();
    var currentMonth = date.getMonth();
    var todayDate = date.getDate();
    var currentYear = date.getFullYear();

    $('.expensedate').datepicker({
        dateFormat: 'yy-mm-dd',
    });
	});

	
	/*$('.editacc').on('change', function() {   
	var val=this.value;
	accountid=this.id;
	
	$('select[name^='+accountid+'] option[value='+val+']').attr("selected","selected");
    });*/
	
	
</script>

<script>	
	
    $('#expense-grid a.save-ajax-button').click(function(e)
    {
        var row = $(this).parent().parent();
 
        var data = $('input', row).serializeObject();
		var data1 = $('select', row).serializeObject();
		var desc = $('textarea', row).serializeObject();
		if(data['Expenses[amount]'].match(/^\d+$/)) {
		
		var url=jQuery(this).attr('href')+"&expdate="+data['expdate']+"&accname="+data1['accname']+"&desc="+desc['expdesc'];
		 
		
        $.ajax({
            type: 'POST',
            data: data,
            url: url,
            success: function(data, textStatus, jqXHR) {
                
                
				alert("Data updated successsfully");
				location.reload(true);	
            },
            error: function(textStatus, errorThrown) {
                //console.log(textStatus);
                //console.log(errorThrown);
            }
        });
		}
		else{
		alert("Amount must be an integer");
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

