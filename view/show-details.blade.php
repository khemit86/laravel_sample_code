@extends('layouts.main')

@section('content')

    <div class="show-details">
        <div class="details-content employeees-text">
            <date>{{date("H:i",strtotime($show['start_datetime']))}}</date>
            <span class="prog-name">{{ $show['name'] }}</span>
            <p>
                @if($show['studio'])
                    <a href="#">
                        {{ $show['studio'] }}</a> <small>|</small>
                @endif

                @if($show['set'])
                    <a href="#">Set {{ $show['set'] }}</a>
                @endif
            </p>
        </div>
    </div>
    <div class="show-details-table-content">
        <table class="table">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @if($show['moderation'])
            <tr>
                <th scope="row" width="30%"><span class="detail-key">Moderation:</span></th>
                <td>
                    <span class="detail-value">{{ $show['moderation'] }}</span>
                </td>
            </tr>
            @endif

            @if($show['experte'])
            <tr>
                <th scope="row"><span class="detail-key">Experte:</span></th>
                <td>
                    <span class="detail-value">{{ $show['experte'] }}</span>
                </td>
            </tr>
            @endif

            @if($show['producer'])
            <tr>
                <th scope="row"><span class="detail-key">Producer:</span></th>
                <td>
                    <span class="detail-value">{{ $show['producer'] }}</span>
                </td>
            </tr>
            @endif

            @if($show['bimi'])
            <tr>
                <th scope="row"><span class="detail-key">Bimi:</span></th>
                <td>
                    <span class="detail-value">{{ $show['bimi'] }}</span>
                </td>
            </tr>
            @endif

            @if(!empty($show['model']) && !is_array($show['model']))
                <tr>
                    <th scope="row"><span class="detail-key">Model:</span></th>
                    <td>
                        <span class="detail-value">{{ $show['model'] }}</span>
                    </td>
                </tr>
            @endif

            @if(!empty($show['model']) && is_array($show['model']))
                @foreach($show['model'] as $model_name)
                <tr>
                    <th scope="row"><span class="detail-key">Model:</span></th>
                    <td>
                        <span class="detail-value">{{ $model_name }}</span>
                    </td>
                </tr>
                @endforeach
            @endif

            @if(!empty($schedules_data))
                @foreach($schedules_data as $schedule_data)
                    <tr>
                        <th scope="row"><span class="detail-key">{{$schedule_data['job_name']}}:</span></th>
                        <td><span
                                class="detail-value">{{$schedule_data['firstname']}} {{$schedule_data['lastname']}}</span>
                        </td>
                    </tr>
                @endforeach
            @endif

            </tbody>
        </table>
    </div>

    <div class="directions">
        {{--<a href="{{url('shows')}}/{{$channel}}/{{$day}}">
            <img src="{{ asset('/image/icons_png/icon_back.png') }}" class="icon-direction">
        </a>--}}
        <a href="{{ url()->previous() }}">
            <img src="{{ asset('/image/icons_png/icon_back.png') }}" class="icon-direction">
        </a>
    </div>
    <div class="home-symbol">
        <a href="{{url('channels')}}/{{$channel}}/{{$day}}">
            <img src="{{ asset('/image/icons_png/icon_home.png') }}" class="" height="80px" width="70px">
        </a>
    </div>
@endsection
