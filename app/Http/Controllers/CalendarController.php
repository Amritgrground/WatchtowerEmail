<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\TimeZones\TimeZones;

class CalendarController extends Controller
{
     public function amritmail()
    {
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();
       //dd($accessToken);
        $accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6Il9KaERoazJ3WV9TWmZicC1FZC1IYXB1N2Z0blZxQ0UwNlFWbXU5THl0M00iLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8yYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUvIiwiaWF0IjoxNjUyMDkwMzkwLCJuYmYiOjE2NTIwOTAzOTAsImV4cCI6MTY1MjA5NDQ2MywiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZRWpWNllrcWFKbWNWcXdUUDJHVjRjdThNbk51Y2VGL0JmRU55NnplTVhtZmVnSUEiLCJhbXIiOlsicHdkIiwicnNhIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJkZXZpY2VpZCI6ImE5N2VlZjQzLWQ3OTMtNDQxZS1hNjRkLWU4NTk5Y2MxYzhmNiIsImZhbWlseV9uYW1lIjoiR3VydW5nIiwiZ2l2ZW5fbmFtZSI6IkFtcml0IiwiaWR0eXAiOiJ1c2VyIiwiaXBhZGRyIjoiODAuMTk1LjcwLjEwMiIsIm5hbWUiOiJBbXJpdCBHdXJ1bmciLCJvaWQiOiI2MDNjMDQwZC1mYTM4LTQxNTgtODg2OC1hYmExZDg3OTI1M2EiLCJwbGF0ZiI6IjMiLCJwdWlkIjoiMTAwMzIwMDFERkIyMEU4MiIsInJoIjoiMC5BWE1BNHdCY0xBV1lDVUM0YlBqXzd2YkV0UU1BQUFBQUFBQUF3QUFBQUFBQUFBQnpBQlEuIiwic2NwIjoiQ2FsZW5kYXJzLlJlYWQgQ2FsZW5kYXJzLlJlYWQuU2hhcmVkIENhbGVuZGFycy5SZWFkV3JpdGUgQ2hhbm5lbE1lc3NhZ2UuU2VuZCBDaGF0LlJlYWRXcml0ZSBDaGF0TWVzc2FnZS5TZW5kIEZpbGVzLlJlYWQgRmlsZXMuUmVhZC5BbGwgRmlsZXMuUmVhZFdyaXRlIEZpbGVzLlJlYWRXcml0ZS5BbGwgTWFpbC5SZWFkIE1haWwuUmVhZEJhc2ljIE1haWwuUmVhZFdyaXRlIE1haWwuU2VuZCBNYWlsYm94U2V0dGluZ3MuUmVhZCBvcGVuaWQgcHJvZmlsZSBTaXRlcy5SZWFkLkFsbCBTaXRlcy5SZWFkV3JpdGUuQWxsIFVzZXIuUmVhZCBVc2VyLlJlYWRCYXNpYy5BbGwgVXNlci5SZWFkV3JpdGUgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJ1M0xFZnJKNVZ6aEpYbUlKUWgxM2M3SDhvZEdlaHFIak5RaV9DUW5TdEJvIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiMmM1YzAwZTMtOTgwNS00MDA5LWI4NmMtZjhmZmVlZjZjNGI1IiwidW5pcXVlX25hbWUiOiJhbXJpdC5ndXJ1bmdAcm91bmRjb3JwLmNvbSIsInVwbiI6ImFtcml0Lmd1cnVuZ0Byb3VuZGNvcnAuY29tIiwidXRpIjoiX3NSbnNCSXBNVU95M2dSeV8tNEdBQSIsInZlciI6IjEuMCIsIndpZHMiOlsiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19zdCI6eyJzdWIiOiI4UHEtZTU5S1Y0dGFIZkJBQllkXzBxSUp1Vzk2ZE1pUEFHdXZxclJnV0o0In0sInhtc190Y2R0IjoxNTk4MjIwMjA0fQ.h0nN6CcCLeI4dJ06wAoOkYjWgky8Fe7-dZUa4j8QT0Tl8kn5HMi8ctPYL1tumxfpig9JanfdDdAetyrglSDv51ECUT9UYgZFlC_BS8mJFyqoMQHCb_ZmmncFLHRTvFZE6XBG_QYTTnTTkHj78bU46COUaROqeLUl6-LpPpJwa2L1CoJMHNOW2X0HTHPrM2stK1sT3E5U9IbiUoMjI7sIbMxNp8vXZoh7cQ8eAP2YwkCIOF5Y1sA-jg-9MrmDj5LsL82BR3LdJcAbOObGwtLe2QRvjhaQ2QxWppp38CTJ9aaoxMOuX6D63KjyAa-2yP7n1qaii0kWfEjYZPdi48_0kw';
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        $ptr = $graph->createCollectionRequest("GET", "/me/messages?expand=attachments")
//            dd($ptr)
            ->setReturnType(Model\Message::class)
            ->setPageSize(5);
        $eventss = $ptr->getPage();
//        dd($eventss);
        return view('email', compact('eventss'));
    }

    function amritmails($mailbox)
    {
        if (!$this->Token) {
            throw new Exception('No token defined');
        }
        $messageList = json_decode($this->sendGetRequest($this->baseURL . 'users/' . $mailbox . '/mailFolders/Inbox/Messages'));
        if ($messageList->error) {
            throw new Exception($messageList->error->code . ' ' . $messageList->error->message);
        }
        $messageArray = array();

        foreach ($messageList->value as $mailItem) {
            $attachments = (json_decode($this->sendGetRequest($this->baseURL . 'users/' . $mailbox . '/messages/' . $mailItem->id . '/attachments')))->value;
            if (count($attachments) < 1) unset($attachments);
            foreach ($attachments as $attachment) {
                if ($attachment->{'@odata.type'} == '#microsoft.graph.referenceAttachment') {
                    $attachment->contentBytes = base64_encode('This is a link to a SharePoint online file, not yet supported');
                    $attachment->isInline = 0;
                }
            }
            $messageArray[] = array('id' => $mailItem->id,
                'sentDateTime' => $mailItem->sentDateTime,
                'subject' => $mailItem->subject,
                'bodyPreview' => $mailItem->bodyPreview,
                'importance' => $mailItem->importance,
                'conversationId' => $mailItem->conversationId,
                'isRead' => $mailItem->isRead,
                'body' => $mailItem->body,
                'sender' => $mailItem->sender,
                'toRecipients' => $mailItem->toRecipients,
                'ccRecipients' => $mailItem->ccRecipients,
                'toRecipientsBasic' => $this->basicAddress($mailItem->toRecipients),
                'ccRecipientsBasic' => $this->basicAddress($mailItem->ccRecipients),
                'replyTo' => $mailItem->replyTo,
                'attachments' => $attachments);

        }
        return $messageArray;
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

    public function getNewEventForm()
    {
        $viewData = $this->loadViewData();

        return view('newevent', $viewData);
    }

    public function reply()
    {
        $viewData = $this->loadViewData();

        return view('show', $viewData);
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


    public function pleasereply(Request $request)
    {

//        $body = 'We have received your email.You support ticket number is ' . $randomNumber . '. We will get in touch with you soon. ' ;
//        $subject = $request->eventsubject. '['.$randomNumber.']';

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
//              dd('not same ');
            $accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6Il9KaERoazJ3WV9TWmZicC1FZC1IYXB1N2Z0blZxQ0UwNlFWbXU5THl0M00iLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8yYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUvIiwiaWF0IjoxNjUyMDkwMzkwLCJuYmYiOjE2NTIwOTAzOTAsImV4cCI6MTY1MjA5NDQ2MywiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZRWpWNllrcWFKbWNWcXdUUDJHVjRjdThNbk51Y2VGL0JmRU55NnplTVhtZmVnSUEiLCJhbXIiOlsicHdkIiwicnNhIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJkZXZpY2VpZCI6ImE5N2VlZjQzLWQ3OTMtNDQxZS1hNjRkLWU4NTk5Y2MxYzhmNiIsImZhbWlseV9uYW1lIjoiR3VydW5nIiwiZ2l2ZW5fbmFtZSI6IkFtcml0IiwiaWR0eXAiOiJ1c2VyIiwiaXBhZGRyIjoiODAuMTk1LjcwLjEwMiIsIm5hbWUiOiJBbXJpdCBHdXJ1bmciLCJvaWQiOiI2MDNjMDQwZC1mYTM4LTQxNTgtODg2OC1hYmExZDg3OTI1M2EiLCJwbGF0ZiI6IjMiLCJwdWlkIjoiMTAwMzIwMDFERkIyMEU4MiIsInJoIjoiMC5BWE1BNHdCY0xBV1lDVUM0YlBqXzd2YkV0UU1BQUFBQUFBQUF3QUFBQUFBQUFBQnpBQlEuIiwic2NwIjoiQ2FsZW5kYXJzLlJlYWQgQ2FsZW5kYXJzLlJlYWQuU2hhcmVkIENhbGVuZGFycy5SZWFkV3JpdGUgQ2hhbm5lbE1lc3NhZ2UuU2VuZCBDaGF0LlJlYWRXcml0ZSBDaGF0TWVzc2FnZS5TZW5kIEZpbGVzLlJlYWQgRmlsZXMuUmVhZC5BbGwgRmlsZXMuUmVhZFdyaXRlIEZpbGVzLlJlYWRXcml0ZS5BbGwgTWFpbC5SZWFkIE1haWwuUmVhZEJhc2ljIE1haWwuUmVhZFdyaXRlIE1haWwuU2VuZCBNYWlsYm94U2V0dGluZ3MuUmVhZCBvcGVuaWQgcHJvZmlsZSBTaXRlcy5SZWFkLkFsbCBTaXRlcy5SZWFkV3JpdGUuQWxsIFVzZXIuUmVhZCBVc2VyLlJlYWRCYXNpYy5BbGwgVXNlci5SZWFkV3JpdGUgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJ1M0xFZnJKNVZ6aEpYbUlKUWgxM2M3SDhvZEdlaHFIak5RaV9DUW5TdEJvIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiMmM1YzAwZTMtOTgwNS00MDA5LWI4NmMtZjhmZmVlZjZjNGI1IiwidW5pcXVlX25hbWUiOiJhbXJpdC5ndXJ1bmdAcm91bmRjb3JwLmNvbSIsInVwbiI6ImFtcml0Lmd1cnVuZ0Byb3VuZGNvcnAuY29tIiwidXRpIjoiX3NSbnNCSXBNVU95M2dSeV8tNEdBQSIsInZlciI6IjEuMCIsIndpZHMiOlsiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19zdCI6eyJzdWIiOiI4UHEtZTU5S1Y0dGFIZkJBQllkXzBxSUp1Vzk2ZE1pUEFHdXZxclJnV0o0In0sInhtc190Y2R0IjoxNTk4MjIwMjA0fQ.h0nN6CcCLeI4dJ06wAoOkYjWgky8Fe7-dZUa4j8QT0Tl8kn5HMi8ctPYL1tumxfpig9JanfdDdAetyrglSDv51ECUT9UYgZFlC_BS8mJFyqoMQHCb_ZmmncFLHRTvFZE6XBG_QYTTnTTkHj78bU46COUaROqeLUl6-LpPpJwa2L1CoJMHNOW2X0HTHPrM2stK1sT3E5U9IbiUoMjI7sIbMxNp8vXZoh7cQ8eAP2YwkCIOF5Y1sA-jg-9MrmDj5LsL82BR3LdJcAbOObGwtLe2QRvjhaQ2QxWppp38CTJ9aaoxMOuX6D63KjyAa-2yP7n1qaii0kWfEjYZPdi48_0kw';
            $graph = new Graph();
            $graph->setAccessToken($accessToken);
            if($request->File() == null)
            {
                $randomNumber = rand(500, 15000000);
                $body = 'We have received your email.You support ticket number is ' . $randomNumber . '. We will get in touch with you soon. ' ;
                $subject = $request->eventsubject. '['.$randomNumber.']';

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
//        $data = file_get_contents($image);
//        dd($image);
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
//            dd($mailBody);
            }

//        dd($mailBody);

            // POST /me/events
            $response = $graph->createRequest('POST', '/me/sendMail')
                ->attachBody($mailBody)
                ->execute();
            dd($response);

        }
//
    }
    }

