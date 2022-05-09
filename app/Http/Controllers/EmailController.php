<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\TokenStore\TokenEmail;
use App\TimeZones\TimeZones;

class EmailController extends Controller
{

    public function upload(Request $request)
    {

        // Validate required fields
        $request->validate([
            'eventfile' => 'nullable|string',
            'eventuser' => 'nullable|string',
            'eventemail' => 'nullable|string',
            'eventsubject' => 'nullable|string',
            'eventBody' => 'nullable|string'
        ]);

//        $val = Validator:make($request->all, [
//        'imgUpload1' => 'required',
//    ]);
//
//    if($val->fails()) {
//    return redirect()->back()->with(['message' => 'No file received']);
//}
//else {
//    $file = $request->file('imgUpload1')->store('images');
//    return redirect()->back();
//}

        if ($request->file('eventfile') == null) {
            $file = "not store";
        }else{
            $file = $request->file('eventfile')->store('C:\Program Files (x86)\Zend\Apache24\htdocs\msoffice\example-app\storage\app\docs');
        }
        dd($file);

        $randomNumber = rand(500, 15000000);

        $body = 'We have received your email.You support ticket number is ' . $randomNumber . '. We will get in touch with you soon. ';
        $subject = $request->eventsubject. '['.$randomNumber.']';


        $tokenCache = new TokenCache();

        $accessToken = $tokenCache->getAccessToken();

        //dd($accessToken);
        $accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6IldHc2hHQmZEeHFhQnZDYXlDcV9iOWNhU00temd2cVlZLXJrUnp6M2Y4NnciLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8yYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUvIiwiaWF0IjoxNjQ3OTUxODczLCJuYmYiOjE2NDc5NTE4NzMsImV4cCI6MTY0Nzk1Njg0OCwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZSWlxZkdoOXByRkRmL0hsOVMxYTkvOHJyejl2VTFmbzB4WEcydVZjOXVzcWN5RUEiLCJhbXIiOlsicHdkIiwicnNhIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJkZXZpY2VpZCI6ImE5N2VlZjQzLWQ3OTMtNDQxZS1hNjRkLWU4NTk5Y2MxYzhmNiIsImZhbWlseV9uYW1lIjoiR3VydW5nIiwiZ2l2ZW5fbmFtZSI6IkFtcml0IiwiaWR0eXAiOiJ1c2VyIiwiaXBhZGRyIjoiODAuMTk1LjcwLjEwMiIsIm5hbWUiOiJBbXJpdCBHdXJ1bmciLCJvaWQiOiI2MDNjMDQwZC1mYTM4LTQxNTgtODg2OC1hYmExZDg3OTI1M2EiLCJwbGF0ZiI6IjMiLCJwdWlkIjoiMTAwMzIwMDFERkIyMEU4MiIsInJoIjoiMC5BWE1BNHdCY0xBV1lDVUM0YlBqXzd2YkV0UU1BQUFBQUFBQUF3QUFBQUFBQUFBQnpBQlEuIiwic2NwIjoiQ2FsZW5kYXJzLlJlYWQgQ2FsZW5kYXJzLlJlYWQuU2hhcmVkIENhbGVuZGFycy5SZWFkV3JpdGUgQ2hhbm5lbE1lc3NhZ2UuU2VuZCBDaGF0LlJlYWRXcml0ZSBDaGF0TWVzc2FnZS5TZW5kIEZpbGVzLlJlYWQgRmlsZXMuUmVhZC5BbGwgRmlsZXMuUmVhZFdyaXRlIEZpbGVzLlJlYWRXcml0ZS5BbGwgTWFpbC5SZWFkIE1haWwuUmVhZEJhc2ljIE1haWwuUmVhZFdyaXRlIE1haWwuU2VuZCBNYWlsYm94U2V0dGluZ3MuUmVhZCBvcGVuaWQgcHJvZmlsZSBTaXRlcy5SZWFkLkFsbCBTaXRlcy5SZWFkV3JpdGUuQWxsIFVzZXIuUmVhZCBVc2VyLlJlYWRCYXNpYy5BbGwgVXNlci5SZWFkV3JpdGUgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJ1M0xFZnJKNVZ6aEpYbUlKUWgxM2M3SDhvZEdlaHFIak5RaV9DUW5TdEJvIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiMmM1YzAwZTMtOTgwNS00MDA5LWI4NmMtZjhmZmVlZjZjNGI1IiwidW5pcXVlX25hbWUiOiJhbXJpdC5ndXJ1bmdAcm91bmRjb3JwLmNvbSIsInVwbiI6ImFtcml0Lmd1cnVuZ0Byb3VuZGNvcnAuY29tIiwidXRpIjoiSmlWbzBCSW5kRUtWMHF4MWZ5NkhBQSIsInZlciI6IjEuMCIsIndpZHMiOlsiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19zdCI6eyJzdWIiOiI4UHEtZTU5S1Y0dGFIZkJBQllkXzBxSUp1Vzk2ZE1pUEFHdXZxclJnV0o0In0sInhtc190Y2R0IjoxNTk4MjIwMjA0fQ.GWV20h7GxaFMZ6kjW6ONJx6BVX1vB0YL8VW7aF38Jq_uzWPv1bbDw9UVpeItGw4lO-xFgtzc8QLz_GhNj8wujr3Iv6OzETGomPIKimSOomukVyoRDjhVo9S90kp1iitk7W6b_NYkGnTQ3KZ2Egk6vVo0gUAhVOKJByAV67jns_m0qpgTnnb_OE0ZGOldUOK2Bgzgc7RCv4NOj31cZ9oym7azpLet0M0rfH_TDDy2VORIz-lZzPdeYq0cV31gvNoOHyqKmyCOOMWrACCPWDxHwSZMfCKEccpdp4TMBsG00-EEgUhQsVM3glGk7s4xXK2CTpIUy988mT8rJR8k1i825g';
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        //dd($request);
       // $viewData = $this->loadViewData();

        $mailBody = array(
                "Message" => array(
                    "subject" => $subject,
                    "body" => array(
                        "contentType" => "html",
                        "content" => $body,
                    ),
                "attachments" => array(
                    array('upload' => $request->eventfile,)
                ),
                /*"sender" => array(
                    "emailAddress" => array(
                        "name" => $request->eventuser,
                        "address" => 'amrit.gurung@roundcorp.com',
                    )
                ),
                "from" => array(
                    "emailAddress" => array(
                        "name" => $request->eventuser,
                        "address" => 'amrit.gurung@roundcorp.com',
                    )
                ),*/
                "toRecipients" => array(
                    array(
                        "emailAddress" => array(
                            "name" => $request->eventuser,
                            "address" => $request->eventemail,

                        )
                    )
                )

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


}


