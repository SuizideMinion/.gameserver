@extends('layout.ingame')

@section('styles')
@endsection

@section('settings')
@endsection

@section('content')
    @include('layout/bugs_navi')

    <div class="container" style="margin-top: 20px">
        <div class="user-message">
            <form class="" method="post" action="{{route('bugs.store')}}">
                @csrf
                <div class="text-form">
                    <div class="orbit-form d-grid">
                        <label for="input">
                            <input type="text" placeholder="Titel" name="title">
                        </label>
                        <select name="group" class="form-select class" aria-label="Default select example">
                            @foreach($arrayGroups as $Group)
                            <option value="{{ $Group }}" >{{ Lang('Bug.Group.'. $Group) }}</option>
                            @endforeach
                        </select>
                        <label for="textarea">
                            <textarea type="text" placeholder="Text" name="text" id="textarea"></textarea>
                        </label>
                        <span class="icon"><i class="fa-solid fa-question"></i></span>
                    </div>
                </div>
                <button class="orbit-btn" type="submit">Abschicken</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
