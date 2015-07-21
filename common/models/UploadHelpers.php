<?php

namespace common\models;

use yii\web\UploadedFile;

/**
 * add in the models beforeSave function 
 * $oldFileName = $this->$property;               
 * \common\models\UploadHelpers::saveFile( $this, $property, $oldFileName, $folderPath );
 * ----------------------------------------
 * add in update action in the controllers
 * $oldFile = $model->$property;        
 *  if ( $model->load(Yii::$app->request->post()) ) {
 *  //because after load function $model->$property = ""
 *  $model->$property = $oldFile;          
 *  $model->save();
 * ----------------------------------------
 * add in delete controller action
 * \common\models\UploadHelpers::deleteFile($model->$property, $folderPath);
 * $model->delete();
 */
class UploadHelpers
{
    
    /**
     * @param string $fileName
     * @param string $folderPath
     */
    public static function deleteFile( $fileName, $folderPath ) 
    {
        if( file_exists($folderPath.'/'.$fileName) && $fileName != "" ){         
          unlink( $folderPath.'/'.$fileName );
        }        
    }
    
    /**
     * 
     * @param \yii\db\ActiveRecord $model
     * @param string $property 
     * (model class property that keeps the saved file)
     * @param string $oldFileName
     * @param string $folderPath
     */
    public static function saveFile( $model, $property, $oldFileName, $folderPath )
    {
        $model->$property = UploadedFile::getInstance($model, $property);
        //returns Null if nothing uploaded        
        if ($model->$property !== NULL) {          
            $newName = self::changeName($model->$property, $folderPath);
            self::saveNewDeleteOld($model, $property, $newName, $oldFileName, $folderPath);        
        }else{
            $model->$property = $oldFileName;
            /* for example when updated 
             * one desn't choose any file to upload
             * so $model->$property becomes Null
             */
        }
    }
    
    /** 
     * @param \yii\db\ActiveRecord $model
     * @param string $property 
     * (model class property that keeps the saved file)
     * @param string $newFileName
     * @param string $oldFileName
     * @param string $folderPath
     */
    private static function saveNewDeleteOld($model, $property, $newFileName, $oldFileName, $folderPath)
    {
         if( $model->$property->saveAs( $folderPath.'/'.$newFileName) ){
              $model->$property->name = $newFileName;
              self::deleteFile( $oldFileName, $folderPath );    
         }else{
              die("Failed to upload: upload_max_filesize=4M ! you can change the ini configuration");
         }        
    }

    /**
     * file name is chosen like in Windows, while uploading,
     * to avoid overwriting files with similar names.
     * any characters except A-Za-z0-9.() in the name of file
     * are dropped out.
     * @param string $name 
     * @param string $folderPath
     * @return string
     */
    private static function changeName($name, $folderPath)
    {
        $changedName = preg_replace("/[^A-Za-z0-9.()]/", "", $name);
        
        $dotExtension = strrchr($changedName, ".");
        $base = basename($changedName, $dotExtension);        
        
        $parenthesis = strrchr($base, "(");
        
        if(   $parenthesis && ctype_digit(  substr( $parenthesis, 1, strlen($parenthesis)-2 )  )   )
        {
            $base = basename( $base , $parenthesis );
            $changedName=$base.$dotExtension;
        }
        if(file_exists($folderPath.'/'.$changedName)){
           
            $changedName=$base."(1)".$dotExtension;
        }
        while( file_exists($folderPath.'/'.$changedName) )
        {
            $n = (string)( (int)substr($changedName, strlen($base)+1, strlen($changedName)-strlen($base)- strlen($dotExtension)-2 ) + 1 );            
            $changedName=$base."(".$n.")".$dotExtension;
        }     
      
        return $changedName;
    }

}