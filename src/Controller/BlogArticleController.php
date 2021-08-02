<?php

namespace App\Controller;

use App\Entity\BlogArticle;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\Workflow;

class BlogArticleController extends AbstractController
{
    private Registry $workflowRegistry;
    private Workflow $articleWorkflow;
    private EntityManagerInterface $entityManager;

    public function __construct(Registry $workflowRegistry, EntityManagerInterface $entityManager)
    {
        $this->workflowRegistry = $workflowRegistry;
        $this->articleWorkflow  = $this->workflowRegistry->get(new BlogArticle());
        $this->entityManager    = $entityManager;
    }

    /**
     * @Route("/article", name="app_article")
     */
    public function article(): Response
    {
        $article = (new BlogArticle())->setTitle(sprintf('This is Article Title %s', rand(1000000, 9999999)));
        $this->entityManager->persist($article);
        $this->entityManager->flush();

        $this->articleWorkflow = $this->workflowRegistry->get(new BlogArticle());

        try {
            $this->articleWorkflow->apply($article, 'init');
            $this->articleWorkflow->apply($article, 'to_review');
            $this->articleWorkflow->apply($article, 'publish');
        } catch (LogicException $exception) {
            return new Response(
                sprintf(
                    '<html><body>Exception %s</body></html>',
                    $exception->getMessage()
                )
            );
        }

        return new Response(
            sprintf(
                '<html><body>Article #%s successfully passed add transitions</body></html>',
                $article->getId()
            )
        );
    }
}
