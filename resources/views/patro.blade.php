@extends('layout')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Subject</th>
            <th scope="col">Body Preview</th>
        </tr>

        </thead>
        <tbody>
        @isset($eventss)
            @foreach ($eventss as $message)
                <?php
                //            dd($message);
                //        dd($message->getFrom()->getEmailAddress()->getName() );
                //        dd($message->getSender()->getEmailAddress()->getAddress() );
                ?>

                <tr>
                    {{--            <td><?php echo $message->getFrom()->getEmailAddress()->getName()?></td>--}}

                    <td><?php echo $message->getSubject() ?></td>
                    <td><?php echo $message->getbodypreview() ?></td>
                    {{--            <td><?php echo $message->getFrom()->getEmailAddress()->getName()?></td>--}}



                    <td><form action="{{route('data')}}" method="POST">
                            {{ csrf_field() }}
                            {{--                    <input type="hidden" class="form-control" name="name" value="{{ $message->getSender()->getEmailAddress()->getName()}}" />--}}
                            <input type="hidden" class="form-control" name="subject" value="{{$message->getSubject()}}" />
                            {{--                    <input type="hidden" class="form-control" name="address" value="{{$message->getSender()->getEmailAddress()->getAddress()}}" />--}}
                            {{--                    <input type="hidden" class="form-control" name="age" value="{{$message->getbodypreview()}}" />--}}
                            <button type="submit"  name="submit" class="btn btn-primary">Please store to database</button>
                        </form>
                    </td>





                    {{--            <td>--}}
                    {{--                <form action="{{route('data')}}" method="POST">--}}
                    {{--                    {{ csrf_field() }}--}}
                    {{--                    <label>name</label>--}}
                    {{--                    <input type="text" class="form-control" name="name"  />--}}
                    {{--                    <label>age</label>--}}
                    {{--                    <input type="text" class="form-control" name="age" />--}}
                    {{--                    <label>address</label>--}}
                    {{--                    <input type="text" class="form-control" name="address"/>--}}
                    {{--                    <label>subject</label>--}}
                    {{--                    <input type="text" class="form-control" name="subject"/>--}}
                    {{--                    <label>Save</label>--}}
                    {{--                    <input type="submit" class="btn btn-primary mr-2" />--}}
                    {{--                    <button type="submit" class="btn btn-primary" id="btn-submit">Send back/ Reply</button>--}}
                    {{--                    <button type="submit"  name="submit" class="btn btn-primary">Save</button>--}}
                    {{--                </form>--}}
                    {{--            </td>--}}
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
@endsection
