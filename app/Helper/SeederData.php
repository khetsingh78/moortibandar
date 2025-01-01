<?php

function roles()
{
    $roles = [
        [
            "name" => "user",
            "description" => "persion who can login on site.",
        ],
        [
            "name" => "team-leader",
            "description" => "persion who is leader of few employees.",
        ],
        [
            "name" => "manager",
            "description" => "manage all the team leader and there activities.",
        ],
        [
            "name" => "admin",
            "description" => "persion who can access all the features of panel.",
        ],
        [
            "name" => "super-admin",
            "description" => "persion who have access all features.",
        ],
    ];

    return $roles;
}


function permissions()
{
    $permissions = [
        [
            "name" => "add",
            "description" => "only can add.",
        ],
        [
            "name" => "read",
            "description" => "only can read.",
        ],
        [
            "name" => "update",
            "description" => "only can update.",
        ],
        [
            "name" => "delete",
            "description" => "only can delete.",
        ],
    ];

    return  $permissions;
}

function RolePermissions()
{
    $RolePermissions = [
        [
            "role_id" => 1,
            "permission_id" => 1,
        ],
        [
            "role_id" => 1,
            "permission_id" => 2,
        ],
        [
            "role_id" => 1,
            "permission_id" => 3,
        ],

        [
            "role_id" => 5,
            "permission_id" => 1,
        ],
        [
            "role_id" => 5,
            "permission_id" => 2,
        ],
        [
            "role_id" => 5,
            "permission_id" => 3,
        ],
        [
            "role_id" => 5,
            "permission_id" => 4,
        ],
    ];

    return  $RolePermissions;
}

function userRoles()
{
    $userRoles = [
        [
            "user_id" => 1,
            "role_id" => 1,
        ],
        [
            "user_id" => 2,
            "role_id" => 5,
        ],
    ];

    return  $userRoles;
}

function category()
{

    $category = [
        [
            "name" => "jain-statue",
            "parent_id" => null
        ],
        [
            "name" => "hindu-statue",
            "parent_id" => null
        ],
        [
            "name" => "mahavir",
            "parent_id" => 1
        ],
        [
            "name" => "parasnath",
            "parent_id" => 1
        ],
        [
            "name" => "gautam-swami",
            "parent_id" => 1
        ],
        [
            "name" => "ganesh",
            "parent_id" => 2
        ],
        [
            "name" => "mahalakshmi",
            "parent_id" => 2
        ],
        [
            "name" => "saraswati",
            "parent_id" => 2
        ],
        [
            "name" => "durga",
            "parent_id" => 2
        ],
        [
            "name" => "krishna",
            "parent_id" => 2
        ],
        [
            "name" => "radha-krishan",
            "parent_id" => 2
        ],
    ];

    return $category;
}

function discount()
{

    $discount = [
        [
            "name" => "product name",
            "description" => "percentage of project is very according to state",
            "dis_percent" => "0%",
            "status" => "dective",

        ],
        [
            "name" => "product name",
            "description" => "percentage of project is very according to state",
            "dis_percent" => "5%",
            "status" => "dective",

        ],
        [
            "name" => "product name",
            "description" => "percentage of project is very according to state",
            "dis_percent" => "10%",
            "status" => "dective",

        ],
        [
            "name" => "product name",
            "description" => "percentage of project is very according to state",
            "dis_percent" => "15%",
            "status" => "dective",

        ],
        [
            "name" => "product name",
            "description" => "percentage of project is very according to state",
            "dis_percent" => "25%",
            "status" => "dective",

        ],
        [
            "name" => "product name",
            "description" => "percentage of project is very according to state",
            "dis_percent" => "50%",
            "status" => "dective",

        ],
        [
            "name" => "product name",
            "description" => "percentage of project is very according to state",
            "dis_percent" => "75%",
            "status" => "dective",

        ],

    ];

    return $discount;
}

function gsttax()
{

    $gsttax = [
        [
            "gst" => "0%",
            "description" => "goods and servie tax.",
        ],
        [
            "gst" => "5%",
            "description" => "goods and servie tax.",
        ],
        [
            "gst" => "10%",
            "description" => "goods and servie tax.",
        ],
        [
            "gst" => "12%",
            "description" => "goods and servie tax.",
        ],
        [
            "gst" => "16%",
            "description" => "goods and servie tax.",
        ],
        [
            "gst" => "18%",
            "description" => "goods and servie tax.",
        ],
        [
            "gst" => "20%",
            "description" => "goods and servie tax.",
        ],
        [
            "gst" => "24%",
            "description" => "goods and servie tax.",
        ]

    ];

    return $gsttax;
}

function height()
{

    $height = [
        [
            "name" => "6 inch",
        ],
        [
            "name" => "7 inch",
        ],
        [
            "name" => "8 inch",
        ],
        [
            "name" => "8 inch",
        ],
        [
            "name" => "9 inch",
        ],
        [
            "name" => "10 inch",
        ],
        [
            "name" => "11 inch",
        ],
        [
            "name" => "12 inch",
        ],
        [
            "name" => "13 inch",
        ],
        [
            "name" => "14 inch",
        ],
        [
            "name" => "15 inch",
        ],
        [
            "name" => "16 inch",
        ],
        [
            "name" => "17 inch",
        ],
    ];

    return $height;
}

function dimension()
{

    $dimension = [
        [
            "name" => "9 x 4 inch",
        ],
        [
            "name" => "10 x 12 inch",
        ],
        [
            "name" => "8 x 12 inch",
        ],
        [
            "name" => "8 x 14 inch",
        ],
        [
            "name" => "9 x 10 inch",
        ],
        [
            "name" => "10 x 15 inch",
        ],
        [
            "name" => "11 x 25 inch",
        ],
        [
            "name" => "12 x 16 inch",
        ]

    ];

    return $dimension;
}

function marbal()
{

    $marbal = [
        [
            "name" => "white",
        ],
        [
            "name" => "black",
        ],
        [
            "name" => "green",
        ],
        [
            "name" => "red",
        ],
        [
            "name" => "blue",
        ],

    ];

    return $marbal;
}

function painting()
{

    $painting = [
        [
            "name" => "Elegant Gold",
        ],
        [
            "name" => "Elegant Silver",
        ],
    ];

    return $painting;
}
