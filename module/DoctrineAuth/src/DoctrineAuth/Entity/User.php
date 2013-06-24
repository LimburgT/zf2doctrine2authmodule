<?php
namespace DoctrineAuth\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
  @ORM\Entity
  @ORM\Table(name="user")
 */
class User
{
    /**
     *  @ORM\Id
     *  @ORM\Column(type="integer", name="id")
     *  @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *  @ORM\Column(type="string", name="Email", length=100, unique=true)
     */
    protected $email;

    /**
     *  @ORM\Column(type="string", name="Password", length=100)
     */
    protected $password;
    
    /**
     *  @ORM\Column(type="string", name="Salt", length=100)
     */
    protected $salt;

    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getUseremail()
    {
        return $this->useremail;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }
    
    public function setSalt($salt)
    {
        $this->salt = $password;
    }

    public function getSalt()
    {
        return $this->salt;
    }
}