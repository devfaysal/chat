<?php

use App\Models\Participant;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::get('dashboard', function(){
    $participants = Participant::whereIn('room_id', auth()->user()->participants->pluck('room_id'))
        ->where('user_id', '!=', auth()->id())
        ->get();
    $room = $participants->first()->room;
    // dd($participants);
        return view('dashboard', [
            'participants' => $participants,
            'room' => $room
        ]);
    })
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('messages/rooms/{room}', function(Room $room){
    $participants = Participant::whereIn('room_id', auth()->user()->participants->pluck('room_id'))
        ->where('user_id', '!=', auth()->id())
        ->get();

    return view('dashboard', [
        'participants' => $participants,
        'room' => $room
    ]);
})
->middleware(['auth', 'verified'])
->name('messages.index');

Route::post('messages/rooms/{room}', function(Request $request, Room $room){
    $room->messages()->create([
        'user_id' => auth()->id(),
        'message' => $request->message
    ]);

    return redirect()->route('messages.index', $room);
})
->middleware(['auth', 'verified'])
->name('messages.store');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::get('messages/rooms/create/{user}', function(User $user){
    $records = DB::table('participants')
                ->where('user_id', $user->id)
                ->whereIn('room_id', DB::table('participants')->select('room_id')->where('user_id', auth()->id()))
                ->get();
    dd($records->first());
    // $room = Room::create([]);
    // $room->participants()->createMany([
    //     ['user_id' => auth()->id()],
    //     ['user_id' => $user->id],
    // ]);
});
