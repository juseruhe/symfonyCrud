<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class UsersController extends AbstractController
{
  
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(Users::class)->findAll();

        return $this->render('base.html.twig',['users' => $users]);
    }

    public function create(){
        return $this->render('users/users.html.twig',[]);
    }

    public function store(Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = new Users();

        $user->setFirstname($request->request->get('firstname'));
        $user->setLastname($request->request->get('lastname'));
        $user->setEmail($request->request->get('email'));

         $em->persist($user);
         $em->flush();

      return $this->redirectToRoute('index');

    }

    public function delete($id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Users::class)->find($id);

       $em->remove($user);
       $em->flush();

       return $this->redirectToRoute('index');

    }

    public function show($id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Users::class)->find($id);

        return $this->render('users/show.html.twig',['user' => $user]);
    }

    public function edit($id){
       $em = $this->getDoctrine()->getManager();
       $user = $em->getRepository(Users::class)->find($id);
      
       return $this->render('users/edit.html.twig',['user' => $user]);
    }

    public function update(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        
        $user = $em->getRepository(Users::class)->find($id);

        $user->setFirstname($request->request->get('firstname'));
        $user->setLastname($request->request->get('lastname'));
        $user->setEmail($request->request->get('email'));

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('show',["id" => $user->getId()]);
    }


}
