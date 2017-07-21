<section class="sidebar">
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ url("storage/avatars/".Auth::user()->avatar) }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>{{ Auth::user()->fullname }}</p>
            <a href=""><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>

    <ul class="sidebar-menu">
        <li class=""><a href="../home"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
        <li class="active"><a href="{{ route('rooms.index') }}"><i class="fa fa-folder"></i> <span>Rooms</span></a></li>
        <li class=""><a href="{{ route('emotions.index') }}"><i class="fa fa-smile-o"></i> <span>Emotions</span></a></li>
        <li class=""><a href="{{ route('files.index') }}"><i class="fa fa-file-audio-o"></i> <span>Files</span></a></li>
        <li class=""><a href="{{ route('users.index') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
    </ul>
</section>