@extends('layouts.main')

@section('content')

    @foreach($show as $key => $value)
        <a href="{{route('show_info', ['channel' => $channel, 'day' => $day, 'id' => $value['id']])}}">
            <div class="show-listing">
                <div class="show-content">
                    <date>{{date("H:i",strtotime($value['start_datetime']))}}</date>
                    <span class="prog-name">{{ $value['name'] }}</span>
                    @if(isset($value['studio']) || isset($value['set']))
                        <p>
                            {{ $value['studio'] }} <small class="pullup">|</small> Set {{ $value['set'] }}
                        </p>
                    @endif
                </div>
            </div>
        </a>
    @endforeach

    @if(count($show) == 0)
        <div class="show-listing">
            <div class="show-content">
                Keine Daten vorhanden!
            </div>
        </div>
    @endif

    @if(isset($is_late))
        <div class="directions">
            <a href="{{url('shows')}}/{{$channel}}/{{$day}}">
                <img src="{{ asset('/image/icons_png/icon_back.png') }}" class="icon-direction">
            </a>
        </div>
    @else

        <div class="directions">
            <a href="{{url('shows')}}/{{$channel}}/{{$day}}/late_shift">
                <img src="{{ asset('/image/icons_png/icon_forward.png') }}" class="icon-direction">
            </a>
        </div>

    @endif
    <div class="home-symbol">
        <a href="{{url('channels')}}/{{$channel}}/{{$day}}">
            <img src="{{ asset('/image/icons_png/icon_home.png') }}" class="" height="80px" width="70px">
        </a>
    </div>

@endsection
