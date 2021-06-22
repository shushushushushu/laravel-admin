<?php

namespace Encore\Admin\Form\Field;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Image extends File
{
    use ImageField;

    /**
     * {@inheritdoc}
     */
    protected $view = 'admin::form.file';

    /**
     *  Validation rules.
     *
     * @var string
     */
    protected $rules = 'image';

    /**
     * @param array|UploadedFile $image
     *
     * @return string
     */
    public function prepare($image)
    {
        if ($this->picker) {
            return parent::prepare($image);
        }

        if (request()->has(static::FILE_DELETE_FLAG)) {
            return $this->destroy();
        }

        $this->name = $this->getStoreName($image);

        $this->callInterventionMethods($image->getRealPath());

        $path = $this->uploadAndDeleteOriginal($image);

        $this->uploadAndDeleteOriginalThumbnail($image);
        
        if(isset(config('filesystems.disks.' . config('filesystems.default'))['remote_url'])){
            $remoteUrl = config('filesystems.disks.' . config('filesystems.default'))['remote_url'];
            $path = rtrim($remoteUrl, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $path;
        }

        return $path;
    }

    /**
     * force file type to image.
     *
     * @param $file
     *
     * @return array|bool|int[]|string[]
     */
    public function guessPreviewType($file)
    {
        $extra = parent::guessPreviewType($file);
        $extra['type'] = 'image';

        return $extra;
    }
}
