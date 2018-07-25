@if(Auth::user()->access_id == 1)
<ul class="nav" id="side-menu">
    <li class="user-pro">
        <a href="javascript:void(0)" class="waves-effect"><img src="{{ asset('admin-css/plugins/images/users/varun.jpg') }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}<span class="fa arrow"></span></span>
        </a>
        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
            <li><a href="javascript:void(0)"><i class="ti-user"></i> <span class="hide-menu">My Profile</span></a></li>
            <li><a href="javascript:void(0)"><i class="ti-wallet"></i> <span class="hide-menu">My Balance</span></a></li>
            <li><a href="javascript:void(0)"><i class="ti-email"></i> <span class="hide-menu">Inbox</span></a></li>
            <li><a href="javascript:void(0)"><i class="ti-settings"></i> <span class="hide-menu">Account Setting</span></a></li>
            <li><a href="{{ url('logout') }}"><i class="fa fa-power-off"></i> <span class="hide-menu">Logout</span></a></li>
        </ul>
    </li>
    <li> <a href="{{ route('home') }}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard <span class="fa arrow"></span> <span class="label label-rouded label-inverse pull-right">4</span></span></a></li>
    <li class="devider"></li>
    <li>
        <a href="javascript:void(0)" class="waves-effect">
            <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">Management Anggota<span class="fa arrow"></span></span>
        </a>
        <ul class="nav nav-second-level">
            <li>
                <a href="{{ route('anggota.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Anggota</span></a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{ route('pinjaman.index')}}" class="waves-effect">
            <i class="mdi mdi-table-large fa-fw"></i> <span class="hide-menu">Pinjaman</span>
        </a>
    </li>
    <li>
        <a href="{{ route('tagihan.index')}}" class="waves-effect">
            <i class="mdi mdi-table-large fa-fw"></i> <span class="hide-menu">Tagihan</span>
        </a>
    </li>
    <li>
    <a href="{{ route('finance.index')}}" class="waves-effect">
            <i class="mdi mdi-currency-usd fa-fw"></i> <span class="hide-menu">Keuangan</span>
        </a>
    </li>

    <li>
        <a href="javascript:void(0)" class="waves-effect">
            <i class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">Setting<span class="fa arrow"></span></span>
        </a>
        <ul class="nav nav-second-level">
            <li>
                <a href="{{ route('aktiva.index') }}"><i class="mdi mdi-table-large fa-fw"></i><span class="hide-menu">Aktiva</span></a>
            </li>
            <li>
                <a href="{{ route('pasiva.index') }}"><i class="mdi mdi-table-large fa-fw"></i><span class="hide-menu">Pasiva</span></a>
            </li>
            <li>
                <a href="{{ route('pendapatan.index') }}"><i class="mdi mdi-table-large fa-fw"></i><span class="hide-menu">Pendapatan</span></a>
            </li>
            <li>
                <a href="{{ route('biaya.index') }}"><i class="mdi mdi-table-large fa-fw"></i><span class="hide-menu">Biaya - biaya</span></a>
            </li>
            <li>
                <a href="{{ route('premi.index') }}"><i class="mdi mdi-table-large fa-fw"></i><span class="hide-menu">Premi AJK</span></a>
            </li>
            <li>
                <a href="{{ route('setting.index') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">Setting</span></a>
            </li>
            <li>
                <a href="{{ route('user.index') }}"><i class="mdi mdi-account fa-fw"></i><span class="hide-menu">User</span></a>
            </li>
        </ul>
    </li>
</ul>
@else
<ul class="nav" id="side-menu">
    <li class="user-pro">
        <a href="javascript:void(0)" class="waves-effect"><img src="{{ asset('admin-css/plugins/images/users/varun.jpg') }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}<span class="fa arrow"></span></span>
        </a>
        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
            <li><a href="javascript:void(0)"><i class="ti-user"></i> <span class="hide-menu">My Profile</span></a></li>
            <li><a href="javascript:void(0)"><i class="ti-wallet"></i> <span class="hide-menu">My Balance</span></a></li>
            <li><a href="javascript:void(0)"><i class="ti-email"></i> <span class="hide-menu">Inbox</span></a></li>
            <li><a href="javascript:void(0)"><i class="ti-settings"></i> <span class="hide-menu">Account Setting</span></a></li>
            <li><a href="{{ url('logout') }}"><i class="fa fa-power-off"></i> <span class="hide-menu">Logout</span></a></li>
        </ul>
    </li>
    <li> <a href="{{ route('home') }}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard <span class="fa arrow"></span> <span class="label label-rouded label-inverse pull-right">4</span></span></a>
    </li>
</ul>

@endif