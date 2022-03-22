@extends('admin.layout.master')

@section('content')

    <div class="col-lg-3 col-xs-6">
        <div class="small-box smallBoxCustom bg-brown-400">
            <div class="inner">
                @php $Users = App\User::where('acc_type','admin')->count(); @endphp
                <h3>{{$Users}}</h3>
                <p> عدد المديرين </p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="{{route('users')}}" class="small-box-footer">الذهاب <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box smallBoxCustom bg-brown-400">
            <div class="inner">
                @php $clients = App\User::where('acc_type','client')->count(); @endphp
                <h3>{{$clients}}</h3>
                <p> عدد العملاء </p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="{{route('clients')}}" class="small-box-footer">الذهاب <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box smallBoxCustom bg-brown-400">
            <div class="inner">
                @php $sellerusers = App\User::where('acc_type','seller')->count(); @endphp
                <h3>{{$sellerusers}}</h3>
                <p> عدد البائعين </p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="{{route('sellers')}}" class="small-box-footer">الذهاب <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box smallBoxCustom bg-brown-400">
            <div class="inner">
                @php $delegateusers = App\User::where('acc_type','delegate')->whereHas('delegate')->count(); @endphp
                <h3>{{$delegateusers}}</h3>
                <p> عدد المندوبين </p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="{{route('delegates')}}" class="small-box-footer">الذهاب <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box smallBoxCustom bg-brown-400">
            <div class="inner">
                @php $categories = App\Models\Category::where('category_id',null)->count(); @endphp
                <h3>{{$categories}}</h3>
                <p> عدد الأقسام الرئيسيه </p>
            </div>
            <div class="icon">
                <i class="fa fa-tags"></i>
            </div>
            <a href="{{route('admin.categories')}}" class="small-box-footer">الذهاب <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box smallBoxCustom bg-brown-400">
            <div class="inner">
                @php $subcategories = App\Models\Category::where('category_id','!=',null)->count(); @endphp
                <h3>{{$subcategories}}</h3>
                <p> عدد الأقسام الفرعيه </p>
            </div>
            <div class="icon">
                <i class="fa fa-tags"></i>
            </div>
            <a href="{{route('admin.categories')}}" class="small-box-footer">الذهاب <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box smallBoxCustom bg-brown-400">
            <div class="inner">
                @php $sliders = App\Models\Slider::where('status',1)->where('user_id','!=',null)->count(); @endphp
                <h3>{{$sliders}}</h3>
                <p> عدد البنرات المتحركه المفعله </p>
            </div>
            <div class="icon">
                <i class="fa fa-star"></i>
            </div>
            <a href="{{route('admin.sliders')}}" class="small-box-footer">الذهاب <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box smallBoxCustom bg-brown-400">
            <div class="inner">
                @php $offers = App\Models\Offer::where('status',1)->where('user_id','!=',null)->count(); @endphp
                <h3>{{$offers}}</h3>
                <p> عدد العروض المفعله </p>
            </div>
            <div class="icon">
                <i class="fa fa-star"></i>
            </div>
            <a href="{{route('admin.offers')}}" class="small-box-footer">الذهاب <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box smallBoxCustom bg-brown-400">
            <div class="inner">
                @php $items = App\Models\Item::count(); @endphp
                <h3>{{$items}}</h3>
                <p> عدد المنتجات </p>
            </div>
            <div class="icon">
                <i class="fa fa-star"></i>
            </div>
            <a href="{{route('getitems')}}" class="small-box-footer">الذهاب <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box smallBoxCustom bg-brown-400">
            <div class="inner">
                @php $orders = App\Models\Order::where('status','!=',0)->count(); @endphp
                <h3>{{$orders}}</h3>
                <p> عدد الطلبات </p>
            </div>
            <div class="icon">
                <i class="fa fa-star"></i>
            </div>
            <a href="{{route('admin.orders')}}" class="small-box-footer">الذهاب <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box smallBoxCustom bg-brown-400">
            <div class="inner">
                @php $countries = App\Models\Country::count(); @endphp
                <h3>{{$countries}}</h3>
                <p> عدد الدول </p>
            </div>
            <div class="icon">
                <i class="fa fa-flag"></i>
            </div>
            <a href="{{route('getcountries')}}" class="small-box-footer">الذهاب <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box smallBoxCustom bg-brown-400">
            <div class="inner">
                @php $cities = App\Models\City::count(); @endphp
                <h3>{{$cities}}</h3>
                <p> عدد المدن </p>
            </div>
            <div class="icon">
                <i class="fa fa-flag"></i>
            </div>
            <a href="{{route('getcity')}}" class="small-box-footer">الذهاب <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>

@endsection
