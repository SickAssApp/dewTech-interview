
<div id="message1">


<?php 
	echo $this->Form->create('Type',
		array(
			'id'=>'form_type',
			'url' => array('controller' => 'Format', 'action' => 'submit'),			
			'type'=>'file',
			'class'=>'',
			'autocomplete'=>'off',
			'inputDefaults'=>array(				
				'label'=>false,
				'div'=>false,
				'type'=>'text',
				'required'=>false
			)
		)
	)
?>
	
<?php echo __("Hi, please choose a type below:")?>
<br><br>

<?php $options_new = array(
 		// 'Type1' => __('<span class="showDialog" data-id="dialog_1" style="color:blue">Type1</span>'),
		'Type1' => __('<span class="showDialog" data-id="dialog_1" id="option1" style="color:blue">Type1</span>'),
		'Type2' => __('<span class="showDialog" data-id="dialog_2" id="option2" style="color:blue">Type2</span>')
		);?>

<?php echo $this->Form->input('type', array('legend'=>false, 'type' => 'radio', 'options'=>$options_new,'before'=>'<label class="radio line notcheck">','after'=>'</label>' ,'separator'=>'</label><label class="radio line notcheck">'));?>


<?php echo $this->Form->end('Save');?>

</div>

<style>
.showDialog:hover{
	text-decoration: underline;
}

#message1 .radio{
	vertical-align: top;
	font-size: 13px;
}

.control-label{
	font-weight: bold;
}

.wrap {
	white-space: pre-wrap;
}

.align-left{
	text-align:left;
}

/* Might be better to alter all tooltip's css in one file */
.tooltip.right{
	margin-left:10px;
	padding: 0 4px;
}
.tooltip.right .tooltip-inner {
	background-color: white;
	border: 1px solid #e2e1e0;	
	color: black;
	box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
}
.tooltip.right .tooltip-arrow {		
	border-right-color: white;	
	left:-5px;
	margin-top: -10px;
	border-width: 10px 10px 10px 0;	
}

</style>

<?php $this->start('script_own')?>
<script>

$(document).ready(function(){
	// $(".dialog").dialog({
	// 	autoOpen: false,
	// 	width: '500px',
	// 	modal: true,
	// 	dialogClass: 'ui-dialog-blue'
	// });	

	var msg1 = '<ul class="align-left"><li>Description .......</li>'
		msg1 += '<li>Description 2</li></ul>';		

	var msg2 = '<ul class="align-left"><li>Desc 1 .....</li>'
		msg2 += '<li>Desc 2...</li></ul></span>';

	$("#option1").tooltip({
		html: true,
        placement: "right",
        title: msg1,
    });

	$("#option2").tooltip({
		html: true,
        placement: "right",
        title: msg2,
    });
	// $(".showDialog").click(function(){ var id = $(this).data('id'); $("#"+id).dialog('open'); });


})


</script>
<?php $this->end()?>