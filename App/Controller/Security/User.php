<?php
namespace App\Controller\Security;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class User implements AdvancedUserInterface {

  private $id;
  private $username;
  private $password;
  private $email;
  private $role;
  private $creation_date;

  public function __construct(
    $id,
    $username,
    $password,
    $email,
    $role,
    $creation_date
    )
  {
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
    $this->email = $email;
    $this->role = $role;
    $this->creation_date = $creation_date;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getSalt()
  {
    return $this->username;
  }

  public function getCreationDate()
  {
    return $this->creation_date;
  }

  public function getRoles()
  {
    return array($this->role);
  }

  public function eraseCredentials()
  {

  }
  
  public function isAccountNonExpired()
  {
    return true;
  }

  public function isAccountNonLocked()
  {
    return true;
  }

  public function isCredentialsNonExpired()
  {
    return true;
  }

  public function isEnabled()
  {
    return true;
  }


}