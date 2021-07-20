@forelse ($users as $key => $user)
    <tr>
        <td>
            <a class="text-item-table" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->id }}</a>
        </td>
        <td>
            <a class="text-item-table" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->full_name }}</a>
        </td>
        <td>
            <a class="text-item-table" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->email }}</a>
        </td>
        @php
            $roles = $user->roles->pluck("name")->all();
            $rolesResult = [];
            foreach ($roles as $key => $value)
            {
                $rolesResult[ $key ] = __($value);
            }
        @endphp
        <td>
            <a class="text-item-table" href="{{ route('users.show', ['user' => $user->id]) }}">{{ implode(", ", $rolesResult) }}</a>
        </td>
        <td>
            <a class="btn btn-outline-warning" href="{{ route('users.edit', ['user' => $user->id]) }}">{{ __('Editar') }}</a>
            <button class="btn btn-outline-danger delete-user" id="user_{{ $user->id }}" data-toggle="modal" data-target="#delete_modal" data-id="{{ $user->id }}">{{ __('Apagar') }}</button>
        </td>
    <tr>
@empty
    <tr>
        <td class="text-center" colspan="5">{{ __("Nenhum usuário encontrado") }}</td>
    </tr>
@endforelse
