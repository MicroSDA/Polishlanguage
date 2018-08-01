<?php
/**
 * Created by PhpStorm.
 * User: Ro
 * Date: 6/4/2018
 * Time: 14:51
 */

class FileUpload
{

    /**
     * @var null
     */
    private $FILE_NAME = NULL;

    /**
     * @return null
     */
    public function getFILENAME()
    {
        return $this->FILE_NAME;
    }
    /**
     * @var null
     */
    private $FILE_MASK = NULL;
    /**
     * @var null
     */
    private $FILE_PATH = NULL;
    /**
     * @var array
     */
    private $FILE_TYPE = [];
    /**
     * @var null
     */
    private $FILE_SIZE = NULL;

    /**
     * FileUpload constructor.
     */
    public function __construct()
   {


   }


    /**
     * @param $FILE_MASK
     * @param $FILE_PATH
     * @param array $FILE_TYPE
     * @param int $FILE_SIZE
     * @return bool
     */
    public function upload($FILE_MASK, $FILE_PATH, $FILE_TYPE = [], $FILE_SIZE = 100000){

       try{

           if(empty($FILE_MASK) or empty($FILE_PATH) or empty($FILE_TYPE)){

               die;
               throw new RuntimeException('Invalid income parameters !, File Mask ='.
                   $FILE_MASK.', File Path ='.
                   $FILE_PATH.', File Type ='. arrayPrint($FILE_TYPE));

           }else{

               /**
                * Set income parameters
                */
               $this->FILE_NAME = $_FILES[$FILE_MASK]['name'];
               $this->FILE_MASK = $FILE_MASK;
               $this->FILE_PATH = $FILE_PATH;
               $this->FILE_TYPE = $FILE_TYPE;
               $this->FILE_SIZE = $FILE_SIZE;

               /**
                * -----------------------
                */

               /**
                * Check if file has some errors
                */

               switch ($_FILES[$this->FILE_MASK]['error']) {
                   case UPLOAD_ERR_OK:
                       break;
                   case UPLOAD_ERR_NO_FILE:
                       throw new RuntimeException('File hasn\'t been sent');
                   case UPLOAD_ERR_INI_SIZE:
                       break;
                   case UPLOAD_ERR_FORM_SIZE:
                       throw new RuntimeException('Превышен размер файла');
                   default:
                       throw new RuntimeException('Unknown errors.');
               }

               /**
                * -----------------------
                */

               /**
                * Check if file size
                */

               if ($_FILES[$this->FILE_MASK]['size'] > $this->FILE_SIZE) {
                   throw new RuntimeException('Превышен размер файла');
               }

               /**
                * -----------------------
                */

               /**
                * Check file format
                * Example : array(pdf' => 'application/pdf');
                */
               $file_type = new finfo(FILEINFO_MIME_TYPE);
               if (false === $ext = array_search(
                       $file_type->file($_FILES[$this->FILE_MASK]['tmp_name']),
                       $this->FILE_TYPE,
                       true
                   )) {
                   throw new RuntimeException('Invalid file format.');
               }

               /**
                * -----------------------
                */

               /**
                * Save file
                */
               if (!move_uploaded_file($_FILES[$this->FILE_MASK]['tmp_name'], sprintf($this->FILE_PATH.'%s',$_FILES[$this->FILE_MASK]['name']))) {
                   die;
                   throw new RuntimeException('Failed during move uploaded file.');

               }else{

                   return true;
               }

           }

       }catch (RuntimeException $exception){

           echo '<div style="text-align: center"><span class="btn btn-warning">'.$exception->getMessage().'</span></div>.';
           die();
       }

   }
}
