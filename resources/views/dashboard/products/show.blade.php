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
									<textarea name="description" id="editor" class="form-control"
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

					<!--begin::Pricing-->
					<div class="card card-flush py-4">
						<!--begin::Card header-->
						<div class="card-header">
							<div class="card-title">
								<h2>Pricing</h2>
							</div>
						</div>

						<div class="card-body pt-0">
							<!--begin::Input group-->
							<div class="mb-10 fv-row fv-plugins-icon-container">
								<!--begin::Label-->
								<label class="required form-label">Base Price</label>
								<input type="text" name="price" class="form-control mb-2" placeholder="Product price"
									value="{{ $product->price }}" name="price">
								<div class="text-muted fs-7">Set the product price.</div>
								<div
									class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
								</div>
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="fs-6 fw-semibold mb-2">Discount Type
									<span class="ms-1" data-bs-toggle="tooltip"
										aria-label="Select a discount type that will be applied to this product"
										data-bs-original-title="Select a discount type that will be applied to this product"
										data-kt-initialized="1">
										<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
										</i>
									</span></label>
								<!--End::Label-->
								<!--begin::Row-->
								<div class="row row-cols-1 row-cols-md-3 row-cols-lg-1 row-cols-xl-3 g-9"
									data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']"
									data-kt-initialized="1">
									<!--begin::Col-->
									<div class="col">
										<!--begin::Option-->
										<label
											class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 active"
											data-kt-button="true">
											<!--begin::Radio-->
											<span
												class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
												<input class="form-check-input" type="radio" name="discount_option"
													value="1">
											</span>
											<!--end::Radio-->
											<!--begin::Info-->
											<span class="ms-5">
												<span class="fs-4 fw-bold text-gray-800 d-block">No Discount</span>
											</span>
											<!--end::Info-->
										</label>
										<!--end::Option-->
									</div>

									<div class="col">
										<!--begin::Option-->
										<label
											class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
											data-kt-button="true">
											<!--begin::Radio-->
											<span
												class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
												<input class="form-check-input" type="radio" name="discount_option"
													value="2" checked="checked">
											</span>
											<!--end::Radio-->
											<!--begin::Info-->
											<span class="ms-5">
												<span class="fs-4 fw-bold text-gray-800 d-block">Percentage %</span>
											</span>
											<!--end::Info-->
										</label>
										<!--end::Option-->
									</div>

									<div class="col">
										<label
											class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
											data-kt-button="true">
											<span
												class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
												<input class="form-check-input" type="radio" name="discount_option"
													value="3">
											</span>
											<span class="ms-5">
												<span class="fs-4 fw-bold text-gray-800 d-block">Fixed Price</span>
											</span>
										</label>
									</div>

								</div>
								<!--end::Row-->
							</div>

							<div class="mb-10 fv-row d-none" id="kt_ecommerce_add_product_discount_percentage">
								<!--begin::Label-->
								<label class="form-label">Set Discount Percentage</label>
								<!--end::Label-->
								<!--begin::Slider-->
								<div class="d-flex flex-column text-center mb-5">
									<div class="d-flex align-items-start justify-content-center mb-7">
										<span class="fw-bold fs-3x"
											id="kt_ecommerce_add_product_discount_label">10</span>
										<span class="fw-bold fs-4 mt-1 ms-2">%</span>
									</div>
									<div id="kt_ecommerce_add_product_discount_slider"
										class="noUi-sm noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr">
										<div class="noUi-base">
											<div class="noUi-connects"></div>
											<div class="noUi-origin"
												style="transform: translate(-90.9091%, 0px); z-index: 4;">
												<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0"
													role="slider" aria-orientation="horizontal" aria-valuemin="1.0"
													aria-valuemax="100.0" aria-valuenow="10.0" aria-valuetext="10.00">
													<div class="noUi-touch-area"></div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="text-muted fs-7">Set a percentage discount to be applied on this product.
								</div>

							</div>

							<div class="mb-10 fv-row d-none" id="kt_ecommerce_add_product_discount_fixed">
								<!--begin::Label-->
								<label class="form-label">Fixed Discounted Price</label>
								<input type="text" name="dicsounted_price" class="form-control mb-2"
									placeholder="Discounted price">

								<div class="text-muted fs-7">Set the discounted product price. The product will be
									reduced at the determined fixed price</div>
								<!--end::Description-->
							</div>

							<div class="d-flex flex-wrap gap-5">
								<!--begin::Input group-->
								<div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
									<!--begin::Label-->
									<label class="required form-label">Tax Class</label>

									<select class="form-select mb-2 select2-hidden-accessible" name="tax"
										data-control="select2" data-hide-search="true"
										data-placeholder="Select an option" data-select2-id="select2-data-15-jvx0"
										tabindex="-1" aria-hidden="true" data-kt-initialized="1">
										<option></option>
										<option value="0">Tax Free</option>
										<option value="1" selected="selected" data-select2-id="select2-data-17-78w5">
											Taxable Goods</option>
										<option value="2">Downloadable Product</option>
									</select>

									<div class="text-muted fs-7">Set the product tax class.</div>
									<!--end::Description-->
									<div
										class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
									</div>
								</div>

								<div class="fv-row w-100 flex-md-root">
									<label class="form-label">VAT Amount (%)</label>
									<input type="text" class="form-control mb-2" value="35">
									<div class="text-muted fs-7">Set the product VAT about.</div>
								</div>
								<!--end::Input group-->
							</div>
							<!--end:Tax-->
						</div>

					</div>
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