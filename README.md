# Academia – Student Course Management

## ✨ Penjelasan Singkat
Aplikasi web berbasis **Laravel** untuk mengelola mahasiswa dan mata kuliah.  
- **👩‍💼 Admin**: mengatur data mahasiswa & courses, melakukan bulk actions, serta melihat dashboard analitik.  
- **🎓 Student**: memiliki dashboard pribadi, dapat browse & enroll courses dengan perhitungan SKS realtime, serta melihat progress nilai.

---

## 🔑 Fitur Utama

### 🔐 Authentication & Role Based
- Login Admin & Student.  
- Logout dengan modal konfirmasi.  

---

### 👩‍💼 Fitur Admin
#### 👨‍🎓 Manajemen Mahasiswa
- CRUD mahasiswa.  
- Bulk activate/deactivate/delete dengan modal konfirmasi.  
- Status aktif/nonaktif ditampilkan dengan badge.  

#### 📚 Manajemen Course
- CRUD courses.  
- Filter & search course.  
- Detail course menampilkan enrolled students.  

#### 📊 Dashboard Admin
- Statistik total mahasiswa & courses.  
- Chart distribusi mahasiswa per jurusan.  
- Chart top 5 popular courses.  
- Chart distribusi nilai/grade.  

---

### 🎓 Fitur Student
#### 🏠 Dashboard Student
- Profil singkat (nama, NIM, jurusan, entry year).  
- Statistik utama: All Courses, My Courses, Available, Total SKS Taken, Current GPA.  
- Chart distribusi nilai (Grade Distribution).  

#### 🔍 Browse Courses
- List semua courses yang tersedia.  
- Filter & search courses.  
- Checklist multiple course → total SKS realtime.  
- Enroll course dengan modal konfirmasi.  

#### 📖 My Courses
- Menampilkan daftar courses yang sudah diambil.  
- Menampilkan grade, SKS, serta nilai konversi (angka & IPK).  
- Aksi unenroll course dengan modal konfirmasi.  

---

### 🛠 UX & Komponen Umum
- Sidebar dengan menu aktif highlight.  
- Form validation dengan error message.  
- Modal konfirmasi (delete, logout, enroll, bulk action).  
- Tampilan chart interaktif dengan Chart.js.  

---

### 🌐 Landing Page
- Halaman awal sederhana untuk memperkenalkan aplikasi.  

---

## 🛠 Teknologi
- Laravel 10+  
- Blade Template Engine  
- TailwindCSS  
- Chart.js  
- Vanilla JavaScript (DOM, Event Handling, Async Demo)  
- Database: **MySQL** (via phpMyAdmin)  
- Vite (asset bundler & hot reload)  

---

## 📸 Screenshots

### 🌐 Landing Page
![Landing](docs/screenshots/landing.png)

### 🔐 Login
![Login](docs/screenshots/login.png)

### 📊 Dashboard Admin
![Dashboard Admin](docs/screenshots/admin-dashboard.png)  
![Dashboard Admin 2](docs/screenshots/admin-dashboard2.png)

### 📚 Manage Courses (Admin)
![Courses](docs/screenshots/admin-course.png)

### 👨‍🎓 Manage Students (Admin)
![Students](docs/screenshots/studenpage-admin.png)

### ⚡ Bulk Action (Admin – Students)
![Bulk Action Admin](docs/screenshots/bulk-action-admin.png)

### 🏠 Dashboard Student
![Student Dashboard](docs/screenshots/student-dashboard.png)  
![Student Dashboard 2](docs/screenshots/student-dashboard2.png)

### 🔍 Browse Courses (Student)
![Browse Courses](docs/screenshots/browse-course.png)

### ⚡ Bulk Action (Student – Enroll Multiple)
![Bulk Action Student](docs/screenshots/bulk-actions-student.png)

### 📖 My Courses (Student)
![My Courses](docs/screenshots/my-course.png)
