
<!-- begin:: Header Topbar -->
<div class="kt-header__topbar">
    <div class="kt-header__topbar-item kt-header__topbar-item--langs">
        <a href="{{route('admin.notifications')}}" class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                <a href="{{route('admin.notifications')}}" class="kt-header__topbar-icon position-relative">
                    <span class="notify-count">{{auth()->user()->unreadnotifications()->count()}}</span>
                    <i class="fa fa-bell"></i>
                </a>
        </a>
    </div>
    <div class="kt-header__topbar-item kt-header__topbar-item--langs">
        <a href="{{route('admin.chats.messagesNotifications')}}" class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
            <a href="{{route('admin.chats.messagesNotifications')}}" class="kt-header__topbar-icon position-relative">
                <span class="messages-count">{{\App\Models\Message_notification::whereRaw('created_at IN (select MAX(created_at) FROM message_notifications GROUP BY room_id)')->where('is_seen',0)->where('is_sender',0)->where('user_id',auth()->id())->count()}}</span>
                <i class="fa fa-comments-o"></i>
            </a>
        </a>
    </div>
    <div class="kt-header__topbar-item kt-header__topbar-item--langs">
        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                <span class="kt-header__topbar-icon">
                                    <img class="" src="{{dashboard_url('assets/media/flag-400.png')}}" alt="">
                                </span>
        </div>
        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround">
            <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
                @foreach($langs as $locale)
                    <li class="kt-nav__item">
                        <a href="{{route('change.language',$locale['lang'])}}" class="kt-nav__link">
                            <span class="kt-nav__link-text">{{$locale['name']}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!--begin: User Bar -->
    <div class="kt-header__topbar-item kt-header__topbar-item--user">
        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
            <div class="kt-header__topbar-user">
                <span class="kt-header__topbar-welcome kt-hidden-mobile">{{awtTrans('مرحبا')}}</span>
                <span class="kt-header__topbar-username kt-hidden-mobile">{{auth()->user()->name}}</span>
                <img class="kt-hidden" alt="Pic" src="{{asset('assets/media/users/300_25.jpg')}}" />
                <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"><img class=" " alt="Pic" src="{{asset('images/avatarDefault.png')}}" /></span>
            </div>
        </div>
        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
            <!--begin: Head -->
            <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url({{asset('assets/media/misc/bg-1.jpg')}})">
                <div class="kt-user-card__avatar">
                    <img class="kt-hidden" alt="Pic" src="{{asset('assets/media/users/300_25.jpg')}}" />
                    <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                    <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success"><img class=" " alt="Pic" src="{{asset('images/avatarDefault.png')}}" /></span>
                </div>
                <div class="kt-user-card__name">
                    {{auth()->user()->name}}
                </div>
            </div>
            <!--end: Head -->
            <!--begin: Navigation -->
            <div class="kt-notification">
                <a href="{{route('admin.settings.index')}}" class="kt-notification__item">
                    <div class="kt-notification__item-icon">
                        <i class="flaticon2-calendar-3 kt-font-success"></i>
                    </div>
                    <div class="kt-notification__item-details">
                        <div class="kt-notification__item-title kt-font-bold">
                            {{awtTrans('الاعدادات')}}
                        </div>
                    </div>
                </a>
                <div class="kt-notification__custom kt-space-between" style="float:left">
                    <a style="line-height: 30px" href="{{ url('/logout') }}" class="btn btn-label btn-label-brand btn-sm btn-bold">{{awtTrans('تسجيل الخروج')}}</a>
                </div>
            </div>
            <!--end: Navigation -->
        </div>
    </div>
    <!--end: User Bar -->
</div>
<!-- end:: Header Topbar -->
