@extends('layouts.app', ['page' => 'Danh sách danh mục', 'pageSlug' => 'categories', 'section' => 'inventory'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Danh sách </h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">Thêm danh mục</a>
                        </div>
                    </div>
                </div>

                <div>
                    <form action="{{route('categories.index')}}" method="get">
                        <div class="form-header">
                            <input class="au-input au-input--xl" type="text" name="search"
                                   placeholder="Nhập danh mục muốn tìm kiếm....."/>
                            <button class="au-btn--submit" type="submit">
                                <i class="tim-icons icon-zoom-split"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <th scope="col">Tên</th>
                                <th scope="col">Tổng số loại sản phẩm</th>
                                <th scope="col">Tồn kho</th>
                                <th scope="col">Sản phẩm lỗi</th>
                                <th scope="col">Giá trung bình</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ count($category->products) }}</td>
                                        <td>{{ $category->products->sum('stock') }}</td>
                                        <td>{{ $category->products->sum('stock_defective') }}</td>
                                        <td>{{ format_money($category->products->avg('price')) }}</td>
                                        <td class="td-actions text-right">
                                            <a href="{{ route('categories.show', $category) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                                <i class="tim-icons icon-zoom-split"></i>
                                            </a>
                                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Category">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Category" onclick="confirm('Are you sure you want to delete this category? All products belonging to it will be deleted and the records that contain it will not be accurate.') ? this.parentElement.submit() : ''">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $categories->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
