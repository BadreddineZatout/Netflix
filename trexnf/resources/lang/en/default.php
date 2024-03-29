<?php
return array_merge([
    // Responses
    'created_response' => ':name has been created successfully',
    'updated_response' => ':name has been updated successfully',
    'deleted_response' => ':name has been deleted successfully',
    'failed_response' => 'Something went wrong',
    'notified' => ':name has been notified successfully',
    'duplicated_response' => ':name has been duplicated successfully',
    'status_updated_response' => ':name status has been changed to :status',
    'action_not_allowed' => 'You are not allowed for this action',
    'cant_delete_own_account' => 'You can\'t delete your own account',
    'attached_response' => ':name has been attached successfully',
    'detached_response' => ':name has been detached successfully',
    'default_delete' => 'You can not delete the default :name .',
    'default_update' => 'You can not update the default :name',
    'old_password_is_in_correct' => 'Old password is incorrect',
    'attach_log' => 'New :pivot attached to :model',
    'detach_log' => ':pivot detached from :model',
    'status_log' => ':model has been :status',
    'incorrect_user_password' => 'Incorrect user or password',
    'invite_user_response' => 'User has been invited successfully',
    'invalid_token' => 'The token is Invalid',
    'user_account_confirmed' => 'Your account has been confirmed successfully',
    'user_invited_to_join' => 'An user has been invited to join',
    'user_confirm_joining' => 'User confirmed his joining',
    'log_description_message' => ':model has been :event',
    'password_reset_mail_has_been_sent_successfully' => 'We sent an email containing password reset link to your email address. Please check it',
    'no_user_found_on_that_email' => 'No user found of that email address.',
    'password_has_been_reset_successfully' => 'Your password has been reset successfully',
    'resource_not_found' => 'The :resource you are looking for is not found.',
    'created' => 'Created',
    'deleted' => 'Deleted',
    'updated' => 'updated',
    'resource' => 'resource',

    // Number of Decimal
    '0' => 'ZERO (0)',

    //HTTP Responses
    '200' => 'Success',

    //Number of Decimal
    '2' => 'TWO (2)',

    // HTTP Responses
    '400' => 'Bad Request',
    '401' => 'Unauthorized',
    '403' => 'Forbidden',
    '404' => 'Not Found',
    '413' => 'Payload too large',
    '414' => 'URI Too long',
    '415' => 'Unsupported Media Type',
    '426' => 'Upgrade Required',
    '429' => 'Too Many Requests',


    // Features

    // Custom Field Builder
    'custom_field' => 'Custom field',
    'custom_field_type' => 'Custom field Type',

    // Fields
    'text' => 'Textbox',
    'textarea' => 'Textarea',
    'checkbox' => 'Checkbox',
    'radio_button' => 'Radio Button',
    'select' => 'Select',
    'multi_select' => 'Multi Select',

    // Notification event
    'notification_event_name' => ':name :action',
    'notification_created' => 'created',
    'notification_updated' => 'updated',
    'notification_deleted' => 'deleted',
    'notification_user' => 'user',
    'notification_reset' => 'reset',

    // Notifications
    'notification' => 'Notification',
    'notify_by_email' => 'Notify by Email',
    'notify_by_sms' => 'Notify by SMS',
    'notification_settings' => 'Notification settings',
    'notification_template' => 'Notification template',

    // Labels
    'user' => 'User',
    'brand' => 'Brand',
    'status' => 'Status',
    'name' => 'Name',
    'email' => 'Email',
    'mail' => 'Mail',
    'value' => 'Value',
    'type' => 'Type',
    'database' => 'System',
    'sms' => 'SMS',
    'users' => 'Users',
    'roles' => 'Roles',
    'role' => 'Role',
    'permissions' => 'Permissions',
    'permission' => 'Permission',
    'settings' => 'Settings',
    'password' => 'Password',
    'allowed' => 'allowed',
    'profile_picture' => 'Profile picture',
    'delivery_settings' => 'Email settings',
    'brand_settings' => 'Brand settings',
    'privacy_settings' => 'Privacy settings',
    'corn_job' => 'Corn job',
    'brand_group' => 'Brand group',
    'template' => 'Template',
    'profile' => 'Profile',
    'log' => 'Log',
    'invite' => 'Invite',

    //Settings
    'app_name' => 'App Name',
    'brand_name' => 'Brand Name',

    // Status
    'status_active' => 'Active',
    'status_pending' => 'Pending',
    'status_deleted' => 'Deleted',
    'status_processing' => 'Processing',
    'status_sent' => 'Sent',
    'status_draft' => 'Draft',
    'status_regular' => 'Regular',
    'status_auto' => 'Auto',
    'status_dynamic' => 'Dynamic',
    'status_imported' => 'Imported',
    'status_black-listed' => 'Black listed',
    'status_inactive' => 'Inactive',

    // Permissions
    'manage_dashboard' => 'Can manage app dashboard',
    'view_users' => 'Can view list of user',
    'create_users' => 'Can create an user',
    'update_users' => 'Can update an user',
    'delete_users' => 'Can delete an user',
    'view_brands' => 'Can view list of brand',
    'create_brands' => 'Can create brand',
    'update_brands' => 'Can update brand',
    'delete_brands' => 'Can delete brand',
    'user_list_brands' => 'Can view users of a brand',
    'attach_users_brands' => 'Can attach user to brand',
    'detach_users_brands' => 'Can detach user from a brand',
    'brand_list_users' => 'Can view brands of a user',
    'manage_brand_dashboard' => 'Can view brand dashboard',
    'update_brand_privacy_settings' => 'Can update brand privacy from app',
    'view_brand_privacy_settings' => 'Can view brand privacy from app',
    'view_roles' => 'Can view list of role',
    'create_roles' => 'Can create role',
    'update_roles' => 'Can update role',
    'delete_roles' => 'Can delete role',
    'view_settings' => 'Can view list of setting',
    'update_settings' => 'Can update setting',
    'view_permission' => 'Can view list of permission',
    'view_custom_fields' => 'Can view list of custom field',
    'create_custom_fields' => 'Can create custom field',
    'update_custom_fields' => 'Can update custom field',
    'delete_custom_fields' => 'Can delete custom field',
    'attach_roles_users' => 'Can attach roles to users',
    'detach_roles_users' => 'Can detach roles from users',
    'attach_permissions_roles' => 'Can attach permissions to role',
    'detach_permissions_roles' => 'Can detach permissions from role',
    'change_settings_users' => 'Can change own settings',
    'settings_list_users' => 'Can view settings list',
    'change_password_users' => 'Can change user password',
    'change_profile_picture_users' => 'Can change profile picture',
    'update_delivery_settings' => 'Can update email settings',
    'update_corn_job_settings' => 'Can update corn job settings',
    'view_corn_job_settings' => 'Can view corn job settings',
    'view_delivery_settings' => 'Can view email settings',
    'view_brand_delivery_settings' => 'Can view brand delivery settings',
    'view_notification_settings' => 'Can view notification settings',
    'update_notification_settings' => 'Can update notification settings',
    'create_brand_groups' => 'Can create brand group',
    'view_brand_groups' => 'Can view brand group',
    'update_brand_groups' => 'Can update brand group',
    'delete_brand_groups' => 'Can delete brand group',
    'attach_brand_brand_groups' => 'Can attach brand to brand group',
    'detach_brand_brand_groups' => 'Can detach brand from brand group',
    'view_brands_brand_groups' => 'Can view brands of a brand group',
    'view_notification_templates' => 'Can view notification templates',
    'create_notification_templates' => 'Can create notification templates',
    'update_notification_templates' => 'Can update notification templates',
    'delete_notification_templates' => 'Can delete notification templates',
    'attach_templates_notification_events' => 'Can attach templates to notification event',
    'detach_templates_notification_events' => 'Can detach templates to notification event',
    'view_activity_logs' => 'Can view activity log',
    'view_templates' => 'Can view templates',
    'create_templates' => 'Can create templates',
    'update_templates' => 'Can update templates',
    'delete_templates' => 'Can delete templates',
    'invite_user' => 'Can invite user',

    'date_format' => 'date format',
    'time_format' => 'time format',
    'decimal_separator' => 'decimal separator',
    'thousand_separator' => 'thousand separator',
    'number_of_decimal' => 'number of decimal',
    'currency_position' => 'currency position',

    // Language
    'en' => 'English',

    // Date Format
    'd-m-Y' => 'DD-MM-YYYY',
    'm-d-Y' => 'MM-DD-YYYY',
    'Y-m-d' => 'YYYY-MM-DD',
    'm/d/Y' => 'MM/DD/YYYY',
    'd/m/Y' => 'DD/MM/YYYY',
    'Y/m/d' => 'YYYY/MM/DD',
    'm.d.Y' => 'MM.DD.YYYY',
    'd.m.Y' => 'DD.MM.YYYY',
    'Y.m.d' => 'YYYY.MM.DD',

    // Time Format
    'h' => '12 HOURS',
    'H' => '24 HOURS',

    // Decimal and Thousand Separator
    '.' => 'DOT(.)',
    ',' => 'COMMA(,)',
    ' ' => 'Space',



    // Currency Positions
    'prefix_only' => '$1,100.00',
    'prefix_with_space' => '$ 1,100.00',
    'suffix_only' => '1,100.00$',
    'suffix_with_space' => '1,100.00 $',

    // Empty data
    "nothing_to_show_here" => "Nothing to show here",
    "thank_you" => "Thank you",
    "go_back_to_your_page" => "Go back to your page",
    "something_went_wrong" => "Something went wrong!",
    "empty_data_block_dummy_message" => "Please add a new entity or manage the data table to see the content here",

    'you_are_invited' => 'You are invited',


    //No notification
    "no_notification_one" => "It's very much boring to do as usual stuff, let's have a party with some beer!",
    "no_notification_two" => "Are you hungry there? Please have good food and get back to work.",
    "no_notification_three" => "Rock & role time! Turn on your music and have some fun with your team.",

    // Date Format
    'dd-mm-yyyy' => 'DD-MM-YYYY',

    // Validation
    "is_required" => "is required",
    "and" => "and",
    "this_field_is_required" => "This field is required",
    "this_field_is_invalid" => "This field is invalid",
    "this_field_is_not_alphanumeric" => "This field is not alphanumeric",
    "passwords_are_not_matched" => "Passwords are not matched",
    "please_enter_a_strong_password" => "Please enter a strong password.",
    "are_not_match" => "are not match",
    "can_not_before" => "can not before",
    "is_invalid" => "is invalid",
    "minimum_length_is" => "Minimum length is",
    "maximum_length_is" => "Maximum length is",
    "maximum_number_is" => "Maximum number is",
    "minimum_number_is" => "Minimum number is",
    "is_not_alphanumeric" => "is not alphanumeric",
    "not_found" => "Not found",

    // Btn
    "load_more" => "Load more",
    "apply" => "Apply",
    "clear" => "Clear",
    "close" => "Close",
    "yes" => "Yes",
    "no" => "No",
    "more" => "more",
    "actions" => "Actions",

    // Multi select component
    "add" => "add",

    // Filters
    "filters" => "Filters",
    "minimum_rate" => "Minimum rate",
    "maximum_rate" => "Maximum rate",
    "want_to_manage_datatable" => "Want to manage datatable?",
    "please_drag_and_drop_your_column_to_reorder_your_table_and_enable_see_option_as_you_want" => "Please drag and drop your column to reorder your table and enable see option as you want.",
    "manage_columns" => "Manage Columns",
    "search" => "Search",

    // Modal
    "are_you_sure" => "Are you sure?",
    "this_content_will_be_deleted_permanently" => "This content will be deleted permanently.",

    // File upload
    "change_image" => "Change Image",
    "choose_file" => "Choose File",
    "drag_and_drop" => "Drag & Drop",
    "or" => "or",
    "browse" => "Browse",

    // No notification
    "no_notification_one" => "It's very much boring to do as usual stuff, let's have a party with some beer!",
    "no_notification_two" => "Are you hungry there? Please have good food and get back to work.",
    "no_notification_three" => "Rock & role time! Turn on your music and have some fun with your team.",
    "all_notifications" => "All Notifications",

    // Tooltip titles
    "collapse_sidebar" => "Collapse sidebar",
    "floating_sidebar" => "Floating sidebar",
    "full_sidebar" => "Full sidebar",
    "light_mood" => "Light mood",
    "dark_mood" => "Dark mood",
    "fullscreen" => "Fullscreen",
    "exit_fullscreen" => "Exit fullscreen",

    // Tenant Preview Card
    "invited_by" => "Invited by",
    "short_name" => "Short name",
    "group" => "Group",
    "go_to_dashboard" => "Go To Dashboard",

], include 'custom.php');
