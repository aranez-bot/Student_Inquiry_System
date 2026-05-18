# Quick Start Guide - Student Inquiry System

## 🚀 Getting Started

### Prerequisites
- PHP 8.1+
- MySQL/MariaDB
- Composer
- Laravel 11+

### Installation Steps

#### 1. Database Setup
```bash
# Create database
mysql -u root -p
> CREATE DATABASE inquiry_system;
> EXIT;

# Configure .env file
cp .env.example .env
# Update these values in .env:
# DB_DATABASE=inquiry_system
# DB_USERNAME=root
# DB_PASSWORD=(your password)
```

#### 2. Install Dependencies
```bash
composer install
php artisan key:generate
```

#### 3. Run Migrations & Seeders
```bash
php artisan migrate
php artisan db:seed
```

#### 4. Start Development Server
```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

---

## 👥 Test Accounts

### Super Admin
- **Email**: superadmin@example.com
- **Password**: password
- **Access**: Full system management

### Department Admin
- **Email**: registrar@example.com
- **Password**: password
- **Department**: Registrar
- **Access**: Manage inquiries for Registrar department

### Student
- **Email**: student@example.com
- **Password**: password
- **Access**: Submit inquiries and chat

---

## 🎯 Main Features to Try

### For Students
1. ✅ **Dashboard** - View recent inquiries and statistics
2. ✅ **Create Inquiry** - Click "New Inquiry" to submit
3. ✅ **Select Department** - Choose from 6 departments
4. ✅ **Live Chat** - Send messages to department staff
5. ✅ **Track Status** - Monitor inquiry progress
6. ✅ **Notifications** - Receive updates

### For Department Admins
1. ✅ **Admin Dashboard** - See all department statistics
2. ✅ **Inquiry Inbox** - View all student inquiries
3. ✅ **Respond to Inquiries** - Send messages to students
4. ✅ **Update Status** - Change inquiry status
5. ✅ **Add Resolution Notes** - Document resolutions
6. ✅ **Statistics** - Track department performance

### For Super Admin
1. ✅ **System Dashboard** - Overview of all activities
2. ✅ **Manage Departments** - Create, edit departments
3. ✅ **Manage Users** - Create, edit, delete users
4. ✅ **Assign Roles** - Set user types and departments
5. ✅ **Analytics** - View system statistics

---

## 🔑 Key User Flows

### Student Workflow
```
Login (student@example.com)
  ↓
View Dashboard
  ↓
Click "New Inquiry"
  ↓
Select Department & Write Message
  ↓
Submit
  ↓
Chat with Department Staff
  ↓
Check Notifications for Updates
```

### Department Admin Workflow
```
Login (registrar@example.com)
  ↓
View Admin Dashboard
  ↓
Click "Inquiry Inbox"
  ↓
Select an Inquiry
  ↓
Read Student Message
  ↓
Send Reply
  ↓
Update Status (In Progress / Resolved)
  ↓
Add Resolution Notes
```

### Super Admin Workflow
```
Login (superadmin@example.com)
  ↓
View System Dashboard
  ↓
Manage Departments
  ↓
Manage Users
  ↓
View Analytics
```

---

## 📱 UI Features

### Responsive Design
- ✅ Works on desktop, tablet, mobile
- ✅ Collapsible sidebar on mobile
- ✅ Bootstrap 5 responsive grid

### Navigation
- ✅ Top navbar with user menu
- ✅ Left sidebar with role-specific menu
- ✅ Quick action buttons
- ✅ Breadcrumb navigation

### Visual Elements
- ✅ Color-coded status badges
- ✅ Department info cards
- ✅ Statistics cards
- ✅ Message bubbles
- ✅ Notification alerts
- ✅ Loading states

---

## 🎨 Styling Highlights

### Color Scheme
- **Primary**: Indigo (#4f46e5)
- **Secondary**: Cyan (#06b6d4)
- **Success**: Green (#10b981)
- **Warning**: Amber (#f59e0b)
- **Danger**: Red (#ef4444)

### Status Colors
- 🟡 **Pending** - Yellow background
- 🔵 **In Progress** - Blue background
- 🟢 **Resolved** - Green background
- ⚫ **Closed** - Gray background

---

## 🔒 Security Features

- ✅ Role-based access control (RBAC)
- ✅ Authorization policies for all models
- ✅ CSRF protection on all forms
- ✅ Password hashing (bcrypt)
- ✅ Email verification support
- ✅ Protected routes with middleware

---

## 📊 Available Departments

1. **Registrar**
   - Email: registrar@school.edu
   - Handles: Transcripts, records, enrollment

2. **Accounting**
   - Email: accounting@school.edu
   - Handles: Fees, payments, financial matters

3. **Guidance Office**
   - Email: guidance@school.edu
   - Handles: Counseling, student support

4. **IT Support**
   - Email: itsupport@school.edu
   - Handles: Technical issues, system access

5. **Scholarship Office**
   - Email: scholarship@school.edu
   - Handles: Scholarships, grants, financial aid

6. **Student Affairs**
   - Email: affairs@school.edu
   - Handles: Activities, campus life

---

## 🐛 Troubleshooting

### Database Connection Error
```bash
# Verify .env has correct credentials
php artisan tinker
> DB::connection()->getPDO();
```

### Migration Errors
```bash
# Reset database (be careful!)
php artisan migrate:fresh --seed
```

### Permissions Issues
```bash
# Fix storage/bootstrap permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📝 Creating Test Data

### Create New Student
```php
// Via tinker
php artisan tinker
> User::create(['name'=>'Test Student', 'email'=>'test@test.com', 'password'=>bcrypt('password'), 'user_type'=>'student'])
```

### Create New Department Admin
```php
// Get a department first
php artisan tinker
> $dept = Department::first();
> User::create(['name'=>'Test Admin', 'email'=>'admin@test.com', 'password'=>bcrypt('password'), 'user_type'=>'department_admin', 'department_id'=>$dept->id])
```

---

## 🔗 Important Routes

```
Login Page:         /login
Register Page:      /register
Student Dashboard:  /student/dashboard
Admin Dashboard:    /admin/dashboard
Super Admin:        /superadmin/dashboard
```

---

## 📚 API Endpoints (for future mobile apps)

These are currently available as JSON responses:

```
GET  /inquiry/{id}/messages   - Retrieve all messages
POST /message/{id}/read       - Mark message as read
```

---

## 🎓 Learning Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.0)
- [Blade Templating](https://laravel.com/docs/11.x/blade)

---

## ✨ Tips & Tricks

1. **Login with different roles** to see different dashboards
2. **Test inquiry workflow** - create, reply, update status
3. **Check notifications** for real-time feedback
4. **Inspect console messages** for debugging
5. **Use browser DevTools** to inspect responsive design

---

## 🚀 Next Features to Implement

- [ ] WebSocket real-time chat
- [ ] File attachments
- [ ] Email notifications
- [ ] SMS alerts
- [ ] Mobile app version
- [ ] Advanced analytics/reports
- [ ] User profile customization
- [ ] Dark mode toggle

---

## 💡 Project Structure

```
inquiry-system/
├── Routes:         routes/web.php
├── Controllers:    app/Http/Controllers/
├── Models:         app/Models/
├── Views:          resources/views/
├── Migrations:     database/migrations/
├── Policies:       app/Policies/
└── Middleware:     app/Http/Middleware/
```

---

## 🆘 Need Help?

Check these files for more details:
- `SYSTEM_DOCUMENTATION.md` - Complete system overview
- `app/Http/Controllers/` - Controller logic
- `app/Models/` - Model relationships
- `resources/views/` - View templates

---

**Enjoy using the Student Inquiry System! 🎉**
