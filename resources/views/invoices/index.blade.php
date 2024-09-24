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
                <div class="page-header d-flex align-items-center justify-content-between mb-4">
                    <div class="left-part">
                        <h2 class="text-dark">Invoices</h2>
                        <p class="text-muted mb-0">Manage View Invoices</p>
                    </div>
                    <div class="right-part d-flex align-items-center">
                        <div class="filtering d-flex align-items-center me-3">
                            <a href="#" class="btn list-view p-0 fs-30"><i class="bi bi-list"></i></a>
                            <a href="#" class="btn grid-view p-0 fs-30 active"><i class="bi bi-grid"></i></a>
                        </div>
                        @if(auth()->user()->role === 'admin') <!-- Adjust the property to match your user model -->
                            <button type="button" class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
                                <i class="bi bi-plus-circle me-1"></i>Add Invoice
                            </button>
                        @endif
                        <form method="GET" action="{{ route('invoices.index') }}" class="ms-3">
                            <div class="row g-2">
                                <div class="col-auto">
                                    <input type="text" name="customer_name" class="form-control" placeholder="Search by Customer Name" value="{{ request()->input('customer_name') }}">
                                </div>
                                <div class="col-auto">
                                    <input type="text" name="phone" class="form-control" placeholder="Search by Phone" value="{{ request()->input('phone') }}">
                                </div>
                                <div class="col-auto">
                                    <input type="date" name="invoice_date" class="form-control" value="{{ request()->input('invoice_date') }}">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive mt-4 bg-white">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th scope="col" class="text-white"></th>
                                <th scope="col" class="text-white">description</th>
                                <th scope="col" class="text-white">Customer Name</th>
                                <th scope="col" class="text-white">Amount</th>
                                <th scope="col" class="text-white">Date</th>
                                <th scope="col" class="text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td><input type="checkbox" class="form-check-input" name="selectedInvoices[]" value="{{ $invoice->id }}"></td>
                                <td>{{ $invoice->description }}</td>
                                <td>{{ $invoice->customer->name ?? '' }}</td>
                                <td>{{ $invoice->amount }}</td>
                                <td>{{ $invoice->date }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editInvoiceModal{{ $invoice->id }}">Edit</a></li>
                                            <li>
                                                @if(auth()->user()->role === 'admin') <!-- Check if user is admin -->
                                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Confirm delete?')">Delete</button>
                                                    </form>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Invoice Modal -->
                            <div class="modal fade" id="editInvoiceModal{{ $invoice->id }}" tabindex="-1" aria-labelledby="editInvoiceModalLabel{{ $invoice->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editInvoiceModalLabel{{ $invoice->id }}">Edit Invoice</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('invoices.update', $invoice->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label for="invoice_number" class="form-label">Description</label>
                                                    <input type="text" class="form-control" id="Description" name="description" value="{{ $invoice->description }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="customer_id" class="form-label">Customer</label>
                                                    <select class="form-control" id="customer_id" name="customer_id" required>
                                                        <option value="">Select Customer</option>
                                                        @foreach($customers as $customer)
                                                            <option value="{{ $customer->id }}" {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="amount" class="form-label">Amount</label>
                                                    <input type="number" class="form-control" id="amount" name="amount" value="{{ $invoice->amount }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date" class="form-label">Date</label>
                                                    <input type="date" class="form-control" id="date" name="date" value="{{ $invoice->date}}" required>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Save Changes</button>
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
                    <p class="mb-0 me-3">Showing <span class="fw-bold">{{ $invoices->firstItem() }}-{{ $invoices->lastItem() }}</span> of <span class="fw-bold">{{ $invoices->total() }}</span> entries</p>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            @if ($invoices->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $invoices->previousPageUrl() }}">&laquo;</a></li>
                            @endif
                            @foreach ($invoices->getUrlRange(1, $invoices->lastPage()) as $page => $url)
                                @if ($page == $invoices->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                            @if ($invoices->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $invoices->nextPageUrl() }}">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </main>

    <!-- Create Invoice Modal -->
<!-- Create Invoice Modal -->
<div class="modal fade" id="createInvoiceModal" tabindex="-1" aria-labelledby="createInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createInvoiceModalLabel">Add Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('invoices.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="description" class="form-label">description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select class="form-control" id="customer_id" name="customer_id" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option> <!-- Adjust according to your customer attributes -->
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Invoice</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Invoice Modal -->


</body>
@endsection
