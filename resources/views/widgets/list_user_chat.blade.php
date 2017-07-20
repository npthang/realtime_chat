@foreach($listUser as $user)
<div class="lv-item media">
	<a href="{{ route('private.user', $user->name) }}" title="" style="text-decoration:none;">
	<div class="lv-avatar pull-left"> <img src="{{ asset('images/sumit.jpg') }}" alt=""> </div>
	<div class="media-body">
		<div class="lv-title">{{ $user->fullname }}</div>
		<div class="lv-small">@ {{ $user->name }}</div>
	</div>
</div>
@endforeach