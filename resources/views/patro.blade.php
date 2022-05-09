@extends('layout')

@section('content')
    <h1>Calendar</h1>
    <h2>{{ $dateRange }}</h2>
    <a class="btn btn-light btn-sm mb-3" href={{action('PatroController@getNewEventForm')}}>New event Gurung</a>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Organizer</th>
            <th scope="col">Subject</th>
            <th scope="col">Body</th>
            <th scope="col">Start</th>
            <th scope="col">End</th>
        </tr>
        </thead>
        <tbody>
        @isset($patross)
<!--            --><?php //var_dump($patross); die(); ?>
            @foreach($patross as $event)

                <tr>
                    <td>{{ $event->getOrganizer()->getEmailAddress()->getName() }}</td>
                    <td>{{ $event->getSubject() }}</td>
                    {{--                    <td>{{ $event->getBody()->getContentType() }}</td>--}}
                    <td>{{ \Carbon\Carbon::parse($event->getStart()->getDateTime())->format('n/j/y g:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->getEnd()->getDateTime())->format('n/j/y g:i A') }}</td>
                    <td><a class="btn btn-light btn-sm mb-3" href={{action('CalendarController@getNewEventForm')}}>New event Gurung</a> </td>
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
        var body=event['end']['body'];
        // var subject=event['start'];
        console.log(body);
        $("#myModal .modal-body").html('username:    '+name+'<br>'+ 'Subject :'+subject+'<br>'+ 'Date :'+date+'<br>'+ 'body :'+body+'');


    }
</script>
