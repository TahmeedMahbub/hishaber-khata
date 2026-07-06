<?php

/*
|--------------------------------------------------------------------------
| Application Translations
|--------------------------------------------------------------------------
|
| Single source of truth for ALL user-facing text. Keys are grouped by
| module and accessed with dot-notation via the t() helper:
|
|     t('nav.dashboard')   →  "ড্যাশবোর্ড" or "Dashboard" (per user language)
|     t('common.save')     →  "সংরক্ষণ করুন" or "Save"
|
| Each leaf entry holds a 'bn' and an 'en' value. Add a new key under the
| relevant group and it is instantly usable. Missing keys return the key
| name itself, and language falls back to 'bn'.
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | Brand
    |--------------------------------------------------------------------------
    */
    'brand' => [
        'name' => ['bn' => 'হিসাবিজ', 'en' => 'Hishabiz'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation (sidebar / navbar / mobile bottom nav)
    |--------------------------------------------------------------------------
    */
    'nav' => [
        'dashboard'     => ['bn' => 'ড্যাশবোর্ড', 'en' => 'Dashboard'],
        'sales'         => ['bn' => 'বিক্রয়', 'en' => 'Sales'],
        'pos'           => ['bn' => 'বিক্রয়', 'en' => 'POS'],
        'sell'          => ['bn' => 'বিক্রয় করুন', 'en' => 'POS'],
        'products'      => ['bn' => 'পণ্য', 'en' => 'Products'],
        'all_products'  => ['bn' => 'সকল পণ্য', 'en' => 'All Products'],
        'categories'    => ['bn' => 'ক্যাটাগরি', 'en' => 'Categories'],
        'more'          => ['bn' => 'আরও', 'en' => 'More'],
        'more_options'  => ['bn' => 'আরও অপশন', 'en' => 'More Options'],
        'purchases'     => ['bn' => 'ক্রয়', 'en' => 'Purchases'],
        'customers'     => ['bn' => 'কাস্টমার', 'en' => 'Customers'],
        'suppliers'     => ['bn' => 'সরবরাহকারী', 'en' => 'Suppliers'],
        'due_payments'  => ['bn' => 'বাকির হিসাব', 'en' => 'Due Accounts'],
        'expenses'      => ['bn' => 'খরচ', 'en' => 'Expenses'],
        'damages'       => ['bn' => 'ড্যামেজ / হারানো', 'en' => 'Damage / Loss'],
        'damages_short' => ['bn' => 'ড্যামেজ / লস', 'en' => 'Damage Loss'],
        'sale_returns'     => ['bn' => 'বিক্রয় রিটার্ন', 'en' => 'Sale Returns'],
        'purchase_returns' => ['bn' => 'ক্রয় রিটার্ন', 'en' => 'Purchase Returns'],
        'employees'     => ['bn' => 'কর্মচারী', 'en' => 'Employees'],
        'settings'      => ['bn' => 'সেটিংস', 'en' => 'Settings'],
        'profile'       => ['bn' => 'প্রোফাইল', 'en' => 'Profile'],
        'profile_edit'  => ['bn' => 'প্রোফাইল তথ্য পরিবর্তন', 'en' => 'Edit Profile'],
        'feedback'      => ['bn' => 'মতামত', 'en' => 'Feedback'],
        'reports'       => ['bn' => 'রিপোর্ট', 'en' => 'Reports'],
        'notifications' => ['bn' => 'নোটিফিকেশন', 'en' => 'Notifications'],
        'logout'        => ['bn' => 'লগ আউট', 'en' => 'Log Out'],
        'main_menu'     => ['bn' => 'মূল মেনু', 'en' => 'Main Menu'],
        'notifications_new'    => ['bn' => 'নতুন', 'en' => 'New'],
        'notifications_unread' => ['bn' => 'অপঠিত নোটিফিকেশন', 'en' => 'Unread notifications'],
        'notifications_empty'  => ['bn' => 'কোনো নোটিফিকেশন নেই।', 'en' => 'No notifications.'],
        'mark_all_read'        => ['bn' => 'সব পঠিত করুন', 'en' => 'Mark all as read'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Footer
    |--------------------------------------------------------------------------
    */
    'footer' => [
        'year'      => ['bn' => '২০২৬', 'en' => '2026'],
        'rights'    => ['bn' => 'সর্বস্বত্ব সংরক্ষিত।', 'en' => 'All rights reserved.'],
        'crafted_by' => ['bn' => 'তৈরি করেছেন', 'en' => 'Crafted by'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Common UI (buttons, labels, generic words reused everywhere)
    |--------------------------------------------------------------------------
    */
    'common' => [
        'save'                => ['bn' => 'সংরক্ষণ', 'en' => 'Save'],
        'save_and_add_another' => ['bn' => 'সংরক্ষণ ও নতুন', 'en' => 'Save & New'],
        'update'          => ['bn' => 'আপডেট করুন', 'en' => 'Update'],
        'create'          => ['bn' => 'তৈরি করুন', 'en' => 'Create'],
        'add'             => ['bn' => 'যোগ করুন', 'en' => 'Add'],
        'edit'            => ['bn' => 'সম্পাদনা', 'en' => 'Edit'],
        'delete'          => ['bn' => 'মুছুন', 'en' => 'Delete'],
        'cancel'          => ['bn' => 'বাতিল', 'en' => 'Cancel'],
        'close'           => ['bn' => 'বন্ধ করুন', 'en' => 'Close'],
        'confirm'         => ['bn' => 'নিশ্চিত করুন', 'en' => 'Confirm'],
        'search'          => ['bn' => 'খুঁজুন', 'en' => 'Search'],
        'filter'          => ['bn' => 'ফিল্টার', 'en' => 'Filter'],
        'reset'           => ['bn' => 'রিসেট', 'en' => 'Reset'],
        'back'            => ['bn' => 'ফিরে যান', 'en' => 'Back'],
        'view'            => ['bn' => 'দেখুন', 'en' => 'View'],
        'view_all'        => ['bn' => 'সব দেখুন', 'en' => 'View All'],
        'details'         => ['bn' => 'বিস্তারিত', 'en' => 'Details'],
        'print'           => ['bn' => 'প্রিন্ট', 'en' => 'Print'],
        'download'        => ['bn' => 'ডাউনলোড', 'en' => 'Download'],
        'export'          => ['bn' => 'এক্সপোর্ট', 'en' => 'Export'],
        'actions'         => ['bn' => 'অ্যাকশন', 'en' => 'Actions'],
        'action'          => ['bn' => 'কার্যক্রম', 'en' => 'Action'],
        'status'          => ['bn' => 'স্ট্যাটাস', 'en' => 'Status'],
        'active'          => ['bn' => 'সক্রিয়', 'en' => 'Active'],
        'inactive'        => ['bn' => 'নিষ্ক্রিয়', 'en' => 'Inactive'],
        'yes'             => ['bn' => 'হ্যাঁ', 'en' => 'Yes'],
        'no'              => ['bn' => 'না', 'en' => 'No'],
        'name'            => ['bn' => 'নাম', 'en' => 'Name'],
        'phone'           => ['bn' => 'ফোন', 'en' => 'Phone'],
        'email'           => ['bn' => 'ইমেইল', 'en' => 'Email'],
        'address'         => ['bn' => 'ঠিকানা', 'en' => 'Address'],
        'note'            => ['bn' => 'নোট', 'en' => 'Note'],
        'notes'           => ['bn' => 'নোট', 'en' => 'Notes'],
        'date'            => ['bn' => 'তারিখ', 'en' => 'Date'],
        'amount'          => ['bn' => 'পরিমাণ', 'en' => 'Amount'],
        'total'           => ['bn' => 'মোট', 'en' => 'Total'],
        'quantity'        => ['bn' => 'পরিমাণ', 'en' => 'Quantity'],
        'price'           => ['bn' => 'মূল্য', 'en' => 'Price'],
        'description'     => ['bn' => 'বিবরণ', 'en' => 'Description'],
        'role'            => ['bn' => 'ভূমিকা', 'en' => 'Role'],
        'optional'        => ['bn' => 'ঐচ্ছিক', 'en' => 'Optional'],
        'required'        => ['bn' => 'আবশ্যক', 'en' => 'Required'],
        'select'          => ['bn' => 'নির্বাচন করুন', 'en' => 'Select'],
        'all'             => ['bn' => 'সব', 'en' => 'All'],
        'none'            => ['bn' => 'নেই', 'en' => 'None'],
        'no_data'         => ['bn' => 'কোনো তথ্য নেই।', 'en' => 'No data available.'],
        'loading'         => ['bn' => 'লোড হচ্ছে...', 'en' => 'Loading...'],
        'serial'          => ['bn' => 'ক্রম', 'en' => '#'],
        'from_date'       => ['bn' => 'শুরুর তারিখ', 'en' => 'From Date'],
        'to_date'         => ['bn' => 'শেষ তারিখ', 'en' => 'To Date'],
        'created_at'      => ['bn' => 'তৈরির সময়', 'en' => 'Created At'],
        'are_you_sure'    => ['bn' => 'আপনি কি নিশ্চিত?', 'en' => 'Are you sure?'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Auth (login / register)
    |--------------------------------------------------------------------------
    */
    'auth' => [
        'login'            => ['bn' => 'লগ ইন', 'en' => 'Log In'],
        'register'         => ['bn' => 'নিবন্ধন', 'en' => 'Register'],
        'logout'           => ['bn' => 'লগ আউট', 'en' => 'Log Out'],
        'email'            => ['bn' => 'ইমেইল', 'en' => 'Email'],
        'phone'            => ['bn' => 'ফোন নম্বর', 'en' => 'Phone Number'],
        'password'         => ['bn' => 'পাসওয়ার্ড', 'en' => 'Password'],
        'confirm_password' => ['bn' => 'পাসওয়ার্ড নিশ্চিত করুন', 'en' => 'Confirm Password'],
        'remember_me'      => ['bn' => 'মনে রাখুন', 'en' => 'Remember Me'],
        'forgot_password'  => ['bn' => 'পাসওয়ার্ড ভুলে গেছেন?', 'en' => 'Forgot Password?'],
        'no_account'       => ['bn' => 'অ্যাকাউন্ট নেই?', 'en' => "Don't have an account?"],
        'have_account'     => ['bn' => 'অ্যাকাউন্ট আছে?', 'en' => 'Already have an account?'],
        'sign_in'          => ['bn' => 'সাইন ইন করুন', 'en' => 'Sign In'],
        'sign_up'          => ['bn' => 'সাইন আপ করুন', 'en' => 'Sign Up'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    'dashboard' => [
        'today_sales'    => ['bn' => 'আজকের বিক্রয়', 'en' => "Today's Sales"],
        'today_profit'   => ['bn' => 'আজকের লাভ', 'en' => "Today's Profit"],
        'cash_balance'   => ['bn' => 'নগদ ব্যালেন্স', 'en' => 'Cash Balance'],
        'customer_due'   => ['bn' => 'কাস্টমার বাকি', 'en' => 'Customer Due'],
        'supplier_due'   => ['bn' => 'সরবরাহকারী বাকি', 'en' => 'Supplier Due'],
        'stock_value'    => ['bn' => 'স্টক মূল্য', 'en' => 'Stock Value'],
        'new_sale'       => ['bn' => 'নতুন বিক্রয়', 'en' => 'New Sale'],
        'new_purchase'   => ['bn' => 'নতুন ক্রয়', 'en' => 'New Purchase'],
        'add_product'    => ['bn' => 'পণ্য যোগ', 'en' => 'Add Product'],
        'add_expense'    => ['bn' => 'খরচ যোগ', 'en' => 'Add Expense'],
        'low_stock'      => ['bn' => 'কম স্টক', 'en' => 'Low Stock'],
        'persons'        => ['bn' => 'জন', 'en' => 'persons'],
        'recent_sales'   => ['bn' => 'সাম্প্রতিক বিক্রয়', 'en' => 'Recent Sales'],
        'invoice'        => ['bn' => 'ইনভয়েস', 'en' => 'Invoice'],
        'top_products'   => ['bn' => 'টপ সেলিং পণ্য', 'en' => 'Top Selling Products'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Flash / status messages (controllers)
    |--------------------------------------------------------------------------
    */
    'msg' => [
        'category_created'   => ['bn' => 'ক্যাটাগরি যোগ করা হয়েছে।', 'en' => 'Category added.'],
        'category_updated'   => ['bn' => 'ক্যাটাগরি আপডেট করা হয়েছে।', 'en' => 'Category updated.'],
        'category_deleted'   => ['bn' => 'ক্যাটাগরি মুছে ফেলা হয়েছে।', 'en' => 'Category deleted.'],
        'customer_created'   => ['bn' => 'কাস্টমার যোগ করা হয়েছে।', 'en' => 'Customer added.'],
        'customer_updated'   => ['bn' => 'কাস্টমার আপডেট করা হয়েছে।', 'en' => 'Customer updated.'],
        'customer_deleted'   => ['bn' => 'কাস্টমার মুছে ফেলা হয়েছে।', 'en' => 'Customer deleted.'],
        'supplier_created'   => ['bn' => 'সরবরাহকারী যোগ করা হয়েছে।', 'en' => 'Supplier added.'],
        'supplier_updated'   => ['bn' => 'সরবরাহকারী আপডেট করা হয়েছে।', 'en' => 'Supplier updated.'],
        'supplier_deleted'   => ['bn' => 'সরবরাহকারী মুছে ফেলা হয়েছে।', 'en' => 'Supplier deleted.'],
        'product_created'    => ['bn' => 'পণ্য যোগ করা হয়েছে।', 'en' => 'Product added.'],
        'product_updated'    => ['bn' => 'পণ্য আপডেট করা হয়েছে।', 'en' => 'Product updated.'],
        'product_deleted'    => ['bn' => 'পণ্য মুছে ফেলা হয়েছে।', 'en' => 'Product deleted.'],
        'product_deactivated' => ['bn' => 'পণ্যটি নিষ্ক্রিয় করা হয়েছে।', 'en' => 'Product marked as inactive.'],
        'product_import_done' => ['bn' => 'টি পণ্য সফলভাবে যোগ করা হয়েছে।', 'en' => 'products imported successfully.'],
        'sale_created'       => ['bn' => 'বিক্রয় সম্পন্ন হয়েছে।', 'en' => 'Sale completed.'],
        'sale_deleted'       => ['bn' => 'বিক্রয় মুছে ফেলা হয়েছে।', 'en' => 'Sale deleted.'],
        'sale_return_created' => ['bn' => 'রিটার্ন সফলভাবে সম্পন্ন হয়েছে।', 'en' => 'Sale return completed.'],
        'sale_return_deleted' => ['bn' => 'রিটার্ন মুছে ফেলা হয়েছে। স্টক ও বাকি পুনরুদ্ধার করা হয়েছে।', 'en' => 'Return deleted. Stock and due restored.'],
        'purchase_created'   => ['bn' => 'ক্রয় সম্পন্ন হয়েছে।', 'en' => 'Purchase completed.'],
        'purchase_deleted'   => ['bn' => 'ক্রয় মুছে ফেলা হয়েছে।', 'en' => 'Purchase deleted.'],
        'purchase_return_created' => ['bn' => 'ক্রয় রিটার্ন সফলভাবে সম্পন্ন হয়েছে।', 'en' => 'Purchase return completed.'],
        'purchase_return_deleted' => ['bn' => 'ক্রয় রিটার্ন মুছে ফেলা হয়েছে। স্টক ও বাকি পুনরুদ্ধার করা হয়েছে।', 'en' => 'Purchase return deleted. Stock and due restored.'],
        'expense_created'    => ['bn' => 'খরচ যোগ করা হয়েছে।', 'en' => 'Expense added.'],
        'expense_updated'    => ['bn' => 'খরচ আপডেট করা হয়েছে।', 'en' => 'Expense updated.'],
        'expense_deleted'    => ['bn' => 'খরচ মুছে ফেলা হয়েছে।', 'en' => 'Expense deleted.'],
        'damage_created'     => ['bn' => 'ড্যামেজ/হারানো রেকর্ড সংরক্ষণ করা হয়েছে।', 'en' => 'Damage/loss record saved.'],
        'damage_deleted'     => ['bn' => 'রেকর্ড মুছে ফেলা হয়েছে। স্টক ফিরিয়ে দেওয়া হয়েছে।', 'en' => 'Record deleted. Stock restored.'],
        'duepay_paid'        => ['bn' => 'বাকি পরিশোধ সফলভাবে রেকর্ড করা হয়েছে।', 'en' => 'Due payment recorded successfully.'],
        'duepay_collect'     => ['bn' => 'বাকি আদায় সফলভাবে রেকর্ড করা হয়েছে।', 'en' => 'Due collection recorded successfully.'],
        'duepay_deleted'     => ['bn' => 'লেনদেন মুছে ফেলা হয়েছে এবং বাকি পুনরায় যোগ হয়েছে।', 'en' => 'Transaction deleted and due amount restored.'],
        'profile_updated'    => ['bn' => 'প্রোফাইল আপডেট করা হয়েছে।', 'en' => 'Profile updated.'],
        'password_changed'   => ['bn' => 'পাসওয়ার্ড পরিবর্তন করা হয়েছে।', 'en' => 'Password changed.'],
        'settings_updated'   => ['bn' => 'সেটিংস আপডেট করা হয়েছে।', 'en' => 'Settings updated.'],
        'employee_created'   => ['bn' => 'নতুন কর্মচারী যোগ করা হয়েছে।', 'en' => 'New employee added.'],
        'employee_invited'   => ['bn' => 'কর্মচারীকে আমন্ত্রণ ইমেইল পাঠানো হয়েছে।', 'en' => 'An invitation email has been sent to the employee.'],
        'notifications_all_read' => ['bn' => 'সব নোটিফিকেশন পঠিত হিসেবে চিহ্নিত করা হয়েছে।', 'en' => 'All notifications marked as read.'],
        'feedback_thanks'    => ['bn' => 'আপনার মতামতের জন্য ধন্যবাদ!', 'en' => 'Thank you for your feedback!'],
        'no_account'         => ['bn' => 'এই মোবাইল নম্বরে কোনো অ্যাকাউন্ট নেই। প্রথমে রেজিস্টার করুন।', 'en' => 'No account exists for this mobile number. Please register first.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation messages (FormRequests / inline validators)
    |--------------------------------------------------------------------------
    */
    'valid' => [
        'register_phone_unique'  => ['bn' => 'এই মোবাইল নম্বরটি আগে থেকেই নিবন্ধিত।', 'en' => 'This mobile number is already registered.'],
        'register_email_unique'  => ['bn' => 'এই ইমেইলটি আগে থেকেই নিবন্ধিত।', 'en' => 'This email is already registered.'],
        'category_name_unique'   => ['bn' => 'এই নামে একটি ক্যাটাগরি ইতিমধ্যে আছে।', 'en' => 'A category with this name already exists.'],
        'customer_name_required' => ['bn' => 'কাস্টমারের নাম দিন।', 'en' => 'Enter the customer name.'],
        'customer_phone_unique'  => ['bn' => 'এই মোবাইল নম্বরে আগে থেকেই একজন কাস্টমার আছে।', 'en' => 'A customer with this mobile number already exists.'],
        'supplier_name_required' => ['bn' => 'সরবরাহকারীর নাম দিন।', 'en' => 'Enter the supplier name.'],
        'supplier_phone_unique'  => ['bn' => 'এই মোবাইল নম্বরে আগে থেকেই একজন সরবরাহকারী আছে।', 'en' => 'A supplier with this mobile number already exists.'],
        'product_name_required'  => ['bn' => 'পণ্যের নাম দিন।', 'en' => 'Enter the product name.'],
        'items_required'         => ['bn' => 'অন্তত একটি পণ্য যোগ করুন।', 'en' => 'Add at least one product.'],
        'expense_title_required' => ['bn' => 'খরচের বিবরণ দিন।', 'en' => 'Enter the expense description.'],
        'amount_required'        => ['bn' => 'টাকার পরিমাণ দিন।', 'en' => 'Enter the amount.'],
        'amount_min'             => ['bn' => 'টাকার পরিমাণ ০ এর বেশি হতে হবে।', 'en' => 'The amount must be greater than 0.'],
        'damage_product_required' => ['bn' => 'পণ্য নির্বাচন করুন।', 'en' => 'Select a product.'],
        'qty_required'           => ['bn' => 'পরিমাণ দিন।', 'en' => 'Enter the quantity.'],
        'party_type_required'    => ['bn' => 'কাস্টমার বা সরবরাহকারী নির্বাচন করুন।', 'en' => 'Select a customer or supplier.'],
        'party_id_required'      => ['bn' => 'নাম নির্বাচন করুন।', 'en' => 'Select a name.'],
        'party_id_exists'        => ['bn' => 'নির্বাচিত ব্যক্তি খুঁজে পাওয়া যায়নি।', 'en' => 'The selected party was not found.'],
        'name_required'          => ['bn' => 'নাম দিন।', 'en' => 'Enter the name.'],
        'phone_in_use'           => ['bn' => 'এই ফোন নম্বর আগে থেকে ব্যবহৃত হচ্ছে।', 'en' => 'This phone number is already in use.'],
        'email_in_use'           => ['bn' => 'এই ইমেইল আগে থেকে ব্যবহৃত হচ্ছে।', 'en' => 'This email is already in use.'],
        'business_name_required' => ['bn' => 'ব্যবসার নাম দিন।', 'en' => 'Enter the business name.'],
        'current_password_required' => ['bn' => 'বর্তমান পাসওয়ার্ড দিন।', 'en' => 'Enter your current password.'],
        'current_password_wrong' => ['bn' => 'বর্তমান পাসওয়ার্ড সঠিক নয়।', 'en' => 'The current password is incorrect.'],
        'password_required'      => ['bn' => 'নতুন পাসওয়ার্ড দিন।', 'en' => 'Enter a new password.'],
        'password_min'           => ['bn' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।', 'en' => 'The password must be at least 6 characters.'],
        'password_confirmed'     => ['bn' => 'পাসওয়ার্ড মিলছে না।', 'en' => 'The passwords do not match.'],
        'email_required'         => ['bn' => 'ইমেইল ঠিকানা দিন।', 'en' => 'Enter your email address.'],
        'email_invalid'          => ['bn' => 'সঠিক ইমেইল ঠিকানা দিন।', 'en' => 'Enter a valid email address.'],
        'employee_name_required' => ['bn' => 'কর্মচারীর নাম দিন।', 'en' => 'Enter the employee name.'],
        'employee_email_required' => ['bn' => 'কর্মচারীর ইমেইল দিন।', 'en' => 'Enter the employee email.'],
        'role_required'          => ['bn' => 'ভূমিকা নির্বাচন করুন।', 'en' => 'Select a role.'],
        'employee_password_required' => ['bn' => 'পাসওয়ার্ড দিন।', 'en' => 'Enter a password.'],
        'file_required'          => ['bn' => 'একটি ফাইল নির্বাচন করুন।', 'en' => 'Select a file.'],
        'file_mimes'             => ['bn' => 'শুধুমাত্র Excel (.xlsx, .xls) বা CSV ফাইল আপলোড করা যাবে।', 'en' => 'Only Excel (.xlsx, .xls) or CSV files can be uploaded.'],
        'file_max'               => ['bn' => 'ফাইলের আকার সর্বোচ্চ ৫ MB হতে পারে।', 'en' => 'The file may be at most 5 MB.'],
        'feedback_type_required' => ['bn' => 'ধরন নির্বাচন করুন।', 'en' => 'Select a type.'],
        'feedback_message_required' => ['bn' => 'আপনার মতামত লিখুন।', 'en' => 'Write your feedback.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Feedback
    |--------------------------------------------------------------------------
    */
    'feedback' => [
        'type_suggestion' => ['bn' => 'পরামর্শ', 'en' => 'Suggestion'],
        'type_bug'        => ['bn' => 'সমস্যা / বাগ', 'en' => 'Problem / Bug'],
        'type_complaint'  => ['bn' => 'অভিযোগ', 'en' => 'Complaint'],
        'type_praise'     => ['bn' => 'প্রশংসা', 'en' => 'Praise'],
        'type_other'      => ['bn' => 'অন্যান্য', 'en' => 'Other'],
        'form_title'      => ['bn' => 'মতামত / ফিডব্যাক', 'en' => 'Feedback'],
        'intro'           => ['bn' => 'আপনার মতামত আমাদের কাছে গুরুত্বপূর্ণ। সমস্যা, পরামর্শ বা প্রশংসা — যা কিছু থাকুক, জানান।', 'en' => 'Your feedback matters to us. Whether it is a problem, a suggestion, or praise — let us know.'],
        'type_label'      => ['bn' => 'ধরন', 'en' => 'Type'],
        'rating'          => ['bn' => 'রেটিং (ঐচ্ছিক)', 'en' => 'Rating (optional)'],
        'rating_aria'     => ['bn' => 'রেটিং', 'en' => 'Rating'],
        'message_label'   => ['bn' => 'আপনার মতামত', 'en' => 'Your Feedback'],
        'message_ph'      => ['bn' => 'এখানে লিখুন...', 'en' => 'Write here...'],
        'submit'          => ['bn' => 'পাঠান', 'en' => 'Send'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Category module
    |--------------------------------------------------------------------------
    */
    'category' => [
        'title'      => ['bn' => 'ক্যাটাগরি', 'en' => 'Categories'],
        'new'        => ['bn' => 'নতুন ক্যাটাগরি', 'en' => 'New Category'],
        'edit_title' => ['bn' => 'ক্যাটাগরি সম্পাদনা', 'en' => 'Edit Category'],
        'empty'      => ['bn' => 'কোনো ক্যাটাগরি নেই।', 'en' => 'No categories.'],
        'name_label' => ['bn' => 'ক্যাটাগরির নাম', 'en' => 'Category Name'],
        'name_ph'    => ['bn' => 'যেমন: চাল, তেল', 'en' => 'e.g. Rice, Oil'],
        'search_ph'  => ['bn' => 'নাম দিয়ে খুঁজুন...', 'en' => 'Search by name...'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Customer module
    |--------------------------------------------------------------------------
    */
    'customer' => [
        'title'          => ['bn' => 'কাস্টমার', 'en' => 'Customers'],
        'new'            => ['bn' => 'নতুন কাস্টমার', 'en' => 'New Customer'],
        'edit_title'     => ['bn' => 'কাস্টমার সম্পাদনা', 'en' => 'Edit Customer'],
        'empty'          => ['bn' => 'কোনো কাস্টমার নেই।', 'en' => 'No customers.'],
        'name_label'     => ['bn' => 'কাস্টমারের নাম', 'en' => 'Customer Name'],
        'name_ph'        => ['bn' => 'যেমন: করিম মিয়া', 'en' => 'e.g. Karim Mia'],
        'mobile'         => ['bn' => 'মোবাইল', 'en' => 'Mobile'],
        'orders'         => ['bn' => 'অর্ডার', 'en' => 'Orders'],
        'sales'          => ['bn' => 'বিক্রয়', 'en' => 'Sales'],
        'due'            => ['bn' => 'বাকি', 'en' => 'Due'],
        'prev_due'       => ['bn' => 'পূর্ববর্তী বাকি (৳)', 'en' => 'Previous Due (৳)'],
        'search_ph'      => ['bn' => 'নাম বা মোবাইল দিয়ে খুঁজুন...', 'en' => 'Search by name or mobile...'],
        'due_locked_note' => ['bn' => 'বাকি এখান থেকে পরিবর্তন করা যাবে না।', 'en' => 'The due amount cannot be changed here.'],
        'collect_due'    => ['bn' => 'বাকি আদায়', 'en' => 'Collect Due'],
        'use_page'       => ['bn' => 'পেজ ব্যবহার করুন।', 'en' => 'Use the page.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Supplier module
    |--------------------------------------------------------------------------
    */
    'supplier' => [
        'title'          => ['bn' => 'সরবরাহকারী', 'en' => 'Suppliers'],
        'new'            => ['bn' => 'নতুন সরবরাহকারী', 'en' => 'New Supplier'],
        'edit_title'     => ['bn' => 'সরবরাহকারী সম্পাদনা', 'en' => 'Edit Supplier'],
        'empty'          => ['bn' => 'কোনো সরবরাহকারী নেই।', 'en' => 'No suppliers.'],
        'name_label'     => ['bn' => 'সরবরাহকারীর নাম', 'en' => 'Supplier Name'],
        'name_ph'        => ['bn' => 'যেমন: ঢাকা ট্রেডার্স', 'en' => 'e.g. Dhaka Traders'],
        'mobile'         => ['bn' => 'মোবাইল', 'en' => 'Mobile'],
        'purchases'      => ['bn' => 'ক্রয়', 'en' => 'Purchases'],
        'due'            => ['bn' => 'বাকি', 'en' => 'Due'],
        'prev_due'       => ['bn' => 'পূর্ববর্তী বাকি (৳)', 'en' => 'Previous Due (৳)'],
        'search_ph'      => ['bn' => 'নাম বা মোবাইল দিয়ে খুঁজুন...', 'en' => 'Search by name or mobile...'],
        'due_locked_note' => ['bn' => 'বাকি এখান থেকে পরিবর্তন করা যাবে না।', 'en' => 'The due amount cannot be changed here.'],
        'pay_due'        => ['bn' => 'বাকি পরিশোধ', 'en' => 'Pay Due'],
        'use_page'       => ['bn' => 'পেজ ব্যবহার করুন।', 'en' => 'Use the page.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Product module
    |--------------------------------------------------------------------------
    */
    'product' => [
        'title'                  => ['bn' => 'পণ্য', 'en' => 'Products'],
        'new'                    => ['bn' => 'নতুন পণ্য', 'en' => 'Create Product'],
        'list'                   => ['bn' => 'পণ্য তালিকা', 'en' => 'Product List'],
        'edit_title'             => ['bn' => 'পণ্য সম্পাদনা', 'en' => 'Edit Product'],
        'empty'                  => ['bn' => 'কোনো পণ্য নেই।', 'en' => 'No products.'],
        'name_label'             => ['bn' => 'পণ্যের নাম', 'en' => 'Product Name'],
        'name_ph'                => ['bn' => 'যেমন: মিনিকেট চাল', 'en' => 'e.g. Miniket Rice'],
        'category'               => ['bn' => 'ক্যাটাগরি', 'en' => 'Category'],
        'category_optional_select' => ['bn' => '— ঐচ্ছিক ক্যাটাগরি নির্বাচন করুন —', 'en' => '— Select category (optional) —'],
        'all_categories'         => ['bn' => 'সব ক্যাটাগরি', 'en' => 'All Categories'],
        'barcode'                => ['bn' => 'বারকোড', 'en' => 'Barcode'],
        'unit'                   => ['bn' => 'একক', 'en' => 'Unit'],
        'purchase_price'         => ['bn' => 'ক্রয়মূল্য', 'en' => 'Purchase Price'],
        'sale_price'             => ['bn' => 'বিক্রয়মূল্য', 'en' => 'Sale Price'],
        'purchase_price_label'   => ['bn' => 'ক্রয়মূল্য (৳)', 'en' => 'Purchase Price (৳)'],
        'sale_price_label'       => ['bn' => 'বিক্রয়মূল্য (৳)', 'en' => 'Sale Price (৳)'],
        'stock'                  => ['bn' => 'স্টক', 'en' => 'Stock'],
        'current_stock'          => ['bn' => 'বর্তমান স্টক', 'en' => 'Current Stock'],
        'low'                    => ['bn' => 'কম', 'en' => 'Low'],
        'low_stock_alert'        => ['bn' => 'কম স্টক সতর্কতা', 'en' => 'Low Stock Alert'],
        'search_ph'              => ['bn' => 'নাম বা বারকোড দিয়ে খুঁজুন...', 'en' => 'Search by name or barcode...'],
        'barcode_scan'           => ['bn' => 'বারকোড স্ক্যান', 'en' => 'Barcode Scan'],
        'barcode_scan_title'     => ['bn' => 'বারকোড স্ক্যান করুন', 'en' => 'Scan Barcode'],
        'scan_with_camera'       => ['bn' => 'ক্যামেরা দিয়ে স্ক্যান করুন', 'en' => 'Scan with camera'],
        'hold_barcode'           => ['bn' => 'ক্যামেরার সামনে বারকোড ধরুন', 'en' => 'Hold the barcode in front of the camera'],
        'hold_product_barcode'   => ['bn' => 'পণ্যের বারকোড ক্যামেরার সামনে ধরুন', 'en' => 'Hold the product barcode in front of the camera'],
        'camera_failed'          => ['bn' => 'ক্যামেরা চালু করা যায়নি। অনুমতি দিন।', 'en' => 'Could not start the camera. Please allow access.'],
        'camera_failed_manual'   => ['bn' => 'ক্যামেরা চালু করা যায়নি। অনুমতি দিন বা ম্যানুয়ালি লিখুন।', 'en' => 'Could not start the camera. Allow access or enter it manually.'],
        'excel_import'           => ['bn' => 'Excel ইমপোর্ট', 'en' => 'Excel Import'],
        'import_title'           => ['bn' => 'Excel দিয়ে পণ্য ইমপোর্ট', 'en' => 'Import Products via Excel'],
        'import_step1'           => ['bn' => 'নিচের বাটন থেকে টেমপ্লেট ডাউনলোড করুন।', 'en' => 'Download the template from the button below.'],
        'import_step2_pre'       => ['bn' => 'প্রথম সারির শিরোনাম (কলামের নাম)', 'en' => 'Keep the first row headers (column names)'],
        'import_step2_strong'    => ['bn' => 'অপরিবর্তিত', 'en' => 'unchanged'],
        'import_step2_post'      => ['bn' => 'রাখুন।', 'en' => '.'],
        'import_step3'           => ['bn' => 'দ্বিতীয় সারি থেকে পণ্যের তথ্য লিখুন ও আপলোড করুন।', 'en' => 'From the second row, enter product details and upload.'],
        'template_download'      => ['bn' => 'টেমপ্লেট ডাউনলোড', 'en' => 'Download Template'],
        'excel_csv_file'         => ['bn' => 'Excel / CSV ফাইল', 'en' => 'Excel / CSV File'],
        'header_order'           => ['bn' => 'শিরোনাম ক্রম: পণ্যের নাম · ক্যাটাগরি · বারকোড · ক্রয়মূল্য · বিক্রয়মূল্য · একক · বর্তমান স্টক · কম স্টক সতর্কতা।', 'en' => 'Header order: Product Name · Category · Barcode · Purchase Price · Sale Price · Unit · Current Stock · Low Stock Alert.'],
        'import_btn'             => ['bn' => 'ইমপোর্ট করুন', 'en' => 'Import'],
        'some_rows_skipped'      => ['bn' => 'কিছু সারি বাদ পড়েছে:', 'en' => 'Some rows were skipped:'],
        'in_use_title'           => ['bn' => 'পণ্য মুছা যাচ্ছে না', 'en' => 'Cannot Delete Product'],
        'in_use_body'            => ['bn' => 'এই পণ্যটি বিক্রয়, ক্রয় বা অন্য কোনো রেকর্ডে ব্যবহৃত হয়েছে, তাই মুছা সম্ভব নয়। পণ্যটি আর প্রয়োজন না হলে নিষ্ক্রিয় করুন।', 'en' => 'This product is linked to existing sales, purchases, or other records and cannot be deleted. If it is no longer needed, you can mark it as inactive instead.'],
        'make_inactive'          => ['bn' => 'নিষ্ক্রিয় করুন', 'en' => 'Make Inactive'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Expense module
    |--------------------------------------------------------------------------
    */
    'expense' => [
        'title'        => ['bn' => 'খরচ', 'en' => 'Expenses'],
        'new'          => ['bn' => 'নতুন খরচ', 'en' => 'New Expense'],
        'edit_title'   => ['bn' => 'খরচ সম্পাদনা', 'en' => 'Edit Expense'],
        'empty'        => ['bn' => 'কোনো খরচ নেই।', 'en' => 'No expenses.'],
        'search_ph'    => ['bn' => 'খরচের বিবরণ দিয়ে খুঁজুন...', 'en' => 'Search by expense description...'],
        'money'        => ['bn' => 'টাকা', 'en' => 'Amount'],
        'title_label'  => ['bn' => 'খরচের বিবরণ', 'en' => 'Expense Description'],
        'title_ph'     => ['bn' => 'যেমন: দোকান ভাড়া', 'en' => 'e.g. Shop Rent'],
        'amount_label' => ['bn' => 'টাকার পরিমাণ (৳)', 'en' => 'Amount (৳)'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sale module (sales list, POS, invoice)
    |--------------------------------------------------------------------------
    */
    'sale' => [
        'title'               => ['bn' => 'বিক্রয়', 'en' => 'Sales'],
        'new_pos'             => ['bn' => 'নতুন বিক্রয় (POS)', 'en' => 'New Sale (POS)'],
        'list'                => ['bn' => 'বিক্রয় তালিকা', 'en' => 'Sales List'],
        'search_ph'           => ['bn' => 'ইনভয়েস বা কাস্টমার দিয়ে খুঁজুন...', 'en' => 'Search by invoice or customer...'],
        'items_col'           => ['bn' => 'আইটেম', 'en' => 'Items'],
        'paid'                => ['bn' => 'পরিশোধ', 'en' => 'Paid'],
        'due'                 => ['bn' => 'বাকি', 'en' => 'Due'],
        'paid_off'            => ['bn' => 'পরিশোধিত', 'en' => 'Paid'],
        'walkin_short'        => ['bn' => 'ওয়াক-ইন', 'en' => 'Walk-in'],
        'walkin'              => ['bn' => 'ওয়াক-ইন কাস্টমার', 'en' => 'Walk-in Customer'],
        'delete_confirm'      => ['bn' => 'এই বিক্রয় মুছলে স্টক ফেরত যাবে। নিশ্চিত?', 'en' => 'Deleting this sale will restore the stock. Are you sure?'],
        'empty'               => ['bn' => 'কোনো বিক্রয় নেই।', 'en' => 'No sales.'],
        'status_draft'        => ['bn' => 'খসড়া', 'en' => 'Draft'],
        'status_cancelled'    => ['bn' => 'বাতিল', 'en' => 'Cancelled'],
        'whatsapp'            => ['bn' => 'হোয়াটসঅ্যাপ', 'en' => 'WhatsApp'],
        'customer_label'      => ['bn' => 'গ্রাহক', 'en' => 'Customer'],
        'salesperson'         => ['bn' => 'বিক্রয়কর্মী', 'en' => 'Salesperson'],
        'price_col'           => ['bn' => 'দাম', 'en' => 'Price'],
        'unit_price'          => ['bn' => 'একক দাম', 'en' => 'Unit Price'],
        'items_suffix'        => ['bn' => 'টি পণ্য', 'en' => 'items'],
        'total_qty'           => ['bn' => 'মোট পরিমাণ', 'en' => 'Total Quantity'],
        'subtotal'            => ['bn' => 'সাবটোটাল', 'en' => 'Subtotal'],
        'discount'            => ['bn' => 'ছাড়', 'en' => 'Discount'],
        'grand_total'         => ['bn' => 'সর্বমোট', 'en' => 'Grand Total'],
        'authorized_sign'     => ['bn' => 'কর্তৃপক্ষের স্বাক্ষর', 'en' => 'Authorized Signature'],
        'thanks'              => ['bn' => 'কেনাকাটার জন্য ধন্যবাদ', 'en' => 'Thank you for your purchase'],
        'search_product'      => ['bn' => 'পণ্য খুঁজুন', 'en' => 'Search Product'],
        'search_product_ph'   => ['bn' => 'পণ্যের নাম লিখুন বা বারকোড স্ক্যান করুন...', 'en' => 'Type product name or scan barcode...'],
        'cart_empty'          => ['bn' => 'কার্ট খালি', 'en' => 'Cart is empty'],
        'you'                 => ['bn' => 'আপনি', 'en' => 'You'],
        'discount_amount'     => ['bn' => 'ছাড় (৳)', 'en' => 'Discount (৳)'],
        'paid_amount'         => ['bn' => 'পরিশোধ (৳)', 'en' => 'Paid (৳)'],
        'full_ph'             => ['bn' => 'পূর্ণ', 'en' => 'Full'],
        'tendered'            => ['bn' => 'প্রদানকৃত টাকা (৳)', 'en' => 'Cash Tendered (৳)'],
        'change_due'          => ['bn' => 'ফেরতযোগ্য টাকা', 'en' => 'Change Due'],
        'toggle_discount_due' => ['bn' => 'ছাড় / বাকি রাখুন', 'en' => 'Add Discount / Due'],
        'note_ph'             => ['bn' => 'নোট (ঐচ্ছিক)', 'en' => 'Note (optional)'],
        'complete'            => ['bn' => 'সম্পন্ন করুন', 'en' => 'Complete'],
        'save'                => ['bn' => 'সংরক্ষণ', 'en' => 'Save'],
        'no_product_found'    => ['bn' => 'কোনো পণ্য পাওয়া যায়নি', 'en' => 'No product found'],
        'prev_due_label'      => ['bn' => 'পূর্ববর্তী বকেয়াঃ', 'en' => 'Previous due:'],
        'customer_add_failed' => ['bn' => 'কাস্টমার যোগ করা যায়নি।', 'en' => 'Could not add customer.'],
        'server_error'        => ['bn' => 'সার্ভার ত্রুটি। আবার চেষ্টা করুন।', 'en' => 'Server error. Please try again.'],
        'clear_cart'          => ['bn' => 'কার্ট খালি করুন', 'en' => 'Clear Cart'],
        'edit_title'          => ['bn' => 'বিক্রয় সম্পাদনা', 'en' => 'Edit Sale'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sale Return module
    |--------------------------------------------------------------------------
    */
    'sale_return' => [
        'title'            => ['bn' => 'বিক্রয় রিটার্ন', 'en' => 'Sale Return'],
        'new_title'        => ['bn' => 'বিক্রয় রিটার্ন করুন', 'en' => 'Create Sale Return'],
        'receipt'          => ['bn' => 'রিটার্ন রসিদ', 'en' => 'Return Receipt'],
        'return_no'        => ['bn' => 'রিটার্ন নং', 'en' => 'Return No'],
        'original_invoice' => ['bn' => 'মূল ইনভয়েস', 'en' => 'Original Invoice'],
        'sold_qty'         => ['bn' => 'বিক্রিত', 'en' => 'Sold'],
        'returnable_qty'   => ['bn' => 'রিটার্নযোগ্য', 'en' => 'Returnable'],
        'return_qty'       => ['bn' => 'রিটার্ন', 'en' => 'Return Qty'],
        'return_total'     => ['bn' => 'রিটার্ন মোট', 'en' => 'Return Total'],
        'refunded'         => ['bn' => 'নগদ ফেরত', 'en' => 'Cash Refunded'],
        'adjusted_due'     => ['bn' => 'বাকি থেকে কমানো', 'en' => 'Adjusted from Due'],
        'reason'           => ['bn' => 'কারণ', 'en' => 'Reason'],
        'reason_ph'        => ['bn' => 'রিটার্নের কারণ (ঐচ্ছিক)', 'en' => 'Reason for return (optional)'],
        'return_all'       => ['bn' => 'সবকিছু রিটার্ন', 'en' => 'Return All'],
        'confirm_btn'      => ['bn' => 'রিটার্ন সম্পন্ন করুন', 'en' => 'Confirm Return'],
        'delete_confirm'   => ['bn' => 'এই রিটার্ন মুছলে স্টক কমবে ও বাকি ফিরে আসবে। নিশ্চিত?', 'en' => 'Deleting this return will reverse stock and due changes. Are you sure?'],
        'none_yet'         => ['bn' => 'কোনো রিটার্ন হয়নি', 'en' => 'No returns yet'],
        'returned'         => ['bn' => 'রিটার্ন', 'en' => 'Returned'],
        'net_sale'         => ['bn' => 'নেট বিক্রয়', 'en' => 'Net Sale'],
        'view_return'      => ['bn' => 'রিটার্ন দেখুন', 'en' => 'View Return'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Purchase module (purchase list, create, voucher)
    |--------------------------------------------------------------------------
    */
    'purchase' => [
        'title'               => ['bn' => 'ক্রয়', 'en' => 'Purchases'],
        'search_ph'           => ['bn' => 'ইনভয়েস, সরবরাহকারীর নাম বা মোবাইল দিয়ে খুঁজুন...', 'en' => 'Search by invoice, supplier name or mobile...'],
        'items_col'           => ['bn' => 'আইটেম', 'en' => 'Items'],
        'paid'                => ['bn' => 'পরিশোধ', 'en' => 'Paid'],
        'due'                 => ['bn' => 'বাকি', 'en' => 'Due'],
        'paid_off'            => ['bn' => 'পরিশোধিত', 'en' => 'Paid'],
        'cash_purchase'       => ['bn' => 'নগদ ক্রয়', 'en' => 'Cash Purchase'],
        'delete_confirm_pre'  => ['bn' => 'ইনভয়েস', 'en' => 'Invoice'],
        'delete_confirm_post' => ['bn' => 'মুছে ফেলা হবে এবং স্টক ফিরিয়ে নেওয়া হবে।', 'en' => 'will be deleted and stock will be restored.'],
        'empty'               => ['bn' => 'কোনো ক্রয় নেই।', 'en' => 'No purchases.'],
        'list'                => ['bn' => 'ক্রয় তালিকা', 'en' => 'Purchase List'],
        'purchase_date'       => ['bn' => 'ক্রয়ের তারিখ', 'en' => 'Purchase Date'],
        'assigned_staff'      => ['bn' => 'দায়িত্বপ্রাপ্ত কর্মী', 'en' => 'Assigned Staff'],
        'add_product'         => ['bn' => 'পণ্য যোগ করুন', 'en' => 'Add Product'],
        'product_search_ph'   => ['bn' => 'পণ্যের নাম বা বারকোড লিখুন...', 'en' => 'Type product name or barcode...'],
        'no_items'            => ['bn' => 'কোনো পণ্য যোগ করা হয়নি', 'en' => 'No products added'],
        'paid_amount'         => ['bn' => 'পরিশোধ (৳)', 'en' => 'Paid (৳)'],
        'full_ph'             => ['bn' => 'পূর্ণ', 'en' => 'Full'],
        'note_ph'             => ['bn' => 'নোট (ঐচ্ছিক)', 'en' => 'Note (optional)'],
        'save'                => ['bn' => 'ক্রয় সংরক্ষণ করুন', 'en' => 'Save Purchase'],
        'save_and_add'        => ['bn' => 'সংরক্ষণ করুন', 'en' => 'Save'],
        'save_and_select'     => ['bn' => 'সংরক্ষণ ও নির্বাচন', 'en' => 'Save & Select'],
        'product_add_failed'  => ['bn' => 'পণ্য যোগ করা যায়নি।', 'en' => 'Could not add product.'],
        'supplier_add_failed' => ['bn' => 'সরবরাহকারী যোগ করা যায়নি।', 'en' => 'Could not add supplier.'],
        'server_error'        => ['bn' => 'সার্ভার ত্রুটি। আবার চেষ্টা করুন।', 'en' => 'Server error. Please try again.'],
        'voucher'             => ['bn' => 'ক্রয় ভাউচার', 'en' => 'Purchase Voucher'],
        'status_completed'    => ['bn' => 'সম্পন্ন', 'en' => 'Completed'],
        'status_draft'        => ['bn' => 'খসড়া', 'en' => 'Draft'],
        'whatsapp'            => ['bn' => 'হোয়াটসঅ্যাপ', 'en' => 'WhatsApp'],
        'received_by'         => ['bn' => 'গ্রহণকারী', 'en' => 'Received By'],
        'items_suffix'        => ['bn' => 'টি পণ্য', 'en' => 'items'],
        'total_qty'           => ['bn' => 'মোট পরিমাণ', 'en' => 'Total Quantity'],
        'grand_total'         => ['bn' => 'সর্বমোট', 'en' => 'Grand Total'],
        'authorized_sign'     => ['bn' => 'কর্তৃপক্ষের স্বাক্ষর', 'en' => 'Authorized Signature'],
        'thanks'              => ['bn' => 'ধন্যবাদ', 'en' => 'Thank you'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Purchase Return module
    |--------------------------------------------------------------------------
    */
    'purchase_return' => [
        'title'            => ['bn' => 'ক্রয় রিটার্ন', 'en' => 'Purchase Return'],
        'new_title'        => ['bn' => 'ক্রয় রিটার্ন করুন', 'en' => 'Create Purchase Return'],
        'receipt'          => ['bn' => 'রিটার্ন রসিদ', 'en' => 'Return Receipt'],
        'return_no'        => ['bn' => 'রিটার্ন নং', 'en' => 'Return No'],
        'original_invoice' => ['bn' => 'মূল ইনভয়েস', 'en' => 'Original Invoice'],
        'purchased_qty'    => ['bn' => 'ক্রয়কৃত', 'en' => 'Purchased'],
        'returnable_qty'   => ['bn' => 'রিটার্নযোগ্য', 'en' => 'Returnable'],
        'return_qty'       => ['bn' => 'রিটার্ন', 'en' => 'Return Qty'],
        'return_total'     => ['bn' => 'রিটার্ন মোট', 'en' => 'Return Total'],
        'refunded'         => ['bn' => 'নগদ ফেরত পেয়েছি', 'en' => 'Cash Received'],
        'adjusted_due'     => ['bn' => 'বাকি থেকে কমানো', 'en' => 'Adjusted from Due'],
        'reason'           => ['bn' => 'কারণ', 'en' => 'Reason'],
        'reason_ph'        => ['bn' => 'রিটার্নের কারণ (ঐচ্ছিক)', 'en' => 'Reason for return (optional)'],
        'return_all'       => ['bn' => 'সবকিছু রিটার্ন', 'en' => 'Return All'],
        'confirm_btn'      => ['bn' => 'রিটার্ন সম্পন্ন করুন', 'en' => 'Confirm Return'],
        'delete_confirm'   => ['bn' => 'এই রিটার্ন মুছলে স্টক বাড়বে ও বাকি ফিরে আসবে। নিশ্চিত?', 'en' => 'Deleting this return will reverse stock and due changes. Are you sure?'],
        'none_yet'         => ['bn' => 'কোনো রিটার্ন হয়নি', 'en' => 'No returns yet'],
        'returned'         => ['bn' => 'রিটার্ন', 'en' => 'Returned'],
        'view_return'      => ['bn' => 'রিটার্ন দেখুন', 'en' => 'View Return'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Due payments module (due ledger, record payment, history)
    |--------------------------------------------------------------------------
    */
    'duepay' => [
        'title'             => ['bn' => 'বাকির খাতা', 'en' => 'Due Ledger'],
        'history'           => ['bn' => 'লেনদেন ইতিহাস', 'en' => 'Transaction History'],
        'collect_pay'       => ['bn' => 'আদায় / পরিশোধ', 'en' => 'Collect / Pay'],
        'receivable'        => ['bn' => 'কাস্টমারের কাছে পাওনা', 'en' => 'Receivable from Customers'],
        'payable'           => ['bn' => 'সরবরাহকারীকে দেনা', 'en' => 'Payable to Suppliers'],
        'due_list'          => ['bn' => 'বাকি তালিকা', 'en' => 'Due List'],
        'search_ph'         => ['bn' => 'নাম বা মোবাইল দিয়ে খুঁজুন', 'en' => 'Search by name or mobile'],
        'type'              => ['bn' => 'ধরন', 'en' => 'Type'],
        'due'               => ['bn' => 'বাকি', 'en' => 'Due'],
        'collect'           => ['bn' => 'আদায়', 'en' => 'Collect'],
        'pay'               => ['bn' => 'পরিশোধ', 'en' => 'Pay'],
        'empty'             => ['bn' => 'কোনো বাকি নেই।', 'en' => 'No dues.'],
        'new_transaction'   => ['bn' => 'নতুন লেনদেন', 'en' => 'New Transaction'],
        'collect_customer'  => ['bn' => 'কাস্টমার বাকি আদায়', 'en' => 'Collect Customer Due'],
        'pay_supplier'      => ['bn' => 'সরবরাহকারী পরিশোধ', 'en' => 'Pay Supplier'],
        'select_ph'         => ['bn' => '— নির্বাচন করুন —', 'en' => '— Select —'],
        'amount_tk'         => ['bn' => 'পরিমাণ (৳)', 'en' => 'Amount (৳)'],
        'method_label'      => ['bn' => 'পেমেন্ট মাধ্যম', 'en' => 'Payment Method'],
        'note_ph'           => ['bn' => 'যেমন: চেক নং', 'en' => 'e.g. Cheque No.'],
        'method_cash'       => ['bn' => 'নগদ', 'en' => 'Cash'],
        'method_bkash'      => ['bn' => 'বিকাশ', 'en' => 'bKash'],
        'method_nagad'      => ['bn' => 'নগদ (Nagad)', 'en' => 'Nagad'],
        'method_rocket'     => ['bn' => 'রকেট', 'en' => 'Rocket'],
        'method_bank'       => ['bn' => 'ব্যাংক', 'en' => 'Bank'],
        'method_other'      => ['bn' => 'অন্যান্য', 'en' => 'Other'],
        'due_inline'        => ['bn' => 'বাকিঃ', 'en' => 'Due:'],
        'current_due'       => ['bn' => 'বর্তমান বাকিঃ', 'en' => 'Current Due:'],
        'all_transactions'  => ['bn' => 'সকল লেনদেন', 'en' => 'All Transactions'],
        'method_col'        => ['bn' => 'মাধ্যম', 'en' => 'Method'],
        'delete_confirm'    => ['bn' => 'এই লেনদেন মুছলে বাকি পুনরায় যোগ হবে। নিশ্চিত?', 'en' => 'Deleting this transaction will restore the due. Are you sure?'],
        'empty_transactions' => ['bn' => 'কোনো লেনদেন নেই।', 'en' => 'No transactions.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Damage / Loss module
    |--------------------------------------------------------------------------
    */
    'damage' => [
        'title'          => ['bn' => 'ড্যামেজ / হারানো', 'en' => 'Damage / Loss'],
        'new_record'     => ['bn' => 'নতুন রেকর্ড', 'en' => 'New Record'],
        'list'           => ['bn' => 'তালিকা', 'en' => 'List'],
        'search_ph'      => ['bn' => 'পণ্য বা কারণ দিয়ে খুঁজুন...', 'en' => 'Search by product or reason...'],
        'type'           => ['bn' => 'ধরন', 'en' => 'Type'],
        'reason'         => ['bn' => 'কারণ', 'en' => 'Reason'],
        'lost'           => ['bn' => 'হারানো', 'en' => 'Lost'],
        'damage'         => ['bn' => 'ড্যামেজ', 'en' => 'Damage'],
        'stock_restore'  => ['bn' => 'স্টক ফিরিয়ে দেওয়া হবে।', 'en' => 'Stock will be restored.'],
        'empty'          => ['bn' => 'কোনো রেকর্ড নেই।', 'en' => 'No records.'],
        'new_title'      => ['bn' => 'ড্যামেজ / হারানো পণ্য', 'en' => 'Damage / Lost Product'],
        'select_product' => ['bn' => '— পণ্য নির্বাচন করুন —', 'en' => '— Select product —'],
        'reason_ph'      => ['bn' => 'যেমন: মেয়াদ শেষ, ভেঙে গেছে', 'en' => 'e.g. Expired, Broken'],
        'stock_warning'  => ['bn' => 'এই পরিমাণ স্টক থেকে কমে যাবে।', 'en' => 'This quantity will be deducted from stock.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reports module (report landing, shared partials, individual reports)
    |--------------------------------------------------------------------------
    */
    'report' => [
        // Report names (index cards, page headers, titles)
        'daily_sales'         => ['bn' => 'ডেইলি সেলস রিপোর্ট', 'en' => 'Daily Sales Report'],
        'monthly_sales'       => ['bn' => 'মাসিক সেলস রিপোর্ট', 'en' => 'Monthly Sales Report'],
        'purchase'            => ['bn' => 'ক্রয় রিপোর্ট', 'en' => 'Purchase Report'],
        'stock'               => ['bn' => 'বর্তমান স্টক রিপোর্ট', 'en' => 'Current Stock Report'],
        'low_stock'           => ['bn' => 'কম স্টক রিপোর্ট', 'en' => 'Low Stock Report'],
        'customer_due'        => ['bn' => 'কাস্টমার বাকি রিপোর্ট', 'en' => 'Customer Due Report'],
        'supplier_due'        => ['bn' => 'সরবরাহকারী বাকি রিপোর্ট', 'en' => 'Supplier Due Report'],
        'expense'             => ['bn' => 'খরচ রিপোর্ট', 'en' => 'Expense Report'],
        'cash_book'           => ['bn' => 'ক্যাশ বুক রিপোর্ট', 'en' => 'Cash Book Report'],
        'profit_loss'         => ['bn' => 'লাভ ও ক্ষতি রিপোর্ট', 'en' => 'Profit & Loss Report'],

        // Index page phase groupings
        'phase1'              => ['bn' => 'ফেজ ১', 'en' => 'Phase 1'],
        'phase2'              => ['bn' => 'ফেজ ২', 'en' => 'Phase 2'],
        'phase3'              => ['bn' => 'ফেজ ৩', 'en' => 'Phase 3'],
        'profit_by_product'   => ['bn' => 'পণ্য অনুযায়ী লাভ', 'en' => 'Profit by Product'],
        'stock_ledger'        => ['bn' => 'স্টক লেজার', 'en' => 'Stock Ledger'],
        'customer_ledger'     => ['bn' => 'কাস্টমার লেজার', 'en' => 'Customer Ledger'],
        'supplier_ledger'     => ['bn' => 'সরবরাহকারী লেজার', 'en' => 'Supplier Ledger'],
        'top_selling'         => ['bn' => 'টপ সেলিং পণ্য', 'en' => 'Top Selling Products'],
        'business_health'     => ['bn' => 'বিজনেস হেলথ', 'en' => 'Business Health'],
        'ai_insights'         => ['bn' => 'এআই ইনসাইটস', 'en' => 'AI Insights'],
        'forecasting'         => ['bn' => 'ফোরকাস্টিং', 'en' => 'Forecasting'],

        // Range / date filters
        'from'                => ['bn' => 'শুরু', 'en' => 'From'],
        'to'                  => ['bn' => 'শেষ', 'en' => 'To'],
        'month'               => ['bn' => 'মাস', 'en' => 'Month'],

        // Summary cards & column labels
        'total_sales'         => ['bn' => 'মোট বিক্রয়', 'en' => 'Total Sales'],
        'total_purchase'      => ['bn' => 'মোট ক্রয়', 'en' => 'Total Purchase'],
        'total_expenses'      => ['bn' => 'মোট খরচ', 'en' => 'Total Expenses'],
        'total_products'      => ['bn' => 'মোট পণ্য', 'en' => 'Total Products'],
        'total_due'           => ['bn' => 'মোট বাকি', 'en' => 'Total Due'],
        'paid'                => ['bn' => 'পরিশোধ', 'en' => 'Paid'],
        'due'                 => ['bn' => 'বাকি', 'en' => 'Due'],
        'estimated_profit'    => ['bn' => 'আনুমানিক লাভ', 'en' => 'Estimated Profit'],
        'orders'              => ['bn' => 'অর্ডার', 'en' => 'Orders'],
        'invoice'             => ['bn' => 'ইনভয়েস', 'en' => 'Invoice'],
        'items'               => ['bn' => 'আইটেম', 'en' => 'Items'],
        'walkin'              => ['bn' => 'ওয়াক-ইন', 'en' => 'Walk-in'],
        'grand_total'         => ['bn' => 'সর্বমোট', 'en' => 'Grand Total'],
        'sales_suffix'        => ['bn' => 'টি বিক্রয়', 'en' => 'sales'],
        'daily_breakdown'     => ['bn' => 'দৈনিক বিভাজন', 'en' => 'Daily Breakdown'],
        'invoice_count'       => ['bn' => 'ইনভয়েস সংখ্যা', 'en' => 'Invoice Count'],
        'entry_count'         => ['bn' => 'এন্ট্রি সংখ্যা', 'en' => 'Entry Count'],
        'expense_head'        => ['bn' => 'খরচের খাত', 'en' => 'Expense Head'],

        // Profit & loss rows
        'revenue'             => ['bn' => 'মোট বিক্রয় (রাজস্ব)', 'en' => 'Total Sales (Revenue)'],
        'included_discount'   => ['bn' => 'এর মধ্যে ছাড়', 'en' => 'Of which discount'],
        'cogs'                => ['bn' => 'বিক্রিত পণ্যের ক্রয়মূল্য (COGS)', 'en' => 'Cost of Goods Sold (COGS)'],
        'gross_profit'        => ['bn' => 'গ্রস লাভ', 'en' => 'Gross Profit'],
        'net_profit'          => ['bn' => 'নিট লাভ / ক্ষতি', 'en' => 'Net Profit / Loss'],

        // Stock report
        'stock_value_cost'    => ['bn' => 'স্টক মূল্য (ক্রয়)', 'en' => 'Stock Value (Cost)'],
        'stock_value_sale'    => ['bn' => 'স্টক মূল্য (বিক্রয়)', 'en' => 'Stock Value (Sale)'],
        'stock_value'         => ['bn' => 'স্টক মূল্য', 'en' => 'Stock Value'],
        'total_stock_value_cost' => ['bn' => 'মোট স্টক মূল্য (ক্রয়)', 'en' => 'Total Stock Value (Cost)'],

        // Low stock report
        'low_stock_count_suffix' => ['bn' => 'টি পণ্যের স্টক সতর্কতা সীমার নিচে', 'en' => 'products are below the alert threshold'],
        'current_stock'       => ['bn' => 'বর্তমান স্টক', 'en' => 'Current Stock'],
        'alert_threshold'     => ['bn' => 'সতর্কতা সীমা', 'en' => 'Alert Threshold'],
        'shortage'            => ['bn' => 'ঘাটতি', 'en' => 'Shortage'],

        // Due reports
        'due_customers'       => ['bn' => 'বাকিদার কাস্টমার', 'en' => 'Customers with Due'],
        'due_suppliers'       => ['bn' => 'বাকিদার সরবরাহকারী', 'en' => 'Suppliers with Due'],

        // Cash book
        'cash_in'             => ['bn' => 'নগদ আগমন', 'en' => 'Cash In'],
        'cash_out'            => ['bn' => 'নগদ নির্গমন', 'en' => 'Cash Out'],
        'net_cash'            => ['bn' => 'নিট নগদ', 'en' => 'Net Cash'],
        'head'                => ['bn' => 'খাত', 'en' => 'Head'],
        'in_tk'               => ['bn' => 'আগমন (৳)', 'en' => 'In (৳)'],
        'out_tk'              => ['bn' => 'নির্গমন (৳)', 'en' => 'Out (৳)'],

        // Empty states
        'no_sales_day'        => ['bn' => 'এই দিনে কোনো বিক্রয় নেই।', 'en' => 'No sales on this day.'],
        'no_sales_month'      => ['bn' => 'এই মাসে কোনো বিক্রয় নেই।', 'en' => 'No sales in this month.'],
        'no_purchase_period'  => ['bn' => 'এই সময়ে কোনো ক্রয় নেই।', 'en' => 'No purchases in this period.'],
        'no_expense_period'   => ['bn' => 'এই সময়ে কোনো খরচ নেই।', 'en' => 'No expenses in this period.'],
        'no_products'         => ['bn' => 'কোনো পণ্য নেই।', 'en' => 'No products.'],
        'stock_sufficient'    => ['bn' => 'সব পণ্যের স্টক পর্যাপ্ত আছে।', 'en' => 'All products have sufficient stock.'],
        'no_due'              => ['bn' => 'কোনো বাকি নেই।', 'en' => 'No dues.'],
        'no_transactions_period' => ['bn' => 'এই সময়ে কোনো লেনদেন নেই।', 'en' => 'No transactions in this period.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Profile module
    |--------------------------------------------------------------------------
    */
    'profile' => [
        'tab_info'             => ['bn' => 'তথ্য আপডেট', 'en' => 'Update Info'],
        'tab_password'         => ['bn' => 'পাসওয়ার্ড আপডেট', 'en' => 'Update Password'],
        'personal_info'        => ['bn' => 'ব্যক্তিগত তথ্য', 'en' => 'Personal Information'],
        'business_info'        => ['bn' => 'ব্যবসার তথ্য', 'en' => 'Business Information'],
        'business_name'        => ['bn' => 'ব্যবসার নাম', 'en' => 'Business Name'],
        'business_type'        => ['bn' => 'ব্যবসার ধরন', 'en' => 'Business Type'],
        'current_password'     => ['bn' => 'বর্তমান পাসওয়ার্ড', 'en' => 'Current Password'],
        'new_password'         => ['bn' => 'নতুন পাসওয়ার্ড', 'en' => 'New Password'],
        'confirm_new_password' => ['bn' => 'নতুন পাসওয়ার্ড (পুনরায়)', 'en' => 'New Password (again)'],
        'change_password_btn'  => ['bn' => 'পাসওয়ার্ড পরিবর্তন করুন', 'en' => 'Change Password'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Settings module
    |--------------------------------------------------------------------------
    */
    'settings' => [
        'general'              => ['bn' => 'সাধারণ সেটিংস', 'en' => 'General Settings'],
        'currency'             => ['bn' => 'মুদ্রা', 'en' => 'Currency'],
        'currency_symbol'      => ['bn' => 'মুদ্রার প্রতীক', 'en' => 'Currency Symbol'],
        'date_format'          => ['bn' => 'তারিখের ফরম্যাট', 'en' => 'Date Format'],
        'invoice_prefix'       => ['bn' => 'ইনভয়েস প্রিফিক্স', 'en' => 'Invoice Prefix'],
        'features'             => ['bn' => 'বৈশিষ্ট্য সক্রিয় করুন', 'en' => 'Enable Features'],
        'track_stock'          => ['bn' => 'স্টক হিসাব করুন', 'en' => 'Track Stock'],
        'low_stock_alert'      => ['bn' => 'কম স্টক সতর্কতা', 'en' => 'Low Stock Alert'],
        'allow_negative_stock' => ['bn' => 'ঋণাত্মক স্টক অনুমোদন করুন', 'en' => 'Allow Negative Stock'],
        'enable_barcode'       => ['bn' => 'বারকোড সক্রিয় করুন', 'en' => 'Enable Barcode'],
        'show_profit'          => ['bn' => 'মুনাফা দেখান', 'en' => 'Show Profit'],
        'enable_due'           => ['bn' => 'বাকি সক্রিয় করুন', 'en' => 'Enable Due'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Employee module
    |--------------------------------------------------------------------------
    */
    'employee' => [
        'add_new'          => ['bn' => 'নতুন কর্মচারী', 'en' => 'New Employee'],
        'role_staff'       => ['bn' => 'স্টাফ', 'en' => 'Staff'],
        'role_manager'     => ['bn' => 'ম্যানেজার', 'en' => 'Manager'],
        'confirm_password' => ['bn' => 'পাসওয়ার্ড (পুনরায়)', 'en' => 'Password (again)'],
        'add_btn'          => ['bn' => 'কর্মচারী যোগ করুন', 'en' => 'Add Employee'],
        'current'          => ['bn' => 'বর্তমান কর্মচারী', 'en' => 'Current Employees'],
        'empty'            => ['bn' => 'কোনো কর্মচারী নেই।', 'en' => 'No employees.'],
        'activate'         => ['bn' => 'সক্রিয় করুন', 'en' => 'Activate'],
        'deactivate'       => ['bn' => 'নিষ্ক্রিয় করুন', 'en' => 'Deactivate'],
        'activated'        => ['bn' => 'কর্মচারী সক্রিয় করা হয়েছে।', 'en' => 'Employee activated.'],
        'deactivated'      => ['bn' => 'কর্মচারী নিষ্ক্রিয় করা হয়েছে।', 'en' => 'Employee deactivated.'],
        'activate_confirm'   => ['bn' => 'আপনি কি এই কর্মচারীকে সক্রিয় করতে চান? তিনি আবার লগইন করতে পারবেন।', 'en' => 'Activate this employee? They will be able to log in again.'],
        'deactivate_confirm' => ['bn' => 'আপনি কি এই কর্মচারীকে নিষ্ক্রিয় করতে চান? তিনি আর লগইন করতে পারবেন না।', 'en' => 'Deactivate this employee? They will no longer be able to log in.'],
        'pending'          => ['bn' => 'অপেক্ষমাণ', 'en' => 'Pending'],
        'resend_invite'    => ['bn' => 'আবার আমন্ত্রণ পাঠান', 'en' => 'Resend Invite'],
        'invite_note'      => ['bn' => 'কর্মচারীর ইমেইলে একটি আমন্ত্রণ লিংক পাঠানো হবে। তিনি লিংকে ক্লিক করে নিজের পাসওয়ার্ড সেট করবেন।', 'en' => 'An invitation link will be sent to the employee\'s email. They will click it to set their own password.'],
        'invite_subject'      => ['bn' => 'হিসাবিজ — আপনাকে আমন্ত্রণ জানানো হয়েছে', 'en' => 'Hishabiz — You have been invited'],
        'invite_greeting'     => ['bn' => 'হ্যালো', 'en' => 'Hello'],
        'invite_intro'        => ['bn' => 'আপনাকে এই ব্যবসায় যোগ দিতে আমন্ত্রণ জানানো হয়েছে:', 'en' => 'You have been invited to join the business:'],
        'invite_action_line'  => ['bn' => 'অ্যাকাউন্ট সক্রিয় করতে এবং আপনার পাসওয়ার্ড সেট করতে নিচের বাটনে ক্লিক করুন।', 'en' => 'Click the button below to activate your account and set your password.'],
        'invite_button'       => ['bn' => 'পাসওয়ার্ড সেট করুন', 'en' => 'Set Your Password'],
        'invite_expiry'       => ['bn' => 'এই আমন্ত্রণ লিংকটি ৭ দিনের মধ্যে মেয়াদোত্তীর্ণ হবে।', 'en' => 'This invitation link will expire in 7 days.'],
        'invite_ignore'       => ['bn' => 'আপনি যদি এটি আশা না করেন, তাহলে এই ইমেইলটি উপেক্ষা করুন।', 'en' => 'If you were not expecting this, you can ignore this email.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notifications page
    |--------------------------------------------------------------------------
    */
    'notify' => [
        'mark_read' => ['bn' => 'পঠিত হিসেবে চিহ্নিত করুন', 'en' => 'Mark as read'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Auth pages (login / register page-specific copy)
    |--------------------------------------------------------------------------
    */
    'authpage' => [
        'login_heading'         => ['bn' => 'লগ-ইন করুন', 'en' => 'Log In'],
        'login_subtitle'        => ['bn' => 'আপনার মোবাইল বা ইমেইল এবং পাসওয়ার্ড দিয়ে লগইন করুন।', 'en' => 'Log in with your mobile / email and password.'],
        'login_register_prompt' => ['bn' => 'ভুল তথ্য! নতুন ব্যবহারকারী হলে অনুগ্রহ করে প্রথমে রেজিস্টার করুন।', 'en' => 'Invalid details! If you are a new user, please register first.'],
        'register_now'          => ['bn' => 'রেজিস্টার করুন', 'en' => 'Register'],
        'mobile_number'         => ['bn' => 'মোবাইল নম্বর', 'en' => 'Mobile Number'],
        'mobile_or_email'       => ['bn' => 'মোবাইল নম্বর বা ইমেইল', 'en' => 'Mobile Number or Email'],
        'login_btn'             => ['bn' => 'লগইন', 'en' => 'Log In'],
        'new_user'              => ['bn' => 'নতুন ব্যবহারকারী?', 'en' => 'New user?'],
        'create_account'        => ['bn' => 'একাউন্ট তৈরি করুন', 'en' => 'Create Account'],
        'register_heading'      => ['bn' => 'ব্যবসা শুরু করুন', 'en' => 'Start Your Business'],
        'register_subtitle'     => ['bn' => 'কয়েক সেকেন্ডে আপনার "হিসাবিজ" একাউন্ট খুলুন।', 'en' => 'Open your "Hishabiz" account in seconds.'],
        'register_title'        => ['bn' => 'ব্যবসা নিবন্ধন', 'en' => 'Register Business'],
        'business_name_label'   => ['bn' => 'ব্যবসার নাম', 'en' => 'Business Name'],
        'business_name_ph'      => ['bn' => 'যেমন: রহিম স্টোর', 'en' => 'e.g. Rahim Store'],
        'owner_name_label'      => ['bn' => 'মালিকের নাম', 'en' => "Owner's Name"],
        'owner_name_ph'         => ['bn' => 'আপনার নাম', 'en' => 'Your name'],
        'business_type_label'   => ['bn' => 'ব্যবসার ধরন', 'en' => 'Business Type'],
        'already_have_account'  => ['bn' => 'আগে থেকেই একাউন্ট আছে?', 'en' => 'Already have an account?'],
        'login_link'            => ['bn' => 'লগইন করুন', 'en' => 'Log In'],
        'verify_title'          => ['bn' => 'ইমেইল যাচাই', 'en' => 'Verify Email'],
        'verify_heading'        => ['bn' => 'আপনার ইমেইল যাচাই করুন', 'en' => 'Verify Your Email'],
        'verify_subtitle'       => ['bn' => 'আপনার ইমেইলে একটি ৪-সংখ্যার কোড পাঠানো হয়েছে। অ্যাকাউন্ট সক্রিয় করতে কোডটি লিখুন।', 'en' => 'We have sent a 4-digit code to your email. Enter it to activate your account.'],
        'verify_spam_note'      => ['bn' => 'ইমেইল না পেলে অনুগ্রহ করে স্প্যাম ফোল্ডার দেখুন।', 'en' => "Didn't get the email? Please check your spam folder."],
        'verify_resend_btn'     => ['bn' => 'আবার কোড পাঠান', 'en' => 'Resend Code'],
        'verify_resent'         => ['bn' => 'একটি নতুন যাচাইকরণ কোড আপনার ইমেইলে পাঠানো হয়েছে।', 'en' => 'A new verification code has been sent to your email.'],
        'verify_logout'         => ['bn' => 'লগ আউট', 'en' => 'Log Out'],
        'verify_code_label'     => ['bn' => '৪-সংখ্যার যাচাইকরণ কোড', 'en' => '4-Digit Verification Code'],
        'verify_code_hint'      => ['bn' => 'আপনার ইমেইলে পাঠানো ৪-সংখ্যার কোডটি লিখুন।', 'en' => 'Enter the 4-digit code sent to your email.'],
        'verify_code_btn'       => ['bn' => 'কোড যাচাই করুন', 'en' => 'Verify Code'],
        'verify_code_invalid'   => ['bn' => 'কোডটি ভুল অথবা মেয়াদ শেষ হয়ে গেছে।', 'en' => 'The code is invalid or has expired.'],
        'verify_code_attempts_left' => ['bn' => 'বার চেষ্টা বাকি', 'en' => 'attempts left'],
        'verify_code_max_attempts'  => ['bn' => 'অনেকবার ভুল হয়েছে। একটি নতুন কোড আপনার ইমেইলে পাঠানো হয়েছে।', 'en' => 'Too many wrong attempts. A new code has been sent to your email.'],
        'verify_code_subject'   => ['bn' => 'আপনার যাচাইকরণ কোড', 'en' => 'Your Verification Code'],
        'verify_code_greeting'  => ['bn' => 'হ্যালো', 'en' => 'Hello'],
        'verify_code_intro'     => ['bn' => 'আপনার ইমেইল যাচাই করতে নিচের ৪-সংখ্যার কোডটি ব্যবহার করুন:', 'en' => 'Use the following 4-digit code to verify your email:'],
        'verify_code_expiry'    => ['bn' => 'এই কোডটি ১৫ মিনিটের জন্য বৈধ।', 'en' => 'This code is valid for 15 minutes.'],
        'verify_code_ignore'    => ['bn' => 'আপনি যদি এই অনুরোধ না করে থাকেন, তবে এই ইমেইলটি উপেক্ষা করুন।', 'en' => 'If you did not request this, please ignore this email.'],
        'setup_title'           => ['bn' => 'পাসওয়ার্ড সেট করুন', 'en' => 'Set Password'],
        'setup_heading'         => ['bn' => 'আপনার পাসওয়ার্ড সেট করুন', 'en' => 'Set Your Password'],
        'setup_subtitle'        => ['bn' => 'অ্যাকাউন্ট সক্রিয় করতে একটি পাসওয়ার্ড তৈরি করুন।', 'en' => 'Create a password to activate your account.'],
        'setup_password'        => ['bn' => 'নতুন পাসওয়ার্ড', 'en' => 'New Password'],
        'setup_btn'             => ['bn' => 'পাসওয়ার্ড সেট করে শুরু করুন', 'en' => 'Set Password & Continue'],
        'back_to_login'         => ['bn' => 'লগইনে ফিরুন', 'en' => 'Back to Login'],
        'forgot_title'          => ['bn' => 'পাসওয়ার্ড পুনরুদ্ধার', 'en' => 'Forgot Password'],
        'forgot_heading'        => ['bn' => 'পাসওয়ার্ড ভুলে গেছেন?', 'en' => 'Forgot your password?'],
        'forgot_subtitle'       => ['bn' => 'আপনার ইমেইল দিন, আমরা পাসওয়ার্ড রিসেট লিংক পাঠাব।', 'en' => 'Enter your email and we will send you a password reset link.'],
        'forgot_btn'            => ['bn' => 'রিসেট লিংক পাঠান', 'en' => 'Send Reset Link'],
        'reset_link_sent'       => ['bn' => 'যদি এই ইমেইলে কোনো অ্যাকাউন্ট থাকে, একটি পাসওয়ার্ড রিসেট লিংক পাঠানো হয়েছে।', 'en' => 'If an account exists for that email, a password reset link has been sent.'],
        'reset_title'           => ['bn' => 'পাসওয়ার্ড রিসেট', 'en' => 'Reset Password'],
        'reset_heading'         => ['bn' => 'নতুন পাসওয়ার্ড সেট করুন', 'en' => 'Set a New Password'],
        'reset_subtitle'        => ['bn' => 'আপনার অ্যাকাউন্টের জন্য একটি নতুন পাসওয়ার্ড দিন।', 'en' => 'Choose a new password for your account.'],
        'reset_password'        => ['bn' => 'নতুন পাসওয়ার্ড', 'en' => 'New Password'],
        'reset_btn'             => ['bn' => 'পাসওয়ার্ড রিসেট করুন', 'en' => 'Reset Password'],
        'reset_success'         => ['bn' => 'আপনার পাসওয়ার্ড রিসেট হয়েছে। এখন লগইন করুন।', 'en' => 'Your password has been reset. You can now log in.'],
        'reset_failed'          => ['bn' => 'পাসওয়ার্ড রিসেট ব্যর্থ হয়েছে। লিংকটি অবৈধ বা মেয়াদোত্তীর্ণ হতে পারে।', 'en' => 'Password reset failed. The link may be invalid or expired.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Landing / marketing page (public)
    |--------------------------------------------------------------------------
    */
    'landing' => [
        // Page + nav
        'page_title'        => ['bn' => 'হিসাবিজ – ছোট ব্যবসার ডিজিটাল খাতা', 'en' => 'Hishabiz – Digital Ledger for Small Businesses'],
        'logo_word1'        => ['bn' => 'Hishabiz', 'en' => 'হিসাবিজ'],
        'logo_word2'        => ['bn' => 'হিসাবিজ', 'en' => 'Hishabiz'],
        'nav_features'      => ['bn' => 'ফিচার', 'en' => 'Features'],
        'nav_how'           => ['bn' => 'কিভাবে কাজ করে', 'en' => 'How It Works'],
        'nav_plans'         => ['bn' => 'প্ল্যান', 'en' => 'Plans'],
        'nav_faq'           => ['bn' => 'প্রশ্ন-উত্তর', 'en' => 'FAQ'],
        'nav_login'         => ['bn' => 'লগইন', 'en' => 'Log In'],
        'nav_cta'           => ['bn' => 'বিনামূল্যে শুরু করুন', 'en' => 'Start Free'],
        'nav_cta_short'     => ['bn' => 'বিনামূল্যে শুরু', 'en' => 'Start Free'],
        'login_cta'         => ['bn' => 'লগইন করুন', 'en' => 'Log In'],

        // Hero
        'hero_badge'        => ['bn' => '৫০০+ উদ্দোক্তা বিশ্বাস করেন', 'en' => 'Trusted by 500+ entrepreneurs'],
        'hero_title_1'      => ['bn' => 'প্রতিটি ব্যবসার জন্য', 'en' => 'For every business,'],
        'hero_title_2'      => ['bn' => 'একটি সহজ ব্যবস্থাপনা', 'en' => 'a simple management system'],
        'hero_subtitle'     => ['bn' => 'মোবাইল থেকেই বিক্রয়, কেনাকাটা, স্টক, খরচ ও লাভ ট্র্যাক করুন। কোনো অ্যাকাউন্টিং জ্ঞান দরকার নেই।', 'en' => 'Track sales, purchases, stock, expenses and profit right from your mobile. No accounting knowledge needed.'],
        'trust_mobile'      => ['bn' => 'মোবাইল ফ্রেন্ডলি', 'en' => 'Mobile Friendly'],
        'trust_cloud'       => ['bn' => 'ক্লাউড ভিত্তিক', 'en' => 'Cloud Based'],
        'trust_secure'      => ['bn' => 'নিরাপদ ডেটা', 'en' => 'Secure Data'],
        'trust_multidevice' => ['bn' => 'মাল্টি ডিভাইস', 'en' => 'Multi Device'],

        // Dashboard preview mock
        'dash_today_summary' => ['bn' => 'আজকের সারসংক্ষেপ', 'en' => "Today's Summary"],
        'dash_total_profit'  => ['bn' => 'মোট লাভ', 'en' => 'Total Profit'],
        'dash_product_count' => ['bn' => 'পণ্য সংখ্যা', 'en' => 'Product Count'],
        'dash_due'           => ['bn' => 'বকেয়া', 'en' => 'Due'],
        'dash_weekly_sales'  => ['bn' => 'সাপ্তাহিক বিক্রয়', 'en' => 'Weekly Sales'],
        'add_sale'           => ['bn' => 'বিক্রয় যোগ করুন', 'en' => 'Add Sale'],
        'label_product'      => ['bn' => 'পণ্য', 'en' => 'Product'],
        'label_amount'       => ['bn' => 'পরিমাণ', 'en' => 'Quantity'],
        'save_btn'           => ['bn' => 'সেভ করুন', 'en' => 'Save'],
        'today_sale_short'   => ['bn' => 'আজ বিক্রয়', 'en' => 'Sales Today'],
        'profit'             => ['bn' => 'লাভ', 'en' => 'Profit'],
        'stock_list'         => ['bn' => 'স্টক তালিকা', 'en' => 'Stock List'],
        'due_list'           => ['bn' => 'বকেয়া তালিকা', 'en' => 'Due List'],

        // Demo / mock data
        'demo_summary'       => ['bn' => 'আজকের সারসংক্ষেপ', 'en' => "Today's Summary"],
        'demo_total_profit'  => ['bn' => 'মোট লাভ', 'en' => 'Total Profit'],
        'demo_product_count' => ['bn' => 'পণ্য সংখ্যা', 'en' => 'Products'],
        'demo_due'           => ['bn' => 'বকেয়া', 'en' => 'Due'],
        'demo_weekly_sales'  => ['bn' => 'সাপ্তাহিক বিক্রয়', 'en' => 'Weekly Sales'],
        'demo_sale_1'   => ['bn' => 'সাবান - ৩ পিস', 'en' => 'Soap - 3 pcs'],
        'demo_sale_2'   => ['bn' => 'শ্যাম্পু বোতল', 'en' => 'Shampoo bottle'],
        'demo_sale_3'   => ['bn' => 'চাল - ৫ কেজি', 'en' => 'Rice - 5 kg'],
        'demo_rice_5kg' => ['bn' => 'চাল ৫কেজি', 'en' => 'Rice 5kg'],
        'qty_2'         => ['bn' => '২টি', 'en' => '2'],
        'demo_rice_kg'  => ['bn' => 'চাল (কেজি)', 'en' => 'Rice (kg)'],
        'val_48kg'      => ['bn' => '৪৮ কেজি', 'en' => '48 kg'],
        'demo_dal_kg'   => ['bn' => 'ডাল (কেজি)', 'en' => 'Lentil (kg)'],
        'val_22kg'      => ['bn' => '২২ কেজি', 'en' => '22 kg'],
        'demo_mustard_oil' => ['bn' => 'সরিষার তেল', 'en' => 'Mustard Oil'],
        'val_3liter'    => ['bn' => '৩ লিটার', 'en' => '3 L'],
        'demo_soap_5pc' => ['bn' => 'সাবান ৫পিস', 'en' => 'Soap 5pc'],
        'demo_shampoo'  => ['bn' => 'শ্যাম্পু', 'en' => 'Shampoo'],
        'demo_rice_10kg' => ['bn' => 'চাল ১০কেজি', 'en' => 'Rice 10kg'],
        'demo_name_1'   => ['bn' => 'রহিম সাহেব', 'en' => 'Rahim Saheb'],
        'demo_name_2'   => ['bn' => 'করিম ভাই', 'en' => 'Karim Bhai'],
        'demo_name_3'   => ['bn' => 'নাসরিন আপা', 'en' => 'Nasrin Apa'],

        // Why / problems
        'why_tag'       => ['bn' => 'সমস্যা থেকে সমাধান', 'en' => 'From Problem to Solution'],
        'why_title_1'   => ['bn' => 'উদ্যোক্তাদের প্রতিদিনের সমস্যাগুলো', 'en' => "Entrepreneurs' everyday problems"],
        'why_title_2'   => ['bn' => 'আমরা বুঝি', 'en' => 'we understand'],
        'why_subtitle'  => ['bn' => 'পুরনো পদ্ধতি আর নয়। "হিসাবিজ" আপনার ব্যবসাকে সহজ ও স্মার্ট করে তুলবে।', 'en' => 'No more old methods. "Hishabiz" makes your business simple and smart.'],
        'problem_1_before' => ['bn' => 'কাগজের খাতা হারিয়ে যায়', 'en' => 'Paper ledgers get lost'],
        'problem_1_after'  => ['bn' => 'ক্লাউডে সংরক্ষিত, কখনো হারাবে না', 'en' => 'Saved in the cloud, never lost'],
        'problem_2_before' => ['bn' => 'স্টক হিসাব করা কঠিন', 'en' => 'Stock counting is hard'],
        'problem_2_after'  => ['bn' => 'স্বয়ংক্রিয়ভাবে স্টক আপডেট হয়', 'en' => 'Stock updates automatically'],
        'problem_3_before' => ['bn' => 'লাভ কত হলো বোঝা যায় না', 'en' => "Can't tell how much profit was made"],
        'problem_3_after'  => ['bn' => 'রিয়েল-টাইম লাভের রিপোর্ট দেখুন', 'en' => 'See real-time profit reports'],
        'problem_4_before' => ['bn' => 'বাকির হিসাব গুলিয়ে যায়', 'en' => 'Due accounts get muddled'],
        'problem_4_after'  => ['bn' => 'কাস্টমার বাকির সম্পূর্ণ ইতিহাস', 'en' => 'Complete customer due history'],
        'problem_5_before' => ['bn' => 'ব্যবসার তথ্য ছড়িয়ে থাকে', 'en' => 'Business data is scattered'],
        'problem_5_after'  => ['bn' => 'একটি অ্যাপে সব তথ্য একসাথে', 'en' => 'All data together in one app'],
        'problem_6_before' => ['bn' => 'মাসের হিসাব বের করা ঝামেলা', 'en' => 'Monthly accounting is a hassle'],
        'problem_6_after'  => ['bn' => 'এক ক্লিকেই মাসিক রিপোর্ট', 'en' => 'Monthly reports in one click'],

        // Features
        'features_tag'     => ['bn' => 'মূল ফিচারসমূহ', 'en' => 'Key Features'],
        'features_title_1' => ['bn' => 'আপনার ব্যবসার জন্য দরকারি', 'en' => 'Everything your business needs'],
        'features_title_2' => ['bn' => 'সব কিছু এক জায়গায়', 'en' => 'all in one place'],
        'feat_sales_title' => ['bn' => 'বিক্রয় ব্যবস্থাপনা', 'en' => 'Sales Management'],
        'feat_sales_1'     => ['bn' => 'দ্রুত বিক্রয় এন্ট্রি', 'en' => 'Quick sales entry'],
        'feat_sales_2'     => ['bn' => 'ইনভয়েস তৈরি করুন', 'en' => 'Create invoices'],
        'feat_sales_3'     => ['bn' => 'বিক্রয়ের ইতিহাস দেখুন', 'en' => 'View sales history'],
        'feat_sales_4'     => ['bn' => 'প্রতিদিনের বিক্রয় সারসংক্ষেপ', 'en' => 'Daily sales summary'],
        'feat_purchase_title' => ['bn' => 'ক্রয় ব্যবস্থাপনা', 'en' => 'Purchase Management'],
        'feat_purchase_1'  => ['bn' => 'কেনাকাটার রেকর্ড রাখুন', 'en' => 'Keep purchase records'],
        'feat_purchase_2'  => ['bn' => 'সরবরাহকারী ট্র্যাকিং', 'en' => 'Supplier tracking'],
        'feat_purchase_3'  => ['bn' => 'ক্রয় বিল সংরক্ষণ', 'en' => 'Store purchase bills'],
        'feat_purchase_4'  => ['bn' => 'সাপ্লায়ার বকেয়া ব্যবস্থাপনা', 'en' => 'Supplier due management'],
        'feat_stock_title' => ['bn' => 'স্টক ব্যবস্থাপনা', 'en' => 'Stock Management'],
        'feat_stock_1'     => ['bn' => 'বর্তমান স্টক দেখুন', 'en' => 'View current stock'],
        'feat_stock_2'     => ['bn' => 'কম স্টক এলার্ট পান', 'en' => 'Get low stock alerts'],
        'feat_stock_3'     => ['bn' => 'স্টক মুভমেন্ট ট্র্যাক করুন', 'en' => 'Track stock movement'],
        'feat_stock_4'     => ['bn' => 'স্টক রিপোর্ট পান', 'en' => 'Get stock reports'],
        'feat_customer_title' => ['bn' => 'কাস্টমার ব্যবস্থাপনা', 'en' => 'Customer Management'],
        'feat_customer_1'  => ['bn' => 'কাস্টমারের তথ্য সংরক্ষণ', 'en' => 'Store customer information'],
        'feat_customer_2'  => ['bn' => 'বাকির হিসাব ট্র্যাক করুন', 'en' => 'Track due accounts'],
        'feat_customer_3'  => ['bn' => 'পেমেন্টের ইতিহাস দেখুন', 'en' => 'View payment history'],
        'feat_customer_4'  => ['bn' => 'কাস্টমারকে মনে করিয়ে দিন', 'en' => 'Send customer reminders'],
        'feat_expense_title' => ['bn' => 'খরচ ব্যবস্থাপনা', 'en' => 'Expense Management'],
        'feat_expense_1'   => ['bn' => 'ভাড়ার খরচ রেকর্ড', 'en' => 'Record rent expenses'],
        'feat_expense_2'   => ['bn' => 'কর্মচারীর বেতন', 'en' => 'Employee salaries'],
        'feat_expense_3'   => ['bn' => 'বিদ্যুৎ ও ইউটিলিটি খরচ', 'en' => 'Electricity & utility costs'],
        'feat_expense_4'   => ['bn' => 'অন্যান্য খরচ ট্র্যাক', 'en' => 'Track other expenses'],
        'feat_report_title' => ['bn' => 'রিপোর্ট ও বিশ্লেষণ', 'en' => 'Reports & Analytics'],
        'feat_report_1'    => ['bn' => 'দৈনিক বিক্রয় রিপোর্ট', 'en' => 'Daily sales report'],
        'feat_report_2'    => ['bn' => 'মাসিক বিক্রয় সারসংক্ষেপ', 'en' => 'Monthly sales summary'],
        'feat_report_3'    => ['bn' => 'লাভ-লোকসান রিপোর্ট', 'en' => 'Profit & loss report'],
        'feat_report_4'    => ['bn' => 'স্টক রিপোর্ট', 'en' => 'Stock report'],
        'feat_cashbook_title' => ['bn' => 'ক্যাশবুক', 'en' => 'Cashbook'],
        'feat_cashbook_1'  => ['bn' => 'নগদ আয় রেকর্ড', 'en' => 'Record cash income'],
        'feat_cashbook_2'  => ['bn' => 'নগদ খরচ রেকর্ড', 'en' => 'Record cash expenses'],
        'feat_cashbook_3'  => ['bn' => 'বর্তমান ব্যালেন্স দেখুন', 'en' => 'View current balance'],
        'feat_cashbook_4'  => ['bn' => 'দৈনিক ক্যাশ সারসংক্ষেপ', 'en' => 'Daily cash summary'],
        'feat_invoice_title' => ['bn' => 'ইনভয়েস ও রশিদ', 'en' => 'Invoices & Receipts'],
        'feat_invoice_1'   => ['bn' => 'প্রফেশনাল ইনভয়েস তৈরি', 'en' => 'Create professional invoices'],
        'feat_invoice_2'   => ['bn' => 'ডিজিটাল রশিদ শেয়ার করুন', 'en' => 'Share digital receipts'],
        'feat_invoice_3'   => ['bn' => 'WhatsApp-এ পাঠান', 'en' => 'Send via WhatsApp'],
        'feat_invoice_4'   => ['bn' => 'প্রিন্ট করুন সহজেই', 'en' => 'Print easily'],

        // Benefits
        'benefits_tag'     => ['bn' => 'কেন উদ্যোক্তারা ভালোবাসেন', 'en' => 'Why Entrepreneurs Love It'],
        'benefits_title_1' => ['bn' => '"হিসাবিজ" ব্যবহার করলে', 'en' => 'When you use "Hishabiz"'],
        'benefits_title_2' => ['bn' => 'যা পাবেন', 'en' => "here's what you get"],
        'benefit_1_title'  => ['bn' => 'যেকোনো ডিভাইসে চলে', 'en' => 'Works on any device'],
        'benefit_1_desc'   => ['bn' => 'মোবাইল, ট্যাবলেট বা কম্পিউটার — সব জায়গায় ব্যবহার করুন', 'en' => 'Mobile, tablet or computer — use it everywhere'],
        'benefit_2_title'  => ['bn' => 'হিসাবের জ্ঞান লাগে না', 'en' => 'No accounting knowledge needed'],
        'benefit_2_desc'   => ['bn' => 'যে কেউ সহজেই শিখতে ও ব্যবহার করতে পারবেন', 'en' => 'Anyone can learn and use it easily'],
        'benefit_3_title'  => ['bn' => 'সময় বাঁচায়', 'en' => 'Saves time'],
        'benefit_3_desc'   => ['bn' => 'ম্যানুয়াল হিসাবের ঝামেলা থেকে মুক্তি, বেশি সময় ব্যবসায়', 'en' => 'Free from manual bookkeeping, more time for business'],
        'benefit_4_title'  => ['bn' => 'স্টক ভুল হয় না', 'en' => 'No stock errors'],
        'benefit_4_desc'   => ['bn' => 'প্রতিটি বিক্রয়ে স্বয়ংক্রিয়ভাবে স্টক আপডেট হয়', 'en' => 'Stock updates automatically on every sale'],
        'benefit_5_title'  => ['bn' => 'সত্যিকারের লাভ দেখায়', 'en' => 'Shows real profit'],
        'benefit_5_desc'   => ['bn' => 'খরচ বাদ দিয়ে আসল লাভ কত তা স্পষ্টভাবে দেখুন', 'en' => 'See your true profit after expenses, clearly'],
        'benefit_6_title'  => ['bn' => 'ব্যবসা বাড়াতে সাহায্য করে', 'en' => 'Helps grow your business'],
        'benefit_6_desc'   => ['bn' => 'ডেটা দেখে সঠিক সিদ্ধান্ত নিন, ব্যবসাকে এগিয়ে নিন', 'en' => 'Make the right decisions from data and move ahead'],
        'benefit_7_title'  => ['bn' => '২৪/৭ সহজলভ্য', 'en' => 'Available 24/7'],
        'benefit_7_desc'   => ['bn' => 'যেকোনো সময়, যেকোনো জায়গা থেকে হিসাব দেখুন', 'en' => 'Check your accounts anytime, anywhere'],
        'benefit_8_title'  => ['bn' => 'বাংলায় সম্পূর্ণ', 'en' => 'Fully in Bangla'],
        'benefit_8_desc'   => ['bn' => 'সম্পূর্ণ বাংলা ভাষায়, বাংলাদেশের উদ্যোক্তাদের জন্য', 'en' => 'Entirely in Bangla, made for Bangladeshi entrepreneurs'],

        // How it works
        'how_title'    => ['bn' => 'মাত্র ৫টি ধাপে শুরু করুন', 'en' => 'Get started in just 5 steps'],
        'how_subtitle' => ['bn' => 'জটিল কিছু নেই। সহজ ধাপগুলো অনুসরণ করুন এবং আজই ব্যবসা ম্যানেজ শুরু করুন।', 'en' => 'Nothing complicated. Follow the simple steps and start managing your business today.'],
        'step_1' => ['bn' => '১', 'en' => '1'],
        'step_2' => ['bn' => '২', 'en' => '2'],
        'step_3' => ['bn' => '৩', 'en' => '3'],
        'step_4' => ['bn' => '৪', 'en' => '4'],
        'step_5' => ['bn' => '৫', 'en' => '5'],
        'step_1_title' => ['bn' => 'ব্যবসা নিবন্ধন করুন', 'en' => 'Register your business'],
        'step_1_desc'  => ['bn' => 'ব্যবসার নাম ও তথ্য দিয়ে বিনামূল্যে অ্যাকাউন্ট খুলুন', 'en' => 'Open a free account with your business name and details'],
        'step_2_title' => ['bn' => 'পণ্য যোগ করুন', 'en' => 'Add products'],
        'step_2_desc'  => ['bn' => 'আপনার পণ্যের তালিকা ও দাম সেট করুন', 'en' => 'Set up your product list and prices'],
        'step_3_title' => ['bn' => 'কেনাকাটা রেকর্ড করুন', 'en' => 'Record purchases'],
        'step_3_desc'  => ['bn' => 'পাইকারি থেকে পণ্য কিনলে তা রেকর্ড করুন', 'en' => 'Record products bought from wholesale'],
        'step_4_title' => ['bn' => 'বিক্রয় রেকর্ড করুন', 'en' => 'Record sales'],
        'step_4_desc'  => ['bn' => 'প্রতিটি বিক্রয় দ্রুত এন্ট্রি করুন, ইনভয়েস তৈরি করুন', 'en' => 'Enter each sale quickly and create invoices'],
        'step_5_title' => ['bn' => 'লাভ ট্র্যাক করুন', 'en' => 'Track profit'],
        'step_5_desc'  => ['bn' => 'রিয়েল-টাইম রিপোর্টে দেখুন কতটুকু লাভ হচ্ছে', 'en' => 'See how much profit you are making in real-time reports'],

        // Plans
        'plans_tag'        => ['bn' => 'সাবস্ক্রিপশন প্ল্যান', 'en' => 'Subscription Plans'],
        'plans_title_1'    => ['bn' => 'আপনার ব্যবসার আকার অনুযায়ী', 'en' => 'Based on your business size'],
        'plans_title_2'    => ['bn' => 'প্ল্যান বেছে নিন', 'en' => 'choose a plan'],
        'plans_subtitle'   => ['bn' => 'বিনামূল্যে শুরু করুন, যখন প্রয়োজন আপগ্রেড করুন', 'en' => 'Start free, upgrade when you need to'],
        'per_month'        => ['bn' => '/ মাস', 'en' => '/ month'],
        'plan_free_name'   => ['bn' => 'ফ্রি', 'en' => 'Free'],
        'plan_free_desc'   => ['bn' => 'নতুন উদ্যোক্তাদের জন্য শুরু করার সুযোগ', 'en' => 'A starting point for new entrepreneurs'],
        'plan_free_f1'     => ['bn' => '৫০টি পণ্য', 'en' => '50 products'],
        'plan_free_f2'     => ['bn' => 'মাসে ১০০টি বিক্রয়', 'en' => '100 sales per month'],
        'plan_free_f3'     => ['bn' => 'বেসিক রিপোর্ট', 'en' => 'Basic reports'],
        'plan_free_f4'     => ['bn' => 'ইনভয়েস', 'en' => 'Invoice'],
        'invoice_create'   => ['bn' => 'ইনভয়েস তৈরি', 'en' => 'Create Invoice'],
        'customer_mgmt'    => ['bn' => 'কাস্টমার ম্যানেজমেন্ট', 'en' => 'Customer Management'],
        'cloud_backup'     => ['bn' => 'ক্লাউড ব্যাকআপ', 'en' => 'Cloud Backup'],
        'backup'           => ['bn' => 'ব্যাকআপ', 'en' => 'Backup'],
        'multi_user'       => ['bn' => 'একাধিক ব্যবহারকারী', 'en' => 'Multiple Users'],
        'multi_branch'     => ['bn' => 'একাধিক শাখা', 'en' => 'Multiple Branches'],
        'plan_starter_name' => ['bn' => 'স্টার্টার', 'en' => 'Starter'],
        'plan_starter_desc' => ['bn' => 'ছোট ব্যবসার জন্য আদর্শ', 'en' => 'Ideal for small businesses'],
        'plan_starter_f1'  => ['bn' => '৫০০টি পণ্য', 'en' => '500 products'],
        'unlimited_sales'  => ['bn' => 'সীমাহীন বিক্রয়', 'en' => 'Unlimited sales'],
        'start_btn'        => ['bn' => 'শুরু করুন', 'en' => 'Get Started'],
        'plan_popular_badge' => ['bn' => 'প্রস্তাবিত', 'en' => 'Recommended'],
        'plan_dreamer_name' => ['bn' => 'ড্রিমার', 'en' => 'Dreamer'],
        'plan_dreamer_desc' => ['bn' => 'বেড়ে ওঠা ব্যবসার জন্য উপযোগী প্ল্যান', 'en' => 'A suitable plan for growing businesses'],
        'unlimited_products' => ['bn' => 'সীমাহীন পণ্য', 'en' => 'Unlimited products'],
        'plan_dreamer_f3'  => ['bn' => 'সব ফিচার অন্তর্ভুক্ত', 'en' => 'All features included'],
        'plan_dreamer_f4'  => ['bn' => '৩ জন ব্যবহারকারী', 'en' => '3 users'],
        'plan_dreamer_f5'  => ['bn' => 'প্রিমিয়াম রিপোর্ট', 'en' => 'Premium reports'],
        'plan_dreamer_f6'  => ['bn' => 'WhatsApp ইনভয়েস', 'en' => 'WhatsApp invoice'],
        'plan_dreamer_btn' => ['bn' => 'এখনই শুরু করুন', 'en' => 'Start Now'],
        'plan_enterprise_name' => ['bn' => 'এন্টারপ্রাইজ', 'en' => 'Enterprise'],
        'plan_enterprise_desc' => ['bn' => 'একাধিক শাখা বা বড় ব্যবসার জন্য', 'en' => 'For multiple branches or large businesses'],
        'plan_enterprise_f1' => ['bn' => 'সব ড্রিমার ফিচার', 'en' => 'All Dreamer features'],
        'plan_enterprise_f2' => ['bn' => 'সীমাহীন ব্যবহারকারী', 'en' => 'Unlimited users'],
        'plan_enterprise_f4' => ['bn' => 'ডেডিকেটেড সাপোর্ট', 'en' => 'Dedicated support'],
        'plan_enterprise_f5' => ['bn' => 'কাস্টম রিপোর্ট', 'en' => 'Custom reports'],
        'plan_enterprise_f6' => ['bn' => 'API অ্যাক্সেস', 'en' => 'API access'],
        'contact_btn'      => ['bn' => 'যোগাযোগ করুন', 'en' => 'Contact Us'],

        // Compare table
        'compare_row_product_limit' => ['bn' => 'পণ্যের সীমা', 'en' => 'Product limit'],
        'compare_row_sales_entry'   => ['bn' => 'বিক্রয় এন্ট্রি', 'en' => 'Sales entry'],
        'compare_row_priority_support' => ['bn' => 'অগ্রাধিকার সাপোর্ট', 'en' => 'Priority support'],
        'unlimited'        => ['bn' => 'সীমাহীন', 'en' => 'Unlimited'],
        'qty_50'           => ['bn' => '৫০টি', 'en' => '50'],
        'qty_500'          => ['bn' => '৫০০টি', 'en' => '500'],
        'sales_100_month'  => ['bn' => '১০০/মাস', 'en' => '100/month'],
        'users_3'          => ['bn' => '৩ জন', 'en' => '3 users'],

        // Mobile section
        'mobile_tag'       => ['bn' => 'যেকোনো ডিভাইসে', 'en' => 'On Any Device'],
        'mobile_title_1'   => ['bn' => 'মোবাইল ফ্রেন্ডলি', 'en' => 'Mobile-friendly'],
        'mobile_title_2'   => ['bn' => 'অ্যাপ', 'en' => 'app'],
        'mobile_subtitle'  => ['bn' => 'ইন্সটল করার ঝামেলা নেই। ব্রাউজার খুলুন, ব্যবহার করুন।', 'en' => 'No installation hassle. Open your browser and use it.'],
        'mobile_note'      => ['bn' => 'কোনো অ্যাপ ডাউনলোড করতে হবে না। ব্রাউজার দিয়েই সব কাজ করুন।', 'en' => 'No app download needed. Do everything from your browser.'],

        // Security
        'security_tag'      => ['bn' => 'নিরাপত্তা ও বিশ্বাস', 'en' => 'Security & Trust'],
        'security_title_1'  => ['bn' => 'আপনার ব্যবসার তথ্য', 'en' => 'Your business data'],
        'security_title_2'  => ['bn' => 'সম্পূর্ণ নিরাপদ', 'en' => 'fully secure'],
        'security_subtitle' => ['bn' => 'আমরা আপনার ব্যবসার তথ্যকে আমাদের নিজের মতো সুরক্ষিত রাখি', 'en' => 'We protect your business data as if it were our own'],
        'sec_1_desc'   => ['bn' => 'ডেটা স্বয়ংক্রিয়ভাবে ক্লাউডে সংরক্ষিত। ফোন হারালেও ডেটা থাকবে।', 'en' => 'Data is saved to the cloud automatically. Even if you lose your phone, the data stays.'],
        'sec_2_title'  => ['bn' => 'নিরাপদ লগইন', 'en' => 'Secure Login'],
        'sec_2_desc'   => ['bn' => 'পাসওয়ার্ড সুরক্ষিত অ্যাকাউন্ট। শুধু আপনিই আপনার ডেটা দেখতে পারবেন।', 'en' => 'Password-protected accounts. Only you can see your data.'],
        'sec_3_title'  => ['bn' => 'ডেটা সুরক্ষা', 'en' => 'Data Protection'],
        'sec_3_desc'   => ['bn' => 'SSL এনক্রিপশন প্রযুক্তিতে ডেটা ট্রান্সফার সম্পূর্ণ নিরাপদ।', 'en' => 'Data transfer is fully secure with SSL encryption technology.'],
        'sec_4_title'  => ['bn' => 'ব্যবসার ডেটা আলাদা', 'en' => 'Isolated Business Data'],
        'sec_4_desc'   => ['bn' => 'প্রতিটি ব্যবসার তথ্য আলাদাভাবে সংরক্ষিত। কেউ অন্যের তথ্য দেখতে পাবে না।', 'en' => "Each business's data is stored separately. No one can see another's data."],
        'sec_5_title'  => ['bn' => 'মাল্টি-টেন্যান্ট সিকিউরিটি', 'en' => 'Multi-tenant Security'],
        'sec_5_desc'   => ['bn' => 'আধুনিক প্রযুক্তিতে তৈরি, প্রতিটি অ্যাকাউন্ট সম্পূর্ণ আলাদা ও নিরাপদ।', 'en' => 'Built with modern technology, every account is fully separate and secure.'],
        'sec_6_title'  => ['bn' => 'অটো ব্যাকআপ', 'en' => 'Auto Backup'],
        'sec_6_desc'   => ['bn' => 'প্রতিদিন স্বয়ংক্রিয়ভাবে ডেটার ব্যাকআপ নেওয়া হয়। কোনো ডেটা হারাবে না।', 'en' => 'Data is backed up automatically every day. No data is ever lost.'],

        // FAQ
        'faq_tag'   => ['bn' => 'প্রশ্ন ও উত্তর', 'en' => 'Questions & Answers'],
        'faq_title' => ['bn' => 'সাধারণ প্রশ্নসমূহ', 'en' => 'Frequently Asked Questions'],
        'faq_q1'    => ['bn' => 'কি টেকনিক্যাল জ্ঞান লাগবে?', 'en' => 'Do I need technical knowledge?'],
        'faq_a1'    => ['bn' => 'না, একদমই না। "হিসাবিজ" সাধারণ উদ্যোক্তাদের কথা মাথায় রেখে তৈরি। মোবাইল চালাতে পারলেই ব্যবহার করতে পারবেন। আমাদের সহজ ইন্টারফেস যে কেউ শিখে নিতে পারবে।', 'en' => 'No, not at all. "Hishabiz" is built with ordinary entrepreneurs in mind. If you can use a mobile phone, you can use it. Anyone can learn our simple interface.'],
        'faq_q2'    => ['bn' => 'মোবাইল থেকে ব্যবহার করা যাবে?', 'en' => 'Can I use it from a mobile?'],
        'faq_a2'    => ['bn' => 'হ্যাঁ, সম্পূর্ণভাবে। Android, iPhone, Tablet সব ডিভাইসে কাজ করে। আলাদা কোনো অ্যাপ ডাউনলোড করতে হবে না — ব্রাউজার থেকেই ব্যবহার করুন।', 'en' => 'Yes, completely. It works on Android, iPhone and Tablet — all devices. No separate app to download — just use it from your browser.'],
        'faq_q3'    => ['bn' => 'স্টক ট্র্যাক করা যাবে কি?', 'en' => 'Can I track stock?'],
        'faq_a3'    => ['bn' => 'অবশ্যই। প্রতিটি বিক্রয় ও কেনাকাটায় স্বয়ংক্রিয়ভাবে স্টক আপডেট হয়। কোনো পণ্যের স্টক কমে গেলে আপনাকে এলার্ট দেওয়া হবে।', 'en' => 'Absolutely. Stock updates automatically on every sale and purchase. You will be alerted when a product runs low.'],
        'faq_q4'    => ['bn' => 'কাস্টমারের বাকির হিসাব রাখা যাবে?', 'en' => 'Can I keep track of customer dues?'],
        'faq_a4'    => ['bn' => 'হ্যাঁ। প্রতিটি কাস্টমারের বাকির সম্পূর্ণ ইতিহাস, পেমেন্টের তারিখ ও বকেয়া পরিমাণ — সব কিছু ট্র্যাক করা যাবে।', 'en' => "Yes. Each customer's full due history, payment dates and outstanding amount — everything can be tracked."],
        'faq_q5'    => ['bn' => 'পরে কি আপগ্রেড করা যাবে?', 'en' => 'Can I upgrade later?'],
        'faq_a5'    => ['bn' => 'হ্যাঁ, যেকোনো সময় যেকোনো প্ল্যানে আপগ্রেড বা ডাউনগ্রেড করতে পারবেন। বিনামূল্যে শুরু করুন, প্রয়োজন হলে আপগ্রেড করুন।', 'en' => 'Yes, you can upgrade or downgrade to any plan at any time. Start free and upgrade when needed.'],
        'faq_q6'    => ['bn' => 'আমার ডেটা কি নিরাপদ?', 'en' => 'Is my data safe?'],
        'faq_a6'    => ['bn' => 'সম্পূর্ণ নিরাপদ। আপনার ব্যবসার তথ্য এনক্রিপ্টেড এবং ক্লাউডে সংরক্ষিত। শুধু আপনিই আপনার ডেটা দেখতে পারবেন। আমরা কখনো তৃতীয় পক্ষের সাথে ডেটা শেয়ার করি না।', 'en' => 'Completely safe. Your business data is encrypted and stored in the cloud. Only you can see your data. We never share data with third parties.'],
        'faq_q7'    => ['bn' => 'ইন্টারনেট না থাকলে কি কাজ করবে?', 'en' => 'Does it work without internet?'],
        'faq_a7'    => ['bn' => 'মূল ফিচারগুলো ব্যবহারের জন্য ইন্টারনেট সংযোগ প্রয়োজন। তবে বাংলাদেশে এখন প্রায় সর্বত্র মোবাইল ইন্টারনেট পাওয়া যায়, তাই এটি সমস্যা হওয়ার কথা নয়।', 'en' => 'An internet connection is required to use the core features. But mobile internet is now available almost everywhere in Bangladesh, so this should not be a problem.'],
        'faq_q8'    => ['bn' => 'সাহায্য দরকার হলে কোথায় যাবো?', 'en' => 'Where do I go if I need help?'],
        'faq_a8'    => ['bn' => 'আমাদের সাপোর্ট টিম বাংলায় সাহায্য করতে সবসময় প্রস্তুত। WhatsApp, ফোন বা ইমেইলে যোগাযোগ করুন। আমরা সপ্তাহে ৬ দিন সকাল ৯টা থেকে রাত ৯টা পর্যন্ত সাহায্য করি।', 'en' => 'Our support team is always ready to help in Bangla. Reach us on WhatsApp, phone or email. We help 6 days a week, from 9am to 9pm.'],

        // Final CTA
        'cta_tag'        => ['bn' => 'আজই শুরু করুন', 'en' => 'Start Today'],
        'cta_title_1'    => ['bn' => 'আজ থেকেই আপনার ব্যবসা', 'en' => 'Starting today, run your business'],
        'cta_title_2'    => ['bn' => 'স্মার্টভাবে পরিচালনা করুন', 'en' => 'the smart way'],
        'cta_subtitle'   => ['bn' => 'বিনামূল্যে শুরু করুন। কোনো ক্রেডিট কার্ড লাগবে না। কোনো ঝামেলা নেই।', 'en' => 'Start free. No credit card required. No hassle.'],
        'cta_create_account' => ['bn' => 'বিনামূল্যে অ্যাকাউন্ট খুলুন', 'en' => 'Open a Free Account'],
        'cta_note_1'     => ['bn' => '১৪ দিন ফ্রি ট্রায়াল', 'en' => '14-day free trial'],
        'cta_note_2'     => ['bn' => 'ক্রেডিট কার্ড লাগবে না', 'en' => 'No credit card required'],
        'cta_note_3'     => ['bn' => 'যেকোনো সময় বাতিল করুন', 'en' => 'Cancel anytime'],

        // Footer
        'footer_about'   => ['bn' => 'ছোট ব্যবসার জন্য ডিজিটাল হিসাব খাতা। বাংলাদেশের উদ্যোক্তাদের জন্য তৈরি।', 'en' => 'A digital ledger for small businesses. Made for Bangladeshi entrepreneurs.'],
        'footer_help'    => ['bn' => 'সাহায্য', 'en' => 'Help'],
        'footer_support_center' => ['bn' => 'সাপোর্ট সেন্টার', 'en' => 'Support Center'],
        'footer_privacy_policy' => ['bn' => 'গোপনীয়তা নীতি', 'en' => 'Privacy Policy'],
        'footer_terms'   => ['bn' => 'ব্যবহারের শর্তাবলী', 'en' => 'Terms of Use'],
        'footer_privacy' => ['bn' => 'গোপনীয়তা', 'en' => 'Privacy'],
        'footer_terms_short' => ['bn' => 'শর্তাবলী', 'en' => 'Terms'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Error / status pages (404, 500, maintenance)
    |--------------------------------------------------------------------------
    */
    'errors' => [
        'home'                 => ['bn' => 'হোমে ফিরে যান', 'en' => 'Back to Home'],
        'go_back'              => ['bn' => 'পূর্বের পৃষ্ঠায় যান', 'en' => 'Go Back'],

        '404_code'             => ['bn' => '৪০৪', 'en' => '404'],
        '404_title'            => ['bn' => 'পৃষ্ঠাটি খুঁজে পাওয়া যায়নি', 'en' => 'Page Not Found'],
        '404_message'          => ['bn' => 'দুঃখিত, আপনি যে পৃষ্ঠাটি খুঁজছেন সেটি সরিয়ে ফেলা হয়েছে বা কখনো ছিল না।', 'en' => 'Sorry, the page you are looking for has been moved or never existed.'],

        '500_code'             => ['bn' => '৫০০', 'en' => '500'],
        '500_title'            => ['bn' => 'কিছু একটা সমস্যা হয়েছে', 'en' => 'Something Went Wrong'],
        '500_message'          => ['bn' => 'আমাদের সার্ভারে একটি অপ্রত্যাশিত সমস্যা হয়েছে। আমরা বিষয়টি দেখছি, একটু পরে আবার চেষ্টা করুন।', 'en' => 'An unexpected error occurred on our server. We are looking into it, please try again shortly.'],

        'maint_title'          => ['bn' => 'রক্ষণাবেক্ষণ চলছে', 'en' => 'Under Maintenance'],
        'maint_message'        => ['bn' => 'আমরা সেবাটিকে আরও উন্নত করতে কিছু কাজ করছি। শীঘ্রই ফিরে আসছি — ধন্যবাদ আপনার ধৈর্যের জন্য।', 'en' => 'We are performing some upgrades to serve you better. We will be back shortly — thank you for your patience.'],
        'maint_badge'          => ['bn' => 'শীঘ্রই ফিরছি', 'en' => 'Back Soon'],
        'maint_refresh'        => ['bn' => 'আবার চেষ্টা করুন', 'en' => 'Try Again'],
    ],
];
