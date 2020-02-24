@extends('companies.master')
@section('pageTitle','View User')
@section('content')
@section('pageCss')
<style>
	.my-form-control { padding: .3em; display: inline-block; border: 1px solid #ccc; box-shadow: inset 0 1px 3px #ddd;  border-radius: 4px; vertical-align: middle; box-sizing: border-box; font-size: .9em; }
	#late_low, #late_high {  width: 3em; }
	.dataTable tr td.time_delay { color: #fff; background-color: red; }
	.dataTable tr td.no_bus_record_exist { color: #fff; background-color: #000; }
	.dataTable tr td.bus_record_not_found { color: #fff; background-color: red; }
	.dataTable tr td.time_taken_long {     color: #000; background-color: yellow; }
</style>
@stop
<?php
//dd($userName);

?>
<input type="hidden" name="user_id" value="{{$userId}}">
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">All Tracker Listing</h4>
				<h6 class="card-subtitle">Here you can manage Tracker</h6>
				<div class="table-responsive m-t-40">
					@if(Session::has('status'))
						<div class="alert alert-{{ Session::get('status') }}">
							<i class="ti-user"></i> {{ Session::get('message') }}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
					@endif
                	<table id="dataTable" class=" table table-striped table-bordered dataTable">
                        <thead>
                            <tr>
                                <th>Tracker Id</th>
                                <th>Tracker Name</th>
                                <!--<th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Account Status</th>
                                <th>Created Date</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>

						<tbody>
                        </tbody>
                    </table>
				</div>
			</div>
		</div>

	</div>
</div>
@stop
@section('pagejs')
<script type="text/javascript">
	var userId = $('input[name=user_id]').val();
	$('#dataTable').DataTable({
		processing : true,
		serverSide: true,
		lengthMenu: [10,20,50,100],
		order: [[1,'desc']],
		ajax: '{{ url("/company/user-management/get-trackers") }}'+'/'+userId,
		columns: [
			{ data: 'id', name: 'id', orderable: true },
			{ data: 'label', name: 'label', orderable: true },
		  // { data: 'mileageDa',name: 'mileageDa', orderable: true },
		  // { data: 'odometer',	name: 'odometer', orderable: true },
		  // { data: 'mileageDa',name: 'mileageDa',	orderable: true, "visible":true },
		  // { data: 'odometer',	name: 'odometer',	orderable: true, "visible":true },
			{ data: 'action', name: 'action', orderable: false,  },
		],
		dom: 'Blfrptip',
		buttons: [
			{
				extend: 'colvis',text: "Show / Hide Columns"
			}
		],
		oLanguage: {
			sProcessing: "<img height='80' width='80' src='{{ url('public/assets/admin/images/loading.gif') }}' alt='loader'/>",
			"oPaginate": {
				"sPrevious": "Previous",
				"sNext": "Next",
				},
				"sSearch": "Search",
				"sLengthMenu": "Show _MENU_ entries",
				"sInfo": "Showing _START_ to _END_ of _TOTAL_ enteris",
				"sInfoEmpty" : "Showing 0 to 0 of 0 entries",
				 "sInfoFiltered": "search filtered entries",
				"sZeroRecords": "No matching records found",
				"sEmptyTable": "No data available in table",
			},
			initComplete: function () {
				this.api().columns().every(function () {
					var column = this;
					var input = document.createElement("input");
					$(input).appendTo($(column.footer()).empty()).on('change', function () {
						column.search($(this).val(), false, false, true).draw();
					});
			});
		}
	});


	// 	$(".tracker").click(function(){
	// 		var trackerId = $(this).attr('data-id');
	//         var user_id = $("input[name=user_id]").val();
	// 		$('#lastTrackerData').DataTable({
	// 			processing : true,
	// 			serverSide: true,
	// 			lengthMenu: [10,20,50,100],
	// 			order: [[1,'desc']],
	// 			ajax: '{{ url("/company/user-management/get-tracker-data") }}'+'/'+trackerId+'/'+user_id,
	// 			columns: [
	// 				{ data: 'userData', name: 'userData', orderable: true },
	// 				{ data: 'mileage',		name: 'mileage', orderable: true },
	// 				{ data: 'mileageDa',		name: 'mileageDa', orderable: true },
	// 				{ data: 'odometer',	name: 'odometer', orderable: true },
	// 				// { data: 'mileageDa',	name: 'mileageDa',	orderable: true, "visible":true },
	// 				// { data: 'odometer',	name: 'odometer',	orderable: true, "visible":true },
	// 				{ data: 'action', name: 'action', orderable: false,  },
	// 			],
	// 			dom: 'Blfrptip',
	// 			buttons: [
	// 				{
	//                      extend: 'colvis',text: "Show / Hide Columns"
	//                 }
	// 			],
	// 			oLanguage: {
	// 				sProcessing: "<img height='80' width='80' src='{{ url('public/assets/admin/images/loading.gif') }}' alt='loader'/>",
	// 				"oPaginate": {
	// 					"sPrevious": "Previous",
	// 					"sNext": "Next",
	// 				},
	// 				"sSearch": "Search",
	// 				"sLengthMenu": "Show _MENU_ entries",
	// 				"sInfo": "Showing _START_ to _END_ of _TOTAL_ enteris",
	// 				"sInfoEmpty" : "Showing 0 to 0 of 0 entries",
	// 				 "sInfoFiltered": "search filtered entries",
	// 				"sZeroRecords": "No matching records found",
	// 				"sEmptyTable": "No data available in table",
	// 			},
	// 			initComplete: function () {
	// 				this.api().columns().every(function () {
	// 					var column = this;
	// 					var input = document.createElement("input");
	// 					$(input).appendTo($(column.footer()).empty()).on('change', function () {
	// 						column.search($(this).val(), false, false, true).draw();
	// 					});
	// 			});
	// 		}
	// 	});
	// });
</script>
@stop

