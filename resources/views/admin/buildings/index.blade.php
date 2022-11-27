@extends('layout.admin')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-sm float-right" onclick="window.location.href = '{{ route('admin.buildings.create') }}';">Add New Building</button>
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

                    @foreach($Buildings as $key => $Building)
                        <tr onclick="window.location.href = '{{ route('admin.buildings.edit', $Building->id) }}';"
                            style="cursor: pointer;">
                            @foreach( $Columns AS $Column )
                                <th scope="col">{{ $Building[$Column] }}</th>
                            @endforeach
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
