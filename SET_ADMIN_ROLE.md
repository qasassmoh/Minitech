# How to Set User Role to Admin

If you can't see the Admin Panel link, your user account might not have the 'admin' role set in the database.

## Option 1: Using Laravel Tinker (Recommended)

1. Open terminal/command prompt in your project directory
2. Run: `php artisan tinker`
3. Then run these commands:

```php
// Find your user (replace 'admin2' with your username)
$user = \App\Models\User::where('username', 'admin2')->first();

// Check current role
echo "Current role: " . ($user->role ?? 'NULL') . "\n";

// Set role to admin
$user->role = 'admin';
$user->save();

// Verify
echo "New role: " . $user->role . "\n";
```

## Option 2: Using SQL (if you have database access)

```sql
UPDATE users SET role = 'admin' WHERE username = 'admin2';
```

## Option 3: Direct Database Access

1. Open your database tool (phpMyAdmin, DBeaver, etc.)
2. Go to the `users` table
3. Find your user (username: admin2)
4. Set the `role` column to: `admin`
5. Save

After updating, refresh your browser and you should see the "Admin Panel" button in the navigation.
