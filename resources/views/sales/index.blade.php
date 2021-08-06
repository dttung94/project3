@extends('layouts.app', ['page' => 'Đơn bán', 'pageSlug' => 'sales', 'section' => 'transactions'])

@section('content')
    @include('alerts.success')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Đơn bán</h4>
                        </div>
                        @if(auth()->user()->role == '2')
                        <div class="col-4 text-right">
                            <a href="{{ route('sales.create') }}" class="btn btn-sm btn-primary">Thêm</a>
                        </div>
                        @endif
                    </div>
                </div>

                <div>
                    <form action="{{route('sales.index')}}" method="get">
                        <div class="form-header">
                            <input class="au-input au-input--xl" type="text" name="search"
                                   placeholder="Tìm kiếm đơn đặt hàng..."/>
                            <button class="au-btn--submit" type="submit">
                                <i class="tim-icons icon-zoom-split"></i>
                            </button>
                        </div>
                    </form>
                </div>


                <div class="card-body">
                    <div class="">
                        <table class="table">
                            <thead>
                                <th>Ngày</th>
                                <th>Khách khàng</th>
                                <th>Người xử lý</th>
                                <th>Số loại sản phẩm</th>
                                <th>Tổng số sản phẩm</th>
                                <th>Tổng số tiền</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>{{ date('d-m-y', strtotime($sale->created_at)) }}</td>
                                        <td><a href="{{ route('clients.show', $sale->client) }}">{{ $sale->client->name }}<br>{{ $sale->client->document_type }}-{{ $sale->client->document_id }}</a></td>
                                        <td>{{ $sale->user->name }}</td>
                                        <td>{{ $sale->products->count() }}</td>
                                        <td>{{ $sale->products->sum('qty') }}</td>
                                        <td>{{ format_money($sale->transactions->sum('amount')) }}</td>
                                        <td>
                                            @if (!$sale->finalized_at)
                                                <span class="text-danger">To Finalize</span>
                                            @else
                                                <span class="text-success">Finalized</span>
                                            @endif
                                        </td>
                                        <td class="td-actions text-right">

                                            @if (!$sale->finalized_at)
                                                @if(auth()->user()->role=='2')
                                                <a href="{{ route('sales.show', ['sale' => $sale]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Sale">
                                                    <i class="tim-icons icon-pencil"></i>
                                                </a>
                                                @endif


                                                <a href="{{ route('sales.show', ['sale' => $sale]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="View Sale">
                                                    <i class="tim-icons icon-zoom-split"></i>
                                                </a>
                                            @if(auth()->user()->role=='2')
                                            <form action="{{ route('sales.destroy', $sale) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Sale" onclick="confirm('Are you sure you want to delete this sale? All your records will be permanently deleted.') ? this.parentElement.submit() : ''">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                            </form>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $sales->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
