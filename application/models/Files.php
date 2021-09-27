<?php

class Files extends CI_Model {
    /**
     * Will add new files to the droppy_files table
     * @param type $upload_id
     * @param type $file_id
     * @param type $file_name
     * @param type $size
     * @return boolean
     */
    function add($upload_id, $file_id, $file_name, $size) {
        $data = array(
            'upload_id'     => $upload_id,
            'secret_code'   => $file_id,
            'file'          => $file_name,
            'size'          => $size,
            'time'          => time()
        );

        $query = $this->db->insert('droppy_files', $data);

        if($query) {
            return true;
        }
        return false;
    }

    /**
     * Will return all files from the droppy_files table
     * @param int $start
     * @param int $limit
     * @return array|bool
     */
    function getAll($start = 0, $limit = 0) {
        $this->db->select('*');
        $this->db->from('droppy_files');
        if($limit > 0) {
            $this->db->limit($start, $limit);
        }
        
        $query = $this->db->get();
        
        if($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
    /**
     * Will return total amount of rows in the droppy_files table
     * @return type
     */
    function getTotal() {
        $this->db->select('*');
        $this->db->from('droppy_files');
        
        $query = $this->db->get();
        
        return $query->num_rows;
    }
    
    
    /**
     * Will fetch files by upload ID
     * @param type $upload_id
     * @return array|boolean
     */
    function getByUploadID($upload_id) {
        $this->db->select('*');
        $this->db->from('droppy_files');
        $this->db->where('upload_id', $upload_id);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    /**
     * Returns the amount of rows found by upload id
     *
     * @param $upload_id
     * @return int
     */
    function getTotalByUploadID($upload_id) {
        $this->db->select('*');
        $this->db->from('droppy_files');
        $this->db->where('upload_id', $upload_id);

        $query = $this->db->get();

        return $query->num_rows;
    }

    /**
     * Gets file by ID
     * @param type $id
     * @return boolean
     */
    function getByID($id) {
        $this->db->select('*');
        $this->db->from('droppy_files');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
    /**
     * Fetch incomplete uploads
     * @return boolean|array
     */
    function getIncompleteUploads() {
        $this->db->select('*');
        $this->db->from('droppy_uploads');
        $this->db->where('status', 'processing');
        $this->db->where('(time + 43200) < ', time());
        $query = $this->db->get();
        
        if($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
    function deleteFileByID($file_id) {
        $this->db->delete('droppy_files', array('id' => $file_id));
        
        return true;
    }
    
    function deleteFilesByUploadID($upload_id) {
        $this->db->delete('droppy_files', array('upload_id' => $upload_id));
    
        return true;
    }
}