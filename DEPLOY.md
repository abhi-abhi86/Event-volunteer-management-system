# Deployment (Two-way running)

This project supports **two modes**:
1) **Local PHP + MySQL (XAMPP)**: runs the full PHP pages and connects to MySQL.
2) **Vercel**: serves a **static UI demo** (because Vercel cannot run PHP/MySQL directly).

---

## Mode A — Run on your PC (XAMPP / PHP + MySQL)

### 1) Start XAMPP services
- Start **Apache**
- Start **MySQL**

### 2) Import the database
- Create/import `database.sql` into MySQL.
- Database name must be: `volunteer_management`

### 3) Open the site
Run:
```bash
./run_local.sh
```
Then open the URL shown in the script.

> Note: `db_connect.php` uses:
> - host: `localhost`
> - user: `root`
> - pass: *(empty string)*
>
> If your root password is not empty, update `db_connect.php`.

---

## Mode B — Deploy on Vercel (Static UI demo)

### What you get on Vercel
- Vercel serves:
  - `index.html`
  - `events.html`
  - `register.html`
  - `admin_login.html`

### Why it’s static
- PHP/MySQL authentication + data writes cannot run directly on Vercel without converting the backend to serverless (or a Node/Next.js API).

### Files involved
- `vercel.json` routes all requests to `index.html`.

Run:
```bash
./run_vercel_ui.sh
```
For manual steps.

---

## Recommended next step (true PHP on Vercel)
Convert backend to a supported runtime (e.g., **Next.js API routes + MySQL**). If you want, I can migrate the PHP pages to a Node/Next.js backend next.

