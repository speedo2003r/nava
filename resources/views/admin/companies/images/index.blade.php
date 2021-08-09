@extends('admin.layout.master')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>صور ومستندات الشركه</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card page-body">
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
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">صورة الهويه</label>
                        <div class="col-lg-9">
                            <div class = "images-upload-block single-image">
                                <label class = "upload-img">
                                    <input type = "file" name = "_id_avatar" id = "id_avatar" accept = "image/*" class = "image-uploader">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </label>
                                <div class = "upload-area">
                                    <div class="uploaded-block" data-count-order="1">
                                        <a href="{{$provider->company->id_avatar}}" data-fancybox data-caption="{{$provider->company->id_avatar}}"><img src="{{$provider->company->id_avatar}}"></a>
                                        <button class="close">&times;</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                <button type="submit" class="btn btn-primary">{{__('save')}}</button>
            </form>
        </div>
    </section>



@endsection
@push('js')
    <script>

    </script>
@endpush
