<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    public $firstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public $ref;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public $referralOf;

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param mixed $ref
     */
    public function setRef($ref): void
    {
        $this->ref = $ref;
    }

    /**
     * @return mixed
     */
    public function getReferralOf()
    {
        return $this->referralOf;
    }

    /**
     * @param mixed $refferalOf
     */
    public function setReferralOf($referralOf): void
    {
        $this->referralOf = $referralOf;
    }

    /**
     * @return string of generated code
     */
    public function generateNewReferralCode($allReferralCodes)
    {
        $refArr = array();
        foreach ($allReferralCodes as $refCodes) {
            array_push($refArr, $refCodes['ref']);
        }

        $newReferralCode = $this->difCode($refArr);
        return $newReferralCode;
    }

    /**
     * @return string of random code
     */
    protected function createCode(){
        $code = "";
        for($i = 0; $i < 6; $i++){
            $code.= (string)rand(0, 9);
        }
        return $code;
    }

    /**
     * @return string of new code if doesn't exist
     */
    protected function difCode($refArr){
        $newCode = $this->createCode();
        if (in_array($newCode, $refArr)) {
            $this->difCode($refArr);
        }
        else{
            return $newCode;
        }
    }
}
