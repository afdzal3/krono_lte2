<?php

use App\Shared\UserHelper;


return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Overtime Claim System!',

    'title_prefix' => 'OTCS - ',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => 'NEO',

    // 'logo_mini' => '<b>A</b>LT',
    'logo_mini' => 'NEO',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | light variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'black-light',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => true,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we have the option to enable a right sidebar.
    | When active, you can use @section('right-sidebar')
    | The icon you configured will be displayed at the end of the top menu,
    | and will show/hide de sidebar.
    | The slide option will slide the sidebar over the content, while false
    | will push the content, and have no animation.
    | You can also choose the sidebar theme (dark or light).
    | The right Sidebar can only be used if layout is not top-nav.
    |
    */

    'right_sidebar' => true,
    'right_sidebar_icon' => 'fas fa-exclamation',
    'right_sidebar_theme' => 'light',
    'right_sidebar_slide' => true,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs.
    | This was automatically set on install, only change if you really need.
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and a URL. You can also specify an icon from Font
    | Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    */

    'menu' => [

      //   //UNCOMMENT THIS LATER
      //System Configuration
      ['header' => 'admin_menu', 'can' => '1-nav-menu-admin'],
      [//System Configuration
        'text' => 'admin_menu',
        'icon' => 'fas f fa-user-clock',
        'can' => '1-nav-menu-admin',
        'submenu' => [
          [
              'text' => 'manage_role',
              'url'  => '/admin/role',
              'icon' => '',
            //   'icon' => 'fas fa-lock-open',
              'can' => '1-nav-admin',
          ],
          [
              'text' => 'manage_company',
              'url'  => '/admin/company',
              'icon' => '',
            //   'icon' => 'fas fa-briefcase',
              'can' => '1-nav-admin',
          ],
          [
              'text' => 'manage_state',
              'url' => '/admin/state/show',
              'icon' => '',
            //   'icon' => 'fas fa-map-marked-alt',
              'can' => '1-nav-admin',
          ],
          [
            'text' => 'manage_psubarea',
            'url' => '/admin/psubarea',
            'icon' => '',
            //   'icon' => 'fas fa-map-marked-alt',
            'can' => '1-nav-admin',
          ],
          // [
          //     'text' => 'manage_overtime',
          //     'url' => '/admin/overtime',
          //      'otm' => '',
          //     'icon' => '',
          //   //   'icon' => 'fas fas fa-clock',
          //     // 'can' => '2-cfg-psubarea',
          // ],
          [
              'text' => 'manage_eligibility',
              'url' => '/admin/overtime/eligibility',
              'icon' => '',
            //   'icon' => 'fas fas fa-clock',
              'can' => '1-nav-admin',
          ],
          // [
          //     'text' => 'manage_formula',
          //     'url' => '/admin/overtime/formula',
          //     'icon' => '',
          //   //   'icon' => 'fas fas fa-clock',
          //     'can' => '1-nav-admin',
          // ],
          [
              'text' => 'manage_wdays',
              'url'  => '/admin/workday',
              'icon' => '',
            //   'icon' => 'far fa-calendar-alt',
              'can' => '1-nav-admin',
          ],
          [
              'text' => 'shift_template',
              'url'  => '/admin/shift_pattern',
              'icon' => '',
            //   'icon' => 'far fa-calendar-alt',
              'can' => '1-nav-admin',
          ],
          [
              'text' => 'payrollgroup',
              'url' => '/admin/pygroup',
              'icon' => '',
            //   'icon' => 'fas fa-calendar-alt',
              'can' => '1-nav-admin',
          ],
          [
              'text' => 'paymentsch',
              'url' => '/admin/paymentsc',
              'icon' => '',
            //   'icon' => 'fas fa-calendar-alt',
              'can' => '1-nav-admin',
          ],
          [
            'text' => 'manage_holiday',
            'url' => '/admin/holiday/show',
            'icon' => '',
            //   'icon' => 'fas fa-umbrella-beach',
            'can' => '1-nav-admin',
          ],
          [
            'text' => 'manage_overtimeex',
            'url' => '/admin/overtime',
            'icon' => '',
            //   'icon' => 'fas fas fa-clock',
            'can' => '1-nav-admin',
          ],
          [
              'text' => 'manage_announcement',
              'url' => '/admin/announcement',
              'icon' => '',
            //   'icon' => 'fas fa-calendar-alt',
              'can' => '1-nav-admin',
          ],
        ],
      ],
      [ //USER MANAGMENT
        'text' => 'admin_user_menu',
        'icon' => 'fas fa-clock',
        'can' => '5-user-mngmt-menu',
        'submenu' => [
          [
              'text' => 'user_autho',
              'url'  => '/admin/staff/auth/empty',
              'icon' => '',
              'estaffauth' => '',
              'can' => '5-user-mngmt',
          ],
          [
              'text' => 'staff_list',
              // 'url'  => '/staff',
              'url'  => '/staffidx',
              'icon' => '',
              'can' => '5-user-mngmt',
          ],
          [
              'text' => 'manual_overtime',
              'url' => '/admin/overtime/approval',
              'otv' => '',
              'icon' => '',
              'can' => '5-user-mngmt',
          ],
          [
              'text' => 'user_logs',
              'url' => '/log/listUserLogs',
              'icon' => '',
              'can' => '5-user-mngmt',
          ],
          [
              'text' => 'week_remind',
              'route' => 'reminder.jobs',
              'icon' => '',
              'can' => '5-user-mngmt',
          ],
          [
              'text' => 'admin_shift_group',
              'route' => 'admin.shiftgroup',
              'icon' => '',
              'can' => '5-user-mngmt',
          ],
          [
              'text' => 'admin_shift_group_pattern',
              'route' => 'admin.shiftGroupPattern',
              'icon' => '',
              'can' => '5-user-mngmt',
          ],
          [
              'text' => 'admin_shift_planning',
              'route' => 'admin.shiftplanning',
              'icon' => '',
              'can' => '5-user-mngmt',
          ],
          [
              'text' => 'maintenance_order',
              'route' => 'mo.list',
              'icon' => '',
              'can' => '5-user-mngmt',
          ],
          [
              'text' => 'project_list',
              'route' => 'project.list',
              'icon' => '',
              'can' => '5-user-mngmt',
          ],
        ]
      ],


      // [
      //   'text' => 'Dummy',
      //   'icon' => 'fas fa-carrot',
      //   'submenu' => [
      //     [
      //         'text' => 'Dummy Email',
      //         'url'  => '/email/dummy',
      //         'icon' => 'fas fa-envelope',
      //         // 'can' => 'admin-nav-menu',
      //     ],
      //   ]
      // ],
//UNCOMMENT THIS LATER



      [ //USER
        'header' => 'user_menu',
      ],
      [
          'text' => 'user_home',
          'url'  => '/home',
          'icon' => 'fas fa-home',
      ],
      [
        'text' => 'user_profile',
        'url'  => '/staff/profile',
        'icon' => 'fas fa-user',
      ],

      // [
      //     'text' => 'staff_list',
      //     'url'  => '/staff',
      //     'icon' => 'fas fa-tasks',
      //     // 'can' => '3-user-staff-list',
      // ],

      [ //OVERTIME
        'text' => 'ot_menu',
        'icon' => 'fas fa-user-clock',
        // 'can' => '2-ot-menu',
        'submenu' => [
          [
            'text' => 'ot_apply',
            'url'  => '/overtime/form',
            'otnew' => '',
            'icon' => '',
            // 'can' => '2-ot-all',
          ],
          [
              'text' => 'user_punch_list',
              'url'  => '/punch',
              'icon' => '',
              // 'can' => '2-ot-all',
          ],
          [
              'text' => 'claim_list',
              'url'  => '/overtime',
              'icon' => '',
              // 'can' => '2-ot-all',
          ],
          [
              'text' => 'ot_verify',
              'url'  => '/overtime/verify',
              // 'label'       => UserHelper::GetRequireAttCount(),
              // 'label' => OvertimeController::getQueryAmount(),
              'label_color' => 'warning',
              'icon' => '',
              // 'can' => '2-ot-all',
          ],
          [
              'text' => 'ot_verify_report',
              'url'  => '/overtime/verify/report',
              'label_color' => 'warning',
              'icon' => '',
              // 'can' => '2-ot-all',
          ],
          [
              'text' => 'ot_approve',
              'url'  => '/overtime/approval',
                  // 'label'       => UserHelper::GetRequireAttCount(),
              // 'label' => OvertimeController::getQueryAmount(),
              'label_color' => 'warning',
              'icon' => '',
              // 'can' => '2-ot-all',
          ],
          [
              'text' => 'ot_approve_report',
              'url'  => '/overtime/approval/report',
              'label_color' => 'warning',
              'icon' => '',
              // 'can' => '2-ot-all',
          ],

          [
              'text' => 'ot_def_ver',
              'url'  => '/verifier',
              'icon' => '',
              // 'can' => '2-ot-all',
          ],
        ]
      ],
      [ //SHIFT MANAGEMENT
        'text' => 'shift_menu',
        'icon' => 'fas fa-clock',
        // 'can' => '1-nav-menu-shiftp',
        'submenu' => [
          [
              'text' => 'shift_group',
              'url'  => '/shift_plan/group',
              'icon' => '',
              'can' => '3-shift-grp',
          ],
          [
              'text' => 'my_shift_grp',
              'url'  => '/shift_plan/mygroup',
              'icon' => '',
              // 'can' => '4-shift-plan',
          ],
          [
              'text' => 'shift_plan',
              'url'  => '/shift_plan',
              'icon' => '',
              // 'can' => '4-shift-plan',
          ],
          [
              'text' => 'shift_approval',
              'url'  => '/shift_plan',
              'icon' => '',
              // 'can' => '4-shift-plan',
          ],
          [
              'text' => 'user_shift_sc',
              'url'  => '/workschedule',
              'icon' => '',
              // 'can' => '4-shift-plan-all',
          ],
          [
              'text' => 'shift_workteam',
              'url'  => '/workschedule?page=teamc',
              'icon' => '',
              // 'can' => '4-shift-plan',
          ],
        ]
      ],
      [ //REPORT USER ADMIN
        'text' => 'rpt_menu',
        'icon' => 'fas fa-print',
        'can' => '6-rpt-ot-menu',
        'submenu' => [
          [
            'text' => 'otr_details',
            'url'  => '/report/otd',
            'icon' => '',
            'can' => '6-rpt-ot',
          ],
          [
            'text' => 'otr',
            'url'  => '/report/ot',
            'icon' => '',
            'can' => '6-rpt-ot',
          ],
        ],
      ],
      [//REPORT SYSADM
        'text' => 'rpt_menu',
        'icon' => 'fas fa-print',
        'can' => '7-rpt-ot-sa-menu',
        'submenu' => [
          [
            'text' => 'sysadmotd',
            'url'  => '/syadmrep/otd',
            'icon' => '',
            'can' => '7-rpt-ot-sa',
          ],
          [
            'text' => 'sysadmot',
            'url'  => '/syadmrep/ot',
            'icon' => '',
            'can' => '7-rpt-ot-sa',
          ],
          [
            'text' => 'sysadmotStEd',
            'url'  => '/syadmrep/StEd',
            'icon' => '',
            'can' => '7-rpt-ot-sa',
          ],
          [
            'text' => 'sysadmotlog',
            // 'url'  => '/syadmrep/otlog',
            'url'  => '/report/otlog',
            'icon' => '',
            'can' => '7-rpt-ot-sa',
          ],
        ],
      ],
      [
          'header' => 'INFO',
      ],
      [//Holiday calendar
        'text' => 'guideline_calendar',
        'url'  => 'guide/calendar',
        'icon' => 'fa fa-calendar',
        'guide' => '',
      ],
      [//GUIDELINE
          'text' => 'user_guide',
          'icon' => 'fas fa-info-circle',
          'submenu' => [
            [
              'text' => 'guideline_system',
              'url'  => 'guide/system',
              'icon' => '',
            ],
            [
              'text' => 'guideline_payment',
              'url'  => 'guide/calendar/payment',
              'icon' => '',
            ],
          ],
      ],
      [
        'text' => 'user_faqs',
        'url'  => '/vendor/docs/FAQs.pdf',
        'icon' => 'fas fa-question-circle',
        //'can' => '1-user-faqs',
      ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Configure which JavaScript plugins should be included. At this moment,
    | DataTables, Select2, Chartjs and SweetAlert are added out-of-the-box,
    | including the Javascript and CSS files from a CDN via script and link tag.
    | Plugin Name, active status and files array (even empty) are required.
    | Files, when added, need to have type (js or css), asset (true or false) and location (string).
    | When asset is set to true, the location will be output using asset() function.
    |
    */

    'plugins' => [
        [
          'name' => 'Jszip',
          'active' => true,
          'files' => [
              [
                  'type' => 'js',
                  'asset' => false,
                  'location' => '//cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js',
              ],
          ],
        ],
        [
          'name' => 'PDFmake',
          'active' => true,
          'files' => [
              [
                  'type' => 'js',
                  'asset' => false,
                  //'location' => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.62/pdfmake.min.js',
                  'location' => '/vendor/otcdn/pdfmake.min.js',
              ],
              [
                  'type' => 'js',
                  'asset' => false,
                  //'location' => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.62/vfs_fonts.js',
                  'location' => '/vendor/otcdn/vfs_fonts.js',
              ],
          ],
        ],
        [
            'name' => 'Datatables',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    //'location' => '//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js',
                    //'location' => '//cdn.datatables.net/v/bs/dt-1.10.20/b-1.6.0/b-html5-1.6.0/fh-3.1.6/datatables.min.js',
                    'location' => '/vendor/otcdn/datatables.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    //'location' => '//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css',
                    //'location' => '//cdn.datatables.net/v/bs/dt-1.10.20/b-1.6.0/b-html5-1.6.0/fh-3.1.6/datatables.min.css',
                    'location' => '/vendor/otcdn/datatables.min.css',
                ],

            ],
        ],
        [
            'name' => 'Select2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    //'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js',
                    'location' => '/vendor/otcdn/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    //'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.css',
                    'location' => '/vendor/otcdn/select2.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    //'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                    'location' => '/vendor/otcdn/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    //'location' => '//cdn.jsdelivr.net/npm/sweetalert2@9',
                    'location' => '/vendor/otcdn/sweetalert2@9',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    //'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                    'location' => '/vendor/otcdn/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    //'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                    'location' => '/vendor/otcdn/pace.min.js',
                ],
            ],
        ],
        [
            'name' => 'Datejs',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/vendor/datejs/build/date.js',
                    //'location' => secure_asset('/vendor/datejs/build/date.js'),
                ],
                // [
                //     'type' => 'js',
                //     'asset' => true,
                //     'location' => '/vendor/datejs/src/date.js',
                // ],
            ],
        ],
    ],
];
