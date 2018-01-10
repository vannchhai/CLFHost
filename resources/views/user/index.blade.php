@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>LIST USER</h2>
        </div>
        <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>USER MANAGEMENT</h2>
                                </div>
                            </div>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                @if(Session::has('msg'))
                                   <div class="alert bg-green alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{Session::get('msg')}}
                                    </div>
                                @endif
                                <a href="{{ url('/user_create')}}" class="btn btn-primary pull-right"><i class="material-icons">playlist_add</i></a>
                                <br>
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Gender</th>
                                            <th>Profile</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($listUser as $key)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $key->name }}</td>
                                            <td>{{ $key->email }}</td>
                                            <td>{{ $key->phone }}</td>
                                            <td>{{ ($key->sex == 0) ? "Male" : "Female" }}</td>
                                            <td>{{ $key->profile }}</td>
                                            <td>{{ $key->active }}</td>
                                            <td class="text-nowap">
                                                <a href="{{ url('/user_detail') . '/' . $key->id }}" class="btn btn-warning"><i class="material-icons" title="Detail">list</i></a>
                                                <a href="{{ url('/user_edit') . '/' . $key->id }}" title="Edit" class="btn btn-info"><i class="material-icons">open_in_new</i></a>
                                                <a href="{{ url('/user_delete') . '/' . $key->id }}" title="Delete" class="btn btn-danger"><i class="material-icons">delete_forever</i></a>
                                                <!-- <a href="#" class="btn btn-danger"><i class="material-icons" title="Block user">block</i></a> -->
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{ asset('plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{ asset('plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
    <script src="{{ asset('js/pages/tables/jquery-datatable.js')}}"></script>
@endsection
