@extends('layout.admin')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-sm float-right" onclick="window.location.href = '{{ route('admin.buildings.create') }}';">Add New Building</button>
                <button type="button" class="btn btn-danger btn-sm float-right" onclick="window.location.href = '/admin/buildingsadd';">Reload CSV!!</button>
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
                        @if($Building->can()['notDisplay'] == 0)
                        <tr onclick="window.location.href = '{{ route('admin.buildings.edit', $Building->id) }}';"
{{--<tr--}}
                            style="cursor: pointer;">
                            @foreach( $Columns AS $Column )
                                <th scope="col">{{ $Building[$Column] }} {{$Building->can()['notDisplay']}} {{$Building->can()['error'] ?? ''}}</th>
                            @endforeach
                        </tr>
                        @endif
                    @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
