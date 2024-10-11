@extends('admin.layouts.app')

@section('content')

<form id="kt_ecommerce_add_product_form"
	class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework"
	data-kt-redirect="apps/ecommerce/catalog/products.html" data-select2-id="select2-data-kt_ecommerce_add_product_form"
	method="POST" action="{{ route('admin.products.update', $product->id) }}">

	@csrf

	<div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10"
		data-select2-id="select2-data-130-l6c6">

		<div class="card card-flush py-4">
			<div class="card-header">
				<div class="card-title">
					<h2>Status</h2>
				</div>
				<div class="card-toolbar">
					<div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
				</div>
			</div>

			<div class="card-body pt-0">

				<select class="form-select mb-2" data-control="select2" data-hide-search="true"
					data-placeholder="Select an option" id="kt_ecommerce_add_product_status_select"
					name="status">
					<option></option>
					<option value="published" selected="selected">Published</option>
					<option value="draft">Draft</option>
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
						<!--end::Card header-->
						<!--begin::Card body-->
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
								<div id="kt_ecommerce_add_product_description"
									name="kt_ecommerce_add_product_description" class="min-h-200px mb-2"></div>
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
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body pt-0">
							<!--begin::Input group-->
							<div class="mb-10 fv-row fv-plugins-icon-container">
								<!--begin::Label-->
								<label class="required form-label">Base Price</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input type="text" name="price" class="form-control mb-2" placeholder="Product price"
									value="{{ $product->price }}"
									name="price">
								<!--end::Input-->
								<!--begin::Description-->
								<div class="text-muted fs-7">Set the product price.</div>
								<!--end::Description-->
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
									<!--end::Col-->
									<!--begin::Col-->
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
									<!--end::Col-->
									<!--begin::Col-->
									<div class="col">
										<!--begin::Option-->
										<label
											class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
											data-kt-button="true">
											<!--begin::Radio-->
											<span
												class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
												<input class="form-check-input" type="radio" name="discount_option"
													value="3">
											</span>
											<!--end::Radio-->
											<!--begin::Info-->
											<span class="ms-5">
												<span class="fs-4 fw-bold text-gray-800 d-block">Fixed Price</span>
											</span>
											<!--end::Info-->
										</label>
										<!--end::Option-->
									</div>
									<!--end::Col-->
								</div>
								<!--end::Row-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
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
								<!--end::Slider-->
								<!--begin::Description-->
								<div class="text-muted fs-7">Set a percentage discount to be applied on this product.
								</div>
								<!--end::Description-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="mb-10 fv-row d-none" id="kt_ecommerce_add_product_discount_fixed">
								<!--begin::Label-->
								<label class="form-label">Fixed Discounted Price</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input type="text" name="dicsounted_price" class="form-control mb-2"
									placeholder="Discounted price">
								<!--end::Input-->
								<!--begin::Description-->
								<div class="text-muted fs-7">Set the discounted product price. The product will be
									reduced at the determined fixed price</div>
								<!--end::Description-->
							</div>
							<!--end::Input group-->
							<!--begin::Tax-->
							<div class="d-flex flex-wrap gap-5">
								<!--begin::Input group-->
								<div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
									<!--begin::Label-->
									<label class="required form-label">Tax Class</label>
									<!--end::Label-->
									<!--begin::Select2-->
									<select class="form-select mb-2 select2-hidden-accessible" name="tax"
										data-control="select2" data-hide-search="true"
										data-placeholder="Select an option" data-select2-id="select2-data-15-jvx0"
										tabindex="-1" aria-hidden="true" data-kt-initialized="1">
										<option></option>
										<option value="0">Tax Free</option>
										<option value="1" selected="selected" data-select2-id="select2-data-17-78w5">
											Taxable Goods</option>
										<option value="2">Downloadable Product</option>
									</select><span class="select2 select2-container select2-container--bootstrap5"
										dir="ltr" data-select2-id="select2-data-16-36yp" style="width: 100%;"><span
											class="selection"><span
												class="select2-selection select2-selection--single form-select mb-2"
												role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
												aria-disabled="false" aria-labelledby="select2-tax-54-container"
												aria-controls="select2-tax-54-container"><span
													class="select2-selection__rendered" id="select2-tax-54-container"
													role="textbox" aria-readonly="true" title="Taxable Goods">Taxable
													Goods</span><span class="select2-selection__arrow"
													role="presentation"><b
														role="presentation"></b></span></span></span><span
											class="dropdown-wrapper" aria-hidden="true"></span></span>
									<!--end::Select2-->
									<!--begin::Description-->
									<div class="text-muted fs-7">Set the product tax class.</div>
									<!--end::Description-->
									<div
										class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
									</div>
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="fv-row w-100 flex-md-root">
									<!--begin::Label-->
									<label class="form-label">VAT Amount (%)</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control mb-2" value="35">
									<!--end::Input-->
									<!--begin::Description-->
									<div class="text-muted fs-7">Set the product VAT about.</div>
									<!--end::Description-->
								</div>
								<!--end::Input group-->
							</div>
							<!--end:Tax-->
						</div>
						<!--end::Card header-->
					</div>
					<!--end::Pricing-->
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
										<option value="{{ $country->id }}" {{ in_array($country->id, $product->countries->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $country->name }}</option>
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

@endsection