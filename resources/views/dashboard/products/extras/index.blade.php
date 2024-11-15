<div class="modal fade" id="kt_modal_product_extra_{{ $extra->id }}" tabindex="-1" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit extra #{{ $extra->id }}</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>

            <div class="modal-body py-lg-10 px-lg-10">
                <form method="POST" action="{{ route('dashboard.extras.update', $extra->id) }}">
                    @csrf

                    <input type="hidden" name="product_id" value="{{ $extra->product_id }}" />
                    <input type="hidden" name="type" value="gov_fees" />

                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Title</label>
                        <input type="text" name="name" class="form-control mb-2"
                            value="{{ $extra->name }}">
                    </div>

                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Price</label>
                        <input type="text" name="price" class="form-control mb-2"
                            value="{{ $extra->price }}">
                    </div>

                    <div class="d-flex flex-stack">

                        <div></div>

                        <div>
                            <button type="submit" class="btn btn-lg btn-primary">
                                Save
                                <i class="ki-duotone ki-arrow-right fs-3 ms-1 me-0">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i></button>
                        </div>

                    </div>

                </form>

                <hr />

                <form action="{{ route('dashboard.extras.destroy', $extra->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger alert">
                        Delete extra service
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>