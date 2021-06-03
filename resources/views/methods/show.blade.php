@extends('layouts.app', ['page' => 'Thông tin PTTT', 'pageSlug' => 'methods', 'section' => 'methods'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin PTTT</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Mô tả</th>
                            <th>Số giao dịch</th>
                            <th>Ví hàng ngày</th>
                            <th>Ví hàng tuần</th>
                            <th>Ví hàng tháng</th>
                            <th>Ví hàng qúy</th>

                            <th>Cả năm</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $method->id }}</td>
                                <td>{{ $method->name }}</td>
                                <td>{{ $method->description }}</td>
                                <td>{{ $method->transactions->count() }}</td>
                                <td>{{ format_money($balances['daily']) }}</td>
                                <td>{{ format_money($balances['weekly']) }}</td>
                                <td>{{ format_money($balances['monthly']) }}</td>
                                <td>{{ format_money($balances['quarter']) }}</td>

                                <td>{{ format_money($balances['annual']) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Số giao dịch: {{ $transactions->count() }}</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>

                            <th>Ngày</th>
                            <th>Loại GD</th>
                            <th>Tiêu đề</th>
                            <th>Số tiền</th>
                            <th>Mô tả</th>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>

                                    <td>{{ date('d-m-y', strtotime($transaction->created_at)) }}</td>
                                    <td><a href="{{ route('transactions.type', $transaction->type) }}">{{ $transactionname[$transaction->type] }}</a></td>
                                    <td>{{ $transaction->title }}</td>
                                    <td>{{ format_money($transaction->amount) }}</td>
                                    <td>{{ $transaction->reference }}</td>

                                    <td class="td-actions text-right">
                                        @if (auth()->user()->role == '2')
                                            <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Transaction">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('transactions.destroy', $transaction) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Transaction" onclick="confirm('Bạn muốn xóa giao dịch này chứ ?') ? this.parentElement.submit() : ''">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                            </form>
                                        @endif
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
