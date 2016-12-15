<?php

namespace M2I\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use M2I\BlogBundle\Entity\Article;

use Symfony\Component\Form\Extension\Core\Type\FormType; // Appel la Création de Formulaire
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;



class IndexController extends Controller
{

    /* public function testAction()
    {
        // Creation de notre Entiry Article
        $newArticle = new Article();
        $newArticle->setTitle('titre creation');
        $newArticle->setDescription('description creation');

        // Récuperation de notre Entity Manager
        $em = $this->container->get('doctrine.orm.entity_manager');

        // Récuperation du Repository de Article
        $articleRepository = $em->getRepository('M2IBlogBundle:Article');
        $toUpdateArticle = $articleRepository->findOneById(1);

        // Modif de l'Article avec l'ID 1
        $toUpdateArticle->setTitle('new title');

        // On Persist l'Entity Article
        // Modification ou Création
        // Persist
        $em->persist($newArticle);
        $em->flush();  // Flush exectute les requêtes

        return new Response('<html><body></body></html>'); // Pour afficher le Profiler
    }*/

    public function indexAction()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');               // Entity Manager : Sert à aller chercher le Repo de Entity Manager
        $articleRepository = $em->getRepository('M2IBlogBundle:Article');         // Va chercher le Repo de notre Class Article
        //$doctrine = $this->container->get('doctrine');
        //$em = $doctrine->getManager();
        $articleList = $articleRepository->findAll();                             // Hydrate les Objets de Article
        /********************* Version BeauGosse *************************
        / $em = $this->getDoctrine()->getManager();
        / $articleRepository = $em-getRepository('M2IBlogBundle:Article');
        / dump($articleRepository->findAll());
        ******************************************************************/

        /*********************** DUMP pour Détails ***********************
        // Tous les Articles
        $articleList = $articleRepository->findAll();

        // Get Article ID = 2
        $article2 = $articleRepository->find(2);
        $article2 = $articleRepository->findById(2);
        $article2 = $articleRepository->findOneById(2);

        // Get Article avec Title = 'Article 3'
        $article3 = $articleRepository->findByTitle('Troisième Article');
        $article3 = $articleRepository->findOneByTitle('Troisième Article');

        dump($article2);
        dump($article3);
        die();
        ******************************************************************/

        $articleList = $articleRepository->findAll();

        return $this->render('M2IBlogBundle:Index:index.html.twig', array('articleList' => $articleList));

    }

    public function contactAction()
    {
        return $this->render('M2IBlogBundle:Index:contact.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('M2IBlogBundle:Index:about.html.twig');
    }

    public function detailAction($idArticle)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');               // Entity Manager : Sert à aller chercher le Repo de Entity Manager
        $articleRepository = $em->getRepository('M2IBlogBundle:Article');         // Va chercher le Repo de notre Class Article

        $article = $articleRepository->findOneById($idArticle);

        return $this->render('M2IBlogBundle:Index:detail.html.twig', array('article' => $article));
    }



    public function addAction(Request $request)
    {
        $article = new Article();
        $article->setTitle('Titre');

        $formBuilder = $this
                ->container
                ->get('form.factory')
                ->createBuilder(FormType::class, $article);

        $formBuilder
                ->add('title',         TextType::class,        ['label' => 'Titre'])
                ->add('description',   TextareaType::class,    ['label' => 'Contenu de l\'Article'])
                ->add('createDate',    DateTimeType::class,    ['label' => 'Date et Heure de Création'])
                ->add('save',          SubmitType::class,      ['label' => 'Publier'])
                ->getForm()
                ;

        $form = $formBuilder->getForm();

        // Si la requête est en POST
        if ($request->isMethod('POST'))
        {
            // On fait le lien Requête <-> Formulaire
            // A partir de maintenant, la variable $article contient les valeurs entrées dans le Formulaire
            $form->handleRequest($request);

            // On vérifie que les valeurs entrées sont correctes
            if ($form->isValid())
            {
                $em = $this->container->get('doctrine.orm.entity_manager'); // Connexion à la BDD via l'Entity Manager
                $em->persist($article);                                     // Remplit $article
                $em->flush();                                               // Commit à la BDD

                return $this->redirectToRoute('m2_i_blog_add_article');     // Efface le formulaire une fois validé
            }
        }

        return $this->render('M2IBlogBundle:Index:add_article.html.twig', array('myForm' => $form->createView()));
    }

    public function editArticleAction(Request $request, $idArticle) // Le REQUEST permet de vérifier qu'il y a bien des données en POST, et passe les données du Formulaire à notre Entity
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $articleRepository = $em->getRepository('M2IBlogBundle:Article');

        $article = $articleRepository->findOneById($idArticle);

        $formBuilder = $this
                ->container
                ->get('form.factory')
                ->createBuilder(FormType::class, $article);

        $formBuilder
                ->add('title',         TextType::class,        ['label' => 'Titre'])
                ->add('description',   TextareaType::class,    ['label' => 'Contenu de l\'Article'])
                ->add('createDate',    DateTimeType::class,    ['label' => 'Date et Heure de Création'])
                ->add('save',          SubmitType::class,      ['label' => 'Publier'])
                ->getForm()
                ;

        $form = $formBuilder->getForm();

        if ($request->isMethod('POST'))
        {
            // On fait le lien Requête <-> Formulaire
            // A partir de maintenant, la variable $article contient les valeurs entrées dans le Formulaire
            $form->handleRequest($request);

            // On vérifie que les valeurs entrées sont correctes
            if ($form->isValid())
            {
                $em = $this->container->get('doctrine.orm.entity_manager'); // Connexion à la BDD via l'Entity Manager
                $em->persist($article);                                     // Remplit $article
                $em->flush();                                               // Commit à la BDD

                return $this->redirectToRoute('m2_i_blog_edit_article', ['idArticle' => $idArticle]);     // Met à jour le formulaire une fois validé
            }
        }

        return $this->render('M2IBlogBundle:Index:edit_article.html.twig', array('myForm' => $form->createView()));
    }
}
