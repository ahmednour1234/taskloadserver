@extends('welcome')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* Custom CSS for the table */
    .table-custom {
        width: 100%;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .table-custom th,
    .table-custom td {
        padding: 12px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    .table-custom th {
        background-color: #007bff;
        color: white;
    }

    .table-custom tbody tr:nth-of-type(even) {
        background-color: #f8f9fa;
    }

    .table-custom tbody tr:hover {
        background-color: #e9ecef;
    }

    .service-name {
        font-weight: bold;
        color: #343a40;
    }

    .service-name-ar {
        color: #6c757d;
    }

    /* Styling for modal */
    .modal-content {
        border-radius: 8px;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
        border-radius: 8px 8px 0 0;
    }

    .modal-title {
        font-weight: bold;
    }
</style>

<body class="bg-light d-flex flex-column min-vh-100">
    <!-- Main content -->
    <main class="main-wrapper">
        <div class="container-fluid">
            <div class="inner-contents">
                <!-- Page Header -->
                <div class="page-header d-flex align-items-center justify-content-between">
                    <div class="left-part">
                        <h2 class="text-dark">logs</h2>
                        <p class="text-gray mb-0">manage_view_logs</p>
                    </div>
                    <div class="right-part d-flex align-items-center">
                        <div class="filtering d-flex align-items-center ms-3">
                            <a href="#" class="btn list-view p-0 fs-30"><i class="bi bi-list"></i></a>
                            <a href="#" class="btn grid-view p-0 fs-30 active"><i class="bi bi-grid"></i></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-4 bg-white">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th scope="col" class="text-white"></th>
                                <th scope="col" class="text-white">user name</th>
                                <th scope="col" class="text-white">role user</th>
                                <th scope="col" class="text-white">invoice id</th>
                                <th scope="col" class="text-white">customer name</th>
                                <th scope="col" class="text-white">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr>
                                <td><input type="checkbox" class="form-check-input"  value="{{ $log->id }}"></td>
                                <td>{{ $log->user->name }}</td>
                                <td>{{ $log->role }}</td>
                                <td>{{ $log->invoice->id ?? '' }}</td>
                                <td>{{ $log->invoice->customer->name ?? '' }}</td>
                                <td>{{ $log->action }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="my-5 d-flex justify-content-center align-items-center">
                    <p class="mb-0 me-3">Showing <span class="fw-bold">{{ $logs->firstItem() }}-{{ $logs->lastItem() }}</span> of <span class="fw-bold">{{ $logs->total() }}</span> entries</p>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            @if ($logs->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $logs->previousPageUrl() }}">&laquo;</a></li>
                            @endif
                            @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                                @if ($page == $logs->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                            @if ($logs->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $logs->nextPageUrl() }}">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </main>
</body>
    @endsection
