<?php
namespace Lrotherfield\Component\Form\DataTransformer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class EntityToIntTransformer
 *
 * Transform an entity to  and from it's 'id' field
 *
 * @package Lrotherfield\Bundle\TestBundle\Form\DataTransformer
 * @author Luke Rotherfield <luke@lrotherfield.com>
 */
class EntityToIdentifierTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    private $entityRepository;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * If the passed argument is a valid entity return the id, else return empty string
     * @param mixed $entity
     * @return integer|string
     */
    public function transform($entity)
    {
        if (is_null($entity) || !is_object($entity) || !method_exists($entity, 'getId')) {
            return '';
        }

        return $entity->getId();
    }

    /**
     * Attempt to retrieve the entity from the database using the passed argument
     * as the id field
     * @param integer $id
     * @throws TransformationFailedException
     * @return object
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $entity = $this->em->getRepository($this->entityRepository)->find($id);

        if (null === $entity) {
            throw new TransformationFailedException(sprintf(
                'An entity with id "%s" does not exist!',
                $id
            ));
        }

        return $entity;
    }

    /**
     * Set the repository in shorthand or FQN string
     * @param string $entityRepository
     */
    public function setEntityRepository($entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

}
