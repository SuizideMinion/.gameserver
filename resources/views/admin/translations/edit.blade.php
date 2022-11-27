@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Übersetzungen</h5>
                    <form method="POST" action="{{ route('admin.translate.update', $Translation->id) }}">
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
                                <th scope="col">race</th>
                                <th scope="col">Value</th>
                                <th scope="col">Plural</th>
                                <th scope="col">Sprache</th>
                                <th scope="col">Erstellt</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <th scope="row">*</th>
                                <td><input class="form-control" style="background: #fff;" type="text"
                                           name="key" id="key" placeholder="key" value="{{ $Translation->key }}"></td>
                                <td><select name="race" class="form-select" id="inputGroupSelect"
                                            aria-label="">
                                        <option value="0" {{ $Translation->race == 0 ? 'selected':'' }}>Keine Rasse</option>
                                        <option value="1" {{ $Translation->race == 1 ? 'selected':'' }}>E</option>
                                        <option value="2" {{ $Translation->race == 2 ? 'selected':'' }}>I</option>
                                        <option value="3" {{ $Translation->race == 3 ? 'selected':'' }}>K</option>
                                        <option value="4" {{ $Translation->race == 4 ? 'selected':'' }}>Z</option>
                                        <option value="5" {{ $Translation->race == 5 ? 'selected':'' }}>A</option>
                                    </select>
                                </td>
                                <td><input class="form-control" style="background: #fff;" type="text"
                                           name="value" id="value" placeholder="Value" value="{{ $Translation->value }}"></td>
                                <td><input class="form-control" style="background: #fff;" type="text"
                                           name="plural" id="plural" placeholder="plural" value="{{ $Translation->plural }}"></td>
                                <td><select name="lang" class="form-select" id="inputGroupSelect"
                                            aria-label="">
                                        <option value="DE" {{ $Translation->lang == 'DE' ? 'selected':'' }}>Deutsch</option>
                                        <option value="EN" {{ $Translation->lang == 'EN' ? 'selected':'' }}>Englisch</option>
                                        <option value="CZ" {{ $Translation->lang == 'CZ' ? 'selected':'' }}>Tschechisch</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-outline-secondary" type="submit">Eintragen</button>
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
