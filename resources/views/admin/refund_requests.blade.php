<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Refund &amp; Return Requests – Admin – Skyrose Atelier</title>
    @include('partials.head')
    <style>
        .AdminPage { max-width: 1300px; margin: 80px auto 60px; padding: 0 24px 60px; }
        .AdminPage h1 { font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 6px; }
        .AdminSubnav { display: flex; gap: 10px; margin-bottom: 32px; flex-wrap: wrap; }
        .AdminSubnav a { display: inline-block; font-size: 14px; font-weight: 600; text-decoration: none; padding: 8px 20px; border-radius: 4px; border: 2px solid #c8c389; color: #c8c389; transition: all 0.2s; }
        .AdminSubnav a:hover, .AdminSubnav a.active { background: #c8c389; color: #fff; }

        .filter-bar { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; align-items: flex-end; }
        .filter-bar select { padding: 9px 14px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; color: #333; background: #fff; }
        .filter-btn { padding: 9px 20px; background: #c8c389; color: #fff; border: none; border-radius: 4px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .filter-btn:hover { background: #b5b070; }
        .filter-clear { padding: 9px 16px; background: #f5f0e8; color: #555; border: 1px solid #e8e0d0; border-radius: 4px; font-size: 14px; text-decoration: none; }

        .orders-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid #e8e0d0; }
        .orders-table th { background: #1a1a1a; color: #fff; padding: 13px 16px; text-align: left; font-size: 12px; text-transform: uppercase; letter-spacing: 0.6px; white-space: nowrap; }
        .orders-table td { padding: 14px 16px; border-bottom: 1px solid #f5f0e8; font-size: 14px; color: #333; vertical-align: middle; }
        .orders-table tr:last-child td { border-bottom: none; }
        .orders-table tr:hover td { background: #fdfaf5; }

        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: capitalize; }
        .status-pending   { background: #fff3cd; color: #856404; }
        .status-approved  { background: #d4edda; color: #155724; }
        .status-rejected  { background: #f8d7da; color: #721c24; }
        .status-completed { background: #cfe2ff; color: #084298; }

        .type-badge { padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; }
        .type-refund { background: #e2d9f3; color: #432874; }
        .type-return { background: #d1ecf1; color: #0c5460; }

        .status-form { display: flex; gap: 8px; align-items: center; }
        .status-select { padding: 6px 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; background: #fff; }
        .save-btn { padding: 6px 14px; background: #c8c389; color: #fff; border: none; border-radius: 4px; font-size: 13px; font-weight: 600; cursor: pointer; }
        .save-btn:hover { background: #b5b070; }

        .view-link { color: #111; font-weight: 700; text-decoration: none; font-size: 13px; }
        .view-link:hover { text-decoration: underline; }

        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
        .summary { font-size: 14px; color: #888; margin-bottom: 12px; }
        .pagination-wrap { margin-top: 28px; display: flex; justify-content: center; }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <div class="PageContent">
            @include('partials.nav')

            <div class="AdminPage">
                <h1>Refund &amp; Return Requests</h1>
                <div class="AdminSubnav">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a href="{{ route('admin.orders') }}">Customer Orders</a>
                    <a href="{{ route('admin.refund-requests') }}" class="active">Refund/Return Requests</a>
                </div>

                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                {{-- Filters --}}
                <form method="GET" action="{{ route('admin.refund-requests') }}" class="filter-bar">
                    <select name="type">
                        <option value="">All Types</option>
                        <option value="refund" @selected(request('type') === 'refund')>Refund</option>
                        <option value="return" @selected(request('type') === 'return')>Return</option>
                    </select>
                    <select name="status">
                        <option value="">All Statuses</option>
                        @foreach(['pending','approved','rejected','completed'] as $s)
                            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="filter-btn">Filter</button>
                    @if(request()->hasAny(['type','status']))
                        <a href="{{ route('admin.refund-requests') }}" class="filter-clear">Clear</a>
                    @endif
                </form>

                <p class="summary">Showing {{ $refundRequests->firstItem() }}–{{ $refundRequests->lastItem() }} of {{ $refundRequests->total() }} requests</p>

                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Update Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($refundRequests as $rr)
                        <tr>
                            <td>{{ $rr->id }}</td>
                            <td><span class="type-badge type-{{ $rr->type }}">{{ ucfirst($rr->type) }}</span></td>
                            <td>#{{ $rr->order_id }}</td>
                            <td>
                                {{ $rr->user->name ?? 'Unknown' }}<br>
                                <span style="font-size:12px;color:#888;">{{ $rr->user->email ?? '' }}</span>
                            </td>
                            <td>{{ $rr->created_at->format('d M Y H:i') }}</td>
                            <td><span class="status-badge status-{{ $rr->status }}">{{ ucfirst($rr->status) }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('admin.refund-requests.updateStatus', $rr->id) }}" class="status-form">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="status-select">
                                        @foreach(['pending','approved','rejected','completed'] as $s)
                                            <option value="{{ $s }}" @selected($rr->status === $s)>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="save-btn">Save</button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $rr->order_id) }}" class="view-link">View Order →</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" style="text-align:center;color:#999;padding:32px;">No refund or return requests yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination-wrap">
                    {{ $refundRequests->links() }}
                </div>
            </div>
        </div>
        @include('partials.footer')
    </div>
</body>
</html>
