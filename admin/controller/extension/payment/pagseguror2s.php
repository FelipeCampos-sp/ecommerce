<?php
class ControllerExtensionPaymentPagSeguroR2S extends Controller {
    private $error = array();
    public $opcoes = array();
    public function index() {
        $pyxdvgbpla = "data";
        $this->language->load("extension/payment/pagseguror2s");
        $this->document->setTitle("PagSeguro Transparente");
        $this->load->model("setting/setting");
        $stlpfgqwwd = "OOO000000";
        $kddontoo = "serial";
        $mudrpwgtpbgv = "data";
        $data["campos"] = $this->getCustomFields();
        $ujqkshdysdgy = "data";
        $rjazwrrvrpb = "OOO000000";
        $xgpynvmtxo = "OOO000000";
        $cwlbbpqwbfk = "data";
        $ttpabmrnkoh = "OOO000000";
        $negorfgrah = "OOO000000";
        $qftrrnxd = "data";
        $muwbgbmmho = "OOO000000";
        if (($this->request->server["REQUEST_METHOD"] == "POST") && $this->validate()) {
            $this->model_setting_setting->editSetting("pagseguror2s", $this->request->post);
            if (isset($this->request->post["pagseguror2s_status_tef"])) {
                $this->model_setting_setting->editSetting("pagseguror2stef", array("pagseguror2stef_status" => $this->request->post["pagseguror2s_status_tef"]));
            }
            if (isset($this->request->post["pagseguror2s_status_boleto"])) {
                $this->model_setting_setting->editSetting("pagseguror2sboleto", array("pagseguror2sboleto_status" => $this->request->post["pagseguror2s_status_boleto"]));
            }
            $this->session->data["success"] = $this->language->get("text_success");
            $this->response->redirect($this->url->link("extension/payment/pagseguror2s", "token=" . $this->session->data["token"], "SSL"));
        }
        $data["heading_title"] = $this->language->get("heading_title");
        ${$ujqkshdysdgy}["button_save"] = $this->language->get("button_save");
        $hvazhkqvtgp = "idPagamento";
        ${$mudrpwgtpbgv}["button_cancel"] = $this->language->get("button_cancel");
        $data["text_enabled"] = $this->language->get("text_enabled");
        $data["text_disabled"] = $this->language->get("text_disabled");
        $data["error_warning"] = "";
        $data["breadcrumbs"] = array();
        $rydylrnqz = "data";
        $data["breadcrumbs"][] = array("text" => $this->language->get("text_home"), "href" => $this->url->link("common/home", "token=" . $this->session->data["token"], "SSL"), "separator" => false);
        $data["breadcrumbs"][] = array("text" => $this->language->get("text_payment"), "href" => $this->url->link("extension/payment", "token=" . $this->session->data["token"], "SSL"), "separator" => " :: ");
        ${$rydylrnqz}["breadcrumbs"][] = array("text" => "PagSeguro Transparente", "href" => $this->url->link("extension/payment/pagseguror2s", "token=" . $this->session->data["token"], "SSL"), "separator" => " :: ");
        $qqrpdegxoln = "OOO0000O0";
        $data["action"] = $this->url->link("extension/payment/pagseguror2s", "token=" . $this->session->data["token"], "SSL");
        $data["cancel"] = $this->url->link("extension/payment", "token=" . $this->session->data["token"], "SSL");
        $serial = trim($this->config->get("pagseguror2s_serial"));
        ${$muwbgbmmho} = urldecode("%61%68%36%73%62%65%68%71%6c%61%34%63%6f%5f%73%61%64");
        $OO00O0000 = 244;
        $OOO0000O0 = $OOO000000{4} . $OOO000000{9} . ${$stlpfgqwwd}{3} . ${$ttpabmrnkoh}{5};
		$OOO0000O0.= $OOO000000{2} . ${$rjazwrrvrpb}{10} . $OOO000000{13} . $OOO000000{16};
		$OOO0000O0.= $OOO0000O0{3} . $OOO000000{11} . ${$negorfgrah}{12} . ${$qqrpdegxoln}{7} . ${$xgpynvmtxo}{5};
		$O0O0000O0 = "OOO0000O0";
		$key_string = ${$kddontoo};
		$remote_auth = "df08acba4ec3";
		$key_location = DIR_UPLOAD . "key.pagseguror2s.php";
		$key_age = 1296000;
		$resultado = new gateway_pagseguro_open_web_loja5($key_string, $remote_auth, $key_location, $key_age);
		$idPagamento = $OOO0000O0($resultado->result);
		$data["mod_ativado"] = $idPagamento;
		
		$this->get("pagseguror2s_serial");
		if (1 == 1) {    
		$this->get("pagseguror2s_titulo_cartao");    
		$this->get("pagseguror2s_titulo_boleto");    
		$this->get("pagseguror2s_titulo_tef");    
		$this->get("pagseguror2s_email");    
		$this->get("pagseguror2s_token");    
		$this->get("pagseguror2s_modo");    
		$this->get("pagseguror2s_in");    
		$this->get("pagseguror2s_pe");    
		$this->get("pagseguror2s_pg");    
		$this->get("pagseguror2s_ca");    
		$this->get("pagseguror2s_de");    
		$this->get("pagseguror2s_di");    
		$this->get("pagseguror2s_geo_zone_id");    
		$this->get("pagseguror2s_status");    
		$this->get("pagseguror2s_status_cartao");    
		$this->get("pagseguror2s_status_boleto");    
		$this->get("pagseguror2s_status_tef");    
		$this->get("pagseguror2s_ordem_cartao");    
		$this->get("pagseguror2s_complemento");    
		$this->get("pagseguror2s_ordem_boleto");    
		$this->get("pagseguror2s_ordem_tef");    
		$this->get("pagseguror2s_total_cartao");    
		$this->get("pagseguror2s_total_boleto");    
		$this->get("pagseguror2s_total_tef");    
		$this->get("pagseguror2s_fiscal");    
		$this->get("pagseguror2s_numero");
		
		}
		foreach ($this->opcoes AS $k => $v){
			$data[$k] = $v;
			}
			$this->load->model("localisation/order_status");
			${$qftrrnxd}["order_statuses"] = $this->model_localisation_order_status->getOrderStatuses();
			$this->load->model("localisation/geo_zone");
			$data["geo_zones"] = $this->model_localisation_geo_zone->getGeoZones();
		if (1 == 1) {
			$tema = "extension/payment/pagseguror2s.tpl";} 
		else {   
			$tema = "extension/payment/pagseguror2s_ativar.tpl";
			}
		$data["header"] = $this->load->controller("common/header");
		${$cwlbbpqwbfk}["column_left"] = $this->load->controller("common/column_left");
		$data["footer"] = $this->load->controller("common/footer");
		$this->response->setOutput($this->load->view($tema, $data));
    }
    public function install() {
		$this->load->model("extension/extension");
		$this->model_extension_extension->install("payment", "pagseguror2stef");
		$this->model_extension_extension->install("payment", "pagseguror2sboleto");
    }
    public function uninstall() {
		$this->load->model("extension/extension");
		$this->model_extension_extension->uninstall("payment", "pagseguror2stef");
		$this->model_extension_extension->uninstall("payment", "pagseguror2sboleto");
    }
    public function get($campo) {
		if (isset($this->request->post[$campo])) {
			$mlmpzxyquvi = "campo";    
			$this->opcoes[$campo] = $this->request->post[${$mlmpzxyquvi}];
		} 
		else {
			$this->opcoes[$campo] = $this->config->get($campo);
		}
    }
    public function getCustomFields($data = array()) {
		
		$wqslgj = "sort_data";
		if (empty($data["filter_customer_group_id"])){
			$sql = "SELECT * FROM `" . DB_PREFIX . "custom_field` cf LEFT JOIN " . DB_PREFIX . "custom_field_description cfd ON (cf.custom_field_id = cfd.custom_field_id) WHERE cfd.language_id = '" . (int)$this->config->get("config_language_id") . "'";} 
		else {
			$hsgbdqyq = "sql";
			${$hsgbdqyq} = "SELECT * FROM " . DB_PREFIX . "custom_field_customer_group cfcg LEFT JOIN `" . DB_PREFIX . "custom_field` cf ON (cfcg.custom_field_id = cf.custom_field_id) LEFT JOIN " . DB_PREFIX . "custom_field_description cfd ON (cf.custom_field_id = cfd.custom_field_id) WHERE cfd.language_id = '" . (int)$this->config->get("config_language_id") . "'";}
			if (!empty($data["filter_name"])) {
				$oqbdos = "data";
				$sql.= " AND cfd.name LIKE '" . $this->db->escape(${$oqbdos}["filter_name"]) . "%'";}
				if (!empty($data["filter_customer_group_id"])) {
					$sql.= " AND cfcg.customer_group_id = '" . (int)$data["filter_customer_group_id"] . "'";
				}
				$sort_data = array("cfd.name", "cf.type", "cf.location", "cf.status", "cf.sort_order");
				if (isset($data["sort"]) && in_array($data["sort"], ${$wqslgj})) {    
				$owvkwazt = "data";    
				$sql.= " ORDER BY " . ${$owvkwazt}["sort"];
				} else {
				$sql.= " ORDER BY cfd.name";
				}
				if (isset($data["order"]) && ($data["order"] == "DESC")) {    
				$sql.= " DESC";} 
				else {
				$yigjmmmxisd = "sql";
				${$yigjmmmxisd}.= " ASC";
				}
				if (isset($data["start"]) || isset($data["limit"])) {
					$krkuwep = "data";    
					if ($data["start"] < 0) {
						$fkkbckbwvntk = "data";
						${$fkkbckbwvntk}["start"] = 0;
					}    
					if ($data["limit"] < 1) {
						$data["limit"] = 20;
					}
						$sql.= " LIMIT " . (int)$data["start"] . "," . (int)${$krkuwep}["limit"];
				}$query = $this->db->query($sql);return $query->rows;
    }
    protected function validate() {
		return true;
    }
}
class gateway_pagseguro_open_web_loja5 {
    var $license_key;
    var $home_url_site = 'd3d3LmxvY2FzaXN0ZW1hcy5jb20=';
    var $home_url_port = 80;
    var $home_url_iono = 'L2NsaWVudGVzL3JlbW90ZS5waHA=';
    var $key_location;
    var $remote_auth;
    var $key_age;
    var $key_data;
    var $now;
    var $result;
    function __construct($license_key, $remote_auth, $key_location = 'key.php', $key_age = 1296000) {$this->gateway_pagseguro_open_web_loja5($license_key, $remote_auth, $key_location, $key_age);
    }
    function Visa() {return true;
    }
    function http_response($url) {
	$ch = curl_init();
	$qffsxr = "ch";
	curl_setopt($ch, CURLOPT_URL, "http://" . $url);
	$ebazjkoq = "ch";
	$tjjgxwhmqqx = "ch";
	curl_setopt(${$ebazjkoq}, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$head = curl_exec(${$tjjgxwhmqqx});
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close(${$qffsxr});
	return $httpCode;
    }
    function CiCielo() {
		return true;
    }
    function MCoder($str) {
	$uqmfiupvo = "OOO000000";
	$agtoobgiyhd = "OOO000000";
	$dbvlfx = "O0O0000O0";
	$axexhud = "OOO0000O0";
	$rbaddvbqg = "OOO000000";
	$lehzssy = "OOO000000";
	$OOO000000 = urldecode("%61%68%36%73%62%65%68%71%6c%61%34%63%6f%5f%73%61%64");
	$OO00O0000 = 244;
	$tmcrdiwa = "OOO000000";
	$nauggncc = "OOO0000O0";
	${$axexhud} = $OOO000000{4} . $OOO000000{9} . $OOO000000{3} . $OOO000000{5};
	$OOO0000O0.= ${$uqmfiupvo}{2} . $OOO000000{10} . ${$tmcrdiwa}{13} . ${$agtoobgiyhd}{16};$OOO0000O0.= $OOO0000O0{3} . ${$rbaddvbqg}{11} . ${$lehzssy}{12} . ${$nauggncc}{7} . $OOO000000{5};
	${$dbvlfx} = "OOO0000O0";
	return $OOO0000O0($str);
    }
    function gateway_pagseguro_open_web_loja5($license_key, $remote_auth, $key_location = 'key.pagseguro.php', $key_age = 1296000) {$mlurase = "servidoronline";
	
	$rqywnnhvjplf = "a";
	$difjff = "license_key";
	$this->license_key = ${$difjff};
	$mqmvauzejftf = "key_age";
	$this->remote_auth = $remote_auth;
	$taiknrk = "p_id";
	$this->key_location = $key_location;
	$this->key_age = ${$mqmvauzejftf};
	$this->now = time();
	${$taiknrk} = "58";
	${$rqywnnhvjplf} = @explode("-", $license_key);
	if (isset($a[2]) && $a[2] != $p_id) {
	$this->result = "NjY=";
	return true;
	}
	$servidoronline = $this->http_response($this->MCoder($this->home_url_site));
	if (${$mlurase} <= 0){  
	$this->result = "MQ==";
	return true;
	}
	if (empty($license_key)) {    
	$this->result = "NA==";
	return false;
	}
	if (empty($remote_auth)) {
		$this->result = "NA==";
		return false;
	}
		if (file_exists($this->key_location)) {
			$this->result = $this->PagamentoCreditoDebitoCielo();
		} else {
			$this->result = $this->PagamentoCreditoDebito();
			if (empty($this->result)) {
				$this->result = $this->PagamentoCreditoDebitoCielo();
			}
		}
		unset($this->remote_auth);
		return true;
    }
    function PagamentoCreditoDebito() {
		$ucmmku = "request";
		$vmfscl = "exploded";
		$mcbcate = "data";
		$servidoronline = $this->http_response($this->MCoder($this->home_url_site));
		if ($servidoronline <= 0) {    
		return "MQ==";
		}
		$uvonuuaiushh = "fp";
		$request = "remote=licenses&type=5&license_key=" . urlencode(base64_encode($this->license_key));
		$wimueovkcdu = "request";
		$nxewguxcfyf = "data_encoded";
		${$ucmmku}.= "&host_ip=" . urlencode(base64_encode("")) . "&host_name=" . urlencode(base64_encode(str_replace("www.", "", $_SERVER["SERVER_NAME"])));
		$request.= "&hash=" . urlencode(base64_encode(md5(${$wimueovkcdu})));
		$request = $this->MCoder($this->home_url_iono) . "?" . $request;
		$header = "GET $request HTTP/1.0 Host: " . $this->MCoder($this->home_url_site) . "Connection: Close User-Agent: iono (www.olate.co.uk/iono)";
		$header.= "";
		$fpointer = @fsockopen($this->MCoder($this->home_url_site), $this->home_url_port, $errno, $errstr, 5);
		$return = "";$tdfddqgn = "exploded";
		if ($fpointer) {    
		$vfsqkupdeh = "fpointer";    
		$atuvfsb = "fpointer";
		@fwrite($fpointer, $header);
		while (!@feof(${$atuvfsb})) {
			$return.= @fread($fpointer, 1024);
		}    
		@fclose(${$vfsqkupdeh});
		} 
		else {
			return "MTI=";
		}
		$gcrwiwk = "return";
		$content = explode("", $return);
		$content = explode($content[0], ${$gcrwiwk});
		$string = urldecode($content[1]);
		$exploded = explode("|", $string);
		switch ($exploded[0]) {
			case 0:
			return "OA==";
			break;
			case 2:
			return "OQ==";
			break;
			case 3:
			return "NQ==";
			break;
			case 10:
			return "NA==";
			break;
		}
			$data["license_key"] = $exploded[1];
			$data["expiry"] = $exploded[2];
			${$mcbcate}["hostname"] = ${$vmfscl}[3];
			$hsmfttwtjp = "data";$glkjbgrqmz = "data_encoded";
			$data["ip"] = ${$tdfddqgn}[4];
			$data["timestamp"] = $this->now;
			if (empty($data["hostname"])) {    
			$zxvpbum = "data";    
			${$zxvpbum}["hostname"] = str_replace("www.", "", $_SERVER["SERVER_NAME"]);
			}
			if (empty($data["ip"])) {
				$data["ip"] = "";
			}
				$data_encoded = serialize(${$hsmfttwtjp});
				$data_encoded = base64_encode($data_encoded);
				${$glkjbgrqmz} = md5($this->now . $this->remote_auth) . $data_encoded;
				$data_encoded = strrev(${$nxewguxcfyf});
				$data_encoded_hash = sha1($data_encoded . $this->remote_auth);
				${$uvonuuaiushh} = fopen($this->key_location, "w");
				if ($fp) {
					$flpivybfq = "fp_write";
					${$flpivybfq} = fwrite($fp, wordwrap($data_encoded . $data_encoded_hash, 40, "", true));
					if (!$fp_write) {
						return "MTE=";
						}
					fclose($fp);
				} else {
				return "MTA=";
				}
    }
    function B0000000() {
		return true;
    }
    function PagamentoCreditoDebitoCielo() {
		$key = file_get_contents($this->key_location);
		if ($key !== false) {
			$xsxlhthy = "key";
			$tnbagidpj = "key";
			$kdzsvewr = "key";
			$key = str_replace("", "", $key);
			$key_string = substr($tnbagidpj, 0, strlen($xsxlhthy) - 40);
			$key_sha_hash = substr($key, strlen($kdzsvewr) - 40, strlen($key));
			if (sha1($key_string . $this->remote_auth) == $key_sha_hash){
				$ykxgjfbu = "key_data";
				$jwvsaefokj = "key";
				$cyfnbybendg = "key_string";
				$riwownuhssu = "key";
				${$riwownuhssu} = strrev(${$cyfnbybendg});
				$inrtiud = "key_data";
				$key_hash = substr(${$jwvsaefokj}, 0, 32);
				${$ykxgjfbu} = substr($key, 32);
				${$inrtiud} = base64_decode($key_data);
				$key_data = unserialize($key_data);
				if (md5($key_data["timestamp"] . $this->remote_auth) == $key_hash) {
					$fmjkgucyfmn = "key_data";
					if (($this->now - ${$fmjkgucyfmn}["timestamp"]) >= $this->key_age) {
						unlink($this->key_location);
						$this->result = $this->PagamentoCreditoDebito();
						if (empty($this->result)) {
							$this->result = $this->PagamentoCreditoDebitoCielo();
						}
						return "MQ==";
					} else {
						$hwkhwi = "key_data";
						$jsgchknx = "key_data";
						$this->key_data = ${$hwkhwi};
						if (${$jsgchknx}["license_key"] != $this->license_key) {
							return "NA==";
						}
						$xdciyesoiuq = "key_data";
						if ($key_data["expiry"] <= $this->now && $key_data["expiry"] != 1) {
							return "NQ==";
						}
						if (substr_count(${$xdciyesoiuq}["hostname"], ",") == 0) {
							$wfqeumjbs = "key_data";
							$limpo = str_replace("www.", "", $_SERVER["SERVER_NAME"]);
							if (${$wfqeumjbs}["hostname"] != $limpo && !empty($key_data["hostname"])) {
								return "Ng==";
							}
						} else {
							$kfqwayewn = "key_data";
							$ahosgkwwt = "limpo";
							$hostnames = explode(",", ${$kfqwayewn}["hostname"]);$limpo = str_replace("www.", "", $_SERVER["SERVER_NAME"]);
							if (!in_array(${$ahosgkwwt}, $hostnames)) {
								return "Ng==";
							}
						}
						return "MQ==";
					}
				} else {
					return "Mw==";
					}
			} else {
				return "Mg==";
		}} else {
			return "MA==";
		}
    }
    function get_data() {return $this->key_data;
    }
    function B39() {return true;
    }
}
?>