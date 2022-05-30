<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Microsoft\Graph\CallRecords\Model\Session;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\TimeZones\TimeZones;

class CalendarController extends Controller
{
    public function list(){

        return DB::table('databasegraph')->get();
    }


    public function amritmail()
    {
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();
        //dd($accessToken);
        $accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6IjhkQzJVQlVIXzFNN3J2OWY3SGludjlXb2ZNOTF0TEZPdzhOQ0dLalVMNlUiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8yYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUvIiwiaWF0IjoxNjUzOTA5NjY5LCJuYmYiOjE2NTM5MDk2NjksImV4cCI6MTY1MzkxNTI2NCwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZSGdWY0w3NjlKejVmSHJXVGx5OHp0NW5GLzBQK3FHVXdxMXcrdG8yKzUxcTJTSUEiLCJhbXIiOlsicHdkIiwicnNhIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJkZXZpY2VpZCI6ImE5N2VlZjQzLWQ3OTMtNDQxZS1hNjRkLWU4NTk5Y2MxYzhmNiIsImZhbWlseV9uYW1lIjoiR3VydW5nIiwiZ2l2ZW5fbmFtZSI6IkFtcml0IiwiaWR0eXAiOiJ1c2VyIiwiaXBhZGRyIjoiODAuMTk1LjcwLjEwMiIsIm5hbWUiOiJBbXJpdCBHdXJ1bmciLCJvaWQiOiI2MDNjMDQwZC1mYTM4LTQxNTgtODg2OC1hYmExZDg3OTI1M2EiLCJwbGF0ZiI6IjMiLCJwdWlkIjoiMTAwMzIwMDFERkIyMEU4MiIsInJoIjoiMC5BWE1BNHdCY0xBV1lDVUM0YlBqXzd2YkV0UU1BQUFBQUFBQUF3QUFBQUFBQUFBQnpBQlEuIiwic2NwIjoiQ2FsZW5kYXJzLlJlYWQgQ2FsZW5kYXJzLlJlYWQuU2hhcmVkIENhbGVuZGFycy5SZWFkV3JpdGUgQ2hhbm5lbE1lc3NhZ2UuU2VuZCBDaGF0LlJlYWRXcml0ZSBDaGF0TWVzc2FnZS5TZW5kIEZpbGVzLlJlYWQgRmlsZXMuUmVhZC5BbGwgRmlsZXMuUmVhZFdyaXRlIEZpbGVzLlJlYWRXcml0ZS5BbGwgTWFpbC5SZWFkIE1haWwuUmVhZEJhc2ljIE1haWwuUmVhZFdyaXRlIE1haWwuU2VuZCBNYWlsYm94U2V0dGluZ3MuUmVhZCBvcGVuaWQgcHJvZmlsZSBTaXRlcy5SZWFkLkFsbCBTaXRlcy5SZWFkV3JpdGUuQWxsIFVzZXIuUmVhZCBVc2VyLlJlYWRCYXNpYy5BbGwgVXNlci5SZWFkV3JpdGUgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJ1M0xFZnJKNVZ6aEpYbUlKUWgxM2M3SDhvZEdlaHFIak5RaV9DUW5TdEJvIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiMmM1YzAwZTMtOTgwNS00MDA5LWI4NmMtZjhmZmVlZjZjNGI1IiwidW5pcXVlX25hbWUiOiJhbXJpdC5ndXJ1bmdAcm91bmRjb3JwLmNvbSIsInVwbiI6ImFtcml0Lmd1cnVuZ0Byb3VuZGNvcnAuY29tIiwidXRpIjoieGFjYUxyM3hsMHVmcWdqYzV0UmFBQSIsInZlciI6IjEuMCIsIndpZHMiOlsiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19zdCI6eyJzdWIiOiI4UHEtZTU5S1Y0dGFIZkJBQllkXzBxSUp1Vzk2ZE1pUEFHdXZxclJnV0o0In0sInhtc190Y2R0IjoxNTk4MjIwMjA0fQ.YbMVgFmqcji2-uot5AF0KsV2xwFN3ol_Bu8WdG-WtUnX3ExF40q9tfEgM8mJH6gnUJYx--NfU_YxcKWKFIpQhZ3z67oXQZd7Eq5WKPjXLuGVn6DZ28HbpDFSxW2IQwuj5XQ0VZYdxjXqpUShfSKY39efoyOYAPUeoimXqvXGlQojCUxN8QBNcxmwzs11xCwoL42dQc-NbtuJg2ktCbdbkgyPBFc-BtBpA4ZiMgAhRJpqbHa5A35mbkcyMAfzV36KZl1rigyO2TvDFYxPeCOjtHw2E8x_fVPJ6uJ3Bo78UsNPxbuELWykvG4Ulk0uOGmPHh1iK7Lr0Qi7qIJQ7-90Gg';
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        $ptr = $graph->createCollectionRequest("GET", "/me/messages?expand=attachments")
//            dd($ptr)
            ->setReturnType(Model\Message::class)
            ->setPageSize(2);
        $eventss = $ptr->getPage();
//        dd($eventss);
        return view('email', compact('eventss'));
    }


    public function amritmails()
    {
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();
        //dd($accessToken);
        $accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6IjhkQzJVQlVIXzFNN3J2OWY3SGludjlXb2ZNOTF0TEZPdzhOQ0dLalVMNlUiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8yYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUvIiwiaWF0IjoxNjUzOTA5NjY5LCJuYmYiOjE2NTM5MDk2NjksImV4cCI6MTY1MzkxNTI2NCwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZSGdWY0w3NjlKejVmSHJXVGx5OHp0NW5GLzBQK3FHVXdxMXcrdG8yKzUxcTJTSUEiLCJhbXIiOlsicHdkIiwicnNhIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJkZXZpY2VpZCI6ImE5N2VlZjQzLWQ3OTMtNDQxZS1hNjRkLWU4NTk5Y2MxYzhmNiIsImZhbWlseV9uYW1lIjoiR3VydW5nIiwiZ2l2ZW5fbmFtZSI6IkFtcml0IiwiaWR0eXAiOiJ1c2VyIiwiaXBhZGRyIjoiODAuMTk1LjcwLjEwMiIsIm5hbWUiOiJBbXJpdCBHdXJ1bmciLCJvaWQiOiI2MDNjMDQwZC1mYTM4LTQxNTgtODg2OC1hYmExZDg3OTI1M2EiLCJwbGF0ZiI6IjMiLCJwdWlkIjoiMTAwMzIwMDFERkIyMEU4MiIsInJoIjoiMC5BWE1BNHdCY0xBV1lDVUM0YlBqXzd2YkV0UU1BQUFBQUFBQUF3QUFBQUFBQUFBQnpBQlEuIiwic2NwIjoiQ2FsZW5kYXJzLlJlYWQgQ2FsZW5kYXJzLlJlYWQuU2hhcmVkIENhbGVuZGFycy5SZWFkV3JpdGUgQ2hhbm5lbE1lc3NhZ2UuU2VuZCBDaGF0LlJlYWRXcml0ZSBDaGF0TWVzc2FnZS5TZW5kIEZpbGVzLlJlYWQgRmlsZXMuUmVhZC5BbGwgRmlsZXMuUmVhZFdyaXRlIEZpbGVzLlJlYWRXcml0ZS5BbGwgTWFpbC5SZWFkIE1haWwuUmVhZEJhc2ljIE1haWwuUmVhZFdyaXRlIE1haWwuU2VuZCBNYWlsYm94U2V0dGluZ3MuUmVhZCBvcGVuaWQgcHJvZmlsZSBTaXRlcy5SZWFkLkFsbCBTaXRlcy5SZWFkV3JpdGUuQWxsIFVzZXIuUmVhZCBVc2VyLlJlYWRCYXNpYy5BbGwgVXNlci5SZWFkV3JpdGUgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJ1M0xFZnJKNVZ6aEpYbUlKUWgxM2M3SDhvZEdlaHFIak5RaV9DUW5TdEJvIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiMmM1YzAwZTMtOTgwNS00MDA5LWI4NmMtZjhmZmVlZjZjNGI1IiwidW5pcXVlX25hbWUiOiJhbXJpdC5ndXJ1bmdAcm91bmRjb3JwLmNvbSIsInVwbiI6ImFtcml0Lmd1cnVuZ0Byb3VuZGNvcnAuY29tIiwidXRpIjoieGFjYUxyM3hsMHVmcWdqYzV0UmFBQSIsInZlciI6IjEuMCIsIndpZHMiOlsiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19zdCI6eyJzdWIiOiI4UHEtZTU5S1Y0dGFIZkJBQllkXzBxSUp1Vzk2ZE1pUEFHdXZxclJnV0o0In0sInhtc190Y2R0IjoxNTk4MjIwMjA0fQ.YbMVgFmqcji2-uot5AF0KsV2xwFN3ol_Bu8WdG-WtUnX3ExF40q9tfEgM8mJH6gnUJYx--NfU_YxcKWKFIpQhZ3z67oXQZd7Eq5WKPjXLuGVn6DZ28HbpDFSxW2IQwuj5XQ0VZYdxjXqpUShfSKY39efoyOYAPUeoimXqvXGlQojCUxN8QBNcxmwzs11xCwoL42dQc-NbtuJg2ktCbdbkgyPBFc-BtBpA4ZiMgAhRJpqbHa5A35mbkcyMAfzV36KZl1rigyO2TvDFYxPeCOjtHw2E8x_fVPJ6uJ3Bo78UsNPxbuELWykvG4Ulk0uOGmPHh1iK7Lr0Qi7qIJQ7-90Gg';
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        $ptr = $graph->createCollectionRequest("GET", "/me/messages?expand=attachments")
//            dd($ptr)
            ->setReturnType(Model\Message::class)
            ->setPageSize(3);
        $eventss = $ptr->getPage();
//        dd($eventss);
        return view('patro', compact('eventss'));
    }




    public function getNewEventForm()
    {
        $viewData = $this->loadViewData();

        return view('newevent', $viewData);
    }

    public function getNewEventForms()
    {
        $viewData = $this->loadViewData();

        return view('patro', $viewData);
    }


    public function datas(Request $request)
    {

        $conn = mysqli_connect('localhost', 'root', 'software123!', 'databasegraph');


        if(isset($_POST['submit'])){
            $subject = $request->subject;
            $name = $request->name;
            $age = $request->age;
            $address = $request->address;

////            $id  = $_POST['id'];
//            $name = $_POST['name'];
//            dd($name);
//            $age   = $_POST['age'];
//            $address    = $_POST['address'];
//            $subject    = $_POST['subject'];

//            $query = "INSERT INTO databasegraph VALUES ('$name','$age','$address', '$subject')";
//            dd($query);
            $query = "INSERT INTO databasegraph ( name, address, subject)
            VALUES ('$name','$address', '$subject')";
//            dd($query);
            $execute = mysqli_query($conn, $query);
//            dd($execute);
            if($execute=== true){
                $msg= "Data was inserted successfully";
                dd($msg);
            }else{
                dd('sory');
//                $msg= mysqli_error($conn);
            }

        }


    }

    public function databasesget()
    {

        $conn = mysqli_connect('localhost', 'root', 'software123!', 'databasegraph');
        if ($conn->connect_error) {
            dd('Process');
            echo "$conn->connect_error";
            die("Connection Failed : " . $conn->connect_error);
        } else {
            $sql = "SELECT * FROM databasegraph";
//            $result = mysqli_query($conn, $sql);
            $result = $conn->query($sql);


//            $resultCheck = mysqli_num_rows($result);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {

                    $databases = ["id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["age"]] ;

//                    dd($databases);
                    return view('emailss', compact('databases'));
//                    return view('emailss', $databases);
                }
            } else {
                echo "0 results";
            }


//
//            if ($resultCheck > 0) {
//                while ($row = mysqli_fetch_all($result)){
//                $databases = array();
//                $databases[] = mysqli_fetch_assoc($result);
//
//
////                    $database[] = [
////
////                        $row = mysqli_fetch_all($result),
////
//////                        $a = mysqli_fetch_assoc($row),
//////                $rows[] = mysqli_fetch_array($result),
////
//////                $database = $row['name']."<br>",
////
////                    ];
////                    while ($row = mysqli_fetch_assoc($result)){
////                    $database = $row['id']."<br>";
////                    $database = $row;
////                dd($databases);
//                    return view('emailss', compact('databases'));
////                dd('hi');
////                return view('emailss', $databases);
////                }
//            }
////            $data = databasegraph::all;
////            dd($result);
//            $database = [
//
//                    $row[] = mysqli_fetch_all($result),
////                $rows[] = mysqli_fetch_array($result),
//
////                $database = $row['name']."<br>",
//
//            ];
////            dd($database);
////            for($i=0; $row = mysqli_fetch_assoc($result); $i++){
//////            if ($resultCheck > 0)
////
//////                while ($row = mysqli_fetch_assoc($result))
////                {
//////                    dd($row['name']."<br>");
////
////                    $database = $row['name']."<br>";
////                    dd($database);
//////                    $database = $amrit->getPage();
////
////                }
////            }
//        dd($database);
//                    return view('emailss', compact('database'));
//                    return view('emailss', $database);

            dd(' Not done');
            echo "Registration successfully...";

        }
//        $record="SELECT * FROM databasegraph;";
//        $list = array();
//        while($row=mysql_fetch_assoc($record)){
//            //fill array how to fill array that will look like bellow from database???
//            $list[] = row;
//        }


//        dd($request->all());
//        $subject = $request->subject;
//        $name = $request->name;
//        $age = $request->age;
//        $address = $request->address;
//        dd($subject);


//            DB::table('databasegraph')->insert($datasave);
        // Database connection

        DB::table('databasegraphs')->get();
        dd('hi');

        return view('emailss', $viewData);
    }




    public function calendar()
    {
        $viewData = $this->loadViewData();

        $graph = $this->getGraph();

        // Get user's timezone
        $timezone = TimeZones::getTzFromWindows($viewData['userTimeZone']);

        // Get start and end of week
        $startOfWeek = new \DateTimeImmutable('sunday -1 week', $timezone);
        $endOfWeek = new \DateTimeImmutable('sunday', $timezone);
        $viewData['dateRange'] = $startOfWeek->format('M j, Y') . ' - ' . $endOfWeek->format('M j, Y');

        $queryParams = array(
            'startDateTime' => $startOfWeek->format(\DateTimeInterface::ISO8601),
            'endDateTime' => $endOfWeek->format(\DateTimeInterface::ISO8601),
            // Only request the properties used by the app
            '$select' => 'subject,organizer,start,end',
            // Sort them by start time
            '$orderby' => 'start/dateTime',
            // Limit results to 25
            '$top' => 25
        );
        // Append query parameters to the '/me/calendarView' url
        $getEventsUrl = '/me/calendarview?startdatetime=2022-03-23T12:14:02.300Z&enddatetime=2022-03-30T11:14:02.300Z';
        $events = $graph->createRequest('GET', $getEventsUrl)
//            ->Expand("attachments")
            //  $events = $graph->createRequest('GET', "/me/calendarview?startdatetime=2022-03-23T12:14:02.300Z&enddatetime=2022-03-30T11:14:02.300Z")
            // Add the user's timezone to the Prefer header
            ->addHeaders(array(
                'Prefer' => 'outlook.timezone="' . $viewData['userTimeZone'] . '"'
            ))
            ->setReturnType(Model\Event::class)
            ->execute();
        //  dd($events);
        $viewData['events'] = $events;
        return view('calendar', $viewData);
    }





    private function getGraph(): Graph
    {
        // Get the access token from the cache
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();

        // Create a Graph client
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        return $graph;
    }



    public function createNewEvent(Request $request)
    {
        // Validate required fields
        $request->validate([
            'eventSubject' => 'nullable|string',
            'eventAttendees' => 'nullable|string',
            'eventStart' => 'required|date',
            'eventEnd' => 'required|date',
            'eventBody' => 'nullable|string'
        ]);
        $viewData = $this->loadViewData();

        $graph = $this->getGraph();
        // Attendees from form are a semi-colon delimited list of
        // email addresses
        $attendeeAddresses = explode(';', $request->eventAttendees);
        // The Attendee object in Graph is complex, so build the structure
        $attendees = [];
        foreach ($attendeeAddresses as $attendeeAddress) {
            array_push($attendees, [
                // Add the email address in the emailAddress property
                'emailAddress' => [
                    'address' => $attendeeAddress
                ],
                // Set the attendee type to required
                'type' => 'required'
            ]);
        }
        // Build the event
        $newEvent = [
            'subject' => $request->eventSubject,
            'attendees' => $attendees,
            'start' => [
                'dateTime' => $request->eventStart,
                'timeZone' => $viewData['userTimeZone']
            ],
            'end' => [
                'dateTime' => $request->eventEnd,
                'timeZone' => $viewData['userTimeZone']
            ],
            'body' => [
                'content' => $request->eventBody,
                'contentType' => 'text'
            ]
        ];
        //dd($newEvent);
        // POST /me/events
        $response = $graph->createRequest('POST', '/me/events')
            ->attachBody($newEvent)
            ->setReturnType(Model\Event::class)
            ->execute();

        return redirect('/calendar');
    }

    public function view()
    {
        // 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

        $tokenCache = new TokenCache();

        $accessToken = $tokenCache->getAccessToken();

        //dd($accessToken);
        $accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6ImRtSWVpRENpMjRuNy00TjVHal9qRmVRZ0hIYVhlVEFaaG1wRTZyNHRyczQiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8yYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUvIiwiaWF0IjoxNjQ3MjYzOTE4LCJuYmYiOjE2NDcyNjM5MTgsImV4cCI6MTY0NzI2OTI3MCwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkFTUUEyLzhUQUFBQURnQTJOdG8vMEhtakdyTXFLN1N4cnhFUFVraTJ2aGt3UGhQdXkvZVU0N289IiwiYW1yIjpbInB3ZCIsInJzYSJdLCJhcHBfZGlzcGxheW5hbWUiOiJHcmFwaCBFeHBsb3JlciIsImFwcGlkIjoiZGU4YmM4YjUtZDlmOS00OGIxLWE4YWQtYjc0OGRhNzI1MDY0IiwiYXBwaWRhY3IiOiIwIiwiZGV2aWNlaWQiOiJhOTdlZWY0My1kNzkzLTQ0MWUtYTY0ZC1lODU5OWNjMWM4ZjYiLCJmYW1pbHlfbmFtZSI6Ikd1cnVuZyIsImdpdmVuX25hbWUiOiJBbXJpdCIsImlkdHlwIjoidXNlciIsImlwYWRkciI6IjgwLjE5NS43MC4xMDIiLCJuYW1lIjoiQW1yaXQgR3VydW5nIiwib2lkIjoiNjAzYzA0MGQtZmEzOC00MTU4LTg4NjgtYWJhMWQ4NzkyNTNhIiwicGxhdGYiOiIzIiwicHVpZCI6IjEwMDMyMDAxREZCMjBFODIiLCJyaCI6IjAuQVhNQTR3QmNMQVdZQ1VDNGJQal83dmJFdFFNQUFBQUFBQUFBd0FBQUFBQUFBQUJ6QUJRLiIsInNjcCI6IkNoYW5uZWxNZXNzYWdlLlNlbmQgQ2hhdC5SZWFkV3JpdGUgQ2hhdE1lc3NhZ2UuU2VuZCBGaWxlcy5SZWFkIEZpbGVzLlJlYWQuQWxsIEZpbGVzLlJlYWRXcml0ZSBGaWxlcy5SZWFkV3JpdGUuQWxsIE1haWwuUmVhZCBNYWlsLlJlYWRCYXNpYyBNYWlsLlJlYWRXcml0ZSBNYWlsLlNlbmQgTWFpbGJveFNldHRpbmdzLlJlYWQgb3BlbmlkIHByb2ZpbGUgU2l0ZXMuUmVhZC5BbGwgU2l0ZXMuUmVhZFdyaXRlLkFsbCBVc2VyLlJlYWQgVXNlci5SZWFkV3JpdGUgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJ1M0xFZnJKNVZ6aEpYbUlKUWgxM2M3SDhvZEdlaHFIak5RaV9DUW5TdEJvIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiMmM1YzAwZTMtOTgwNS00MDA5LWI4NmMtZjhmZmVlZjZjNGI1IiwidW5pcXVlX25hbWUiOiJhbXJpdC5ndXJ1bmdAcm91bmRjb3JwLmNvbSIsInVwbiI6ImFtcml0Lmd1cnVuZ0Byb3VuZGNvcnAuY29tIiwidXRpIjoiQzNmZ1pub2o2VXVoYW8xZS1rMmdBQSIsInZlciI6IjEuMCIsIndpZHMiOlsiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19zdCI6eyJzdWIiOiI4UHEtZTU5S1Y0dGFIZkJBQllkXzBxSUp1Vzk2ZE1pUEFHdXZxclJnV0o0In0sInhtc190Y2R0IjoxNTk4MjIwMjA0fQ.Q1pB2RXxhANDXd0l7sW2hNIgljHSM7oQRTYqRVwJolaRftGGF6-eZ7ptvP9CS2JIWmKlxCr5rZ_W8nuek1uht_5iHMtp5r6tCWT-2EqmkC0QrsgCqIuUNob7QY_E1qPae6v64PV5k5hiJYj5_pU2Far7m1xtnDtC63lMgBRZ5TZkTBswSS-mooRhDZ5geWEsl4NX4y4bV_90U9viglsG81_dPPLqvnhG8bPFQyIYcL2koY85qe-mOs1OHQFsA-WVxC3FYVsenbPMSdI_mGhQEUjj4zMJx13feO4_9992pt5ZPabNBPNU-LxHAJBcTi3YNGb2hYPppca9qGk_bbopuw';
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $ptr = $graph->createCollectionRequest("GET", "/me/messages")
            ->setReturnType(Model\Message::class)
            ->setPageSize(20);


        $events = $ptr->getPage();

        return view('replymail', compact('events'));

    }



    public function pleasereply(Request $request)
    {
        $randomNumber = rand(500, 15000000);
        $body = 'We have received your email.You support ticket number is ' . $randomNumber . '. We will get in touch with you soon. ' ;
        $subject = $request->eventsubject. '['.$randomNumber.']';

        //dd($subject);

        $tokenCache = new TokenCache();

        $accessToken = $tokenCache->getAccessToken();

        //dd($accessToken);
        $accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6ImV5UDNzMnZWaXV3dHVDODA1ZFNHWHdMSWx0dC1NSkV3Qmw2YXFpanMtcGsiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8yYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUvIiwiaWF0IjoxNjQ4NjMzOTgwLCJuYmYiOjE2NDg2MzM5ODAsImV4cCI6MTY0ODYzODI2NSwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZQWpZSVZiZVpuczBhZksxbFB2SlA1ZDNtZFpYMTVvdWpsdjhMUFlrQjlOcW8xMEEiLCJhbXIiOlsicHdkIiwicnNhIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJkZXZpY2VpZCI6ImE5N2VlZjQzLWQ3OTMtNDQxZS1hNjRkLWU4NTk5Y2MxYzhmNiIsImZhbWlseV9uYW1lIjoiR3VydW5nIiwiZ2l2ZW5fbmFtZSI6IkFtcml0IiwiaWR0eXAiOiJ1c2VyIiwiaXBhZGRyIjoiODAuMTk1LjcwLjEwMiIsIm5hbWUiOiJBbXJpdCBHdXJ1bmciLCJvaWQiOiI2MDNjMDQwZC1mYTM4LTQxNTgtODg2OC1hYmExZDg3OTI1M2EiLCJwbGF0ZiI6IjMiLCJwdWlkIjoiMTAwMzIwMDFERkIyMEU4MiIsInJoIjoiMC5BWE1BNHdCY0xBV1lDVUM0YlBqXzd2YkV0UU1BQUFBQUFBQUF3QUFBQUFBQUFBQnpBQlEuIiwic2NwIjoiQ2FsZW5kYXJzLlJlYWQgQ2FsZW5kYXJzLlJlYWQuU2hhcmVkIENhbGVuZGFycy5SZWFkV3JpdGUgQ2hhbm5lbE1lc3NhZ2UuU2VuZCBDaGF0LlJlYWRXcml0ZSBDaGF0TWVzc2FnZS5TZW5kIEZpbGVzLlJlYWQgRmlsZXMuUmVhZC5BbGwgRmlsZXMuUmVhZFdyaXRlIEZpbGVzLlJlYWRXcml0ZS5BbGwgTWFpbC5SZWFkIE1haWwuUmVhZEJhc2ljIE1haWwuUmVhZFdyaXRlIE1haWwuU2VuZCBNYWlsYm94U2V0dGluZ3MuUmVhZCBvcGVuaWQgcHJvZmlsZSBTaXRlcy5SZWFkLkFsbCBTaXRlcy5SZWFkV3JpdGUuQWxsIFVzZXIuUmVhZCBVc2VyLlJlYWRCYXNpYy5BbGwgVXNlci5SZWFkV3JpdGUgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJ1M0xFZnJKNVZ6aEpYbUlKUWgxM2M3SDhvZEdlaHFIak5RaV9DUW5TdEJvIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiMmM1YzAwZTMtOTgwNS00MDA5LWI4NmMtZjhmZmVlZjZjNGI1IiwidW5pcXVlX25hbWUiOiJhbXJpdC5ndXJ1bmdAcm91bmRjb3JwLmNvbSIsInVwbiI6ImFtcml0Lmd1cnVuZ0Byb3VuZGNvcnAuY29tIiwidXRpIjoiV3FVbFlXaWt6RUNxcmZCWlNiWjZBQSIsInZlciI6IjEuMCIsIndpZHMiOlsiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19zdCI6eyJzdWIiOiI4UHEtZTU5S1Y0dGFIZkJBQllkXzBxSUp1Vzk2ZE1pUEFHdXZxclJnV0o0In0sInhtc190Y2R0IjoxNTk4MjIwMjA0fQ.dHT9dgYpZ8t08qQj-piPHgMffaVu3pikip7xrbdSc315iyd-4nnBpHFG4UEKagYQoCmVe4AB_1s356TJzIzzikLrWTrrXDNDsEIRHJ2FHTWo1eO0G_QInL9Qq5rF8pjq6K6Tq5tVyRj872c3tcvWjBWVmcCak5NAVLVag54wItoxInOudq-XGPCBrhaY--ZROEVw81w0RnrHwHYbl1PZrmZlMSr9Tue_YyOvGPle1VU-YrhgWhH3zDH0BiOOfXZd0SM62BnxdBC2S5bV7q6NeBNh2Dcf98ZMoeZzxpclhz7O0U3g7-GlANmM3HRJzozSG3c1SVWnw_-3RGpCCdTHXA';
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        //dd($request);
        $viewData = $this->loadViewData();




        $mailBody = array(
            "Message" => array(
                "subject" => $subject,
                "body" => array(
                    "contentType" => "html",
                    "content" => $body,
                ),

                "toRecipients" => array(
                    array(
                        "emailAddress" => array(
                            "name" => $request->eventuser,
                            "address" => $request->eventemail,

                        )
                    )
                ),
            )
        );


        dd($mailBody);

        // POST /me/events
        $response = $graph->createRequest('POST', '/me/sendMail')
            ->attachBody($mailBody)
            ->execute();


        dd($response);
        return redirect('/messageA');
    }





    public function download(Request $request){
//        dd($request);
        $d = $request->eventd;
        $b = $request->eventb;
        $t = $request->eventt;
        $image = $request->file('eventd');
        $contents = base64_decode($b);
//        dd($contents);
        header("Content-type: ".$t);
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=" . $d);
//        dd($d);
        print $contents;
        die;
    }



    public function attach(Request $request)
    {
        {
            $accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6InRkX3hoM3RwbzN3Sy1tRzlibzhnWkpyc0FjMUZHV0hpbzNSS1hXR0g1OWMiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8yYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUvIiwiaWF0IjoxNjUyMTAyNjAxLCJuYmYiOjE2NTIxMDI2MDEsImV4cCI6MTY1MjEwNzU4NSwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZRGkzOVByaWJpMXY5ZnpxZzFPU2JRNno2cXR4Smo5OHVQdnQ4emhQdGkrVFJSTUEiLCJhbXIiOlsicHdkIiwicnNhIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJkZXZpY2VpZCI6ImE5N2VlZjQzLWQ3OTMtNDQxZS1hNjRkLWU4NTk5Y2MxYzhmNiIsImZhbWlseV9uYW1lIjoiR3VydW5nIiwiZ2l2ZW5fbmFtZSI6IkFtcml0IiwiaWR0eXAiOiJ1c2VyIiwiaXBhZGRyIjoiODAuMTk1LjcwLjEwMiIsIm5hbWUiOiJBbXJpdCBHdXJ1bmciLCJvaWQiOiI2MDNjMDQwZC1mYTM4LTQxNTgtODg2OC1hYmExZDg3OTI1M2EiLCJwbGF0ZiI6IjMiLCJwdWlkIjoiMTAwMzIwMDFERkIyMEU4MiIsInJoIjoiMC5BWE1BNHdCY0xBV1lDVUM0YlBqXzd2YkV0UU1BQUFBQUFBQUF3QUFBQUFBQUFBQnpBQlEuIiwic2NwIjoiQ2FsZW5kYXJzLlJlYWQgQ2FsZW5kYXJzLlJlYWQuU2hhcmVkIENhbGVuZGFycy5SZWFkV3JpdGUgQ2hhbm5lbE1lc3NhZ2UuU2VuZCBDaGF0LlJlYWRXcml0ZSBDaGF0TWVzc2FnZS5TZW5kIEZpbGVzLlJlYWQgRmlsZXMuUmVhZC5BbGwgRmlsZXMuUmVhZFdyaXRlIEZpbGVzLlJlYWRXcml0ZS5BbGwgTWFpbC5SZWFkIE1haWwuUmVhZEJhc2ljIE1haWwuUmVhZFdyaXRlIE1haWwuU2VuZCBNYWlsYm94U2V0dGluZ3MuUmVhZCBvcGVuaWQgcHJvZmlsZSBTaXRlcy5SZWFkLkFsbCBTaXRlcy5SZWFkV3JpdGUuQWxsIFVzZXIuUmVhZCBVc2VyLlJlYWRCYXNpYy5BbGwgVXNlci5SZWFkV3JpdGUgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJ1M0xFZnJKNVZ6aEpYbUlKUWgxM2M3SDhvZEdlaHFIak5RaV9DUW5TdEJvIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiMmM1YzAwZTMtOTgwNS00MDA5LWI4NmMtZjhmZmVlZjZjNGI1IiwidW5pcXVlX25hbWUiOiJhbXJpdC5ndXJ1bmdAcm91bmRjb3JwLmNvbSIsInVwbiI6ImFtcml0Lmd1cnVuZ0Byb3VuZGNvcnAuY29tIiwidXRpIjoiczBEaVljY2h6MFdqVEVKY3FxUmhBQSIsInZlciI6IjEuMCIsIndpZHMiOlsiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19zdCI6eyJzdWIiOiI4UHEtZTU5S1Y0dGFIZkJBQllkXzBxSUp1Vzk2ZE1pUEFHdXZxclJnV0o0In0sInhtc190Y2R0IjoxNTk4MjIwMjA0fQ.ZPO8xGPA7qfy73dBefBx2kbTF1O3xVGeFM1Li3bzYTkGQITYiD6hDUZwNElgvK_gOF1igkuu_dTFlkGsQbWkWR-mkYDliggR-EZ18Ce5_ktpxoMia0qrpXKHcsBZnThwJc_F5t41vuH2Qs2s0-vwl6QGOFeSH9LoUcXqzkL90bZ150J6Z_8DG3zOoulEVb32ZpcLzHW085T6NHg3E3aN-75F6U34RdyDDBbRw0_HthYGFgSQlLZCfolI8Qk294JTuOY7Oni_DETFNzbN8nQI7Z4t7PqDhs9fZx6jMHxYlJ3oGJm0zzns-bjzgA0_bFuLOf4WaDnRFpbyrgdR4sJn6A';
            $graph = new Graph();
            $graph->setAccessToken($accessToken);
            if($request->File() == null)
            {
                $randomNumber = rand(500, 15000000);
                $body = 'We have received your email.You support ticket number is ' . $randomNumber . '. We will get in touch with you soon. ' ;
                $subject = $request->eventsubject. '['.$randomNumber.']';
                $a = $request->eventuser;
                $mailBody = array(
                    "Message" => array(
                        "subject" => $subject,
                        "body" => array(
                            "contentType" => "html",
                            "content" => $body,
                        ),
                        "toRecipients" => array(
                            array(
                                "emailAddress" => array(
                                    "name" => $request->eventuser,
                                    "address" => $request->eventemail,
                                )
                            )
                        ),
                    )
                );

                $response = $graph->createRequest('POST', '/me/sendMail')
                    ->attachBody($mailBody)
                    ->execute();
                dd($response);


            }else {
                $image = $request->file('images');
                $name = time().'.'.$image->getClientOriginalExtension();
//            dd($name);
                $destinationPath = public_path('/Amritattach/');
//            dd($destinationPath);
                $a = $image->move($destinationPath, $name);
                $type = pathinfo($a, PATHINFO_EXTENSION);
//            dd($type);
                $data = file_get_contents($a);
//            dd($data);
                $base64 = base64_encode($data);
            }
            $randomNumber = rand(500, 15000000);
            $body = 'We have received your email.You support ticket number is ' . $randomNumber . '. We will get in touch with you soon. ' ;
            $subject = $request->eventsubject. '['.$randomNumber.']';
            {
                $mailBody = array(
                    "message"=> array (
                        "subject" => $subject,
                        "body" => array(
                            "contentType" => "html",
                            "content" => $body,
                        ),
                        "toRecipients" => array(
                            array(
                                "emailAddress" => array(
                                    "name" => $request->eventuser,
                                    "address" => $request->eventemail,
                                )
                            )
                        ),
                        "attachments@odata.context"=> "https://graph.microsoft.com/v1.0/metadata#users('603c040d-fa38-4158-8868-aba1d879253a')/messages('AAMkADE5NTE1YzM1LTFlZDctNGJhZC04ODMzLWM4NzU5MjQ4MTgxMABGAAAAAAA5UGWn0Oz3Q6Ym3fcZCXuQBwCXEnEp3csTQ7Rv6UwcopTjAAAAAAEMAACXEnEp3csTQ7Rv6UwcopTjAAAWb5uJAAA%3D')/attachments",
                        "attachments"=> array(array
                        (
                            "@odata.type"=> "#microsoft.graph.fileAttachment",
                            "name"=> $name,
                            "contentType"=> "application/json",
//                            "size"=> 3483322,
//                            "Content-Length" => 26,
//                            "Content-Range" => "bytes 0-25/128",
                            "contentBytes"=> $base64
                        ),
                            array
                            (
                                "@odata.type"=> "#microsoft.graph.fileAttachment",
                                "name"=> $name,
                                "contentType"=> "application/json",
//                                "size"=> 3483322,
//                                "Content-Length" => 26,
//                                "Content-Range" => "bytes 0-25/128",
                                "contentBytes"=> $base64
                            )
                        )
                    )
                );
            }
//        dd($mailBody);
            // POST /me/message
            $response = $graph->createRequest('POST', '/me/sendMail')
                ->attachBody($mailBody)
                ->execute();
            dd($response);

        }
//
    }
}

