<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     *
     * @param TaskRepository $taskRepository
     * @return Response
     */
    public function listAction(TaskRepository $taskRepository): Response
    {
        return $this->render('task/list.html.twig', ['tasks' => $taskRepository->findBy(['isDone' => false])]);
    }

    /**
     * @Route("/tasks/done", name="task_list_done")
     *
     * @param TaskRepository $taskRepository
     * @return Response
     */
    public function listDone(TaskRepository $taskRepository): Response
    {
        return $this->render('task/isDone.html.twig', ['tasks' => $taskRepository->findBy(['isDone' => true])]);
    }


    /**
     * @Route("/tasks/create", name="task_create")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function createAction(Request $request, EntityManagerInterface $manager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($this->getUser());
            $manager->persist($task);
            $manager->flush();

            $this->addFlash('success', 'Task was successfully added.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     *
     * @param Task $task
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function editAction(Task $task, Request $request, EntityManagerInterface $manager): Response
    {

        $this->denyAccessUnlessGranted('TASK_EDIT', $task);
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'The task has been modified.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     *
     * @param Task $task
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function toggleAction(Task $task, EntityManagerInterface $manager): RedirectResponse
    {
        $this->denyAccessUnlessGranted('TASK_EDIT', $task);

        $task->setIsDone(!$task->getIsDone());
        $manager->flush();

        $this->addFlash('success', sprintf('The %s task was well marked as done.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }


    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     *
     * @param Task $task
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function deleteAction(Task $task, EntityManagerInterface $manager): RedirectResponse
    {
        $this->denyAccessUnlessGranted('TASK_DELETE', $task);
        $manager->remove($task);
        $manager->flush();
        $this->addFlash('success', 'The task has been removed.');
            return $this->redirectToRoute('task_list');
    }
}
