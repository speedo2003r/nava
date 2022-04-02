@extends('admin.layout.master')
@section('title',awtTrans('صور ومستندات الشركه'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(),$provider['id']) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('صور ومستندات الشركه') }}</a>
@endsection
@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__body kt-portlet__body--fit">

                    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

                        <div class="kt-portlet__head kt-portlet__head--lg p-0">
                            <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                    <img style="width: 25px" alt="icon" src="{{asset('assets/media/menuicon/document.svg')}}" />
                    </span>
                                <h3 class="kt-portlet__head-title">
                                    {{awtTrans('صور ومستندات الشركه')}}
                                </h3>
                            </div>
                        </div>
                            <form action="{{route('admin.companies.storeImages',$provider['id'])}}" method="post" role="form" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-lg-3 control-label">سجل الشركه</label>
                                    <div class="col-lg-9">
                                        <div class = "images-upload-block single-image">
                                            <label class = "upload-img">
                                                <input type = "file" name = "_commercial_image" id = "commercial_image" accept = "image/*" class = "image-uploader">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </label>
                                            <div class = "upload-area">
                                                <div class="uploaded-block" data-count-order="1">
                                                    <a href="{{$provider->company->commercial_image}}" data-fancybox data-caption="{{$provider->company->commercial_image}}"><img src="{{$provider->company->commercial_image}}"></a>
                                                    <button class="close">&times;</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 control-label">الشهاده الضريبيه</label>
                                    <div class="col-lg-9">
                                        <div class = "images-upload-block single-image">
                                            <label class = "upload-img">
                                                <input type = "file" name = "_tax_certificate" id = "tax_certificate" accept = "image/*" class = "image-uploader">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </label>
                                            <div class = "upload-area">
                                                <div class="uploaded-block" data-count-order="1">
                                                    <a href="{{$provider->company->tax_certificate}}" data-fancybox data-caption="{{$provider->company->tax_certificate}}"><img src="{{$provider->company->tax_certificate}}"></a>
                                                    <button class="close">&times;</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{__('save')}}</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@push('js')
    <script>

    </script>
@endpush
