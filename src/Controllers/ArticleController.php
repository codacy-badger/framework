<?php

namespace App\Controllers;

use Core\Model\ModelFactory;

class ArticleController extends Controller
{
    public $errors;

    public function add()
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['addArticle'])) {
                if (!empty($_POST['titleArticle']) || !empty($_POST['contentArticle'])) {
                    $data = [
                        'title' => $_POST['titleArticle'],
                        'content' => $_POST['contentArticle'],
                        'id_user' => $_SESSION['user']['id'],
                        'date_add' => date('Y-m-d H:i:s')
                    ];

                    if (ModelFactory::get('Article')->create($data)) {
                        header('Location: /user/'.$_SESSION['user']['id']);
                    } else{
                        $this->errors[] = 'Erreur lors de l\'enregistrement';
                    }
                } else {
                    $this->errors[] = 'Veuillez remplir tous les champs';
                }
            }

            echo $this->twig->render('article/add.html.twig', ['errors' => $this->errors]);
        } else {
            header('Location: /');
        }
    }

    public function deleteArticle($id)
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['deleteArticle'])) {
                ModelFactory::get('Article')->delete($id);
                header('Location: /user/article');
            }
            echo $this->twig->render('article/delete.html.twig', ['article_id' => $id]);
        } else {
            header('Location: /');
        }
    }

    public function articlesByUser()
    {
        if (isset($_SESSION['user'])) {
            $articles = ModelFactory::get('Article')->list($_SESSION['user']['id'], 'id_user');
            echo $this->twig->render('user/articles.html.twig', ['articles' => $articles]);
        } else {
            header('Location: /');
        }
    }

    public function editArticle($id)
    {
        if (isset($_SESSION['user'])) {
            $article = ModelFactory::get('Article')->getArticleByIdUser($id, $_SESSION['user']['id']);
            echo $this->twig->render('article/edit.html.twig', ['article' => $article]);
        } else {
            header('Location: /');
        }
    }
}