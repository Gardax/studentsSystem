<?php
/**
 * Created by PhpStorm.
 * User: gardax
 * Date: 2/3/16
 * Time: 8:18 PM
 */

namespace AppBundle\Security;


use AppBundle\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

/**
 * Class ApiKeyAuthenticator
 * @package AppBundle\Security
 */
class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface
{
    public function createToken(Request $request, $providerKey)
    {
         $apiKey = $request->headers->get('apiKey');

        if(!$apiKey) {
            //throw new BadCredentialsException('No API key found');

            // or to just skip api key authentication
            return null;
        }

        return new PreAuthenticatedToken(
            'anon.',
            $apiKey,
            $providerKey
        );
    }

    /**
     * @param TokenInterface $token
     * @param UserProviderInterface $userService
     * @param $providerKey
     * @return PreAuthenticatedToken
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userService, $providerKey)
    {
        if(!$userService instanceof UserService) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of UserService (%s was given).',
                    get_class($userService)
                )
            );
        }

        $apiKey = $token->getCredentials();
        $username = $userService->getUsernameForApiKey($apiKey);

        if(!$username) {
            // CAUTION: this message will be returned to the client
            // (so don't put any un-trusted messages / error strings here)
            throw new CustomUserMessageAuthenticationException(
                sprintf('API Key "%s" does not exist.', $apiKey)
            );
        }

        $user = $userService->loadUserByUsername($username);

        return new PreAuthenticatedToken(
            $user,
            $apiKey,
            $providerKey,
            $user->getRoles()->toArray()
        );
    }

    /**
     * @param TokenInterface $token
     * @param $providerKey
     * @return bool
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }
}