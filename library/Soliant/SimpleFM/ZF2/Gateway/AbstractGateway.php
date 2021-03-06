<?php
/**
 * This source file is subject to the MIT license that is bundled with this package in the file LICENSE.txt.
 *
 * @package   Soliant\SimpleFM\ZF2
 * @copyright Copyright (c) 2007-2016 Soliant Consulting, Inc. (http://www.soliantconsulting.com)
 * @author    jsmall@soliantconsulting.com
 */

namespace Soliant\SimpleFM\ZF2\Gateway;

use Doctrine\Common\Collections\ArrayCollection;
use Soliant\SimpleFM\Adapter as SimpleFMAdapter;
use Soliant\SimpleFM\Exception\ErrorException;
use Soliant\SimpleFM\Exception\FileMakerException;
use Soliant\SimpleFM\Exception\HttpException;
use Soliant\SimpleFM\Exception\XmlException;
use Soliant\SimpleFM\Result\AbstractResult;
use Soliant\SimpleFM\Result\FmResultSet;
use Soliant\SimpleFM\ZF2\Authentication\Mapper\Identity;
use Soliant\SimpleFM\ZF2\Entity\AbstractEntity;

abstract class AbstractGateway
{

    /**
     * The fully qualified class name for an object that implements
     * \Soliant\SimpleFM\ZF2\Entity\AbstractEntity
     *
     * @var string
     */
    protected $entityName;

    /**
     * The FileMaker Layout assigned to the $entityPointerName
     *
     * @var string
     */
    protected $entityLayout;

    /**
     * @var \Soliant\SimpleFM\Adapter
     */
    protected $simpleFMAdapter;

    /**
     * @param AbstractEntity $entity
     * @param SimpleFMAdapter $simpleFMAdapter
     * @param Identity $identity
     * @param null $encryptionKey
     */
    public function __construct(
        AbstractEntity $entity,
        SimpleFMAdapter $simpleFMAdapter,
        Identity $identity = null,
        $encryptionKey = null
    ) {
        $this->setSimpleFMAdapter($simpleFMAdapter);
        $this->setEntityName(get_class($entity));
        $this->setEntityLayout($entity->getDefaultWriteLayoutName());

        if (!empty($identity) && !empty($encryptionKey)) {
            $this->simpleFMAdapter->getHostConnection()->setUsername($identity->getUsername());
            $this->simpleFMAdapter->getHostConnection()->setPassword($identity->getPassword($encryptionKey));
        }

    }

    /**
     * @param AbstractEntity $entity
     * @param string|null $entityLayout
     * @return AbstractEntity
     */
    public function resolveEntity(AbstractEntity $entity, $entityLayout = null)
    {
        if (!empty($entityLayout)) {
            $this->setEntityLayout($entityLayout);
        }
        return $this->find($entity->getRecid());
    }

    /**
     * @param int $recid
     * @return AbstractEntity|null
     * @throws ErrorException
     * @throws FileMakerException
     * @throws HttpException
     * @throws XmlException
     */
    public function find($recid)
    {
        $commandArray = ['-recid' => $recid, '-find' => null];
        $this->simpleFMAdapter
            ->setCommandArray($commandArray)
            ->setLayoutName($this->getEntityLayout());
        /** @var FmResultSet $result */
        $result = $this->handleAdapterResult($this->simpleFMAdapter->execute());
        $entity = $this->rowToEntity($result->getRows()[0]);
        return $entity;
    }

    /**
     * @param array $search
     * @return AbstractEntity|null
     * @throws ErrorException
     * @throws FileMakerException
     * @throws HttpException
     * @throws XmlException
     */
    public function findOneBy(array $search)
    {
        foreach ($search as $field => $value) {
            $search[$field] = str_replace('@', '\@', $value);
        }

        $commandArray = array_merge(
            $search,
            [
                '-max' => '1',
                '-find' => null,
            ]
        );

        $this->simpleFMAdapter
            ->setCommandArray($commandArray)
            ->setLayoutName($this->getEntityLayout());
        /** @var FmResultSet $result */
        $result = $this->handleAdapterResult($this->simpleFMAdapter->execute());

        if (isset($result->getRows()[0]) and $result->getRows()[0]) {
            $entity = $this->rowToEntity($result->getRows()[0]);
            return $entity;
        }
        return null;
    }

    /**
     * @param array $sort
     * @param int|null $max
     * @param int|null $skip
     * @return ArrayCollection
     * @throws ErrorException
     * @throws FileMakerException
     * @throws HttpException
     * @throws XmlException
     */
    public function findAll(array $sort = [], $max = null, $skip = null)
    {
        $commandArray = array_merge(
            $this->sortArrayToCommandArray($sort),
            $this->maxSkipToCommandArray($max, $skip),
            ['-findall' => null]
        );
        $this->simpleFMAdapter
            ->setCommandArray($commandArray)
            ->setLayoutName($this->getEntityLayout());
        /** @var FmResultSet $result */
        $result = $this->handleAdapterResult($this->simpleFMAdapter->execute());
        return $this->rowsToArrayCollection($result->getRows());
    }

    /**
     * @param array $search
     * @param array $sort
     * @param int|null $max
     * @param int|null $skip
     * @return ArrayCollection
     * @throws ErrorException
     * @throws FileMakerException
     * @throws HttpException
     * @throws XmlException
     */
    public function findBy(array $search, array $sort = [], $max = null, $skip = null)
    {
        foreach ($search as $field => $value) {
            $search[$field] = str_replace('@', '\@', $value);
        }

        $commandArray = array_merge(
            $search,
            $this->sortArrayToCommandArray($sort),
            $this->maxSkipToCommandArray($max, $skip),
            ['-find' => null]
        );
        $this->simpleFMAdapter
            ->setCommandArray($commandArray)
            ->setLayoutName($this->getEntityLayout());
        /** @var FmResultSet $result */
        $result = $this->handleAdapterResult($this->simpleFMAdapter->execute());
        return $this->rowsToArrayCollection($result->getRows());
    }

    /**
     * @param AbstractEntity $entity
     * @return AbstractEntity
     * @throws ErrorException
     * @throws FileMakerException
     * @throws HttpException
     * @throws XmlException
     */
    public function create(AbstractEntity $entity)
    {
        $serializedValues = $entity->serialize();

        unset($serializedValues['-recid']);
        unset($serializedValues['-modid']);
        $commandArray = array_merge(
            $serializedValues,
            ['-new' => null]
        );
        $this->simpleFMAdapter
            ->setCommandArray($commandArray)
            ->setLayoutName($this->getEntityLayout());
        /** @var FmResultSet $result */
        $result = $this->handleAdapterResult($this->simpleFMAdapter->execute());
        $entity = $this->rowToEntity($result->getRows()[0]);
        return $entity;
    }

    /**
     * @param AbstractEntity $entity
     * @return AbstractEntity
     * @throws ErrorException
     * @throws FileMakerException
     * @throws HttpException
     * @throws XmlException
     */
    public function edit(AbstractEntity $entity)
    {
        $serializedValues = $entity->serialize();

        $commandArray = array_merge(
            $serializedValues,
            [
                '-edit' => null,
            ]
        );
        $this->simpleFMAdapter
            ->setCommandArray($commandArray)
            ->setLayoutName($this->getEntityLayout());
        /** @var FmResultSet $result */
        $result = $this->handleAdapterResult($this->simpleFMAdapter->execute());
        $entity = $this->rowToEntity($result->getRows()[0]);
        return $entity;
    }

    /**
     * @param AbstractEntity $entity
     * @return bool
     * @throws ErrorException
     * @throws FileMakerException
     * @throws HttpException
     * @throws XmlException
     */
    public function delete(AbstractEntity $entity)
    {
        $commandArray = [
            '-recid' => $entity->getRecid(),
            '-modid' => $entity->getModid(),
            '-delete' => null,
        ];
        $this->simpleFMAdapter
            ->setCommandArray($commandArray)
            ->setLayoutName($this->getEntityLayout());
        $result = $this->handleAdapterResult($this->simpleFMAdapter->execute());
        return true;
    }


    /**
     * @return SimpleFMAdapter
     */
    public function getSimpleFMAdapter()
    {
        return $this->simpleFMAdapter;
    }

    /**
     * @param SimpleFMAdapter $simpleFMAdapter
     * @return $this
     */
    public function setSimpleFMAdapter(SimpleFMAdapter $simpleFMAdapter)
    {
        $this->simpleFMAdapter = $simpleFMAdapter;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntityLayout()
    {
        return $this->entityLayout;
    }

    /**
     * @param string $entityLayout
     * @return $this
     */
    public function setEntityLayout($entityLayout)
    {
        $this->entityLayout = $entityLayout;
        return $this;
    }

    /**
     * Example return: Application\Entity\Entity
     *
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * @param string $entityName
     * @return $this
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
        return $this;
    }

    /**
     * @param int|null $max
     * @param int|null $skip
     * @return array
     */
    protected function maxSkipToCommandArray($max = null, $skip = null)
    {

        $maxCommand = empty($max) ? [] : ['-max' => $max];
        $skipCommand = empty($skip) ? [] : ['-skip' => $skip];

        return array_merge($maxCommand, $skipCommand);
    }

    /**
     * @param array $sort
     * @return array
     */
    protected function sortArrayToCommandArray(array $sort)
    {

        // -sortfield.[1-9] = fully-qualified-field-name
        // -sortorder.[1-9] = [ascend|descend|value-list-name]

        if (empty($sort)) {
            return [];
        }

        $i = 1;
        $command = [];
        foreach ($sort as $field => $method) {
            if ($i > 9) {
                break;
            } // FileMaker API limited to max 9 fields

            switch ((string) $method) {
                case 'dsc':
                    $sortMethod = 'descend';
                    break;
                case 'desc':
                    $sortMethod = 'descend';
                    break;
                case 'descend':
                    $sortMethod = 'descend';
                    break;
                case 'asc':
                    $sortMethod = 'ascend';
                    break;
                case 'ascend':
                    $sortMethod = 'ascend';
                    break;
                case '':
                    $sortMethod = 'ascend';
                    break;
                default:
                    $sortMethod = $method;
                    break;
            }

            $command['-sortfield.' . $i] = $field;
            $command['-sortorder.' . $i] = $sortMethod;
            $i++;
        }

        return $command;

    }

    /**
     * @param array $rows
     * @return ArrayCollection
     */
    protected function rowsToArrayCollection(array $rows)
    {
        $collection = new ArrayCollection();
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $collection->add($this->rowToEntity($row));
            }
        }

        return $collection;
    }

    /**
     * @param array $simpleFMAdapterResult
     * @return array
     * @throws ErrorException
     * @throws FileMakerException
     * @throws HttpException
     * @throws XmlException
     */
    public function handleAdapterResult(AbstractResult $simpleFMAdapterResult)
    {
        $message = $simpleFMAdapterResult->getErrorType() . ' Error ' . $simpleFMAdapterResult->getErrorCode() . ': ' .
            $simpleFMAdapterResult->getErrorMessage() . '. ' . $simpleFMAdapterResult->getDebugUrl();

        if ($simpleFMAdapterResult->getErrorCode() === 0) {
            return $simpleFMAdapterResult;
        } elseif ($simpleFMAdapterResult->getErrorType() == 'FileMaker' && $simpleFMAdapterResult->getErrorCode() === 401) {
            //Don't throw an error for a FileMaker 401: "No records match the request"
            return $simpleFMAdapterResult;
        } elseif ($simpleFMAdapterResult->getErrorType() == 'FileMaker') {
            throw new FileMakerException($message, $simpleFMAdapterResult->getErrorCode());
        } elseif ($simpleFMAdapterResult->getErrorType() == 'HTTP') {
            throw new HttpException($message, $simpleFMAdapterResult->getErrorCode());
        } elseif ($simpleFMAdapterResult->getErrorType() == 'XML') {
            throw new XmlException($message, $simpleFMAdapterResult->getErrorCode());
        } else {
            throw new ErrorException($message, $simpleFMAdapterResult->getErrorCode());
        }
    }

    /**
     * @param $row
     * @return AbstractEntity
     * @codeCoverageIgnore
     */
    protected function rowToEntity($row)
    {
        return new $this->entityName($row);
    }
}
