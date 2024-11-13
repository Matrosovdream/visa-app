<div class="modal fade" id="kt_modal_product_offer_{{ $offer->id }}" tabindex="-1" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit offer #{{ $offer->id }}</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>

            <div class="modal-body py-lg-10 px-lg-10">
                <form method="POST" action="{{ route('dashboard.offers.update', $offer->id) }}">
                    @csrf

                    <input type="hidden" name="product_id" value="{{ $offer->product_id }}" />

                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Title</label>
                        <input type="text" name="name" class="form-control mb-2"
                            value="{{ $offer->name }}">
                    </div>

                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Price</label>
                        <input type="text" name="price" class="form-control mb-2"
                            value="{{ $offer->price }}">
                    </div>

                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Duration title</label>
                        <input type="text" name="meta[duration]" class="form-control mb-2"
                            value="{{ $offer->getMeta('duration') }}">
                    </div>

                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Duration hours</label>
                        <input type="text" name="meta[duration_hours]" class="form-control mb-2"
                            value="{{ $offer->getMeta('duration_hours') }}">
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

                <form action="{{ route('dashboard.offers.destroy', $offer->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger alert">
                        Delete offer
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>