@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">

                    <!-- Table with stripped rows -->
                    <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                        <div class="dataTable-top">
                            <div class="dataTable-search"><input type="text" id="dataSearch" onkeyup="myFunction()"
                                                                 placeholder="Suche ..."
                                                                 title="Type in a name"></div>
                        </div>
                        <div class="dataTable-container">
                            <table class="table dataTable" id="dataTable">
                                <thead>
                                <tr>
                                    <th scope="col">*</th>
                                    <th scope="col">Key</th>
                                    <th scope="col">Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <form method="POST" action="{{ route('admin.server.store') }}">
                                        @csrf
                                        <th scope="row">*</th>
                                        <td><input class="form-control" style="background: #fff;" type="text"
                                                   name="key" id="key" placeholder="Key" value=""></td>
                                        <td class="d-flex"><input class="form-control" style="background: #fff;" type="text"
                                                   name="value" id="value" placeholder="Value" value="">
                                            <button class="btn btn-outline-secondary" type="submit">Speichern</button>
                                        </td>
                                    </form>
                                </tr>
                                @foreach($ServerDatas AS $key => $ServerData)
                                    <tr onclick="window.location.href = '{{ route('admin.server.edit', $ServerData->id) }}';"
                                        style="cursor: pointer;">
                                        <th scope="row">{{ $ServerData->id }}</th>
                                        <td>{{ $ServerData->key }}</td>
                                        <td>{{ $ServerData->value }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

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
