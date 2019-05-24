<?php
/**
 * Uploaded File Reference Converter
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Property\TypeConverter;

use TYPO3\CMS\Core\Resource\DuplicationBehavior;
use TYPO3\CMS\Core\Resource\Exception\ExistingTargetFileNameException;
use TYPO3\CMS\Core\Resource\File as FalFile;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FileReference as FalFileReference;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Domain\Model\AbstractFileFolder;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Error\Error;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Property\Exception\TypeConverterException;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface;
use TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter;
use TYPO3\CMS\Extbase\Security\Cryptography\HashService;

/**
 * Class UploadedFileReferenceConverter
 */
class UploadedFileReferenceConverter extends AbstractTypeConverter
{
    /**
     * Folder where the file upload should go to (including storage).
     */
    const CONFIGURATION_UPLOAD_FOLDER = 1;

    /**
     * How to handle a upload when the name of the uploaded file conflicts.
     */
    const CONFIGURATION_UPLOAD_CONFLICT_MODE = 2;

    /**
     * Whether to replace an already present resource.
     * Useful for "maxitems = 1" fields and properties
     * with no ObjectStorage annotation.
     */
    const CONFIGURATION_ALLOWED_FILE_EXTENSIONS = 4;

    /**
     * If not specified otherwise, files are stored in the default upload folder
     *
     * @var string
     */
    protected $defaultUploadFolder = '1:/user_upload/';

    /**
     * Source types
     *
     * @var array<string>
     */
    protected $sourceTypes = ['array'];

    /**
     * Target type
     *
     * @var string
     */
    protected $targetType = FileReference::class;

    /**
     * Take precedence over the available FileReferenceConverter
     *
     * @var int
     */
    protected $priority = 30;

    /**
     * Resource factory class
     *
     * @var ResourceFactory
     */
    protected $resourceFactory;

    /**
     * Hash service class
     *
     * @var HashService
     */
    protected $hashService;

    /**
     * Persistence Manager class
     *
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * Import resource factory class by dependency injection
     *
     * @param ResourceFactory $resourceFactory
     */
    public function injectResourceFactory(ResourceFactory $resourceFactory): void
    {
        $this->resourceFactory = $resourceFactory;
    }

    /**
     * Import hash service class by dependency injection
     *
     * @param HashService $hashService
     */
    public function injectHashService(HashService $hashService): void
    {
        $this->hashService = $hashService;
    }

    /**
     * Import Persistence Manager class by dependency injection
     *
     * @param PersistenceManager $persistenceManager
     */
    public function injectPersistenceManager(PersistenceManager $persistenceManager): void
    {
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * File interface
     *
     * @var FileInterface[]
     */
    protected $convertedResources = [];

    /**
     * Actually convert from $source to $targetType, taking into account the fully
     * built $convertedChildProperties and $configuration.
     *
     * @param string|int $source
     * @param string $targetType
     * @param array $convertedChildProperties
     * @param PropertyMappingConfigurationInterface $configuration
     * @throws \TYPO3\CMS\Extbase\Property\Exception
     * @return AbstractFileFolder
     */
    public function convertFrom(
        $source,
        $targetType,
        array $convertedChildProperties = [],
        PropertyMappingConfigurationInterface $configuration = null
    ) {
        if (!isset($source['error']) || $source['error'] === \UPLOAD_ERR_NO_FILE) {
            if (isset($source['submittedFile']['resourcePointer'])) {
                try {
                    $resourcePointer = $this->hashService->validateAndStripHmac(
                        $source['submittedFile']['resourcePointer']
                    );
                    if (strpos($resourcePointer, 'file:') === 0) {
                        $fileUid = substr($resourcePointer, 5);
                        return $this->createFileReferenceFromFalFileObject(
                            $this->resourceFactory->getFileObject($fileUid)
                        );
                    } else {
                        return $this->createFileReferenceFromFalFileReferenceObject(
                            $this->resourceFactory->getFileReferenceObject($resourcePointer),
                            $resourcePointer
                        );
                    }
                } catch (\InvalidArgumentException $e) {
                    // No file has been uploaded and resource pointer is invalid. Ignore.
                }
            }
            return null;
        }

        if ($source['error'] !== \UPLOAD_ERR_OK) {
            switch ($source['error']) {
                case \UPLOAD_ERR_INI_SIZE:
                case \UPLOAD_ERR_FORM_SIZE:
                case \UPLOAD_ERR_PARTIAL:
                    return new Error('Error Code: ' . $source['error'], 1264440823);
                default:
                    return new Error('An error occurred while uploading.', 1340193849);
            }
        }

        if (isset($this->convertedResources[$source['tmp_name']])) {
            return $this->convertedResources[$source['tmp_name']];
        }

        try {
            $resource = $this->importUploadedResource($source, $configuration);
        } catch (\Exception $e) {
            return new Error($e->getMessage(), $e->getCode());
        }

        $this->convertedResources[$source['tmp_name']] = $resource;
        return $resource;
    }

    /**
     * Import a resource and respect configuration given for properties
     *
     * @param array $uploadInfo
     * @param PropertyMappingConfigurationInterface $configuration
     * @return FileReference
     * @throws TypeConverterException
     * @throws ExistingTargetFileNameException
     */
    protected function importUploadedResource(array $uploadInfo, PropertyMappingConfigurationInterface $configuration)
    {
        if (!GeneralUtility::verifyFilenameAgainstDenyPattern($uploadInfo['name'])) {
            throw new TypeConverterException('Uploading files with PHP file extensions is not allowed!', 1399312430);
        }

        $allowedFileExtensions = $configuration->getConfigurationValue(
            self::class,
            self::CONFIGURATION_ALLOWED_FILE_EXTENSIONS
        );

        if ($allowedFileExtensions !== null) {
            $filePathInfo = PathUtility::pathinfo($uploadInfo['name']);
            if (!GeneralUtility::inList($allowedFileExtensions, strtolower($filePathInfo['extension']))) {
                throw new TypeConverterException('File extension is not allowed!', 1399312430);
            }
        }

        $uploadFolderId = $configuration->getConfigurationValue(
            self::class,
            self::CONFIGURATION_UPLOAD_FOLDER
        ) ?: $this->defaultUploadFolder;

        $conflictMode = $configuration->getConfigurationValue(
            self::class,
            self::CONFIGURATION_UPLOAD_CONFLICT_MODE
        ) ?: DuplicationBehavior::RENAME;

        $uploadFolder = $this->resourceFactory->retrieveFileOrFolderObject($uploadFolderId);
        $uploadedFile =  $uploadFolder->addUploadedFile($uploadInfo, $conflictMode);

        $resourcePointer = null; // init
        if (isset($uploadInfo['submittedFile']['resourcePointer'])
        && strpos($uploadInfo['submittedFile']['resourcePointer'], 'file:') === false) {
            $resourcePointer = $uploadInfo['submittedFile']['resourcePointer'];
            $resourcePointer = $this->hashService->validateAndStripHmac($resourcePointer);
        }

        $fileReferenceModel = $this->createFileReferenceFromFalFileObject($uploadedFile, $resourcePointer);

        return $fileReferenceModel;
    }

    /**
     * Create file reference from FAL file object
     *
     * @param FalFile $file
     * @param int $resourcePointer
     * @return FileReference
     */
    protected function createFileReferenceFromFalFileObject(FalFile $file, $resourcePointer = null)
    {
        $fileReference = $this->resourceFactory->createFileReferenceObject(
            [
                'uid_local' => $file->getUid(),
                'uid_foreign' => uniqid('NEW_'),
                'uid' => uniqid('NEW_'),
                'crop' => null,
            ]
        );
        return $this->createFileReferenceFromFalFileReferenceObject($fileReference, $resourcePointer);
    }

    /**
     * Create file reference from FAL file reference object
     *
     * @param FalFileReference $falFileReference
     * @param int $resourcePointer
     * @return FileReference
     */
    protected function createFileReferenceFromFalFileReferenceObject(
        FalFileReference $falFileReference,
        $resourcePointer = null
    ) {
        if ($resourcePointer === null) {
            /** @var $fileReference FileReference */
            $fileReference = $this->objectManager->get(FileReference::class);
        } else {
            $fileReference = $this->persistenceManager->getObjectByIdentifier(
                $resourcePointer,
                FileReference::class,
                false
            );
        }
        $fileReference->setOriginalResource($falFileReference);
        return $fileReference;
    }
}
