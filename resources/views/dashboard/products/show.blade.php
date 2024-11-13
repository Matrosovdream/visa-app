@extends('dashboard.layouts.app')

@section('content')

<form id="kt_ecommerce_add_product_form"
	class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework"
	data-kt-redirect="apps/ecommerce/catalog/products.html" data-select2-id="select2-data-kt_ecommerce_add_product_form"
	method="POST" action="{{ route('dashboard.products.update', $product->id) }}">

	@csrf

	<div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-250px min-w-250px mb-7 me-lg-10"
		data-select2-id="select2-data-130-l6c6">

		<div class="card card-flush py-4">
			<div class="card-header">
				<div class="card-title">
					<h2>Status</h2>
				</div>
				<div class="card-toolbar">
					<div class="rounded-circle @if( $product->published ) bg-success @else bg-danger @endif w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
				</div>
			</div>

			<div class="card-body pt-0">

				<select class="form-select mb-2" data-control="select2" data-hide-search="true"
					data-placeholder="Select an option" id="kt_ecommerce_add_product_status_select" name="status">
					<option value="published" @if( $product->published ) selected="selected" @endif >Published</option>
					<option value="draft" @if( !$product->published ) selected="selected" @endif>Draft</option>
				</select>

				<div class="text-muted fs-7">Set the product status.</div>
				<div class="d-none mt-10">
					<label for="kt_ecommerce_add_product_status_datepicker" class="form-label">
						Select publishing date and time
					</label>
					<input class="form-control" id="kt_ecommerce_add_product_status_datepicker"
						placeholder="Pick date & time" />
				</div>
			</div>

			<div class="d-flex justify-content-center mt-30">
				<button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
					<span class="indicator-label">Save Changes</span>
				</button>
			</div>

		</div>
	</div>

	<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

		<ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2"
			role="tablist">
			<li class="nav-item" role="presentation">
				<a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
					href="#kt_ecommerce_add_product_general" aria-selected="true" role="tab">General</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
					href="#kt_ecommerce_add_product_fields" aria-selected="true" role="tab">Fields</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
					href="#kt_ecommerce_add_product_offers" aria-selected="true" role="tab">Offers</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
					href="#kt_ecommerce_add_product_extras" aria-selected="true" role="tab">Extras</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
					href="#kt_ecommerce_add_product_countries" aria-selected="false" role="tab"
					tabindex="-1">Countries</a>
			</li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane fade active show" id="kt_ecommerce_add_product_general" role="tab-panel">
				<div class="d-flex flex-column gap-7 gap-lg-10">
					<!--begin::General options-->
					<div class="card card-flush py-4">
						<!--begin::Card header-->
						<div class="card-header">
							<div class="card-title">
								<h2>General</h2>
							</div>
						</div>

						<div class="card-body pt-0">
							<!--begin::Input group-->
							<div class="mb-10 fv-row fv-plugins-icon-container">
								<!--begin::Label-->
								<label class="required form-label">Product Name</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input type="text" name="product_name" class="form-control mb-2"
									placeholder="Product name" value="{{ $product->name }}">
								<!--end::Input-->
								<!--begin::Description-->
								<div class="text-muted fs-7">A product name is required and recommended to be unique.
								</div>
								<!--end::Description-->
								<div
									class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
								</div>
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div>
								<!--begin::Label-->
								<label class="form-label">Description</label>
								<!--end::Label-->
								<!--begin::Editor-->
								<div id="kt_ecommerce_add_product_description" class="min-h-200px mb-2">
									<textarea name="description" id="editor1" class="form-control"
										rows="10">{{ $product->description }}</textarea>
								</div>
								<!--end::Editor-->
								<!--begin::Description-->
								<div class="text-muted fs-7">Set a description to the product for better visibility.
								</div>
								<!--end::Description-->
							</div>
							<!--end::Input group-->
						</div>
						<!--end::Card header-->
					</div>
					<!--end::General options-->

				</div>
			</div>

			<div class="tab-pane fade" id="kt_ecommerce_add_product_fields" role="tab-panel">
				<div class="d-flex flex-column gap-7 gap-lg-10">

					<div class="card card-flush py-4">
						<div class="card-header">
							<div class="card-title">
								<h2>Fields</h2>
							</div>
						</div>
						<div class="card-body pt-0">

							@foreach($productFields as $field) 

								<div class="mb-10 fv-row fv-plugins-icon-container">
									<label class="required form-label">{{ $field['title'] }}</label>
									<input type="text" name="fields[{{ $field['slug'] }}]" class="form-control mb-2"
										placeholder="" value="{{ $field['value'] }}">
									<div class="text-muted fs-7">

									</div>
									<div
										class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
									</div>
								</div>

							@endforeach

						</div>
					</div>

				</div>
			</div>

			<div class="tab-pane fade" id="kt_ecommerce_add_product_offers" role="tab-panel">
				<div class="d-flex flex-column gap-7 gap-lg-10">

					<div class="card card-flush py-4">
						<div class="card-header">
							<div class="card-title">
								<h2>Offers</h2>
							</div>
						</div>

						<div class="card-body pt-0">
							<div class="" data-kt-ecommerce-catalog-add-product="auto-options">

								<div id="kt_ecommerce_add_product_options">

									<div class="form-group">
										<div data-repeater-list="kt_ecommerce_add_product_options"
											class="d-flex flex-column gap-3">

											<div data-repeater-item=""
												class="form-group d-flex flex-wrap align-items-center gap-5">

												<div class="w-100 w-md-200px">Title</div>
												<div class="w-100 w-md-100px">Price</div>
												<div class="w-200 w-md-200px">Duration title</div>
												<div class="w-100 w-md-100px text-right">Duration hours</div>
												<div class="w-50 w-md-50px"></div>

											</div>

											@foreach($product->offers as $offer)

												<div data-repeater-item=""
													class="form-group d-flex flex-wrap align-items-center gap-5">

													<div class="w-100 w-md-200px">
														<input type="text" class="form-control" name="offers[{{ $offer->id }}][name]"
															placeholder="Offer name" value="{{ $offer->name }}" />
													</div>

													<div class="w-100 w-md-100px">
														<input type="text" class="form-control" name="offers[{{ $offer->id }}]['price']"
															placeholder="Offer price" value="{{ $offer->price }}" />
													</div>

													<div class="w-200 w-md-200px">
														<input type="text" class="form-control"
															name="offers[{{ $offer->id }}][meta][duration_title]" placeholder="Offer duration title"
															value="{{ $offer->getMeta('duration') }}" />
													</div>

													<div class="w-100 w-md-100px">
														<input type="text" class="form-control"
															name="offers[{{ $offer->id }}][meta][duration_hours]" placeholder="Offer duration hours"
															value="{{ $offer->getMeta('duration_hours') }}" />
													</div>

													<div class="w-50 w-md-50px">

														<a 
															href="#" 
															class="btn btn-sm fw-bold btn-primary" 
															data-bs-toggle="modal" 
															data-bs-target="#kt_modal_product_offer_{{ $offer->id }}">
															Edit
														</a>

													</div>

												</div>

												@include('dashboard.products.offers.index', ['offer' => $offer])

											@endforeach

										</div>
									</div>

									<div class="form-group mt-5">
										<button type="button" data-repeater-create=""
											class="btn btn-sm btn-light-primary">
											<i class="ki-duotone ki-plus fs-2"></i>Add another offer</button>
									</div>

								</div>

							</div>
						</div>

					</div>

				</div>
			</div>

			<div class="tab-pane fade" id="kt_ecommerce_add_product_extras" role="tab-panel">
				<div class="d-flex flex-column gap-7 gap-lg-10">

					<div class="card card-flush py-4">
						<div class="card-header">
							<div class="card-title">
								<h2>Extras</h2>
							</div>
						</div>

						<div class="card-body pt-0">
							<div class="" data-kt-ecommerce-catalog-add-product="auto-options">

								<div id="kt_ecommerce_add_product_options">

									<div class="form-group">
										<div data-repeater-list="kt_ecommerce_add_product_options"
											class="d-flex flex-column gap-3">

											<div data-repeater-item=""
												class="form-group d-flex flex-wrap align-items-center gap-5">

												<div class="w-100 w-md-200px">Title</div>
												<div class="w-100 w-md-100px">Price</div>
												<div class="w-50 w-md-50px"></div>

											</div>

											@foreach($product->extras as $extra)

												<div data-repeater-item=""
													class="form-group d-flex flex-wrap align-items-center gap-5">

													<div class="w-100 w-md-200px">
														<input type="text" class="form-control" name="offer_name[]"
															placeholder="Offer name" value="{{ $extra->name }}" />
													</div>

													<div class="w-100 w-md-100px">
														<input type="text" class="form-control" name="offer_price[]"
															placeholder="Offer price" value="{{ $extra->price }}" />
													</div>

													<div class="w-50 w-md-50px">
														<button type="button" data-repeater-delete=""
															class="btn btn-sm btn-icon btn-light-danger">
															<i class="ki-duotone ki-cross fs-1">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</button>
													</div>

												</div>

											@endforeach

										</div>
									</div>

									<div class="form-group mt-5">
										<button type="button" data-repeater-create=""
											class="btn btn-sm btn-light-primary">
											<i class="ki-duotone ki-plus fs-2"></i>Add another extra product</button>
									</div>

								</div>

							</div>
						</div>

					</div>

				</div>
			</div>

			<div class="tab-pane fade active" id="kt_ecommerce_add_product_countries" role="tab-panel">
				<div class="d-flex flex-column gap-7 gap-lg-10">

					<div class="card card-flush py-4">
						<div class="card-header">
							<div class="card-title">
								<h2>Attached countries</h2>
							</div>
						</div>

						<div class="card-body pt-0">
							<div class="mb-10 fv-row fv-plugins-icon-container">
								<label class="required form-label">Countries list</label>

								<select multiple class="form-select mb-2" data-control="select2" data-hide-search="true"
									data-placeholder="Select an option" id="kt_ecommerce_add_product_status_select"
									name="countries[]">
									<option></option>

									@foreach($countries as $country)
										<option value="{{ $country->id }}" {{ in_array($country->id, $product->countries->pluck('id')->toArray()) ? 'selected' : '' }}>
											{{ $country->name }}
										</option>
									@endforeach

								</select>

								<div class="text-muted fs-7">Set the product countries.</div>

							</div>

						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="d-flex justify-content-end">

			<a href="apps/ecommerce/catalog/products.html" id="kt_ecommerce_add_product_cancel"
				class="btn btn-light me-5">Cancel</a>
			<button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
				<span class="indicator-label">Save Changes</span>
				<span class="indicator-progress">Please wait...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
			</button>
		</div>

	</div>
</form>


<!-- TinyMCE Editor -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
	tinymce.init({
		selector: '#editor',
		height: 300,
		plugins: 'lists link image code',
		toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image | code',
		menubar: false
	});
</script>

@endsection