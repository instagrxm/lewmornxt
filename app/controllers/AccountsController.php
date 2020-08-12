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
if (Input::post("action") == "switch-platform") {
    $this->switchPlatform();
}
        
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