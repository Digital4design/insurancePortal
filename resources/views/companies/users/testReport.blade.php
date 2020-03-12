@extends('companies.master')
@section('pageTitle','View Report')
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
<input type="hidden" name="user_id" value="{{$userId}}">
<input type="hidden" name="trackerId" value="{{$trackerId}}">
<div class="">
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <h4 class="card-title">Genrate Reports</h4>
            <form class=" form-horizontal">
               <div class="form-body">
                  <div class="form-group row col-md-8">
                     <label for="report_date" class="col-sm-4 control-label">Select a dates for the schedule:</label>
                     <div class="col-sm-4">
                        <div class="input-group">
                           <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                           <input id="report_date" type="text" name="report_date" class=" form-control">
                           <input type="hidden" id="startDate" name="startDate" class="my-report-Dates" value="" />
                           <input type="hidden" id="endDate" name="endDate" class="my-report-Dates"  value="" />
                        </div>
                     </div>
                  </div>
                  <div class="text-left">
                     <button id="generate_btn" type="button" class="btn waves-effect waves-light btn-info">Generate Report</button>
                  </div>
                  <div class="table-responsive m-t-40">
                     <table id="dataTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                           <tr>
                              <th>Policy Holder</th>
                              <th>Rating(1-10)</th>
                              <th>Odometer Reading (Km)</th>
                              <th>Total Mileage (Km)</th>
                              <th>Last Known GPS Location (Latitude, Longitude)</th>
                           </tr>
                        </thead>
                        <tfoot>
                        </tfoot>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
                  <div class="text-left">
                  </div>
               </div>
            </form>
            <div id="messages"></div>
         </div>
      </div>
   </div>
</div>
@stop
@section('pagejs')
<script type="text/javascript">
   ReportTable =$('#dataTable').DataTable();
   $("#generate_btn").on("click", function (event) {
      var userId = $('input[name=user_id]').val();
      var trackerId = $('input[name=trackerId]').val();
      var startDate = $('input[name=startDate]').val();
      var endDate = $('input[name=endDate]').val();
      var dateRange = $('input[name=report_date]').val();
      if (!dateRange) {
         swal("Alert !", "Please select date range");
         return false;
      }
      ReportTable.destroy();
      ReportTable =$('#dataTable').DataTable({
         processing: true,
         serverSide: true,
         lengthMenu: [10,20,50,100], 
         order:[[1,'desc']],
         ajax:'{{ url("/company/user-management/get-tracker-report-data") }}'+'/'+trackerId+'/'+userId+'/'+startDate+'/'+endDate,
         columns: [
            { data:'userData',name: 'userData', orderable: true },
            { data:'rating',name: 'rating', orderable: true },
            { data: 'odometer',name: 'odometer',orderable: true, "visible":true },
            { data: 'mileageDa',name: 'mileageDa',orderable: true, "visible":true },
            { data: 'action',name: 'action', orderable: false,},
         ],
         dom: 'Blfrptip',
         buttons: [
            'excel','pdf'
            // {
               // extend: 'colvis',text: "Show / Hide Columns"
            // }
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
         // ReportTable . destroy();
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
   });
   $('#report_date').daterangepicker({
      //timePicker: true,
      autoUpdateInput: false,
      locale: {
         cancelLabel: 'Clear'
      },
      /*
         startDate : moment().startOf('hour'),
         endDate  : moment().startOf('hour').add(24),
         locale   : {
            format: 'DD-M-Y'
         }
      */
     }, function(start, end, label) {
        $("#startDate").val(start.format('YYYY-MM-DD'));
        $("#endDate").val(end.format('YYYY-MM-DD'));
      });
   
      $('#report_date').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD-M-Y') + ' - ' + picker.endDate.format('DD-M-Y'));
         $("#startDate").val(picker.startDate.format('YYYY-MM-DD'));
         $("#endDate").val(picker.endDate.format('YYYY-MM-DD'));
      });
   
   /*
      var userId = $('input[name=user_id]').val();
      var trackerId = $('input[name=trackerId]').val();
      $('#dataTable').DataTable({
         processing: true,
         serverSide: true,
      lengthMenu: [10,20,50,100],
      order:[[1,'desc']],
      ajax:'{{ url("/company/user-management/get-tracker-data") }}'+'/'+trackerId+'/'+userId,
      columns: [
         { data:'userData',name: 'userData', orderable: true },
         { data:'rating',name: 'rating', orderable: true },
         { data: 'odometer',name: 'odometer',	orderable: true, "visible":true },
         { data: 'mileage',name: 'mileage',	orderable: true, "visible":true },
         { data: 'action',name: 'action', orderable: false,  },
      ],
      dom: 'Blfrptip',
      buttons: [
         'excel','pdf','csv','print'
            // {
               // extend: 'colvis',text: "Show / Hide Columns"
            // }
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
   */
   
</script>
@stop