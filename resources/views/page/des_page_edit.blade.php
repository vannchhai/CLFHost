@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>EDIT DESCRIPTION PAGE</h2>
        </div>
        <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>EDIT DESCRIPTION PAGE</h2>
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
                            <form class="form-horizontal" action="{{ ($des_pageModel) ? url('/des_page_update')  : url('/page_insert')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Icon</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="icon" value="{{ ($des_pageModel) ? $des_pageModel->icon : '' }}" class="form-control" placeholder="Icon" required>
                                                <input type="hidden" name="id" value="{{ ($des_pageModel) ? $des_pageModel->id : '' }}" class="form-control" placeholder="Name">
                                                <input type="hidden" name="index" value="{{ ($des_pageModel) ? $des_pageModel->index : '' }}" class="form-control" placeholder="Name">
                                                <input type="hidden" name="page_id" value="{{ ($des_pageModel) ? $des_pageModel->page_id : '' }}" class="form-control" placeholder="Name">
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">title</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="title" value="{{ ($des_pageModel) ? $des_pageModel->title : '' }}" class="form-control" placeholder="Title" required>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Description</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="description" value="{{ ($des_pageModel) ? $des_pageModel->description : '' }}" class="form-control" placeholder="Description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                            <input type="checkbox" id="remember_me_3" name="active" class="filled-in" checked>
                                            <label for="remember_me_3">Active</label>
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