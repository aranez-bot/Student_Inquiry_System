<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Notification;
use Illuminate\Http\Request;

class DepartmentAdminController extends Controller
{
    public function dashboard()
    {
        $admin = auth()->user();
        $department = $admin->department;
        $inquiries = $department->inquiries()->latest()->paginate(10);
        $pendingCount = $department->inquiries()->where('status', 'pending')->count();
        $inProgressCount = $department->inquiries()->where('status', 'in_progress')->count();
        $resolvedCount = $department->inquiries()->where('status', 'resolved')->count();
        $unreadNotifications = $admin->notifications()->where('read_at', null)->count();

        return view('admin.dashboard', compact(
            'department',
            'inquiries',
            'pendingCount',
            'inProgressCount',
            'resolvedCount',
            'unreadNotifications'
        ));
    }

    public function inquiryInbox()
    {
        $admin = auth()->user();
        $department = $admin->department;
        $inquiries = $department->inquiries()->latest()->paginate(20);

        return view('admin.inquiry.inbox', compact('inquiries'));
    }

    public function viewInquiry(Inquiry $inquiry)
    {
        $this->authorize('viewAdmin', $inquiry);
        $messages = $inquiry->messages()->latest()->paginate(20);

        return view('admin.inquiry.show', compact('inquiry', 'messages'));
    }

    public function updateInquiryStatus(Request $request, Inquiry $inquiry)
    {
        $this->authorize('updateAdmin', $inquiry);

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,closed',
            'resolution_notes' => 'nullable|string|max:5000',
        ]);

        $inquiry->update([
            'status' => $validated['status'],
            'resolution_notes' => $validated['resolution_notes'] ?? $inquiry->resolution_notes,
            'assigned_admin_id' => auth()->id(),
        ]);

        if ($validated['status'] === 'resolved') {
            $inquiry->update(['resolved_at' => now()]);
        } elseif ($validated['status'] === 'closed') {
            $inquiry->update(['closed_at' => now()]);
        }

        // Create notification for student
        Notification::create([
            'user_id' => $inquiry->student_id,
            'inquiry_id' => $inquiry->id,
            'title' => 'Inquiry Status Changed',
            'message' => 'Your inquiry "' . $inquiry->subject . '" status changed to: ' . ucfirst(str_replace('_', ' ', $validated['status'])),
            'type' => 'status_changed',
        ]);

        return back()->with('success', 'Inquiry status updated successfully!');
    }

    public function statistics()
    {
        $admin = auth()->user();
        $department = $admin->department;

        $stats = [
            'total' => $department->inquiries()->count(),
            'pending' => $department->inquiries()->where('status', 'pending')->count(),
            'in_progress' => $department->inquiries()->where('status', 'in_progress')->count(),
            'resolved' => $department->inquiries()->where('status', 'resolved')->count(),
            'closed' => $department->inquiries()->where('status', 'closed')->count(),
        ];

        return view('admin.statistics', compact('stats'));
    }

    public function notifications()
    {
        $admin = auth()->user();
        $notifications = $admin->notifications()->latest()->paginate(20);

        return view('admin.notifications', compact('notifications'));
    }
}
