<div class="alert  ">
<button class="close" data-dismiss="alert"></button>
Question: Advanced Input Field</div>

<p>
1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.

</p>


<p>
2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field

<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>

<div class="alert alert-success">
<button class="close" data-dismiss="alert"></button>
The table you start with</div>

<table class="table table-striped table-bordered table-hover">
<thead>
<th class="row1">
	<span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false"><i class="icon-plus"></i></span>
</th>
<th class="row2">Description</th>
<th class="row3">Quantity</th>
<th class="row4">Unit Price</th>
</thead>

<tbody id="chart">
	<tr>
		<td class="removeAreaFn" data-num='1'><i class="icon-2x icon-remove"></i></td>
		<td class="inputAreaFn" data-type="textarea"><span></span><textarea name="data[1][description]" class="inputStyle hideElem"></textarea></td>
		<td class="inputAreaFn" data-type="input"><span></span><div class="hideElem"><input type="text" class="inputStyle" name="data[1][quantity]"></div></td>
		<td class="inputAreaFn" data-type="input"><span></span><div class="hideElem"><input type="text" class="inputStyle" name="data[1][unit_price]"></div></td>
	</tr>

</tbody>

</table>


<p></p>
<div class="alert alert-info ">
<button class="close" data-dismiss="alert"></button>
Video Instruction</div>

<p style="text-align:left;">
<video width="78%"   controls>
  <source src="/video/q3_2.mov">
Your browser does not support the video tag.
</video>
</p>

<style>
.row1 {
	width:2%;
}
.row2 {
	width:60%;
}
.row3 {
	width:15%;
}
.row4 {
	width:15%;
}

.inputStyle {
	width: 98%;
}

.hideElem {
	display: none;
}

.showElem {
	display: block;
}

</style>

<?php $this->start('script_own');?>
<script>
$(document).ready(function(){
	var rowIdx = 1;
	
	var clickFlag = 0;
	// Initial the first row
	
	$("#add_item_button").click(function(){
		rowIdx += 1;

		var newHtml = 	'<tr>';		
		newHtml 	+=  '<td class="removeAreaFn" data-num='+rowIdx+'><i class="icon-2x icon-remove"></i></td>'
		newHtml 	+=  '<td class="inputAreaFn" data-type="textarea"><span></span><textarea name="data['+rowIdx+'][description]" class="inputStyle hideElem"></textarea></td>'		
		newHtml 	+= 	'<td class="inputAreaFn" data-type="input"><span></span><div class="hideElem"><input type="text" class="inputStyle" name="data['+rowIdx+'][quantity]"></div></td>';
		newHtml 	+= 	'<td class="inputAreaFn" data-type="input"><span></span><div class="hideElem"><input type="text" class="inputStyle" name="data['+rowIdx+'][unit_price]"></div></td>';
		newHtml 	+= 	'</tr>';

		$( "#chart" ).append( newHtml );		
	});
// Listen click event on text area.
	$("#chart").on("click", ".inputAreaFn", function (event) {
		if(clickFlag == 1){	
			clickFlag = 0;		
			return;
		}
		var inputType = $(this).data("type");
		var t = $(this).text();

		if(inputType == 'textarea'){
			elTxt = $(this).find('textarea');
			elSpan = $(this).find('span');
			elTxt.removeClass( "hideElem" ).addClass( "showElem" );
			elSpan.removeClass( "showElem" ).addClass( "hideElem" );
			elTxt.val(t);
			$('textarea').focus();
		}else{
			divEl = $(this).find('div');
			elSpan = $(this).find('span');
			divEl.removeClass( "hideElem" ).addClass( "showElem" );
			elSpan.removeClass( "showElem" ).addClass( "hideElem" );
			inputEl = divEl.find('input');
			inputEl.val(t);
			inputEl.focus();
		}
		
	});
// Listen click event on remove icon
	$("#chart").on("click", ".removeAreaFn", function (event) {
		console.log($(this).parent());
		$(this).parent().remove();
	});

	$('#chart').on('blur','input',function() {		
		$(this).parent().siblings('span').removeClass( "hideElem" ).addClass( "showElem" );		
		$(this).parent().siblings('span').text($(this).val());
		$(this).parent().removeClass( "showElem" ).addClass( "hideElem" );
		clickFlag = 1;
	});
	$('#chart').on('blur','textarea',function(e) {
		$(this).siblings('span').removeClass( "hideElem" ).addClass( "showElem" );
		$(this).siblings('span').text($(this).val());
		$(this).removeClass( "showElem" ).addClass( "hideElem" );
		clickFlag = 1;
	});
	
});
</script>
<?php $this->end();?>

