@extends('layouts.app', ['pageSlug' => 'tstats', 'page' => 'Thống Kê', 'section' => 'transactions'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Thống kê giao dịch</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-primary">
                                Danh sách giao dịch
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>Định kỳ</th>
                                <th>Số giao dịch</th>
                                <th>Thu</th>
                                <th>Chi</th>
                                <th>Thanh toán</th>
                                <th>Ví tiền mặt</th>
                                <th>Tổng</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($transactionsperiods as $period => $data)
                                    <tr>
                                        <td>{{ $period }}</td>
                                        <td>{{ $data->count() }}</td>
                                        <td>{{ format_money($data->where('type', 'income')->sum('amount')) }}</td>
                                        <td>{{ format_money($data->where('type', 'expense')->sum('amount')) }}</td>
                                        <td>{{ format_money($data->where('type', 'payment')->sum('amount')) }}</td>
                                        <td>{{ format_money($data->where('payment_method_id', optional($methods->where('name', 'Cash')->first())->id)->sum('amount')) }}</td>
                                        <td>{{ format_money($data->sum('amount')) }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-tasks">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Ví dư cần xử lý</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('clients.index') }}" class="btn btn-sm btn-primary">Khách hàng</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-full-width table-responsive">
                        <table class="table">
                            <thead>
                                <th>Khách hàng</th>
                                <th>Mua hàng</th>
                                <th>Giao dịch</th>
                                <th>Ví</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td><a href="{{ route('clients.show', $client) }}">{{ $client->name }}<br>{{ $client->document_type }}-{{ $client->document_id }}</a></td>
                                        <td>{{ $client->sales->count() }}</td>
                                        <td>{{ format_money($client->transactions->sum('amount')) }}</td>
                                        <td>
                                            @if ($client->balance > 0)
                                                <span class="text-success">{{ format_money($client->balance) }}</span>
                                            @elseif ($client->balance < 0.00)
                                                <span class="text-danger">{{ format_money($client->balance) }}</span>
                                            @else
                                                {{ format_money($client->balance) }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('clients.transactions.add', $client) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Register Transation">
                                                <i class="tim-icons icon-simple-add"></i>
                                            </a>
                                            <a href="{{ route('clients.show', $client) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="See Client">
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

        <div class="col-md-6">
            <div class="card card-tasks">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Thống kê theo PTTT</h4>
                        </div>
                        @if (auth()->user()->role==2)
                        <div class="col-4 text-right">
                            <a href="{{ route('methods.index') }}" class="btn btn-sm btn-primary">PTTT</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-full-width table-responsive">
                        <table class="table">
                            <thead>
                                <th>Phương thức</th>
                                <th>Giao dịch {{ $date->year }}</th>
                                <th>Ví {{ $date->year }}</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($methods as $method)
                                    <tr>
                                        <td><a href="{{ route('methods.show', $method) }}">{{ $method->name }}</a></td>
                                        <td>{{ $transactionsperiods['Năm']->where('payment_method_id', $method->id)->count() }}</td>
                                        <td>{{ format_money($transactionsperiods['Năm']->where('payment_method_id', $method->id)->sum('amount')) }}</td>
                                        <td>
                                            <a href="{{ route('methods.show', $method) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="See Method">
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
    </div>

    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Thống kê đơn đặt hàng</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">Đơn đặt hàng</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>Period</th>
                        <th>Sales</th>
                        <th>Clients</th>
                        <th>Total Stock</th>
                        <th data-toggle="tooltip" data-placement="bottom" title="Promedio de ingresos por cada venta">Average C / V</th>
                        <th>Billed Amount</th>
                        <th>To Finalize</th>
                    </thead>
                    <tbody>
                        @foreach ($salesperiods as $period => $data)
                            <tr>
                                <td>{{ $period }}</td>
                                <td>{{ $data->count() }}</td>
                                <td>{{ $data->groupBy('client_id')->count() }}</td>
                                <td>{{ $data->where('finalized_at', '!=', null)->map(function ($sale) {return $sale->products->sum('qty');})->sum() }}</td>
                                <td>{{ format_money($data->avg('total_amount')) }}</td>
                                <td>{{ format_money($data->where('finalized_at', '!=', null)->map(function ($sale) {return $sale->products->sum('total_amount');})->sum()) }}</td>
                                <td>{{ $data->where('finalized_at', null)->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
@endsection
