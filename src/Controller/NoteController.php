<?php

declare(strict_types=1);

namespace App\Controller;

// require_once("AbstractController.php");

use App\Exception\NotFoundException;

class NoteController extends AbstractController
{

  private const PAGE_SIZE = 10;
  public function createAction()
  {
    if ($this->request->hasPost()) {
      $noteData = [
        'title' => $this->request->postParam('title'),
        'description' => $this->request->postParam('description')
      ];
      $this->database->createNote($noteData);
      header('Location: /?before=created');
      exit;
    }

    $this->view->render('create');
  }

  public function showAction(){

    $this->view->render(
      'show',
      ['note' => $this->getNote()]
    );
  }

  public function listAction()
  {
    $pageNumber = (int) $this->request->getParam('page', 1);
    $pageSize = (int) $this->request->getParam('pagesize', self::PAGE_SIZE);
    
    $sortBy = $this->request->getParam('sortby', 'created');
    $sortOrder = $this->request->getParam('sortorder', 'asc');
    
    if (!in_array($pageSize, [1, 5, 10, 25])){
      $pagesize = self::PAGE_SIZE;
    }

    $note = $this->database->getNotes($pageNumber, $pageSize, $sortBy, $sortOrder);

    $notes = $this->database->getCount();
    // dump($notes);
    $this->view->render(
      'list',
      [
        'page' => ['number' => $pageNumber, 'size' => $pageSize, 'page' => (int)ceil($notes / $pageSize)],
        'sort' => ['by' => $sortBy, 'order' => $sortOrder,
        ],
        'notes' => $note,
        'before' => $this->request->getParam('before'),
        'error' => $this->request->getParam('error')
      ]
    );
  }

  public function editAction(){

    if ($this->request->isPost()){
      $noteId = (int) $this->request->postParam('id');

      $noteData = [
        'title' => $this->request->postParam('title'),
        'description' => $this->request->postParam('description')
      ];
      $this->database->editNote($noteId, $noteData);
      $this->redirect('/', ['before' => 'edited']);



      // dump($noteId);

      exit('jestesmy w post');
    }

    
    $this->view->render(
      'edit',
      ['note' => $this->getNote()]
    );
  }

  public function deleteAction(): void {


    if ($this->request->isPost()){
      $id = (int) $this->request->postParam('id');
      $this->database->deleteNote($id);
      $this->redirect('/', ['before' => 'deleted']);
      exit('delete');
    }

    $this->view->render(
      'delete',
      ['note' => $this->getNote()]
    );

    // dump($note);
  }

  private function getNote(): array{
    $noteId = (int) $this->request->getParam('id');
    if (!$noteId){
      $this->redirect('/', ['error' => 'missingNoteId']);
    }
    try {
      $note = $this->database->getNote($noteId);
    } catch (NotFoundException $e) {
      header('Location: /?error=noteNotFound');
      exit;
    }
    return $note;
  }
}
