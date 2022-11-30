@extends('layout.admin')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-sm float-right" onclick="window.location.href = '{{ route('admin.researchs.create') }}';">Add New Research</button>
                <button type="button" class="btn btn-danger btn-sm float-right" onclick="window.location.href = '/admin/researchsadd';">Reload CSV!!</button>
            </div>
            <div class="card-body">

                <table class="table datatable">
                    <thead>
                    <tr>
                        @foreach( $Columns AS $Column )
                            <th scope="col">{{ $Column }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($Researchs as $key => $Research)
                        <tr onclick="window.location.href = '{{ route('admin.researchs.edit', $Research->id) }}';"
                            style="cursor: pointer;">
                            @foreach( $Columns AS $Column )
                                <th scope="col">{{ $Research[$Column] }}</th>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
