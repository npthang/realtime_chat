@extends('frontend.layouts.master')

@section('content')

<div class="ms-body"> 
    <div class="listview lv-message">
        <div class="lv-header-alt clearfix">
            <div id="ms-menu-trigger">
                <div class="line-wrap button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" role="button" type="button">
                    <div class="line top"></div>
                    <div class="line center"></div>
                    <div class="line bottom"></div>
                </div>
                @widget('MenuNav')
            </div>
            <div class="lvh-label hidden-xs">
                <div class="lv-avatar pull-left"> 
                    <img src="{{ asset('storage/avatars/' . $toUser->avatar) }}" alt=""> 
                </div>
                <span class="c-black">{{ $toUser->fullname }}</span>
            </div>
            <ul class="lv-actions actions list-unstyled list-inline">
                @if($friendship != null)
                @if($friendship->status == 1)
                <li>
                    <a href="{{ route('deleteRelationship',$friendship->id) }}"> <i class="fa fa-ban"></i></a> Unfriend
                </li>
                @endif
                @if($friendship->status == 0 && $friendship->user_request == Auth::user()->id)
                    <li>
                        <a href="{{ route('deleteRelationship', $friendship->id) }}" title="Cancel request">
                            <i class="fa fa-ban" aria-hidden="true"></i>
                        </a>

                    </li>
                @elseif($friendship->status == 0 && $friendship->user_accept == Auth::user()->id)
                    <li>
                        <a href="{{ route('acceptRelationship',$friendship->id) }}" title="Accept">
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('deleteRelationship',$friendship->id) }}" title="Deny">
                            <i class="fa fa-ban" aria-hidden="true"></i>
                        </a>
                    </li>
                @endif
                @else
                    <li>
                        <a href="{{ route('requestRelationship',$toUser->id) }}" title="Add friend">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                    </li>
                @endif
                    <li>
                        <a href="{{ route('requestRelationship',$toUser->id) }}" title="Hahaha">
                            <img src="/images/haha.png" alt="" width="25px" height="25px">
                        </a>
                    </li>
            </ul>
        </div>
        <div class="lv-body">
            <div class="row content-chat-video">
                <div class="col-md-12">
                    <div id="ms-scrollbar" class="content-message" style="overflow:scroll; overflow-x: hidden; height:72vh;" onmouseenter="return deleteNotif({{ $toUser->id }},{{ $user->id }})">
                        @foreach ($listPrivateChat as $key => $chat)
                        <div class="lv-item media @if($chat->from == Auth::id()) right @endif">
                            <div class="lv-avatar @if($chat->from == Auth::id()) pull-right @else pull-left @endif">
                                @if($chat->from == $user->id)
                                    <img src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="">
                                @elseif($chat->from == $toUser->id)
                                    <img src="{{ asset('storage/avatars/'.$toUser->avatar) }}" alt="">
                                @endif

                            </div>
                            <div class="media-body">
                                <div class="ms-item"> 
                                    {!! $chat->content !!}
                                </div>
                                <small class="ms-date">
                                    <span class="glyphicon glyphicon-time"></span>
                                    &nbsp; {{ date('d-m-Y', strtotime($chat->created_at)) }} at {{ date('H:i:s', strtotime($chat->created_at)) }}
                                </small> 
                            </div>
                        </div>
                        @endforeach
                        </div>
                        <div class="clearfix"></div>

                        <style type="text/css">
                           

                            .emotion{
                                position: relative;
                                z-index: 30000000;
                                bottom: 50px;

                            }
                            .emotion > button{
                                border: none;
                            }

                            #list-icon{
                                display: none;
                                
                            }

                        </style>
                        
                        <div class="lv-footer ms-reply">
                            <div class="emotion">
                                <button onclick="showEmotion()"><i class="fa fa-smile-o" aria-hidden="true"></i></button>
                            </div>

                            <div id="list-icon">
                                a
                            </div>
                             
                            <textarea rows="10" placeholder="Write messages..." id="txt-mess-content" onclick="return deleteNotif({{ $toUser->id }},{{ $user->id }})"></textarea>
                            <button class="" id='btn-reply'>
                                <span class="glyphicon glyphicon-send"></span>
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>

    function showEmotion(){
        $('#list-icon').show();
    }
    index = 10;
    var toUser = {!!json_encode($toUser)!!};
    console.log(toUser);
    scroll('.content-message');
    $('#txt-mess-content').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == 13) {
            $('#btn-reply').click();
            $('#content-message').val('');
        }
    });
    function deleteNotif(from,to) {
        $.ajax({
            url : "{{ route('deleteNotif') }}",
            type : "post",
            dataType:"text",
            data : {
                'userfrom' : from,
                'userto' : to
            },
            success : function (result){
            },error: function (){
            }
        });
    }
    function scroll(element) {
        $(element).animate({
            scrollTop: $(element)[0].scrollHeight
        });
    }
    $(function(){
        $('.content-message').scroll(function(){
            var distance = $('.content-message').scrollTop();
            if(distance == 0){
                $.ajax({
                    url : "{{ route('getmoreMsg') }}",
                    type : "post",
                    dataType:"text",
                    data : {
                        'from' : {{ Auth::user()->id }},
                        'to' : {{ $toUser->id }},
                        'offset': index
                    },
                    success : function (result){
                        if(result != 0){
                            $('.content-message').prepend(result);
                            var distance = $('.content-message').scrollTop(500);
                        }
                    },error: function (){
                    }
                });
                index = index + 10;
            }
        });
    });
</script>
<script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/validate.js') }}" type="text/javascript"></script>
@endsection
