@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Übersetzungen</h5>
                    <form method="POST" action="{{ route('admin.buildingsdata.update', $BuildingData->id) }}">
                        @if( isset($id) )
                            <input type="hidden" name="id" value="{{$id}}">
                        @endif
                        @method('PUT')
                        @csrf
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">key</th>
                                <th scope="col">value</th>
                                <th scope="col">Build_Id</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <th scope="row">*</th>
                                <td><input class="form-control" style="background: #fff;" type="text"
                                           name="key" id="key" placeholder="key" value="{{ $BuildingData->key }}"></td>
                                <td><input class="form-control" style="background: #fff;" type="text"
                                           name="value" id="value" placeholder="Value" value="{{ $BuildingData->value }}"></td>
                                <td><input class="form-control" style="background: #fff;" type="text"
                                           name="build_id" id="build_id" placeholder="build_id" value="{{ $BuildingData->build_id }}"></td>
                                <td>
                                    <button class="btn btn-outline-secondary" type="submit">Speichern</button>
                                </td>

                            </tr>

                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
