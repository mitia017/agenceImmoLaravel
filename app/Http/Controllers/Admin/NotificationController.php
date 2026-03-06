<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientReplyMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;



class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()->latest()->paginate(10);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function show(DatabaseNotification $notification)
    {
        $superadmin = \App\Models\User::first();
        if ($notification->notifiable_id !== $superadmin->id && $notification->notifiable_id !== auth()->id()) {
            abort(403);
        }
        $notification->markAsRead();

        return view('admin.notifications.show', [
            'notification' => $notification,
            'property' => \App\Models\Property::find($notification->data['property_id'])
        ]);
    }

    public function destroy(DatabaseNotification $notification): RedirectResponse
    {
        $notification->delete();
        return back()->with('success', 'Notification supprimé avec succès.');    
        
    }

    public function sendMail(DatabaseNotification $notification)
    {
        abort_if($notification->notifiable_id !== auth()->id() && $notification->notifiable_id !== \App\Models\User::first()->id, 403);

        $data = $notification->data;

        Mail::to($data['email'])->send(
            new ClientReplyMail($data, auth()->user())
        );

        return back()->with('success', 'Mail envoyé au client');
    }
}
