<p align="center" style="background-color: rgb(31,61,123)"><a href="http://44.215.48.16" target="_blank"><img src="https://static.wixstatic.com/media/871c5a_b0955874382040dd80226fa20be7455e~mv2.png/v1/fill/w_174,h_102,al_c,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/w40_logo_White.png"></a></p>

## About West40 Student Roster

A simple Laravel app to manage a roster of students. It includes Breeze authentication, CRUD, search, sorting, pagination, soft deletes with restore/force-delete, responsive UI with Tailwind, and a small Users admin (including activate/deactivate).

## Features
Students:
- CRUD functionality (create, edit, soft-delete to “trash”, restore, force-delete).
- Server + browser-side validation.
- Search by name/email.
- Sortable columns (ID, Name, Email, DOB, Created).
- Pagination with query-string persistence.
- Responsive table: hides Email/DOB/Created on mobile.
- Icon buttons for edit/delete/restore with accessible labels.

Users:
- CRUD functionality (create/edit/activate/inactivate).
- Server + browser-side validation.
- Search by name/email.
- Sortable columns (ID, Name, Email, Created).

Layout/UX:
- Top nav with logo and auth actions.
- Sidebar nav on desktop; mobile hamburger shows the same links.
- Tailwind CSS + Vite; small Alpine.js snippets for hamburger + search clear ✕.
- Fully responsive design
  
## Requirements
- PHP 8.2+
- Composer
- Node 18+ (or 20+) & npm
- MySQL/MariaDB (or SQLite for quick start)

## Installation
```
1) Clone & install
git clone <your-repo-url> student-roster
cd student-roster
cp .env.example .env

composer install
php artisan key:generate

npm install

2) Configure DB in .env
DB_DATABASE=student_roster
DB_USERNAME=...
DB_PASSWORD=...

3) Migrate (and seed demo data)
php artisan migrate
php artisan db:seed --class=StudentSeeder   # demo students via factory (optional)
php artisan db:seed --class=UserSeeder    # if you add one

4) Build frontend (dev)
npm run dev

5) Run the app
php artisan serve
```
