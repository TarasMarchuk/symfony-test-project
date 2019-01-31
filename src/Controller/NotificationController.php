<?php
/**
 * Created by PhpStorm.
 * User: taras
 * Date: 25.01.19
 * Time: 19:20
 */

namespace App\Controller;


use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NotificationController
 * @package App\Controller
 * @Security("is_granted('ROLE_USER')")
 * @Route("/notification")
 */
class NotificationController extends AbstractController
{
    /**
     * @var NotificationRepository
     */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @Route("/unread-count", name="notification_unread")
     */
    public function unreadCount()
    {
        return new JsonResponse([
            'count' => $this->notificationRepository->findUnseenByUser($this->getUser())
            ]
        );
    }

    /**
     * @Route("/all", name="notification_all")
     */
    public function notifications()
    {
        return $this->render(
            'notification/notifications.html.twig', [
                'notifications' => $this->notificationRepository->findBy([
                    'seen' => false,
                    'user' => $this->getUser()
                ])
            ]
        );
    }

    /**
     * @Route("/aknowledge/{id}", name="notification_aknowledge")
     */
    public function aknowledge(Notification $notification)
    {
        $notification->setSeen(true);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('notification_all');
    }

    /**
     * @Route("aknowledge-all", name="notification_aknowledge_all")
     */
    public function aknowledgeAll()
    {
        $this->notificationRepository->markAllAsReadUser($this->getUser());
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('notification_all');
    }
}