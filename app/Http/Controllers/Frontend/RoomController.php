<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Room;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\RoomUser;
use App\File;
use App\Messenges;
use Auth;


class RoomController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $listRoomJoined = RoomUser::where('user_id', Auth::id())->get();

        $arrayRoomJoin = array_pluck($listRoomJoined->toArray(), 'room_id');

        $listRoomRandom = DB::table('rooms')->whereNotIn('id', $arrayRoomJoin)->get();


        return view('frontend.rooms.index', compact('listRoomJoined', 'listRoomRandom'));
    }

    public function create()
    {
    	return view('frontend.rooms.create');
    }

    public function store(Request $request)
    {
        $room = new Room;
        $room->name = $request->name;
        $room->user_id = Auth::id();
        $room->save();


        $roomUser = new RoomUser;
        $roomUser->user_id = Auth::id();
        $roomUser->room_id = $room->id;
        $roomUser->save();

        return redirect()->route('frontend.message.room', $room->id);
    }

    public function show($id)
    {
        return view('frontend.rooms.show');
    }

    public function invite($id)
    {
    	//
    }

    public function leave($id)
    {
        $room = Room::findOrFail($id);

        $files = File::where('room_id', $id)->where('user_id', Auth::id())->get();

        foreach ($files as $key => $file) {
            Storage::delete('public/media/'.$file->name);

            File::findOrFail($file->id)->delete();
        }

        $roomUser = RoomUser::where('user_id', Auth::id())->where('room_id', $id)->first();
        $roomUser->delete();

        $checkRoomMember = RoomUser::where('room_id', $id)->get();

        if(count($checkRoomMember) == 0){
            RoomUser::where('room_id', $id)->delete();
            Messenges::where('room_id', $id)->delete();
            $files = File::where('room_id', $id)->get();

            foreach ($files as $key => $file) {
                Storage::delete('public/media/'.$file->name);
            }

            $room->delete();

            return redirect()->route('frontend.room.index');
        }

        return redirect()->route('frontend.message.room', $id);
    }

    public function join($id)
    {
        $room = Room::findOrFail($id);

        $roomUser = new RoomUser;
        $roomUser->user_id = Auth::id();
        $roomUser->room_id = $id;
        $roomUser->save();

        return redirect()->route('frontend.message.room', $id);
    }

    public function edit($id)
    {
        return redirect()->route('frontend.message.room', $id);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        if ($room->user_id != Auth::id()) {
            abort(404);
        }
        $room->name = $request->name;
        $room->save();

        return redirect()->route('frontend.message.room', $room->id);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        if ($room->user_id != Auth::id()) {
            abort(404);
        }

        RoomUser::where('room_id', $id)->delete();
        Messenges::where('room_id', $id)->delete();
        $files = File::where('room_id', $id)->get();

        foreach ($files as $key => $file) {
            Storage::delete('public/media/'.$file->name);
        }

        $room->delete();

        return redirect()->route('frontend.room.index');
    }
}
