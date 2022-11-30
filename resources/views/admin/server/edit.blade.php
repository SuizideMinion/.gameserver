@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Übersetzungen</h5>
                    <form method="POST" action="{{ route('admin.server.update', $ServerData->id) }}">
                        @method('PUT')
                        @csrf
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">key</th>
                                <th scope="col">Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <th scope="row">*</th>
                                <td><input class="form-control" style="background: #fff;" type="text"
                                           name="key" id="key" placeholder="key" value="{{ $ServerData->key }}"></td>
                                <td><input class="form-control" style="background: #fff;" type="text"
                                           name="value" id="value" placeholder="Value" value="{{ $ServerData->value }}"></td>
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
