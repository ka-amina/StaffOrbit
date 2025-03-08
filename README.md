
1. install dependencies 
``` bash
composer install
```
2. run migration 
``` bash
php artisan migrate
```
3. run this command to insert records
``` bash
php artisan db:seed --class=DatabaseSeeder
```
or 
``` bash
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=ContractTypesSeeder
php artisan db:seed --class=DepartmentSeeder
php artisan db:seed --class=GradeSeeder
php artisan db:seed --class=DefaultUserSeeder
php artisan db:seed --class=FormationSeeder
```
4. sign in to accounts
- Admin :
 email:admin@gmail.com
 Password:admin@gmail.com
- rh:
 email:rh@gmail.com
 Password:rh@gmail.com