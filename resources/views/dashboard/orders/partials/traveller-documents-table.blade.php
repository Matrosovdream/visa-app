<div class="card-header">
    <div class="card-title">
        <h2>Documents</h2>
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

                @foreach($traveller->documents as $item)
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
                                action="{{ route('dashboard.orders.traveller.document.destroy', ['order' => $order->id, 'traveller' => $traveller->id, 'document' => $item->id]) }}"
                                method="POST">
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

<br />


<div class="card-body pt-0 pb-0 w-50">
    <form method="POST"
        action="{{ route('dashboard.orders.traveller.document.store', ['order' => $order->id, 'traveller' => $traveller]) }}"
        enctype="multipart/form-data">
        @csrf

        <div class="mb-10 fv-row fv-plugins-icon-container">
            <label class="required form-label">File</label>
            <input type="file" name="document" class="form-control mb-2">
        </div>

        <div class="mb-10 fv-row fv-plugins-icon-container">
            <label class="required form-label">Description</label>
            <input type="text" name="description" class="form-control mb-2">
        </div>

        <div class="d-flex flex-stack">
            <div></div>
            <div>
                <button type="submit" class="btn btn-lg btn-primary">
                    Upload
                    <i class="ki-duotone ki-arrow-right fs-3 ms-1 me-0">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>
            </div>
        </div>

    </form>
</div>