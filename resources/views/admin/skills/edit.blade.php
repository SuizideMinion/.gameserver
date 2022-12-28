@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>

                    <!-- Horizontal Form -->
                    <form class="row g-3" method="post" action="{{ route('admin.buildings.update', $Building->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="desc" class="col-sm-2 col-form-label">Description:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="desc" name="desc"
                                       value="{{ $Building->desc }}">
                            </div>
                        </div>
                        <table class="table table-sm table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">key</th>
                                <th scope="col">value</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($BuildingsData as $BuildingData)
                                <tr onclick="window.location.href = '{{ route('admin.buildingsdata.edit', $BuildingData->id) }}';"
                                    style="cursor: pointer;">
                                    <th scope="row">{{ $BuildingData->id }}</th>
                                    <td>{{ $BuildingData->key }}</td>
                                    <td>{{ $BuildingData->value }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                        <div class="col-md-6">
                            <label for="key" class="form-label">Neuer Data Key</label>
                            <input type="text" class="form-control" id="key" name="key">
                        </div>
                        <div class="col-md-6">
                            <label for="value" class="form-label">Neue Data Value</label>
                            <input type="text" class="form-control" id="value" name="value">
                        </div>

                        <table class="table table-sm table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">key</th>
                                <th scope="col">value</th>
                                <th scope="col">Race</th>
                                <th scope="col">lang</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($BuildingsTrans as $BuildingTrans)
                                <tr onclick="window.location.href = '{{ route('admin.translate.edit', $BuildingTrans->id) }}';"
                                    style="cursor: pointer;">
                                    <th scope="row">{{ $BuildingTrans->id }}</th>
                                    <td>{{ $BuildingTrans->key }}</td>
                                    <td>{{ $BuildingTrans->value }}</td>
                                    <td>{{ $BuildingTrans->race }}</td>
                                    <td>{{ $BuildingTrans->lang }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                        <div class="col-md-4">
                            <label for="Tkey" class="form-label">Neuer String Key</label>
                            <input type="text" class="form-control" id="Tkey" name="Tkey">
                        </div>
                        <div class="col-md-4">
                            <label for="Tvalue" class="form-label">Neue String Value</label>
                            <input type="text" class="form-control" id="Tvalue" name="Tvalue">
                        </div>

                        <div class="col-md-2">
                            <label for="race" class="form-label">Rasse</label>
                            <select name="race" class="form-select" id="race"
                                    aria-label="">
                                <option value="0" >Keine Rasse</option>
                                <option value="1" >E</option>
                                <option value="2" >I</option>
                                <option value="3" >K</option>
                                <option value="4" >Z</option>
                                <option value="5" >A</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="lang" class="form-label">Lang</label>
                            <select name="lang" class="form-select" id="lang"
                                    aria-label="">
                                <option value="DE" >Deutsch</option>
                                <option value="EN" >Englisch</option>
                                <option value="CZ" >Tschechisch</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form><!-- End Horizontal Form -->


                </div>
            </div>

        </div>
    </div>
@endsection
