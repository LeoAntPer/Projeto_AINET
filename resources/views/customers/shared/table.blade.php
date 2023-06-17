<table class="table">
    <thead class="table-dark">
    <tr>
        @if ($showFoto)
            <th></th>
        @endif
        <th>Nome</th>
        <th>Nif</th>
        @if ($showDelete)
            <th class="button-icon-col"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach ($customers as $customer)
        <tr>
            @if ($showFoto)
                <td><img src="/img/avatar_unknown.png" alt="Avatar" class="bg-dark rounded-circle" width="45" height="45"></td>
            @endif
            <td>{{ $customer->nome_user}}</td>
            <td>{{ $customer->nif }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
