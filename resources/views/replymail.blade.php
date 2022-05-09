
@extends('viewmessage')

@section('content')
    <h1>View Message</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">User Name</th>
            <th scope="col">Message Title Subject</th>
            <th scope="col">Email Address</th>
            <th scope="col">Full details</th>
            <th scope="col">Reply</th>
        </tr>
        </thead>
        @foreach ($eventss as $message)
            <?php
            $popUp=[];
            $popUp['name']=$message->getSender()->getEmailAddress()->getName();
            $popUp['subject']=$message->getSubject();
            $popUp['email']=$message->getSender()->getEmailAddress()->getAddress();
            $popUp['body']=$message->getbodyPreview();
            $popUp['bodys']=$message->getBody()->getContent();
            ?>
            <tr>
                <td><?php echo $message->getSender()->getEmailAddress()->getName() ?></td>
                <td><?php echo $message->getSubject() ?></td>
                <td><?php echo $message->getSender()->getEmailAddress()->getAddress() ?></td>
                {{--                <td><?php echo $message->getbodypreview() ?></td>--}}
                <td>  <button type="button"  data-toggle="modal" data-target="#myModal" class="btn btn-success"  onclick='myFunction(<?php echo json_encode($popUp); ?>)'>View</button></td>
                <td><form action="{{route('messageSend')}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" class="form-control" name="eventuser" value="{{ $message->getSender()->getEmailAddress()->getName()}}" />
                        <input type="hidden" class="form-control" name="eventsubject" value="{{$message->getSubject()}}" />
                        <input type="hidden" class="form-control" name="eventemail" value="{{$message->getSender()->getEmailAddress()->getAddress()}}" />
                        {{--                        <input type="file" name="eventfile" value="">--}}
                        <button type="submit" class="btn btn-primary">upload please</button>
                        <button type="submit" class="btn btn-primary">Send back</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection

<script>
    function myFunction(message) {
        console.log(message);
        $('#myModal').modal('show');
        let name = message['name'];
        console.log(name);
        let subject = message['subject'];
        let email = message['email'];
        let body = message['body'];
        let bodys = message['bodys'];
        console.log(bodys);
        let date = message['date'];
        console.log(bodys);

        $("#myModal .modal-body").html('username:    '+name+'<br>'+ 'Subject :'+subject+'<br>'+'Email Address :'+email+'<br>'+'Body : '+body+'<br>'+'bodys : '+bodys+'<br>'+'date : '+date+'');
    }
</script>
