<?php
/**
 * Accounts Controller
 */
class AccountsController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        $AuthUser = $this->getVariable("AuthUser");
        $EmailSettings = \Controller::model("GeneralData", "email-settings");

        // Auth
        if (!$AuthUser){
            header("Location: ".APPURL."/login");
            exit;
        } else if (
            !$AuthUser->isAdmin() && 
            !$AuthUser->isEmailVerified() &&
            $EmailSettings->get("data.email_verification")) 
        {
            header("Location: ".APPURL."/profile?a=true");
            exit;
        } else if ($AuthUser->isExpired()) {
            header("Location: ".APPURL."/expired");
            exit;
        }

        // Get accounts
        $Accounts = Controller::model("Accounts");
            $Accounts->setPageSize(8)
                     ->setPage(Input::get("page"))
                     ->where("user_id", "=", $AuthUser->get("id"))
                     ->orderBy("id","DESC")
                     ->fetchData();

        $this->setVariable("Accounts", $Accounts);
        
        if (Input::post("action") == "remove") {
            $this->remove();
        }

        $this->view("accounts");
    }



    /**
     * Remove Account
     * @return void
     */
    private function remove()
    {   
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");

        if (!Input::post("id")) {
            $this->resp->msg = __("ID is requred!");
            $this->jsonecho();
        }

        $Account = Controller::model("Account", Input::post("id"));

        if (!$Account->isAvailable() ||
            $Account->get("user_id") != $AuthUser->get("id")) 
        {
            $this->resp->msg = __("Invalid ID");
            $this->jsonecho();
        }

        // Delete instagram session data
        delete(APPPATH . "/sessions/" 
                       . $AuthUser->get("id") 
                       . "/" 
                       . $Account->get("username"));

        $Account->delete();
        
        $this->resp->result = 1;
        $this->jsonecho();
    }
	/**
 * Reconnect Instagram Account
 * @return void
 */
public function reconnect($self_info = true, $update_avatar = true)
{
    ini_set('default_socket_timeout', 300);
    $this->resp->result = 0;
    $AuthUser = $this->getVariable("AuthUser");
    if (!Input::post("id")) {
        $this->resp->title = __("Error");
        $this->resp->msg = __("ID is requred!");
        $this->jsonecho();
    }
    $Account = Controller::model("Account", Input::post("id"));
    // Check Account ID and Account Status
    if (!$Account->isAvailable() ||
        $Account->get("user_id") != $AuthUser->get("id"))
    {
        $this->resp->title = __("Error");
        $this->resp->msg = __("Invalid ID");
        $this->jsonecho();
    }
    // Encrypt the password
    // try {
    //    $passhash = Defuse\Crypto\Crypto::encrypt($Account->get("password"),
    //                Defuse\Crypto\Key::loadFromAsciiSafeString(CRYPTO_KEY));
    //    $this->resp->msg = $passhash;
    //    $this->jsonecho();
    // } catch (\Exception $e) {
    //    $this->resp->msg = $passhash;
    //    $this->jsonecho();
    // }
    // // Force delete Instagram-cookie file on re-connect
    // $cookie_filename = APPPATH . "/sessions/" . $Account->get("user_id") . "/" . $Account->get("username") . "/" . $Account->get("username") . "-cookies.dat";
    // if (file_exists($cookie_filename)) {
    //     @unlink($cookie_filename);
    //     $this->resp->cookies_deleted = true;
    // } else {
    //     $this->resp->cookies_deleted = false;
    // }
    // Set login_required to 0 before logining to Instagram
    // login() function will not work if login_required = 1
    $Account->set("login_required", 0)
        ->save();
    // Get self account info 7 times and skip this process, if this 7 retries unsuccessful
    // Mobile proxy connection break adaptation
    $reconnect_get = 0;
    $reconnect_get_count = 0;
    $reconnect_get_status = 0;
    do {
        $reconnect_get_count += 1;
        if ($reconnect_get_count == 7) {
            $reconnect_get = 1;
            $reconnect_get_status = 0;
        }
        // Try login to Instagram
        try {
            $login_resp = \InstagramController::login($Account);
            $reconnect_get = 1;
            $reconnect_get_status = 1;
        } catch (\InstagramAPI\Exception\NetworkException $e) {
            // Couldn't connect to Instagram account because of network or connection error
            // We will try 10 times otherwise we will show error user message
            sleep(7);
        } catch (\InstagramAPI\Exception\EmptyResponseException $e) {
            // Instagram send us empty response
            // We will try 10 times otherwise we will show error user message
            sleep(7);
        } catch (\Exception $e) {
            $separated = $e->getMessage();
            $text = explode(" | ", $separated, 2);
            $this->resp->title = isset($text[0]) ? $text[0] : __("Oops...");
            $this->resp->msg = isset($text[1]) ? $text[1] : $e->getMessage();
            if ($text[0] == __("Challenge Required") ||
                $text[0] == __("Login Required") ||
                $text[0] == __("Invalid Username") ||
                $text[0] == __("2FA Required") ||
                $text[0] == __("Incorrect Password")) {
                // Redirect user to account settings
                $account_id = Input::post("id");
                if (isset($account_id)) {
                    $this->resp->redirect = APPURL."/accounts/".$account_id;
                } else {
                    $this->resp->redirect = APPURL."/accounts/";
                }
            }
            $this->jsonecho();
        }
    } while (!$reconnect_get);
    if (!$reconnect_get_status) {
        $this->resp->title = __("Couldn't connect to Instagram");
        $this->resp->msg= __("Account not re-connected. Please try again later or contact to Support.");
        $this->jsonecho();
    }
    if ($self_info) {
        // Get and save self account info
        $this->resp->data = $this->selfinfo($login_resp);
    }
    if ($update_avatar) {
        // Update account avatar
        $this->resp->avatar_url = $this->updateavatar($login_resp);
    }
    $this->resp->result = 1;
    $this->jsonecho();
}
/**
 * Get self account info and save this data to database
 * @return void
 */
public function selfinfo($Instagram)
{
    $AuthUser = $this->getVariable("AuthUser");
    if (!Input::post("id")) {
        $this->resp->title = __("Error");
        $this->resp->msg = __("ID is requred!");
        $this->jsonecho();
    }
    $Account = Controller::model("Account", Input::post("id"));
    // Check Account ID and Account Status
    if (!$Account->isAvailable() ||
        $Account->get("user_id") != $AuthUser->get("id"))
    {
        $this->resp->title = __("Error");
        $this->resp->msg = __("Invalid ID");
        $this->jsonecho();
    }
    // Get self account info 7 times and skip this process, if this 7 retries unsuccessful
    // Mobile proxy connection break adaptation
    $selfinfo_get = 0;
    $selfinfo_get_count = 0;
    $selfinfo_get_status = 0;
    do {
        $selfinfo_get_count += 1;
        if ($selfinfo_get_count == 7) {
            $selfinfo_get = 1;
            $selfinfo_get_status = 0;
        }
        try {
            $resp = $Instagram->people->getSelfInfo();
            $selfinfo_get = 1;
            $selfinfo_get_status = 1;
        } catch (\InstagramAPI\Exception\NetworkException $e) {
            // Couldn't connect to Instagram account because of network or connection error
            // Do nothing, just try again
            sleep(7);
        } catch (\InstagramAPI\Exception\EmptyResponseException $e) {
            // Instagram send us empty response
            // Do nothing, just try again
            sleep(7);
        } catch (\Exception $e) {
            if ($e->hasResponse()) {
                $msg = $e->getResponse()->getMessage();
            } else {
                $msg = explode(":", $e->getMessage(), 2);
                $msg = end($msg);
            }
            $this->resp->msg = $msg;
            $this->resp->title = __("Oops...");
            $this->jsonecho();
        }
    } while (!$selfinfo_get);
    if (!$selfinfo_get_status) {
        $this->resp->title = __("Couldn't connect to Instagram");
        $this->resp->msg= __("Account self info not updated. Please try again later or contact to Support.");
        $this->jsonecho();
    }
    // Save current account basic numbers
    $u_data = $resp->getUser();
    $account_data = "data.".$Account->get("username");
    // Check is prev account type is equal to current, don't
    $pev_account_type = $AuthUser->get($account_data . ".pev.account_type");
    $account_type = $u_data->getAccountType();
    if ($pev_account_type == $account_type) {
        $AuthUser->set($account_data . ".prev", "")
            ->save();
    }
    // Check is username should be updated
    if ($u_data->getUsername()) {
        if ($Account->get("username") !==  $u_data->getUsername()) {
            $Account->set("username", $u_data->getUsername())
                ->save();
        }
    }
    // Check is Insights Basic data available for today
    if ($AuthUser->get("settings.insights_basic")) {
        if ($Account->isAvailable() && $Account->get("user_id") == $AuthUser->get("id")) {
            $now = new \Moment\Moment("now", $AuthUser->get("preferences.timezone"));
            $now = $now->format("Y-m-d");
            $InsightBasic = new InsightBasicModel([
                "user_id" => $Account->get("user_id"),
                "instagram_id" => $Account->get("instagram_id"),
                "date" => $now
            ]);
            if ($InsightBasic->isAvailable()) {
                // Update data
                $InsightBasic->set("data.follower_count", $u_data->getFollowerCount())
                    ->save();
                $this->resp->insights_basic_now  = $now;
                $this->resp->insights_basic_new = false;
            } else {
                // Create new database note
                $InsightNew = new InsightBasicModel;
                $InsightNew->set("user_id", $Account->get("user_id"))
                    ->set("instagram_id", $Account->get("instagram_id"))
                    ->set("data.follower_count", $u_data->getFollowerCount())
                    ->set("date", $now)
                    ->save();
                $this->resp->insights_basic_now  = $now;
                $this->resp->insights_basic_new_note = true;
            }
            $Settings = \Controller::model("GeneralData", "settings");
            $interval = $Settings->get("data.insight_basic_interval") ? $Settings->get("data.insight_basic_interval") : 12;
            // Update last check time
            $Account->set("insights_last_check", date("Y-m-d H:i:s", time() + $interval * 3600))
                ->save();
        }
        $AuthUser->set($account_data . ".media_count", $u_data->getMediaCount())
            ->set($account_data . ".following_count", $u_data->getFollowingCount())
            ->set($account_data . ".follower_count", $u_data->getFollowerCount())
            ->set($account_data . ".full_name", $u_data->getFullName())
            ->set($account_data . ".bio", $u_data->getBiography())
            ->set($account_data . ".link", $u_data->getExternalUrl())
            ->set($account_data . ".category", $u_data->getCategory())
            ->set($account_data . ".city", $u_data->getCityName())
            ->set($account_data . ".address_street", $u_data->getAddressStreet())
            ->set($account_data . ".city_id", $u_data->getCityId())
            ->set($account_data . ".is_private", $u_data->getIsPrivate())
            ->set($account_data . ".is_business", $u_data->getIsBusiness())
            ->set($account_data . ".account_type", $u_data->getAccountType())
            ->set($account_data . ".should_show_category", $u_data->getShouldShowCategory())
            ->set($account_data . ".should_show_public_contacts", $u_data->getShouldShowPublicContacts())
            ->set($account_data . ".public_email", $u_data->getPublicEmail())
            ->set($account_data . ".public_phone_country_code", $u_data->getPublicPhoneCountryCode())
            ->set($account_data . ".public_phone_number", $u_data->getPublicPhoneNumber())
            ->set($account_data . ".business_contact_method", $u_data->getBusinessContactMethod())
            ->save();
        $this->resp->data = [
            "media_count" => $u_data->getMediaCount(),
            "following_count" => $u_data->getFollowingCount(),
            "follower_count" => $u_data->getFollowerCount(),
            "full_name" => $u_data->getFullName(),
            "bio" => $u_data->getBiography(),
            "link" => $u_data->getExternalUrl(),
            "category" => $u_data->getCategory(),
            "city" => $u_data->getCityName(),
            "address_street" => $u_data->getAddressStreet(),
            "city_id" => $u_data->getCityId(),
            "is_private" => $u_data->getIsPrivate(),
            "is_business" => $u_data->getIsBusiness(),
            "account_type" => $u_data->getAccountType(),
            "should_show_category" => $u_data->getShouldShowCategory(),
            "should_show_public_contacts" => $u_data->getShouldShowPublicContacts(),
            "public_email" => $u_data->getPublicEmail(),
            "public_phone_country_code" => $u_data->getPublicPhoneCountryCode(),
            "public_phone_number" => $u_data->getPublicPhoneNumber(),
            "business_contact_method" => $u_data->getBusinessContactMethod()
        ];
        return $this->resp->data;
    } else {
        return __("Insights Basic modification not activated");
    }
}
/**
 * Get account avatar and save him to user folder
 * @return void
 */
public function updateavatar($Instagram)
{
    $AuthUser = $this->getVariable("AuthUser");
    if (!Input::post("id")) {
        $this->resp->title = __("Error");
        $this->resp->msg = __("ID is requred!");
        $this->jsonecho();
    }
    $Account = Controller::model("Account", Input::post("id"));
    // Check Account ID and Account Status
    if (!$Account->isAvailable() ||
        $Account->get("user_id") != $AuthUser->get("id"))
    {
        $this->resp->title = __("Error");
        $this->resp->msg = __("Invalid ID");
        $this->jsonecho();
    }
    // Default redirect
    $this->resp->redirect = APPURL."/accounts";
    // Get account avatar 7 times and skip this process, if this 7 retries unsuccessful
    // Mobile proxy connection break adaptation
    $avatar_get = 0;
    $avatar_get_count = 0;
    $avatar_get_status = 0;
    do {
        $avatar_get_count += 1;
        if ($avatar_get_count == 7) {
            $avatar_get = 1;
            $avatar_get_status = 0;
        }
        try {
            $user_resp = $Instagram->account->getCurrentUser()->getUser();
            $avatar_get = 1;
            $avatar_get_status = 1;
        } catch (\InstagramAPI\Exception\NetworkException $e) {
            // Couldn't connect to Instagram account because of network or connection error
            // Do nothing, just try again
            sleep(7);
        } catch (\InstagramAPI\Exception\EmptyResponseException $e) {
            // Instagram send us empty response
            // Do nothing, just try again
            sleep(7);
        } catch (\Exception $e) {
            if ($e->hasResponse()) {
                $msg = $e->getResponse()->getMessage();
            } else {
                $msg = explode(":", $e->getMessage(), 2);
                $msg = end($msg);
            }
            $this->resp->msg = $msg;
            $this->resp->title = __("Oops...");
            $this->jsonecho();
        }
    } while (!$avatar_get);
    if (!$avatar_get_status) {
        $this->resp->title = __("Couldn't connect to Instagram");
        $this->resp->msg= __("Account avatar not updated. Please try again later or contact to Support.");
        $this->jsonecho();
    }
    // Download profile picture
    // Set path to user directory
    $user_dir_path = ROOTPATH."/assets/uploads/".$AuthUser->get("id")."/";
    if (!file_exists($user_dir_path)) {
        mkdir($user_dir_path);
    }
    // Set user directory URL
    $user_dir_url = APPURL."/assets/uploads/".$AuthUser->get("id")."/";
    $ig_pic_url = $user_resp->getProfilePicUrl();
    $url_parts = parse_url($ig_pic_url);
    $ext = strtolower(pathinfo($url_parts['path'], PATHINFO_EXTENSION));
    $filename = "profile-pic-".$user_resp->getUsername().".".$ext;
    $downres = file_put_contents($user_dir_path.$filename, file_get_contents($ig_pic_url));
    $this->resp->avatar_url = APPURL."/assets/uploads/".$AuthUser->get("id")."/profile-pic-".$user_resp->getUsername().".".$ext;
    return $this->resp->avatar_url;
}
/**
 * Switch emulated platform
 */
public function switchPlatform()
{
    ini_set('default_socket_timeout', 300);
    $this->resp->result = 0;
    $AuthUser = $this->getVariable("AuthUser");
    if (!Input::post("id")) {
        $this->resp->title = __("Error");
        $this->resp->msg = __("ID is requred!");
        $this->jsonecho();
    }
    $Account = Controller::model("Account", Input::post("id"));
    // Check Account ID and Account Status
    if (!$Account->isAvailable() ||
        $Account->get("user_id") != $AuthUser->get("id"))
    {
        $this->resp->title = __("Error");
        $this->resp->msg = __("Invalid ID");
        $this->jsonecho();
    }
    $username = $Account->get("username");
    // Detect current platform and set new
    \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
    $st_config = [
        "storage" => "file",
        "basefolder" => SESSIONS_PATH."/".$Account->get("user_id")."/",
    ];
    $IG = new \InstagramAPI\Instagram(false, false, $st_config);
    if (method_exists($IG, 'getIsAndroidSession')) {
        $IG->settings->setActiveUser($username);
        if ($IG->getIsAndroidSession()) {
            $new_platform = "ios";
        } else {
            $new_platform = "android";
        }
    } else {
        $this->resp->title = __("Error");
        $this->resp->msg = __("Update API of the system to latest version to use this feature.");
    }
    // Delete device settings file
    $device_file = APPPATH . "/sessions/" . $AuthUser->get("id") . "/" . $Account->get("username") . "-settings.dat";
    delete($device_file);
    // Allow web usage
    \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
    // Create and configure new instagram client
    $Instagram = new \InstagramAPI\Instagram(false, false, $st_config, $new_platform);
    $Instagram->setVerifySSL(SSL_ENABLED);
    $proxy = $Account->get("proxy");
    if ($proxy) {
        $Instagram->setProxy($proxy);
    }
    // Decrypt pass.
    try {
        $password = \Defuse\Crypto\Crypto::decrypt($Account->get("password"),
            \Defuse\Crypto\Key::loadFromAsciiSafeString(CRYPTO_KEY));
    } catch (Exception $e) {
        throw new Exception(__("Encryption error"));
    }
    $Instagram->changeUser($username, $password);
    $this->reconnect(false, false);
}
}