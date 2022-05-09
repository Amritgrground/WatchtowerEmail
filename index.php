<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>JavaScript SPA Graph Tutorial</title>

    <link rel="shortcut icon" href="g-raph.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container">
        <a href="/" class="navbar-brand">Javascript SPA Graph Tutorial</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul id="authenticated-nav" class="navbar-nav me-auto"></ul>
            <ul class="navbar-nav align-items-center justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" href="https://docs.microsoft.com/graph/overview" target="_blank">
                        ↗ Docs
                    </a>
                </li>
                <li id="account-nav" class="nav-item"></li>
            </ul>
        </div>
    </div>
</nav>

<main id="main-container" role="main" class="container">

</main>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<!-- Moment.js -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://momentjs.com/downloads/moment-timezone-with-data-10-year-range.js"></script>

<!-- MSAL -->
<script src="https://alcdn.msauth.net/browser/2.16.1/js/msal-browser.min.js"
        integrity="sha384-bPBovDNeUf0pJstTMwF5tqVhjDS5DZPtI1qFzQI9ooDIAnK8ZCYox9HowDsKvz4i"
        crossorigin="anonymous"></script>

<!-- Graph SDK -->
<script src="https://cdn.jsdelivr.net/npm/@microsoft/microsoft-graph-client@3.0.0/lib/graph-js-sdk.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@microsoft/microsoft-graph-client@3.0.0/lib/graph-client-msalBrowserAuthProvider.js"></script>

<script src="config.js"></script>
<script src="timezones.js"></script>
<script src="ui.js"></script>
<script src="graph.js"></script>
<script src="auth.js"></script>
</body>
</html>