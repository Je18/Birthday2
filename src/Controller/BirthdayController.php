<?php

namespace App\Controller;

use App\Entity\Birthday;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BirthdayRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

/**
 * @Route("/api")
 */
class BirthdayController extends AbstractController
{
    /**
     * @Route("/birthday", name="app_birthday", methods = {"GET"})
     */
    public function getBirthday(BirthdayRepository $birthdayRepository, SerializerInterface $serializer): JsonResponse
    {
        $birthday = $birthdayRepository->findAll();
        $jsonBirthList = $serializer->serialize($birthday, 'json');
        return new JsonResponse($jsonBirthList, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/birthday/{id}", name="app_birthday_details", methods = {"GET"})
     */
    public function getBirthdayOne(int $id, BirthdayRepository $birthdayRepository, SerializerInterface $serializer): JsonResponse
    {
        $birthday = $birthdayRepository->find($id);
        if ($birthday) {
            $jsonBook = $serializer->serialize($birthday, 'json');
            return new JsonResponse($jsonBook, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/birthday", name="app_create_birthday", methods={"POST"})
     */
    public function createBirthday(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $birthday = new Birthday();
        $birthday->setName($data['name']);
        $birthday->setBirthday(new \DateTime($data['birthday'])); 

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($birthday);
        $entityManager->flush();

        $jsonBirthday = $serializer->serialize($birthday, 'json');

        return new JsonResponse($jsonBirthday, Response::HTTP_CREATED, [], true);
    }

    /**
     * @Route("/birthday/{id}", name="app_delete_birthday", methods={"DELETE"})
     */
    public function deleteBirthday(int $id, BirthdayRepository $birthdayRepository): JsonResponse
    {
        $birthday = $birthdayRepository->find($id);

        if (!$birthday) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($birthday);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/birthday/{id}", name="app_update_birthday", methods={"PATCH"})
     */
    public function updateBirthday(int $id, Request $request, BirthdayRepository $birthdayRepository): JsonResponse
    {
        $birthday = $birthdayRepository->find($id);

        if (!$birthday) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) {
            $birthday->setName($data['name']);
        }
        if (isset($data['date'])) {
            $birthday->setBirthday(new \DateTime($data['birthday']));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $response = new JsonResponse(null, Response::HTTP_NO_CONTENT);
        $response->headers->set('Location', $this->generateUrl('app_birthday_details', ['id' => $birthday->getId()]));

        return $response;
    }
}
