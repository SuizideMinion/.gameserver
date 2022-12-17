<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>test DE:r ingame</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/assets/img/favicon.ico" rel="icon">
    <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Template Main CSS File -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/{{ uData('race') }}.css" rel="stylesheet">
    <link href="/assets/css/responsive.css" rel="stylesheet">
    <style type="text/css">
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

        .srch_bar input {
            border: 1px solid #cdcdcd;
            border-width: 0 0 1px 0;
            width: 80%;
            padding: 2px 0 4px 6px;
            background: none;
        }

        .srch_bar .input-group-addon button {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            padding: 0;
            color: #707070;
            font-size: 18px;
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

        .inbox_chat {
            height: 550px;
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
            width: 60%;
            height: 582px;
            overflow: scroll;
            OVERFLOW-X: auto;
            max-height: 100%;
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
<body>
<!------ Include the above in your HEAD tag ---------->

    <div class="messaging">
        <div class="inbox_msg">
            <div class="inbox_people">
                <div class="inbox_chat agenda">
                    @foreach($Researchs as $Key => $Research)
                        <div class="agenda-one" onclick="showResearch('/researchs/{{ $Key }}')">
                            <div class="user-text">
                                <div class="text">
                                    <p>{{ Lang('Forschung.Group.'. $Key, array: [':KOLLEKTOREN' => Lang('Unit.name.1', plural: '2')]) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mesgs">
            </div>
        </div>
    </div>

<script src="/assets/js/jquery.js"></script>
<script type="text/javascript">
    function showResearch(id)
    {
        $(".mesgs").html(
            '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $(document).ready(function() {
            $('.mesgs').load(id);
        })
    }
</script>

<script>
    $('.m').each(function () {
        if ($(this).text() > {{ uRess()->ress1 }}) {
            $(this).css("color", "red");
        }
    });
    $('.d').each(function () {
        if ($(this).text() > {{ uRess()->ress2 }}) {
            $(this).css("color", "red");
        }
    });
    $('.i').each(function () {
        if ($(this).text() > {{ uRess()->ress3 }}) {
            $(this).css("color", "red");
        }
    });
    $('.e').each(function () {
        if ($(this).text() > {{ uRess()->ress4 }}) {
            $(this).css("color", "red");
        }
    });
    $('.t').each(function () {
        if ($(this).text() > {{ uRess()->ress5 }}) {
            $(this).css("color", "red");
        }
    });
</script>

</body>
</html>
