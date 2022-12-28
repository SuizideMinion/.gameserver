@extends('layout.admin')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-sm float-right" onclick="window.location.href = '{{ route('admin.skills.create') }}';"><s>Add New Building</s></button>
                <button type="button" class="btn btn-danger btn-sm float-right" onclick="window.location.href = '/admin/skillsadd';">Reload CSV!!</button>
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
                        <tr onclick="window.location.href = '{{ route('admin.skills.edit', $Building->id) }}';"
{{--<tr--}}
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
