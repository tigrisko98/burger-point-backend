<?php

namespace admin\components\s3;

use Yii;
use yii\web\UploadedFile;

/**
 * @property-read string $fileUrl
 */
trait S3MediaTrait
{
    /**
     * @return Module
     */
    public function getS3Component()
    {
        return Yii::$app->get('s3');
    }

    /**
     * Save UploadedFile to AWS S3.
     * Important: This function uploads this model filename to keep consistency of the model.
     *
     * @param \yii\web\UploadedFile $file Uploaded file to save
     * @param string $attribute Attribute name where the uploaded filename name will be saved
     * @param string $fileName Name which file will be saved. If empty will use the name from $file
     * @param bool $updateExtension TRUE to automatically append the extension to the file name. Default is TRUE
     *
     * @return string|false Uploaded filename on success or FALSE in failure.
     */
    public function saveUploadedFile(UploadedFile $file,$attribute, $fileName='', $updateExtension = true)
    {
        if ( $this->hasErrors() && ! $file instanceof UploadedFile ) {
            return false;
        }

        // Update filename
        if ( empty( $fileName ) ) {
            $fileName = $file->name;
        }

        if ( $updateExtension ) {
            $fileName .= '.' . $file->extension;
        }

        /** @var \Aws\ResultInterface $result */
        $commands = $this->getS3Component()
            ->commands()
            ->upload(
                $this->getAttributePath( $attribute ) . $fileName,
                $file->tempName
            )
            ->withContentType( $file->type )
            ->withAcl( 'public-read' )
            ->execute();

        // Validate successful upload to S3
//        if ( $this->isSuccessResponseStatus( $result ) ) {
//            $this->{$attribute} = $fileName;
//            return $fileName;
//        }

        return false;
    }

    /**
     * Delete model file attribute from AWS S3.
     *
     * @param string $attribute Atribute name which holds the filename
     *
     * @return bool TRUE on success or if file doesn't exist.
     */
    public function removeFile($attribute, $fileName)
    {
        if ( empty( $fileName ) ) {
            // No file to remove
            return true;
        }

        $file = $this->getAttributePath( $attribute ) . $fileName;
        $result = $this->getS3Component()
            ->commands()
            ->delete( $file )
            ->execute();

        // Validate successful removal from S3
//        if ( $this->isSuccessResponseStatus( $result ) ) {
//            $this->{$attribute} = null;
//            return true;
//        }

        return false;
    }

    /**
     * Retrieves the URL for a given model file attribute.
     *
     * @param string $attribute Atribute name which holds the filename
     *
     * @return string URL to access file
     */
    public function getFileUrl($filename, $folder)
    {
        if ( empty( $filename ) ) {
            return '';
        }

        return $this->getS3Component()->getUrl( $folder . $filename );
    }

    /**
     * Retrieves the presigned URL for a given model file attribute.
     *
     * @param string $attribute Atribute name which holds the filename
     *
     * @return string Presigned URL to access file
     */
    public function getFilePresignedUrl($attribute)
    {
        if ( empty( $this->{$attribute} ) ) {
            return '';
        }

        return $this->getS3Component()->getPresignedUrl(
            $this->getAttributePath( $attribute ) . $this->{$attribute},
            $this->getPresignedUrlDuration()
        );
    }


    /**
     * Retrieves the URL signature expiration.
     *
     * @return mixed URL expiration
     */
    protected function getPresignedUrlDuration()
    {
        return '+1 day';
    }

    /**
     * Retrieves the base path on AWS S3 for a given attribute.
     * @see attributePaths()
     *
     * @param string $attribute Attribute to get its path
     *
     * @return string The path where all file of that attribute should be stored. Returns empty string if the attribute isn't in the list.
     */
    protected function getAttributePath($attribute)
    {
        $paths = $this->attributePaths();

        if ( array_key_exists( $attribute, $paths ) ) {
            return $paths[$attribute];
        }

        return '';
    }

    /**
     * List the paths on AWS S3 to each model file attribute.
     * It must be a Key-Value array, where Key is the attribute name and Value is the base path for the file in S3.
     * Override this method for saving each attribute in its own "folder".
     *
     * @return array Key-Value of attributes and its paths.
     */
    protected function attributePaths()
    {
        return [];
    }

    /**
     * Check for valid status code from the AWS S3 response.
     * Success responses will be considered status codes between 200 and 204.
     * Override function for custom validations.
     *
     * @param \Aws\ResultInterface $response AWS S3 response containing the status code
     *
     * @return bool TRUE on success status.
     */
    protected function isSuccessResponseStatus($response)
    {
        return ! empty( $response->get('@metadata')['statusCode'] ) &&
            $response->get('@metadata')['statusCode'] >= 200 &&
            $response->get('@metadata')['statusCode'] <= 204;
    }
}
