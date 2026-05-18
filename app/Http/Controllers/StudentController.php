<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Inquiry;
use App\Models\Notification;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user();
        $inquiries = $student->inquiries()->latest()->paginate(10);
        $unreadNotifications = $student->notifications()->where('read_at', null)->count();

        return view('student.dashboard', compact('inquiries', 'unreadNotifications'));
    }

    public function createInquiry()
    {
        $departments = Department::where('is_active', true)->get();
        return view('student.inquiry.create', compact('departments'));
    }

    public function storeInquiry(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
        ]);

        $inquiry = Inquiry::create([
            'student_id' => auth()->id(),
            'department_id' => $validated['department_id'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        // Create notification for department admins
        $dept = Department::find($validated['department_id']);
        $admins = $dept->admins;

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'inquiry_id' => $inquiry->id,
                'title' => 'New Inquiry',
                'message' => auth()->user()->name . ' submitted a new inquiry: ' . $validated['subject'],
                'type' => 'inquiry_new',
            ]);
        }

        return redirect()->route('student.inquiry.show', $inquiry)
                        ->with('success', 'Inquiry submitted successfully!');
    }

    public function viewInquiry(Inquiry $inquiry)
    {
        $this->authorize('view', $inquiry);
        $messages = $inquiry->messages()->latest()->paginate(20);
        $unreadMessages = $messages->filter(fn($msg) => !$msg->isRead())->count();

        return view('student.inquiry.show', compact('inquiry', 'messages', 'unreadMessages'));
    }

    public function inquiryHistory()
    {
        $student = auth()->user();
        $inquiries = $student->inquiries()->latest()->paginate(15);

        return view('student.inquiry.history', compact('inquiries'));
    }

    public function notifications()
    {
        $student = auth()->user();
        $notifications = $student->notifications()->latest()->paginate(20);

        return view('student.notifications', compact('notifications'));
    }

    public function markNotificationRead(Notification $notification)
    {
        $this->authorize('view', $notification);
        $notification->markAsRead();

        return back()->with('success', 'Notification marked as read');
    }
}
