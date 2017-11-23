<?php

namespace VoitureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Modele
 *
 * @ORM\Table(name="modele")
 * @ORM\Entity(repositoryClass="VoitureBundle\Repository\ModeleRepository")
 */
class Modele
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    
    /**
     * 
     *  @ORM\ManyToOne(targetEntity="Marque")
     *  @ORM\JoinColumn(nullable=false)
     */
    private $marque ;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Modele
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set marque
     *
     * @param \VoitureBundle\Entity\Marque $marque
     *
     * @return Modele
     */
    public function setMarque(\VoitureBundle\Entity\Marque $marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return \VoitureBundle\Entity\Marque
     */
    public function getMarque()
    {
        return $this->marque;
    }
    public function __toString(){
        return $this->nom;
    }
}
