@php
     $notification = getNotification(Auth::user()->id);
     $nt_count = $notification->count();
@endphp
<header class="header header-sticky">
    <div class="container-fluid">
        {{--<a class="header-brand d-none d-md-flex" href="{{route('admin.dashboard')}}">
            <img height="46" src="{{asset('assets/coreui/assets/img/logo-naro.png')}}" alt="logo">
        </a>--}}
        <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-menu')}}"></use>
            </svg>
        </button>
        {{--<ul class="header-nav d-none d-md-flex">
            <li class="nav-item"><a class="nav-link" href="{{route('dashboard')}}">ড্যাশবোর্ড</a></li>
        </ul>--}}
        {{--<ul class="header-nav ms-auto">
            <div class="switch">
                <input id="language-toggle" class="check-toggle check-toggle-round-flat" type="checkbox">
                <label for="language-toggle"></label>
                <span class="on">BN</span>
                <span class="off">EN</span>
            </div>
        </ul>--}}

        <ul class="header-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#"  aria-haspopup="true" aria-expanded="false">
                    <span class="flag-icon flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span> {{ Config::get('languages')[App::getLocale()]['display'] }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @foreach (Config::get('languages') as $lang => $language)
                        @if ($lang != App::getLocale())
                            <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"><span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span> {{$language['display']}}</a>
                        @endif
                    @endforeach
                </div>
            </li>
        </ul>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown d-md-down-none"><a  data-user_id="{{ Auth::user()->id }}"  class="nav-link" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
                    <svg class="icon icon-lg my-1 mx-2">
                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-bell')}}"></use>
                    </svg>
                     <span class="badge rounded-pill position-absolute top-0 end-0 bg-danger-gradient text-white" style="background: #be1616; ">{{$unseens->count()}}</span>
                   {{-- <span class="badge rounded-pill position-absolute top-0 end-0 bg-danger-gradient text-white" style="background: #be1616; ">{{ $nt_count }}</span> --}}
                    <span class="badge rounded-pill position-absolute top-0 end-0 bg-danger-gradient text-white" id="not_counter" style="background: #be1616; ">{{ $nt_count }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg scrollable-menu pt-0 " style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-151px, 50px);" data-popper-placement="bottom-end">
                    <div class="dropdown-header bg-light"><strong>You have {{ $unseens->count()}} unseen notifications</strong></div>
                     @foreach($notices as $notice)
                        <form action="{{ route('admin.notices.seen', $notice->id) }}" method="post">
                            @csrf
                            @method("PUT")
                            @if($notice->status == 0)
                            <button class="dropdown-item text-dark"><strong>{{\Illuminate\Support\Str::limit($notice->title, 40)}}</strong></button>
                            @else
                                <button class="dropdown-item text-dark"><span>{{\Illuminate\Support\Str::limit($notice->title, 40)}}</span></button>
                            @endif
                        </form>
                    @endforeach
                    {{-- @if ($nt_count > 0)
                        <div class="notification-box">
                            @foreach ($notification as $nt)
                                <div class="dropdown-header bg-light notification_id{{ $nt->id }}" style="border-bottom: 1px solid #ccc;">
                                    <strong>{{ $nt->body }}</strong>
                                    <a id="notification-clear" data-notification_id="{{ $nt->id }}" data-user_id="{{ Auth::user()->id }}"><i class="fa fa-times"></i></a>
                                </div>
                            @endforeach
                        </div>


                    @else
                    <div class="dropdown-header bg-light" style="border-bottom: 1px solid #ccc;"><strong>0 Unseen notification</strong></div>
                    @endif --}}


                </div>
            </li>
        </ul>


        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">

                    <span class="" style="display: inline-block">
                        <span class="user-name">{{ Auth::user()->name ?? '' }}</span>
                        <span class="user-possition" style="font-size: 12px; ">
                            @if(!empty(Auth::user()->getRoleNames()))
                                @foreach(Auth::user()->getRoleNames() as $v)
                                    <span class="small" style="display: block">{{ $v }}</span>
                                @endforeach
                            @endif
                        </span>
                    </span>
                    <div class="avatar avatar-md" style="vertical-align: unset !important;">
                        <img class="avatar-img" src="{{(!empty(auth()->user()->avatar))? asset(auth()->user()->avatar) : asset('assets/coreui/assets/img/avatars/8.jpg')}}" alt="image">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">{{__('messages.সেটিংস')}}</div>
                    </div>
                    <a class="dropdown-item" href="{{route('admin.profile')}}">
                        <svg class="icon me-2">
                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-user')}}"></use>
                        </svg> {{__('messages.প্রোফাইল')}}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{url('/clear-cache')}}">
                        <svg class="icon me-2">
                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-clear-all')}}"></use>
                        </svg> {{__('messages.ক্লিয়ার ক্যাশ')}}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <svg class="icon me-2">
                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-account-logout')}}"></use>
                        </svg>
                        {{ __('messages.লগআউট') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>

            </li>
        </ul>
    </div>
</header>
