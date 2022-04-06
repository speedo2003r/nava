@extends('admin.layout.master')
@section('title',awtTrans('الاعدادات'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('الاعدادات') }}</a>
@endsection
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-md-12">
                <!--begin::Portlet-->
                    <div class="kt-portlet" style="padding-top:15px">
                        <div class="row">
      <div class="col-md-4 col-12">
        <!-- Default box -->
        <div class="card card card-outline card-info">
          <div class="card-body p-0">
            <div class="set-tabs">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="setting-tab" data-toggle="tab" href="#setting" role="tab" aria-controls="setting" aria-selected="true">
                    <img src="{{dashboard_url('presentation.png')}}" alt="">
                    <span>اعدادت التطبيق</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="false">
                    <img src="{{dashboard_url('meeting.png')}}" alt="">
                    <span>مواقع التواصل</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="false">
                    <img src="{{dashboard_url('map-placeholder.png')}}" alt="">
                    <span>اعدادات الخريطة</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile5-tab" data-toggle="tab" href="#profile5" role="tab" aria-controls="profile5" aria-selected="false">
                    <img src="{{dashboard_url('headphone.png')}}" alt="">
                    <span>اعدادات الدعم </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact6-tab" data-toggle="tab" href="#contact6" role="tab" aria-controls="contact6" aria-selected="false">
                    <img src="{{dashboard_url('wallet.png')}}" alt="">
                    <span>اعدادات الدفع </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col-md-8 col-12">
        <!-- Default box -->
        <div class="card card card-outline card-info">
          <div class="card-body p-0">
            <div class="set-tabsContent">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                  <form action="{{route('admin.settings.update')}}" method="post" id="updatesettingForm" class="dropzone" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail2">اسم التطبيق</label>
                        <input type="text" name="keys[site_name]" value="{{settings('site_name')}}" class="form-control" id="exampleInputEmail2" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">البريد الإلكتروني</label>
                        <input type="email" name="keys[email]" value="{{settings('email')}}" class="form-control" id="exampleInputEmail1" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputTax1">الضريبه</label>
                        <input type="number" name="keys[tax]" value="{{settings('tax')}}" class="form-control" id="exampleInputTax1" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputTax1">الحد الأدني للطلب</label>
                        <input type="number" name="keys[mini_order_charge]" value="{{settings('mini_order_charge')}}" class="form-control" id="exampleInputTax1" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputTax1">المدفوع لأقل قيمه للطلب</label>
                        <input type="number" name="keys[mini_order_charge_paid]" value="{{settings('mini_order_charge_paid')}}" class="form-control" id="exampleInputTax1" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputTax1"> قيمه المعاينه</label>
                        <input type="number" name="keys[preview_value]" value="{{settings('preview_value')}}" class="form-control" id="exampleInputTax1" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">واتساب</label>
                        <input type="number" name="keys[whatsapp]" value="{{settings('whatsapp')}}" class="form-control" id="exampleInputPhone1" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">الجوال</label>
                        <input type="number" name="keys[phone]" value="{{settings('phone')}}" class="form-control" id="exampleInputPhone1" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword2">الجوال 2</label>
                        <input type="number" name="keys[phone2]" value="{{settings('phone2')}}" class="form-control" id="exampleInputPhone2" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword2">متجر جوجل</label>
                        <input type="text" name="keys[googleStore]" value="{{settings('googleStore')}}" class="form-control" id="exampleInputPhone2" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword2">متجر أبل</label>
                        <input type="text" name="keys[appleStore]" value="{{settings('appleStore')}}" class="form-control" id="exampleInputPhone2" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword2">الفيديو التعريفي</label>
                        <input type="text" name="keys[into_video]" value="{{settings('into_video')}}" class="form-control" id="exampleInputPhone2" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword2">عدد الطلبات التي يمكن تعيينها للتقني</label>
                        <input type="text" name="keys[techOrderCount]" value="{{settings('techOrderCount')}}" class="form-control" id="exampleInputPhone222" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputMapkey">مفتاح الخريطة</label>
                        <input type="text" name="keys[map_key]" value="{{settings('map_key')}}" class="form-control" id="exampleInputMapkey" placeholder="">
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-success save" style="width:100%">حفظ</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                  <form action="{{route('admin.socials.update')}}" id="settings.updateForm" method="POST" class="dropzone">
                    @csrf
                    <div class="card-body">
                      @foreach($socials as $social)
                      <div class="form-group">
                        <label>{{$social['key']}}</label>
                        <div class="input-group">
                          <input type="url" name="socials[{{$social['key']}}]" value="{{$social['value']}}" class="form-control">
                        </div>
                        <!-- /.input group -->
                      </div>
                      @endforeach
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-success save" style="width:100%">حفظ</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade show" id="location" role="tabpanel" aria-labelledby="location-tab">
                  <form action="{{route('admin.settings.update')}}" id="updatelocationForm" method="POST" class="dropzone">
                    @csrf
                    <div class="card-body">
                      <div class="form-group" style="position: relative;">
                        <input class="controls" id="pac-input" name="pac-input" value="" placeholder="اكتب موقعك" />
                        <input type="hidden" name="keys[lat]" id="lat" value="{{settings('lat')}}" readonly />
                        <input type="hidden" name="keys[lng]" id="lng" value="{{settings('lng')}}" readonly />
                        <div class="col-sm-12 add_map" id="map"></div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-success save" style="width:100%">حفظ</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="profile5" role="tabpanel" aria-labelledby="mail-tab">
                  <form action="{{route('admin.settings.update')}}" id="updateseoForm" method="POST" class="dropzone">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label>النوع</label>
                        <input type="text" name="keys[smtp_type]" value="{{settings('smtp_type')}}" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>اسم المستخدم</label>
                        <input type="text" name="keys[smtp_username]" value="{{settings('smtp_username')}}" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>الرقم السري</label>
                        <input type="text" name="keys[smtp_password]" value="{{settings('smtp_password')}}" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>الايميل المرسل</label>
                        <input type="text" name="keys[smtp_sender_email]" value="{{settings('smtp_sender_email')}}" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>الاسم المرسل</label>
                        <input type="text" name="keys[smtp_sender_name]" value="{{settings('smtp_sender_name')}}" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>البورت</label>
                        <input type="text" name="keys[smtp_port]" value="{{settings('smtp_port')}}" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>الهوست</label>
                        <input type="text" name="keys[smtp_host]" value="{{settings('smtp_host')}}" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>التشفير</label>
                        <input type="text" name="keys[smtp_encryption]" value="{{settings('smtp_encryption')}}" class="form-control" required>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-success save" style="width:100%">حفظ</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="contact6" role="tabpanel" aria-labelledby="mail-tab">
                  <form action="{{route('admin.settings.update')}}" id="updateseoForm" method="POST" class="dropzone">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label>Token Api</label>
                        <input type="text" name="keys[token]" value="{{settings('token')}}" class="form-control" required>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-success save" style="width:100%">حفظ</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
                    </div>
                </div>
            </div>
        </div>
  </div>

<!-- add model -->
<div class="modal fade" id="addModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">اضافة وسيله تواصل</h4>
      </div>
      <form action="{{route('admin.socials.store')}}" method="post" role="form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>مسمي الوسيله</label>
                <input type="text" name="key" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary">{{__('save')}}</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">{{__('close')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>
@push('js')
<script>
  console.log(true);
  $(document).on('click', '.close', function() {
    event.preventDefault();
    var that = $(this);
    var logo = 'remove';
    $.ajax({
      type: "POST",
      url: "{{route('admin.settings.update')}}",
      data: {
        logo: logo,
        _token: '{{csrf_token()}}'
      },
      success: function(msg) {
        $('.upload-area').remove();
      }
    });
  })
</script>

@endpush


@endsection
