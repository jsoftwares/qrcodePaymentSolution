<div class="table-responsive">
    <table class="table" id="accountHistories-table">
        <thead>
            <tr>
                <th>Account</th>
        <th>User</th>
        <th>Done At</th>
        <th>Message</th>
                <!-- <th colspan="3">Action</th> -->
            </tr>
        </thead>
        <tbody>
        @foreach($accountHistories as $accountHistory)
            <tr>
                <td>{!! $accountHistory->account_id !!}</td>
            <td>{!! $accountHistory->user['email'] !!}</td>
            <td>{!! $accountHistory->created_at->format('D d M, Y H:i')  !!}</td>
            <td>{!! $accountHistory->message !!}</td>
                <!-- No one should be able to delete a trasaction history <td> 
                    {!! Form::open(['route' => ['accountHistories.destroy', $accountHistory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('accountHistories.show', [$accountHistory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('accountHistories.edit', [$accountHistory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td> -->
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
