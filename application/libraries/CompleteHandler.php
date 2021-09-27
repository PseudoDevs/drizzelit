<?php

/**
 * Droppy - Upload complete handler
 *
 * Class CompleteHandler
 */
class CompleteHandler
{
    /**
     * @var CI_Controller
     */
    protected $CI;

    /**
     * CompleteHandler constructor.
     */
    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Process the upload completion
     *
     * @param $post_data
     * @return bool
     * @throws Exception
     */
    public function complete($post_data) {
        $this->CI->load->model('uploads');
        $this->CI->load->model('files');
        $this->CI->load->model('receivers');

        // Make sure to keep the script running
        // Zipping and encrypting can take some time
        ini_set('max_execution_time', 0);

        // Get the uploaded files
        $files = $this->CI->files->getByUploadID($post_data['upload_id']);

        $this->CI->logging->log($post_data['upload_id'] . " > Disconnecting the client from the request, Droppy will continue completing the upload in the background");

        // Kill the connection to the user, we got what we need.
        $this->killConnection();

        $this->CI->logging->log($post_data['upload_id'] . " > Client disconnected, start processing files..");

        // Process the files (Zipping, moving etc.)
        if($this->processFiles($files, $post_data['upload_id'])) {
            $this->CI->db->reconnect();

            // Update the upload info in the DB
            $this->CI->uploads->updateByUploadID($post_data['upload_id'], array('count' => $post_data['total_files']));

            // Get upload info
            $upload = $this->CI->uploads->getByUploadID($post_data['upload_id']);

            if($upload !== false && $upload['share'] == 'mail') {
                // Load email library
                $this->CI->load->library('email');

                // Prepare sender data array to pass to email
                $sender_data = array('upload_id' => $post_data['upload_id']);
                if(isset($post_data['password'])) {
                    $sender_data['password'] = $post_data['password'];
                }

                // Send email to uploader
                $this->CI->email->sendEmail('sender', $sender_data, array($upload['email_from']));

                // Get receivers
                $receivers = $this->CI->receivers->getByUploadID($post_data['upload_id']);

                // Send email to receivers
                foreach($receivers as $receiver) {
                    $this->CI->load->library('email');

                    // Prepare receiver data array to pass to email
                    $receiver_data = array('upload_id' => $post_data['upload_id'], 'private_id' => $receiver['private_id'], 'email' => $receiver['email'], 'email_from' => $upload['email_from']);
                    if(isset($post_data['password'])) {
                        $receiver_data['password'] = $post_data['password'];
                    }

                    $this->CI->email->sendEmail('receiver', $receiver_data, array($receiver['email']));
                }
            }

            return true;
        }
        return false;
    }

    /**
     * Process the upoaded files to one single zip file.
     *
     * @param $files
     * @param $upload_id
     * @return bool
     * @throws Exception
     */
    private function processFiles($files, $upload_id) {
        $this->CI->load->helper('file');

        $upload_path    = FCPATH . $this->CI->config->item('upload_dir');
        $temp_path      = $upload_path . 'temp/';

        // Check the total amount of files
        $total = count($files);

        $this->CI->logging->log("$upload_id > Total of $total files to process");

        if($total > 1) {
            $this->CI->logging->log("$upload_id > Start zipping process");

            // If more than 1 start zipping files
            $file_name  = $this->CI->config->item('name_on_file') . '-' . $upload_id . '.zip';
            $zip_path   = FCPATH . $this->CI->config->item('upload_dir') . $file_name;

            // Load zip library
            $this->CI->load->library('zip');

            $this->CI->logging->log("$upload_id > Created $zip_path");

            // Create the zip file
            $this->CI->zip->zip_start($zip_path);

            // Loop through files
            foreach($files as $file) {
                $path = $temp_path . $file['secret_code'] . '-' . $file['file'];

                $this->CI->logging->log("$upload_id > Adding $path to ZIP $zip_path");

                $this->CI->zip->zip_add($path, $file['file']);

                $this->CI->logging->log("$upload_id > Added $path to ZIP $zip_path");
            }

            $this->CI->logging->log("$upload_id > Saving ZIP $zip_path");

            // Save the ZIP file
            if($this->CI->zip->zip_end(1)) {
                $this->CI->logging->log("$upload_id > ZIP file $zip_path saved! Starting to remove original files");
                // Loop through files again but delete them this time
                foreach($files as $file) {
                    $path = $temp_path . $file['secret_code'] . '-' . $file['file'];

                    unlink($path);

                    $this->CI->logging->log("$upload_id > Removed file $path");
                }
            }

            $final_path = $zip_path;
            $success    = true;
        }
        else
        {
            $this->CI->logging->log("$upload_id > Single file in upload, start renaming the file");

            // Ignore zipping when only 1 file has been selected
            foreach($files as $file) {
                $file_name = $file['secret_code'] . '-' . $file['file'];
                $path = $temp_path . $file_name;

                $final_path = $upload_path . $file_name;
                rename($path, $final_path);
                $this->CI->logging->log("$upload_id > File $path renamed to $final_path");
            }

            $success    = true;
        }

        // File processing was successfull
        if($success == true) {
            $this->CI->logging->log("$upload_id > File processing finished successfully!");
            $this->CI->db->reconnect();

            // Store the final size of the file in the database
            $final_size = filesize($final_path);
            $this->CI->uploads->updateByUploadID($upload_id, array('size' => $final_size));
            $this->CI->logging->log("$upload_id > Final size of file ($final_size) stored in DB");

            $this->CI->load->library('plugin');
            if($this->CI->plugin->pluginLoaded('upload')) {
                $this->CI->logging->log("$upload_id > External storage plugin installed, start sending the file to external storage..");

                $upload_plugin = $this->CI->plugin->_plugins['upload'];

                require_once $this->CI->plugin->_pluginDir . $upload_plugin['load'] . '/' . $upload_plugin['handler_library'];

                $handlerLibrary = new HandlerLibrary();

                if($handlerLibrary->upload($upload_id, $final_path, $file_name, $this->CI->config->item('encrypt_files'))) {
                    $this->CI->logging->log("$upload_id > File successfully sent to external storage, removing local file $final_path");
                    if(unlink($final_path)) {
                        $this->CI->logging->log("$upload_id > Local file $final_path removed!");
                        return true;
                    }
                }
            }

            // If enabled start encrypting the zip file
            if($this->CI->config->item('encrypt_files') == 1) {
                $this->CI->logging->log("$upload_id > File encryption enabled! Start encrypting the file $final_path");
                $encryptKey = $this->encryptFile($final_path);

                $this->CI->db->reconnect();

                $this->CI->uploads->updateEncrypt($encryptKey, $upload_id);
                $this->CI->logging->log("$upload_id > File $final_path successfully encrypted");
            }

            return $final_path;
        }

        // Ohno !! Something went wrong
        return false;
    }

    /**
     * Encrypt a file
     *
     * @param $file_path
     * @return bool|string
     */
    function encryptFile($file_path)
    {
        $this->CI->load->helper('string');
        $gen_key = random_string('alnum', 32);

        $key = substr(sha1($gen_key, true), 0, 16);
        $iv = openssl_random_pseudo_bytes(16);
        $blocks = 10000;

        $temp_file  = $this->CI->config->item('upload_dir') . 'temp/' . random_string('alnum', 32) . '.tmp';

        if ($fpOut = fopen($temp_file, 'w')) {
            // Put the initialzation vector to the beginning of the file
            fwrite($fpOut, $iv);
            if ($fpIn = fopen($file_path, 'rb')) {
                while (!feof($fpIn)) {
                    $plaintext = fread($fpIn, 16 * $blocks);
                    $ciphertext = openssl_encrypt($plaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                    // Use the first 16 bytes of the ciphertext as the next initialization vector
                    $iv = substr($ciphertext, 0, 16);
                    fwrite($fpOut, $ciphertext);
                }
                fclose($fpIn);
            }
            fclose($fpOut);
        }

        if(unlink($file_path)) {
            // Place encrypted version
            if(rename($temp_file, $file_path)) {
                return $gen_key;
            }
        }
    }

    /**
     * Decrypt a file
     *
     * @param $source
     * @param $dest
     * @param $key
     * @return bool
     */
    function decryptFile($source, $dest, $key)
    {
        $key = substr(sha1($key, true), 0, 16);

        $error = false;
        if ($fpOut = fopen($dest, 'w')) {
            if ($fpIn = fopen($source, 'rb')) {
                // Get the initialzation vector from the beginning of the file
                $iv = fread($fpIn, 16);
                while (!feof($fpIn)) {
                    $ciphertext = fread($fpIn, 16 * (10000 + 1)); // we have to read one block more for decrypting than for encrypting
                    $plaintext = openssl_decrypt($ciphertext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                    // Use the first 16 bytes of the ciphertext as the next initialization vector
                    $iv = substr($ciphertext, 0, 16);
                    fwrite($fpOut, $plaintext);
                }
                fclose($fpIn);
            } else {
                $error = true;
            }
            fclose($fpOut);
        } else {
            $error = true;
        }

        return $error ? false : $dest;
    }

    /**
     * Kill the connection with the user, but keep the script running in the background.
     */
    private function killConnection() {
        ignore_user_abort(true);
        ob_start();
        echo "success";
        $size = ob_get_length();
        header("Content-Length: $size");
        header('Connection: close');
        ob_end_flush();
        ob_flush();
        flush();
        if (session_id()) session_write_close();
    }
}