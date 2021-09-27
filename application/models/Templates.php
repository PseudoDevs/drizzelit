<?php

class Templates extends CI_Model {

    function getByTypeAndLanguage($type, $language) {
        $this->db->select('*');
        $this->db->where('type', $type);
        $this->db->where('lang', $language);
        $this->db->from('droppy_templates');
        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }
    }

    function save($data) {
        $lang = $data['lang'];

        $this->db->select('*');
        $this->db->where('lang', $lang);
        $this->db->from('droppy_templates');
        $this->db->limit(1);
        $query = $this->db->get();

        unset($data['lang']);

        if($query->num_rows() > 0)
        {
            foreach($data as $key => $msg) {
                $this->db->set('msg', $msg);
                $this->db->where('type', $key);
                $this->db->where('lang', $lang);

                $this->db->update('droppy_templates');
            }
        }
        else
        {
            foreach($data as $key => $msg) {
                $insertdata = array(
                    'type'  => $key,
                    'msg'   => $msg,
                    'lang'  => $lang
                );

                $this->db->insert('droppy_templates', $insertdata);
            }
        }
    }
}