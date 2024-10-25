@extends('dashboard.layouts.app')

@section('content')

<div class="card card-flush">

    <form action="{{ route('dashboard.articles.index') }}" method="GET">

        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" name="s" value="{{ request()->s }}"
                        class="form-control form-control-solid w-250px ps-12" placeholder="Search Articles">
                </div>
            </div>

            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <div class="w-100 mw-150px">
                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                        data-placeholder="Status" name="status">
                        <option></option>
                        <option value="all">All</option>
                        <option value="published">Published</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <a href="{{ route('dashboard.articles.create') }}" class="btn btn-primary">Add article</a>
            </div>
        </div>

    </form>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                    data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="1" />
                            </div>
                        </th>
                        <th class="max-w-150px">Title</th>
                        <th class="">Author</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created at</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">

                    @foreach($articles as $article)

                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('dashboard.articles.show', $article->id) }}"
                                    class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                    data-kt-ecommerce-product-filter="product_name">
                                    {{ $article->title }}
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('dashboard.users.show', $article->author_id) }}"
                                    class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                    data-kt-ecommerce-product-filter="product_name">
                                    {{ $article->author->name }}
                                </a>
                            </td>
                            <td class="text-center">
                               @if( $article->published )
                                    <span class="badge badge-light-success">Published</span>
                                @else
                                    <span class="badge badge-light-danger">Draft</span>
                                @endif
                            </td>
                            <td class="text-center pe-0">
                                {{ $article->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
     
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                    data-kt-menu="true">

                                    <div class="menu-item px-3">
                                        <a href="{{ route('dashboard.articles.show', $article->id) }}"
                                            class="menu-link px-3">Edit</a>
                                    </div>

                                    <div class="menu-item px-3">
                                        <form action="{{ route('dashboard.articles.destroy', $article->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="menu-link px-3" type="submit">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>
        </div>


        <div id="" class="row">
            {{ $articles->links('dashboard.includes.pagination.default') }}
        </div>

    </div>

</div>

@endsection