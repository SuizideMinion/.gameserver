@extends('layout.admin')

@section('styles')
    <style>

        img {
            max-width: 100%;
        }

        .recent_heading h4 {
            color: #05728f;
            font-size: 21px;
            margin: auto;
        }

        .chat_ib h5 {
            font-size: 15px;
            color: #464646;
            margin: 0 0 8px 0;
        }

        .chat_ib h5 span {
            font-size: 13px;
            float: right;
        }

        .chat_ib p {
            font-size: 14px;
            color: #989898;
            margin: auto
        }

        .received_withd_msg p {
            background: #ebebeb none repeat scroll 0 0;
            border-radius: 3px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .mesgs {
            float: left;
            padding: 30px 15px 0 25px;
            width: 100%;
        }

        .sent_msg p {
            background: #05728f none repeat scroll 0 0;
            border-radius: 3px;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
        }

    </style>
@endsection

@section('settings')
@endsection

@section('content')
    <div class="container">
        <div class="mesgs">
            <div class="message-type">
                <form method="post" action="{{ route('admin.messages.store') }}">
                    @csrf
                    <div class="message-type-one">
                        <div class="text-btn">
                            <div class="row mb-3">
                                <label for="text" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <textarea id="text" class="form-control" name="text" style="height: 100px"></textarea>
                                </div>
                            </div>
                            <button type="submit">send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
