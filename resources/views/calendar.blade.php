@extends('layout')

@section('content')
    <h1>Calendar</h1>
    {{--    <h2>{{ $dateRange }}</h2>--}}
    <a class="btn btn-light btn-sm mb-4" href={{action('CalendarController@getNewEventForm')}}>Create New event Amrit</a>
    <a class="btn btn-light btn-sm mb-4" href={{action('CalendarController@amritmails')}}>Add  Amrit</a>
    <a class="btn btn-light btn-sm mb-4" href={{action('CalendarController@databasesget')}}>Show  Amrit</a>


    <table class="table">
        <thead>
        {{--        <form class="form-inline" method="POST" action="{{route('messageSend')}}">--}}
        {{--            <div class="input-group col-md-12">--}}
        {{--                <input type="text" class="form-control" placeholder="Search here..." name="keyword" required="required" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>"/>--}}
        {{--                <span class="input-group-btn">--}}
        {{--						<button class="btn btn-primary" name="search"><span class="glyphicon glyphicon-search"></span></button>--}}
        {{--					</span>--}}
        {{--            </div>--}}
        {{--        </form>--}}

        <tr>
            <th scope="col">Organizer</th>
            <th scope="col">Subject</th>
            <th scope="col">Start</th>
            <th scope="col">End</th>
            <th scope="col">Detail</th>
        </tr>
        </thead>
        <tbody>
        @isset($events)

            @foreach($events as $event)





                <tr>
                    <td>{{ $event->getOrganizer()->getEmailAddress()->getName() }}</td>
                    <td>{{ $event->getSubject() }}</td>
                    {{--                    <td>{{ $event->getBody()->getContentType() }}</td>--}}
                    <td>{{ \Carbon\Carbon::parse($event->getStart()->getDateTime())->format('n/j/y g:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->getEnd()->getDateTime())->format('n/j/y g:i A') }}</td>
                    {{--                    <td>{{ $event->getbody()->getContentType() }}</td>--}}
                    <td><button type="button"  data-toggle="modal" data-target="#myModal" class="btn btn-success"  onclick='myFunction(<?php  echo json_encode($event); ?>)'>View</button></td>

                </tr>


            @endforeach
        @endif
        </tbody>
    </table>
@endsection





<script>
    function myFunction(event) {
        // console.log(event);
        $('#myModal').modal('show');
        var name=event['organizer']['emailAddress']['name'];
        var subject=event['subject'];
        var date=event['end']['dateTime'];
        var body=event['body']['content'];
        // var subject=event['start'];
        console.log(body);
        $("#myModal .modal-body").html('username:    '+name+'<br>'+ 'Subject :'+subject+'<br>'+ 'Date :'+date+'<br>'+ 'body :'+body+'');


    }
</script>
