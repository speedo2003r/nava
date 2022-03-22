<ul class="nav nav-tabs mb-5" >
    @foreach(\App\Entities\Lang::all() as $key => $locale)
    <li><a class="btn btn-default @if($locale['lang'] == 'ar') active @endif ml-2" href="#locale-tab-{{$locale['lang']}}" data-toggle="tab">{{$locale['name']}}</a></li>
    @endforeach
</ul>
