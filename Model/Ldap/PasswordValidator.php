<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   Magenerds
 * @package    Magenerds_Ldap
 * @copyright  Copyright (c) 2016 TechDivision GmbH (http://www.techdivision.com)
 * @version    ${release.version}
 * @link       http://www.techdivision.com/
 * @link       https://github.com/Magenerds/Ldap
 * @author     Julian Schlarb <j.schlarb@techdivision.com>
 */
namespace Magenerds\Ldap\Model\Ldap;


use Magento\Framework\Exception\LocalizedException;

/**
 * Class PasswordValidator
 * @package Magenerds\Ldap\Model\Ldap
 */
class PasswordValidator
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * LdapClient constructor.
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param $password
     * @param $hash
     * @return bool
     * @throws LocalizedException
     */
    public function validatePassword($password, $hash)
    {
        // empty password
        if (empty($hash)) {
            return $this->configuration->getAllowEmptyPassword() === '1';
        }

        // plaintext password
        if ($hash{0} != '{') {
            return $password === $hash;
        }

        if (strpos($hash, '{crypt}') === 0) {
            $encryptedPassword = '{crypt}' . crypt($password, substr($hash, 7));
        } elseif (strpos($hash, '{MD5}') === 0) {
            $encryptedPassword = '{MD5}' . base64_encode(md5($password, true));
        } elseif (strpos($hash, '{SHA}') === 0) {
            $encryptedPassword = "{SHA}" . base64_encode(sha1($password, true));
        } elseif (strpos($hash, '{SSHA}') === 0) {
            $salt = substr(base64_decode(substr($hash, 6)), 20);
            $encryptedPassword = '{SSHA}' . base64_encode(sha1($password . $salt, true) . $salt);
        } else {
            throw new LocalizedException(__('Unsupported password hash format'));
        }

        return $hash === $encryptedPassword;
    }

    /**
     * @return bool
     */
    public function isPasswordCachedAllowed()
    {
        return $this->configuration->getCachePassword();
    }
}
