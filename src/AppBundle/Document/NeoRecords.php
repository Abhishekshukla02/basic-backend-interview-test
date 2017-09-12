<?php 

namespace AppBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ORM\Mapping as ORM;

/**
 * @MongoDB\Document(repositoryClass="AppBundle\Repository\NeoRecordsRepository")
 */
class NeoRecords
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(name="date", type="date")
     */
    protected $date;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $reference;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $speed;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $isHazardous;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return string $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return self
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * Get reference
     *
     * @return string $reference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set speed
     *
     * @param string $speed
     * @return self
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;
        return $this;
    }

    /**
     * Get speed
     *
     * @return string $speed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set isHazardous
     *
     * @param string $isHazardous
     * @return self
     */
    public function setIsHazardous($isHazardous)
    {
        $this->isHazardous = $isHazardous;
        return $this;
    }

    /**
     * Get isHazardous
     *
     * @return string $isHazardous
     */
    public function getIsHazardous()
    {
        return $this->isHazardous;
    }
}
