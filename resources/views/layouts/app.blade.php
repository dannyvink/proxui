<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <title>@yield('title', 'ProxUI') - ProxUI</title>
  </head>
  <body>
    <div id="app">
      <header id="site-header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <div class="container">
            <a class="navbar-brand" href="/">ProxUI</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="main-nav">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="/">Scan Fob</a></li>
                <li class="nav-item"><a class="nav-link" href="/history">History</a></li>
                <li class="nav-item"><a class="nav-link" href="/terminal">Terminal</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <main id="site-content" class="mt-4">
        <div class="container">
          @yield('content')
        </div>
      </main>
      <div class="modal fade" id="cloneModal" tabindex="-1" role="dialog" aria-labelledby="cloneModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Clone @{{ cloneTarget.type }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              To clone this tag, place an empty <code>@{{ cloneTarget.type }}</code> compatible tag on the scanner.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="clone()">Clone</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="{{ mix('/js/app.js') }}"></script>
  </body>
</html>