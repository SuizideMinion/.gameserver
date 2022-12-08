@extends('layout.admin')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-sm float-right" onclick="window.location.href = '{{ route('admin.units.create') }}';">Add New Unit</button>
                <button type="button" class="btn btn-danger btn-sm float-right" onclick="window.location.href = '/admin/Unitsadd';">Reload CSV!!</button>
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

                    @foreach($Units as $key => $Unit)
                        @if($Unit->can()['notDisplay'] == 0)
{{--                        <tr onclick="window.location.href = '{{ route('admin.units.edit', $Unit->id) }}';"--}}
<tr
                            style="cursor: pointer;">
                            @foreach( $Columns AS $Column )
                                <th scope="col">{{ $Unit[$Column] }} {{$Unit->can()['notDisplay']}} {{$Unit->can()['error'] ?? ''}}</th>
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
