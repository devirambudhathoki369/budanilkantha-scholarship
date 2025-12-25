<?php

use App\Models\Level;
use App\Models\Members;
use App\Models\Specialization;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

function public_url($url)
{
  $base = url('/');
  if (strpos(php_sapi_name(), 'cli') !== false)
    return $base . '/' . $url;

  return $base . '/' . $url;

  //uncomment below line while using local and accessing from ip or server name!
  //   return $base . '/public/' . $url;
}

function storage_folder()
{
  // uncomment below line if linked folder in public is named as uploads
  // return 'uploads';

  return 'storage';
}

function storage_url($url)
{
  // uncomment below line if linked folder in public is named as uploads
  return public_url(storage_folder()) . '/' . $url;

  //   return public_url('storage/') . $url;
}

function make_route($route, $id = null, $other_fields = [])
{
  if ($id && count($other_fields)) {
    return route($route, array_merge([$id, hashtag($id)], $other_fields));
  } else if ($id) {
    return route($route, [$id, hash_value($id)]);
  }
  return route($route);
}

function home()
{
  return make_route('home');
}

function integrityHash($filePath)
{
  $fileContent = file_get_contents($filePath);
  $hash = hash('sha256', $fileContent);
  return 'sha256-' . base64_encode(hex2bin($hash));
}

function allErrors($errors)
{
  if ($errors->any())
    echo implode('', $errors->all('<div>:message</div>'));
}

function slug($text, $seperate = '-')
{
  $randNum = RandomNum(4);
  if (preg_match("/^[a-zA-Z]/", $text))
    $text = strtolower($text);

  $text = preg_replace('/\s+/u', '-', trim($text));
  $text = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $text);
  $text = preg_replace("/[\/_|+ -]+/", $seperate, $text);

  return $text . '-' . $randNum;
}

function user_type($type)
{
  switch ($type) {
    case '1':
      return "Super Admin";
    case '2':
      return "Office User";
    case '3':
      return "Member";
    default:
      return "";
  }
}

function debit_credit($type)
{
  switch ($type) {
    case '1':
      return "डेबिट";
    case '2':
      return "क्रेडिट";
    default:
      return "";
  }
}

function notice_type($type)
{
  switch ($type) {
    case '1':
      return "For All Inside Notice Section";
    case '2':
      return "Only Government Office Notice";
    case '3':
      return "Only Hospital Notice";
    case '4':
      return "Login Page Notice";
    default:
      return "";
  }
}

function is_active_fy($type)
{
  switch ($type) {
    case '0':
      return "Yes";
    case '1':
      return "No";
    default:
      return "";
  }
}

function office_type($type)
{
  switch ($type) {
    case '0':
      return "केन्द्रीय";
    case '1':
      return "कार्यसन्चालन";
    default:
      return "";
  }
}

function review_status($type)
{
  switch ($type) {
    case '1':
      return "Correct";
    case '2':
      return "Incorrect";
    default:
      return "N/A";
  }
}

function review_status_gui($type)
{
  switch ($type) {
    case '1':
      return "<span class='text-success'><i class='ri-check-double-line'></i></span>";
    case '2':
      return "<span class='text-danger'><i class='ri-close-fill'></i></span>";
    default:
      return "";
  }
}

function application_type($type)
{
  switch ($type) {
    case '1':
      return "Letter of Intent";
    case '2':
      return "Renewal";
    case '3':
      return "Upgrade";
    case '4':
      return "Service Expansion";
    default:
      return "";
  }
}

function process($type)
{
  switch ($type) {
    case '1':
      return "Under Review";
    case '2':
      return "Approved";
    case '3':
      return "Unapproved";
    case '4':
      return "Returned to re-submit!";
    default:
      return "Not submitted to admin!";
  }
}

function process_status($type)
{
  switch ($type) {
    case '1':
      $bgColor = "bg-info";
      break;
    case '2':
      $bgColor = "bg-success";
      break;
    case '3':
      $bgColor = "bg-danger";
      break;
    default:
      $bgColor = "bg-warning";
      break;
  }
  $htmlTag = '';

  if ($bgColor) {
    $htmlTag = "<span class='p-1 display-block text-center {$bgColor}'>" . process($type) . "</span>";
  }

  echo $htmlTag;
}

function process_full_status($type, $sending_date = null)
{
  switch ($type) {
    case '1':
      $bgColor = "bg-info";
      break;
    case '2':
      $bgColor = "bg-success";
      break;
    case '3':
      $bgColor = "bg-danger";
      break;
    case '4':
      $bgColor = "bg-warning";
      break;
    default:
      $bgColor = "";
      break;
  }
  $htmlTag = '';


  if ($sending_date) {
    $sending_date = "(Submitted date: $sending_date)";
  }

  if ($bgColor) {
    $htmlTag = "<span class='p-1 display-block text-center {$bgColor}'>Your request is " . process($type) . " $sending_date</span>";
  }

  echo $htmlTag;
}

function user_rights($right)
{
  switch ($right) {
    case '1':
      echo "<i class='text-success fa fa-check'></i>";
      break;
    default:
      echo "<i class='text-danger fa fa-times'></i>";
  }
}

function sanitize($string)
{
  $pdata = entity_convert($string);
  return UTF8toEng($pdata);
}

function sanitizeSearch($data)
{
  $pdata = entity_convert($data);
  return $pdata;
}

function entity_convert($string)
{
  // $string = htmlentities($string, ENT_QUOTES, "UTF-8");
  // $string = addslashes($string);

  return $string;
}

function hashtag($id)
{
  return substr(sha1($id), 3, 21);
}


function hashtag_field($id)
{
  return "<input type='hidden' name='hashtag' value='" . hashtag($id) . "'>";
}

function checkHash($id, $hash)
{
  if (hash_value($id) === $hash)
    return true;

  return false;
}


function decode($data)
{
  return html_entity_decode($data);
}

function UTF8toEng($string)
{
  $patterns[0] = '0';
  $patterns[1] = '1';
  $patterns[2] = '2';
  $patterns[3] = '3';
  $patterns[4] = '4';
  $patterns[5] = '5';
  $patterns[6] = '6';
  $patterns[7] = '7';
  $patterns[8] = '8';
  $patterns[9] = '9';
  $replacements[0] = '/०/';
  $replacements[1] = '/१/';
  $replacements[2] = '/२/';
  $replacements[3] = '/३/';
  $replacements[4] = '/४/';
  $replacements[5] = '/५/';
  $replacements[6] = '/६/';
  $replacements[7] = '/७/';
  $replacements[8] = '/८/';
  $replacements[9] = '/९/';
  return preg_replace($replacements, $patterns, $string);
}

function EngToUTF8($string)
{
  $num = array(
    "-" => "-",
    "0" => "०",
    "1" => "१",
    "2" => "२",
    "3" => "३",
    "4" => "४",
    "5" => "५",
    "6" => "६",
    "7" => "७",
    "8" => "८",
    "9" => "९"
  );
  return strtr($string, $num); //corrected
}

function RandomVal($val = 8)
{
  $characters = '0123456789abcdefghijk14725836907456983210lmnopqrstuvwxyz9876543210zyxwvutsrqponml3654789210kjihgfedcba';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $val; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function RandomNum($val = 8)
{
  $characters = '0123456789987654321014702583699512365478975623148967';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $val; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function addModalButton($buttonName, $modalID = 'showModal')
{
  if (auth()->user()->add_data) {
    echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#" . $modalID . "'>$buttonName</button>";
  }
  return '';
}

function addButton($buttonName, $modalID = 'showAddForm')
{
  if (auth()->user()->add_data) {
    echo "<button type='button' id='" . $modalID . "' class='btn btn-primary btn-sm mr-2'><i class='fa fa-plus'></i> $buttonName</button>";
  }

  return '';
}

function addURL($path, $title)
{
  if (auth()->user()->add_data) {
    return "<a class='btn btn-success btn-xs waves-effect waves-light pull-right' title = '$title' href='" . $path . "'><i class='fa fa-plus'></i> $title</a>";
  }
  return '';
}

function goBack($path, $id = null)
{
  echo "<a class='btn btn-xs btn-secondary pull-right no-print' href='" . make_route($path, $id) . "'><i class='fa fa-arrow-left'></i>  Go Back</a>";
}


function editURL($route, $id)
{
  if (auth()->user()->edit_data) {
    echo "<a class='btn btn-success btn-xs waves-effect waves-light' title='Edit Data' href='" . make_route($route, $id) . "'><i class='fa fa-pencil'></i></a>";
  }
  return '';
}

function editWithSlug($route, $id, $slug)
{
  if (auth()->user()->edit_data) {
    echo "<a class='btn btn-success btn-xs waves-effect waves-light' href='" . make_route($route, $id, $slug) . "'><i class='fa fa-edit'></i></a>";
  }

  return '';
}

function editLinkButton($route, $id)
{
  if (auth()->user()->edit_data)
    echo "<a href='" . route($route, $id) . "' id='editDataForm' title='Edit Data' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i></a>";
}

function deleteLinkButton($route, $delete_id, $page_id = null)
{
  // if (auth()->user()->delete_data) {
  $deleteButton = "<form method='POST' action='" . make_route($route, $delete_id) . "'>";

  $deleteButton .= csrf_field();
  $deleteButton .= method_field('DELETE');
  $deleteButton .= "<input type='hidden' value='" . $delete_id . "' name='id'>";
  $deleteButton .= "<input type='hidden' value='" . hashtag($delete_id) . "' name='hashtag'>";

  $deleteButton .= "<button type='submit' onclick='return delConfirm();' class='dropdown-item remove-item-btn'><i class='ri-delete-bin-fill align-bottom me-2 text-muted'></i> Delete</button>";
  $deleteButton .= "</form>";

  echo $deleteButton;
  // }

  return '';
}

function deleteWithSlug($route, $id, $slug)
{
  if (auth()->user()->delete_data) {
    $deleteButton = "<form method='POST' action='" . make_route($route, $slug) . "'>";

    $deleteButton .= csrf_field();
    $deleteButton .= method_field('DELETE');
    $deleteButton .= "<input type='hidden' value='" . $id . "' name='id'>";
    $deleteButton .= "<input type='hidden' value='" . hashtag($id) . "' name='hashtag'>";

    $deleteButton .= "<button type='submit' onclick='return delConfirm();' class='btn btn-xs btn-danger' title='delete'><i class='fa fa-trash'></i></button>";
    $deleteButton .= "</form>";

    echo $deleteButton;
  }

  return '';
}

function deleteLinkButtonRoute($route, $id)
{
  if (auth()->user()->delete_data) {
    $deleteButton = "<form method='POST' action='$route'>";

    $deleteButton .= csrf_field();
    $deleteButton .= method_field('DELETE');
    $deleteButton .= "<input type='hidden' value='" . $id . "' name='id'>";
    $deleteButton .= "<input type='hidden' value='" . hashtag($id) . "' name='hashtag'>";

    $deleteButton .= "<button type='submit' onclick='return delConfirm();' class='btn btn-xs btn-danger' title='delete'><i class='fa fa-trash'></i></button>";
    $deleteButton .= "</form>";

    echo $deleteButton;
  }
}

function active($active)
{
  if ($active)
    echo '<span class="badge badge-soft-info">Yes</span>';
}


function status($status, $route, $id)
{
  $btnColor = $status == '1' ? 'primary' : 'warning';
  $dispMsg = $status == '1' ? 'Deactivate' : 'Activate';

  if (auth()->user()->edit_data) {
    $statusButton = "<form method='POST' action='" . route($route) . "'>";

    $statusButton .= csrf_field();
    $statusButton .= method_field('PATCH');
    $statusButton .= "<input type='hidden' value='" . $id . "' name='id'>";
    $statusButton .= "<input type='hidden' value='" . hashtag($id) . "' name='hashtag'>";

    $statusButton .= "<button type='submit' onclick='return statusConfirm();' class='btn btn-xs btn-$btnColor' title='$dispMsg'>$dispMsg</button>";
    $statusButton .= "</form>";

    echo $statusButton;
  }
}

function noData($colspan)
{
  echo "<tr><td colspan='$colspan'>No records avialable.</td></tr>";
}

function hash_value($value)
{
  return hashtag($value);
}

function gender($type)
{
  if ($type == '1') {
    return "Male";
  } elseif ($type == '2') {
    return "Female";
  } else {
    return "Other";
  }
}

function genderNep($type)
{
  if ($type == '1') {
    return "पुरुष";
  } elseif ($type == '2') {
    return "महिला";
  } else {
    return "कृषक तथा अन्यका लागि";
  }
}

function service_type($type)
{
  if ($type == '1') {
    return "Diagnostic Service";
  } elseif ($type == '2') {
    return "Repulsive Service";
  } else {
    return "Remedial Service";
  }
}


function slug_route($route, $slug = null)
{
  if ($slug) {
    return route($route, [$slug]);
  }
  return route($route);
}

function display_count_words($content, $limit)
{
  $blog_description = $content;

  $str_replace_div_to_p = str_replace('<div', '<p', $blog_description);
  $str_replace_div_to_p = str_replace('</div>', '</p>', $str_replace_div_to_p);

  $explodePtag = explode('</p>', $str_replace_div_to_p);

  $firstParagraph = $explodePtag[0];

  $strLen = strlen($firstParagraph);
  if ($strLen > 500) {
    $words = word_count($firstParagraph, $limit);
  } else {
    $words = $firstParagraph;
  }

  return $words . '...</p>';
}

function str_limit($content, $limit = 500, $end = '...')
{
  return Str::limit($content, $limit, $end);
}

function word_count($sentence, $num = 500)
{
  $sentence = substr($sentence, 0, $num);
  return $sentence;
}

function sanitizeDatas($request)
{
  $validatedItems = [];
  foreach ($request->validated() as $key => $data) {
    if (!$request->hasFile($key)) {
      $validatedItems[$key] = sanitize($data);
    }
  }

  return $validatedItems;
}

function print_button()
{
  echo '<a href="#" onclick="window.print()" class="btn btn-success no-print"><i class="fa fa-print align-middle me-1"></i> Print </a>';
}

function ledger_type($type)
{
  if ($type == '1') {
    return "मूल कोष बैंक खाता";
  } elseif ($type == '2') {
    return "जिल्ला विपद व्यवस्थापन कोष";
  } elseif ($type == '3') {
    return "आम्दानी/विविध";
  } elseif ($type == '4') {
    return "खर्च";
  }
}

function fy_month($data)
{
  if ($data == '1') {
    return "10";
  } elseif ($data == '2') {
    return "11";
  } elseif ($data == '3') {
    return "12";
  } elseif ($data == '4') {
    return "1";
  } elseif ($data == '5') {
    return "2";
  } elseif ($data == '6') {
    return "3";
  } elseif ($data == '7') {
    return "4";
  } elseif ($data == '8') {
    return "5";
  } elseif ($data == '9') {
    return "6";
  } elseif ($data == '10') {
    return "7";
  } elseif ($data == '11') {
    return "8";
  } elseif ($data == '12') {
    return "9";
  }
}

function getSpecializationFromId($id)
{
  $spez = Specialization::findOrFail($id);

  return $spez->specialization;
}

function getLevelFromId($id)
{
  $lev = Level::findOrFail($id);

  return $lev->level;
}

function memberfromuser($id)
{
  $member = Members::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();
  if ($member) {
    return $member->id;
  } else {
    return '1';
  }
}

function count_user_member()
{
  $membercount = Members::where('user_id', auth()->user()->id)->count();
  return $membercount;
}


function payment_by_level($data)
{
  if ($data == '1') {
    $amount = "5000.00";
  }
  if ($data == '2') {
    $amount = "3000.00";
  }
  if ($data == '3') {
    $amount = "2000.00";
  }
  if ($data == '4') {
    $amount = "1500.00";
  }
  if ($data == '5') {
    $amount = "1000.00";
  }

  return $amount;
}

function payment_status($data)
{
  if ($data == 0) {
    $status = "भुक्तानी हुन बाँकि";
  } else {
    $status = "भुक्तानी भएको";
  }

  return $status;
}

function send_sparrow_sms($mobile, $message)
{
  $mobile = app()->environment('production') ? $mobile : 9861585362;

  if (config('basic.sparrow_sms.send') && !empty($mobile) && strlen($mobile) == 10) {

    $url = config('basic.sparrow_sms.api_endpoint');

    $args = http_build_query(array(
      'token' => config('basic.sparrow_sms.api_token'),
      'from' => config('basic.sparrow_sms.sms_id'),
      'to'    => $mobile,
      'text'  => $message
    ));


    # Make the call using API.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Response
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $response;
  }
}

function levelInNepali($data)
{
  if ($data == '1') {
    $amount = "क";
  }
  if ($data == '2') {
    $amount = "ख";
  }
  if ($data == '3') {
    $amount = "ग";
  }
  if ($data == '4') {
    $amount = "घ";
  }
  if ($data == '5') {
    $amount = "ग्रा.प.स्वा.का.";
  }

  return $amount;
}

function province($data)
{
  if ($data == '1') {
    $amount = "कोशी प्रदेश";
  }
  if ($data == '2') {
    $amount = "मधेश प्रदेश";
  }
  if ($data == '3') {
    $amount = "बागमती प्रदेश";
  }
  if ($data == '4') {
    $amount = "गण्डकी प्रदेश";
  }
  if ($data == '5') {
    $amount = "लुम्बिनी प्रदेश";
  }
  if ($data == '6') {
    $amount = "कर्णाली प्रदेश";
  }
  if ($data == '7') {
    $amount = "सुदुरपश्चिम प्रदेश";
  }
  if ($data == '0') {
    $amount = "-";
  }
  if (is_null($data)) {
    $amount = "-";
  }

  return $amount;
}

function app_status($data)
{
  if ($data == '0') {
    $amount = "आवेदन पेश नगरिएको";
  }
  if ($data == '1') {
    $amount = "आवेदन पेश गरिएको";
  }
  if ($data == '2') {
    $amount = "आवेदन स्विकृत भएको";
  }
  if ($data == '3') {
    $amount = "आवेदन अस्विकृत भएको";
  }
  if ($data == '4') {
    $amount = "आवेदन नविकरणको लागि पेश गरिएको";
  }
  if ($data == '5') {
    $amount = "आवेदन रद्द गरिएको";
  }
  if ($data == '6') {
    $amount = "आवेदन फिर्ता पठाइएको";
  }

  return $amount;
}
/*
 * @param Model $model - The model instance
 * @return string - SHA256 hash
 */
function generate_hash($model)
{
    return hash('sha256', $model->id . $model->created_at);
}

/**
 * Verify a hash for a model ID and creation timestamp
 *
 * @param Model $model - The model instance
 * @param string $hash - The hash to verify
 * @return bool - True if hash is valid, false otherwise
 */
function verify_hash($model, $hash)
{
    $expectedHash = hash('sha256', $model->id . $model->created_at);
    return hash_equals($expectedHash, $hash);
}


if (!function_exists('eng_to_nep_date')) {
    function eng_to_nep_date($engDate) {
        if (!$engDate) return null;

        $date = \DB::table('dates')
            ->where('engdate', $engDate)
            ->first();

        return $date ? $date->nepdate : $engDate;
    }
}

if (!function_exists('nep_to_eng_date')) {
    function nep_to_eng_date($nepDate) {
        if (!$nepDate) return null;

        $date = \DB::table('dates')
            ->where('nepdate', $nepDate)
            ->first();

        return $date ? $date->engdate : $nepDate;
    }
}
