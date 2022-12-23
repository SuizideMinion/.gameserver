@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Übersetzungen</h5>
                    <table class="table datatable" id="dataTable">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Registriert</th>
                            <th scope="col">Token</th>
                            <th scope="col">Letzter Update</th>
                            <th scope="col">Letzter Klick</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($Users AS $User)
                            <tr>
                                <th scope="row">{{ $User->id }}</th>
                                <td>{{ $User->name }}</td>
                                <td>{{ $User->created_at->format('d.m.Y H:i:s') }}</td>
                                <td><a href="/{{ ( uData('CanAdminUserJoin') == 1 ? 'login/'. $User->token:'500' ) }}">Join</a> </td>
                                <td>{{ $User->updated_at->format('d.m.Y H:i:s') }}</td>
                                <td>{{ date('d.m.Y H:i:s', ($User->getData->pluck('value', 'key')['lastclick'] ?? 0) ) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('Scripts')
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("dataSearch");
            filter = input.value.toUpperCase();
            table = document.getElementById("dataTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection
