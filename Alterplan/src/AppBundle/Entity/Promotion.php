<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table(name="Promotion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromotionRepository")
 */
class Promotion
{
    /**
     * @var string
     *
     * @ORM\Column(name="CodePromotion", type="string", length=8)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codePromotion;

    /**
     * @var string
     *
     * @ORM\Column(name="Libelle", type="string", length=200, nullable=false)
     */
    private $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Debut", type="datetime", nullable=false)
     */
    private $debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fin", type="datetime", nullable=false)
     */
    private $fin;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixPublicAffecte", type="float", precision=53, scale=0, nullable=false)
     */
    private $prixPublicAffecte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixPECAffecte", type="float", precision=53, scale=0, nullable=false)
     */
    private $prixPecAffecte;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixFinanceAffecte", type="float", precision=53, scale=0, nullable=false)
     */
    private $prixFinanceAffecte;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeContactENI", type="integer", nullable=true)
     */
    private $codeContactEni;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeLieu", type="integer", nullable=true)
     */
    private $codeLieu;

    /**
     * @var \AppBundle\Entity\Formation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeFormation", referencedColumnName="CodeFormation")
     * })
     */
    private $formation;

    /**
     * @var bool
     * @ORM\Column(name="IsActive", type="boolean", nullable=false)
     */
    private $isActive = true;

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return Promotion
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodePromotion()
    {
        return $this->codePromotion;
    }

    /**
     * @param string $codePromotion
     * @return Promotion
     */
    public function setCodePromotion($codePromotion)
    {
        $this->codePromotion = $codePromotion;
        return $this;
    }

    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     * @return Promotion
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * @param \DateTime $debut
     * @return Promotion
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * @param \DateTime $fin
     * @return Promotion
     */
    public function setFin($fin)
    {
        $this->fin = $fin;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrixPublicAffecte()
    {
        return $this->prixPublicAffecte;
    }

    /**
     * @param float $prixPublicAffecte
     * @return Promotion
     */
    public function setPrixPublicAffecte($prixPublicAffecte)
    {
        $this->prixPublicAffecte = $prixPublicAffecte;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     * @return Promotion
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrixPecAffecte()
    {
        return $this->prixPecAffecte;
    }

    /**
     * @param float $prixPecAffecte
     * @return Promotion
     */
    public function setPrixPecAffecte($prixPecAffecte)
    {
        $this->prixPecAffecte = $prixPecAffecte;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrixFinanceAffecte()
    {
        return $this->prixFinanceAffecte;
    }

    /**
     * @param float $prixFinanceAffecte
     * @return Promotion
     */
    public function setPrixFinanceAffecte($prixFinanceAffecte)
    {
        $this->prixFinanceAffecte = $prixFinanceAffecte;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeContactEni()
    {
        return $this->codeContactEni;
    }

    /**
     * @param int $codeContactEni
     * @return Promotion
     */
    public function setCodeContactEni($codeContactEni)
    {
        $this->codeContactEni = $codeContactEni;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeLieu()
    {
        return $this->codeLieu;
    }

    /**
     * @param int $codeLieu
     * @return Promotion
     */
    public function setCodeLieu($codeLieu)
    {
        $this->codeLieu = $codeLieu;
        return $this;
    }

    /**
     * @return Formation
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * @param Formation $formation
     * @return Promotion
     */
    public function setFormation($formation)
    {
        $this->formation = $formation;
        return $this;
    }

}

