@extends('layout.ingame')

@section('styles')
@endsection

@section('settings')
@endsection

@section('content')
    @include('layout/bugs_navi')

    <div class="container" style="margin-top: 20px">
        <div class="user-message">
            @foreach($Bugs AS $Bug)
                <div class="user-message-one" style="cursor:pointer;" onclick="window.location.href = '{{ route('bugs.show', $Bug->id) }}';">
                    <div class="user-img">
                        {{ ($Bug->status == 1 ? 'Eingereicht':($Bug->status == 2 ? 'in Bearbeitung':'Behoben')) }}
                    </div>
                    <div class="user-text">
                        <h6>{{ $Bug->getUser->name }}</h6>
                        <div class="text">
                            <p>{{ $Bug->title }}</p>
                        </div>
                    </div>
                    <div class="user-active">
                        <span>{{ $Bug->created_at }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')

@endsection
