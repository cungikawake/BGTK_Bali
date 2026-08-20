<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	require APPPATH .'third_party/Google/vendor/autoload.php';
	
	/* https://developers.google.com/oauthplayground/ 
	   to get refresh token (make sure set your client id and cleint secret on gear setting [v] Use your own OAuth credentials)
	*/
	
	class Google {
		protected $client;
		protected $drive;
		protected $userTokenPath = APPPATH .'third_party/Google/vendor/user_token/';
		
		protected $tokenFile = APPPATH .'third_party/Google/vendor/token_file.json';
		protected $credential = APPPATH .'third_party/Google/vendor/client_credentials.json';
		
		public function __construct() {
			$CI =& get_instance();
			
			$this->client = new Google\Client();
			$this->client->setAuthConfig(APPPATH .'third_party/Google/vendor/client_credentials.json');
			
			if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
				// Scopes for admin
				//$this->client->setScopes(array("https://www.googleapis.com/auth/drive", "email"));
				$this->client->setScopes(array('email','profile'));
				//https://www.googleapis.com/auth/calendar
				$this->client->setRedirectUri("https://bgpbali.id/admin/user/oAuth2");
			}
			else {
				// Scopes for guest
				$this->client->setScopes(array('email','profile'));
				$this->client->setRedirectUri("https://bgpbali.id/user/oAuth2");
			}
			
			
			$this->client->setAccessType('offline');
			$this->client->setApprovalPrompt('force');
			
			//$this->setClient();
		}
		
		public function authUrl() {
			return $this->client->createAuthUrl();
		}		
		
		public function isAuthenticated ($code) {
			return $this->client->authenticate($code);
		}
		
		public function getAccessToken() {
			return $this->client->getAccessToken();
		}
		
		public function setAccessToken($token) {
			$accessToken = $this->client->setAccessToken($token);
			//$this->drive = new Google\Service\Drive($this->client);
			
			return $accessToken;
		}
		
		public function saveTokenFile ($filename, $content) {
			$fp = fopen($this->userTokenPath . $filename.".txt","wb");
			fwrite($fp,$content);
			fclose($fp);
		}
		
		public function getUserDetail() {
			$payload = $this->client->verifyIdToken();
			return $payload;	
		}
		
		public function setClient() {
			
			/*if (isset($_SESSION["user"]) && isset($_SESSION["user"]["id"])) {
				$tokenFile = $this->userTokenPath. $_SESSION["user"]["id"].".txt";
				
				if (!file_exists($tokenFile)) {
					$tokenFile = $this->userTokenPath. "1.txt"; // Akun belajar.id Bayu Prawira
				}
			}
			else {
				$tokenFile = $this->userTokenPath. "1.txt"; // Akun belajar.id Bayu Prawira
			}
			
			if (file_exists($tokenFile)) {
				$accessToken = json_decode(file_get_contents($tokenFile), true);
				$this->client->setAccessToken($accessToken);
			}*/

			if ($this->client->isAccessTokenExpired()) {
				if ($this->client->getRefreshToken()) {
					$this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
				}

				// pass access token to some variable
				$accessToken = $this->client->getAccessToken();
				$this->client->setAccessToken($accessToken);

				//file_put_contents($tokenFile, json_encode($accessToken));
			}

			//$this->drive = new Google\Service\Drive($this->client);
		}
		
		public function serachDriveFolderByName ($name, $parent = '') {
			$queryParent = "";
			
			if (!empty($parent)) {
				$queryParent = "'".$parent."' in parents AND ";
			}
			
			$parameters = array("q" => $queryParent."name='".$name."' AND mimeType = 'application/vnd.google-apps.folder' AND trashed = false");
			
			$files = $this->drive->files->listFiles($parameters);
			
			if (!empty($files->files)) {
				return $files->files[0]->id;
			}
			else {
				return "";
			}
		}
		
		public function createDriveFolder ($folderName, $parent = '') {
			$folderId = $this->serachDriveFolderByName($folderName, $parent);
			
			if (empty($folderId)) {
				$file = new Google\Service\Drive\DriveFile();
				$file->setName($folderName);
				$file->setMimeType('application/vnd.google-apps.folder');
				
				if (!empty($parent)) {
					$file->setParents(array($parent));
				}

				$folder = $this->drive->files->create($file);
				$folderId = $folder->id;
				
				
				$permission = new Google\Service\Drive\Permission(array(
					'type' => 'anyone',
					'role' => "writer",
					'withLink' => true
				));
				
				$this->drive->permissions->create($folderId, $permission, array('fields' => 'id'));
			}
			
			return $folderId;
		}
		
		public function createDriveFile ($fileTmp, $parent = "") {
			$file = new Google\Service\Drive\DriveFile();
			$file->setName($fileTmp["name"]);
			
			if (!empty($parent)) {
				$file->setParents(array($parent));
			}
			
			$data = array();
			$data["data"] = file_get_contents($fileTmp["tmp_name"]);
			$data["mimeType"] = "application/octet-stream";
			$data["uploadType"] = "multipart";
			$data["supportsAllDrives"] = true;
			
			$result = $this->drive->files->create($file, $data);
			
			return $result->id;
		}
		
		public function deleteDriveFile ($fileId) {
			$result = $this->drive->files->delete($fileId);
			
			return $result;
		}
		
		public function getDriveFileList () {
			$files = $this->drive->files->listFiles();
  			return $files;
		}
	}