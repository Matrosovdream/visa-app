<div class="tab-pane fade" id="kt_ecommerce_sales_order_certificates" role="tab-panel">
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid">

            <div class="card-header">
                <div class="card-title">
                    <h2>Certificates</h2>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">

                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">File</th>
                                <th class="min-w-175px">Description</th>
                                <th class="min-w-175px">Date/Time</th>
                                <th class="min-w-125px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">

                            @foreach($order->certificates as $item)
                                <tr>
                                    <td>
                                        {{ $item->file->filename }}
                                    </td>
                                    <td>
                                        {{ $item->file->description }}
                                    </td>
                                    <td>
                                        {{ $item->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        <form 
                                        action="{{ route('dashboard.orders.certificate.destroy', ['order' => $order->id, 'certificate' => $item->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light btn-active-light-primary">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-toolbar w-50">

            <form action="{{ route('dashboard.orders.certificate.create', $order->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <input type="file" class="form-control" id="document" name="document">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">
                        Document Description
                    </label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    Add file
                </button>
            </form>

        </div>

    </div>
</div>