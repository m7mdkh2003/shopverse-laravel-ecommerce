<?php
namespace App\Http\Controllers;
use App\Models\ContactMessage;
class AdminMessageController extends Controller
{
    public function index() { $messages=ContactMessage::latest()->paginate(20); return view('admin.messages.index',compact('messages')); }
    public function show(ContactMessage $message) { if(!$message->read_at) $message->update(['read_at'=>now()]); return view('admin.messages.show',compact('message')); }
    public function destroy(ContactMessage $message) { $message->delete(); return redirect()->route('admin.messages.index')->with('success','Message deleted.'); }
}
