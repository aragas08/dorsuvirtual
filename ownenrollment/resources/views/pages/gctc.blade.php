@extends('layouts.app', ['activePage' => 'gctc', 'title' => 'Sync-in - DOrSU', 'navName' => 'GCTC Dashboard', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
        <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h4 class="card-title">Students List</h4>
                                    <p class="card-description">For students given School Identification Number</p>
                                </div>
                                <div class="col-sm-4">
                                    <a class="btn btn-primary float-right mt-2" href="{{ url('students/export') }}">Export</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-full-width table-striped" style="width:100%" id="ajax-crud-datatable">
                                <thead>
                                    <tr>
                                        <th>Assigned On</th>
                                        <th width="80px">School ID</th>
                                        <th>Name</th>
                                        <th>Course</th>
                                        <th>Campus</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th>Assigned On</th>
                                        <th></th>
                                        <th></th>
                                        <th>Course</th>
                                        <th>Campus</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            //yajra datatables
            // $('#ajax-crud-datatable tfoot th').each(function () {
            //     var title = $(this).text();
            //     $(this).html('<input type="text" style="font-size:12px" placeholder="Search ' + title + '" />');
            // });
            $('#ajax-crud-datatable').DataTable({
                processing: true,
                serverSide: false,
                ajax: "{{ route('ajaxAssigned') }}",
                initComplete: function () {
                    this.api()
                        .columns([0,3,4])
                        .every(function () {
                            var column = this;
                            var select = $('<select style="font-size: 12px;"><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
        
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });
        
                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function (d, j) {
                                    select.append('<option value="' + d + '">' + d + '</option>');
                                });
                        });
                },
                columns: [
                { data: 'school_id_at', name: 'school_id_at'},
                { data: 'school_id', name: 'school_id' },
                { data: 'fullname', name: 'fullname' },
                { data: 'short_name', name: 'program.short_name' },
                { data: 'campus', name: 'campus' },
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
            });

        
        });
    </script>
@endsection