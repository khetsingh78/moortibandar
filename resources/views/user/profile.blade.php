@extends('partial/layouts')

@section('title', 'My Profile')
@section('robots', 'noindex, nofollow')

@push('header')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <style>
        .breadcrumb-option {
            background: transparent;
            box-shadow: none;
            padding: 18px 0 0;
            border: none;
        }

        .breadcrumb__links {
            background: #fff;
            border: 1px solid #f1f1f1;
            padding: 12px 18px;
            border-radius: 12px;
        }

        .profile-page {
            background: transparent;
            padding: 24px 0 60px;
        }

        .profile-card {
            background: #fff;
            border: 1px solid #f1f1f1;
            border-radius: 18px;
            box-shadow: none;
            padding: 25px;
            margin-bottom: 24px;
        }

        .profile-avatar-wrap {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f1f1f1;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #111;
        }

        .profile-form .form-group {
            margin-bottom: 18px;
        }

        .profile-form label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        .profile-form input,
        .profile-form select {
            width: 100%;
            height: 48px;
            border: 1px solid #e2e2e2;
            border-radius: 10px;
            padding: 0 14px;
            background: #fff;
        }

        .site-btn {
            display: inline-block;
            padding: 12px 28px;
            border: none;
            background: #111;
            color: #fff;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .site-btn:hover {
            background: #d32f2f;
            color: #fff;
        }

        .order-table-wrap {
            background: #fff;
            border-radius: 18px;
            padding: 20px;
            border: 1px solid #f1f1f1;
            box-shadow: none;
        }

        .table tbody tr {
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .table tbody tr:hover {
            background: #fafafa;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-pending {
            background: #fff3cd;
            color: #8a6d00;
        }

        .status-paid {
            background: #d1f2dd;
            color: #0d6b3f;
        }

        .status-processing,
        .status-shipped {
            background: #dfe9ff;
            color: #1d4ed8;
        }

        .status-delivered {
            background: #d1fae5;
            color: #047857;
        }

        .status-cancelled,
        .status-failed {
            background: #ffe4e6;
            color: #b42318;
        }

        .modal-content {
            border: none;
            border-radius: 18px;
            box-shadow: none;
        }

        .modal-header {
            border-bottom: 1px solid #f1f1f1;
            padding: 18px 20px;
        }

        .modal-header .btn-close {
            background-color: #111;
            border-radius: 50%;
            opacity: 1;
            filter: invert(1);
            padding: 0.5rem;
            box-shadow: none;
        }

        .order-summary-box {
            background: #fafafa;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 18px;
        }

        .order-item-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-item-row:last-child {
            border-bottom: none;
        }

        @media (max-width: 768px) {
            .profile-page {
                padding: 30px 0;
            }
        }
    </style>
@endpush

@php
    $ordersCount = $orders->count();
    $totalSpent = $orders->sum('total');
    $lastOrder = $orders->first();
    $deliveredCount = $orders->where('delivery_status', 'delivered')->count();
@endphp

@section('content')
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="{{ route('user.profile') }}">My Account</a>
                        <span>{{ Auth::user()->name ?? 'Profile' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="profile-page">
        <div class="container">
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="profile-card h-100">
                        <p class="mb-2 text-muted">Total Orders</p>
                        <h4 class="mb-0">{{ $ordersCount }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="profile-card h-100">
                        <p class="mb-2 text-muted">Total Spent</p>
                        <h4 class="mb-0">₹{{ number_format((float) $totalSpent, 2) }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="profile-card h-100">
                        <p class="mb-2 text-muted">Delivered</p>
                        <h4 class="mb-0">{{ $deliveredCount }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="profile-card h-100">
                        <p class="mb-2 text-muted">Last Order</p>
                        <h4 class="mb-0">{{ $lastOrder ? '#' . $lastOrder->invoice_no : 'N/A' }}</h4>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="profile-card">
                        <div class="profile-avatar-wrap">
                            <img src="{{ Auth::user()->profile_url ?? asset('img/user.jpg') }}" alt="Profile Photo"
                                class="profile-avatar">
                        </div>

                        <form action="{{ route('user.photo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="userPhoto">Update profile image</label>
                                <input type="file" name="userPhoto" class="form-control" id="userPhoto"
                                    accept=".png,.jpg,.jpeg,.svg">
                            </div>
                            <button type="submit" class="site-btn w-100">Upload Photo</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="profile-card">
                        <h3 class="section-title">Personal Information</h3>

                        <form action="{{ route('user.profile.update') }}" method="POST" class="profile-form">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Full Name</label>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', Auth::user()->name) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" id="email" name="email"
                                            value="{{ old('email', Auth::user()->email) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" id="phone" name="phone"
                                            value="{{ old('phone', Auth::user()->phone) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select id="gender" name="gender">
                                            <option value="">Select</option>
                                            <option value="male"
                                                {{ old('gender', Auth::user()->gender) == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female"
                                                {{ old('gender', Auth::user()->gender) == 'female' ? 'selected' : '' }}>
                                                Female</option>
                                            <option value="other"
                                                {{ old('gender', Auth::user()->gender) == 'other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="site-btn">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h3 class="section-title">Order History</h3>

                <div class="order-table-wrap">
                    <div class="table-responsive">
                        <table id="orderHistoryTable" class="table table-borderless align-middle">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Delivery</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            {{-- @dd($orders->count()); --}}
                            <tbody>
                                @foreach ($orders ?? [] as $order)
                                    <tr data-order-id="{{ $order->id ?? '' }}">
                                        <td>#{{ $order->invoice_no ?? 'N/A' }}</td>
                                        <td>{{ $order->created_at?->format('d M Y') ?? 'N/A' }}</td>
                                        <td>₹{{ number_format((float) $order->total, 2) }}</td>
                                        <td>
                                            <span
                                                class="status-badge {{ $order->payment_status == 'paid' ? 'status-paid' : ($order->payment_status == 'pending' ? 'status-pending' : 'status-processing') }}">
                                                {{ ucfirst($order->payment_status ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge {{ $order->delivery_status == 'delivered' ? 'status-delivered' : ($order->delivery_status == 'pending' ? 'status-pending' : ($order->delivery_status == 'cancelled' ? 'status-cancelled' : 'status-processing')) }}">
                                                {{ ucfirst(str_replace('_', ' ', $order->delivery_status ?? 'N/A')) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-dark view-order-btn">View</button>
                                        </td>
                                    </tr>
                                    {{-- @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">No orders found yet.</td>
                                    </tr> --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="order-summary-box">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Invoice:</strong> <span id="detailInvoice"></span></p>
                                <p><strong>Order Date:</strong> <span id="detailDate"></span></p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <p><strong>Delivery:</strong> <span id="detailDelivery"></span></p>
                                <p><strong>Payment:</strong> <span id="detailPayment"></span></p>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3">Items</h6>
                    <div id="detailItems"></div>

                    <hr>

                    <h6 class="fw-bold mb-3">Shipping Address</h6>
                    <div id="detailAddress" class="order-summary-box"></div>

                    <h6 class="fw-bold mb-3">Payment Details</h6>
                    <div id="detailPaymentInfo" class="order-summary-box"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#orderHistoryTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                pageLength: 10,
                order: [
                    [1, 'desc']
                ],
                language: {
                    search: "Search orders",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ orders",
                    emptyTable: "No orders found yet.",
                    zeroRecords: "No matching orders found."
                }
            });

            $('#orderHistoryTable tbody').on('click', 'tr', function() {
                const orderId = $(this).data('order-id');
                if (!orderId) return;

                $.get('{{ url('/profile/order') }}/' + orderId, function(response) {
                    $('#detailInvoice').text(response.order.invoice_no);
                    $('#detailDate').text(response.order.created_at);
                    $('#detailDelivery').text(response.order.delivery_status.replace('_', ' '));
                    $('#detailPayment').text(response.order.payment_status);

                    let itemsHtml = '';

                    response.items.forEach(function(item) {
                        itemsHtml += `
                            <div class="order-item-row">
                                <div>
                                    <strong>${item.title}</strong><br>
                                    <small>Qty: ${item.quantity}</small>
                                </div>
                                <div class="text-end">
                                    <div>₹${item.total}</div>
                                    <small>₹${item.price} each</small>
                                </div>
                            </div>
                        `;
                    });

                    $('#detailItems').html(itemsHtml);

                    const shipping = response.shipping || {};
                    $('#detailAddress').html(`
                        <p><strong>Name:</strong> ${shipping.name || '-'}</p>
                        <p><strong>Phone:</strong> ${shipping.phone || '-'}</p>
                        <p><strong>Email:</strong> ${shipping.email || '-'}</p>
                        <p><strong>Address:</strong> ${shipping.house_no || ''} ${shipping.address || ''}</p>
                        <p><strong>City:</strong> ${shipping.city || '-'} | <strong>State:</strong> ${shipping.state || '-'}</p>
                        <p><strong>Zip:</strong> ${shipping.zip || '-'} | <strong>Country:</strong> ${shipping.country || '-'}</p>
                        <p><strong>Note:</strong> ${shipping.note || '-'}</p>
                    `);

                    const payment = response.payment || {};
                    $('#detailPaymentInfo').html(`
                        <p><strong>Method:</strong> ${payment.payment_method || '-'}</p>
                        <p><strong>Status:</strong> ${payment.status || '-'}</p>
                        <p><strong>Amount:</strong> ₹${payment.amount || '0.00'}</p>
                        <p><strong>Transaction Order ID:</strong> ${payment.transaction_order_id || '-'}</p>
                        <p><strong>Transaction Payment ID:</strong> ${payment.transaction_payment_id || '-'}</p>
                    `);

                    $('#orderDetailModal').modal('show');
                });
            });
        });
    </script>
@endpush
