<div class="ms-menu" style="overflow:scroll; overflow-x: hidden;" id="ms-scrollbar">
	<div class="ms-block">
		<div class="ms-user"> 
			<img src="{{ asset('images/avatar.jpg') }}" alt="">
			<h5 class="q-title" align="center">
				{{ Auth::user()->fullname }}<br />                                    
            <a href="{!! url('/logout') !!}" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="text-decoration: none;">
                Sign out <i class="fa fa-sign-out" aria-hidden="true"></i>
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
				</h5> 
		</div>
	</div>
	<div class="ms-block"> 
		<form action="" method="post">
			<div class="form-group">
				<input type="name" class="form-control" id="name" placeholder="Search">
			</div>
		</form>
	</div>
	<hr/>
	<div class="listview lv-user m-t-20">
		@widget('listRoomChat')
	</div>
	<hr>
	<div class="listview lv-user m-t-20">
		@widget('listUserChat')
	</div>
</div>
