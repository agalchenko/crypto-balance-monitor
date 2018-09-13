<?php

namespace App\Controller;

use Sonata\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ConfirmRegistrationController extends Controller
{
    public function confirmedAction(Request $request)
    {
        $user = $this->getUser();

        // TODO: probably we should add some logic

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $url = $this->generateUrl('sonata_admin_dashboard');

        return new RedirectResponse($url);
    }
}
