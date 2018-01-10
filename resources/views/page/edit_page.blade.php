@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>EDIT PAGE</h2>
        </div>
        <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>EDIT PAGE</h2>
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
                            <form class="form-horizontal" action="{{ ($pageModel) ? url('/page_update')  : url('/page_insert')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Name</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="name" value="{{ ($pageModel) ? $pageModel->name : '' }}" class="form-control" placeholder="Name" required>
                                                <input type="hidden" name="id" value="{{ ($pageModel) ? $pageModel->id : '' }}" class="form-control" placeholder="Name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Description</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="description" value="{{ ($pageModel) ? $pageModel->description : '' }}" class="form-control" placeholder="Name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                            <input type="checkbox" id="remember_me_3" name="active" class="filled-in" checked>
                                            <label for="remember_me_3">Active</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Page Decription</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                 <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Icon</th>
                                                                <th>Title</th>
                                                                <th>Description</th>
                                                                <th>Active</th>
                                                                <th>Date</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1; ?>
                                                            @foreach($listDescriptionPage as $key)
                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <td>{{ $key->icon }}</td>
                                                                <td>{{ $key->title }}</td>
                                                                <td>{{ $key->description }}</td>
                                                                <td>{{ $key->active }}</td>
                                                                <td>{{ $key->created_at }}</td>
                                                                <td class="text-nowrap">
                                                                    <a href="{{ url('/des_page_edit') . '/' . $key->id }}" title="Edit" class="btn btn-info"><i class="material-icons">open_in_new</i></a>
                                                                    <a href="{{ url('/des_page_block') . '/' . $key->id }}" title="Block" class="btn btn-danger"><i class="material-icons">block</i></a>
                                                                    <!-- <a href="#" class="btn btn-danger"><i class="material-icons" title="Block user">block</i></a> -->
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SAVE</button>
                                            <a href="{{ url('/page')}}" class="btn btn-warning m-t-15 waves-effect">CANCEL</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js')}}"></script>
@endsection