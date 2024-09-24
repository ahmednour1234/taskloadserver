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
                        <h2 class="text-dark">customers</h2>
                        <p class="text-gray mb-0">manage_view_customers</p>
                    </div>
                    <div class="right-part d-flex align-items-center">
                        <div class="filtering d-flex align-items-center ms-3">
                            <a href="#" class="btn list-view p-0 fs-30"><i class="bi bi-list"></i></a>
                            <a href="#" class="btn grid-view p-0 fs-30 active"><i class="bi bi-grid"></i></a>
                        </div>
                        <button type="button" class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#createCustomerModal">
                            add_customer
                        </button>
                    </div>
                </div>
                <div class="table-responsive mt-4 bg-white">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th scope="col" class="text-white"></th>
                                <th scope="col" class="text-white">name</th>
                                <th scope="col" class="text-white">email</th>
                                <th scope="col" class="text-white">phone</th>
                                <th scope="col" class="text-white">actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <td><input type="checkbox" class="form-check-input" name="selectedCustomers[]" value="{{ $customer->id }}"></td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editCustomerModal{{ $customer->id }}">edit</a></li>
                                            <li>
                                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('confirm_delete')">delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Customer Modal -->
                            <div class="modal fade" id="editCustomerModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editCustomerModalLabel{{ $customer->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editCustomerModalLabel{{ $customer->id }}">@lang('messages.edit_customer')</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('customers.update', $customer->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label for="name" class="form-label">customer_name</label>
                                                    <input type="text" class="form-control" id="edit_name" name="name" value="{{ $customer->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_email" class="form-label">email</label>
                                                    <input type="email" class="form-control" id="edit_email" name="email" value="{{ $customer->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_phone" class="form-label">phone</label>
                                                    <input type="text" class="form-control" id="edit_phone" name="phone" value="{{ $customer->phone }}" required>
                                                </div>

                                                <button type="submit" class="btn btn-primary">save_changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="my-5 d-flex justify-content-center align-items-center">
                    <p class="mb-0 me-3">Showing <span class="fw-bold">{{ $customers->firstItem() }}-{{ $customers->lastItem() }}</span> of <span class="fw-bold">{{ $customers->total() }}</span> entries</p>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            @if ($customers->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $customers->previousPageUrl() }}">&laquo;</a></li>
                            @endif
                            @foreach ($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                                @if ($page == $customers->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                            @if ($customers->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $customers->nextPageUrl() }}">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </main>

    <!-- Create Customer Modal -->
    <div class="modal fade" id="createCustomerModal" tabindex="-1" aria-labelledby="createCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCustomerModalLabel">@lang('messages.add_customer')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">customer_name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>

                        <button type="submit" class="btn btn-primary">add_customer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
