<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function show(Inquiry $inquiry)
    {
        if (auth()->user()->isStudent()) {
            $this->authorize('view', $inquiry);
            return redirect()->route('student.inquiry.show', $inquiry);
        } elseif (auth()->user()->isDepartmentAdmin()) {
            $this->authorize('viewAdmin', $inquiry);
            return redirect()->route('admin.inquiry.show', $inquiry);
        }

        abort(403);
    }
}
