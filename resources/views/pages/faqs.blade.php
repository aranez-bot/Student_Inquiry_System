@extends('layouts.app')

@section('title', 'FAQs')

@section('content')
    <h1 class="mb-4">
        <i class="fas fa-question-circle"></i> FAQs
    </h1>

    <div class="card">
        <div class="card-body">
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne">
                            How do I submit an inquiry?
                        </button>
                    </h2>
                    <div id="faqOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Go to New Inquiry, choose the department, and fill in the subject and description.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo">
                            Where can I see my inquiry status?
                        </button>
                    </h2>
                    <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Open Inquiry History or your Dashboard to view recent inquiries and their current status.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree">
                            How do I update my profile photo?
                        </button>
                    </h2>
                    <div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Click the profile icon in the header, open My Profile, upload a photo, then save your profile.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
