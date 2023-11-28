<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

    <!-- CSS files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">

    @vite(['resources/css/app.css'])
</head>

<body>
    <div class="page">
        <div class="page-wrapper">
            <!-- Page header -->
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">Chat</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-12 col-lg-5 col-xl-3 border-end">
                                <div class="card-body p-0 scrollable" style="max-height: 35rem">
                                    <div class="nav flex-column nav-pills" role="tablist">
                                        @forelse ($friends as $friend)
                                        <a href="#" class="nav-link text-start mw-100 p-3 friends" data-bs-toggle="pill" role="tab" aria-selected="true" data-friend-id="{{ $friend->id }}" data-friend-name="{{ $friend->name }}">
                                            <div class="row align-items-center flex-fill">
                                                <div class="col-auto"><span class="avatar" style="background-image: url(./user.png)"></span>
                                                </div>
                                                <div class="col text-body">
                                                    <div>{{ $friend->name }}</div>
                                                </div>
                                            </div>
                                        </a>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-9 d-flex flex-column d-none" id="chatbox">
                                <div class="card-header">
                                    <div class="fw-bold friend_name"></div>
                                </div>
                                <div class="card-body scrollable" style="height: 35rem">
                                    <div class="chat">
                                        <div class="chat-bubbles" id="chat-bubbles">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="text" class="form-control" autocomplete="off" placeholder="Type message" id="type-area" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Libs JS -->

    <!-- Tabler Core -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>

    @vite(['resources/js/app.js'])
</body>

</html>