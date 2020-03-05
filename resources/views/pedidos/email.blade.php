<table style="width: 100%;">
    <thead>
        <tr>
            <th style="width: 1px;">&nbsp;</th>
            <th>Pastel</th>
            <th style="width: 1px;"><abbr title="Quantidade">Qtd.</abbr></th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedido->pasteis as $pastel)
            <tr>
                <td>
                    <img style="width: 100px; border: 1px solid #333;"
                         src="{{ asset("storage/{$pastel->foto}") }}"
                         alt="{{ $pastel->nome }}">
                </td>
                <td>{{ $pastel->nome }}</td>
                <td>{{ $pastel->quantidade }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
