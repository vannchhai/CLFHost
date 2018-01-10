@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>ITEMS</h2>
        </div>
        <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>ITEMS CONFIGURE</h2>
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
                                <br>
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>User Name</th>
                                            <th>Type</th>
                                            <th>Category</th>
                                            <th>Item Description</th>
                                            <th>Contact Number</th>
                                            <th>Location</th>
                                            <th>Photo</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($listItem as $key)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $key->item_name }}</td>
                                            <td>{{ $key->name }}</td>
                                            <td>{{ $key->type_name }}</td>
                                            <td>{{ $key->category_name }}</td>
                                            <td>{{ $key->item_description }}</td>
                                            <td>{{ $key->contact_number }}</td>
                                            <td>{{ $key->location_id }}</td>
                                            <td>{{ $key->item_gallery_id }}</td>
                                            <td>{{ $key->active == 1 ? 'Available' : 'Block' }}</td>
                                            <td>
                                                @if($key->active == 1)
                                                <a href="{{ url('/item_block') . '/' . $key->id }}" class="btn btn-danger"><i class="material-icons" title="Block">block</i></a>
                                                @else
                                                <a href="{{ url('/item_reblock') . '/' . $key->id }}" class="btn btn-info"><i class="material-icons" title="Undo Block">undo</i></a>
                                                @endif
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
    <script src="{{ asset('js/pages/tables/jquery-datatable.js')}}"></script>
@endsection

