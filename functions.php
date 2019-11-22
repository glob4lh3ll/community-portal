<?php
// Mozilla theme functions file

// Remove the admin header styles for homepage
add_action('get_header', 'remove_admin_login_header');

// Native Wordpress Actions
add_action('init', 'mozilla_init');
add_action('wp_enqueue_scripts', 'mozilla_init_scripts');
add_action('admin_enqueue_scripts', 'mozilla_init_admin_scripts');
add_action('admin_menu', 'mozilla_add_menu_item');

// Ajax Calls
add_action('wp_ajax_nopriv_upload_group_image', 'mozilla_upload_image');
add_action('wp_ajax_upload_group_image', 'mozilla_upload_image');
add_action('wp_ajax_join_group', 'mozilla_join_group');
add_action('wp_ajax_nopriv_join_group', 'mozilla_join_group');
add_action('wp_ajax_leave_group', 'mozilla_leave_group');
add_action('wp_ajax_get_users', 'mozilla_get_users');
add_action('wp_ajax_validate_email', 'mozilla_validate_email');
add_action('wp_ajax_nopriv_validate_group', 'mozilla_validate_group_name');
add_action('wp_ajax_validate_group', 'mozilla_validate_group_name');
add_action('wp_ajax_check_user', 'mozilla_validate_username');

// Gutenberg Setup 
function pg_blocks() {
  wp_enqueue_script('blocks-scripts', get_template_directory_uri() . '/js/gutenberg.js', array('wp-blocks', 'wp-dom-ready', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-i18n', 'jquery'), false, true);
 }
 add_action('enqueue_block_editor_assets', 'pg_blocks', 10, 1);


// Buddypress Actions
add_action('bp_before_create_group_page', 'mozilla_create_group', 10, 1);
add_action('bp_before_edit_group_page', 'mozilla_edit_group', 10, 1);
add_action('bp_before_edit_member_page', 'mozilla_update_member', 10, 1);

// Removed cause it was causing styling conflicts
remove_action('init', 'bp_nouveau_get_container_classes');
remove_action('em_event_save','bp_em_group_event_save', 1, 2);


// Auth0 Actions
add_action('auth0_user_login', 'mozilla_post_user_creation', 10, 6);

// Filters
add_filter('nav_menu_link_attributes', 'mozilla_add_menu_attrs', 10, 3);
add_filter('nav_menu_css_class', 'mozilla_menu_class', 10, 4);
//add_filter('nav_menu_css_class', 'mozilla_add_active_page' , 10 , 2);

// Events Action
add_action('save_post', 'mozilla_save_event', 10, 3);


// Include theme style.css file not in admin page
if(!is_admin()) 
    wp_enqueue_style('style', get_stylesheet_uri());

$countries = Array(
    "AF" => "Afghanistan",
    "AL" => "Albania",
    "DZ" => "Algeria",
    "AS" => "American Samoa",
    "AD" => "Andorra",
    "AO" => "Angola",
    "AI" => "Anguilla",
    "AQ" => "Antarctica",
    "AG" => "Antigua and Barbuda",
    "AR" => "Argentina",
    "AM" => "Armenia",
    "AW" => "Aruba",
    "AU" => "Australia",
    "AT" => "Austria",
    "AZ" => "Azerbaijan",
    "BS" => "Bahamas",
    "BH" => "Bahrain",
    "BD" => "Bangladesh",
    "BB" => "Barbados",
    "BY" => "Belarus",
    "BE" => "Belgium",
    "BZ" => "Belize",
    "BJ" => "Benin",
    "BM" => "Bermuda",
    "BT" => "Bhutan",
    "BO" => "Bolivia",
    "BA" => "Bosnia and Herzegovina",
    "BW" => "Botswana",
    "BV" => "Bouvet Island",
    "BR" => "Brazil",
    "IO" => "British Indian Ocean Territory",
    "BN" => "Brunei Darussalam",
    "BG" => "Bulgaria",
    "BF" => "Burkina Faso",
    "BI" => "Burundi",
    "KH" => "Cambodia",
    "CM" => "Cameroon",
    "CA" => "Canada",
    "CV" => "Cape Verde",
    "KY" => "Cayman Islands",
    "CF" => "Central African Republic",
    "TD" => "Chad",
    "CL" => "Chile",
    "CN" => "China",
    "CX" => "Christmas Island",
    "CC" => "Cocos (Keeling) Islands",
    "CO" => "Colombia",
    "KM" => "Comoros",
    "CG" => "Congo",
    "CD" => "Congo, the Democratic Republic of the",
    "CK" => "Cook Islands",
    "CR" => "Costa Rica",
    "CI" => "Cote D'Ivoire",
    "HR" => "Croatia",
    "CU" => "Cuba",
    "CY" => "Cyprus",
    "CZ" => "Czech Republic",
    "DK" => "Denmark",
    "DJ" => "Djibouti",
    "DM" => "Dominica",
    "DO" => "Dominican Republic",
    "EC" => "Ecuador",
    "EG" => "Egypt",
    "SV" => "El Salvador",
    "GQ" => "Equatorial Guinea",
    "ER" => "Eritrea",
    "EE" => "Estonia",
    "ET" => "Ethiopia",
    "FK" => "Falkland Islands (Malvinas)",
    "FO" => "Faroe Islands",
    "FJ" => "Fiji",
    "FI" => "Finland",
    "FR" => "France",
    "GF" => "French Guiana",
    "PF" => "French Polynesia",
    "TF" => "French Southern Territories",
    "GA" => "Gabon",
    "GM" => "Gambia",
    "GE" => "Georgia",
    "DE" => "Germany",
    "GH" => "Ghana",
    "GI" => "Gibraltar",
    "GR" => "Greece",
    "GL" => "Greenland",
    "GD" => "Grenada",
    "GP" => "Guadeloupe",
    "GU" => "Guam",
    "GT" => "Guatemala",
    "GN" => "Guinea",
    "GW" => "Guinea-Bissau",
    "GY" => "Guyana",
    "HT" => "Haiti",
    "HM" => "Heard Island and Mcdonald Islands",
    "VA" => "Holy See (Vatican City State)",
    "HN" => "Honduras",
    "HK" => "Hong Kong",
    "HU" => "Hungary",
    "IS" => "Iceland",
    "IN" => "India",
    "ID" => "Indonesia",
    "IR" => "Iran, Islamic Republic of",
    "IQ" => "Iraq",
    "IE" => "Ireland",
    "IL" => "Israel",
    "IT" => "Italy",
    "JM" => "Jamaica",
    "JP" => "Japan",
    "JO" => "Jordan",
    "KZ" => "Kazakhstan",
    "KE" => "Kenya",
    "KI" => "Kiribati",
    "KP" => "Korea, Democratic People's Republic of",
    "KR" => "Korea, Republic of",
    "KW" => "Kuwait",
    "KG" => "Kyrgyzstan",
    "LA" => "Lao People's Democratic Republic",
    "LV" => "Latvia",
    "LB" => "Lebanon",
    "LS" => "Lesotho",
    "LR" => "Liberia",
    "LY" => "Libyan Arab Jamahiriya",
    "LI" => "Liechtenstein",
    "LT" => "Lithuania",
    "LU" => "Luxembourg",
    "MO" => "Macao",
    "MK" => "Macedonia, the Former Yugoslav Republic of",
    "MG" => "Madagascar",
    "MW" => "Malawi",
    "MY" => "Malaysia",
    "MV" => "Maldives",
    "ML" => "Mali",
    "MT" => "Malta",
    "MH" => "Marshall Islands",
    "MQ" => "Martinique",
    "MR" => "Mauritania",
    "MU" => "Mauritius",
    "YT" => "Mayotte",
    "MX" => "Mexico",
    "FM" => "Micronesia, Federated States of",
    "MD" => "Moldova, Republic of",
    "MC" => "Monaco",
    "MN" => "Mongolia",
    "MS" => "Montserrat",
    "MA" => "Morocco",
    "MZ" => "Mozambique",
    "MM" => "Myanmar",
    "NA" => "Namibia",
    "NR" => "Nauru",
    "NP" => "Nepal",
    "NL" => "Netherlands",
    "AN" => "Netherlands Antilles",
    "NC" => "New Caledonia",
    "NZ" => "New Zealand",
    "NI" => "Nicaragua",
    "NE" => "Niger",
    "NG" => "Nigeria",
    "NU" => "Niue",
    "NF" => "Norfolk Island",
    "MP" => "Northern Mariana Islands",
    "NO" => "Norway",
    "OM" => "Oman",
    "PK" => "Pakistan",
    "PW" => "Palau",
    "PS" => "Palestinian Territory, Occupied",
    "PA" => "Panama",
    "PG" => "Papua New Guinea",
    "PY" => "Paraguay",
    "PE" => "Peru",
    "PH" => "Philippines",
    "PN" => "Pitcairn",
    "PL" => "Poland",
    "PT" => "Portugal",
    "PR" => "Puerto Rico",
    "QA" => "Qatar",
    "RE" => "Reunion",
    "RO" => "Romania",
    "RU" => "Russian Federation",
    "RW" => "Rwanda",
    "SH" => "Saint Helena",
    "KN" => "Saint Kitts and Nevis",
    "LC" => "Saint Lucia",
    "PM" => "Saint Pierre and Miquelon",
    "VC" => "Saint Vincent and the Grenadines",
    "WS" => "Samoa",
    "SM" => "San Marino",
    "ST" => "Sao Tome and Principe",
    "SA" => "Saudi Arabia",
    "SN" => "Senegal",
    "CS" => "Serbia and Montenegro",
    "SC" => "Seychelles",
    "SL" => "Sierra Leone",
    "SG" => "Singapore",
    "SK" => "Slovakia",
    "SI" => "Slovenia",
    "SB" => "Solomon Islands",
    "SO" => "Somalia",
    "ZA" => "South Africa",
    "GS" => "South Georgia and the South Sandwich Islands",
    "ES" => "Spain",
    "LK" => "Sri Lanka",
    "SD" => "Sudan",
    "SR" => "Suriname",
    "SJ" => "Svalbard and Jan Mayen",
    "SZ" => "Swaziland",
    "SE" => "Sweden",
    "CH" => "Switzerland",
    "SY" => "Syrian Arab Republic",
    "TW" => "Taiwan, Province of China",
    "TJ" => "Tajikistan",
    "TZ" => "Tanzania, United Republic of",
    "TH" => "Thailand",
    "TL" => "Timor-Leste",
    "TG" => "Togo",
    "TK" => "Tokelau",
    "TO" => "Tonga",
    "TT" => "Trinidad and Tobago",
    "TN" => "Tunisia",
    "TR" => "Turkey",
    "TM" => "Turkmenistan",
    "TC" => "Turks and Caicos Islands",
    "TV" => "Tuvalu",
    "UG" => "Uganda",
    "UA" => "Ukraine",
    "AE" => "United Arab Emirates",
    "GB" => "United Kingdom",
    "US" => "United States",
    "UM" => "United States Minor Outlying Islands",
    "UY" => "Uruguay",
    "UZ" => "Uzbekistan",
    "VU" => "Vanuatu",
    "VE" => "Venezuela",
    "VN" => "Viet Nam",
    "VG" => "Virgin Islands, British",
    "VI" => "Virgin Islands, U.s.",
    "WF" => "Wallis and Futuna",
    "EH" => "Western Sahara",
    "YE" => "Yemen",
    "ZM" => "Zambia",
    "ZW" => "Zimbabwe"
);


abstract class PrivacySettings {
    const REGISTERED_USERS = 0;
    const PUBLIC_USERS = 1; 
    const PRIVATE_USERS = 2;
}

function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}

function mozilla_init() {
    register_nav_menu('mozilla-theme-menu', __('Mozilla Custom Theme Menu'));

    $user = wp_get_current_user()->data;
    // Not logged in
    if(!isset($user->ID)) {
        if(isset($_GET['redirect_to'])) {
            setcookie("mozilla-redirect", $_GET['redirect_to'], 0, "/");
        }
    }

    // Create Activities
    $labels = Array(
        'name'              =>  __('Activities'),
        'singular_name'     =>  __('Activity')
    );

    $args = Array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-chart-line',
        'rewrite'            =>  Array('slug'    =>  'activities')
    );

    register_post_type('activity', $args);

    // Create Campaigns
    $labels = Array(
        'name'              =>  __('Campaigns'),
        'singular_name'     =>  __('Campaign')
    );

    $args = Array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-admin-site-alt3',
        'rewrite'            =>  Array('slug'    =>  'campaigns')
    );

    register_post_type('campaign', $args);
}

function mozilla_add_menu_attrs($attrs, $item, $args) {
    $attrs['class'] = 'menu-item__link';
    return $attrs;
}

function mozilla_init_admin_scripts() {
    $screen = get_current_screen();

    if(strtolower($screen->id) === 'toplevel_page_bp-groups') {
        wp_enqueue_script('groups', get_stylesheet_directory_uri()."/js/admin.js", array('jquery'));
    }


}

function mozilla_init_scripts() {

    // Vendor scripts
    wp_enqueue_script('dropzonejs', get_stylesheet_directory_uri()."/js/vendor/dropzone.min.js", array('jquery'));
    wp_enqueue_script('autcomplete', get_stylesheet_directory_uri()."/js/vendor/autocomplete.js", array('jquery'));
    wp_enqueue_script('identicon', get_stylesheet_directory_uri()."/js/vendor/identicon.js", array());
    wp_register_script('mapbox', "https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.js");
    wp_enqueue_script('mapbox');
    wp_register_style('mapbox-css', 'https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css');
    wp_enqueue_style('mapbox-css');

    // Custom scripts
    wp_enqueue_script('groups', get_stylesheet_directory_uri()."/js/groups.js", array('jquery'));
    wp_enqueue_script('events', get_stylesheet_directory_uri()."/js/events.js", array('jquery'));
    wp_enqueue_script('cleavejs', get_stylesheet_directory_uri()."/js/vendor/cleave.min.js", array());
    wp_enqueue_script('nav', get_stylesheet_directory_uri()."/js/nav.js", array('jquery'));
    wp_enqueue_script('profile', get_stylesheet_directory_uri()."/js/profile.js", array('jquery'));
    wp_enqueue_script('lightbox', get_stylesheet_directory_uri()."/js/lightbox.js", array('jquery'));
    

}

// If the create group page is called create a group 
function mozilla_create_group() {

    if(is_user_logged_in()) {
        $required = Array(
            'group_name',
            'group_type',
            'group_desc',
            'my_nonce_field'
        );

        $optional = Array(
            'group_address_type',
            'group_address',
            'group_meeting_details',
            'group_discourse',
            'group_facebook',
            'group_telegram',
            'group_github',
            'group_twitter',
            'group_other',
            'group_country',
            'group_city'
        );

        
        // If we're posting data lets create a group
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['step']) && isset($_POST['my_nonce_field']) && wp_verify_nonce($_REQUEST['my_nonce_field'], 'protect_content')) {
                switch($_POST['step']) {
                    case '1':
                        // Gather information
                        $error = false;
                        foreach($required AS $field) {
                            if(isset($_POST[$field])) {
                                if($_POST[$field] === "" || $_POST[$field] === 0) {
                                    $error = true;
                                }
                            }
                            
                            // @todo: Lets revisit this logic 
                            // if(isset($_POST['group_type']) && trim(strtolower($_POST['group_type'])) == 'offline') {
                            //     if(!isset($_POST['group_country']) || $_POST['group_country'] == '0')  {
                            //         $error = true;
                            //     }

                            //     if(!isset($_POST['group_city']) || $_POST['group_city'] === '') {
                            //         $error = true;
                            //     }
                            // }
                        }
  
                        $_SESSION['form'] = $_POST;
                       

                        // Cleanup
                        if($error) {
                            if(isset($_SESSION['uploaded_file']) && file_exists($_SESSION['uploaded_file'])) {
                                $image = getimagesize($_SESSION['uploaded_file']);
                                if(isset($image[2]) && in_array($image[2], Array(IMAGETYPE_JPEG ,IMAGETYPE_PNG))) {
                                    unlink($_SESSION['uploaded_file']);
                                }
                            }

                            $_POST['step'] = 0;                           
                        }
                        
                        break;
                    case 2:

                        if(isset($_POST['agree']) && $_POST['agree']) {
                            $args = Array(
                                'group_id'  =>  0,
                            );
                            
                            $args['name'] = sanitize_text_field($_POST['group_name']);
                            $args['description'] = sanitize_text_field($_POST['group_desc']);
                            $args['status'] = 'private';
                            
                            $group_id = groups_create_group($args);
                            $meta = Array();

                            if($group_id) {
                                // Loop through optional fields and save to meta
                                foreach($optional AS $field) {
                                    if(isset($_POST[$field]) && $_POST[$field] !== "") {
                                        $meta[$field] = trim(sanitize_text_field($_POST[$field]));
                                    }
                                }

                                if(isset($_POST['group_admin_id']) && $_POST['group_admin_id']) {
                                    groups_join_group($group_id, intval($_POST['group_admin_id']));
                                    groups_promote_member(intval($_POST['group_admin_id']), $group_id, 'admin');
                                }

                                // Required information but needs to be stored in meta data because buddypress does not support these fields
                                $meta['group_image_url'] = trim(sanitize_text_field($_POST['image_url']));
                                $meta['group_type'] = trim(sanitize_text_field($_POST['group_type']));
                    

                                if(isset($_POST['tags'])) {
                                    $tags = explode(',', $_POST['tags']);
                                    $meta['group_tags'] = array_filter($tags);
                                }

                                $result = groups_update_groupmeta($group_id, 'meta', $meta);
                    
                                if($result) {
                                    unset($_SESSION['form']);
                                    $_POST = Array();
                                    $_POST['step'] = 3;
                                    $group = groups_get_group(Array('group_id' => $group_id ));
                                    $_POST['group_slug'] = $group->slug;
                                } else {
                                    groups_delete_group($group_id);
                                    $_POST['step'] = 0;
                                }                                
                            }
                        } else {
                            $_POST['step'] = 2;
                        }

                        break;
                        
                }
            }
        } else {
            unset($_SESSION['form']);
        }
    } else {
        wp_redirect("/");
    }
}

function mozilla_upload_image() {

    if(!empty($_FILES) && wp_verify_nonce($_REQUEST['my_nonce_field'], 'protect_content')) {
        $image = getimagesize($_FILES['file']['tmp_name']);

        if(isset($image[2]) && in_array($image[2], Array(IMAGETYPE_JPEG ,IMAGETYPE_PNG))) {
            $uploaded_bits = wp_upload_bits($_FILES['file']['name'], null, file_get_contents($_FILES['file']['tmp_name']));
            
            if (false !== $uploaded_bits['error']) {
                
            } else {
                $uploaded_file     = $uploaded_bits['file'];
                $_SESSION['uploaded_file'] = $uploaded_bits['file'];
                $uploaded_url      = $uploaded_bits['url'];
                $uploaded_filetype = wp_check_filetype(basename($uploaded_bits['file'] ), null);
        
                print $uploaded_url;
            }
        }
    }
	die();
}

function mozilla_validate_group_name() {

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        if(isset($_GET['q'])) {
            $query = $_GET['q'];
            $gid = isset($_GET['gid']) && $_GET['gid'] != 'false' ? intval($_GET['gid']) : false;

            $found = mozilla_search_groups($query, $gid);

            if($found == false) {
                print json_encode(true);
            } else {
                print json_encode(false);
            }
            die();
        }
    }
}

function mozilla_search_groups($name, $gid) {
    $groups = groups_get_groups();
    $group_array = $groups['groups'];

    $found = false;
    foreach($group_array AS $g) {
        if($gid && $gid == $g->id) {
            continue;
        } else {
            $x = trim(strtolower($g->name));
            $y = trim(strtolower($name));
            if(sanitize_text_field($x) ==  sanitize_text_field($y))
                return true;
                    
        }
    }

    return $found;
}

function add_query_vars_filter( $vars ){
  $vars[] = "view";
  $vars[] = "country";
  $vars[] = "tag";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

function mozilla_validate_username() {

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        if(isset($_GET['u']) && strlen($_GET['u']) > 0) {
            $u = sanitize_text_field(trim($_GET['u']));
            $current_user_id = get_current_user_id();

            $query = new WP_User_Query(Array(
                'search'            =>  $u,
                'search_columns'    =>  Array(
                    'user_nicename'
                ),
                'exclude'   => Array($current_user_id)
            ));
   
            print (sizeof($query->get_results()) === 0) ? json_encode(true) : json_encode(false);
        }
    }
    die();
}

function mozilla_validate_email() {

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        if(isset($_GET['u']) && strlen($_GET['u']) > 0) {
            $u = sanitize_text_field(trim($_GET['u']));
            $current_user_id = get_current_user_id();

            $query = new WP_User_Query(Array(
                'search'            =>  $u,
                'search_columns'    =>  Array(
                    'user_email'
                ),
                'exclude'   => Array($current_user_id)
            ));
   
            print (sizeof($query->get_results()) === 0) ? json_encode(true) : json_encode(false);
        }
    }
    die();
}

function mozilla_get_users() {
    $json_users = Array();

    if(isset($_GET['q']) && $_GET['q']) {
        $q = esc_attr(trim($_GET['q']));
        $current_user_id = get_current_user_id();

        $query = new WP_User_Query(Array(
            'search'            =>  "*{$q}*",
            'search_columns'    =>  Array(
                'user_nicename'
            ),
            'exclude'   => Array($current_user_id)
        ));

        print json_encode($query->get_results());

    }
    die();
}

function mozilla_join_group() {
   if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = wp_get_current_user();
        
        if($user->ID) {
            if(isset($_POST['group']) && $_POST['group']) {
                $joined = groups_join_group(intval(trim($_POST['group'])), $user->ID);
                if($joined) {
                    print json_encode(Array('status'   =>  'success', 'msg'  =>  'Joined Group'));
                } else {
                    print json_encode(Array('status'   =>  'error', 'msg'   =>  'Could not join group'));
                }
                die();
            } 
        } else {
            setcookie('mozilla-redirect', $_SERVER['HTTP_REFERER'], 0, "/");
            print json_encode(Array('status'    =>  'error', 'msg'  =>  'Not Logged In'));
            die();
        }
    }

    print json_encode(Array('status'    =>  'error', 'msg'  =>  'Invalid Request'));
    die();
}

function mozilla_leave_group() {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = wp_get_current_user();
        if($user->ID) {
            if(isset($_POST['group']) && $_POST['group']) {
                $group = intval(trim($_POST['group']));
                if(!groups_is_user_admin($user->ID, $group)) {
                    $left = groups_leave_group($group, $user->ID);
                    if($left) {
                        print json_encode(Array('status'   =>  'success', 'msg'  =>  'Left Group'));
                    } else {
                        print json_encode(Array('status'   =>  'error', 'msg'   =>  'Could not leaev group'));
                    }
                } else {
                    print json_encode(Array('status'   =>  'error', 'msg'   =>  'Admin cannot leave a group'));
                }
                die();
            }
        } else {
            print json_encode(Array('status'    =>  'error', 'msg'  =>  'Not Logged In'));
            die();
        }
    }

    print json_encode(Array('status'    =>  'error', 'msg'  =>  'Invalid Request'));
    die();
}

function mozilla_post_user_creation($user_id, $userinfo, $is_new, $id_token, $access_token, $refresh_token ) {
    $meta = get_user_meta($user_id);


    if($is_new || !isset($meta['agree'][0]) || (isset($meta['agree'][0]) && $meta['agree'][0] != 'I Agree')) {
        $user = get_user_by('ID', $user_id);
        wp_redirect("/members/{$user->data->user_nicename}/profile/edit/group/1/");
        die();        
    }

    if(isset($_COOKIE['mozilla-redirect']) && strlen($_COOKIE['mozilla-redirect']) > 0) {
        $redirect = $_COOKIE['mozilla-redirect'];
        unset($_COOKIE['mozilla-redirect']);
        wp_redirect($redirect);
        die();
    }
}


function mozilla_update_member() {  

    // Submited Form
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(is_user_logged_in()) {
            $user = wp_get_current_user()->data;
            $edit = false;

            // Get current meta to compare to
            $meta = get_user_meta($user->ID);

            $required = Array(
                'username',
                'username_visibility',
                'first_name',
                'first_name_visibility',
                'last_name',
                'last_name_visibility',
                'email',
                'email_visibility',
                'agree'
            );

            $additional_fields = Array(
                'image_url',
                'profile_image_url_visibility',
                'pronoun',
                'profile_pronoun_visibility',
                'bio',
                'profile_bio_visibility',
                'phone',
                'profile_phone_visibility',
                'discourse',
                'profile_discourse_visibility',
                'facebook',
                'profile_facebook_visibility',
                'twitter',
                'profile_twitter_visibility',
                'linkedin',
                'profile_linkedin_visibility',
                'github',
                'profile_github_visibility',
                'telegram',
                'profile_telegram_visibility',
                'languages',
                'profile_languages_visibility',
                'tags',
                'profile_tags_visibility',
                'profile_groups_joined_visibility',
                'profile_events_attended_visibility',
                'profile_events_organized_visibility',
                'profile_campaigns_visibility',
                'profile_location_visibility'
            );

            // Add additional required fields after initial setup
            if(isset($meta['agree'][0]) && $meta['agree'][0] == 'I Agree') {
                unset($required[8]);
                $required[] = 'profile_location_visibility';
                $_POST['edit'] = true;
            }

            $error = false;
            foreach($required AS $field) {
                if(isset($_POST[$field])) {
                    if($_POST[$field] === "" || $_POST[$field] === 0) {
                        $error = true;
                    }
                }
            }

            // Validate email and username
            if($error === false) {

                if(!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
                    $error = true;
                    $_POST['email_error_message'] = 'Invalid email address';
                }


                $query = new WP_User_Query(Array(
                    'search'            =>  sanitize_text_field(trim($_POST['email'])),
                    'search_columns'    =>  Array(
                        'user_email'
                    ),
                    'exclude'   => Array($user->ID)
                ));

                if(sizeof($query->get_results()) !== 0) {
                    $error = true;
                    $_POST['email_error_message'] = 'This email is already in use';
                }

                $query = new WP_User_Query(Array(
                    'search'            =>  sanitize_text_field(trim($_POST['username'])),
                    'search_columns'    =>  Array(
                        'user_nicename'
                    ),
                    'exclude'   => Array($user->ID)
                ));

                // Validate email

                if(sizeof($query->get_results()) !== 0) {
                    $_POST['username_error_message'] = 'This username is already in use';
                    $error = true;
                }
            }
           
            // Create the user and save meta data
            if($error === false) {

                $_POST['complete'] = true;

                // Update regular wordpress user data
                $data = Array(
                    'ID'            =>  $user->ID,
                    'user_email'    =>  sanitize_text_field(trim($_POST['email'])),
                );

                // We need to udpate the user
                if($_POST['username'] !== $user->user_nicename) {
                    $data['user_nicename'] = sanitize_text_field(trim($_POST['username']));
                }

                wp_update_user($data);

                // No longe need this key
                unset($required[0]);

                foreach($required AS $field) {
                    $form_data = sanitize_text_field(trim($_POST[$field]));
                    update_user_meta($user->ID, $field, $form_data);
                }


                // Update other fields here
                $addtional_meta = Array();

                foreach($additional_fields AS $field) {
                    if(isset($_POST[$field])) {
                        if(is_array($_POST[$field])) {
                            $additional_meta[$field] = array_map('sanitize_text_field', array_filter($_POST[$field]));
                        } else {
                            $additional_meta[$field] = sanitize_text_field(trim($_POST[$field]));
                        }
                    }
                }    

                update_user_meta($user->ID, 'community-meta-fields', $additional_meta);

            }
        }
    }
}

function mozilla_is_logged_in() {
    $current_user = wp_get_current_user()->data;
    return sizeof((Array)$current_user) > 0 ? true : false; 
}

function mozilla_determine_field_visibility($field, $visibility_field, $community_fields, $is_me, $logged_in) {
    
    if(isset($community_fields[$field]) 
        || $field === 'city' 
        || $field === 'username' 
        || $field === 'country'
        || $field === 'profile_groups_joined'
        || $field === 'profile_events_attended' 
        || $field === 'profile_events_organized'
        || $field === 'profile_campaigns'
        || $field === 'profile_telegram'
        || $field === 'profile_facebook' 
        || $field === 'profile_twitter' 
        || $field === 'profile_discourse'
        || $field === 'profile_github'
        || $field === 'profile_linkedin') {   
        
        if($field === 'city' || $field === 'country') {
            $visibility_field = 'profile_location_visibility';
        }
        if($is_me) {
            $display = true;
        } else {
            if(($logged_in && isset($community_fields[$visibility_field]) && intval($community_fields[$visibility_field]) === PrivacySettings::REGISTERED_USERS) || intval($community_fields[$visibility_field]) === PrivacySettings::PUBLIC_USERS) {

                $display = true;
            } else {
                $display = false;
            }

            if($logged_in && $field === 'first_name') {
                $display = true;
            }
        }
    } else {
        $display = false;
    }

    return $display;
}


function mozilla_save_event($post_id, $post, $update) {
  if ($post->post_type === 'event') {
    $event = new stdClass();
    $event->image_url = esc_url_raw($_POST['image_url']);
    $event->location_type = sanitize_text_field($_POST['location-type']);
    $event->external_url = esc_url_raw($_POST['event_external_link']);
    $event->campaign = sanitize_text_field($_POST['event_campaign']);
    update_post_meta($post_id, 'event-meta', $event);
  }
}

function mozilla_match_categories() {
  $cat_terms = get_terms(EM_TAXONOMY_CATEGORY, array('hide_empty'=>false));
  $wp_terms = get_terms('post_tag', array('hide_empty'=>false));
  $cat_terms_name = array_map(function($n) {
    return $n->name;
  }, $cat_terms);
  $wp_terms = array_map(function($n) {
    return $n->name;
  }, $wp_terms);
  foreach ($wp_terms as $wp_term) {
    if (!in_array($wp_term, $cat_terms_name)) {
      wp_insert_term($wp_term, EM_TAXONOMY_CATEGORY);
    }
  }
  foreach ($cat_terms as $cat_term) {
    if (!in_array($cat_term->name, $wp_terms)) {
      wp_delete_term($cat_term->term_id, EM_TAXONOMY_CATEGORY);
    }
  }
}

function mozilla_edit_group() {

    $group_id = bp_get_current_group_id();
    $user = wp_get_current_user();

    if($group_id && $user) {

        $is_admin = groups_is_user_admin($user->ID, $group_id);

        if($is_admin !== false) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $required = Array(
                    'group_name',
                    'group_type',
                    'group_desc',
                    'group_address',
                    'my_nonce_field'
                );
                foreach($required AS $field) {
                    if(isset($_POST[$field])) {
                        if($_POST[$field] === "" || $_POST[$field] === 0) {
                            $error = true;
                        }
                    }
                }
      
                if(isset($_POST['group_name'])) {
                    $error = mozilla_search_groups($_POST['group_name'], $group_id);
                    if($error) {
                        $_POST['group_name_error'] = 'This group name is already taken';
                    }
                }

                // Lets update
                if($error === false) {
                    $args = Array(
                        'group_id'      =>  $group_id,
                        'name'          =>  sanitize_text_field($_POST['group_name']),
                        'description'   =>  sanitize_text_field($_POST['group_desc']),
                    );

                    // Update the group
                    groups_create_group($args);

                    // Update group meta data
                    $meta = Array();
                    $meta['group_image_url'] = isset($_POST['image_url']) ? sanitize_text_field($_POST['image_url']) : '';
                    $meta['group_address_type'] = isset($_POST['group_address_type']) ? sanitize_text_field($_POST['group_address_type']) : 'Address';
                    $meta['group_address'] = isset($_POST['group_address']) ? sanitize_text_field($_POST['group_address']) : '';
                    $meta['group_meeting_details'] = isset($_POST['group_meeting_details']) ? sanitize_text_field($_POST['group_meeting_details']) : '';
                    $meta['group_city'] = isset($_POST['group_city']) ? sanitize_text_field($_POST['group_city']) : '';
                    $meta['group_country'] = isset($_POST['group_country']) ? sanitize_text_field($_POST['group_country']): '';
                    $meta['group_type'] = isset($_POST['group_type']) ? sanitize_text_field($_POST['group_type']) : 'Online';

                    if(isset($_POST['tags'])) {
                        $tags = array_filter(explode(',', $_POST['tags']));
                        $meta['group_tags'] = $tags;
                    }

                    $meta['group_discourse'] = isset($_POST['group_discourse']) ? sanitize_text_field($_POST['group_discourse']) : '';
                    $meta['group_facebook'] = isset($_POST['group_facebook']) ? sanitize_text_field($_POST['group_facebook']) : '';
                    $meta['group_telegram'] = isset($_POST['group_telegram']) ? sanitize_text_field($_POST['group_telegram']) : '';
                    $meta['group_github'] = isset($_POST['group_github']) ? sanitize_text_field($_POST['group_github']) : '';
                    $meta['group_twitter'] = isset($_POST['group_twitter']) ? sanitize_text_field($_POST['group_twitter']) : '';
                    $meta['group_other'] = isset($_POST['group_other']) ? sanitize_text_field($_POST['group_other']) : '';

                    groups_update_groupmeta($group_id, 'meta', $meta);
                }
        
            }
        }
    }
}
    
function mozilla_menu_class($classes, $item, $args) {

    $path_items = array_filter(explode('/', $_SERVER['REQUEST_URI']));
    $menu_url = strtolower(str_replace('/', '', $item->url));

    
    if(sizeof($path_items) > 0) {
        
        if(strtolower($path_items[1]) === $menu_url) {
            $item->current = true;
            $classes[] = 'menu-item--active';
        }
    }

    return $classes;
}

function mozilla_theme_settings() {
    $theme_dir = get_template_directory();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['admin_nonce_field']) && wp_verify_nonce($_REQUEST['admin_nonce_field'], 'protect_content')) {
            if(isset($_POST['google_analytics_id'])) {
                update_option('google_analytics_id', sanitize_text_field($_POST['google_analytics_id']));
            }
        }
    }

    $options = wp_load_alloptions();
    
    include "{$theme_dir}/templates/settings.php";

}

function mozilla_add_menu_item() {
  add_menu_page('Mozilla Settings', 'Mozilla Settings', 'manage_options', 'theme-panel', 'mozilla_theme_settings', null, 99);
}


function mozilla_events_redirect($location) {
  if (strpos($location, 'event_id') !== false) {
    $location = get_site_url(null, 'events/');
    return $location;
  }
  return $location;
}

add_filter('wp_redirect', 'mozilla_events_redirect');

function mozilla_is_site_admin(){
  return in_array('administrator',  wp_get_current_user()->roles);
}

function mozilla_delete_events($id, $post) {
  $post_id = $post->post_id;
  wp_delete_post($post_id);
  return $post;
}

add_filter('em_event_delete', 'mozilla_delete_events', 10, 2);

function mozilla_verify_deleted_events() {
  $args = array(
    'post_type' => 'event',
    'posts_per_page' => 1000,
  );
  $allPosts = new WP_Query($args);
  foreach($allPosts->posts as $post):
    $event = EM_Events::get(array('post_id' => $post->ID));
    if (count($event) === 0):
      wp_delete_post($post->ID, true);
    endif;
  endforeach;
  wp_reset_query();
}

add_action('init', 'mozilla_verify_deleted_events', 10)

?>