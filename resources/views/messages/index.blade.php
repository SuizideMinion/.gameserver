@extends('layout.ingame')

@section('styles')
    <style>

        img {
            max-width: 100%;
        }

        .inbox_people {
            float: left;
            overflow: hidden;
            width: 40%;
            border-right: 1px solid #c4c4c4;
        }

        .inbox_msg {
            border: 1px solid #c4c4c4;
            clear: both;
            overflow: hidden;
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

        .chat_img {
            float: left;
            width: 11%;
        }

        .chat_ib {
            float: left;
            padding: 0 0 0 15px;
            width: 88%;
        }

        .chat_people {
            overflow: hidden;
            clear: both;
        }

        .chat_list {
            border-bottom: 1px solid #c4c4c4;
            margin: 0;
            padding: 18px 16px 10px;
        }

        .inbox_chat {
            height: 60vh;
            overflow-y: scroll;
        }

        .incoming_msg_img {
            display: inline-block;
            width: 6%;
        }

        .received_msg {
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            width: 92%;
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

        .time {
            color: #747474;
            font-size: 12px
        }

        .received_withd_msg {
            width: 57%;
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

        .outgoing_msg {
            overflow: hidden;
            margin: 26px 0 26px;
        }

        .sent_msg {
            float: right;
            width: 46%;
        }

        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
        }

        .type_msg {
            border-top: 1px solid #c4c4c4;
            position: relative;
        }

        .msg_send_btn {
            background: #05728f none repeat scroll 0 0;
            border: medium none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            height: 33px;
            position: absolute;
            right: 0;
            top: 11px;
            width: 33px;
        }

        .messaging {
            padding: 0 0 50px 0;
        }

        .msg_history {
            height: 516px;
            overflow-y: auto;
        }
    </style>
@endsection

@section('settings')
@endsection

@section('content')
    <div class="container">
        {{--        <div class="messaging">--}}
        {{--            <div class="inbox_msg">--}}
        {{--                <div class="inbox_people">--}}
        {{--                    <div class="inbox_chat">--}}
        {{--                        <div class="active_chat user-message-one">--}}
        {{--                            <div class="user-img"><img src="https://ptetutorials.com/images/user-profile.png"--}}
        {{--                                                       alt="sunil"></div>--}}
        {{--                            <div class="user-text">--}}
        {{--                                <h6>Sunil Rajput</h6>--}}
        {{--                                <div class="text">--}}
        {{--                                    <p>Test, which is a new approach to have all solutions--}}
        {{--                                        astrology under one roof.</p>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <div class="user-active">--}}
        {{--                                <span>1h</span>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                        <div class="user-message-two">--}}
        {{--                            <div class="user-img"><img src="https://ptetutorials.com/images/user-profile.png"--}}
        {{--                                                       alt="sunil"></div>--}}
        {{--                            <div class="user-text">--}}
        {{--                                <h6>Sunil Rajput</h6>--}}
        {{--                                <div class="text">--}}
        {{--                                    <p>Test, which is a new approach to have all solutions--}}
        {{--                                        astrology under one roof.</p>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <div class="user-active">--}}
        {{--                                <span>1h</span>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        <div class="mesgs">
            <div class="msg_history ">
                @foreach( $Messages AS $Message)
                    <div
                        class="{{ ( $Message->sender_id == auth()->user()->id ? 'outgoing-message':'upcoming-message') }}">
                        <p><span class="time">{{ $Message->created_at }}</span><br>{{ $Message->text }}</p>
                    </div>
                @endforeach
                <div class="lastElement"></div>
            </div>
            <div class="type_msg">
                <div class="input_msg_write">
                    <form class="row g-3" method="post" action="{{ route('messages.update', $id) }}">
                        @csrf
                        @method('PUT')
                        <input type="text" name="text" class="write_msg" placeholder="Type a message"/>
                        <button class="msg_send_btn" type="button"><i class="bi bi-cursor" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        {{--            </div>--}}

        {{--        </div>--}}
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // setTimeout( function() {$(".lastElement").scrollTop(0)}, 200 );
            $('.msg_history').animate({
                scrollTop: $(".lastElement").offset().top
            }, 1000);
        });
    </script>
@endsection
