<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('migration');
    }

    public function index() { 
        $this->load->library('migration');
        if ($this->migration->current() === FALSE)
        {
            echo $this->migration->error_string();
        }else{
            echo "Table Migrated Successfully.";
        }
    }

    public function kegiatan_options () {
        $this->load->model("kegiatan_model");
        $kegiatan = $this->kegiatan_model->get_all();

        $komponen = array(
            "peserta", "panitia", "narasumber", "moderator", "instruktur", "fasil", "pp", "pengawas", "kepala_sekolah"
        );

        $data = array();

        foreach ($kegiatan as $out) {
            $out = (array) $out;

            $data[$out["id"]] = array();
            
            // Pharsing
            if (isset($out["link_peserta"]) && !empty($out["link_peserta"])) {
                $out["link_peserta"] = (array) json_decode($out["link_peserta"]);
            }
            
            if (isset($out["link_narasumber"]) && !empty($out["link_narasumber"])) {
                $out["link_narasumber"] = (array) json_decode($out["link_narasumber"]);
            }
            
            if (isset($out["link_panitia"]) && !empty($out["link_panitia"])) {
                $out["link_panitia"] = (array) json_decode($out["link_panitia"]);
            }
            
            if (isset($out["link_moderator"]) && !empty($out["link_moderator"])) {
                $out["link_moderator"] = (array) json_decode($out["link_moderator"]);
            }
            
            if (isset($out["link_pp"]) && !empty($out["link_pp"])) {
                $out["link_pp"] = (array) json_decode($out["link_pp"]);
            }
            
            if (isset($out["link_fasil"]) && !empty($out["link_fasil"])) {
                $out["link_fasil"] = (array) json_decode($out["link_fasil"]);
            }
            
            if (isset($out["link_instruktur"]) && !empty($out["link_instruktur"])) {
                $out["link_instruktur"] = (array) json_decode($out["link_instruktur"]);
            }
            
            if (isset($out["link_pengawas"]) && !empty($out["link_pengawas"])) {
                $out["link_pengawas"] = (array) json_decode($out["link_pengawas"]);
            }
            
            if (isset($out["link_kepala_sekolah"]) && !empty($out["link_kepala_sekolah"])) {
                $out["link_kepala_sekolah"] = (array) json_decode($out["link_kepala_sekolah"]);
            }
            
            if (isset($out["detail_tgl_kegiatan"]) && !empty($out["detail_tgl_kegiatan"])) {
                $out["detail_tgl_kegiatan"] = (array) json_decode($out["detail_tgl_kegiatan"]);
            }
            
            if (isset($out["komponen"]) && !empty($out["komponen"])) {
                $out["komponen"] = (array) json_decode($out["komponen"]);
            }
            
            if (isset($out["kategori"]) && !empty($out["kategori"])) {
                $out["kategori"] = (array) json_decode($out["kategori"]);
            }

            if (isset($out["no_urut_terakhir"]) && !empty($out["no_urut_terakhir"])) {
                $out["no_urut_terakhir"] = (array) json_decode($out["no_urut_terakhir"]);
            }

            $options = array();

            foreach ($komponen as $kom) {
                $komNew = $kom;

                if ($kom == "pp") {
                    $komNew = "pengajar_praktik";
                }

                if ($kom == "fasil") {
                    $komNew = "fasilitator";
                }

                $data[$out["id"]][$komNew]["link"] = $out["link_".$kom];
                $data[$out["id"]][$komNew]["link_on"] = $out["link_".$kom."_on"];
                $data[$out["id"]][$komNew]["form_show_bank"] = $out["form_show_bank_".$kom];
                $data[$out["id"]][$komNew]["form_show_confirm_paket"] = $out["form_show_confirm_paket_".$kom];
                $data[$out["id"]][$komNew]["form_ttd"] = $out["form_ttd_".$kom];
                $data[$out["id"]][$komNew]["wa_grup"] = $out["wa_grup_".$kom];
                $data[$out["id"]][$komNew]["tele_grup"] = $out["tele_grup_".$kom];
                $data[$out["id"]][$komNew]["form_upload_surtug"] = $out["form_upload_surtug_".$kom];
                $data[$out["id"]][$komNew]["form_wajib_surtug"] = $out["form_wajib_surtug_".$kom];
                $data[$out["id"]][$komNew]["kategori"] = $out["kategori"][$kom];
                exit();
            }

            print "<pre>";
            print_r($data);
            print "</pre>";
        }
    }
}