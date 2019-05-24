<?php
/**
 * Upload ViewHelper
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\ViewHelpers\Form;

use \TYPO3\CMS\Fluid\ViewHelpers\Form\UploadViewHelper as FluidUploadViewHelper;
use \TYPO3\CMS\Extbase\Security\Cryptography\HashService;
use \TYPO3\CMS\Extbase\Property\PropertyMapper;
use \TYPO3\CMS\Extbase\Domain\Model\FileReference;

/**
 * Upload ViewHelper class
 */
class UploadViewHelper extends FluidUploadViewHelper
{
    /**
     * Hash service class
     *
     * @var HashService
     */
    protected $hashService;

    /**
     * Property Mapper class
     *
     * @var PropertyMapper
     */
    protected $propertyMapper;

    /**
     * Hash service class
     *
     * @param HashService $hashService
     */
    public function injectHashService(HashService $hashService): void
    {
        $this->hashService = $hashService;
    }

    /**
     * Property Mapper class
     *
     * @param PropertyMapper $propertyMapper
     */
    public function injectPropertyMapper(PropertyMapper $propertyMapper): void
    {
        $this->propertyMapper = $propertyMapper;
    }

    /**
     * Render the upload field including possible resource pointer
     *
     * @return string
     */
    public function render(): string
    {
        $output = '';

        $resource = $this->getUploadedResource();
        if ($resource !== null) {
            $resourcePointerIdAttribute = '';
            if ($this->hasArgument('id')) {
                $resourcePointerIdAttribute = ' id="' . htmlspecialchars($this->arguments['id']) . '-file-reference"';
            }
            $resourcePointerValue = $resource->getUid();
            if ($resourcePointerValue === null) {
                // Newly created file reference which is not persisted yet.
                // Use the file UID instead, but prefix it with "file:" to communicate this to the type converter
                $resourcePointerValue = 'file:' . $resource->getOriginalResource()->getOriginalFile()->getUid();
            }

            $attributes = [
                'class="file-upload"',
                'type="hidden"',
                'name="' . $this->getName() . '[submittedFile][resourcePointer]"',
                'value="' . htmlspecialchars($this->hashService->appendHmac((string)$resourcePointerValue)) . '"',
                $resourcePointerIdAttribute
            ];

            $output .= '<input ' . implode(' ', $attributes) . ' />';

            $this->templateVariableContainer->add('resource', $resource);
            $output .= $this->renderChildren();
            $this->templateVariableContainer->remove('resource');
        }

        $output .= parent::render();
        return $output;
    }

    /**
     * Return a previously uploaded resource.
     * Return NULL if errors occurred during property mapping for this property.
     *
     * @return FileReference|null
     */
    protected function getUploadedResource()
    {
        if ($this->getMappingResultsForProperty()->hasErrors()) {
            return null;
        }
        $resource = $this->getValueAttribute();
        if ($resource instanceof FileReference) {
            return $resource;
        }
        return $this->propertyMapper->convert($resource, FileReference::class);
    }
}
