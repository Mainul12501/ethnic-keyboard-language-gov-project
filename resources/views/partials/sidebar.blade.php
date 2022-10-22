<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">

        <div class="sidebar-brand-full" >

        </div>
        <div class="sidebar-brand-narrow" >

        </div>
       
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <li class="nav-item "><a class="nav-link" href="{{route('admin.dashboard')}}">
                <svg class="nav-icon">
                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-speedometer')}}"></use>
                </svg>{{__('messages.ড্যাশবোর্ড')}} </a>
        </li>
        @can('Linguist-List')
            <li class="nav-group "><a class="nav-link nav-group-toggle" href="#">
                    <svg class="nav-icon">
                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-language')}}"></use>
                    </svg>{{__('ভাষা(সেটিং)')}} </a>
                <ul class="nav-group-items">
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.languages.index')}}"> {{__('messages.ভাষা')}} </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.directeds.index')}}">{{__('messages.নির্দেশিত')}}  </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.spontaneouses.index')}}">{{__('messages.স্বতঃস্ফূর্ত')}}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.language_assigns.index')}}">{{__('messages.ভাষা অ্যাসাইন')}}  </a></li>
                </ul>
            </li>
        @endcan

        @can('Group-List')
            <li class="nav-group "><a class="nav-link nav-group-toggle" href="#">
                    <svg class="nav-icon">
                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-group')}}"></use>
                    </svg>{{__('কর্মকর্তাগণ')}} </a>
                <ul class="nav-group-items">
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.groups.index')}}">{{__('messages.গ্রুপ')}} </a></li>
                    {{--<li class="nav-item"><a class="nav-link" href="{{route('admin.speakers.index')}}"> স্পিকার</a></li>--}}
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.managers.index')}}">{{__('messages.ম্যানেজার')}} </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.supervisors.index')}}">{{__('messages.সুপারভাইজর')}} </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.data_collectors.index')}}">{{__('messages.ডাটা কালেক্টর')}} </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.guides.index')}}">{{__('messages.গাইড')}} </a></li>
                </ul>
            </li>
        @endcan
        @can('Assign-Task-To-Data-Collector')

            <li class="nav-group "><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-group')}}"></use>
                </svg>{{__('messages.টাস্ক অ্যাসাইন')}} </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{route('admin.task_assigns.index')}}">{{__('messages.ডাটা কালেক্টর')}} </a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('admin.linguist_task_assigns.index')}}">{{__('messages.ভাষাবিদ')}} </a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('admin.validator_task_assigns.index')}}">{{__('messages.যাচাইকারী')}} </a></li>

            </ul>
        </li>
        @endcan
        @can('Data-Collection-List')
        <li class="nav-group "><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-group')}}"></use>
            </svg>{{__('ডাটা সংগ্রহ')}} </a>
            <ul class="nav-group-items">
                {{-- <li class="nav-item"><a class="nav-link" href="{{route('admin.task-assign.language.list')}}">{{__('অর্পিত')}} </a></li> --}}
                {{--<li class="nav-item"><a class="nav-link" href="{{route('admin.speakers.index')}}"> স্পিকার</a></li>--}}
                <li class="nav-item"><a class="nav-link" href="{{route('admin.data_collections.index')}}">{{__('সংগৃহীত')}} </a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('admin.data_collections.userapproval.list')}}">{{__('অনুমোদিত')}} </a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('admin.user_wise_data_collection.correction')}}">{{__('সংশোধনী')}} </a></li>
                {{-- <li class="nav-item"><a class="nav-link" href="{{route('admin.guides.index')}}">{{__('messages.গাইড')}} </a></li> --}}
            </ul>
        </li>
        @endcan
        @can('Data-Collection-List')
        {{--<li class="nav-item"><a class="nav-link" href="{{route('admin.data_collections.index')}}">
                <svg class="nav-icon">
                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-hand-point-up')}}"></use>
                </svg>{{__('messages.তথ্য সংগ্রহ')}} </a>
        </li>--}}

        {{-- <li class="nav-group "><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-hand-point-up')}}"></use>
                </svg>{{__('messages.তথ্য সংগ্রহ')}} </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{route('admin.data_collections.index')}}">{{__('messages.সব তথ্য')}} </a></li>
                @if(Auth::user()->user_type == 4)
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.data_collection.correction')}}"><span class="blink_me">{{__('messages.সংশোধন')}}</span> </a></li>
                @endif
                @if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2 || Auth::user()->user_type == null )
                <li class="nav-item"><a class="nav-link" href="{{route('admin.data_collections.pending.list')}}">{{__('messages.বিচারাধীন')}} </a></li>
                @endif

                @if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2 || Auth::user()->user_type == null )
                <li class="nav-item"><a class="nav-link" href="{{route('admin.speaker')}}">{{__('messages.অনুমোদিত ডাটা')}} </a></li>
                @endif
                @if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2 || Auth::user()->user_type == null )
                <li class="nav-item"><a class="nav-link" href="{{route('admin.data_collections.userapproval.list')}}">{{__('messages.অনুমোদিত ডাটা')}} </a></li>
                @endif
            </ul>


        </li> --}}
        @if(Auth::user()->user_type == 4 || Auth::user()->user_type == 2 || Auth::user()->user_type == null )
        <li class="nav-item"><a class="nav-link" href="{{route('admin.speakers.index')}}">
            <svg class="nav-icon">
                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-audio-spectrum')}}"></use>
            </svg>{{__('messages.স্পিকার')}} </a></a>
        </li>
        @endif
        @if(Auth::user()->user_type == 4 || Auth::user()->user_type == 2 || Auth::user()->user_type == null )
        <li class="nav-item"><a class="nav-link" href="{{route('admin.languageList')}}">
            {{-- <svg class="nav-icon">
                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-audio-spectrum')}}"></use>
            </svg> --}}
            <i class="fa-solid fa-language nav-icon"></i>
            {{__('messages.অর্পিত ভাষা')}} </a></a>
        </li>
        @endif
        @if(Auth::user()->user_type == 4)
        <li class="nav-item"><a class="nav-link" href="{{route('admin.viewTable')}}">
            {{-- <svg class="nav-icon">
                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-audio-spectrum')}}"></use>
            </svg> --}}
            {{-- <i class="fa-solid fa-language nav-icon"></i> --}}
            <i class="fa-solid fa-person-dots-from-line  nav-icon"></i>
            {{__('সমগ্র ডাটা')}} </a></a>
        </li>
        @endif
        @if(Auth::user()->user_type == 4 || Auth::user()->user_type == 2 || Auth::user()->user_type == null )
        <li class="nav-item"><a class="nav-link" href="{{route('admin.data_collections.userapproval.list')}}">
            {{-- <svg class="nav-icon">
                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-audio-spectrum')}}"></use>
            </svg> --}}
            <i class="fa-solid fa-check-double nav-icon"></i>
            {{__('messages.অনুমোদিত ডাটা')}} </a></a>
        </li>
        @endif
    @endcan
        @can('Speech-Trimming')
            {{-- <li class="nav-item"><a class="nav-link" href="{{ route('get-trim-audios') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-audio-spectrum')}}"></use>
                    </svg>{{__('messages.স্পিচ ট্রিমিং')}} </a>
            </li> --}}
        @endcan
        {{-- <li class="nav-item"><a class="nav-link" href="index.html">
                <svg class="nav-icon">
                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-clipboard')}}"></use>
                </svg> ডেটাসেট</a>
        </li> --}}
        @can('Notice')
            <li class="nav-item"><a class="nav-link" href="{{route('admin.notices.index')}}">
                    <svg class="nav-icon">
                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-bullhorn')}}"></use>
                    </svg>{{__('messages.বিজ্ঞপ্তি')}} </a>
            </li>
        @endcan
        {{-- @can('Add-Location')
         <li class="nav-group "><a class="nav-link nav-group-toggle" href="#">
                 <svg class="nav-icon">
                     <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-language')}}"></use>
                 </svg>{{__('messages.অন্যান্য')}}</a>
             <ul class="nav-group-items">
                 <li class="nav-item"><a class="nav-link" href="{{route('admin.districts.index')}}">{{__('messages.জেলা')}}</a></li>
                 <li class="nav-item"><a class="nav-link" href="{{route('admin.upazilas.index')}}">{{__('messages.উপজেলা')}}</a></li>
                 <li class="nav-item"><a class="nav-link" href="{{route('admin.unions.index')}}">{{__('messages.ইউনিয়ন')}} </a></li>
                 <li class="nav-item"><a class="nav-link" href="{{route('admin.villages.index')}}"> {{__('messages.গ্রাম')}}</a></li>
             </ul>
         </li>
         @endcan--}}
        @can('user-list')
            <li class="nav-group "><a class="nav-link nav-group-toggle" href="#">
                    <svg class="nav-icon">
                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-settings')}}"></use>
                    </svg>{{__('messages.সেটিংস')}} </a>
                <ul class="nav-group-items">

                    <li class="nav-item"><a class="nav-link" href="{{route('admin.users.index')}}">{{__('messages.ইউজার')}}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.roles.index')}}">{{__('messages.রোল এ্যান্ড পারমিশন')}} </a></li>
                    @can('Add-Location')
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.districts.index')}}">{{__('messages.জেলা')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.upazilas.index')}}">{{__('messages.উপজেলা')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.unions.index')}}">{{__('messages.ইউনিয়ন')}} </a></li>
                        {{--<li class="nav-item"><a class="nav-link" href="{{route('admin.villages.index')}}"> {{__('messages.গ্রাম')}}</a></li>--}}
                    @endcan
                    {{-- <li class="nav-item"><a class="nav-link" href="{{route('admin.permissions.index')}}"> পারমিশন</a></li> --}}

                    {{-- <li class="nav-item"><a class="nav-link" href="#"> ব্যবহারকারী</a></li>
                     <li class="nav-item"><a class="nav-link" href="#"> ভূমিকা এবং অনুমতি</a></li>
                     <li class="nav-item"><a class="nav-link" href="#"> প্রজ্ঞাপন</a></li>
                     <li class="nav-item"><a class="nav-link" href="#"> ব্যাকআপ</a></li>--}}
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.activity.log')}}">{{__('messages.অ্যাক্টিভিটি লগ')}}</a></li>
                </ul>
            </li>
        @endcan

    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
