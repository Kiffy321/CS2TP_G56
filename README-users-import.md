# Importing Example Users

To import example users into your local database, use the following command in your terminal (replace `username` and `database_name` with your MySQL credentials):

```
mysql -u username -p database_name < database/users.sql
```

This will import the users from the provided SQL file into your database.
The import file now creates the `users` table if it does not exist and adds any missing user columns before inserting the demo records.

**Note:**
- Only use this file for test/demo data. Do not use real user data in public repositories.
- Existing users with the same email will be updated instead of causing the import to fail.

The default MySQL username is usually root and the password is often blank (just press Enter when prompted).

You can access phpMyAdmin by clicking the "Admin" button next to MySQL in the XAMPP Control Panel. No extra setup is needed—just navigate to your database from there.
