<?php 
namespace App\Controller\Security;
 
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\DBAL\Connection;
 
class UserProvider implements UserProviderInterface
{
    private $dbConn;
 
    public function __construct($dbConn)
    {
        $this->dbConn = $dbConn;
    }
 
    public function loadUserByUsername($username)
    {
        $user_record = $this->dbConn->fetchAssoc('
            SELECT id, username, password, email, role, creation_date
            FROM user WHERE username like ?',
            array($username)
            );

        if (!$user_record)
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
 
        return new User(
            $user_record['id'],
            $user_record['username'],
            $user_record['password'],
            $user_record['email'],
            $user_record['role'],
            $user_record['creation_date']
            );
    }
 
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
 
        return $this->loadUserByUsername($user->getUsername());
    }
 
    public function supportsClass($class)
    {
        return $class === 'App\Controller\Security\User';
    }
}