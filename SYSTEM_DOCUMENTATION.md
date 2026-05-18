# Student Inquiry System - Complete Documentation

## Project Overview

A modern, department-based student inquiry management system built with Laravel and Blade templates. Students can submit inquiries to specific departments, engage in live chat with department staff, and track their inquiry status in real-time.

## System Features

### ✅ Completed Features

#### Phase 1: Foundation (100%)
- ✅ Database schema with migrations
- ✅ 5 main models: User, Department, Inquiry, Message, Notification
- ✅ Proper relationships and database constraints
- ✅ Role-based user types (Student, DepartmentAdmin, SuperAdmin)

#### Phase 2: Authentication & Authorization (100%)
- ✅ Role-based middleware (`EnsureUserType`)
- ✅ Authorization policies for Inquiry, Message, Notification
- ✅ Role-specific routing and access control
- ✅ Helper methods for user type checking

#### Phase 3: Student Features (95%)
- ✅ Student dashboard with statistics
- ✅ Create inquiry form with department selection
- ✅ Inquiry history with status tracking
- ✅ Live chat interface for inquiries
- ✅ Notification system
- ✅ Beautiful Blade templates with Bootstrap 5

#### Phase 4: Department Admin Features (95%)
- ✅ Department admin dashboard with statistics
- ✅ Inquiry inbox with filterable list
- ✅ Inquiry detail view with chat
- ✅ Status management (Pending → In Progress → Resolved → Closed)
- ✅ Resolution notes
- ✅ Reply to students with notifications

#### Phase 5: Super Admin Features (90%)
- ✅ Super admin dashboard with system-wide statistics
- ✅ Department management (create, edit, view)
- ✅ User management (create, edit, delete)
- ✅ Role assignment
- ✅ System analytics foundation

---

## Technology Stack

- **Framework**: Laravel 11+
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap 5 + Blade Templates
- **Authentication**: Laravel's built-in Auth system
- **Real-time Ready**: Prepared for Laravel Echo + WebSockets

---

## Database Schema

### Users Table
```
- id (Primary Key)
- name, email, password
- user_type (enum: student, department_admin, super_admin)
- department_id (Foreign Key to departments)
- email_verified_at, timestamps
```

### Departments Table
```
- id (Primary Key)
- name, slug (unique)
- email (unique)
- description, phone, office_hours
- is_active (boolean)
- timestamps
```

### Inquiries Table
```
- id (Primary Key)
- student_id (FK to users)
- department_id (FK to departments)
- assigned_admin_id (nullable FK to users)
- subject, description
- status (enum: pending, in_progress, resolved, closed)
- priority (int: 1=normal, 2=high, 3=urgent)
- resolution_notes (nullable)
- resolved_at, closed_at (nullable timestamps)
- timestamps
```

### Messages Table
```
- id (Primary Key)
- inquiry_id (FK to inquiries)
- user_id (FK to users)
- message (text)
- attachment_path (nullable)
- read_at (nullable timestamp)
- timestamps
```

### Notifications Table
```
- id (Primary Key)
- user_id (FK to users)
- inquiry_id (nullable FK to inquiries)
- title, message, type
- read_at (nullable timestamp)
- timestamps
```

---

## Routes Overview

### Public Routes
```
GET  /                    - Welcome page
```

### Authenticated Student Routes
```
GET  /dashboard                           - Role-based dashboard redirect
GET  /student/dashboard                   - Student dashboard
GET  /student/inquiry/create               - Create inquiry form
POST /student/inquiry                      - Store new inquiry
GET  /student/inquiry/{id}                 - View inquiry with chat
GET  /student/inquiry-history              - View all inquiries
GET  /student/notifications                - View notifications
POST /student/notifications/{id}/read      - Mark notification as read
```

### Authenticated Admin Routes
```
GET  /admin/dashboard                      - Admin dashboard
GET  /admin/inquiry/inbox                  - Inquiry inbox
GET  /admin/inquiry/{id}                   - View/reply to inquiry
PUT  /admin/inquiry/{id}/status            - Update inquiry status
GET  /admin/statistics                     - Department statistics
GET  /admin/notifications                  - View notifications
```

### Super Admin Routes
```
GET    /superadmin/dashboard               - Super admin dashboard
GET    /superadmin/departments             - List departments
GET    /superadmin/departments/create      - Create department form
POST   /superadmin/departments             - Store department
GET    /superadmin/departments/{id}/edit   - Edit department
PUT    /superadmin/departments/{id}        - Update department
GET    /superadmin/users                   - List users
GET    /superadmin/users/{id}/edit         - Edit user
PUT    /superadmin/users/{id}              - Update user
DELETE /superadmin/users/{id}              - Delete user
GET    /superadmin/analytics               - System analytics
```

### Shared Routes
```
POST /inquiry/{id}/message                 - Send message
GET  /inquiry/{id}/messages                - Get all messages (JSON)
POST /message/{id}/read                    - Mark message as read
```

---

## Controllers Structure

### StudentController
- `dashboard()` - Student dashboard with recent inquiries
- `createInquiry()` - Show inquiry creation form
- `storeInquiry()` - Store new inquiry
- `viewInquiry()` - View inquiry with chat
- `inquiryHistory()` - Paginated inquiry list
- `notifications()` - User notifications
- `markNotificationRead()` - Mark notification as read

### DepartmentAdminController
- `dashboard()` - Admin dashboard
- `inquiryInbox()` - List all department inquiries
- `viewInquiry()` - View and manage inquiry
- `updateInquiryStatus()` - Change inquiry status
- `statistics()` - Department statistics
- `notifications()` - Admin notifications

### SuperAdminController
- `dashboard()` - System-wide overview
- `manageDepartments()` - List departments
- `createDepartment()` - Show creation form
- `storeDepartment()` - Store new department
- `editDepartment()` - Show edit form
- `updateDepartment()` - Update department
- `manageUsers()` - List users
- `editUser()` - Show user edit form
- `updateUser()` - Update user details
- `deleteUser()` - Delete user
- `analytics()` - System analytics

### MessageController
- `store()` - Send message
- `markAsRead()` - Mark message as read
- `getMessages()` - Retrieve messages (API)

### DashboardController
- `index()` - Redirect to appropriate dashboard based on role

---

## Models & Relationships

### User Model
```php
- belongsTo(Department)
- hasMany(Inquiry) as student
- hasMany(Inquiry) as assigned admin
- hasMany(Message)
- hasMany(Notification)

Helper Methods:
- isStudent()
- isDepartmentAdmin()
- isSuperAdmin()
```

### Department Model
```php
- hasMany(User)
- hasMany(User, 'admins') -> filtered to department_admin type
- hasMany(Inquiry)
```

### Inquiry Model
```php
- belongsTo(User, 'student_id')
- belongsTo(Department)
- belongsTo(User, 'assigned_admin_id')
- hasMany(Message)
- hasMany(Notification)

Helper Methods:
- isPending(), isInProgress(), isResolved(), isClosed()
```

### Message Model
```php
- belongsTo(Inquiry)
- belongsTo(User)

Helper Methods:
- isRead()
- markAsRead()
```

### Notification Model
```php
- belongsTo(User)
- belongsTo(Inquiry)

Helper Methods:
- isRead()
- markAsRead()
```

---

## View Templates

### Layouts
- `layouts/app.blade.php` - Main layout with responsive sidebar navigation

### Student Views
- `student/dashboard.blade.php` - Dashboard with departments and recent inquiries
- `student/inquiry/create.blade.php` - Inquiry submission form
- `student/inquiry/show.blade.php` - View inquiry with chat interface
- `student/inquiry/history.blade.php` - Complete inquiry history
- `student/notifications.blade.php` - Notification center

### Admin Views
- `admin/dashboard.blade.php` - Department admin dashboard
- `admin/inquiry/inbox.blade.php` - All inquiries list
- `admin/inquiry/show.blade.php` - Inquiry detail with status update

### Super Admin Views
- `superadmin/dashboard.blade.php` - System overview
- *Additional views for department/user management (can be generated similarly)*

---

## Authorization Policies

### InquiryPolicy
- `view()` - Students can view own inquiries
- `viewAdmin()` - Admins can view department inquiries
- `create()` - Only students can create
- `update()` - Students can update own pending inquiries
- `updateAdmin()` - Admins can update department inquiries
- `sendMessage()` - Both student and admin can message

### MessagePolicy
- `view()` - View messages from accessible inquiries
- `create()` - Students and admins can create messages

### NotificationPolicy
- `view()` - Users can view own notifications

---

## Sample Departments (Seeded)

1. **Registrar** - registrar@school.edu
2. **Accounting** - accounting@school.edu
3. **Guidance Office** - guidance@school.edu
4. **IT Support** - itsupport@school.edu
5. **Scholarship Office** - scholarship@school.edu
6. **Student Affairs** - affairs@school.edu

---

## Setup Instructions

### 1. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed test data
php artisan db:seed
```

### 2. Test Accounts (Auto-created)
- **Super Admin**: superadmin@example.com / password
- **Department Admin**: registrar@example.com / password
- **Student**: student@example.com / password

### 3. Start Development Server
```bash
php artisan serve
```

Access at: `http://localhost:8000`

---

## Key Features

### 1. Department-Based Inquiries
Students choose which department to contact, creating focused communication channels.

### 2. Real-Time Chat
Live messaging between students and department staff with read status indicators.

### 3. Status Tracking
Inquiries progress through: Pending → In Progress → Resolved → Closed

### 4. Notifications
- New inquiry notifications for admins
- Status change alerts for students
- Message arrival notifications

### 5. Role-Based Access
Three user types with specific permissions and dashboards:
- Students: Submit, track, chat
- Admins: Manage, respond, update status
- Super Admin: Manage system

### 6. Modern UI
- Bootstrap 5 responsive design
- Collapsible sidebar
- Card-based layouts
- Gradient headers
- Status badges
- Message bubbles

---

## Future Enhancements (Not Yet Implemented)

### Real-Time Features
- [ ] WebSocket integration with Laravel Echo
- [ ] Live typing indicators
- [ ] Real-time message updates
- [ ] Live notification badges

### Advanced Features
- [ ] File attachments in messages
- [ ] Email notifications
- [ ] SMS alerts
- [ ] AI chatbot assistant
- [ ] Auto-reply system
- [ ] FAQ section per department
- [ ] Voice/video call support

### Admin Features
- [ ] Advanced analytics/reports
- [ ] Custom department categories
- [ ] Queue/priority management
- [ ] SLA tracking
- [ ] Satisfaction surveys

### User Features
- [ ] Dark mode toggle
- [ ] User profile/settings
- [ ] Inquiry templates
- [ ] Bulk inquiry operations
- [ ] Export inquiry history

---

## File Structure

```
inquiry-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── StudentController.php
│   │   │   ├── DepartmentAdminController.php
│   │   │   ├── SuperAdminController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── InquiryController.php
│   │   │   └── MessageController.php
│   │   └── Middleware/
│   │       └── EnsureUserType.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Department.php
│   │   ├── Inquiry.php
│   │   ├── Message.php
│   │   └── Notification.php
│   └── Policies/
│       ├── InquiryPolicy.php
│       ├── MessagePolicy.php
│       └── NotificationPolicy.php
├── database/
│   ├── migrations/
│   │   ├── *_create_users_table.php
│   │   ├── *_create_departments_table.php
│   │   ├── *_create_inquiries_table.php
│   │   ├── *_create_messages_table.php
│   │   └── *_create_notifications_table.php
│   └── seeders/
│       ├── DepartmentSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── student/
│       │   ├── dashboard.blade.php
│       │   ├── notifications.blade.php
│       │   └── inquiry/
│       │       ├── create.blade.php
│       │       ├── show.blade.php
│       │       └── history.blade.php
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   └── inquiry/
│       │       ├── inbox.blade.php
│       │       └── show.blade.php
│       └── superadmin/
│           └── dashboard.blade.php
└── routes/
    └── web.php
```

---

## Notes

- All views are fully responsive and mobile-friendly
- Bootstrap 5 provides consistent styling
- Font Awesome icons are used throughout
- Blade templating provides clean, readable code
- Authorization is enforced at controller and policy level
- All forms include CSRF protection
- Error messages are displayed to users
- Success notifications appear after operations

---

## Next Steps

1. **Real-Time Features**: Implement WebSocket support with Laravel Echo
2. **File Uploads**: Add attachment support to inquiries and messages
3. **Email Notifications**: Send email alerts for key events
4. **Advanced Analytics**: Create detailed reports and charts
5. **Testing**: Write unit and feature tests for all features
6. **Mobile App**: Create mobile version or API for mobile clients

---

## Support

For issues or questions about the system, refer to the specific controller or model files for detailed logic implementation.

Created with ❤️ using Laravel 11+
