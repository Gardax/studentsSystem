<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 3/15/16
 * Time: 12:06 AM
 */

namespace ExportBundle\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\ORM\EntityManager;

class ExportController extends Controller
{

    /**
     * @Route("/csv/users")
     */
    public function userCSVAction()
    {
        $service = $this->get('user_service');

        $users = $service->getUsers(0, 0, [], false, true);

        $response = new StreamedResponse();

        $response->setCallback(
            function () use ($users) {

                $handle = fopen('php://output', 'r+');

                $data = array(
                    'id',
                    'username',
                    'email'
                );
                fputcsv($handle, $data, ';');

                foreach ($users as $user) {
                    $data = array(
                        $user->getId(),
                        $user->getUsername(),
                        $user->getEmail()
                    );
                    fputcsv($handle, $data, ';');
                }
                fclose($handle);
            }
        );

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="users.csv"');

        return $response;
    }
}