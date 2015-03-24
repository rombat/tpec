@extends('layouts.scaffold')

@section('main')

<h1>Show User</h1>

<p>{{ link_to_route('users.index', 'Return to All users', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

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
		</tr>
	</thead>

	<tbody>
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
	</tbody>
</table>

@stop
