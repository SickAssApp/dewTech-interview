
<div class="row-fluid">
	<table class="table table-bordered" id="table_records">
		<thead>
			<tr>
				<th>ID</th>
				<th>NAME</th>	
			</tr>
		</thead>
		<tbody>

			<!-- <?php foreach($records as $record):?>
			<tr>
				<td><?php echo $record['Record']['id']?></td>
				<td><?php echo $record['Record']['name']?></td>
			</tr>	
			<?php endforeach;?> -->

		</tbody>
	</table>
</div>
<?php $this->start('script_own')?>
<script>
$(document).ready(function(){	
	
	$("#table_records").DataTable({
		"bProcessing": true,
        "bServerSide": true,
		"sAjaxSource": "/Record/getRecords",
		"aoColumns": [
			{ "mData": "id" },
			{ "mData": "name" },
		],
		// "fnServerData": function(sSource, aoData, fnCallback, oSettings) {
		// 	oSettings.jqXHR = $.ajax({
		// 		"dataType": "json",
		// 		"type": "GET",
		// 		"url": sSource,
		// 		"data": aoData,
		// 		"success": function(data) {
		// 			console.log(data);
		// 			fnCallback(data);
		// 		}
		// 	});
		// }
	});
	
})
</script>
<?php $this->end()?>