<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function store(Request $request, Inquiry $inquiry)
    {
        $this->authorize('sendMessage', $inquiry);

        $validated = $request->validate([
            'message' => 'nullable|required_without:attachment|string|max:5000',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,csv,txt,jpg,jpeg,png|max:5120',
        ]);

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('inquiry-attachments', 'public');
        }

        $message = Message::create([
            'inquiry_id' => $inquiry->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'] ?? 'Attached a records file.',
            'attachment_path' => $attachmentPath,
        ]);

        $user = auth()->user();

        if ($user->isDepartmentAdmin()) {
            $inquiry->update([
                'assigned_admin_id' => $user->id,
                'status' => $inquiry->status === 'pending' ? 'in_progress' : $inquiry->status,
            ]);
        }

        // Create notification for the other party
        if ($user->isStudent()) {
            // Notify department admins
            $admins = $inquiry->department->admins;
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'inquiry_id' => $inquiry->id,
                    'title' => 'New Message',
                    'message' => $user->name . ' replied to inquiry: ' . $inquiry->subject,
                    'type' => 'message_new',
                ]);
            }
        } else {
            // Notify student
            Notification::create([
                'user_id' => $inquiry->student_id,
                'inquiry_id' => $inquiry->id,
                'title' => 'New Message',
                'message' => 'Department replied to your inquiry: ' . $inquiry->subject,
                'type' => 'message_new',
            ]);
        }

        return back()->with('success', 'Message sent successfully!');
    }

    public function markAsRead(Message $message)
    {
        $this->authorize('view', $message);
        $message->markAsRead();

        return back();
    }

    public function downloadAttachment(Message $message)
    {
        $this->authorize('view', $message);

        abort_if(!$message->attachment_path, 404);
        abort_if(!Storage::disk('public')->exists($message->attachment_path), 404);

        return Storage::disk('public')->download($message->attachment_path);
    }

    public function getMessages(Inquiry $inquiry)
    {
        $this->authorize('sendMessage', $inquiry);

        return response()->json([
            'messages' => $inquiry->messages()->with('user')->latest()->get(),
        ]);
    }
}
