<?php
namespace Shel\Blog\Fusion\Helper;

/*                                                                        *
 * This script belongs to the Flow package "Shel.Blog".                   *
 *                                                                        *
 * @author Sebastian Helzle <sebastian@helzle.it>                         *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Media\Domain\Model\AssetInterface;
use Neos\Media\Domain\Model\ImageInterface;
use Neos\Media\Domain\Model\ThumbnailConfiguration;
use Neos\Media\Domain\Service\ThumbnailService;

class AssetHelper implements ProtectedContextAwareInterface
{
    /**
     * @Flow\Inject
     * @var ThumbnailService
     */
    protected $thumbnailService;

    /**
     * @param AssetInterface $asset
     * @param integer $width Desired width of the image
     * @param integer $maximumWidth Desired maximum width of the image
     * @param integer $height Desired height of the image
     * @param integer $maximumHeight Desired maximum height of the image
     * @param boolean $allowCropping Whether the image should be cropped if the given sizes would hurt the aspect ratio
     * @param boolean $allowUpScaling Whether the resulting image size might exceed the size of the original image
     * @return null|ImageInterface
     * @throws \Exception
     */
    public function createThumbnail(
        AssetInterface $asset,
        $width = null,
        $maximumWidth = null,
        $height = null,
        $maximumHeight = null,
        $allowCropping = false,
        $allowUpScaling = false
    )
    {
        $thumbnailConfiguration = new ThumbnailConfiguration(
            $width,
            $maximumWidth,
            $height,
            $maximumHeight,
            $allowCropping,
            $allowUpScaling
        );
        $thumbnailImage = $this->thumbnailService->getThumbnail($asset, $thumbnailConfiguration);
        if (!$thumbnailImage instanceof ImageInterface) {
            return null;
        }
        return $thumbnailImage;
    }

    /**
     * All methods are considered safe
     *
     * @param string $methodName
     * @return boolean
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
