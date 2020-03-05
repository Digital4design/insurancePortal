@extends('admin.master')
@section('pageTitle','Fuel Management')

@section('content')
     
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				
                <div class="right-side-struct pull-right" >
				    <a href="{{ url('/admin/fuel-type-management/create') }}" class="btn btn-info waves-effect waves-light clearfix add-new add-faicon"  ><i class="fa fa-plus" aria-hidden="true"></i> Add Fuel Type </a>
				</div>

                <h4 class="card-title">All Fuel Management Listing</h4>
				<h6 class="card-subtitle">Here you can manage Fuel</h6>

				<div class="table-responsive m-t-40">
                @if(Session::has('status'))
						<div class="alert alert-{{ Session::get('status') }}"> 
							<i class="ti-user"></i> {{ Session::get('message') }}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
						</div>
					@endif
                	<table id="dataTable" class=" table table-striped table-bordered dataTable  "> 
                        <thead>
                            <tr>
                                <th>Fuel</th>
                                <!-- <th>License Class</th> -->
                                <th>Description</th>
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
$(function() {
    $('#dataTable').DataTable({
		
        //processing : true,
        serverSide: true,
		rowGroup: {
            dataSrc: 'name'
        },

        lengthMenu: [10,20,50,100],
        order: [[0,'asc']],
        ajax: '{!! url("/admin/fuel-type-management/user-data") !!}',
        columns: [
            { data: 'fuels_type',	name: 'fuels_type', orderable: true, visible: true },
            { data: 'fuels_description',		name: 'fuels_description', orderable: true },
            { data: 'action',			name: 'action', orderable: false,  },
        ],
       
        dom: 'Blfrptip',
        buttons: [
                {
                     extend: 'colvis',text: "Show / Hide Columns"
                }
        ], 
        oLanguage: {
                //sProcessing: "<img height='80' width='80' src='{{ url('public/assets/admin/images/loading.gif') }}' alt='loader'/>",
				"oPaginate": {
					"sPrevious": "Previous", // This is the link to the previous page
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
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val(), false, false, true).draw();
                });
            });
        }
	});
});
 
$(document).on('click','.delete',function(){
    var id = $(this).data('id');
    swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false

        }).then(function (isConfirm) {

            if (isConfirm.value === true) {

				$('#dataTable_processing').show();
                
                $.ajax({
                    url:'{{ url("/admin/fuel-type-management/delete") }}'+'/'+id,
                    type: 'GET',
                    success:function(){
						$('#dataTable_processing').hide();
                        swal(
                            'Deleted!',
                            'Vehicle has been deleted successfully.',
                            'success'
                        ).then(function(){
                            window.location.href = '{{ url("/admin/fuel-type-management") }}';
                        });
                    }
                });  
            }
        })
});
</script>
@stop
