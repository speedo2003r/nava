<!DOCTYPE html>
<html>
<head>
    <title></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
</head>
<style>
    body {
        font-family: 'dejavu sans', sans-serif;
        direction:rtl;
        text-align:right;
        padding:0;
        margin: 0;
    }
    table tr td{
        padding: 10px 20px;
        text-align: center;
        border: 1px solid #333;
    }
</style>
<body>
<table style="width: 100%;">
    <tr>
        <td>رقم الطلب</td>
        <td>النوع</td>
        <td>المضاف</td>
        <td>المخصوم</td>
        <td>رصيد</td>
    </tr>
    @foreach($data as $d)
    <tr>
        <td>{{$d->order_num}}</td>
        <td>{{$d->category ? $d->category['title'] : ''}}</td>
        <td>{{$d->income ? $d->income['income'] : 0}} {{trans('api.SAR')}}</td>
        <td>{{count($d->userDeductions) > 0 ? $d->userDeductions()->sum('balance') : 0}} {{trans('api.SAR')}}</td>
        <td>{{$d->income['income'] - $d->userDeductions()->sum('balance')}} {{trans('api.SAR')}}</td>
    </tr>
    @endforeach
</table>

<div class="clearfix"></div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</body>
</html>
