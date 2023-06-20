<table class="table">
    <thead class="table-dark">
    <tr>
        @if ($showFoto)
            <th></th>
        @endif
        <th>Nome</th>
        <th>Nif</th>
        @if ($showEdit)
            <th class="button-icon-col"></th>
        @endif
        @if ($showDelete)
            <th class="button-icon-col"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach ($customers as $customer)
        <tr>


            <td>{{ $customer->user->name}}</td>
            <td>{{ $customer->nif }}</td>
            @if ($showEdit)
                <td class="button-icon-col"><a class="btn btn-dark" href="{{ route('customers.edit', ['customer' => $customer]) }}">
                        <i class="fas fa-edit"></i></a></td>
            @endif
            @if ($showDelete)
                <td class="button-icon-col">
                    <form method="POST" action="{{ route('customers.destroy', ['customer' => $customer]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="delete" class="btn btn-danger">
                            <i class="fas fa-trash"></i></button>
                    </form>
                </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
