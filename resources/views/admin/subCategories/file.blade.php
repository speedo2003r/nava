@extends('admin.layout.master')
@section('content')
    @push('css')
        <style>
            .containerClass .mce-flow-layout {
                white-space: normal;
                display: flex;
                flex-direction: row-reverse;
            }
        </style>

    @endpush

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>العقد</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card page-body">
            <form action="{{route('admin.subcategories.storeUploadFile',$id)}}" method="post">
                @csrf
            <textarea name="contract" class="form-control mytextarea" style="direction: rtl">{{$subCategory['contract']}}</textarea>
            <button type="submit" class="btn btn-primary">حفظ</button>
            </form>
        </div>
    </section>

@endsection
