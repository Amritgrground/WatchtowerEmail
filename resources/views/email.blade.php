@extends('viewmessage')

@section('content')
    <h1>View Message</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">User Name</th>
            <th scope="col">Message Title Subject</th>
            <th scope="col">Email Address</th>
            <th scope="col">Attachments</th>
            <th scope="col">Full details</th>
            <th scope="col">Reply with attachments</th>
        </tr>
        </thead>
        @foreach ($eventss as $message)
            <?php
//            var_dump($message);
//            die();

            $popUp=[];
            $popUp['name']=$message->getSender()->getEmailAddress()->getName();
            $popUp['subject']=$message->getSubject();
            $popUp['email']=$message->getSender()->getEmailAddress()->getAddress();
            $popUp['id']=$message->getid();
            $popUp['attachment']=$message->getAttachments()[0]['contentBytes'];
    var_dump($message);
    die();
            ?>
            <tr>
                <td><?php echo $message->getSender()->getEmailAddress()->getName() ?></td>
                <td><?php echo $message->getSubject() ?></td>
                <td><?php echo $message->getSender()->getEmailAddress()->getAddress() ?></td>

                <td><?php echo $message->getAttachments()[0]['name']?>

                    <form action="{{route('messagedownload')}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" class="form-control" name="eventd" value="{{$message->getAttachments()[0]['name']}}" />
                        <input type="hidden" class="form-control" name="eventb" value="{{$message->getAttachments()[0]['contentBytes']}}" />
                        <input type="hidden" class="form-control" name="eventt" value="{{$message->getAttachments()[0]['contentType']}}" />
                        <button type="submit" class="btn btn-primary">Download Amrit</button>
                    </form>
                </td>
                <td>  <button type="button"  data-toggle="modal" data-target="#myModal" class="btn btn-success"  onclick='myFunction(<?php echo json_encode($popUp); ?>)'>View</button></td>
                <td><form action="{{route('messageSend')}}" method="POST"  id="my-form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" class="form-control" name="eventuser" value="{{ $message->getSender()->getEmailAddress()->getName()}}" />
                        <input type="hidden" class="form-control" name="eventsubject" value="{{$message->getSubject()}}" />
                        <input type="hidden" class="form-control" name="eventemail" value="{{$message->getSender()->getEmailAddress()->getAddress()}}" />
                        <input type="hidden" class="form-control" name="eventid" value="{{$message->getid()}}" />
                        <input type="file" class="form-control" name="images" multiple>
                        <input type="hidden" class="form-control" name="eventBody" value="{{$message->getbodypreview()}}" />
                        <button type="submit" class="btn btn-primary" id="btn-submit">Send back/ Reply</button>
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
        let subject = message['subject'];
        let email = message['email'];
        let body = message['body'];
        // let id = message['id'];
        // let attachment = message['attachment'];
        $("#myModal .modal-body").html('username:    '+name+'<br>'+ 'Subject :'+subject+'<br>'+'Email Address :'+email+'<br>'+'Body : '+body+'');
    }
</script>
