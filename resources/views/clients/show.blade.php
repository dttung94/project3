@extends('layouts.app', ['page' => 'Thông tin khách hàng', 'pageSlug' => 'clients', 'section' => 'clients'])

@section('content')
    @include('alerts.error')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin khách hàng</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Phân loại</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Ví</th>
                            <th>Số hàng đã mua</th>
                            <th>Tổng tiền thanh toán</th>
                            <th>Lần mua hàng cuối</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->document_type }}-{{ $client->document_id }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->email }}</td>
                                <td>
                                    @if ($client->balance > 0)
                                        <span class="text-success">{{ format_money($client->balance) }}</span>
                                    @elseif ($client->balance < 0.00)
                                        <span class="text-danger">{{ format_money($client->balance) }}</span>
                                    @else
                                        {{ format_money($client->balance) }}
                                    @endif
                                </td>
                                <td>{{ $client->sales->count() }}</td>
                                <td>{{ format_money($client->transactions->sum('amount')) }}</td>
                                <td>{{ (empty($client->sales)) ? date('d-m-y', strtotime($client->sales->reverse()->first()->created_at)) : 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Thanh toán</h4>
                        </div>
                        @if(auth()->user()->role=='2')
                        <div class="col-4 text-right">
                            <a href="{{ route('clients.transactions.add', $client) }}" class="btn btn-sm btn-primary">Thêm thanh toán</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Ngày</th>
                            <th>Thanh toán</th>
                            <th>Số tiền</th>
                        </thead>
                        <tbody>
                            @foreach ($client->transactions->reverse()->take(25) as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ date('d-m-y', strtotime($transaction->created_at)) }}</td>
                                    <td><a href="{{ route('methods.show', $transaction->method) }}">{{ $transaction->method->name }}</a></td>
                                    <td>{{ format_money($transaction->amount) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Mua hàng</h4>
                        </div>
                        <div class="col-4 text-right">
                            <form method="post" action="{{ route('sales.store') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
{{--                                <button type="submit" class="btn btn-sm btn-primary">New Purchase</button>--}}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Ngày</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($client->sales->reverse()->take(25) as $sale)
                                <tr>
                                    <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->id }}</a></td>
                                    <td>{{ date('d-m-y', strtotime($sale->created_at)) }}</td>
                                    <td>{{ $sale->products->count() }}</td>
                                    <td>{{ $sale->products->sum('qty') }}</td>
                                    <td>{{ format_money($sale->products->sum('total_amount')) }}</td>
                                    <td>{{ ($sale->finalized_at) ? 'FINISHED' : 'ON HOLD' }}</td>

                                    <td class="td-actions text-right">
                                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                            <i class="tim-icons icon-zoom-split"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
