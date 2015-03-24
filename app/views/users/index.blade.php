@extends('layouts.scaffold')

@section('main')

<h1>All Users</h1>

<p>{{ link_to_route('users.create', 'Add New User', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($users->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Prenom</th>
				<th>Mail</th>
				<th>Password</th>
				<th>Birthdate</th>
				<th>Tel_fixe</th>
				<th>Tel_portable</th>
				<th>Admin</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($users as $user)
				<tr>
					<td>{{{ $user->nom }}}</td>
					<td>{{{ $user->prenom }}}</td>
					<td>{{{ $user->mail }}}</td>
					<td>{{{ $user->password }}}</td>
					<td>{{{ $user->birthdate }}}</td>
					<td>{{{ $user->tel_fixe }}}</td>
					<td>{{{ $user->tel_portable }}}</td>
					<td>{{{ $user->admin }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('users.destroy', $user->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('users.edit', 'Edit', array($user->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no users
@endif

@stop
