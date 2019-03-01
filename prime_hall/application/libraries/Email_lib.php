<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @package	   Luggage2ship project
 * @category   library
 * @link	   http://luggage2ship.com
 * @autor      Arshak Ghazaryan
 * @name       Email_lib
 * Short description:
 * extended library for sending emails
 *
 * Long description
 * sending emails for confirmation, to admin, etc
 *
 **/
class Email_lib {
    /**
     * Constructor
     *
     *
     * @return none
     *
     * @access public
     *
     *
     */

    private $CI;
    private $from = '';
    private $from_name = '';

    public function __construct() {
        $this->CI =& get_instance();

        // Init models
        $this->CI->load->config('sendgrid_config');
        //$this->CI->load->model('Clients_model');
        //$this->CI->load->model('Email_model');

        // Init vars
        $this->from = $this->CI->config->item('admin_sender_email');
        $this->from_name = $this->CI->config->item('admin_name');
    }

    /**
     * sendEmail: sending email function
     *
     * @param array $data having: email of recipient, subject, message, attachment
     * @access protected
     *
     * @return bool
     *
     */

    public function sendEmail($data) {
        if (empty($data)) {
            return false;
        }

        if(empty($data['from_email'])) {
            $from =  $this->CI->config->item('admin_sender_email');
        } else {
            $from = $data['from_email'];
        }

        if(empty($data['from_name'])) {
            $from_name =  $this->CI->config->item('admin_name');
        } else {
            $from_name = $data['from_name'];
        }

        $this->CI->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->from($from, $from_name);
        $this->email->to($data['email']);
        $this->email->subject($data['subject']);
        $this->email->message($data['message']);//message provided by specific methods

        if(!empty($data['attachment'])){
            $this->email->attach($data['attachment']);
        }

        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    } // End of function sendEmail

    public function sendgrid_email($data) {
        if (empty($data)) {
            return false;
        }

        include(APPPATH.'libraries/ext/sendgrid/vendor/autoload.php');

        // CI_Loader instance
        $ci = get_instance();
        $ci->load->config('config');
        $apiKey = $ci->config->item('Sendgrid_Key');

        if(empty($apiKey)) {
            return false;
        }

        if(empty($data['from_email'])) {
            $from =  $ci->config->item('admin_sender_email');
        } else {
            $from = $data['from_email'];
        }

        if(empty($data['from_name'])) {
            $from_name =  $ci->config->item('admin_name');
        } else {
            $from_name = $data['from_name'];
        }

        if(empty($data['to_name'])) {
            $to_name =  $ci->config->item('to_name');
        } else {
            $to_name = $data['to_name'];
        }

        $to = new SendGrid\Email($from_name, $from);
        $subject = $data['subject'];
        $from = new SendGrid\Email($to_name, $data['email']);

        $content = new SendGrid\Content("text/html", $data['message']);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);

        if(!empty($data['attachment'])) {

            foreach($data['attachment'] as $val) {

                if(file_exists($val) && is_file($val)) {

                    $file_content = file_get_contents($val);
                    $attachment = new SendGrid\Attachment();
                    $attachment->setContent(base64_encode($file_content));

                    if(function_exists('mime_content_type')) {
                        $attachment->setType(mime_content_type($val));
                    } else {
                        $attachment->setType($this->_mime_content_type($val));
                    }

                    $attachment->setFilename(basename($val));
                    $attachment->setDisposition("attachment");
                    $attachment->setContentId(uniqid('att_'));
                    $mail->addAttachment($attachment);
                }
            }
        }

        $sg = new \SendGrid($apiKey);

        $response = $sg->client->mail()->send()->post($mail);
        /*
        echo $response->statusCode();
        echo $response->headers();
        echo $response->body();*/
        return $response;
    }

    function _mime_content_type($filename) {
        $idx = explode( '.', $filename );
        $count_explode = count($idx);
        $idx = strtolower($idx[$count_explode-1]);

        $mimet = array(
            'ai' =>'application/postscript',
            'aif' =>'audio/x-aiff',
            'aifc' =>'audio/x-aiff',
            'aiff' =>'audio/x-aiff',
            'asc' =>'text/plain',
            'atom' =>'application/atom+xml',
            'avi' =>'video/x-msvideo',
            'bcpio' =>'application/x-bcpio',
            'bmp' =>'image/bmp',
            'cdf' =>'application/x-netcdf',
            'cgm' =>'image/cgm',
            'cpio' =>'application/x-cpio',
            'cpt' =>'application/mac-compactpro',
            'crl' =>'application/x-pkcs7-crl',
            'crt' =>'application/x-x509-ca-cert',
            'csh' =>'application/x-csh',
            'css' =>'text/css',
            'dcr' =>'application/x-director',
            'dir' =>'application/x-director',
            'djv' =>'image/vnd.djvu',
            'djvu' =>'image/vnd.djvu',
            'doc' =>'application/msword',
            'dtd' =>'application/xml-dtd',
            'dvi' =>'application/x-dvi',
            'dxr' =>'application/x-director',
            'eps' =>'application/postscript',
            'etx' =>'text/x-setext',
            'ez' =>'application/andrew-inset',
            'gif' =>'image/gif',
            'gram' =>'application/srgs',
            'grxml' =>'application/srgs+xml',
            'gtar' =>'application/x-gtar',
            'hdf' =>'application/x-hdf',
            'hqx' =>'application/mac-binhex40',
            'html' =>'text/html',
            'html' =>'text/html',
            'ice' =>'x-conference/x-cooltalk',
            'ico' =>'image/x-icon',
            'ics' =>'text/calendar',
            'ief' =>'image/ief',
            'ifb' =>'text/calendar',
            'iges' =>'model/iges',
            'igs' =>'model/iges',
            'jpe' =>'image/jpeg',
            'jpeg' =>'image/jpeg',
            'jpg' =>'image/jpeg',
            'js' =>'application/x-javascript',
            'kar' =>'audio/midi',
            'latex' =>'application/x-latex',
            'm3u' =>'audio/x-mpegurl',
            'man' =>'application/x-troff-man',
            'mathml' =>'application/mathml+xml',
            'me' =>'application/x-troff-me',
            'mesh' =>'model/mesh',
            'mid' =>'audio/midi',
            'midi' =>'audio/midi',
            'mif' =>'application/vnd.mif',
            'mov' =>'video/quicktime',
            'movie' =>'video/x-sgi-movie',
            'mp2' =>'audio/mpeg',
            'mp3' =>'audio/mpeg',
            'mpe' =>'video/mpeg',
            'mpeg' =>'video/mpeg',
            'mpg' =>'video/mpeg',
            'mpga' =>'audio/mpeg',
            'ms' =>'application/x-troff-ms',
            'msh' =>'model/mesh',
            'mxu m4u' =>'video/vnd.mpegurl',
            'nc' =>'application/x-netcdf',
            'oda' =>'application/oda',
            'ogg' =>'application/ogg',
            'pbm' =>'image/x-portable-bitmap',
            'pdb' =>'chemical/x-pdb',
            'pdf' =>'application/pdf',
            'pgm' =>'image/x-portable-graymap',
            'pgn' =>'application/x-chess-pgn',
            'php' =>'application/x-httpd-php',
            'php4' =>'application/x-httpd-php',
            'php3' =>'application/x-httpd-php',
            'phtml' =>'application/x-httpd-php',
            'phps' =>'application/x-httpd-php-source',
            'png' =>'image/png',
            'pnm' =>'image/x-portable-anymap',
            'ppm' =>'image/x-portable-pixmap',
            'ppt' =>'application/vnd.ms-powerpoint',
            'ps' =>'application/postscript',
            'qt' =>'video/quicktime',
            'ra' =>'audio/x-pn-realaudio',
            'ram' =>'audio/x-pn-realaudio',
            'ras' =>'image/x-cmu-raster',
            'rdf' =>'application/rdf+xml',
            'rgb' =>'image/x-rgb',
            'rm' =>'application/vnd.rn-realmedia',
            'roff' =>'application/x-troff',
            'rtf' =>'text/rtf',
            'rtx' =>'text/richtext',
            'sgm' =>'text/sgml',
            'sgml' =>'text/sgml',
            'sh' =>'application/x-sh',
            'shar' =>'application/x-shar',
            'shtml' =>'text/html',
            'silo' =>'model/mesh',
            'sit' =>'application/x-stuffit',
            'skd' =>'application/x-koan',
            'skm' =>'application/x-koan',
            'skp' =>'application/x-koan',
            'skt' =>'application/x-koan',
            'smi' =>'application/smil',
            'smil' =>'application/smil',
            'snd' =>'audio/basic',
            'spl' =>'application/x-futuresplash',
            'src' =>'application/x-wais-source',
            'sv4cpio' =>'application/x-sv4cpio',
            'sv4crc' =>'application/x-sv4crc',
            'svg' =>'image/svg+xml',
            'swf' =>'application/x-shockwave-flash',
            't' =>'application/x-troff',
            'tar' =>'application/x-tar',
            'tcl' =>'application/x-tcl',
            'tex' =>'application/x-tex',
            'texi' =>'application/x-texinfo',
            'texinfo' =>'application/x-texinfo',
            'tgz' =>'application/x-tar',
            'tif' =>'image/tiff',
            'tiff' =>'image/tiff',
            'tr' =>'application/x-troff',
            'tsv' =>'text/tab-separated-values',
            'txt' =>'text/plain',
            'ustar' =>'application/x-ustar',
            'vcd' =>'application/x-cdlink',
            'vrml' =>'model/vrml',
            'vxml' =>'application/voicexml+xml',
            'wav' =>'audio/x-wav',
            'wbmp' =>'image/vnd.wap.wbmp',
            'wbxml' =>'application/vnd.wap.wbxml',
            'wml' =>'text/vnd.wap.wml',
            'wmlc' =>'application/vnd.wap.wmlc',
            'wmlc' =>'application/vnd.wap.wmlc',
            'wmls' =>'text/vnd.wap.wmlscript',
            'wmlsc' =>'application/vnd.wap.wmlscriptc',
            'wmlsc' =>'application/vnd.wap.wmlscriptc',
            'wrl' =>'model/vrml',
            'xbm' =>'image/x-xbitmap',
            'xht' =>'application/xhtml+xml',
            'xhtml' =>'application/xhtml+xml',
            'xls' =>'application/vnd.ms-excel',
            'xml xsl' =>'application/xml',
            'xpm' =>'image/x-xpixmap',
            'xslt' =>'application/xslt+xml',
            'xul' =>'application/vnd.mozilla.xul+xml',
            'xwd' =>'image/x-xwindowdump',
            'xyz' =>'chemical/x-xyz',
            'zip' =>'application/zip'
        );

        if (isset( $mimet[$idx] )) {
            return $mimet[$idx];
        } else {
            return 'application/octet-stream';
        }
    }
} // end of lib

/* End of file My_Email.php */
