@extends('layout')

@section('content')
    <h1>Calendar</h1>
        <table class="table">
        <thead>
        <tr>
            <th scope="col">User Name</th>
            <th scope="col">Message Title Subject</th>
            <th scope="col">Email Address</th>
            <th scope="col">Body</th>
            <th scope="col">Full details</th>
            <th scope="col">Please Reply</th>
        </tr>
        </thead>
        <tbody>
        @foreach($eventss as $message)

                <tr>
                    <td><?php echo $message->getSender()->getEmailAddress()->getName() ?></td>
                    <td><?php echo $message->getSubject() ?></td>
                    <td><?php echo $message->getSender()->getEmailAddress()->getAddress() ?></td>
                    <td><?php echo $message->getbodypreview() ?></td>
                    <td><button type="button" data-toggle="modal" data-target="#myModal" onclick='functionToExecute(<?php  echo json_encode($message);?>)'>Click Here</button></td>
                    <td><form action="{{route('messageSend')}}" id="hidden_form" method="POST">
                            {{ csrf_field() }}

                            <input type="hidden" class="form-control" name="eventsubject" value="{{$message->getSubject()}}" />

                            <button type="submit" class="btn btn-primary">
                                send amrit
                            </button>
                        </form>
                    </td>

                </tr>
        @endforeach
        </tbody>
    </table>
@endsection




<script>
    function functionToExecute(message) {
        console.log(message);
        $('#myModal').modal('show');
        // var name=$view['sender']['emailAddress']['name'];
        var subject=message['subject'];
        // console.log(subject);
        $("#myModal .modal-body").html('Subject :'+subject+'');
    }
</script>
