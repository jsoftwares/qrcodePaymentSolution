@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">
            Account 

            <small>
                <p class="text-red">{!! $account->applied_for_payout == 1 ? 'Payout request pending' : '' !!}</p>
            </small>
        </h1>
        <div class="pull-right">
            <!-- Show If logged in user is same as the account userID & d acct applied_for_payout is not 1 -->
        @if(Auth::user()->id == $account->user_id && $account->applied_for_payout != 1)
            {!! Form::open(['route' => ['accounts.apply_for_payout'], 'method' => 'post', 'class'=>'pull-left']) !!}
            <!-- Remember 1st value is the name of field and 2nd is the value -->
                {!! Form::hidden('apply_for_payout', $account->id) !!} 
                {!! Form::button('<i class="glyphicon glyphicon-ok"></i> Apply for payout', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'onclick' => "return confirm('Confirm payout request')"]) !!}
            {!! Form::close() !!}
        @endif

        <!-- Show only if logged is user is an admin or moderator & if the current account has not been paid -->
        @if(Auth::user()->role_id < 3 && $account->paid == 0)
            {!! Form::open(['route' => ['accounts.confirm_transfer'], 'method' => 'post', 'class'=>'pull-left', 'style'=>'margin-left:5px']) !!}
                {!!Form::hidden('confirm_transfer', $account->id)!!}
                {!! Form::button('<i class="glyphicon glyphicon-ok"></i> Mark as paid', ['type' => 'submit', 'class' => 'btn btn-primary btn-sm', 'onclick' => "return confirm('Confirm Transfer?')"]) !!}
            {!! Form::close() !!}
        @endif
        </div>
    </section>
        
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('accounts.show_fields')
                    <a href="{!! route('accounts.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
    <h4>Account History</h4>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('account_histories.table')
                </div>
            </div>
        </div>
    </div>
@endsection
