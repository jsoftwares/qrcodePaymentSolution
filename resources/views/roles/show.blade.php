@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Role: 
            {!! $role->name!!}
        </h1>

        <h1 class="pull-right">
            <a href="{!! route('roles.edit', [$role->id]) !!}" class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px">Edit Role</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
    @include('flash::message')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('roles.show_fields')
                    <a href="{!! route('roles.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
