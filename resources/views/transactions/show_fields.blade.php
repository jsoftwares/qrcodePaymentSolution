<!-- Id Field -->
<!-- <div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $transaction->id !!}</p>
</div> -->

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'Buyer Name:') !!}
    <p>
        <a href="{!!route('users.show', [$transaction->user->id]) !!}">
            {!! $transaction->user['name'] !!} | {!! $transaction->user->email !!}
        </a>
    </p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{!! $transaction->amount !!}</p>
</div>

<!-- Qrcode Id Field -->
<div class="form-group">
    {!! Form::label('qrcode_id', 'Product Name:') !!}
    <p>{!! $transaction->qrcode->product_name !!}</p>
</div>

<!-- Payment Method Field -->
<div class="form-group">
    {!! Form::label('payment_method', 'Payment Method:') !!}
    <p>{!! $transaction->payment_method !!}</p>
</div>

<!-- Qrcode Owner Id Field -->
<div class="form-group">
    {!! Form::label('qrcode_owner_id', 'Paid To:') !!}
    <p>{!! $transaction->qrcode->company_name !!}</p>
</div>

<!-- Message Field -->
<div class="form-group">
    {!! Form::label('message', 'Message:') !!}
    <p>{!! $transaction->message !!}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{!! $transaction->status !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $transaction->created_at->format('D d, M, Y H:i:s') !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $transaction->updated_at->format('D d, M, Y H:i:s') !!}</p>
</div>

