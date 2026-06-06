<?php

/*
|--------------------------------------------------------------------------
| Business Types
|--------------------------------------------------------------------------
|
| Supported SME business types (must match the tenants.business_type enum)
| and the default product categories created for each type at registration.
|
*/

return [

    'types' => [
        'grocery' => 'Grocery',
        'pharmacy' => 'Pharmacy',
        'cosmetics' => 'Cosmetics',
        'stationery' => 'Stationery',
        'mobile_accessories' => 'Mobile Accessories',
        'wholesale' => 'Wholesale',
        'other' => 'Other',
    ],

    'default_categories' => [
        'grocery' => ['Rice', 'Oil', 'Biscuit', 'Beverage', 'Spices'],
        'pharmacy' => ['Medicine', 'Syrup', 'Injection', 'Cosmetics', 'Devices'],
        'cosmetics' => ['Skin Care', 'Hair Care', 'Makeup', 'Perfume'],
        'stationery' => ['Pen', 'Notebook', 'Paper', 'Office Supplies'],
        'mobile_accessories' => ['Charger', 'Earphone', 'Cover', 'Cable', 'Power Bank'],
        'wholesale' => ['General'],
        'other' => ['General'],
    ],

];
