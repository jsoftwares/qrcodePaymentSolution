<div class="table-responsive">
    <table class="table" id="accounts-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Balance</th>
                <th>Total Credit</th>
                <th>Total Debit</th>
                <th>Status</th>
                <!-- <th>Withdrawal Method</th>
                <th>Payment Email</th>
                <th>Bank Name</th>
                <th>Bank Account</th>
                <th>Account Name</th>
                <th>Bank Branch</th>
                <th>Applied For Payout</th>
                <th>Paid</th>
                <th>Last Date Applied</th>
                <th>Last Date Paid</th>
                <th>Country</th>
                <th>Other Details</th> -->
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($accounts as $account)

        <!-- Shows only transactions that belong to a logged in user or all trans if admin is logged in-->
            @if($account->user_id === Auth::user()->id || Auth::user()->role_id < 2)
                <tr>
                    <td>
                        <a href="{!! route('accounts.show', [$account->id]) !!}" class='btn btn-default btn-xs'>
                            {!! $account->user->email !!}
                        </a>
                    </td>
                    <td>{!! number_format($account->balance) !!}</td>
                    <td>{!! number_format($account->total_credit) !!}</td>
                    <td>{!! number_format($account->total_debit) !!}</td>
                    <td>
                            @if($account->applied_for_payout == 1)
                                <span class="text-danger">Pending</span>
                            @elseif($account->paid == 1)
                                <span class="text-success">Paid</span>
                            @endif
                    </td>
                    <!-- <td>{!! $account->withdrawal_method !!}</td>
                    <td>{!! $account->payment_email !!}</td>
                    <td>{!! $account->bank_name !!}</td>
                    <td>{!! $account->bank_account !!}</td>
                    <td>{!! $account->account_name !!}</td>
                    <td>{!! $account->bank_branch !!}</td>
                    <td>{!! $account->applied_for_payout !!}</td>
                    <td>{!! $account->paid !!}</td>
                    <td>{!! $account->last_date_applied !!}</td>
                    <td>{!! $account->last_date_paid !!}</td>
                    <td>{!! $account->country !!}</td>
                    <td>{!! $account->other_details !!}</td> -->
                    <td>
                        <!-- {!! Form::open(['route' => ['accounts.destroy', $account->id], 'method' => 'delete']) !!} -->
                        <div class='btn-group'>
                            <!-- <a href="{!! route('accounts.show', [$account->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> -->
                            <a href="{!! route('accounts.edit', [$account->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                            <!-- {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} -->
                        </div>
                        <!-- {!! Form::close() !!} -->
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>
