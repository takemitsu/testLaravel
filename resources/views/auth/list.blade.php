@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Users</div>
				<div class="panel-body">
					<table class="table" style="margin-bottom: 0;">
						<thead>
							<tr>
								<th>idkey</th>
								<th>name</th>
								<th>status</th>
								<th>auth_type</th>
								<th>created at</th>
							</tr>
						</thead>
						<tbody class="table-striped">
					@foreach($users as $user)
						<tr>
							<td>{{ $user->idkey }}</td>
							<td>{{ $user->name }}</td>
							<td>{{ $user->status }}</td>
							<td>{{ $user->auth_type }}</td>
							<td>{{ $user->created_at }}</td>
						</tr>
					@endforeach
						</tbody>
					</table>

				</div>
				<div class="panel-footer">
					{!! $users->render() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
